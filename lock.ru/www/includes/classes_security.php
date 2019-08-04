<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class SECURITY {
      var $user       = null;
      var $usergroup  = null;
      var $auth       = FALSE;

      function user_login_check ( $username, $password ) {
               global $sql;

               $this->auth = FALSE;

               $query = "SELECT
                               `userid`,
                               `usergroupid`,
                               `membergroupids`,
                               `username`,
                               `password`,
                               `salt`
                         FROM
                               `". VBULLETIN_TABLE_PREFIX ."user`
                         WHERE
                               `username` = '". mysql_escape_string ( htmlspecialchars ( $username, ENT_QUOTES ) ) ."'
               ";

               $user = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

               if ( !empty ( $user["username"] ) ) {
                  if ( md5 ( md5 ( $password ) . $user["salt"] ) === $user["password"] ) {
                     $this->user = $user;
                     $this->auth = TRUE;

                     $query = "INSERT INTO
                                          `". SQL_TABLE_USERS_LOGINS ."`
                               VALUES (
                                       '',
                                       '". $user["userid"] ."',
                                       '". $user["username"] ."',
                                       '". IP ."',
                                       '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                               )
                     ";
                     $sql->query ( $query, "print_error_and_exit" );
                     
                     setcookie ( VBULLETIN_COOKIE_USERID, $user["userid"], time()+60*60*24*30, "/" );
                     setcookie ( VBULLETIN_COOKIE_PASSWORD, md5 ( $user["password"] ), time()+60*60*24*30, "/" );

                  } else {
                     $this->auth = FALSE;
                  }
               } else {
                  $this->auth = FALSE;
               }
               
      }
      
      function logout ( ) {
               global $sql;
               if ( $this->auth ) {
                  $query = "INSERT INTO
                                       `". SQL_TABLE_USERS_LOGOUTS ."`
                            VALUES (
                                    '',
                                    '". $this->user["userid"] ."',
                                    '". $this->user["username"] ."',
                                    '". IP ."',
                                    '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                            )
                  ";
                  $sql->query ( $query, "print_error_and_exit" );
                  setcookie ( VBULLETIN_COOKIE_USERID, "", time()-60*60*24*30, "/" );
                  setcookie ( VBULLETIN_COOKIE_PASSWORD, "", time()-60*60*24*30, "/" );
                  $this->user = null;
                  $this->usergroup = null;
                  $this->auth = FALSE;
               }
      }
      
      function user_check ( ) {
               global $sql;

               if ( !$this->auth and isset ( $_COOKIE[VBULLETIN_COOKIE_USERID] ) and isset ( $_COOKIE[VBULLETIN_COOKIE_PASSWORD] ) and !empty ( $_COOKIE[VBULLETIN_COOKIE_USERID] ) and !empty ( $_COOKIE[VBULLETIN_COOKIE_PASSWORD] ) and is_numeric ( $_COOKIE[VBULLETIN_COOKIE_USERID] ) ) {
               
                  $query = "SELECT
                                  *
                            FROM
                                  `". VBULLETIN_TABLE_PREFIX ."user`
                            WHERE
                                  `userid` = '". mysql_escape_string ( $_COOKIE[VBULLETIN_COOKIE_USERID] ) ."'
                  ";

                  $user = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

                  if ( !empty ( $user["username"] ) ) {
                     if ( $_COOKIE[VBULLETIN_COOKIE_PASSWORD] === md5 ( $user["password"] ) ) {
                        $this->user = $user;
                        $this->auth = TRUE;
                     } else {
                       $this->auth = FALSE;
                     }
                  } else {
                     $this->auth = FALSE;
                  }
               } else {
                  $this->auth = FALSE;
               }

      }
      
      function permissions_check ( ) {
               global $sql;
               
               if ( $this->auth ) {
               
                  $query = "SELECT
                                  *
                            FROM
                                  `". VBULLETIN_TABLE_PREFIX ."usergroup`
                            WHERE
                                  `usergroupid` = ". $this->user["usergroupid"] ."
                  ";
                  
                  $this->usergroup = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               }
      }


      
      function error_pages ( $error_code ) {
               global $template, $structure;
               switch ( $error_code ) :

                      case 400 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             Your browser (or proxy) sent a request that this server could not understand.
                                                                     </center>
                           " );
                      break;
                      case 401 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             This server could not verify that you are authorized to access the URL ". htmlspecialchars ( getenv ( "HTTP_REFERER" ), ENT_QUOTES ) .".<br>
                                                                             You either supplied the wrong credentials (e.g., bad password), or your browser doesn't understand how to supply the credentials required.<Br>
                                                                             <br>
                                                                             In case you are allowed to request the document, please check your user-id and password and try again.
                                                                     </center>
                           " );
                      break;
                      case 403 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             You don't have permission to access the requested object.<br>
                                                                             It is either read-protected or not readable by the server.
                                                                     </center>
                           " );
                      break;
                      case 405 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             You don't have permission to access the requested object.<br>
                                                                             It is either read-protected or not readable by the server.
                                                                     </center>
                           " );
                      break;
                      case 408 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The server closed the network connection because the browser didn't finish the request within the specified time.
                                                                     </center>
                           " );
                      break;
                      case 410 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The requested URL is no longer available on this server and there is no forwarding address.<br>
                                                                             Please inform the author of the <a href=\"". htmlspecialchars ( getenv ( "HTTP_REFERER" ), ENT_QUOTES ) ."\">referring page</a> that the link is outdated.<br>
                                                                             If you followed a link from a foreign page, please contact the author of this page.
                                                                     </center>
                           " );
                      break;
                      case 411 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             A request with the method requires a valid <code>Content-Length</code> header.
                                                                     </center>
                           " );
                      break;
                      case 412 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The precondition on the request for the URL failed positive evaluation.
                                                                     </center>
                           " );
                      break;
                      case 413 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The method does not allow the data transmitted, or the data volume exceeds the capacity limit.
                                                                     </center>
                           " );
                      break;
                      case 414 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The length of the requested URL exceeds the capacity limit for this server. The request cannot be processed.
                                                                     </center>
                           " );
                      break;
                      case 415 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The server does not support the media type transmitted in the request.
                                                                     </center>
                           " );
                      break;
                      case 500 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The server encountered an internal error and was unable to complete your request.<br>
                                                                             Either the server is overloaded or there was an error in a CGI script.
                                                                     </center>
                           " );
                      break;
                      case 501 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The server does not support the action requested by the browser.
                                                                     </center>
                           " );
                      break;
                      case 502 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The proxy server received an invalid response from an upstream server.
                                                                     </center>
                           " );
                      break;
                      case 503 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             The server is temporarily unable to service your request due to maintenance downtime or capacity problems.<br>
                                                                             Please try again later.
                                                                     </center>
                           " );
                      break;
                      case 506 :
                           $template->edit ( $structure["content"], "
                                                                     <center class=porr>
                                                                             A variant for the requested entity is itself a negotiable resource.<Br>
                                                                             Access not possible.
                                                                     </center>
                           " );
                      break;
                      default :
                              case 404 :
                                   $template->edit ( $structure["content"], "<center class=porr>»звините, но запрашиваема€ вами страничка не найдена!</center><center class=por>¬озможно вы набрали неправильный адрес.<br>“ак же возможно, что вы зашли по неправильной ссылке.<br><br>¬св€зи с тем, что \"движек\" сайта был обновлЄн и ссылки теперь немного другие,<br>поисчите информацию в соответствующих разделах сайта.</center>" );
                              break;
                      break;
               endswitch;
      }
      
}

?>