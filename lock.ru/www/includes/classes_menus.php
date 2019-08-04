<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ( );
}

class MENUS {

      # Массив с данными для генерации левого меню (навигации)
      var $menu_left    = array (
                                 "razdel" => array ( ),
                                 "kategoria" => array ( )
                                );
      # Массив с данными для генерации левого меню ("друзья")
      var $menu_friends = array ( "friend" => array ( ) );
      # Массив с данными для замены по шаблону
      var $replace      = array (
                                 "left_menu_razdel_string" => array ( ),
                                 "left_menu_kategoria_string" => array ( ),
                                 "web_tools_razdel_string" => array ( ),
                                 "friends_menu_razdel_string" => array ( ),
                                 "members_menu_string" => array ( )
                                );

      # Функция поиска шаболнов для дальнейшего использования онных в скрипте
      function find_templates ( ) {

               global $structure, $template;
               
               # Все совпадения с шаблоном будут находиться в массиве $replace
               preg_match ( "/". $structure["left_menu"]["razdel"]["str_start"]    ."(.*)". $structure["left_menu"]["razdel"]["str_end"]    ."/s", $template->index, $this->replace["left_menu_razdel_string"] );
               preg_match ( "/". $structure["left_menu"]["kategoria"]["str_start"] ."(.*)". $structure["left_menu"]["kategoria"]["str_end"] ."/s", $template->index, $this->replace["left_menu_kategoria_string"] );
               preg_match ( "/". $structure["friends_menu"]["razdel"]["str_start"] ."(.*)". $structure["friends_menu"]["razdel"]["str_end"] ."/s", $template->index, $this->replace["friends_menu_razdel_string"] );
               preg_match ( "/". $structure["members_menu"]["str_start"]           ."(.*)". $structure["members_menu"]["str_end"]           ."/s", $template->index, $this->replace["members_menu_string"] );
               
      }

      # Функция генерации данных для левого меню (навигация)
      # И занесения этих данных в $menu_left
      function generate_left_menu ( ) {

               global $sql;

               # Получаем все разделы
               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` ORDER BY `order` ASC";
               $r1 = $sql->query ( $query, "print_error_and_exit" );

               # Получаем все категории
               $query = "SELECT `id`, `razdel_id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` ORDER BY `order` ASC";
               $r2 = $sql->query ( $query, "print_error_and_exit" );

               # Заносим все данные о разделах в массив $menu_left
               if ( $r1 !== FALSE and mysql_num_rows ( $r1 ) !== 0 ) {
                  while ( $razdel = mysql_fetch_assoc ( $r1 ) ) :
                        $this->menu_left["razdel"][ $razdel["url"] ] = $razdel;
                  endwhile;
               }
               
               # Заносим все данные о категориях в массив $menu_left
               if ( $r2 !== FALSE and mysql_num_rows ( $r2 ) !== 0 ) {
                  while ( $kategoria = mysql_fetch_assoc ( $r2 ) ) :
                        $this->menu_left["kategoria"][ $kategoria["razdel_id"] ][ $kategoria["id"] ] = $kategoria;
                  endwhile;
               }
               
      }

      # Функция генерации данных для левого меню ("друзья")
      # И занесения этих данных в $menu_friends
      function generate_friends_menu ( ) {

               global $sql;
               
               # Получаем все записи
               $query = "SELECT `id`, `link`, `title`, `description` FROM `". SQL_TABLE_FRIENDS ."` ORDER BY `order` ASC";
               $data = $sql->query ( $query, "print_error_and_exit" );
               
               # Заносим все данные о записях в массив $menu_friends
               if ( $data !== FALSE and mysql_num_rows ( $data ) !== 0 ) {
                  while ( $friend = mysql_fetch_assoc ( $data ) ) :
                        $this->menu_friends["friend"][ $friend["id"] ] = $friend;
                  endwhile;
               }

      }

      # Функция генерации левого меню (навигации) используя
      # сгенерированные данные ($menu_left) и шаблоны ($replace)
      function show_left_menu ( ) {

               global $structure;

               $result = "";

               # Проверка на существование шаблона для генерации раздела
               if ( isset ( $this->replace["left_menu_razdel_string"][1] ) and !empty ( $this->replace["left_menu_razdel_string"][1] ) ) {

                  # Просматриваем массив данных (разделы)
                  foreach ( $this->menu_left["razdel"] as $razdel ) { # Генерируем данные о разделе!

                          # Если длинна названия болше чем ***, то будем выводить только до *** символов!
                          if ( strlen ( $razdel["title"] ) > INF_MENU_STR_LENGTH ) {
                             $razdel["title"] = substr ( $razdel["title"], 0, INF_MENU_STR_LENGTH ) ."...";
                          }

                          $l = $this->replace["left_menu_razdel_string"][1]; # шаблон, по которому генерируются разделы!
                          $l = str_replace ( $structure["left_menu"]["razdel"]["link"], "/". $razdel["url"] .".html", $l );
                          $l = str_replace ( $structure["left_menu"]["razdel"]["name"], $razdel["title"], $l );
                          $l = str_replace ( $structure["left_menu"]["razdel"]["title"], strip_tags ( $razdel["title"] ), $l );

                          # Если пользователь находится на страничке этого раздела, то выделяем раздел красным цветом.
                          if ( isset ( $_GET["input"]["razdel_url"] ) and (string) $_GET["input"]["razdel_url"] === (string) $razdel["url"] ) {
                             $l = str_replace ( $structure["left_menu"]["razdel"]["active_link"], "style=\"color:red\"", $l );
                          } else {
                             $l = str_replace ( $structure["left_menu"]["razdel"]["active_link"], "", $l );
                          }

                          $result .= $l."\n";

                          # Если у выбранного раздела есть категории, то покажем их
                          if ( isset ( $_GET["input"]["razdel_url"] ) and (string) $_GET["input"]["razdel_url"] === (string) $razdel["url"] and isset ( $this->menu_left["kategoria"][ $razdel["id"] ] ) ) {

                             # Проверка на существование шаблона для генерации категорий
                             if ( isset ( $this->replace["left_menu_kategoria_string"][1] ) and !empty ( $this->replace["left_menu_kategoria_string"][1] ) ) {
                             
                                $z = sizeof( $this->menu_left["kategoria"][ $razdel["id"] ] );
                                if ( $z > 0 ) {
                          
                                   # Просматриваем массив данных (категории)
                                   foreach ( $this->menu_left["kategoria"][ $razdel["id"] ] as $kategoria ) {

                                           # Если длинна названия болше чем ***, то будем выводить только до *** символов!
                                           if ( strlen ( $kategoria["title"] ) > INF_MENU_STR_LENGTH ) {
                                              $kategoria["title"] = substr ( $kategoria["title"], 0, INF_MENU_STR_LENGTH ) ."...";
                                           }

                                           $k = $this->replace["left_menu_kategoria_string"][1]; # Шаблон по которому будут строиться категории
                                           $k = str_replace ( $structure["left_menu"]["kategoria"]["link"], "/". $razdel["url"] ."/". $kategoria["url"] .".html", $k );
                                           $k = str_replace ( $structure["left_menu"]["kategoria"]["name"], $kategoria["title"], $k );
                                           $k = str_replace ( $structure["left_menu"]["kategoria"]["title"], strip_tags ( $kategoria["title"] ), $k );

                                           # Если пользователь находится на страничке данной категори, то выделяем категорию красным цветом.
                                           if ( isset( $_GET["input"]["kategoria_url"] ) and $_GET["input"]["kategoria_url"] == $kategoria["url"] ) {
                                              $k = str_replace ( $structure["left_menu"]["kategoria"]["active_link"], "style=\"color:red\"", $k );
                                           } else {
                                              $k = str_replace ( $structure["left_menu"]["kategoria"]["active_link"], "", $k );
                                           }

                                           $result .= $k."\n";
                                     
                                   }
                             
                                }
                                
                             }

                          }

                  }
                  
               }

               # Возвращаем сгенерированные данные
               return $result;
             
      }

      # Функция генерации левого меню ("друзья") используя
      # сгенерированные данные ($menu_friends) и шаблоны ($replace)
      function show_friends_menu ( ) {

               global $structure;

               $result = "";

               # Проверка на существование шаблона для генерации записей
               if ( isset ( $this->replace["friends_menu_razdel_string"][1] ) and !empty ( $this->replace["friends_menu_razdel_string"][1] ) ) {

                  # Просматриваем массив данных (записи)
                  foreach ( $this->menu_friends["friend"] as $friend ) { # Генерируем данные о записи!

                          # Если длинна названия болше чем ***, то будем выводить только до *** символов!
                          if ( strlen ( $friend["title"] ) > INF_MENU_STR_LENGTH ) {
                             $friend["title"] = substr ( $friend["title"], 0, INF_MENU_STR_LENGTH ) ."...";
                          }

                          $f = $this->replace["friends_menu_razdel_string"][1]; # шаблон, по которому генерируются разделы!
                          $f = str_replace ( $structure["friends_menu"]["razdel"]["link"], $friend["link"], $f );
                          $f = str_replace ( $structure["friends_menu"]["razdel"]["name"], $friend["title"], $f );
                          $f = str_replace ( $structure["friends_menu"]["razdel"]["title"], str_replace ( "\n", " ", $friend["description"] ), $f );
                          $result .= $f ."\n";

                  }
               
               }
               
               # Возвращаем сгенерированные данные
               return $result;
               
      }
      
      # Функция для генерации левого меню (разное)
      function show_misc_menu ( ) {
      
               $result = "
                          <center class=porr>Наш IRC канал :</center><br>
                          <center class=por>irc.nn.ru : 6667<br>#lock-team</center>
               ";

                  # Возвращаем сгенерированные данные
               return $result;
               
      }

      # Функция для генерации левого меню (члены комманды)
      function show_members_menu ( ) {

               global $sql, $structure;

               $result = "";

               # Получаем данные о всех членах комманды
               $query = "SELECT `id`, `nick`, `icq` FROM `". SQL_TABLE_MEMBERS ."` ORDER BY `order` ASC";
               $data = $sql->query ( $query, "print_error_and_exit" );
               
               # Проверяем полученны данные "на пригодность"
               if ( $data !== FALSE and mysql_num_rows ( $data ) !== 0 ) {

                  # Проверяем на существование шаблона для генерации элементов
                  if ( isset ( $this->replace["members_menu_string"][1] ) and !empty ( $this->replace["members_menu_string"][1] ) ) {
                  
                     while ( $member = mysql_fetch_assoc ( $data ) ) {

                           $icq1 = substr ( $member["icq"], 0, bcdiv ( strlen ( $member["icq"] ), 2 ) );
                           $icq2 = substr ( $member["icq"], bcdiv ( strlen ( $member["icq"] ), 2 ), 5 );
                     
                           $m = $this->replace["members_menu_string"][1];
                           $m = str_replace ( $structure["members_menu"]["full_icq_number"]        , $member["icq"], $m );
                           $m = str_replace ( $structure["members_menu"]["first_half_icq_number"]  , $icq1, $m );
                           $m = str_replace ( $structure["members_menu"]["second_half_icq_number"] , $icq2, $m );
                           $m = str_replace ( $structure["members_menu"]["link"]                   , "/team/members/". $member["id"] .".html", $m );
                           $m = str_replace ( $structure["members_menu"]["nick"]                   , $member["nick"], $m );
                           $result .= $m."\n";
                     
                     }
                     
                  }
                  
               }

               # Возвращаем сгенерированные данные
               return $result;

      }

      # Фукция для генерации правого меню (поиск)
      function show_search_menu ( ) {
      
               $result = "
                          <TABLE cellSpacing=\"2\" cellPadding=\"2\" width=\"150\" border=\"0\">
                          <form action=\"/search.html\" method=\"POST\">
                          <TR>
                              <TD width=150 align=\"center\">
                                  <input type=\"TEXT\" class=\"button\" name=\"search_string\" value=\"search\" onmouseover=\"this.focus ( );\" onblur=\"if ( value == '' ){value = 'search' }\" onfocus=\"if ( value == 'search' ) { value ='' }\"><br><br>
                                  <input type=\"SUBMIT\" class=\"button\" value=\"Поиск\">
                              </TD>
                          </TR>
                          </form>
                          </TABLE>
               ";

               # Возвращаем сгенерированные данные
               return $result;
               
      }

      # Функция для генерации правого меню (авторизация)
      function show_login_menu ( ) {

               global $security;

               $result = "";
               
               # Если пользовательно уже авторизован
               if ( $security->auth ) {

                  $result .= "<center class=\"porr\">Добро пожаловать </center>\n";
                  $result .= "<center class=\"por\">". $security->user["username"] ."</center>\n";

                  # Если пользователь имеет админские права
                  if ( (integer) $security->user["usergroupid"] === (integer) VBULLETIN_ADMIN_GROUP_ID ) {
                  
                     $result .= "<br><center><a href=\"/adminka/index.php\" target=\"_blank\">..::[ Админка ]::..</a></center>\n";
                     $result .= "<center><a href=\"/local_logs.html\">.:.[ Логи сайта ].:.</a></center>\n";
                     
                  }

                  $result .= "<br><center><a href=\"/logout.html\"><b class=porr>.:. Выход .:.</b></a></center>";
                  
               } else {

                  $result .= "<form action=\"/login.html\" method=\"POST\">\n";
                  $result .= "<input type=\"hidden\" name=\"action\" value=\"login\">\n";
                  $result .= "<center class=\"porr\">UserName</center>\n";
                  $result .= "<center><input type=\"TEXT\" class=\"button\" name=\"username\"></center>\n";
                  $result .= "<center class=\"porr\">Password</center>\n";
                  $result .= "<center><input type=\"PASSWORD\" class=\"button\" name=\"password\"></center>\n";
                  $result .= "<br><center><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Войти\"></center>\n";
                  $result .= "</form>\n";
                  $result .= "<center><a href=\"/forum/register.php\" target=\"_blank\">Регистрация</b></center>";
                  
               }

               # Возвращаем сгенерированные данные
               return $result;
               
      }

      # Функция для генерации правого меню (сниффер)
      function show_global_sniffer_menu ( ) {
      
               global $sql;

               $result = "";

               # Получаем данные о последних десяти сайтах попавших в логи
               $query = "SELECT `referer` FROM `". SQL_TABLE_GLOBAL_SNIFFER ."` WHERE `referer` != '' ORDER BY `id` DESC LIMIT 10";
               $data = $sql->query ( $query, "print_error_and_exit" );

               # Проверяем данные "на пригодность"
               if ( $data !== FALSE and mysql_num_rows ( $data ) !== 0 ) {

                  while ( $log = mysql_fetch_assoc ( $data ) ) {

                        $url = parse_url ( urldecode ( base64_decode ( $log["referer"] ) ) );

                        if ( !isset ( $url["host"] ) ) {
                           $url["host"]   = "unknown";
                        }

                        if ( !isset ( $url["scheme"] ) ) {
                           $url["scheme"] = "????";
                        }

                        $result .= "".  substr ( $url["scheme"] ."://". $url["host"], 0, 15 ) ."<br>\n";
                        
                  }

               }

               # Возвращаем сгенерированные данные
               return $result;

      }

      # Функция для генерации правого меню (счетчик)
      function show_counter_menu ( ) {
      
               $result = "
                       <center><img src=\"/style/templates/lock-team/images/counter.gif\" class=\"fadethis\" onMouseOut=\"imgFade(this,30,10,10)\" onMouseOver=\"imgFade(this,100,30,10)\"></center>
               ";

               # Возвращаем сгенерированные данные
               return $result;
               
      }
      
      function show_site_info_menu ( ) {

               global $sql;

               $result = "";

               $query = "SELECT `replycount`, `threadcount` FROM `". VBULLETIN_TABLE_PREFIX ."forum`";
               $data = $sql->query ( $query, "print_error_and_exit" );
               if ( $data !== FALSE and mysql_num_rows ( $data ) !== 0 ) {
                  $replycount = 0;
                  $threadcount = 0;
                  while ( $row = mysql_fetch_assoc ( $data ) ) {
                        $replycount += $row["replycount"];
                        $threadcount += $row["threadcount"];
                  }
               } else {
                  $replycount = 0;
                  $threadcount = 0;
               }

               $query = "SELECT * FROM `". SQL_TABLE_STATISTICS ."`";
               $statistics = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( !isset ( $statistics["news_count"] ) ) {
                  $statistics["news_count"] = 0;
               }
               if ( !isset ( $statistics["news_comm_count"] ) ) {
                  $statistics["news_comm_count"] = 0;
               }
               if ( !isset ( $statistics["articles_count"] ) ) {
                  $statistics["articles_count"] = 0;
               }
               if ( !isset ( $statistics["articles_comm_count"] ) ) {
                  $statistics["articles_comm_count"] = 0;
               }
               
#               $query = "SELECT MAX(`userid`) as userid, `username` FROM `". VBULLETIN_TABLE_PREFIX ."user` GROUP BY `username`";
#               $user = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               
               $result .= "
                           <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" align=\"center\">
                           <tr>
                               <td colspan=\"2\"><center class=porr>Сайт :</center></td>
                           </tr>
                           <tr>
                               <td><b class=por>Новостей</b></td>
                               <td><center class=date>". $statistics["news_count"] ."</center></td>
                           <tr>
                           <tr>
                               <td><b class=por>Комментариев</b></td>
                               <td><center class=date>". $statistics["news_comm_count"] ."</center></td>
                           <tr>
                           <tr>
                               <td colspan=\"2\"><br></td>
                           </tr>
                           <tr>
                               <td><b class=por>Статей</b></td>
                               <td><center class=date>". $statistics["articles_count"] ."</center></td>
                           <tr>
                           <tr>
                               <td><b class=por>Комментариев</b></td>
                               <td><center class=date>". $statistics["articles_comm_count"] ."</center></td>
                           <tr>
                           <tr>
                               <td colspan=\"2\"><br></td>
                           </tr>
                           <tr>
                               <td colspan=\"2\"><center class=porr>Форум :</center></td>
                           </tr>
                           <tr>
                               <td><b class=por>Тем</b></td>
                               <td><center class=date>". $threadcount ."</center></td>
                           <tr>
                           <tr>
                               <td><b class=por>Постов</b></td>
                               <td><center class=date>". $replycount ."</center></td>
                           <tr>
                           </table>
               ";
               
               return $result;

      }
      
}

?>