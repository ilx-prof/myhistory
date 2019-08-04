<?php

/*#*****************************************
=====#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#=====*
====#¤*******************************¤#====*
===#¤*|.............................|*¤#===*
==#¤*-|.            WSR            .|-*¤#==*
=#¤*--|.    SITE : MEGA : ENGINE   .|--*¤#=*
#¤*---|.    version : null-byte    .|---*¤#*
#¤*---|.     wsr@lock-team.com     .|---*¤#*
=#¤*--|.       ICQ : 918-318       .|--*¤#=*
==#¤*-|. http://www.lock-team.com  .|-*¤#==*
===#¤*|.............................|*¤#===*
====#¤*******************************¤#====*
=====#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#¤#=====*
*/#*****************************************

#############################################################
/* Так как у нас свой обработчик кеширования страниц, то   */
/* принудительно отключаем кеширование страниц у браузеров */
header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header ( "Cache-Control: no-cache, must-revalidate" );
header ( "Pragma: no-cache" );
header ( "Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT" );
#############################################################

#################################
/* Самый главный файл : КОНФИГ */
require_once "./config.php";
#################################

# На всякий случай, если повиснет Апач и пропустит кривой запрос, чистим входные данные!
if ( isset ( $_GET["input"] ) ) {
   foreach ( $_GET["input"] as $key => $value ) {
           $_GET["input"][$key] = mysql_escape_string ( htmlspecialchars ( $_GET["input"][$key], ENT_QUOTES ) );
   }
}

# Если зашли на главную страницу, то покажем новости
$_GET["input"]["razdel_url"] = isset ( $_GET["input"]["razdel_url"] ) ? $_GET["input"]["razdel_url"] : "news";

##########################
require_once CLASSES_MISC;
$misc = new MISC;
##########################

###################################################
/* Замеряем начальное значение "generation time" */
$execstart = $misc->mtime ();
###################################################

######################################################
/* Генерировать страничку заново или читать из кеша */
if ( IP === "127.0.0.1" ) {
   $cache_time = CACHE_LOCAL_TIME;
} else {
   $cache_time = CACHE_WORLD_TIME;
}

if ( ( time ( ) - ( file_exists ( CACHE_FILE_FORMAT ) ? filemtime( CACHE_FILE_FORMAT ) : 0 ) ) >= $cache_time ) {
######################################################

         #################################
         /* Включаем буферизацию вывода */
         ob_start ( );
         ob_implicit_flush ( 0 ); # Выводить данные из буфера придется вручную!
         #################################
         
         ######################################################
         /* Подключаем и создаем нужные переменные окружения */
         require_once CLASSES_SQL;            # Класс для работы с базой
         require_once CLASSES_MENUS;          # Класс для генерации меню
         require_once CLASSES_TEMPLATE;       # Класс для работы с шаблоном
         require_once CLASSES_SECURITY;       # Класс для работы с пользователями и страницами ошибок
         require_once INCLUDE_STRUCTURE;      # Структура шаблона
         require_once MODULES_FORUMS_POSTS;   # Модуль для вывода последних сообщений с форума
         require_once MODULES_LOCAL_SNIFFER;  # Модуль для создания логов посещения
         require_once MODULES_GLOBAL_SNIFFER; # Модуль для вывода последних записей в сниффере

         $sql            = new SQL;
         $menus          = new MENUS;
         $template       = new TEMPLATE;
         $security       = new SECURITY;
         $forums_posts   = new FORUMS_POSTS;
         $local_sniffer  = new LOCAL_SNIFFER;
         $global_sniffer = new GLOBAL_SNIFFER;
         ######################################################

         #######################################
         /* Коннектимся к MySQL и выбераем БД */
         $sql->server["host"]     = SQL_CONNECT_HOST;
         $sql->server["user"]     = SQL_CONNECT_USER;
         $sql->server["pass"]     = SQL_CONNECT_PASS;
         $sql->server["database"] = SQL_CONNECT_DATABASE;
         $sql->connect   ( "print_error_and_exit" );
         $sql->select_db ( "print_error_and_exit" );
         #######################################

         ##############################
         /* Пишем лог захода на сайт */
         $local_sniffer->add_log ( );
         ##############################
         
         ######################
         /* Загружаем шаблон */
         if ( $template->exists ( TEMPLATE_INDEX ) ) {
            $template  -> load ( );
            $menus     -> find_templates ( );
         } else {
            die ( "<center>Template is Missing!</center>" );
         }
         ######################

         ######################################
         /* <head> Заменяем значения </head> */
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
         /* Все что касается java-скриптов */
         $template->edit ( $structure["request_uri"]                           , getenv ( "REQUEST_URI" ) );
         $template->edit ( $structure["default_status"]                        , INF_DEFAULT_STATUS );
         $template->edit ( $structure["fade_js"]                               , TEMPLATE_FADE_JS );
         ####################################

         ############################################
         /* Вставляем левую менюшку ( Navigation ) */
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
         /* Вставляем ( Friends ) */
         $menus->generate_friends_menu ( );
         $template->edit ( $structure["friends_menu"]["razdel"]["header"]      , INF_MENU_FRIENDS_NAME );

         if ( isset ( $menus->replace["friends_menu_razdel_string"][0] ) and !empty ( $menus->replace["friends_menu_razdel_string"][0] ) ) {
            $template->edit ( $menus->replace["friends_menu_razdel_string"][0] , $menus->show_friends_menu ( ) );
         }
         ###########################

         ########################
         /* Вставляем ( Misc ) */
         $template->edit ( $structure["misc_menu"]["header"]                   , INF_MENU_MISC_NAME );
         $template->edit ( $structure["misc_menu"]["content"]                  , $menus->show_misc_menu ( ) );
         ########################

         ###########################
         /* Вставляем ( Members ) */
         $template->edit ( $structure["members_menu"]["header"]                , INF_MENU_MEMBERS_NAME );
         if ( isset ( $menus->replace["members_menu_string"][0] ) and !empty ( $menus->replace["members_menu_string"][0] ) ) {
            $template->edit ( $menus->replace["members_menu_string"][0]           , $menus->show_members_menu ( ) );
         }
         ###########################

         ########################################
         /* Заменяем информацию о пользователе */
         $res = $misc->browser ( );
         $template->edit ( $structure["info_header"]                           , INF_MENU_USER_INFO_NAME );
         $template->edit ( $structure["browser"]                               , $res["browser"] );
         $template->edit ( $structure["browser_version"]                       , htmlspecialchars ( $res["version"], ENT_QUOTES ) );
         $template->edit ( $structure["ip"]                                    , IP );
         $template->edit ( $structure["gzip"]                                  , ( CACHE_GZIP_COMPRESSION_ON ) ? "On" : "Off" );
         ########################################

################################################################################
         /* Работа с контентом сайта */
         require_once INCLUDE_INDEX_WORK;
################################################################################

         ############################################
         /* Вставляем последние сообщения с форума */
         $template->edit ( $structure["forums_posts"]["name"]                   , INF_FORUMS_POSTS_NAME );
         $template->edit ( $structure["forums_posts"]["module"]                 , $forums_posts->obrabotka ( ) );
         ############################################

         ##########################
         /* Вставляем ( Search ) */
         $template->edit ( $structure["search_menu"]["header"]                 , INF_MENU_SEARCH_NAME );
         $template->edit ( $structure["search_menu"]["content"]                , $menus->show_search_menu ( ) );
         ##########################

         ###################################
         /* Вставляем менюшку авторизации */
         $template->edit ( $structure["right_menu"]["login"]["name"]           , INF_MENU_LOGIN_NAME );
         $template->edit ( $structure["right_menu"]["login"]["content"]        , $menus->show_login_menu ( ) );
         ###################################

         ########################################
         /* Вставляем менюшку on-line сниффера */
         $template->edit ( $structure["right_menu"]["global_s"]["name"]        , INF_GLOBAL_S_NAME );
         $template->edit ( $structure["right_menu"]["global_s"]["content"]     , $menus->show_global_sniffer_menu ( ) );
         ########################################
         
         ##########################
         /* Вставляем ( Counter ) */
         $template->edit ( $structure["counter_menu"]["header"]                , INF_MENU_COUNTER_NAME );
         $template->edit ( $structure["counter_menu"]["content"]               , $menus->show_counter_menu ( ) );
         ##########################

         ##############################
         /* Вставляем ( Statistics ) */
         $template->edit ( $structure["statistics_menu"]["header"]             , INF_MENU_STATISTICS_NAME );
         $template->edit ( $structure["statistics_menu"]["content"]            , $menus->show_site_info_menu ( ) );
         ##############################

         #######################
         /* Заменяем копирайт */
         $template->edit ( $structure["copyright"]                             , INF_COPYRIGHT );
         #######################

         ########################################
         /* Заменяем время генерации странички */
         $template->edit ( $structure["generation_time"]                       , sprintf( INF_GEN_TIME_FORMAT , ( $misc->mtime ( ) - $execstart ) ) );
         ########################################

         ########################################################
         /* Заменяем количество произведенных запросов к MySQL */
         $template->edit ( $structure["queries_used"]                          , $sql->queries );
         ########################################################

         ##################################
         /* Закрываем соединение с MySQL */
         $sql->close ( );
         ##################################

         #############################################
         /* Пишем буферизированные данные в файл    */
         /* для дальнейшего быстрого доступа к      */
         /* запрошенной страничке в ближайшее время */
         $fp = fopen ( CACHE_FILE_FORMAT, "w+" );
         flock ( $fp, LOCK_EX );
         fputs ( $fp, $template->index );
         flock ( $fp, LOCK_UN );
         fclose ( $fp );
         #############################################

         ######################################################
         # Наконец то используем функцию вывода данных на экран
         $template->show ( );
         # Но мы ничего не видим, так как включена буферизация!
         ######################################################

         #####################################################
         /* Используем сжатие данных или нет??? Yes or No ? */
         /* Конечно если браузер поддерживает сжатие (gzip) */
         /* И в PHP установлен соответсвующий модуль (ZLIB) */
         $content = ob_get_clean ( );
         if ( CACHE_GZIP_COMPRESSION_ON ) {
            header ( "Content-Encoding: gzip" );
            print gzencode ( $content, 4 ); # 9 - Максимальный уровень сжатия (0 - без сжатия)!
         } else {
            print $content;
            exit;
         }
         #####################################################
         
} else {
      ##########################################
      /* Выводим запрашиваемые данные из кеша */
      $content = file_get_contents ( CACHE_FILE_FORMAT );
      if ( CACHE_GZIP_COMPRESSION_ON ) {
         header ( "Content-Encoding: gzip" );
         print gzencode ( $content, 4 ); # 9 - Максимальный уровень сжатия (0 - без сжатия)!
      } else {
         print $content;
         exit;
      }
      ##########################################
}

?>