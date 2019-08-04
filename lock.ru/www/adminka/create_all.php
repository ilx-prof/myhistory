<html>
<head>
      <meta HTTP-EQUIV="Content-Type" Content="text-html; charset=windows-1251">
      <title>Lock-Team Admin Panel</title>
      <link rel="stylesheet" type="text/css" href="/style/templates/lock-team/css/style.css">
      <link rel="shortcut icon" href="/style/templates/lock-team/images/favicon.ico">
</head>
<body marginheight="20" marginwidth="20" leftmargin="20" rightmargin="20" topmargin="20" bottommargin="20">

<?php

require_once "../config.php" ;
require_once "../". CLASSES_SQL;
require_once "../". CLASSES_SECURITY;

$sql = new SQL;
$sql->server["host"]     = SQL_CONNECT_HOST;
$sql->server["user"]     = SQL_CONNECT_USER;
$sql->server["pass"]     = SQL_CONNECT_PASS;
$sql->server["database"] = SQL_CONNECT_DATABASE;
$sql->connect ( "print_error_and_exit" );
$sql->select_db ( "print_error_and_exit" );

$security = new SECURITY;
$security->user_check ( );

if ( $security->auth ) {
  $security->permissions_check ( );

  if ( is_array ( $security->usergroup ) ) {
     if ( $security->usergroup["usergroupid"] != VBULLETIN_ADMIN_GROUP_ID ) {
        exit ( "By" );
     }
  } else {
     exit ( );
  }
} else {
  exit ( );
}

      function create_all ( ) {
               global $sql;
               $sql->server["database"] = SQL_CONNECT_DATABASE;

               ##########################
               /* Создание базы данных */
               $query = "CREATE DATABASE `". $sql->server["database"] ."`;";
               $sql->query ( $query, "return_error" );
               if ( $sql->error ) {
                  print "<b class=porr>База данных по видимому уже создана...(". $sql->error_message .")</b><br>";
                  if ( !$sql->db_selected ) $sql->select_db ( "print_error" );
               } else {
                  print "<b class=porr>База данных успешно создана!</b><br>";
                  if ( !$sql->db_selected ) $sql->select_db ( "print_error" );
               }
               ##########################

               ###########################################
               /* Создание таблицы разделов левого меню */
               $query = "CREATE TABLE `". SQL_TABLE_LM_RAZDELS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `url` TEXT,
                                      `title` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `order` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица разделов левого меню по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица разделов левого меню успешно создана!</b><br>";
               ###########################################

               ############################################
               /* Создание таблицы категорий левого меню */
               $query = "CREATE TABLE `". SQL_TABLE_LM_KATEGORIES ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `razdel_id` INT(10),
                                      `url` TEXT,
                                      `title` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `order` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица категорий левого меню по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица категорий левого меню успешно создана!</b><br>";
               ############################################

               #############################
               /* Создание таблицы друзей */
               $query = "CREATE TABLE `". SQL_TABLE_FRIENDS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `link` TEXT,
                                      `title` TEXT,
                                      `description` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `order` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица \"друзей\" по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица \"друзей\" успешно создана!</b><br>";
               #############################

               #############################
               /* Создание таблицы членов */
               $query = "CREATE TABLE `". SQL_TABLE_MEMBERS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `nick` TEXT,
                                      `icq` INT(9),
                                      `email` TEXT,
                                      `description` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `order` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица \"членов\" по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица \"членов\" успешно создана!</b><br>";
               #############################

               ###############################
               /* Создание таблицы новостей */
               $query = "CREATE TABLE `". SQL_TABLE_NEWS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `razdel_id` INT(10) DEFAULT NULL,
                                      `title` TEXT,
                                      `content` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `order` INT(10) DEFAULT NULL,
                                      `views` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица новостей по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица новостей успешно создана!</b><br>";
               ###############################

               ##############################################
               /* Создание таблицы комментариев к новостям */
               $query = "CREATE TABLE `". SQL_TABLE_NEWS_COMM ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `news_id` INT(10) DEFAULT NULL,
                                      `content` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `allow_html` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица комментариев к новостям по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица комментариев к новостям успешно создана!</b><br>";
               ##############################################

               #############################
               /* Создание таблицы статей */
               $query = "CREATE TABLE `". SQL_TABLE_ARTICLES ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `razdel_id` INT(10) DEFAULT NULL,
                                      `title` TEXT,
                                      `content` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `order` INT(10) DEFAULT NULL,
                                      `views` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица статей по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица статей успешно создана!</b><br>";
               #############################
               
               #############################################
               /* Создание таблицы комментариев к статьям */
               $query = "CREATE TABLE `". SQL_TABLE_ARTICLES_COMM ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `article_id` INT(10) DEFAULT NULL,
                                      `content` TEXT,
                                      `author_id` INT(10) DEFAULT NULL,
                                      `author_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `last_modifier_id` INT(10),
                                      `last_modifier_name` TEXT,
                                      `last_modifier_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `allow_html` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица комментариев к статьям по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица комментариев к статьям успешно создана!</b><br>";
               #############################################

               ################################################
               /* Создание таблицы логов входа пользователей */
               $query = "CREATE TABLE `". SQL_TABLE_USERS_LOGINS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `user_id` INT(10) DEFAULT NULL,
                                      `user_name` TEXT,
                                      `ip_address` TEXT,
                                      `login_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица логов входа пользователей по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица логов входа пользователей успешно создана!</b><br>";
               ################################################

               #################################################
               /* Создание таблицы логов выхода пользователей */
               $query = "CREATE TABLE `". SQL_TABLE_USERS_LOGOUTS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `user_id` INT(10) DEFAULT NULL,
                                      `user_name` TEXT,
                                      `ip_address` TEXT,
                                      `logout_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица логов выхода пользователей по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица логов выхода пользователей успешно создана!</b><br>";
               #################################################

               ###################################################
               /* Создание таблицы логов действий пользователей */
               $query = "CREATE TABLE `". SQL_TABLE_USERS_LOGS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `user_id` INT(10) DEFAULT NULL,
                                      `user_name` TEXT,
                                      `ip_address` TEXT,
                                      `content` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица логов действий пользователя по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица логов действий пользователя успешно создана!</b><br>";
               ###################################################
               
               ###############################################
               /* Создание таблицы для глобального сниффера */
               $query = "CREATE TABLE `". SQL_TABLE_GLOBAL_SNIFFER ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `ip_address` TEXT,
                                      `referer` TEXT,
                                      `content` TEXT,
                                      `user_agent` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      `img_name` TEXT,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица для глобального сниффера по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица для глобального сниффера успешно создана!</b><br>";
               ###############################################

               ##############################################
               /* Создание таблицы для локального сниффера */
               $query = "CREATE TABLE `". SQL_TABLE_LOCAL_SNIFFER ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `ip_address` TEXT,
                                      `user_agent` TEXT,
                                      `remote_host` TEXT,
                                      `referer` TEXT,
                                      `request_uri` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица для локального сниффера по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица для локального сниффера успешно создана!</b><br>";
               ##############################################

               ###########################################
               /* Создание таблицы для заявок о услугах */
               $query = "CREATE TABLE `". SQL_TABLE_SERVICE_REQUEST ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `icq` TEXT,
                                      `request` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица для заявок о услугах по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица для заявок о услугах успешно создана!</b><br>";
               ###########################################
               
               ##########################################
               /* Создание таблицы для инфры в my arch */
               $query = "CREATE TABLE `". SQL_TABLE_MY_ARCH_INFO ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `label` TEXT,
                                      `description` TEXT,
                                      `user_id` INT(10) DEFAULT NULL,
                                      `user_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица для инфры в my arch по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица для инфры в my arch успешно создана!</b><br>";
               ##########################################

               ###########################################
               /* Создание таблицы для данных в my arch */
               $query = "CREATE TABLE `". SQL_TABLE_MY_ARCH_CONTENT ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `label_id` INT(10) DEFAULT NULL,
                                      `content` TEXT,
                                      `user_id` INT(10) DEFAULT NULL,
                                      `user_name` TEXT,
                                      `create_time` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица для данных в my arch по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица для данных в my arch успешно создана!</b><br>";
               ###########################################
               
               ############################################
               /* Создание таблицы для данных статистики */
               $query = "CREATE TABLE `". SQL_TABLE_STATISTICS ."` (
                                      `id` INT(10) DEFAULT NULL AUTO_INCREMENT,
                                      `news_count` INT(10) DEFAULT NULL,
                                      `news_comm_count` INT(10) DEFAULT NULL,
                                      `articles_count` INT(10) DEFAULT NULL,
                                      `articles_comm_count` INT(10) DEFAULT NULL,
                                      `my_archive_count` INT(10) DEFAULT NULL,
                                      UNIQUE (`id`),
                                      PRIMARY KEY (`id`)
                         )
               ";
               $sql->query ( $query, "return_error" );
               if ( $sql->error )
                  print "<b class=porr>Таблица для данных статистики по видимому уже создана...(". $sql->error_message .")</b><br>";
               else
                  print "<b class=por>Таблица для данных статистики успешно создана!</b><br>";
               ###########################################

      }
      
      create_all ( );

$sql->close ( );

?>

</body>

</html>