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

function show_requests ( ) {
         global $sql;
         
         $query = "SELECT * FROM `". SQL_TABLE_SERVICE_REQUEST ."` ORDER BY `id` DESC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         
         if ( mysql_num_rows ( $data ) !== 0 ) {
            while ( $log = mysql_fetch_assoc ( $data ) ) :
                  print "<b class=por>". htmlspecialchars ( $log["icq"], ENT_QUOTES ) ."</b><Br>
                         <b class=date>". htmlspecialchars ( $log["request"], ENT_QUOTES ) ."</b><Br><br>
                  ";
            endwhile;
         } else {
            print "<b class=porr>Записей нет</b>";
         }
         
         
}

if ( isset ( $_GET["action"] ) or isset ( $_POST["action"] ) ) {
   $action = isset ( $_GET["action"] ) ? $_GET["action"] : $_POST["action"];
   switch ( $action ) :

          case "show_requests" :
               show_requests ( );
          break;

   endswitch;
}

$sql->close ( );
?>

</body>

</html>