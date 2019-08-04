<?php

         /* ������ � ��������� */

         $data["title"] = HEAD_DEFAULT_TITLE;
         $data["keyws"] = HEAD_DESCRIPTION_KEYS ." ". HEAD_DEFAULT_TITLE;

         $security->user_check ( );
         switch ( $_GET["input"]["razdel_url"] ) :

                case "index" :
                     $template->edit ( $structure["content"], "�������" );
                break;

                case "news" :
                     include_once MODULES_NEWS;
                     $news = new NEWS;
                     $news->obrabotka ( );

                     $data["title"] .= $news->data["title"];
                     $data["keyws"] .= $news->data["keyws"];
                break;

                case "articles" :
                     include_once MODULES_ARTICLES;
                     $articles = new ARTICLES;
                     $articles->obrabotka ( );

                     $data["title"] .= $articles->data["title"];
                     $data["keyws"] .= $articles->data["keyws"];
                break;

                case "team" :

                     if ( isset ( $_GET["input"]["kategoria_url"] ) and $_GET["input"]["kategoria_url"] == "members" ) {

                        include_once MODULES_MEMBERS;
                        $members = new MEMBERS;
                        $members->obrabotka ( );

                        $data["title"] .= $members->data["title"];
                        $data["keyws"] .= $members->data["keyws"];
                     } else {
                        $security->error_pages ( 404 );
                     }
                break;

                case "forum" :
                     header ( "Location: http://". getenv ( "HTTP_HOST" ) ."/forum/" );
                break;

                case "local_logs" :
                     if ( $security->auth ) {
                        $security->permissions_check ( );
                        if ( is_array ( $security->usergroup ) ) {
                           if ( $security->usergroup["usergroupid"] != VBULLETIN_ADMIN_GROUP_ID ) {
                              $security->error_pages ( 404 );
                           } else {
                              $template->edit ( $structure["content"], $local_sniffer->show_select_and_last_logs ( ) );
                           }
                        } else {
                           $security->error_pages ( 404 );
                        }
                     } else {
                        $security->error_pages ( 404 );
                     }

                     $data["title"] .= "[ Site Log's ].:.";
                     $data["keyws"] .= "[ Site Log's ].:.";
                break;

                case "sniffer" :
                     $template->edit ( $structure["content"], $global_sniffer->show_last_logs ( ) );

                     $data["title"] .= "[ Sniffer ].:. ��������� �������";
                     $data["keyws"] .= "[ Sniffer ].:. ��������� �������";
                break;

                case "sniffer_info" :
                     $template->edit ( $structure["content"], $global_sniffer->show_sniffer_info ( ) );

                     $data["title"] .= "[ Sniffer ].:. On-Line �������, ������� ���� ����� �����������. ��������";
                     $data["keyws"] .= "[ Sniffer ].:. On-Line �������, ������� ���� ����� �����������. ��������";
                break;

                case "login" :
                     if ( isset ( $_POST["action"] ) and $_POST["action"] === "login" and isset ( $_POST["username"] ) and !empty ( $_POST["username"] ) and isset ( $_POST["password"] ) and !empty ( $_POST["password"] ) and isset ( $_POST["submit"] ) ) {
                        $security->user_login_check ( $_POST["username"], $_POST["password"] );
                        if ( $security->auth ) {
                           $template->edit ( $structure["content"], "<center class=porr>���� �������� ������!</center>" );
                           header ( "Location: http://". getenv ( "HTTP_HOST" ) ."/". $_GET["input"]["razdel_url"] .".html" );
                        } else {
                           $template->edit ( $structure["content"], "<center class=porr>���� �� ��������!</center>" );
                        }
                     } else {
                        if ( $security->auth ) {
                           $template->edit ( $structure["content"], "<center class=porr>���� �������� ������!</center>" );
                        } else {
                           $template->edit ( $structure["content"], "<center class=porr>������� ������ ��� �����</center>" );
                        }
                     }

                     $data["title"] .= "[ ���� ].:.";
                     $data["keyws"] .= "[ ���� ].:.";
                break;

                case "logout" :
                     if ( $security->auth ) {
                        $security->logout (  );
                        $template->edit ( $structure["content"], "<center class=porr> ����� ������� ��������! </center>" );
                     } else {
                        $template->edit ( $structure["content"], "<center class=porr>��� ������ ��� ����� �����</center>" );
                     }

                     $data["title"] .= "[ ����� ].:.";
                     $data["keyws"] .= "[ ����� ].:.";
                break;

                case "search" :

                     include_once MODULES_SEARCH;
                     $search = new SEARCH;
                     $template->edit ( $structure["content"], $search->obrabotka ( ) );
                     $data["title"] .= "[ ����� ].:.";
                     $data["keyws"] .= "[ ����� ].:.";
                break;

                case "service" :

                     include_once MODULES_SERVICE;
                     $service = new SERVICE;
                     $template->edit ( $structure["content"], $service->show_info ( ) );

                     $data["title"] .= "[ ������ ].:.";
                     $data["keyws"] .= "[ ������ ].:.";
                break;
                
                case "my_archive" :

                     include_once MODULES_MY_ARCHIVE;
                     $spynet = new MY_ARCHIVE;
                     $spynet->obrabotka ( );
                     
                     $data["title"] .= "[ ��� ����� ].:.";
                     $data["keyws"] .= "[ ��� ����� ].:.";
                break;

                case "web_tools" :

                     include_once MODULES_WEB_TOOLS;
                     $web_tools = new WEB_TOOLS;
                     $web_tools->obrabotka ( );

                     $data["title"] .= $web_tools->data["title"];
                     $data["keyws"] .= $web_tools->data["keyws"];
                break;

                default :
                     case "error_pages" :
                          $security->error_pages ( isset ( $_GET["error"] ) ? $_GET["error"] : 404 );
                          $_GET["input"]["razdel_url"] = "error_pages";

                          $data["title"] .= "[ ������ ].:.";
                          $data["keyws"] .= "[ ������ ].:.";
                     break;
//                break;
         endswitch;

         #######################
         /* �������� �������� */
         $content_name = isset ( $_GET["input"]["razdel_url"] ) ? ucwords ( $_GET["input"]["razdel_url"] ) : "Main_Page";
         $template->edit ( $structure["content_name"]                          , $content_name );
         $template->edit ( $structure["content_header"]                        , INF_CONTENT_HEADER_NAME );
         #######################

         #####################################################
         /* �������� ��������� � �������� ����� ��� ������� */
         $template->edit ( $structure["head"]["title"]                         , htmlspecialchars ( $data["title"], ENT_QUOTES ) );
         $template->edit ( $structure["head"]["keywords"]                      , htmlspecialchars ( $data["keyws"], ENT_QUOTES ) );
         #####################################################


?>