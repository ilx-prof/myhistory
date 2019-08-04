<?php
require_once "../../config.php";
require_once "../../". CLASSES_SQL;
require_once "../../". CLASSES_SECURITY;

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
        exit ( );
     }
  }
} else {
  exit ( );
}
?>

<html>
<head>
      <meta HTTP-EQUIV="Content-Type" Content="text-html; charset=windows-1251">
      <title>Lock-Team Admin Panel</title>
      <link rel="stylesheet" type="text/css" href="/style/templates/lock-team/css/style.css">
      <link rel="shortcut icon" href="/style/templates/lock-team/images/favicon.ico">
</head>
<body marginheight="20" marginwidth="20" leftmargin="20" rightmargin="20" topmargin="20" bottommargin="20">

<?

function recount ( ) {
         global $sql;
         
         $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_NEWS ."`";
         $news_count = mysql_result ( $sql->query ( $query, "print_error_and_exit" ), 0, "cnt" );

         $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_NEWS_COMM ."`";
         $news_comm_count = mysql_result ( $sql->query ( $query, "print_error_and_exit" ), 0, "cnt" );

         $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_ARTICLES ."`";
         $articles_count = mysql_result ( $sql->query ( $query, "print_error_and_exit" ), 0, "cnt" );

         $query = "SELECT COUNT(*) as cnt FROM `". SQL_TABLE_ARTICLES_COMM ."`";
         $articles_comm_count = mysql_result ( $sql->query ( $query, "print_error_and_exit" ), 0, "cnt" );

         $query = "SELECT MAX(`id`) as max FROM `". SQL_TABLE_STATISTICS ."`";
         $max = mysql_result ( $sql->query ( $query, "print_error_and_exit" ), 0, "max" );

         if ( $max != 1 ) {

            $query = "INSERT INTO `". SQL_TABLE_STATISTICS ."`
                      VALUES (
                                  '1',
                                  '". $news_count ."',
                                  '". $news_comm_count ."',
                                  '". $articles_count ."',
                                  '". $articles_comm_count ."',
                                  '0'
                      )
            ";
            $sql->query ( $query, "return_error" );
            if ( $sql->error ) {
               print "<b class=porr>Error</b>" .$sql->error_message;
            } else {
               print "<b class=porr>Информация цспешно обновлена</b>";
            }

         } else {

            $query = "UPDATE `". SQL_TABLE_STATISTICS ."`
                      SET    `news_count` = ". $news_count .",
                             `news_comm_count` = ". $news_comm_count .",
                             `articles_count` = ". $articles_count .",
                             `articles_comm_count` = ". $articles_comm_count ."
                      WHERE  `id` = ". $max ."
            ";
            $sql->query ( $query, "return_error" );
            if ( $sql->error ) {
               print "<b class=porr>Error</b>" .$sql->error_message;
            } else {
               print "<b class=porr>Информация цспешно обновлена</b>";
            }
            

         }
}

if ( isset ( $_GET["action"] ) or isset ( $_POST["action"] ) ) {
   $action = isset ( $_GET["action"] ) ? $_GET["action"] : $_POST["action"];
   switch ( $action ) :

          case "recount" :
               recount ( );
          break;

   endswitch;
}

$sql->close ( );
?>

</body>

</html>