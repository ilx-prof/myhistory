<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class LOCAL_SNIFFER {

      var $date = array ( );

      function add_log ( ) {
               global $sql;

               $this->data["remote_addr"]     = IP;
               $this->data["user_agent"]      = getenv ( "HTTP_USER_AGENT" );
               $this->data["curtime"]         = date ( "Y-m-d H:i:s", time ( ) );
               $this->data["remote_host"]     = getenv ( "REMOTE_HOST" );
               $this->data["http_referer"]    = getenv ( "HTTP_REFERER" );
               $this->data["request_uri"]     = getenv ( "REQUEST_URI" );

               if ( empty ( $this->data["http_user_agent"] ) ) { $this->data["http_user_agent"] = "Unkwnown"; }
               if ( empty ( $this->data["remote_host"] ) )     { $this->data["remote_host"] = "Unknown"; }
               if ( empty ( $this->data["http_referer"] ) )    { $this->data["http_referer"] = "No Referer"; }
               if ( empty ( $this->data["request_uri"] ) )     { $this->data["request_uri"] = "Unknown"; }


               $query = "INSERT INTO
                                    `". SQL_TABLE_LOCAL_SNIFFER ."`
                         VALUES (
                                    '',
                                    '". mysql_escape_string ( $this->data["remote_addr"] ) ."',
                                    '". mysql_escape_string ( base64_encode ( $this->data["user_agent"] ) ) ."',
                                    '". mysql_escape_string ( base64_encode ( $this->data["remote_host"] ) ) ."',
                                    '". mysql_escape_string ( base64_encode ( $this->data["http_referer"] ) ) ."',
                                    '". mysql_escape_string ( base64_encode ( $this->data["request_uri"] ) ) ."',
                                    '". $this->data["curtime"] ."'
                         )
               ";
               $sql->query ( $query, "print_error_and_exit" );

      }

      function show_select_and_last_logs ( ) {
               global $sql;

               if ( isset ( $_POST["input"]["kolvo"] ) ) {
                  $_POST["input"]["kolvo"]++;
                  $_POST["input"]["kolvo"]--;
                  if ( is_int ( $_POST["input"]["kolvo"] ) ) {
                     $lim = $_POST["input"]["kolvo"];
                  } else {
                     $lim = 20;
                  }
               } else {
                  $lim = 20;
               }
               
               if ( isset ( $_POST["input"]["ip_address"] ) ) {
                     $ip_address = ip2long ( $_POST["input"]["ip_address"] );
                     if ( $ip_address == -1 || $ip_address === FALSE ) {
                        $ip_address = "";
                     }
               } else {
                  $ip_address = "";
               }
               
               
               $result = "
                          <table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">
                          <form method=\"POST\">
                          <tr>
                              <td><center class=porr>IP : <br><input type=\"CHECKBOX\" name=\"input[ip]\" ". ( ( isset ( $_POST["input"]["ip"] ) and $_POST["input"]["ip"] ) ? "checked" : "" ) ."></center></td>
                              <td><center class=porr>Date : <br><input type=\"CHECKBOX\" name=\"input[date]\" ". ( ( isset ( $_POST["input"]["date"] ) and $_POST["input"]["date"] ) ? "checked" : "" ) ."></center></td>
                              <td><center class=porr>Referer : <br><input type=\"CHECKBOX\" name=\"input[referer]\" ". ( ( !isset ( $_POST["submit"] ) or isset ( $_POST["input"]["referer"] ) and $_POST["input"]["referer"] ) ? "checked" : "" ) ."></center></td>
                              <td><center class=porr>Request : <br><input type=\"CHECKBOX\" name=\"input[request_uri]\" ". ( ( !isset ( $_POST["submit"] ) or isset ( $_POST["input"]["request_uri"] ) and $_POST["input"]["request_uri"] ) ? "checked" : "" ) ."></center></td>
                              <td><center class=porr>User-Agent : <br><input type=\"CHECKBOX\" name=\"input[user_agent]\" ". ( ( isset ( $_POST["input"]["user_agent"] ) and $_POST["input"]["user_agent"] ) ? "checked" : "" ) ."></center></td>
                              <td><center class=porr>Remote-Host : <br><input type=\"CHECKBOX\" name=\"input[remote_host]\" ". ( ( isset ( $_POST["input"]["remote_host"] ) and $_POST["input"]["remote_host"] ) ? "checked" : "" ) ."></center></td>
                          </tr>
                          <tr>
                              <td><b class=porr>Записей : </b><br><input type=\"TEXT\" class=\"button\" name=\"input[kolvo]\" value=\"". $lim ."\" style=\"width : 50px; text-align : center;\"></td>
                              <td><b class=porr>Выбор по IP : </b><br><input type=\"TEXT\" class=\"button\" name=\"input[ip_address]\" value=\"". long2ip ( $ip_address ) ."\" text-align : center;\"></td>
                              <td align=\"center\"><b class=porr>За сегодня : </b><br><input type=\"CHECKBOX\" class=\"button\" name=\"input[today]\" ". ( ( !isset ( $_POST["submit"] ) or isset ( $_POST["input"]["today"] ) and $_POST["input"]["today"] ) ? "checked" : "" ) ."></td>
                              <td colspan=\"3\" valign=\"bottom\">
                                  <input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Обновить\" style=\"width : 100%\">
                              </td>
                          </tr>
                          </form>
                          </table>
               ";


               $true = TRUE;
               if ( $true === TRUE ) {

                  $result .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">";

                  if ( !isset ( $_POST["input"]["today"] ) or ( $_POST["input"]["today"] == FALSE ) ) {
                     $str = ( $ip_address != "" ) ? " WHERE `ip_address` = '". long2ip ( $ip_address ) ."'" : "";
                     $query = "SELECT * FROM `". SQL_TABLE_LOCAL_SNIFFER ."` ". $str ." ORDER BY `id` DESC LIMIT ". $lim ."";
                  } else {
                     $query = "SELECT * FROM `". SQL_TABLE_LOCAL_SNIFFER ."` WHERE DATE(`create_time`) = '". date ( "Y-m-d", time ( ) ) ."'";
                  }
                  
                  $data = $sql->query ( $query, "print_error_and_exit" );
                  while ( $log = mysql_fetch_assoc ( $data ) ) :

                        list ( $date, $time ) = explode ( " ", $log["create_time"] );
                        if ( $date == date ( "Y-m-d" , time ( ) ) ) {
                           $style = "style=\"background : #F9F9F9\"";
                        } else {
                           $style = "";
                        }

                        $result .= "
                                    <tr ". $style .">
                                        <td>". ( ( isset ( $_POST["input"]["ip"] ) and $_POST["input"]["ip"] ) ? $log["ip_address"] : "" ) ."</td>
                                        <td>". ( ( isset ( $_POST["input"]["date"] ) and $_POST["input"]["date"] ) ? $log["create_time"] : "" ) ."</td>
                                        <td>". ( ( isset ( $_POST["input"]["referer"] ) and $_POST["input"]["referer"] ) ? urldecode ( base64_decode ( $log["referer"] ) ) : "" ) ."</td>
                                        <td>". ( ( isset ( $_POST["input"]["request_uri"] ) and $_POST["input"]["request_uri"] ) ? @urldecode ( @base64_decode ( $log["request_uri"] ) ) : "" ) ."</td>
                                        <td>". ( ( isset ( $_POST["input"]["user_agent"] ) and $_POST["input"]["user_agent"] ) ? urldecode ( base64_decode ( $log["user_agent"] ) ) : "" ) ."</td>
                                        <td>". ( ( isset ( $_POST["input"]["remote_host"] ) and $_POST["input"]["remote_host"] ) ?  urldecode ( base64_decode ( $log["remote_host"] ) ) : "" ) ."</td>
                                    </tr>
                        ";
                     
                  endwhile;


                  $result .= "</table>";
               }

               return $result;

      }

}
?>