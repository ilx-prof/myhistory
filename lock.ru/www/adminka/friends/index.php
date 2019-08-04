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

function show_add_new_friend_form ( ) {

         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/friends/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"add_new_friend\">
                <tr>
                    <td><b class=porr>Добавление \"друга\"</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Ссылка : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"link\"> <b class=date>(http://microsoft.com)</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Заголовок : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\"> <b class=date>(Microsoft)</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Описание : </b><br>
                        <input type=\"TEXT\" class=\"button\" style=\"width : 220px;\" name=\"description\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Добавить\">
                    </td>
                </tr>
                </form>
                </table>
         ";
         
}

function show_edit_friend_form ( ) {
         global $sql;

         $query = "SELECT `id`, `link`, `title`, `description` FROM `". SQL_TABLE_FRIENDS ."` WHERE `id` = ". $_GET["friend"] ."";
         $friend = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/friends/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"edit_friend\">
                <input type=\"HIDDEN\" name=\"friend\" value=\"". $friend["id"] ."\">
                <tr>
                    <td><b class=porr>Редактирование \"друга\"</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Ссылка : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"link\" value=\"". htmlspecialchars ( $friend["link"], ENT_QUOTES ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Заголовок : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\" value=\"". htmlspecialchars ( $friend["title"], ENT_QUOTES ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Описание : </b><br>
                        <input type=\"TEXT\" class=\"button\" style=\"width : 220px;\" name=\"description\" value=\"". htmlspecialchars ( $friend["description"], ENT_QUOTES ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Изменить\">
                    </td>
                </tr>
                </form>
                </table>
         ";
         
}

function show_delete_friend_form ( ) {
         global $sql;

         $query = "SELECT `id`, `link`, `title`, `description` FROM `". SQL_TABLE_FRIENDS ."` WHERE `id` = ". $_GET["friend"] ."";
         $friend = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/friends/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"delete_friend\">
                <input type=\"HIDDEN\" name=\"friend\" value=\"". $friend["id"] ."\">
                <tr>
                    <td><b class=porr>Удаление \"друга\"</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Ссылка : </b> <b class=por>". htmlspecialchars ( $friend["link"], ENT_QUOTES ) ."</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Заголовок : </b><b class=por>Ссылка : </b> <b class=por>". htmlspecialchars ( $friend["title"], ENT_QUOTES ) ."</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Описание : </b><b class=por>Описание : </b> <b class=por>". htmlspecialchars ( $friend["description"], ENT_QUOTES ) ."</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Удалить!\">
                    </td>
                </tr>
                </form>
                </table>
         ";
         
}

function show_friend_order_tree ( ) {
         global $sql;

         $friends = array ( );
         $query = "SELECT `id`, `link`, `title`, `order` FROM `". SQL_TABLE_FRIENDS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         $friendov = mysql_num_rows ( $data );
         
         if ( $friendov >= 2 ) {
            while ( $friend = mysql_fetch_assoc ( $data ) ) :
                  $friends[ $friend["id"] ] = $friend;
            endwhile;
         } else {
            exit ( "<b class=porr>Слишком мало \"друзей\", что бы их можно было менять местами!</b>" );
         }

         print "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\">";
         print "<tr>";
         print "    <td colspan=\"3\"><b class=porr>Изменение положения \"друзей\" :</b><br><br></td>";
         print "</tr>";

         $i = 0;
         foreach ( $friends as $friend ) :
                 if ( $i == 0 ) {
                    print "<form action=\"/adminka/friends/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_friend_position\">";
                    print "<input type=\"HIDDEN\" name=\"friend\" value=\"". $friend["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $friend["order"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"way\" value=\"down\">";
                    print "<tr>";
                    print "    <td colspan=\"2\"><b class=date>\"Друг\" - </b><b class=por>". $friend["title"] ."</b></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Вниз\"></td>";
                    print "</tr>";
                    print "</form>";
                 }

                 if ( $i != 0 and $i != $friendov-1 ) {
                    print "<form action=\"/adminka/friends/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_friend_position\">";
                    print "<input type=\"HIDDEN\" name=\"friend\" value=\"". $friend["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $friend["order"] ."\">";
                    print "<tr>";
                    print "    <td><b class=date>\"Друг\" - </b><b class=por>". $friend["title"] ."</b></td>";
                    print "    <td><select name=\"way\" class=button><option value=\"up\" selected>Вверх</option><option value=\"down\">Вниз</option></select></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Переместить\"></td>";
                    print "</tr>";
                    print "</form>";
                 }
                 
                 if ( $i == $friendov-1 ) {
                    print "<form action=\"/adminka/friends/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_friend_position\">";
                    print "<input type=\"HIDDEN\" name=\"friend\" value=\"". $friend["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $friend["order"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"way\" value=\"up\">";
                    print "<tr>";
                    print "    <td colspan=\"2\"><b class=date>\"Друг\" - </b><b class=por>". $friend["title"] ."</b></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Вверх\"></td>";
                    print "</tr>";
                    print "</form>";
                 }
                 
                 $i++;
         endforeach;
         
         print "</table>";
         
}

function show_tree ( ) {
         global $sql;

         $query = "SELECT `id`, `link`, `title` FROM `". SQL_TABLE_FRIENDS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );

         print "
                <table cellpadding=\"0\" cellspacing=\"2\" border=\"0\">
                <tr>
                    <td><b class=porr>Выберите производимое над элементом действие</b><br><br></td>
                </tr>
         ";
         
         while ( $friend = mysql_fetch_assoc ( $data ) ) :
               print "
                      <tr>
                          <td>
                              <b class=date>
                              [<a href=\"/adminka/friends/index.php?action=show_edit_friend_form&friend=". $friend["id"] ."\"><b class=porr>E</b></a>]
                              [<a href=\"/adminka/friends/index.php?action=show_delete_friend_form&friend=". $friend["id"] ."\"><b class=porr>D</b></a>]
                              </b>
                              <b class=por>". $friend["title"] ."</b> <b class=date>(". $friend["link"] .")</b>
                          </td>
                      </tr>
               ";
         endwhile;

         print "</table>";
         
}

function add_new_friend ( ) {
         global $security, $sql;

         $query = "SELECT `order` FROM `". SQL_TABLE_FRIENDS ."` ORDER BY `order` DESC LIMIT 1";
         $c = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "INSERT INTO
                              `". SQL_TABLE_FRIENDS ."`
                   VALUES (
                              '',
                              '". mysql_escape_string ( stripcslashes ( $_POST["link"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["description"] ) ) ."',
                              '". $security->user["userid"] ."',
                              '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                              '". date ( "Y-m-d H:i:s", time ( ) ) ."',
                              '". $security->user["userid"] ."',
                              '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                              '". date ( "Y-m-d H:i:s", time ( ) ) ."',
                              '". ( $c["order"] + 1 ) ."'
                   )
         ";
         $sql->query ( $query, "return_error" );
         
         if ( !$sql->error ) {
            print "<b class=porr>\"Друг\" <b class=por>". stripcslashes ( $_POST["title"] ) ."</b> успешно добавлен!</b>";

            $content = "New friend(". $_POST["title"] ."[". $_POST["link"] ."]) added";
            $query = "INSERT INTO
                                 `". SQL_TABLE_USERS_LOGS ."`
                      VALUES (
                                 '',
                                 '". $security->user["userid"] ."',
                                 '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                                 '". IP ."',
                                 '". mysql_escape_string ( stripcslashes ( $content ) ) ."',
                                 '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                      )
            ";
            $sql->query ( $query, "print_error_and_exit" );
            
         } else {
            print "<b class=porr>Error</b>";
         }
         
}

function edit_friend ( ) {
         global $security, $sql;

         $query = "SELECT `link`, `title`, `description` FROM `". SQL_TABLE_FRIENDS ."` WHERE `id` = ". $_POST["friend"] ."";
         $before = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "UPDATE
                         `". SQL_TABLE_FRIENDS ."`
                   SET
                         `link` = '". mysql_escape_string ( stripcslashes ( $_POST["link"] ) ) ."',
                         `title` = '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
                         `description` = '". mysql_escape_string ( stripcslashes ( $_POST["description"] ) ) ."',
                         `last_modifier_id` = ". $security->user["userid"] .",
                         `last_modifier_name` = '". $security->user["username"] ."',
                         `last_modifier_time` = '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                   WHERE
                         `id` = ". $_POST["friend"] ."
                   LIMIT
                         1
         ";
         $sql->query ( $query, "return_error" );
         
         if ( !$sql->error ) {
            print "<b class=porr>\"Друг\" успешно обновлен!</b><br>";
            print "<b class=porr>Изменения :</b><br>";
            print "<b class=porr>Ссылка : <b class=por>". $before["link"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["link"] ) ." </b></b>";
            print "<b class=porr>Заголовок : <b class=por>". $before["title"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["title"] ) ." </b></b><br>";
            print "<b class=porr>Описание : <b class=por>". $before["description"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["description"] ) ." </b></b><br>";

            $content = "Change friend(". $before["title"] .") to friend(". $_POST["title"] .") and link(". $before["link"] .") to link(". $_POST["link"] .")";
            $query = "INSERT INTO
                                 `". SQL_TABLE_USERS_LOGS ."`
                      VALUES (
                                 '',
                                 '". $security->user["userid"] ."',
                                 '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                                 '". IP ."',
                                 '". mysql_escape_string ( stripcslashes ( $content ) ) ."',
                                 '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                      )
            ";
            $sql->query ( $query, "print_error_and_exit" );
            
         } else {
            print "<b class=porr>Error</b>";
         }
         
}

function delete_friend ( ) {
         global $security, $sql;

         $query = "SELECT `link`, `title`, `description` FROM `". SQL_TABLE_FRIENDS ."` WHERE `id` = ". $_POST["friend"] ."";
         $before = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "DELETE FROM `". SQL_TABLE_FRIENDS ."` WHERE `id` = ". $_POST["friend"] ." LIMIT 1";
         $sql->query ( $query, "return_error" );

         if ( !$sql->error ) {
            print "<b class=porr>\"Друг\" <b class=por>". $before["title"] ."</b> успешно удален!</b><br>";

            $content = "Delete friend(". $before["title"] ."[". $before["link"] ."])";
            $query = "INSERT INTO
                                 `". SQL_TABLE_USERS_LOGS ."`
                      VALUES (
                                 '',
                                 '". $security->user["userid"] ."',
                                 '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                                 '". IP ."',
                                 '". mysql_escape_string ( stripcslashes ( $content ) ) ."',
                                 '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                      )
            ";
            $sql->query ( $query, "print_error_and_exit" );
            
            
         } else {
            print "<b class=porr>Error</b>";
            exit ( );
         }

}

function edit_friend_position ( ) {
         global $sql;

         $friends = array ( );
         if ( $_POST["way"] === "up" ) :

            $query = "SELECT `id`, `title`, `order`
                      FROM `". SQL_TABLE_FRIENDS ."`
                      WHERE `order` <= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );
            
            $i = 0;
            while ( $friend = mysql_fetch_assoc ( $data ) ) :
                  if ( $friend["id"] === $_POST["friend"] )
                     $moy = $i;
                  $friends[$i] = $friend;
                  $i++;
            endwhile;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $friends[$i]["order"] = $i;
            endfor;
            $friends[$moy-1]["order"] = $moy;
            $friends[$moy]["order"] = $moy-1;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_FRIENDS ."`
                          SET
                                `order` = ". $friends[$i]["order"] ."
                          WHERE
                                `id` = ". $friends[$i]["id"] ."
                          LIMIT
                                1
                ";
                $sql->query ( $query, "return_error" );
                
                if ( $sql->error ) {
                   exit ( );
                }
            endfor;
            
         endif;
         
         if ( $_POST["way"] === "down" ) :

            $query = "SELECT `id`, `title`, `order`
                      FROM `". SQL_TABLE_FRIENDS ."`
                      WHERE `order` >= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );
            
            $friend = mysql_fetch_assoc ( $data );
            $moy = $friend["order"];
            $friends[$moy] = $friend;
            $i = $moy+1;
            while ( $friend = mysql_fetch_assoc ( $data ) ) :
                  $friends[$i] = $friend;
                  $i++;
            endwhile;

            for ( $j = $moy+1; $j < $i; $j++ ) :
                $friends[$j]["order"] = $j;
            endfor;
            $friends[$moy+1]["order"] = $moy;
            $friends[$moy]["order"] = $moy+1;

            for ( $j = $moy; $j < $i; $j++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_FRIENDS ."`
                          SET
                                `order` = ". $friends[$j]["order"] ."
                          WHERE
                                `id` = ". $friends[$j]["id"] ."
                          LIMIT
                                1
                ";
                $sql->query ( $query, "return_error" );
                if ( $sql->error ) exit ( );
            endfor;

            
         endif;

         show_friend_order_tree ( );
}

if ( isset ( $_GET["action"] ) or isset ( $_POST["action"] ) ) {
   $action = isset ( $_GET["action"] ) ? $_GET["action"] : $_POST["action"];
   switch ( $action ) :
          case "show_add_new_friend_form" :
               show_add_new_friend_form ( );
          break;

          case "show_edit_friend_form" :
               show_edit_friend_form ( );
          break;
          
          case "show_delete_friend_form" :
               show_delete_friend_form ( );
          break;
          
          case "show_friend_order_tree" :
               show_friend_order_tree ( );
          break;
          
          case "show_tree" :
               show_tree ( );
          break;

          case "add_new_friend" :
               add_new_friend ( );
          break;
          
          case "edit_friend" :
               edit_friend ( );
          break;
          
          case "delete_friend" :
               delete_friend ( );
          break;

          case "edit_friend_position" :
               edit_friend_position ( );
          break;
          
   endswitch;
}

$sql->close ( );
?>

</body>

</html>