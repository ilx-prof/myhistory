<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ( );
}

class ARTICLES {

      var $replace = array (
                            "razdel_url_and_name_string" => array ( ),
                            "if_razdel_empty_string" => array ( ),
                            "if_razdel_not_empty_string" => array ( ),
                            "articles_url_and_name_string" => array ( ),
                            "comment_string" => array ( ),
                            "comment_noreply_string" => array ( ),
                            "comment_reply_string" => array ( )
                           );

      var $template;
      var $data = array ( );

      function find_templates ( ) {
               global $structure, $misc;

               preg_match ( "/". $structure["articles"]["all_razdels"]["str_start"]     ."(.+)". $structure["articles"]["all_razdels"]["str_end"]     ."/s", $this->template->index, $this->replace["razdel_url_and_name_string"] );
               preg_match ( "/". $structure["articles"]["all_razdels"]["empty_start"]   ."(.+)". $structure["articles"]["all_razdels"]["empty_end"]   ."/s", $this->template->index, $this->replace["if_razdel_empty_string"] );
               preg_match ( "/". $structure["articles"]["all_razdels"]["n_empty_start"] ."(.+)". $structure["articles"]["all_razdels"]["n_empty_end"] ."/s", $this->template->index, $this->replace["if_razdel_not_empty_string"] );
               preg_match ( "/". $structure["articles"]["all_razdels"]["element_start"] ."(.+)". $structure["articles"]["all_razdels"]["element_end"] ."/s", $this->template->index, $this->replace["articles_url_and_name_string"] );

               preg_match ( "/". $structure["articles"]["all_razdels"]["c_str_start"]   ."(.+)". $structure["articles"]["all_razdels"]["c_str_end"]   ."/s", $this->template->index, $this->replace["comment_string"] );
               preg_match ( "/". $structure["articles"]["all_razdels"]["c_nr_start"]    ."(.+)". $structure["articles"]["all_razdels"]["c_nr_end"]    ."/s", $this->template->index, $this->replace["comment_noreply_string"] );
               preg_match ( "/". $structure["articles"]["all_razdels"]["c_r_start"]     ."(.+)". $structure["articles"]["all_razdels"]["c_r_end"]     ."/s", $this->template->index, $this->replace["comment_reply_string"] );

      }

      
      function show_articles_razdels ( ) {
               global $structure, $template, $security, $sql;
               $result = "";

               # Проверяем наличие раздела для категорий
               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'articles'";
               $art = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $art["title"] ) ) {
                  $security->error_pages ( 404 ); # Если нет раздела, то выводим сообщение о отсутствующей странице
                  
                  $this->data["title"] = " Раздела не существует";
                  $this->data["keyws"] = " Раздела не существует";
               } else {
               
                  # Проверяем наличие категорий под статьи
                  $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $art["id"] ." ORDER BY `order` ASC";
                  $data = $sql->query ( $query, "print_error_and_exit" );
                  
                  $this->data["title"] = "[ ". $art["title"]. " ].:.";
                  $this->data["keyws"] = "[ ". $art["title"]. " ].:.";

                  if ( mysql_num_rows ( $data ) == 0 ) {
                     $result = "<center class=porr>Извините, но статей пока нет! Зайдите позже!</center>\n"; # Если категорий нет, то сообщаем пользователя, что бы подождал
                     $this->template->index = str_replace ( $this->replace["if_razdel_not_empty_string"][0], $result, $this->template->index );
                     
                     $this->data["title"] .= " Статей пока нет. Зайдите позже";
                     $this->data["keyws"] .= " Статей пока нет. Зайдите позже";
                     
                  } else {

                     while ( $razdel = mysql_fetch_assoc ( $data ) ) : # Выводим категории

                           $query = "SELECT `id`, `title`, `author_id`, `author_name`, `create_time`, `views` FROM `". SQL_TABLE_ARTICLES ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` ASC LIMIT ". INF_ARTICLES_ON_MAIN_SHOW ."";
                           $data2 = $sql->query ( $query, "print_error_and_exit" );

                           $this->data["title"] .= " ". $razdel["title"] ." : ";
                           $this->data["keyws"] .= " ". $razdel["title"] ." : ";

                           $r = $this->replace["razdel_url_and_name_string"][1];
                           $r = str_replace ( $structure["articles"]["all_razdels"]["razdel_link"], "/". $art["url"] ."/". $razdel["url"] .".html", $r );
                           $r = str_replace ( $structure["articles"]["all_razdels"]["razdel_name"], $razdel["title"], $r );
                           $result .= $r."\n";

                           if ( mysql_num_rows ( $data2 ) === 0 ) {
                              $result .= $this->replace["if_razdel_empty_string"][1];
                           } else {

                              while ( $article = mysql_fetch_assoc ( $data2 ) ) : # Выводим ссылки на статьи
                                    $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_ARTICLES_COMM ."` WHERE `article_id` = ". $article["id"] ."";
                                    $com = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                                    list ( $date, $time ) = explode ( " ", $article["create_time"] );

                                    $this->data["title"] .= $article["title"] .", ";
                                    $this->data["keyws"] .= $article["title"] .", ";

                                    $a = $this->replace["articles_url_and_name_string"][1];
                                    $a = str_replace ( $structure["articles"]["all_razdels"]["element_link"] , "/". $art["url"] ."/". $razdel["url"] ."/". $article["id"] .".html", $a );
                                    $a = str_replace ( $structure["articles"]["all_razdels"]["element_name"] , $article["title"], $a );
                                    $a = str_replace ( $structure["articles"]["all_razdels"]["element_u_l"]  , "/forum/member.php?u=". $article["author_id"], $a );
                                    $a = str_replace ( $structure["articles"]["all_razdels"]["element_user"] , $article["author_name"], $a );
                                    $a = str_replace ( $structure["articles"]["all_razdels"]["element_comm"] , ( $com["cnt"] > 0 ? $com["cnt"] : "нет" ), $a );
                                    $a = str_replace ( $structure["articles"]["all_razdels"]["element_views"], ( $article["views"] > 0 ? $article["views"] : "нет" ), $a );
                                    $a = str_replace ( $structure["articles"]["all_razdels"]["element_date"] , $date, $a );
                                    $result .= $a."\n";

                              endwhile;
                           }

                     endwhile;
                  }
               }

               $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["n_empty_start"], "", $this->template->index );
               $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["n_empty_end"], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["razdel_url_and_name_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["if_razdel_empty_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["articles_url_and_name_string"][0], $result, $this->template->index );
               $template->edit ( $structure["content"], $this->template->index );
               
      }
      
      function show_articles_razdels_only ( ) {
               global $structure, $template, $security, $sql;
               $result = "";

               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'articles'";
               $art = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $art["title"] ) ) {
                  $security->error_pages ( 404 );

                  $this->data["title"] = " Раздела не существует";
                  $this->data["keyws"] = " Раздела не существует";
                  
               } else {

                  $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `url` = '". $_GET["input"]["kategoria_url"] ."' AND `razdel_id` = ". $art["id"] ."";
                  $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

                  $this->data["title"] = "[ ". $art["title"] ." ].:.";
                  $this->data["keyws"] = "[ ". $art["title"] ." ].:.";

                  if ( empty ( $razdel["title"] ) ) {
                     $security->error_pages ( 404 );

                     $this->data["title"] .= " Категории не существует";
                     $this->data["keyws"] .= " Категории не существует";
                     
                  } else {

                     $query = "SELECT `id`, `title`, `author_id`, `author_name`, `create_time`, `views` FROM `". SQL_TABLE_ARTICLES ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` ASC";
                     $data2 = $sql->query ( $query, "print_error_and_exit" );
                     
                     $this->data["title"] .= " ". $razdel["title"] ." : ";
                     $this->data["keyws"] .= " ". $razdel["title"] ." : ";

                     if ( mysql_num_rows ( $data2 ) == 0 ) {
                        $result .= $this->replace["if_razdel_empty_string"][1];

                        $this->data["title"] .= " Статей пока нет. Зайдите позже";
                        $this->data["keyws"] .= " Статей пока нет. Зайдите позже";

                     } else {

                        while ( $article = mysql_fetch_assoc ( $data2 ) ) :

                              $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_ARTICLES_COMM ."` WHERE `article_id` = ". $article["id"] ."";
                              $com = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                              list ( $date, $time ) = explode ( " ", $article["create_time"] );

                              $this->data["title"] .= $article["title"] .", ";
                              $this->data["keyws"] .= $article["title"] .", ";

                              $a = $this->replace["articles_url_and_name_string"][1];
                              $a = str_replace ( $structure["articles"]["all_razdels"]["element_link"] , "/". $art["url"] ."/". $razdel["url"] ."/". $article["id"] .".html", $a );
                              $a = str_replace ( $structure["articles"]["all_razdels"]["element_name"] , $article["title"], $a );
                              $a = str_replace ( $structure["articles"]["all_razdels"]["element_u_l"]  , "/forum/member.php?u=". $article["author_id"], $a );
                              $a = str_replace ( $structure["articles"]["all_razdels"]["element_user"] , $article["author_name"], $a );
                              $a = str_replace ( $structure["articles"]["all_razdels"]["element_comm"] , ( $com["cnt"] > 0 ? $com["cnt"] : "нет" ), $a );
                              $a = str_replace ( $structure["articles"]["all_razdels"]["element_views"], ( $article["views"] > 0 ? $article["views"] : "нет" ), $a );
                              $a = str_replace ( $structure["articles"]["all_razdels"]["element_date"] , $date, $a );
                              $result .= $a."\n";

                        endwhile;
                     }
                     $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["razdel_name"], $razdel["title"], $this->template->index );
                  }
               }

               $this->template->index = str_replace ( $this->replace["if_razdel_empty_string"][0], "", $this->template->index );
               $this->template->index = str_replace ( $this->replace["articles_url_and_name_string"][0], $result, $this->template->index );
               $template->edit ( $structure["content"], $this->template->index );

      }
      
      function show_article ( ) {
               global $security, $structure, $template, $sql, $misc;
               $result = "";

               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'articles'";
               $art = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $art["title"] ) ) {
                  $security->error_pages ( 404 );
                  
                  $this->data["title"] = " Раздела не существует";
                  $this->data["keyws"] = " Раздела не существует";

               } else {

                  $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `url` = '". $_GET["input"]["kategoria_url"] ."' AND `razdel_id` = ". $art["id"] ."";
                  $razdel = mysql_fetch_assoc ( $sql->query ( $query, "$result .=_error_and_exit" ) );
                  
                  $this->data["title"] = "[ ". $art["title"] ." ].:.";
                  $this->data["keyws"] = "[ ". $art["title"] ." ].:.";

                  if ( empty ( $razdel["title"] ) ) {
                     $security->error_pages ( 404 );

                     $this->data["title"] .= " Категории не существует";
                     $this->data["keyws"] .= " Категории не существует";

                  } else {
                  
                     $query = "SELECT `id`, `title`, `content`, `author_id`, `author_name`, `create_time`, `views` FROM `". SQL_TABLE_ARTICLES ."` WHERE `id` = ". $_GET["input"]["element_id"] ." AND `razdel_id` = ". $razdel["id"] ."";
                     $article = mysql_fetch_assoc ( $sql->query ( $query, "$result .=_error_and_exit" ) );

                     $this->data["title"] .= " ". $razdel["title"] ." : ";
                     $this->data["keyws"] .= " ". $razdel["title"]. " : ";

                     if ( empty ( $article["title"] ) ) {
                        $security->error_pages ( 404 );

                        $this->data["title"] .= " Статьи не существует";
                        $this->data["keyws"] .= " Статьи не существует";

                     } else {

                        $query = "UPDATE `". SQL_TABLE_ARTICLES ."` SET `views` = ". ( $article["views"] + 1 ) ." WHERE `id` = ". $article["id"] ." LIMIT 1";
                        $sql->query ( $query, "print_error_and_exit" );
                        
                        $this->data["title"] .= $article["title"];
                        $this->data["keyws"] .= $article["title"];
                        
                        list ( $date, $time ) = explode ( " ", $article["create_time"] );

                        $article["content"] = nl2br ( $article["content"] );
#                        preg_match_all ( "/(<(pre+)[^>]*>)(.*)(<\/\\2>)/Us", $article["content"], $pre, PREG_SET_ORDER );
#                        for ( $i = 0; $i < sizeof ( $pre ); $i++ ) :
#                            $article["content"] = str_replace ( $pre[$i][3], htmlspecialchars ( str_replace ( "<br />", "", $pre[$i][3] ), ENT_QUOTES ), $article["content"] );
#                        endfor;

                        $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["razdel_name"] , $razdel["title"]              , $this->template->index );
                        $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["element_name"], $article["title"]             , $this->template->index );
                        $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["element_date"], $date                         , $this->template->index );
                        $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["element_user"], $article["author_name"]       , $this->template->index );
                        $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["element_cont"], $article["content"]           , $this->template->index );

                        $text = substr ( strip_tags ( nl2br ( $article["content"] ) ), 0, 300 );
                        $text = explode ( " ", $text );
                        for ( $i = 0; $i <= 50; $i++ ) :
                            if ( isset ( $text[$i] ) ) $this->data["keyws"] .= ", " .$text[$i];
                            else break;
                        endfor;
                        
                        if ( $security->auth and isset ( $_POST["action"] ) and $_POST["action"] === "add_new_comment" and isset ( $_POST["content"] ) and strlen ( $_POST["content"] ) > 1 ) {
                           $query = "INSERT INTO
                                                `". SQL_TABLE_ARTICLES_COMM ."`
                                     VALUES (
                                             '',
                                             '". $article["id"] ."',
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

                           $query = "UPDATE `". SQL_TABLE_STATISTICS ."` SET `articles_comm_count` = `articles_comm_count` + 1 WHERE `id` = 1";
                           $sql->query ( $query, "print_error_and_exit" );
                           
                           $content = "Comment to article(". $article["title"] .") added";
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

                        $query = "SELECT `content`, `author_id`, `author_name`, `create_time`, `allow_html` FROM `". SQL_TABLE_ARTICLES_COMM ."` WHERE `article_id` = ". $article["id"] ." ORDER BY `id`";
                        $data = $sql->query ( $query, "print_error_and_exit" );

                        $commentariev = mysql_num_rows ( $data );
                        $this->template->index = str_replace ( $structure["articles"]["all_razdels"]["element_comm"], ( $commentariev > 0 ? $commentariev : "нет" ), $this->template->index );

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
                              $c = str_replace ( $structure["articles"]["all_razdels"]["c_name"], $comment["author_name"], $c );
                              $c = str_replace ( $structure["articles"]["all_razdels"]["c_date"], $date, $c );
                              $c = str_replace ( $structure["articles"]["all_razdels"]["c_time"], $time, $c );
                              $c = str_replace ( $structure["articles"]["all_razdels"]["c_text"], nl2br ( $comment["content"] ), $c );
                              
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

               if ( isset ( $_GET["input"]["razdel_url"] ) and $_GET["input"]["razdel_url"] == "articles" and isset ( $_GET["input"]["kategoria_url"] ) and isset ( $_GET["input"]["element_id"] ) ) {
               
                  $this->template = new TEMPLATE;
                  if ( $this->template->exists ( TEMPLATE_ARTICLES ) ) {
                     $this->template->load ( );
                     $this->find_templates ( );
                     $this->show_article ( );
                  }

               } elseif ( isset ( $_GET["input"]["razdel_url"] ) and $_GET["input"]["razdel_url"] == "articles" and isset ( $_GET["input"]["kategoria_url"] ) ) {

                  $this->template = new TEMPLATE;
                  if ( $this->template->exists ( TEMPLATE_ARTICLES_ONE_R ) ) {
                     $this->template->load ( );
                     $this->find_templates ( );
                     $this->show_articles_razdels_only ( );
                  }

               } elseif ( isset ( $_GET["input"]["razdel_url"] ) and $_GET["input"]["razdel_url"] == "articles" ) {

                  $this->template = new TEMPLATE;
                  if ( $this->template->exists ( TEMPLATE_ARTICLES_ALL_R ) ) {
                     $this->template->load ( );
                     $this->find_templates ( );
                     $this->show_articles_razdels ( );
                  }
                  
               }
      }


}

?>