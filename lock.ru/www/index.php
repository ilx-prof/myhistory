<?php

/*#*****************************************
=====#�#�#�#�#�#�#�#�#�#�#�#�#�#�#�#�#=====*
====#�*******************************�#====*
===#�*|.............................|*�#===*
==#�*-|.            WSR            .|-*�#==*
=#�*--|.    SITE : MEGA : ENGINE   .|--*�#=*
#�*---|.    version : null-byte    .|---*�#*
#�*---|.     wsr@lock-team.com     .|---*�#*
=#�*--|.       ICQ : 918-318       .|--*�#=*
==#�*-|. http://www.lock-team.com  .|-*�#==*
===#�*|.............................|*�#===*
====#�*******************************�#====*
=====#�#�#�#�#�#�#�#�#�#�#�#�#�#�#�#�#=====*
*/#*****************************************

#############################################################
/* ��� ��� � ��� ���� ���������� ����������� �������, ��   */
/* ������������� ��������� ����������� ������� � ��������� */
header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header ( "Cache-Control: no-cache, must-revalidate" );
header ( "Pragma: no-cache" );
header ( "Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT" );
#############################################################

#################################
/* ����� ������� ���� : ������ */
require_once "./config.php";
#################################

# �� ������ ������, ���� �������� ���� � ��������� ������ ������, ������ ������� ������!
if ( isset ( $_GET["input"] ) ) {
   foreach ( $_GET["input"] as $key => $value ) {
           $_GET["input"][$key] = mysql_escape_string ( htmlspecialchars ( $_GET["input"][$key], ENT_QUOTES ) );
   }
}

# ���� ����� �� ������� ��������, �� ������� �������
$_GET["input"]["razdel_url"] = isset ( $_GET["input"]["razdel_url"] ) ? $_GET["input"]["razdel_url"] : "news";

##########################
require_once CLASSES_MISC;
$misc = new MISC;
##########################

###################################################
/* �������� ��������� �������� "generation time" */
$execstart = $misc->mtime ();
###################################################

######################################################
/* ������������ ��������� ������ ��� ������ �� ���� */
if ( IP === "127.0.0.1" ) {
   $cache_time = CACHE_LOCAL_TIME;
} else {
   $cache_time = CACHE_WORLD_TIME;
}

if ( ( time ( ) - ( file_exists ( CACHE_FILE_FORMAT ) ? filemtime( CACHE_FILE_FORMAT ) : 0 ) ) >= $cache_time ) {
######################################################

         #################################
         /* �������� ����������� ������ */
         ob_start ( );
         ob_implicit_flush ( 0 ); # �������� ������ �� ������ �������� �������!
         #################################
         
         ######################################################
         /* ���������� � ������� ������ ���������� ��������� */
         require_once CLASSES_SQL;            # ����� ��� ������ � �����
         require_once CLASSES_MENUS;          # ����� ��� ��������� ����
         require_once CLASSES_TEMPLATE;       # ����� ��� ������ � ��������
         require_once CLASSES_SECURITY;       # ����� ��� ������ � �������������� � ���������� ������
         require_once INCLUDE_STRUCTURE;      # ��������� �������
         require_once MODULES_FORUMS_POSTS;   # ������ ��� ������ ��������� ��������� � ������
         require_once MODULES_LOCAL_SNIFFER;  # ������ ��� �������� ����� ���������
         require_once MODULES_GLOBAL_SNIFFER; # ������ ��� ������ ��������� ������� � ��������

         $sql            = new SQL;
         $menus          = new MENUS;
         $template       = new TEMPLATE;
         $security       = new SECURITY;
         $forums_posts   = new FORUMS_POSTS;
         $local_sniffer  = new LOCAL_SNIFFER;
         $global_sniffer = new GLOBAL_SNIFFER;
         ######################################################

         #######################################
         /* ����������� � MySQL � �������� �� */
         $sql->server["host"]     = SQL_CONNECT_HOST;
         $sql->server["user"]     = SQL_CONNECT_USER;
         $sql->server["pass"]     = SQL_CONNECT_PASS;
         $sql->server["database"] = SQL_CONNECT_DATABASE;
         $sql->connect   ( "print_error_and_exit" );
         $sql->select_db ( "print_error_and_exit" );
         #######################################

         ##############################
         /* ����� ��� ������ �� ���� */
         $local_sniffer->add_log ( );
         ##############################
         
         ######################
         /* ��������� ������ */
         if ( $template->exists ( TEMPLATE_INDEX ) ) {
            $template  -> load ( );
            $menus     -> find_templates ( );
         } else {
            die ( "<center>Template is Missing!</center>" );
         }
         ######################

         ######################################
         /* <head> �������� �������� </head> */
         $template->edit ( $structure["html_language"]                         , HEAD_LANGUAGE );
         $template->edit ( $structure["head"]["default_charset"]               , HEAD_DEFAULT_CHARSET );
         $template->edit ( $structure["head"]["description"]                   , HEAD_DESCRIPTION );
         $template->edit ( $structure["head"]["author"]                        , HEAD_AUTHOR );
         $template->edit ( $structure["head"]["robots"]                        , HEAD_ROBOTS_INDEX );
         $template->edit ( $structure["head"]["revisit"]                       , HEAD_ROBOTS_INDEX_REVISIT );
         $template->edit ( $structure["head"]["stylesheet"]                    , TEMPLATE_CSS );
         $template->edit ( $structure["head"]["shortcut_icon"]                 , TEMPLATE_FAVICON );
         ######################################

         ####################################
         /* ��� ��� �������� java-�������� */
         $template->edit ( $structure["request_uri"]                           , getenv ( "REQUEST_URI" ) );
         $template->edit ( $structure["default_status"]                        , INF_DEFAULT_STATUS );
         $template->edit ( $structure["fade_js"]                               , TEMPLATE_FADE_JS );
         ####################################

         ############################################
         /* ��������� ����� ������� ( Navigation ) */
         $menus->generate_left_menu ( );
         $template->edit ( $structure["left_menu"]["razdel"]["header"]         , INF_MENU_LEFT_NAME );

         if ( isset ( $menus->replace["left_menu_razdel_string"][0] ) and !empty ( $menus->replace["left_menu_razdel_string"][0] ) ) {
            $template->edit ( $menus->replace["left_menu_razdel_string"][0]    , "" );
         }
         if ( isset ( $menus->replace["left_menu_kategoria_string"][0] ) and !empty ( $menus->replace["left_menu_kategoria_string"][0] ) ) {
            $template->edit ( $menus->replace["left_menu_kategoria_string"][0] , $menus->show_left_menu ( ) );
         }
         ############################################

         ###########################
         /* ��������� ( Friends ) */
         $menus->generate_friends_menu ( );
         $template->edit ( $structure["friends_menu"]["razdel"]["header"]      , INF_MENU_FRIENDS_NAME );

         if ( isset ( $menus->replace["friends_menu_razdel_string"][0] ) and !empty ( $menus->replace["friends_menu_razdel_string"][0] ) ) {
            $template->edit ( $menus->replace["friends_menu_razdel_string"][0] , $menus->show_friends_menu ( ) );
         }
         ###########################

         ########################
         /* ��������� ( Misc ) */
         $template->edit ( $structure["misc_menu"]["header"]                   , INF_MENU_MISC_NAME );
         $template->edit ( $structure["misc_menu"]["content"]                  , $menus->show_misc_menu ( ) );
         ########################

         ###########################
         /* ��������� ( Members ) */
         $template->edit ( $structure["members_menu"]["header"]                , INF_MENU_MEMBERS_NAME );
         if ( isset ( $menus->replace["members_menu_string"][0] ) and !empty ( $menus->replace["members_menu_string"][0] ) ) {
            $template->edit ( $menus->replace["members_menu_string"][0]           , $menus->show_members_menu ( ) );
         }
         ###########################

         ########################################
         /* �������� ���������� � ������������ */
         $res = $misc->browser ( );
         $template->edit ( $structure["info_header"]                           , INF_MENU_USER_INFO_NAME );
         $template->edit ( $structure["browser"]                               , $res["browser"] );
         $template->edit ( $structure["browser_version"]                       , htmlspecialchars ( $res["version"], ENT_QUOTES ) );
         $template->edit ( $structure["ip"]                                    , IP );
         $template->edit ( $structure["gzip"]                                  , ( CACHE_GZIP_COMPRESSION_ON ) ? "On" : "Off" );
         ########################################

################################################################################
         /* ������ � ��������� ����� */
         require_once INCLUDE_INDEX_WORK;
################################################################################

         ############################################
         /* ��������� ��������� ��������� � ������ */
         $template->edit ( $structure["forums_posts"]["name"]                   , INF_FORUMS_POSTS_NAME );
         $template->edit ( $structure["forums_posts"]["module"]                 , $forums_posts->obrabotka ( ) );
         ############################################

         ##########################
         /* ��������� ( Search ) */
         $template->edit ( $structure["search_menu"]["header"]                 , INF_MENU_SEARCH_NAME );
         $template->edit ( $structure["search_menu"]["content"]                , $menus->show_search_menu ( ) );
         ##########################

         ###################################
         /* ��������� ������� ����������� */
         $template->edit ( $structure["right_menu"]["login"]["name"]           , INF_MENU_LOGIN_NAME );
         $template->edit ( $structure["right_menu"]["login"]["content"]        , $menus->show_login_menu ( ) );
         ###################################

         ########################################
         /* ��������� ������� on-line �������� */
         $template->edit ( $structure["right_menu"]["global_s"]["name"]        , INF_GLOBAL_S_NAME );
         $template->edit ( $structure["right_menu"]["global_s"]["content"]     , $menus->show_global_sniffer_menu ( ) );
         ########################################
         
         ##########################
         /* ��������� ( Counter ) */
         $template->edit ( $structure["counter_menu"]["header"]                , INF_MENU_COUNTER_NAME );
         $template->edit ( $structure["counter_menu"]["content"]               , $menus->show_counter_menu ( ) );
         ##########################

         ##############################
         /* ��������� ( Statistics ) */
         $template->edit ( $structure["statistics_menu"]["header"]             , INF_MENU_STATISTICS_NAME );
         $template->edit ( $structure["statistics_menu"]["content"]            , $menus->show_site_info_menu ( ) );
         ##############################

         #######################
         /* �������� �������� */
         $template->edit ( $structure["copyright"]                             , INF_COPYRIGHT );
         #######################

         ########################################
         /* �������� ����� ��������� ��������� */
         $template->edit ( $structure["generation_time"]                       , sprintf( INF_GEN_TIME_FORMAT , ( $misc->mtime ( ) - $execstart ) ) );
         ########################################

         ########################################################
         /* �������� ���������� ������������� �������� � MySQL */
         $template->edit ( $structure["queries_used"]                          , $sql->queries );
         ########################################################

         ##################################
         /* ��������� ���������� � MySQL */
         $sql->close ( );
         ##################################

         #############################################
         /* ����� ���������������� ������ � ����    */
         /* ��� ����������� �������� ������� �      */
         /* ����������� ��������� � ��������� ����� */
         $fp = fopen ( CACHE_FILE_FORMAT, "w+" );
         flock ( $fp, LOCK_EX );
         fputs ( $fp, $template->index );
         flock ( $fp, LOCK_UN );
         fclose ( $fp );
         #############################################

         ######################################################
         # ������� �� ���������� ������� ������ ������ �� �����
         $template->show ( );
         # �� �� ������ �� �����, ��� ��� �������� �����������!
         ######################################################

         #####################################################
         /* ���������� ������ ������ ��� ���??? Yes or No ? */
         /* ������� ���� ������� ������������ ������ (gzip) */
         /* � � PHP ���������� �������������� ������ (ZLIB) */
         $content = ob_get_clean ( );
         if ( CACHE_GZIP_COMPRESSION_ON ) {
            header ( "Content-Encoding: gzip" );
            print gzencode ( $content, 4 ); # 9 - ������������ ������� ������ (0 - ��� ������)!
         } else {
            print $content;
            exit;
         }
         #####################################################
         
} else {
      ##########################################
      /* ������� ������������� ������ �� ���� */
      $content = file_get_contents ( CACHE_FILE_FORMAT );
      if ( CACHE_GZIP_COMPRESSION_ON ) {
         header ( "Content-Encoding: gzip" );
         print gzencode ( $content, 4 ); # 9 - ������������ ������� ������ (0 - ��� ������)!
      } else {
         print $content;
         exit;
      }
      ##########################################
}

?>