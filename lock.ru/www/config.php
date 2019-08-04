<?php

#######################################################################################################################################################

if ( get_magic_quotes_gpc ( ) ) {                                                                                     # ���� �������� ������������� ������� � �������, �� ������� ��������
   $_GET    = array_map( "stripslashes_deep", $_GET );
   $_POST   = array_map( "stripslashes_deep", $_POST );
   $_COOKIE = array_map( "stripslashes_deep", $_COOKIE );
}

#####################################
/* ..:: Warning!!! DO NOT EDIT ::..*/
define ( "IN_LOCK_TEAM_ENGINE"       , 1 );                                                                           # �������� �� ������ ����� index.php
define ( "ROOT_DIR"                  , "./" );                                                                        # ����������� ��� ����� index.php
define ( "IP"                        , ip_addr ( ) );                                                                 # IP ����� ������������
define ( "SHOW_ERRORS"               , ( IP === "127.0.0.1" ) ? 1 : 1 );                                              # ���������� ������ ��� ���.
define ( "PHP"                       , php_ver ( ) );                                                                 # ������ ������ PHP

if ( PHP >= 5 ) {
   error_reporting ( SHOW_ERRORS === 1 ? E_ALL | E_STRICT : 0 );
} else {
   error_reporting ( SHOW_ERRORS === 1 ? E_ALL : 0 );
}

if ( ini_get ( "display_errors" ) !== 1 ) {
   ini_set ( "display_errors", SHOW_ERRORS === 1 ? 1 : 0 );
}

set_error_handler ( "log_errors" );                                                                                   # ���� ������� ����������� ������
set_magic_quotes_runtime ( 0 );                                                                                       # ������������ �� ����. ������� ��� ���...
#####################################


#####################################
/* ..:: ��������� ���������� ::..  */
define ( "HEAD_LANGUAGE"             , "RU" );                                                                        # ���� �����
define ( "HEAD_DEFAULT_CHARSET"      , "windows-1251" );                                                              # ��������� �����
define ( "HEAD_DEFAULT_TITLE"        , ".:.[ LOCK-TEAM ].:." );                                                       # ��������� �� ���� ��������� + ��� ������ �������� ����
define ( "HEAD_DESCRIPTION_KEYS"     , "WSR, " );                                                                     # �������� ����� �����
define ( "HEAD_AUTHOR"               , "WSR" );                                                                       # ����� �����
define ( "HEAD_ROBOTS_INDEX"         , "index,all" );                                                                 # ����������
define ( "HEAD_ROBOTS_INDEX_REVISIT" , "10 days" );                                                                   # ���� �� ��������� ����������
define ( "HEAD_DESCRIPTION"          , "������� ������������, Hack and Security" );                                   # �������� �����
#####################################

#####################################
/*   ..:: ��������� ������� ::..   */
define ( "TEMPLATE_NAME"             , "lock-team" );                                                                 # �������� ������� (������������ � ����� � ������� �� ���������)
define ( "TEMPLATE_DIR"              , "style/templates" );                                                           # ���� �� ����������� � ���������
define ( "TEMPLATE_FULL_DIR"         , ROOT_DIR . TEMPLATE_DIR ."/". TEMPLATE_NAME );                                 # ������ ���� �� ����������� � ������� �������
define ( "TEMPLATE_IMAGES_DIR"       , "/". TEMPLATE_DIR ."/". TEMPLATE_NAME ."/images" );                            # ����� � ���������� ������� �������
define ( "TEMPLATE_CSS_DIR"          , "/". TEMPLATE_DIR ."/". TEMPLATE_NAME ."/css" );                               # ����� � ���������� ������� �������
define ( "TEMPLATE_FAVICON"          , TEMPLATE_IMAGES_DIR ."/favicon.ico" );                                         # ������ �����
define ( "TEMPLATE_CSS"              , TEMPLATE_CSS_DIR ."/style.css" );                                              # ������� ������ (CSS)
define ( "TEMPLATE_FADE_JS"          , TEMPLATE_CSS_DIR ."/fade.js" );
define ( "TEMPLATE_INDEX"            , TEMPLATE_FULL_DIR ."/index.tpl" );                                             # ������� �������� �������
define ( "TEMPLATE_ARTICLES_ALL_R"   , TEMPLATE_FULL_DIR ."/articles_all_razdels.tpl" );                              # �������� ���� �������� ������
define ( "TEMPLATE_ARTICLES_ONE_R"   , TEMPLATE_FULL_DIR ."/articles_one_razdel.tpl" );                               # �������� ������� �� ������
define ( "TEMPLATE_ARTICLES"         , TEMPLATE_FULL_DIR ."/articles.tpl" );                                          # �������� ������
define ( "TEMPLATE_NEWS_ALL_R"       , TEMPLATE_FULL_DIR ."/news_all_razdels.tpl" );                                  # �������� ���� �������� ��������
define ( "TEMPLATE_NEWS_ONE_R"       , TEMPLATE_FULL_DIR ."/news_one_razdel.tpl" );                                   # �������� ������� �� ��������
define ( "TEMPLATE_NEWS"             , TEMPLATE_FULL_DIR ."/news.tpl" );                                              # �������� �������
define ( "TEMPLATE_MEMBERS"          , TEMPLATE_FULL_DIR ."/members.tpl" );                                           # �������� ����� ������
define ( "TEMPLATE_FORUMS_POSTS"     , TEMPLATE_FULL_DIR ."/forums_posts.tpl" );                                      # �������� ��������� ��������� � ������
#####################################

#####################################
/*    ..:: ��������� ����� ::..    */
define ( "INF_DEFAULT_STATUS"        , ".:.[ LOCK-TEAM ].:." );                                                       # �������� ���������� ������ �� ���������

define ( "INF_MENU_LEFT_NAME"        , ".:.[ Navigation ].:." );                                                      # �������� ��������� ������ �������������� ����
define ( "INF_MENU_FRIENDS_NAME"     , ".:.[ Friends ].:." );                                                         # �������� ��������� ������ "friends" ����
define ( "INF_MENU_MISC_NAME"        , ".:.[ IRC ].:." );                                                             # �������� ��������� ������ "misc" ����
define ( "INF_MENU_MEMBERS_NAME"     , ".:.[ Team ].:." );                                                            # �������� ��������� ������ "Team" ����
define ( "INF_MENU_USER_INFO_NAME"   , ".:.[ Your Info ].:." );                                                       # �������� ��������� ������� "web-tools" ����
define ( "INF_CONTENT_HEADER_NAME"   , ".:.[ Content ].:." );                                                         # �������� ��������� ������������ ����
define ( "INF_FORUMS_POSTS_NAME"     , ".:.[ Forums Posts ].:." );                                                    # �������� ��������� ������������ ���� forums
define ( "INF_MENU_SEARCH_NAME"      , ".:.[ Search ].:." );                                                          # �������� ��������� ������� "search" ����
define ( "INF_MENU_LOGIN_NAME"       , ".:.[ Login ].:." );                                                           # �������� ��������� ������� "login" ����
define ( "INF_GLOBAL_S_NAME"         , ".:.[ Sniffer ].:." );                                                         # �������� ��������� ������� "sniffer" ����
define ( "INF_MENU_COUNTER_NAME"     , ".:.[ Counter ].:." );                                                         # �������� ��������� ������� "counter" ����
define ( "INF_MENU_STATISTICS_NAME"  , ".:.[ Statistics ].:." );                                                      # �������� ��������� ������� "statistics" ����

define ( "INF_ARTICLES_ON_MAIN_SHOW" , 5 );                                                                           # ������� ������ ���������� �� ������� ������� �� ������� ���������
define ( "INF_NEWS_ON_MAIN_SHOW"     , 2 );                                                                           # ������� �������� ���������� �� ������� ������� �� ������� ���������
define ( "INF_NEWS_PER_PAGE"         , 10 );                                                                           # ������� �������� ���������� �� ���������� ������� �� ����� ���������
define ( "INF_FORUMS_POSTS"          , 8 );                                                                           # ������� ��������� ��������� � ������ ����������
define ( "INF_MENU_STR_LENGTH"       , 150 );                                                                         # ������ �������� ����/�������

define ( "INF_COPYRIGHT"             , ".:.[ Copyright � <b class=porr>L0CK-TEAM</b>, 2005-". date ( "Y", time ( ) ) ." ].:." ); # ��������
define ( "INF_GEN_TIME_FORMAT"       , "%.2f" );                                                                      # ������ ������ ������� ��������� �������� (������ ������ �� sprintf)
#####################################

#####################################
/* ..:: ��������� includes'�� ::.. */
define ( "INCLUDE_DIR"               , ROOT_DIR ."includes/" );                                                       # ����������� � Includes'���
define ( "INCLUDE_DIR_FILE_PREFIX"   , INCLUDE_DIR ."includes_" );                                                    # ����������� � �������� �������
define ( "INCLUDE_STRUCTURE"         , INCLUDE_DIR_FILE_PREFIX ."structure.php" );                                    # ��������� �����!
define ( "INCLUDE_INDEX_WORK"        , INCLUDE_DIR_FILE_PREFIX ."index.php" );                                        # ������ � ��������� �����!
#####################################

#####################################
/*   ..:: ��������� �������  ::..  */
define ( "CLASSES_DIR_FILE_PREFIX"   , INCLUDE_DIR ."classes_" );                                                     # ����������� � ��������
define ( "CLASSES_SQL"               , CLASSES_DIR_FILE_PREFIX ."sql.php" );                                          # ����� ��� ������ � MySQL
define ( "CLASSES_MISC"              , CLASSES_DIR_FILE_PREFIX ."misc.php" );                                         # ����� ��� ��������� �������������� �������
define ( "CLASSES_MENUS"             , CLASSES_DIR_FILE_PREFIX ."menus.php" );                                        # ����� ��� ��������� ��������� �����
define ( "CLASSES_TITLE"             , CLASSES_DIR_FILE_PREFIX ."title.php" );                                        # ����� ��� ��������� ���������� � �������� ���� ��� �������
define ( "CLASSES_TEMPLATE"          , CLASSES_DIR_FILE_PREFIX ."template.php" );                                     # ����� ��� ������ � ��������
define ( "CLASSES_SECURITY"          , CLASSES_DIR_FILE_PREFIX ."security.php" );                                     # ����� ��� ������ � ��������������
#####################################

#####################################
/*  ��������� ������������ ������� */
define ( "MODULES_DIR_FILE_PREFIX"   , INCLUDE_DIR ."modules_" );                                                     # ����������� � ��������
define ( "MODULES_NEWS"              , MODULES_DIR_FILE_PREFIX ."news.php" );                                         # ������ ��� ������ � ���������
define ( "MODULES_ARTICLES"          , MODULES_DIR_FILE_PREFIX ."articles.php" );                                     # ������ ��� ������ �� ��������
define ( "MODULES_WEB_TOOLS"         , MODULES_DIR_FILE_PREFIX ."web_tools.php" );                                    # ������ ��� ������ � web-tools
define ( "MODULES_MEMBERS"           , MODULES_DIR_FILE_PREFIX ."members.php" );                                      # ������ ��� ������ � ������� ��������
define ( "MODULES_FORUMS_POSTS"      , MODULES_DIR_FILE_PREFIX ."forums_post.php" );                                  # ������ ��� ������ � ������� � ������
define ( "MODULES_SEARCH"            , MODULES_DIR_FILE_PREFIX ."search.php" );                                       # ������ ��� ������ � �������
define ( "MODULES_MY_ARCHIVE"        , MODULES_DIR_FILE_PREFIX ."my_archive.php" );                                   # ������ ��� ������ � My Archive
define ( "MODULES_SERVICE"           , MODULES_DIR_FILE_PREFIX ."service.php" );                                      # ������ ��� ������ � ��������
define ( "MODULES_GLOBAL_SNIFFER"    , MODULES_DIR_FILE_PREFIX ."global_sniffer.php" );                               # ������ ��� ������ � On-Line ���������
define ( "MODULES_LOCAL_SNIFFER"     , ROOT_DIR ."local_sniffer/index.php" );                                         # ������ ��� ������ � ��������� ��� �����
#####################################

#####################################
/*: ��������� �����������/������ : */
define ( "CACHE_GZIP_COMPRESSION_ON" , ( strstr ( getenv ( "HTTP_ACCEPT_ENCODING" ), "gzip" ) !== false ) and ( extension_loaded ( "zlib" ) ) ); # ������ �������� �� ������� � � ������������???
define ( "CACHE_FILES_DIR"           , "./cache" );                                                                   # ���������� ��� �������� ������������ �������
define ( "CACHE_FILES_EXT"           , "cache" );                                                                     # ���������� � ������ ����
define ( "CACHE_LOCAL_TIME"          , 0 );                                                                           # ����� ����������� ������� �� localhost'�
define ( "CACHE_WORLD_TIME"          , 0 );                                                                           # ����� ����������� ������� �� ��������� �������
define ( "CACHE_FILE_FORMAT"         , CACHE_FILES_DIR ."/". md5 ( getenv ( "REQUEST_URI" ) ) .".". CACHE_FILES_EXT ); # ������ ����� ����
#####################################

#####################################
/* .: ������ �� ���������� � DB :. */
define ( "SQL_CONNECT_HOST"          , IP == "127.0.0.1" ? "localhost" : "localhost" );                               # MySQL ������ � �������� ����������!
define ( "SQL_CONNECT_USER"          , IP == "127.0.0.1" ? "root" : "lockteac_lock" );                                # Login ��� ��������
define ( "SQL_CONNECT_PASS"          , IP == "127.0.0.1" ? "" : "forforum" );                                         # Password ��� ��������
define ( "SQL_CONNECT_DATABASE"      , IP == "127.0.0.1" ? "vbulletin" : "lockteac_forum" );                          # ��� ���� ������
#####################################

#####################################
/*  .: ������ ��� ������� ����� :. */
define ( "SQL_TABLE_PREFIX"          , "lock_team_" );                                                                # ������� ������
define ( "SQL_TABLE_NEWS"            , SQL_TABLE_PREFIX ."news" );                                                    # ������� �� ��������
define ( "SQL_TABLE_NEWS_COMM"       , SQL_TABLE_PREFIX ."news_comments" );                                           # ������� ������������ � ��������
define ( "SQL_TABLE_ARTICLES"        , SQL_TABLE_PREFIX ."articles" );                                                # ������� �� ��������
define ( "SQL_TABLE_ARTICLES_COMM"   , SQL_TABLE_PREFIX ."articles_comments" );                                       # ������� ������������ � �������
define ( "SQL_TABLE_LM_RAZDELS"      , SQL_TABLE_PREFIX ."menu_left_razdels" );                                       # ������� � ���������� ������ ���� (�������)
define ( "SQL_TABLE_LM_KATEGORIES"   , SQL_TABLE_PREFIX ."menu_left_kategories" );                                    # ������� � ���������� ������ ���� (����������)
define ( "SQL_TABLE_WEB_TOOLS"       , SQL_TABLE_PREFIX ."web_tools" );                                               # ������� � ���������� web-tools ����
define ( "SQL_TABLE_FRIENDS"         , SQL_TABLE_PREFIX ."friends" );                                                 # ������� ������
define ( "SQL_TABLE_MEMBERS"         , SQL_TABLE_PREFIX ."members" );                                                 # ������� ������ ������
define ( "SQL_TABLE_USERS_LOGS"      , SQL_TABLE_PREFIX ."users_logs" );                                              # ������� ����� �������� �������������
define ( "SQL_TABLE_USERS_LOGINS"    , SQL_TABLE_PREFIX ."users_logins" );                                            # ������� ����� ������ �������������
define ( "SQL_TABLE_USERS_LOGOUTS"   , SQL_TABLE_PREFIX ."users_logouts" );                                           # ������� ����� ������� �������������
define ( "SQL_TABLE_GLOBAL_SNIFFER"  , SQL_TABLE_PREFIX ."global_sniffer" );                                          # ������� ����� ����������� ��������
define ( "SQL_TABLE_LOCAL_SNIFFER"   , SQL_TABLE_PREFIX ."local_sniffer" );                                           # ������� ����� ���������� ��������
define ( "SQL_TABLE_SERVICE_REQUEST" , SQL_TABLE_PREFIX ."service_request" );                                         # ������� ������ � �������
define ( "SQL_TABLE_MY_ARCH_INFO"    , SQL_TABLE_PREFIX ."my_archive_info" );                                         # ������� ����� � My Archive
define ( "SQL_TABLE_MY_ARCH_CONTENT" , SQL_TABLE_PREFIX ."my_archive_content" );                                      # ������� ������ � My Archive
define ( "SQL_TABLE_STATISTICS"      , SQL_TABLE_PREFIX ."statistics" );                                              # ������� ������ ����������

define ( "VBULLETIN_TABLE_PREFIX"    , "vb_" );                                                                       # ������� ������ ������
define ( "VBULLETIN_COOKIE_USERID"   , "bbuserid" );                                                                  # ��� ���� � ID ������������
define ( "VBULLETIN_COOKIE_PASSWORD" , "bbpassword" );                                                                # ��� ���� � ������� ������������
define ( "VBULLETIN_ADMIN_GROUP"     , "������" );                                                                    # ��� ������ ���������������
define ( "VBULLETIN_ADMIN_GROUP_ID"  , 6 );                                                                           # ID ������ ���������������
#####################################

#####################################
/* ..:: ��������� (check_bug) ::.. */
define ( "BAD_REQUEST_FILE"          , "./logs/bad_request.txt" );                                                    # ���� � ������� � ������������, ������� ������ ������������ ������
define ( "BAD_REQUEST_REPORT_FORMAT" , time() ."�". IP ."�". getenv ( "REQUEST_URI" ) ."�". getenv ( "HTTP_REFERER" ) ."�". getenv ( "HTTP_USER_AGENT" ) ."�\n" ); # ������ ������ ��� ������������ �������
define ( "BAD_TIME_LOG_FILE"         , "./logs/errors.txt" );                                                         # ����� � ���� ����������� ������!
#####################################

function php_ver ( ) {
         $ver = explode ( ".", PHP_VERSION );
         if ( sizeof ( $ver ) === 0 ) {
            exit ( "����������� ������ �������������� PHP" );
         } else {
            return $ver[0];
         }
}

function stripslashes_deep ( $value ) {
         $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
         return $value;
}

function ip_addr ( ) {
         if ( $ip = getenv ( "HTTP_CLIENT_IP" ) ) {
            return (string) $ip;
         }

         if ( $ip = getenv ( "HTTP_X_FORWARDED_FOR" ) ) {

            if ( $ip == '' || $ip == "unknown" ) {
               $ip = getenv ( "REMOTE_ADDR" );
            }
            
            return (string) $ip;
            
         }

         if ( $ip = getenv ( "REMOTE_ADDR" ) ) {
            return (string) $ip;
         }
}

function log_errors ( $error_code, $error_message, $error_file, $error_line, $error_content ) {

         ob_start ();
         ob_implicit_flush ( 0 );
         print_r ( getenv ( "HTTP_GET_VARS" ) );
         $get_vars = ob_get_contents ();
         print_r ( getenv ( "HTTP_POST_VARS" ) );
         $post_vars = ob_get_contents ();
         print_r ( getenv ( "HTTP_COOKIE_VARS" ) );
         $cookie_vars = ob_get_contents ();
         print_r ( $_REQUEST );
         $request = ob_get_contents ();
         ob_end_clean ();

         $exp = "|�|";
         $error_string  = time()                          . $exp;
         $error_string .= $error_code                     . $exp;
         $error_string .= $error_file                     . $exp;
         $error_string .= $error_line                     . $exp;
         $error_string .= $error_message                  . $exp;
         $error_string .= @$error_content["php_errormsg"] . $exp;
         $error_string .= base64_encode ( $request )      . $exp;
         $error_string .= base64_encode ( $get_vars )     . $exp;
         $error_string .= base64_encode ( $post_vars )    . $exp;
         $error_string .= base64_encode ( $cookie_vars )  . $exp;
         $error_string .= "\r\n";

         $fp = fopen ( BAD_TIME_LOG_FILE, "a+" );
         flock  ( $fp, LOCK_EX );
         fputs  ( $fp, $error_string );
         flock  ( $fp, LOCK_UN );
         fclose ( $fp );
         
         if ( SHOW_ERRORS === 1 ) {
            die ( "\n<br>�� ����� �� ������������ ������, � �������� ������ ��� ���������� �������\n<br>(\n". $error_message ."\n)<br>-". $error_file ."<br>-". $error_line );
         } else {
            header ( "Location: http://". getenv ( "HTTP_HOST" ) ."/error_pages.html" );
         }
}

#######################################################################################################################################################

?>
