<?php

#######################################################################################################################################################

if ( get_magic_quotes_gpc ( ) ) {                                                                                     # Если включено экранирование кавычек и прочего, то убераем бэкслеши
   $_GET    = array_map( "stripslashes_deep", $_GET );
   $_POST   = array_map( "stripslashes_deep", $_POST );
   $_COOKIE = array_map( "stripslashes_deep", $_COOKIE );
}

#####################################
/* ..:: Warning!!! DO NOT EDIT ::..*/
define ( "IN_LOCK_TEAM_ENGINE"       , 1 );                                                                           # Проверка на запуск через index.php
define ( "ROOT_DIR"                  , "./" );                                                                        # Дирректория где лежит index.php
define ( "IP"                        , ip_addr ( ) );                                                                 # IP адрес пользователя
define ( "SHOW_ERRORS"               , ( IP === "127.0.0.1" ) ? 1 : 1 );                                              # Показывать ошибки или нет.
define ( "PHP"                       , php_ver ( ) );                                                                 # Узнаем версию PHP

if ( PHP >= 5 ) {
   error_reporting ( SHOW_ERRORS === 1 ? E_ALL | E_STRICT : 0 );
} else {
   error_reporting ( SHOW_ERRORS === 1 ? E_ALL : 0 );
}

if ( ini_get ( "display_errors" ) !== 1 ) {
   ini_set ( "display_errors", SHOW_ERRORS === 1 ? 1 : 0 );
}

set_error_handler ( "log_errors" );                                                                                   # Своя функция регистрации ошибок
set_magic_quotes_runtime ( 0 );                                                                                       # Экранировать ли спец. символы или нет...
#####################################


#####################################
/* ..:: Настройка переменных ::..  */
define ( "HEAD_LANGUAGE"             , "RU" );                                                                        # Язык сайта
define ( "HEAD_DEFAULT_CHARSET"      , "windows-1251" );                                                              # Кодировка сайта
define ( "HEAD_DEFAULT_TITLE"        , ".:.[ LOCK-TEAM ].:." );                                                       # Заголовок на всех страницах + для каждой страницы свой
define ( "HEAD_DESCRIPTION_KEYS"     , "WSR, " );                                                                     # Ключевые слова сайта
define ( "HEAD_AUTHOR"               , "WSR" );                                                                       # Автор сайта
define ( "HEAD_ROBOTS_INDEX"         , "index,all" );                                                                 # Индексация
define ( "HEAD_ROBOTS_INDEX_REVISIT" , "10 days" );                                                                   # Дней до очередной индексации
define ( "HEAD_DESCRIPTION"          , "Сетевая безопасность, Hack and Security" );                                   # Описание сайта
#####################################

#####################################
/*   ..:: Настройка шаблона ::..   */
define ( "TEMPLATE_NAME"             , "lock-team" );                                                                 # Название шаблона (одновременно и папка в которой он находится)
define ( "TEMPLATE_DIR"              , "style/templates" );                                                           # Путь до дирректории с шаблонами
define ( "TEMPLATE_FULL_DIR"         , ROOT_DIR . TEMPLATE_DIR ."/". TEMPLATE_NAME );                                 # Полный путь до дирректории с данными шаблона
define ( "TEMPLATE_IMAGES_DIR"       , "/". TEMPLATE_DIR ."/". TEMPLATE_NAME ."/images" );                            # Папка с картинками данного шаблона
define ( "TEMPLATE_CSS_DIR"          , "/". TEMPLATE_DIR ."/". TEMPLATE_NAME ."/css" );                               # Папка с картинками данного шаблона
define ( "TEMPLATE_FAVICON"          , TEMPLATE_IMAGES_DIR ."/favicon.ico" );                                         # Иконка сайта
define ( "TEMPLATE_CSS"              , TEMPLATE_CSS_DIR ."/style.css" );                                              # Таблица стилей (CSS)
define ( "TEMPLATE_FADE_JS"          , TEMPLATE_CSS_DIR ."/fade.js" );
define ( "TEMPLATE_INDEX"            , TEMPLATE_FULL_DIR ."/index.tpl" );                                             # Главная страница шаблона
define ( "TEMPLATE_ARTICLES_ALL_R"   , TEMPLATE_FULL_DIR ."/articles_all_razdels.tpl" );                              # Страница всех разделов статей
define ( "TEMPLATE_ARTICLES_ONE_R"   , TEMPLATE_FULL_DIR ."/articles_one_razdel.tpl" );                               # Страница раздела из статей
define ( "TEMPLATE_ARTICLES"         , TEMPLATE_FULL_DIR ."/articles.tpl" );                                          # Страница статьи
define ( "TEMPLATE_NEWS_ALL_R"       , TEMPLATE_FULL_DIR ."/news_all_razdels.tpl" );                                  # Страница всех разделов новостей
define ( "TEMPLATE_NEWS_ONE_R"       , TEMPLATE_FULL_DIR ."/news_one_razdel.tpl" );                                   # Страница раздела из новостей
define ( "TEMPLATE_NEWS"             , TEMPLATE_FULL_DIR ."/news.tpl" );                                              # Страница новости
define ( "TEMPLATE_MEMBERS"          , TEMPLATE_FULL_DIR ."/members.tpl" );                                           # Страница члена группы
define ( "TEMPLATE_FORUMS_POSTS"     , TEMPLATE_FULL_DIR ."/forums_posts.tpl" );                                      # Страница последних сообщений с форума
#####################################

#####################################
/*    ..:: Настройка инфры ::..    */
define ( "INF_DEFAULT_STATUS"        , ".:.[ LOCK-TEAM ].:." );                                                       # Значение статустной строки по умолчанию

define ( "INF_MENU_LEFT_NAME"        , ".:.[ Navigation ].:." );                                                      # Значение заголовка левого навигационного меню
define ( "INF_MENU_FRIENDS_NAME"     , ".:.[ Friends ].:." );                                                         # Значение заголовка левого "friends" меню
define ( "INF_MENU_MISC_NAME"        , ".:.[ IRC ].:." );                                                             # Значение заголовка левого "misc" меню
define ( "INF_MENU_MEMBERS_NAME"     , ".:.[ Team ].:." );                                                            # Значение заголовка левого "Team" меню
define ( "INF_MENU_USER_INFO_NAME"   , ".:.[ Your Info ].:." );                                                       # Значение заголовка правого "web-tools" меню
define ( "INF_CONTENT_HEADER_NAME"   , ".:.[ Content ].:." );                                                         # Значение заголовка центрального меню
define ( "INF_FORUMS_POSTS_NAME"     , ".:.[ Forums Posts ].:." );                                                    # Значение заголовка центрального меню forums
define ( "INF_MENU_SEARCH_NAME"      , ".:.[ Search ].:." );                                                          # Значение заголовка правого "search" меню
define ( "INF_MENU_LOGIN_NAME"       , ".:.[ Login ].:." );                                                           # Значение заголовка правого "login" меню
define ( "INF_GLOBAL_S_NAME"         , ".:.[ Sniffer ].:." );                                                         # Значение заголовка правого "sniffer" меню
define ( "INF_MENU_COUNTER_NAME"     , ".:.[ Counter ].:." );                                                         # Значение заголовка правого "counter" меню
define ( "INF_MENU_STATISTICS_NAME"  , ".:.[ Statistics ].:." );                                                      # Значение заголовка правого "statistics" меню

define ( "INF_ARTICLES_ON_MAIN_SHOW" , 5 );                                                                           # Сколько статей показывать из каждого раздела на главной страничке
define ( "INF_NEWS_ON_MAIN_SHOW"     , 2 );                                                                           # Сколько новостей показывать из каждого раздела на главной страничке
define ( "INF_NEWS_PER_PAGE"         , 10 );                                                                           # Сколько новостей показывать из выбранного раздела на одной страничке
define ( "INF_FORUMS_POSTS"          , 8 );                                                                           # Сколько последних сообщений с форума показывать
define ( "INF_MENU_STR_LENGTH"       , 150 );                                                                         # Длинна названия меню/подменю

define ( "INF_COPYRIGHT"             , ".:.[ Copyright © <b class=porr>L0CK-TEAM</b>, 2005-". date ( "Y", time ( ) ) ." ].:." ); # Копирайт
define ( "INF_GEN_TIME_FORMAT"       , "%.2f" );                                                                      # Формат вывода времени генерации страницы (смотри мануал по sprintf)
#####################################

#####################################
/* ..:: Настройка includes'ов ::.. */
define ( "INCLUDE_DIR"               , ROOT_DIR ."includes/" );                                                       # Дирректория с Includes'ами
define ( "INCLUDE_DIR_FILE_PREFIX"   , INCLUDE_DIR ."includes_" );                                                    # Дирректория с главными файлами
define ( "INCLUDE_STRUCTURE"         , INCLUDE_DIR_FILE_PREFIX ."structure.php" );                                    # Структура сайта!
define ( "INCLUDE_INDEX_WORK"        , INCLUDE_DIR_FILE_PREFIX ."index.php" );                                        # Работа с контентом сайта!
#####################################

#####################################
/*   ..:: Настройка классов  ::..  */
define ( "CLASSES_DIR_FILE_PREFIX"   , INCLUDE_DIR ."classes_" );                                                     # Дирректория с классами
define ( "CLASSES_SQL"               , CLASSES_DIR_FILE_PREFIX ."sql.php" );                                          # Класс для работы с MySQL
define ( "CLASSES_MISC"              , CLASSES_DIR_FILE_PREFIX ."misc.php" );                                         # Класс для различных дополнительных функций
define ( "CLASSES_MENUS"             , CLASSES_DIR_FILE_PREFIX ."menus.php" );                                        # Класс для генерации навигации сайта
define ( "CLASSES_TITLE"             , CLASSES_DIR_FILE_PREFIX ."title.php" );                                        # Класс для генерации заголовков и ключевых слов для страниц
define ( "CLASSES_TEMPLATE"          , CLASSES_DIR_FILE_PREFIX ."template.php" );                                     # Класс для работы с шаблоном
define ( "CLASSES_SECURITY"          , CLASSES_DIR_FILE_PREFIX ."security.php" );                                     # Класс для работы с пользователями
#####################################

#####################################
/*  Настройка подключаемых модулей */
define ( "MODULES_DIR_FILE_PREFIX"   , INCLUDE_DIR ."modules_" );                                                     # Дирректория с модулями
define ( "MODULES_NEWS"              , MODULES_DIR_FILE_PREFIX ."news.php" );                                         # Модуль для работы с новостями
define ( "MODULES_ARTICLES"          , MODULES_DIR_FILE_PREFIX ."articles.php" );                                     # Модуль для работы со статьями
define ( "MODULES_WEB_TOOLS"         , MODULES_DIR_FILE_PREFIX ."web_tools.php" );                                    # Модуль для работы с web-tools
define ( "MODULES_MEMBERS"           , MODULES_DIR_FILE_PREFIX ."members.php" );                                      # Модуль для работы с членами комманды
define ( "MODULES_FORUMS_POSTS"      , MODULES_DIR_FILE_PREFIX ."forums_post.php" );                                  # Модуль для работы с постави с форума
define ( "MODULES_SEARCH"            , MODULES_DIR_FILE_PREFIX ."search.php" );                                       # Модуль для работы с поиском
define ( "MODULES_MY_ARCHIVE"        , MODULES_DIR_FILE_PREFIX ."my_archive.php" );                                   # Модуль для работы с My Archive
define ( "MODULES_SERVICE"           , MODULES_DIR_FILE_PREFIX ."service.php" );                                      # Модуль для работы с заявками
define ( "MODULES_GLOBAL_SNIFFER"    , MODULES_DIR_FILE_PREFIX ."global_sniffer.php" );                               # Модуль для работы с On-Line сниффером
define ( "MODULES_LOCAL_SNIFFER"     , ROOT_DIR ."local_sniffer/index.php" );                                         # Модуль для работы с сниффером для сайта
#####################################

#####################################
/*: Настройка кеширования/сжатия : */
define ( "CACHE_GZIP_COMPRESSION_ON" , ( strstr ( getenv ( "HTTP_ACCEPT_ENCODING" ), "gzip" ) !== false ) and ( extension_loaded ( "zlib" ) ) ); # Сжатие возможно на сервере и у пользователя???
define ( "CACHE_FILES_DIR"           , "./cache" );                                                                   # Директория для хранения кешированных страниц
define ( "CACHE_FILES_EXT"           , "cache" );                                                                     # Расширение у файлов кеша
define ( "CACHE_LOCAL_TIME"          , 0 );                                                                           # Время кеширования страниц на localhost'е
define ( "CACHE_WORLD_TIME"          , 0 );                                                                           # Время кеширования страниц во всемирной паутине
define ( "CACHE_FILE_FORMAT"         , CACHE_FILES_DIR ."/". md5 ( getenv ( "REQUEST_URI" ) ) .".". CACHE_FILES_EXT ); # Формат файла кеша
#####################################

#####################################
/* .: Данные на соединение с DB :. */
define ( "SQL_CONNECT_HOST"          , IP == "127.0.0.1" ? "localhost" : "localhost" );                               # MySQL сервер к которому конектимся!
define ( "SQL_CONNECT_USER"          , IP == "127.0.0.1" ? "root" : "lockteac_lock" );                                # Login для коннекта
define ( "SQL_CONNECT_PASS"          , IP == "127.0.0.1" ? "" : "forforum" );                                         # Password для коннекта
define ( "SQL_CONNECT_DATABASE"      , IP == "127.0.0.1" ? "vbulletin" : "lockteac_forum" );                          # Имя базы данных
#####################################

#####################################
/*  .: Данные для выборки инфры :. */
define ( "SQL_TABLE_PREFIX"          , "lock_team_" );                                                                # Префикс таблиц
define ( "SQL_TABLE_NEWS"            , SQL_TABLE_PREFIX ."news" );                                                    # Таблица со новостям
define ( "SQL_TABLE_NEWS_COMM"       , SQL_TABLE_PREFIX ."news_comments" );                                           # Таблица комментариев к новостям
define ( "SQL_TABLE_ARTICLES"        , SQL_TABLE_PREFIX ."articles" );                                                # Таблица со статьями
define ( "SQL_TABLE_ARTICLES_COMM"   , SQL_TABLE_PREFIX ."articles_comments" );                                       # Таблица комментариев к статьям
define ( "SQL_TABLE_LM_RAZDELS"      , SQL_TABLE_PREFIX ."menu_left_razdels" );                                       # Таблица с элементами левого меню (разделы)
define ( "SQL_TABLE_LM_KATEGORIES"   , SQL_TABLE_PREFIX ."menu_left_kategories" );                                    # Таблица с элементами левого меню (подразделы)
define ( "SQL_TABLE_WEB_TOOLS"       , SQL_TABLE_PREFIX ."web_tools" );                                               # Таблица с элементами web-tools меню
define ( "SQL_TABLE_FRIENDS"         , SQL_TABLE_PREFIX ."friends" );                                                 # Таблица друзей
define ( "SQL_TABLE_MEMBERS"         , SQL_TABLE_PREFIX ."members" );                                                 # Таблица членов группы
define ( "SQL_TABLE_USERS_LOGS"      , SQL_TABLE_PREFIX ."users_logs" );                                              # Таблица логов действий пользователей
define ( "SQL_TABLE_USERS_LOGINS"    , SQL_TABLE_PREFIX ."users_logins" );                                            # Таблица логов входов пользователей
define ( "SQL_TABLE_USERS_LOGOUTS"   , SQL_TABLE_PREFIX ."users_logouts" );                                           # Таблица логов выходов пользователей
define ( "SQL_TABLE_GLOBAL_SNIFFER"  , SQL_TABLE_PREFIX ."global_sniffer" );                                          # Таблица логов глобального сниффера
define ( "SQL_TABLE_LOCAL_SNIFFER"   , SQL_TABLE_PREFIX ."local_sniffer" );                                           # Таблица логов локального сниффера
define ( "SQL_TABLE_SERVICE_REQUEST" , SQL_TABLE_PREFIX ."service_request" );                                         # Таблица заявок о услугах
define ( "SQL_TABLE_MY_ARCH_INFO"    , SQL_TABLE_PREFIX ."my_archive_info" );                                         # Таблица инфры в My Archive
define ( "SQL_TABLE_MY_ARCH_CONTENT" , SQL_TABLE_PREFIX ."my_archive_content" );                                      # Таблица данных в My Archive
define ( "SQL_TABLE_STATISTICS"      , SQL_TABLE_PREFIX ."statistics" );                                              # Таблица данных статистики

define ( "VBULLETIN_TABLE_PREFIX"    , "vb_" );                                                                       # Префикс таблиц форума
define ( "VBULLETIN_COOKIE_USERID"   , "bbuserid" );                                                                  # Имя куки с ID пользователя
define ( "VBULLETIN_COOKIE_PASSWORD" , "bbpassword" );                                                                # Имя куки с паролем пользователя
define ( "VBULLETIN_ADMIN_GROUP"     , "Админы" );                                                                    # Имя группы администраторов
define ( "VBULLETIN_ADMIN_GROUP_ID"  , 6 );                                                                           # ID Группы администраторов
#####################################

#####################################
/* ..:: Настройка (check_bug) ::.. */
define ( "BAD_REQUEST_FILE"          , "./logs/bad_request.txt" );                                                    # Файл с данными о пользователе, который сделал неправильный запрос
define ( "BAD_REQUEST_REPORT_FORMAT" , time() ."¤". IP ."¤". getenv ( "REQUEST_URI" ) ."¤". getenv ( "HTTP_REFERER" ) ."¤". getenv ( "HTTP_USER_AGENT" ) ."¤\n" ); # Формат записи при неправильном запросе
define ( "BAD_TIME_LOG_FILE"         , "./logs/errors.txt" );                                                         # Пишем в файл возникающие ошибки!
#####################################

function php_ver ( ) {
         $ver = explode ( ".", PHP_VERSION );
         if ( sizeof ( $ver ) === 0 ) {
            exit ( "Неизвестная версия интерпретатора PHP" );
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

         $exp = "|¤|";
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
            die ( "\n<br>Вы зашли по неправильной ссылке, и получили ошибку при выполнении скрипта\n<br>(\n". $error_message ."\n)<br>-". $error_file ."<br>-". $error_line );
         } else {
            header ( "Location: http://". getenv ( "HTTP_HOST" ) ."/error_pages.html" );
         }
}

#######################################################################################################################################################

?>
