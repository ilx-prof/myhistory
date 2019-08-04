<?php

class MY_ARCHIVE {

      function show_user_labels ( ) {
               global $security, $sql;
               $result = "";
               
               if ( isset ( $_POST["action"] ) and $_POST["action"] == "add_new_record" and isset ( $_POST["label"] ) and strlen ( trim ( $_POST["label"] ) ) >= 3 and isset ( $_POST["description"] ) ) {

                  $query = "SELECT `user_id` FROM `". SQL_TABLE_MY_ARCH_INFO ."` WHERE `label` = '". mysql_escape_string ( $_POST["label"] ) ."' AND `user_id` = ". $security->user["userid"] ."";
                  $test = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                  if ( !empty ( $test["user_id"] ) ) {
                     $result .= "<center class=porr>Такая запись уже есть в вашей базе.</center><br>";
                  } else {

                     $query = "INSERT INTO `". SQL_TABLE_MY_ARCH_INFO ."`
                               VALUES (
                                           '',
                                           '". mysql_escape_string ( $_POST["label"] ) ."',
                                           '". mysql_escape_string ( $_POST["description"] ) ."',
                                           '". $security->user["userid"] ."',
                                           '". $security->user["username"] ."',
                                           '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                               )
                     ";
                     $sql->query ( $query, "return_error" );
                     if ( $sql->error ) {
                        $result .= "<center class=porr>Запись по неизвестным причинам не добавлена</center><br>";
                     } else {
                        $result .= "<center class=porr>Запись успешно добавлена</center><br>";
                     }
                  }
               }

               $query = "SELECT `id`, `label` FROM `". SQL_TABLE_MY_ARCH_INFO ."` WHERE `user_id` = ". $security->user["userid"] ." ORDER BY `id` DESC";
               $data = $sql->query ( $query, "print_error_and_exit" );
               if ( mysql_num_rows ( $data ) !== 0 ) {
                  $result .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">";
                  $result .= "<tr>
                                  <td><center class=porr>Запись</center></td>
                                  <td><center class=porr>Данных</center></td>
                              </tr>
                  ";
                  while ( $record = mysql_fetch_assoc ( $data ) ) :
                        $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_MY_ARCH_CONTENT ."` WHERE `label_id` = ". $record["id"] ." AND `user_id` = ". $security->user["userid"] ."";
                        $c = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
                        $result .= "<tr>";
                        $result .= "    <td><a href=\"/spynet/record/". $record["id"] .".html\"><b class=por>". htmlspecialchars ( $record["label"], ENT_QUOTES ) ."</b></a></td>";
                        $result .= "    <td><center class=date>". $c["cnt"] ."</center></td>";
                        $result .= "</tr>";
                  endwhile;
                  $result .= "</table>";
               } else {
                  $result .= "<br><center class=porr>У вас нет записей. Хотите их добавить?</center>";
               }
               $result .= "<br><bR><center class=porr>Добавление новой записи</center>
                           <form method=\"POST\">
                           <input type=\"HIDDEN\" name=\"action\" value=\"add_new_record\">
                           <b class=por>Название записи</b><br>
                           <input type=\"TEXT\" class=\"button\" name=\"label\" style=\"width : 100%;\"><br>
                           <b class=por>Описание записи</b><Br>
                           <textarea class=\"button\" name=\"description\" style=\"width : 100%; background : white;\"></textarea><br>
                           <center><input type=\"SUBMIT\" class=\"button\" value=\"Добавить\" style=\"width : 220px;\"></center>
                           </form>
               ";
               
               return $result;

      }
      
      function show_user_content ( ) {
               global $security, $sql;

               $result = "";
               $query = "SELECT `id`, `label`, `description` FROM `". SQL_TABLE_MY_ARCH_INFO ."` WHERE `id` = ". $_GET["input"]["element_id"] ." AND `user_id` = ". $security->user["userid"] ."";
               $record = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $record["id"] ) ) {
                  $result .= "<center class=porr>Данной записи не существует</center>";
               } else {

                  if ( isset ( $_POST["action"] ) and $_POST["action"] == "edit_data" and isset ( $_POST["label"] ) and isset ( $_POST["description"] ) ) {

                     if ( isset ( $_POST["data_old"] ) and is_array ( $_POST["data_old"] ) ) {
                        foreach ( $_POST["data_old"] as $key => $val ) :
                                $key = $key + 1;
                                $key = $key - 1;
                                if ( is_int ( $key ) ) {
                                   if ( empty ( $_POST["data_old"][$key] ) ) {
                                      $query = "DELETE FROM `". SQL_TABLE_MY_ARCH_CONTENT ."` WHERE `id` = ". $key ." AND `user_id` = ". $security->user["userid"] ." AND `label_id` = ". $record["id"] ." LIMIT 1";
                                      $sql->query ( $query, "print_error_and_exit" );
                                   } else {
                                      $query = "UPDATE `". SQL_TABLE_MY_ARCH_CONTENT ."`
                                                SET
                                                       `content` = '". mysql_escape_string ( $_POST["data_old"][$key] ) ."'
                                                WHERE
                                                       `id` = ". $key ." AND `user_id` = ". $security->user["userid"] ." AND `label_id` = ". $record["id"] ."
                                                LIMIT 1
                                      ";
                                      $sql->query ( $query, "print_error_and_exit" );
                                   }
                                }
                        endforeach;
                     }

                     if ( $record["label"] != $_POST["label"] or $record["description"] != $_POST["description"] ) {
                        if ( empty ( $_POST["label"] ) ) {
                           $query = "DELETE FROM `". SQL_TABLE_MY_ARCH_INFO ."` WHERE `id` = ". $record["id"] ." AND `user_id` = ". $security->user["userid"] ." LIMIT 1";
                           $sql->query ( $query, "print_error_and_exit" );
                        } else {
                           $query = "UPDATE `". SQL_TABLE_MY_ARCH_INFO ."`
                                     SET
                                            `label` = '". mysql_escape_string ( $_POST["label"] ) ."',
                                            `description` = '". mysql_escape_string ( $_POST["description"] ) ."'
                                     WHERE
                                            `id` = ". $record["id"] ." AND `user_id` = ". $security->user["userid"] ."
                                     LIMIT 1
                           ";
                           $sql->query ( $query, "print_error_and_exit" );
                        }
                     }
                     
                     if ( isset ( $_POST["data_new"] ) and !empty ( $_POST["data_new"] ) ) {
                        $query = "INSERT INTO `". SQL_TABLE_MY_ARCH_CONTENT ."`
                                  VALUES (
                                              '',
                                              '". $record["id"] ."',
                                              '". mysql_escape_string ( $_POST["data_new"] ) ."',
                                              '". $security->user["userid"] ."',
                                              '". mysql_escape_string ( $security->user["username"] ) ."',
                                              '". date ( "Y-m-d H:i:s", time( ) ) ."'
                                  )
                        ";
                        $sql->query ( $query, "print_error_and_exit" );
                     }
                     
                     header ( "Location: http://". getenv ( "HTTP_HOST" ) ."/". $_GET["input"]["razdel_url"] ."/". $_GET["input"]["kategoria_url"] ."/". $_GET["input"]["element_id"] .".html" );
                  }
                  
                  $query = "SELECT `id`, `content` FROM `". SQL_TABLE_MY_ARCH_CONTENT ."` WHERE `label_id` = ". $_GET["input"]["element_id"] ." AND `user_id` = ". $security->user["userid"] ." ORDER BY `id` ASC";
                  $data = $sql->query ( $query, "print_error_and_exit" );

                  $result .= "<form method=\"POST\">
                              <input type=\"HIDDEN\" name=\"action\" value=\"edit_data\">
                  ";
                  $result .= "<center class=por>Запись : <br><input type=\"TEXT\" name=\"label\" class=\"button1\" value=\"". htmlspecialchars ( $record["label"], ENT_QUOTES ) ."\"></center>";
                  $result .= "<center class=por>Описание : <br><textarea class=\"button1\" name=\"description\">". htmlspecialchars ( $record["description"], ENT_QUOTES ) ."</textarea></center><br>";
                  if ( mysql_num_rows ( $data ) !== 0 ) {
                     $result .= "<center class=porr>Все данные :</center>";
                  } else {
                     $result .= "<center class=porr>У вас нет данных в этой записи, хотите добавить?</center>";
                  }

                  while ( $ddt = mysql_fetch_assoc ( $data ) ) :
                        $result .= "
                                    <textarea class=\"button2\" name=\"data_old[". $ddt["id"] ."]\">". htmlspecialchars ( $ddt["content"], ENT_QUOTES ) ."</textarea><br><br>\n
                        ";
                  endwhile;

                  $result .= "
                              <br>
                              <b class=por>Новые данные</b>
                              <textarea name=\"data_new\" class=\"button\" style=\"width : 100%; background : white;\"></textarea><br><br>
                              <center><input type=\"SUBMIT\" class=\"button\" value=\" Изменить | Добавить \" style=\"width : 220px;\"></center>
                              </form>
                  ";
                  
               }
               
               return $result;
               
      }

      function obrabotka ( ) {
               global $security, $template, $structure;
               $result = "";
               if ( !$security->auth ) {
                  $result .= "<center class=porr>Авторизируйтесь пожалуйста.<Br><b class=por>Эта страница доступна только авторизованным пользователям</b></center>";
               } else {
                  if ( isset ( $_GET["input"]["element_id"] ) and isset ( $_GET["input"]["kategoria_url"] ) and $_GET["input"]["kategoria_url"] == "record" ) {
                     $result .= $this->show_user_content ( );
                     
                  } elseif ( isset ( $_GET["input"]["kategoria_url"] ) and $_GET["input"]["kategoria_url"] == "record" ) {
                     $result .= $this->show_user_labels ( );
                  } else {
                     $result .= $this->show_user_labels ( );
                  }
               }
               $template->edit ( $structure["content"], $result );
               
      }

}

?>