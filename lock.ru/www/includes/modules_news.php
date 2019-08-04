<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class NEWS {

      var $replace = array (
                            "razdel_url_and_name_string" => array ( ),
                            "if_razdel_empty_string" => array ( ),
                            "if_razdel_not_empty_string" => array ( ),
                            "news_url_and_name_string" => array ( ),
                            "comment_string" => array ( ),
                            "comment_noreply_string" => array ( ),
                            "comment_reply_string" => array ( )
                           );

      var $template;
      var $data = array ( "title", "keyws" );
      
      function find_templates ( ) {
               global $structure, $misc;

               preg_match ( "/". $structure["news"]["all_razdels"]["str_start"]     ."(.+)". $structure["news"]["all_razdels"]["str_end"]     ."/s", $this->template->index, $this->replace["razdel_url_and_name_string"] );
               preg_match ( "/". $structure["news"]["all_razdels"]["empty_start"]   ."(.+)". $structure["news"]["all_razdels"]["empty_end"]   ."/s", $this->template->index, $this->replace["if_razdel_empty_string"] );
               preg_match ( "/". $structure["news"]["all_razdels"]["n_empty_start"] ."(.+)". $structure["news"]["all_razdels"]["n_empty_end"] ."/s", $this->template->index, $this->replace["if_razdel_not_empty_string"] );
               preg_match ( "/". $structure["news"]["all_razdels"]["element_start"] ."(.+)". $structure["news"]["all_razdels"]["element_end"] ."/s", $this->template->index, $this->replace["news_url_and_name_string"] );

               preg_match ( "/". $structure["news"]["all_razdels"]["c_str_start"]   ."(.+)". $structure["news"]["all_razdels"]["c_str_end"]   ."/s", $this->template->index, $this->replace["comment_string"] );
               preg_match ( "/". $structure["news"]["all_razdels"]["c_nr_start"]    ."(.+)". $structure["news"]["all_razdels"]["c_nr_end"]    ."/s", $this->template->index, $this->replace["comment_noreply_string"] );
               preg_match ( "/". $structure["news"]["all_razdels"]["c_r_start"]     ."(.+)". $structure["news"]["all_razdels"]["c_r_end"]     ."/s", $this->template->index, $this->replace["comment_reply_string"] );

      }

      
      function show_news_razdels ( ) {
               global $structure, $template, $security, $sql;
               $result = "";

               # Проверяем наличие раздела для категорий
               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'news'";
               $new = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $new["title"] ) ) {
                  $security->error_pages ( 404 ); # Если нет раздела, то выводим сообщение о отсутствующей странице
                  
                  $this->data["title"] = " Раздела не существует";
                  $this->data["keyws"] = " Раздела не существует";
                  
               } else {
               
                  # Проверяем наличие категорий под статьи
                  $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $new["id"] ." ORDER BY `order` ASC";
                  $data = $sql->query ( $query, "print_error_and_exit" );

                  $this->data["title"] = "[ ". $new["title"] ." ].:.";
                  $this->data["keyws"] = "[ ". $new["title"] ." ].:.";

                  if ( mysql_num_rows ( $data ) == 0 ) {
                     $result = "<center class=porr>Извините, но новостей пока нет! Зайдите позже!</center>\n"; # Если категорий нет, то сообщаем пользователя, что бы подождал
                     $this->template->index = str_replace ( $this->replace["if_razdel_not_empty_string"][0], $result, $this->template->index );

                     $this->data["title"] .= " Новостей пока нет. Зайдите позже";
                     $this->data["keyws"] .= " Новостей пока нет. Зайдите позже";

                  } else {

                     while ( $razdel = mysql_fetch_assoc ( $data ) ) : # Выводим категории

                           $query = "SELECT `id`, `title`, `content`, `author_id`, `author_name`, `create_time`, `views` FROM `". SQL_TABLE_NEWS ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` DESC LIMIT ". INF_NEWS_ON_MAIN_SHOW ."";
                           $data2 = $sql->query ( $query, "print_error_and_exit" );

                           $r = $this->replace["razdel_url_and_name_string"][1];
                           $r = str_replace ( $structure["news"]["all_razdels"]["razdel_link"], "/". $new["url"] ."/". $razdel["url"] .".html", $r );
                           $r = str_replace ( $structure["news"]["all_razdels"]["razdel_name"], $razdel["title"], $r );
                           $result .= $r."\n";

                           $this->data["title"] .= " ". $razdel["title"] ." : ";
                           $this->data["keyws"] .= " ". $razdel["title"] ." : ";

                           if ( mysql_num_rows ( $data2 ) === 0 ) {
                              $result .= $this->replace["if_razdel_empty_string"][1];
                              $this->data["title"] .= "Раздел пуст";
                              $this->data["keyws"] .= "Раздел пуст";
                           } else {

                              while ( $news = mysql_fetch_assoc ( $data2 ) ) : # Выводим ссылки на статьи
                                    $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_NEWS_COMM ."` WHERE `news_id` = ". $news["id"] ."";
                                    $com = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                                    list ( $date, $time ) = explode ( " ", $news["create_time"] );

                                    $this->data["title"] .= $news["title"] .", ";
                                    $this->data["keyws"] .= $news["title"] .", ";

                                    $n = $this->replace["news_url_and_name_string"][1];
                                    $n = str_replace ( $structure["news"]["all_razdels"]["element_link"] , "/". $new["url"] ."/". $razdel["url"] ."/". $news["id"] .".html", $n );
                                    $n = str_replace ( $structure["news"]["all_razdels"]["element_name"] , $news["title"], $n );
                                    $n = str_replace ( $structure["news"]["all_razdels"]["element_u_l"]  , "/forum/member.php?u=". $news["author_id"], $n );
                                    $n = str_replace ( $structure["news"]["all_razdels"]["element_user"] , $news["author_name"], $n );
                                    $n = str_replace ( $structure["news"]["all_razdels"]["element_comm"] , ( $com["cnt"] > 0 ? $com["cnt"] : "нет" ), $n );
                                    $n = str_replace ( $structure["news"]["all_razdels"]["element_cont"] , nl2br ( $news["content"] ), $n );
                                    $n = str_replace ( $structure["news"]["all_razdels"]["element_date"] , $date, $n );
                                    $result .= $n."\n";

                              endwhile;
                           }

                     endwhile;
                  }
               }

               $this->template->index = str_replace ( $structure["news"]["all_razdels"]["n_empty_start"], "", $this->template->index );
               $this->template->index = str_replace ( $structure["news"]["all_razdels"]["n_empty_end"], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["razdel_url_and_name_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["if_razdel_empty_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["news_url_and_name_string"][0], $result, $this->template->index );
               $template->edit ( $structure["content"], $this->template->index );
               
      }
      
      function show_news_razdels_only ( ) {
               global $structure, $template, $security, $sql;
               
               function genre_pages ( $razdel_id ) {
                        global $sql;
                        $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_NEWS ."` WHERE `razdel_id` = ". $razdel_id ."";
                        $c = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                        $count = $c["cnt"];

                        $result = "<b class=porr>Страницы : </b>";
                        $nachalo = 0;
                        if ( $count >= INF_NEWS_PER_PAGE ) {
                           $pages = bcdiv ( $count, INF_NEWS_PER_PAGE );
                           if ( bcmod ( $count, INF_NEWS_PER_PAGE ) == 0 ) {
                              for ( $i = 1; $i <= $pages; $i++ ) :
                                  if ( isset ( $_GET["input"]["page"] ) and $i == $_GET["input"]["page"] ) {
                                     $str = "<b class=porr>". $i ."</b>";
                                     $nachalo = ( $i - 1 ) * INF_NEWS_PER_PAGE;
                                  } else {
                                     $str = $i;
                                  }
                                  if ( ( !isset ( $_GET["input"]["page"] ) or ( isset ( $_GET["input"]["page"] ) and $_GET["input"]["page"] >= $pages ) ) and $i == 1 ) {
                                     $str = "<b class=porr>". $i ."</b>";
                                  }
                                  $result .= " <a href=\"/". $_GET["input"]["razdel_url"] ."/". $_GET["input"]["kategoria_url"] .".html+". $i ."\">". $str ."</a>";
                              endfor;
                           } else {
                              for ( $i = 1; $i <= $pages+1; $i++ ) :
                                  if ( isset ( $_GET["input"]["page"] ) and $i == $_GET["input"]["page"] ) {
                                     $nachalo = ( $i - 1 ) * INF_NEWS_PER_PAGE;
                                     $str = "<b class=porr>". $i ."</b>";
                                  } else {
                                     $str = $i;
                                  }
                                  if ( ( !isset ( $_GET["input"]["page"] ) or ( isset ( $_GET["input"]["page"] ) and $_GET["input"]["page"] >= $pages ) ) and $i == 1 ) {
                                     $str = "<b class=porr>". $i ."</b>";
                                  }
                                  $result .= " <a href=\"/". $_GET["input"]["razdel_url"] ."/". $_GET["input"]["kategoria_url"] .".html+". $i ."\">". $str ."</a>";
                              endfor;
                           }
                        } else {
                           $result = "";
                        }

                        $a = array ( );
                        $a["nachalo"] = $nachalo;
                        $a["limit"] = INF_NEWS_PER_PAGE;
                        $a["pages"] = $result;

                        return $a;
                        
               }
               $result = "";

               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'news'";
               $new = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $new["title"] ) ) {
                  $security->error_pages ( 404 );

                  $this->data["title"] = " Раздела не существует";
                  $this->data["keyws"] = " Раздела не существует";
                  
               } else {

                  $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `url` = '". $_GET["input"]["kategoria_url"] ."' AND `razdel_id` = ". $new["id"] ."";
                  $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

                  $this->data["title"] = "[ ". $new["title"] ." ].:.";
                  $this->data["keyws"] = "[ ". $new["title"] ." ].:.";

                  if ( empty ( $razdel["title"] ) ) {
                     $security->error_pages ( 404 );

                     $this->data["title"] .= " Категории не существует";
                     $this->data["keyws"] .= " Категории не существует";
                     
                  } else {

                     $a = genre_pages ( $razdel["id"] );
                     $query = "SELECT `id`, `title`, `content`, `author_id`, `author_name`, `create_time` FROM `". SQL_TABLE_NEWS ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` DESC LIMIT ". $a["nachalo"] .", ". $a["limit"] ."";
                     $data2 = $sql->query ( $query, "print_error_and_exit" );

                     $this->data["title"] .= " ". $razdel["title"] ." : ";
                     $this->data["keyws"] .= " ". $razdel["title"] ." : ";

                     if ( mysql_num_rows ( $data2 ) == 0 ) {
                        $result .= $this->replace["if_razdel_empty_string"][1];
                        
                        $this->data["title"] .= " Новостей пока нет. Зайдите позже";
                        $this->data["keyws"] .= " Новостей пока нет. Зайдите позже";
                        
                     } else {

                        while ( $news = mysql_fetch_assoc ( $data2 ) ) :

                              $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_NEWS_COMM ."` WHERE `news_id` = ". $news["id"] ."";
                              $com = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                              list ( $date, $time ) = explode ( " ", $news["create_time"] );

                              $this->data["title"] .= $news["title"] .", ";
                              $this->data["keyws"] .= $news["title"] .", ";

                              $n = $this->replace["news_url_and_name_string"][1];
                              $n = str_replace ( $structure["news"]["all_razdels"]["element_link"] , "/". $new["url"] ."/". $razdel["url"] ."/". $news["id"] .".html", $n );
                              $n = str_replace ( $structure["news"]["all_razdels"]["element_name"] , $news["title"], $n );
                              $n = str_replace ( $structure["news"]["all_razdels"]["element_u_l"]  , "/forum/member.php?u=". $news["author_id"], $n );
                              $n = str_replace ( $structure["news"]["all_razdels"]["element_user"] , $news["author_name"], $n );
                              $n = str_replace ( $structure["news"]["all_razdels"]["element_cont"] , nl2br ( $news["content"] ), $n );
                              $n = str_replace ( $structure["news"]["all_razdels"]["element_comm"] , ( $com["cnt"] > 0 ? $com["cnt"] : "нет" ), $n );
                              $n = str_replace ( $structure["news"]["all_razdels"]["element_date"] , $date, $n );
                              $result .= $n."\n";

                        endwhile;
                     }
                     $this->template->index = str_replace ( $structure["news"]["all_razdels"]["razdel_name"], $razdel["title"], $this->template->index );
                     $this->template->index = str_replace ( $structure["news"]["all_razdels"]["pages"], $a["pages"], $this->template->index );
                  }
               }

               $this->template->index = str_replace ( $this->replace["if_razdel_empty_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["news_url_and_name_string"][0], $result, $this->template->index );
               $template->edit ( $structure["content"], $this->template->index );

      }
      
      function show_news ( ) {
               global $security, $structure, $template, $sql;
               $result = "";

               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'news'";
               $new = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $new["title"] ) ) {
                  $security->error_pages ( 404 );

                  $this->data["title"] = "Раздела не существует";
                  $this->data["keyws"] = "Раздела не существует";
                  
               } else {

                  $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `url` = '". $_GET["input"]["kategoria_url"] ."' AND `razdel_id` = ". $new["id"] ."";
                  $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

                  $this->data["title"] = "[ ". $new["title"] ." ].:.";
                  $this->data["keyws"] = "[ ". $new["title"] ." ].:.";

                  if ( empty ( $razdel["title"] ) ) {
                     $security->error_pages ( 404 );
                     
                     $this->data["title"] .= "Категории не существует";
                     $this->data["keyws"] .= "Категории не существует";
                     
                  } else {
                  
                     $query = "SELECT `id`, `title`, `content`, `author_id`, `author_name`, `create_time`, `views` FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_GET["input"]["element_id"] ." AND `razdel_id` = ". $razdel["id"] ."";
                     $news = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

                     $this->data["title"] .= " ". $razdel["title"] ." : ";
                     $this->data["keyws"] .= " ". $razdel["title"] ." : ";

                     if ( empty ( $news["title"] ) ) {
                        $security->error_pages ( 404 );
                        
                        $this->data["title"] .= "Новости не существует";
                        $this->data["keyws"] .= "Новости не существует";
                        
                     } else {

                        $query = "UPDATE `". SQL_TABLE_NEWS ."` SET `views` = ". ( $news["views"] + 1 ) ." WHERE `id` = ". $news["id"] ." LIMIT 1";
                        $sql->query ( $query, "print_error_and_exit" );
                        list ( $date, $time ) = explode ( " ", $news["create_time"] );

                        $this->data["title"] .= $news["title"];
                        $this->data["keyws"] .= $news["title"];
                        
                        $text = substr ( strip_tags ( nl2br ( $news["content"] ) ), 0, 300 );
                        $text = explode ( " ", $text );
                        for ( $i = 0; $i <= 50; $i++ ) :
                            if ( isset ( $text[$i] ) ) $this->data["keyws"] .= ", " .$text[$i];
                            else break;
                        endfor;
                        
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["razdel_name"]  , $razdel["title"]                           , $this->template->index );
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["element_name"] , $news["title"]                             , $this->template->index );
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["element_date"] , $date                                      , $this->template->index );
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["element_user"] , $news["author_name"]                       , $this->template->index );
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["element_u_l"]  , "/forum/member.php?u=". $news["author_id"] , $this->template->index );
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["element_user"] , $news["author_name"]                       , $this->template->index );
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["element_cont"] , nl2br ( $news["content"] )                 , $this->template->index );
                        
                        if ( $security->auth and isset ( $_POST["action"] ) and $_POST["action"] === "add_new_comment" and isset ( $_POST["content"] ) and strlen ( $_POST["content"] ) > 1 ) {
                           $query = "INSERT INTO
                                                `". SQL_TABLE_NEWS_COMM ."`
                                     VALUES (
                                             '',
                                             '". $news["id"] ."',
                                             '". mysql_escape_string ( $_POST["content"] ) ."',
                                             '". $security->user["userid"] ."',
                                             '". mysql_escape_string ( $security->user["username"] ) ."',
                                             '". date ( "Y-m-d H:i:s", time ( ) ) ."',
                                             '". $security->user["userid"] ."',
                                             '". mysql_escape_string ( $security->user["username"] ) ."',
                                             '". date ( "Y-m-d H:i:s", time ( ) ) ."',
                                             '". $security->user["userid"] ."'
                                     )
                           ";
                           $sql->query ( $query, "print_error_and_exit" );

                           $query = "UPDATE `". SQL_TABLE_STATISTICS ."` SET `news_comm_count` = `news_comm_count` + 1 WHERE `id` = 1";
                           $sql->query ( $query, "print_error_and_exit" );
                           
                           $content = "Comment to news(". $news["title"] .") added";
                           $query = "INSERT INTO
                                                `". SQL_TABLE_USERS_LOGS ."`
                                     VALUES (
                                                '',
                                                '". $security->user["userid"] ."',
                                                '". mysql_escape_string ( $security->user["username"] ) ."',
                                                '". IP ."',
                                                '". mysql_escape_string ( $content ) ."',
                                                '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                                     )
                           ";
                           $sql->query ( $query, "print_error_and_exit" );
                           
                           header ( "Location: http://". getenv ( "HTTP_HOST" ) ."/". $_GET["input"]["razdel_url"] ."/". $_GET["input"]["kategoria_url"] ."/". $_GET["input"]["element_id"] .".html" );
                        }

                        $query = "SELECT `content`, `author_id`, `author_name`, `create_time`, `allow_html` FROM `". SQL_TABLE_NEWS_COMM ."` WHERE `news_id` = ". $news["id"] ." ORDER BY `id`";
                        $data = $sql->query ( $query, "print_error_and_exit" );

                        $commentariev = mysql_num_rows ( $data );
                        $this->template->index = str_replace ( $structure["news"]["all_razdels"]["element_comm"], ( $commentariev > 0 ? $commentariev : "нет" ), $this->template->index );

                        while ( $comment = mysql_fetch_assoc ( $data ) ) :
                              $query = "SELECT
                                              `usergroupid`
                                        FROM
                                              `". VBULLETIN_TABLE_PREFIX ."user`
                                        WHERE
                                              `userid` = ". $comment["allow_html"] ."
                              ";
                              $user = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                              if ( $user["usergroupid"] != VBULLETIN_ADMIN_GROUP_ID ) {
                                 $comment["content"] = htmlspecialchars ( $comment["content"], ENT_QUOTES );
                              }
                              list ( $date, $time ) = explode ( " ", $comment["create_time"] );

                              $text = substr ( strip_tags ( nl2br ( $comment["content"] ) ), 0, 300 );
                              $text = explode ( " ", $text );
                              for ( $i = 0; $i <= 10; $i++ ) :
                                  if ( isset ( $text[$i] ) ) $this->data["keyws"] .= ", " .$text[$i];
                                  else break;
                              endfor;

                              $c = $this->replace["comment_string"][1];
                              $c = str_replace ( $structure["news"]["all_razdels"]["c_name"], $comment["author_name"], $c );
                              $c = str_replace ( $structure["news"]["all_razdels"]["c_date"], $date, $c );
                              $c = str_replace ( $structure["news"]["all_razdels"]["c_time"], $time, $c );
                              $c = str_replace ( $structure["news"]["all_razdels"]["c_text"], nl2br ( $comment["content"] ), $c );
                              $result .= $c."\n";
                              
                        endwhile;



                        if ( !$security->auth ) {
                           $result .= $this->replace["comment_noreply_string"][1];
                        } else {
                           $result .= $this->replace["comment_reply_string"][1];
                        }
                     }
                  }
               }

               $this->template->index = str_replace ( $this->replace["comment_reply_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["comment_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["comment_noreply_string"][0], $result, $this->template->index );
               
               $template->edit ( $structure["content"], $this->template->index );

      }
      
      function obrabotka ( ) {

               if ( isset ( $_GET["input"]["razdel_url"] ) and $_GET["input"]["razdel_url"] == "news" and isset ( $_GET["input"]["kategoria_url"] ) and isset ( $_GET["input"]["element_id"] ) ) {
               
                  $this->template = new TEMPLATE;
                  if ( $this->template->exists ( TEMPLATE_NEWS ) ) {
                     $this->template->load ( );
                     $this->find_templates ( );
                     $this->show_news ( );
                  }

               } elseif ( isset ( $_GET["input"]["razdel_url"] ) and $_GET["input"]["razdel_url"] == "news" and isset ( $_GET["input"]["kategoria_url"] ) ) {

                  $this->template = new TEMPLATE;
                  if ( $this->template->exists ( TEMPLATE_NEWS_ONE_R ) ) {
                     $this->template->load ( );
                     $this->find_templates ( );
                     $this->show_news_razdels_only ( );
                  }

               } elseif ( isset ( $_GET["input"]["razdel_url"] ) and $_GET["input"]["razdel_url"] == "news" ) {

                  $this->template = new TEMPLATE;
                  if ( $this->template->exists ( TEMPLATE_NEWS_ALL_R ) ) {
                     $this->template->load ( );
                     $this->find_templates ( );
                     $this->show_news_razdels ( );
                  }
                  
               }
      }


}

?>