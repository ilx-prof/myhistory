<?php

class SEARCH {

      var $string;

      function parse_search_string ( ) {
               $this->string = isset ( $_POST["search_string"] ) ? mysql_escape_string ( htmlspecialchars ( $_POST["search_string"], ENT_QUOTES ) ) : "";
      }

      function search_in_news ( ) {
               global $sql;

               $result = "";
               if ( $this->string !== "" ) {
                  $query = "SELECT `id`, `razdel_id`, `title`
                            FROM   `". SQL_TABLE_NEWS ."`
                            WHERE
                                   `title` LIKE '%". $this->string ."%'
                                   OR `content` LIKE '%". $this->string ."%'
                                   OR `author_name` LIKE '%". $this->string ."%'
                            ORDER BY `razdel_id` ASC
                  ";
                  $data = $sql->query ( $query, "print_error_and_exit" );
                  if ( mysql_num_rows ( $data ) !== 0 ) {

                     $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."`";
                     $rdata = $sql->query ( $query, "print_error_and_exit" );
                     if ( mysql_num_rows ( $rdata ) !== 0 ) {
                        $razdels = array ( );
                        while ( $razdel = mysql_fetch_assoc ( $rdata ) ) :
                              $razdels[ $razdel["id"] ] = $razdel;
                        endwhile;

                        $r1 = "";
                        while ( $news = mysql_fetch_assoc ( $data ) ) :

                              if ( isset ( $razdels[$news["razdel_id"]]["title"] ) and $r1 !== $razdels[$news["razdel_id"]]["title"] ) {
                                 $result .= "<br><b class=date>Раздел - </b><b class=porr>". $razdels[$news["razdel_id"]]["title"] ."</b><br>\n";
                                 $r1 = $razdels[$news["razdel_id"]]["title"];
                              }

                              if ( isset ( $razdels[$news["razdel_id"]]["url"] ) ) {
                                 $result .= "<a href=\"/news/". $razdels[$news["razdel_id"]]["url"] ."/". $news["id"] .".html\" style=\"padding-left : 20px;\">". $news["title"] ."</a><bR>\n";
                              }

                        endwhile;

                     } else {
                        $result .= "<b class=date style=\"padding-left : 20px;\">Ничего не найдено</b><Br><Br>";
                     }
                  } else {
                     $result .= "<b class=date style=\"padding-left : 20px;\">Ничего не найдено</b><br><br>";
                  }
               }

               return $result;

      }

      function search_in_articles ( ) {
               global $sql;

               $result = "";
               if ( $this->string !== "" ) {
                  $query = "SELECT `id`, `razdel_id`, `title`
                            FROM   `". SQL_TABLE_ARTICLES ."`
                            WHERE
                                   `title` LIKE '%". $this->string ."%'
                                   OR `content` LIKE '%". $this->string ."%'
                                   OR `author_name` LIKE '%". $this->string ."%'
                            ORDER BY `razdel_id` ASC
                  ";
                  $data = $sql->query ( $query, "print_error_and_exit" );
                  if ( mysql_num_rows ( $data ) !== 0 ) {

                     $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."`";
                     $rdata = $sql->query ( $query, "print_error_and_exit" );
                     if ( mysql_num_rows ( $rdata ) !== 0 ) {
                        $razdels = array ( );
                        while ( $razdel = mysql_fetch_assoc ( $rdata ) ) :
                              $razdels[ $razdel["id"] ] = $razdel;
                        endwhile;

                        $r1 = "";
                        while ( $article = mysql_fetch_assoc ( $data ) ) :

                              if ( isset ( $razdels[$article["razdel_id"]]["title"] ) and $r1 !== $razdels[$article["razdel_id"]]["title"] ) {
                                 $result .= "<br><b class=date>Раздел - </b><b class=porr>". $razdels[$article["razdel_id"]]["title"] ."</b><br>\n";
                                 $r1 = $razdels[$article["razdel_id"]]["title"];
                              }

                              if ( isset ( $razdels[$article["razdel_id"]]["url"] ) ) {
                                 $result .= "<a href=\"/articles/". $razdels[$article["razdel_id"]]["url"] ."/". $article["id"] .".html\" style=\"padding-left : 20px;\">". $article["title"] ."</a><bR>\n";
                              }

                        endwhile;

                     } else {
                        $result .= "<b class=date style=\"padding-left : 20px;\">Ничего не найдено</b><Br><Br>";
                     }
                  } else {
                     $result .= "<b class=date style=\"padding-left : 20px;\">Ничего не найдено</b><br><br>";
                  }
               }

               return $result;

      }
      
      function obrabotka ( ) {
      
               $this->parse_search_string ( );

               $result = "";
               $result .= "<center class=porr>Поиск в новостях : </center>";
               $result .= $this->search_in_news ( );
               $result .= "<br>";
               $result .= "<center class=porr>Поиск в статьях : </center>";
               $result .= $this->search_in_articles ( );
               
               return $result;

      }

}

?>