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

function show_add_new_member_form ( ) {

         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/members/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"add_new_member\">
                <tr>
                    <td><b class=porr>Добавление \"члена\"</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Nick : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"nick\"> <b class=date>(WSR)</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>ICQ : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"icq\"> <b class=date>(918318)</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>E-mail : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"email\"> <b class=date>(wsr@lock-team.com)</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Описание : </b><b class=date>HTML включен</b><br>
                        <textarea class=\"button\" style=\"width : 550px; height : 440px; background : white;\" name=\"description\"></textarea>
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

function show_edit_member_form ( ) {
         global $sql;

         $query = "SELECT * FROM `". SQL_TABLE_MEMBERS ."` WHERE `id` = ". $_GET["member"] ."";
         $member = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/members/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"edit_member\">
                <input type=\"HIDDEN\" name=\"member\" value=\"". $member["id"] ."\">
                <tr>
                    <td><b class=porr>Редактирование \"члена\"</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Nick : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"nick\" value=\"". htmlspecialchars ( $member["nick"] ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>ICQ : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"icq\" value=\"". htmlspecialchars ( $member["icq"] ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>E-mail : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"email\" value=\"". htmlspecialchars ( $member["email"] ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Описание : </b><b class=date>HTML включен</b><br>
                        <textarea class=\"button\" style=\"width : 550px; height : 440px; background : white;\" name=\"description\">". htmlspecialchars ( $member["description"] ) ."</textarea>
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

function show_delete_member_form ( ) {
         global $sql;

         $query = "SELECT * FROM `". SQL_TABLE_MEMBERS ."` WHERE `id` = ". $_GET["member"] ."";
         $member = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/members/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"delete_member\">
                <input type=\"HIDDEN\" name=\"member\" value=\"". $member["id"] ."\">
                <tr>
                    <td><b class=porr>Удаление \"члена\"</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Nick : </b><b class=porr>". htmlspecialchars ( $member["nick"] ) ."</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>ICQ : </b><b class=porr>". htmlspecialchars ( $member["icq"] ) ."</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>E-mail : </b><b class=porr>". htmlspecialchars ( $member["email"] ) ."</b>
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

function show_member_order_tree ( ) {
         global $sql;

         $members = array ( );
         $query = "SELECT * FROM `". SQL_TABLE_MEMBERS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         $membersov = mysql_num_rows ( $data );
         
         if ( $membersov >= 2 ) {
            while ( $member = mysql_fetch_assoc ( $data ) ) :
                  $members[ $member["id"] ] = $member;
            endwhile;
         } else {
            exit ( "<b class=porr>Слишком мало \"членов\", что бы их можно было менять местами!</b>" );
         }

         print "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\">";
         print "<tr>";
         print "    <td colspan=\"3\"><b class=porr>Изменение положения \"членов\" :</b><br><br></td>";
         print "</tr>";

         $i = 0;
         foreach ( $members as $member ) :
                 if ( $i == 0 ) {
                    print "<form action=\"/adminka/members/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_member_position\">";
                    print "<input type=\"HIDDEN\" name=\"member\" value=\"". $member["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $member["order"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"way\" value=\"down\">";
                    print "<tr>";
                    print "    <td colspan=\"2\"><b class=date>\"Член\" - </b><b class=por>". $member["nick"] ."</b></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Вниз\"></td>";
                    print "</tr>";
                    print "</form>";
                 }

                 if ( $i != 0 and $i != $membersov-1 ) {
                    print "<form action=\"/adminka/members/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_member_position\">";
                    print "<input type=\"HIDDEN\" name=\"member\" value=\"". $member["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $member["order"] ."\">";
                    print "<tr>";
                    print "    <td><b class=date>\"Член\" - </b><b class=por>". $member["nick"] ."</b></td>";
                    print "    <td><select name=\"way\" class=button><option value=\"up\" selected>Вверх</option><option value=\"down\">Вниз</option></select></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Переместить\"></td>";
                    print "</tr>";
                    print "</form>";
                 }
                 
                 if ( $i == $membersov-1 ) {
                    print "<form action=\"/adminka/members/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_member_position\">";
                    print "<input type=\"HIDDEN\" name=\"member\" value=\"". $member["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $member["order"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"way\" value=\"up\">";
                    print "<tr>";
                    print "    <td colspan=\"2\"><b class=date>\"Член\" - </b><b class=por>". $member["nick"] ."</b></td>";
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

         $query = "SELECT * FROM `". SQL_TABLE_MEMBERS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );

         print "
                <table cellpadding=\"0\" cellspacing=\"2\" border=\"0\">
                <tr>
                    <td><b class=porr>Выберите производимое над элементом действие</b><br><br></td>
                </tr>
         ";
         
         while ( $member = mysql_fetch_assoc ( $data ) ) :
               print "
                      <tr>
                          <td>
                              <b class=date>
                              [<a href=\"/adminka/members/index.php?action=show_edit_member_form&member=". $member["id"] ."\"><b class=porr>E</b></a>]
                              [<a href=\"/adminka/members/index.php?action=show_delete_member_form&member=". $member["id"] ."\"><b class=porr>D</b></a>]
                              </b>
                              <b class=por>". $member["nick"] ."</b> <b class=date>(". $member["icq"] .")</b>
                          </td>
                      </tr>
               ";
         endwhile;

         print "</table>";
         
}

function add_new_member ( ) {
         global $security, $sql;

         $query = "SELECT `order` FROM `". SQL_TABLE_MEMBERS ."` ORDER BY `order` DESC LIMIT 1";
         $c = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "INSERT INTO
                              `". SQL_TABLE_MEMBERS ."`
                   VALUES (
                              '',
                              '". mysql_escape_string ( stripcslashes ( $_POST["nick"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["icq"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["email"] ) ) ."',
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
            print "<b class=porr>\"Член\" <b class=por>". stripcslashes ( $_POST["nick"] ) ."</b> успешно добавлен!</b>";

            $content = "New member(". $_POST["nick"] ."[". $_POST["icq"] ."]) added";
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

function edit_member ( ) {
         global $security, $sql;

         $query = "SELECT * FROM `". SQL_TABLE_MEMBERS ."` WHERE `id` = ". $_POST["member"] ."";
         $before = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "UPDATE
                         `". SQL_TABLE_MEMBERS ."`
                   SET
                         `nick` = '". mysql_escape_string ( stripcslashes ( $_POST["nick"] ) ) ."',
                         `icq` = '". mysql_escape_string ( stripcslashes ( $_POST["icq"] ) ) ."',
                         `email` = '". mysql_escape_string ( stripcslashes ( $_POST["email"] ) ) ."',
                         `description` = '". mysql_escape_string ( stripcslashes ( $_POST["description"] ) ) ."',
                         `last_modifier_id` = ". $security->user["userid"] .",
                         `last_modifier_name` = '". $security->user["username"] ."',
                         `last_modifier_time` = '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                   WHERE
                         `id` = ". $_POST["member"] ."
                   LIMIT
                         1
         ";
         $sql->query ( $query, "return_error" );
         
         if ( !$sql->error ) {
            print "<b class=porr>\"Член\" успешно обновлен!</b><br>";
            print "<b class=porr>Изменения :</b><br>";
            print "<b class=porr>Nick : <b class=por>". $before["nick"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["nick"] ) ." </b></b><br>";
            print "<b class=porr>ICQ : <b class=por>". $before["icq"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["icq"] ) ." </b></b><br>";
            print "<b class=porr>EMAIL : <b class=por>". $before["email"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["email"] ) ." </b></b><br>";

            $content = "Change member(". $before["nick"] .") to member(". $_POST["nick"] .") and icq(". $before["icq"] .") to link(". $_POST["icq"] .")";
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

function delete_member ( ) {
         global $security, $sql;

         $query = "SELECT * FROM `". SQL_TABLE_MEMBERS ."` WHERE `id` = ". $_POST["member"] ."";
         $before = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "DELETE FROM `". SQL_TABLE_MEMBERS ."` WHERE `id` = ". $_POST["member"] ." LIMIT 1";
         $sql->query ( $query, "return_error" );

         if ( !$sql->error ) {
            print "<b class=porr>\"Член\" <b class=por>". $before["nick"] ."</b> успешно удален!</b><br>";

            $content = "Delete member(". $before["nick"] ."[". $before["icq"] ."])";
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

function edit_member_position ( ) {
         global $sql;

         $members = array ( );
         if ( $_POST["way"] === "up" ) :

            $query = "SELECT *
                      FROM `". SQL_TABLE_MEMBERS ."`
                      WHERE `order` <= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );
            
            $i = 0;
            while ( $member = mysql_fetch_assoc ( $data ) ) :
                  if ( $member["id"] === $_POST["member"] )
                     $moy = $i;
                  $members[$i] = $member;
                  $i++;
            endwhile;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $members[$i]["order"] = $i;
            endfor;
            $members[$moy-1]["order"] = $moy;
            $members[$moy]["order"] = $moy-1;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_MEMBERS ."`
                          SET
                                `order` = ". $members[$i]["order"] ."
                          WHERE
                                `id` = ". $members[$i]["id"] ."
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

            $query = "SELECT *
                      FROM `". SQL_TABLE_MEMBERS ."`
                      WHERE `order` >= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );
            
            $member = mysql_fetch_assoc ( $data );
            $moy = $member["order"];
            $members[$moy] = $member;
            $i = $moy+1;
            while ( $member = mysql_fetch_assoc ( $data ) ) :
                  $members[$i] = $member;
                  $i++;
            endwhile;

            for ( $j = $moy+1; $j < $i; $j++ ) :
                $members[$j]["order"] = $j;
            endfor;
            $members[$moy+1]["order"] = $moy;
            $members[$moy]["order"] = $moy+1;

            for ( $j = $moy; $j < $i; $j++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_MEMBERS ."`
                          SET
                                `order` = ". $members[$j]["order"] ."
                          WHERE
                                `id` = ". $members[$j]["id"] ."
                          LIMIT
                                1
                ";
                $sql->query ( $query, "return_error" );
                if ( $sql->error ) exit ( );
            endfor;

            
         endif;

         show_member_order_tree ( );
}

if ( isset ( $_GET["action"] ) or isset ( $_POST["action"] ) ) {
   $action = isset ( $_GET["action"] ) ? $_GET["action"] : $_POST["action"];
   switch ( $action ) :
          case "show_add_new_member_form" :
               show_add_new_member_form ( );
          break;

          case "show_edit_member_form" :
               show_edit_member_form ( );
          break;
          
          case "show_delete_member_form" :
               show_delete_member_form ( );
          break;
          
          case "show_member_order_tree" :
               show_member_order_tree ( );
          break;
          
          case "show_tree" :
               show_tree ( );
          break;

          case "add_new_member" :
               add_new_member ( );
          break;
          
          case "edit_member" :
               edit_member ( );
          break;
          
          case "delete_member" :
               delete_member ( );
          break;

          case "edit_member_position" :
               edit_member_position ( );
          break;
          
   endswitch;
}

$sql->close ( );
?>

</body>

</html>