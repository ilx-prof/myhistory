<?php

require_once "../config.php";
require_once CLASSES_SQL;

$sql = new SQL;
$sql->server["host"]     = SQL_CONNECT_HOST;
$sql->server["user"]     = SQL_CONNECT_USER;
$sql->server["pass"]     = SQL_CONNECT_PASS;
$sql->server["database"] = SQL_CONNECT_DATABASE;
$sql->connect ( "exit" );
$sql->select_db ( "exit" );

function add_log ( ) {
         global $sql;

         $query = "INSERT INTO
                              `". SQL_TABLE_GLOBAL_SNIFFER ."`
                   VALUES (
                              '',
                              '". IP ."',
                              '". mysql_escape_string ( base64_encode ( getenv ( "HTTP_REFERER" ) ) ) ."',
                              '". mysql_escape_string ( base64_encode ( getenv ( "QUERY_STRING" ) ) ) ."',
                              '". mysql_escape_string ( getenv ( "HTTP_USER_AGENT" ) ) ."',
                              '". date ( "Y-m-d H:i:s", time ( ) ) ."',
                              '". mysql_escape_string ( basename ( getenv ( "REQUEST_URI" ) ) ) ."'
                   )
         ";
         $sql->query ( $query, "print_error_and_exit" );

         header ( "Content-type: image/gif" );
         $im = ImageCreateFromGIF ( "image.gif" );
         ImageGIF ( $im );
         ImageDestroy ( $im );

}

add_log ( );

$sql->close ( );

?>