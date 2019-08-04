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

function show_add_new_razdel_form ( ) {
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/navigation/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"add_new_razdel\">
                <tr>
                    <td><b class=porr>Добавление раздела</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Имя раздела : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\"> <b class=date>(Новости)</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Ссылка раздела : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"url\"> <b class=date>(news)</b>
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

function show_select_razdel_to_add_new_kategoria_form ( ) {
         global $sql;

         $query = "SELECT `id`, `title`, `url` FROM `". SQL_TABLE_LM_RAZDELS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         
         if ( mysql_num_rows ( $data ) == 0 ) {
            exit ( "<b class=porr>У вас не создан как минимум 1 раздел!</b>" );
         }
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/navigation/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"show_add_new_kategoria_form\">
                <tr>
                    <td><b class=porr>Выберите раздел в который вы хотите добавить категорию</b><br><br></td>
                </tr>
         ";
         
         while ( $razdel = mysql_fetch_assoc ( $data ) ) :
               print "
                      <tr>
                          <td><input type=\"RADIO\" name=\"razdel\" value=\"". $razdel["id"] ."\"> <b class=por>". $razdel["title"] ."</b> <b class=date>(". $razdel["url"] .")</b></td>
                      </tr>
               ";
         endwhile;
         
         print "
                <tr>
                    <td><br><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Добавить\"></td>
                </tr>
                </form>
                </table>
         ";
}

function show_add_new_kategoria_form ( ) {

         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/navigation/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"add_new_kategoria\">
                <input type=\"HIDDEN\" name=\"razdel\" value=\"". $_POST["razdel"] ."\">
                <tr>
                    <td><b class=porr>Добавление категории</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Имя категории : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Ссылка категории : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"url\">
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

function show_edit_razdel_form ( ) {
         global $sql;

         $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `id` = ". $_GET["razdel"] ."";
         $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/navigation/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"edit_razdel\">
                <input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">
                <tr>
                    <td><b class=porr>Редактирование раздела</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Имя раздела : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\" value=\"". htmlspecialchars ( $razdel["title"], ENT_QUOTES ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Ссылка раздела : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"url\" value=\"". htmlspecialchars ( $razdel["url"], ENT_QUOTES ) ."\">
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

function show_edit_kategoria_form ( ) {
         global $sql;

         $query = "SELECT `id`, `razdel_id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `id` = ". $_GET["kategoria"] ." and `razdel_id` = ". $_GET["razdel"] ."";
         $kategoria = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/navigation/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"edit_kategoria\">
                <input type=\"HIDDEN\" name=\"razdel\" value=\"". $kategoria["razdel_id"] ."\">
                <input type=\"HIDDEN\" name=\"kategoria\" value=\"". $kategoria["id"] ."\">
                <tr>
                    <td><b class=porr>Редактирование категории</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Имя категории : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\" value=\"". htmlspecialchars ( $kategoria["title"], ENT_QUOTES ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Ссылка категории : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"url\" value=\"". htmlspecialchars ( $kategoria["url"], ENT_QUOTES ) ."\">
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

function show_delete_razdel_form ( ) {
         global $sql;

         $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `id` = ". $_GET["razdel"] ."";
         $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/navigation/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"delete_razdel\">
                <input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">
                <tr>
                    <td><b class=porr>Удаление раздела</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Имя раздела : </b><b class=porr>". $razdel["title"] ."</b><br>
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

function show_delete_kategoria_form ( ) {
         global $sql;

         $query = "SELECT `id`, `razdel_id`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `id` = ". $_GET["kategoria"] ." and `razdel_id` = ". $_GET["razdel"] ."";
         $kategoria = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/navigation/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"delete_kategoria\">
                <input type=\"HIDDEN\" name=\"razdel\" value=\"". $kategoria["razdel_id"] ."\">
                <input type=\"HIDDEN\" name=\"kategoria\" value=\"". $kategoria["id"] ."\">
                <tr>
                    <td><b class=porr>Удаление категории</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Имя категории : </b><b class=porr>". $kategoria["title"] ."</b><br>
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

function show_razdel_order_tree ( ) {
         global $sql;

         $razdels = array ( );
         $query = "SELECT `id`, `title`, `url`, `order` FROM `". SQL_TABLE_LM_RAZDELS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         $razdelov = mysql_num_rows ( $data );
         
         if ( $razdelov >= 2 ) {
            while ( $razdel = mysql_fetch_assoc ( $data ) ) :
                  $razdels[ $razdel["id"] ] = $razdel;
            endwhile;
         } else {
            exit ( "<b class=porr>Слишком мало разделов, что бы их можно было менять местами!</b>" );
         }

         print "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\">";
         print "<tr>";
         print "    <td colspan=\"3\"><b class=porr>Изменение положения разделов :</b><br><br></td>";
         print "</tr>";

         $i = 0;
         foreach ( $razdels as $razdel ) :
                 if ( $i == 0 ) {
                    print "<form action=\"/adminka/navigation/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_razdel_position\">";
                    print "<input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $razdel["order"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"way\" value=\"down\">";
                    print "<tr>";
                    print "    <td colspan=\"2\"><b class=date>Раздел - </b><b class=por>". $razdel["title"] ."</b></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Вниз\"></td>";
                    print "</tr>";
                    print "</form>";
                 }

                 if ( $i != 0 and $i != $razdelov-1 ) {
                    print "<form action=\"/adminka/navigation/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_razdel_position\">";
                    print "<input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $razdel["order"] ."\">";
                    print "<tr>";
                    print "    <td><b class=date>Раздел - </b><b class=por>". $razdel["title"] ."</b></td>";
                    print "    <td><select name=\"way\" class=button><option value=\"up\" selected>Вверх</option><option value=\"down\">Вниз</option></select></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Переместить\"></td>";
                    print "</tr>";
                    print "</form>";
                 }
                 
                 if ( $i == $razdelov-1 ) {
                    print "<form action=\"/adminka/navigation/index.php\" method=\"POST\">";
                    print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_razdel_position\">";
                    print "<input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"order\" value=\"". $razdel["order"] ."\">";
                    print "<input type=\"HIDDEN\" name=\"way\" value=\"up\">";
                    print "<tr>";
                    print "    <td colspan=\"2\"><b class=date>Раздел - </b><b class=por>". $razdel["title"] ."</b></td>";
                    print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Вверх\"></td>";
                    print "</tr>";
                    print "</form>";
                 }
                 
                 $i++;
         endforeach;
         
         print "</table>";
         
}

function show_kategoria_order_tree ( ) {
         global $sql;

         $kategories = array ( );
         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         $razdelov = mysql_num_rows ( $data );

         if ( $razdelov == 0 ) {
            exit ( "<b class=porr>У вас должен быть как минимум 1 раздел.</b>" );
         } else {

            $result = array ( "razdel" => array ( ), "kategoria" => array ( ) );

            while ( $razdel = mysql_fetch_assoc ( $data ) ) :
                  $query = "SELECT `id`, `title`, `order` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` ASC";
                  $data2 = $sql->query ( $query, "print_error_and_exit" );
                  $kategoriy = mysql_num_rows ( $data2 );

                  if ( $kategoriy >= 2 ) :
                     $result["razdel"][ $razdel["id"] ] = $razdel;
                     while ( $kategoria = mysql_fetch_assoc ( $data2 ) ) :
                           $result["kategoria"][ $razdel["id"] ][ $kategoria["id"] ] = $kategoria;
                     endwhile;
                  endif;
            endwhile;
         }

         if ( sizeof ( $result["razdel"] ) >= 1 ) {
            print "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\">";
            print "<tr>";
            print "    <td colspan=\"3\"><b class=porr>Изменение положения категорий :</b></td>";
            print "</tr>";
            
            foreach ( $result["razdel"] as $razdel ) :
                    $kategoriy = sizeof ( $result["kategoria"][ $razdel["id"] ] );

                    print "<tr>";
                    print "    <td colspan=\"2\"><br><b class=date>Раздел - </b><b class=porr>". $razdel["title"] ."</b></td>";
                    print "</tr>";
                    
                    $i = 0;
                    foreach ( $result["kategoria"][ $razdel["id"] ] as $kategoria ) :

                            if ( $i == 0 ) {
                               print "<form action=\"/adminka/navigation/index.php\" method=\"POST\">";
                               print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_kategoria_position\">";
                               print "<input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"kategoria\" value=\"". $kategoria["id"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"order\" value=\"". $kategoria["order"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"way\" value=\"down\">";
                               print "<tr>";
                               print "    <td colspan=\"2\"><b class=por>". $kategoria["title"] ."</b></td>";
                               print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Вниз\"></td>";
                               print "</tr>";
                               print "</form>";
                            }

                            if ( $i != 0 and $i != $kategoriy-1 ) {
                               print "<form action=\"/adminka/navigation/index.php\" method=\"POST\">";
                               print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_kategoria_position\">";
                               print "<input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"kategoria\" value=\"". $kategoria["id"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"order\" value=\"". $kategoria["order"] ."\">";
                               print "<tr>";
                               print "    <td><b class=por>". $kategoria["title"] ."</b></td>";
                               print "    <td><select name=\"way\" class=button><option value=\"up\" selected>Вверх</option><option value=\"down\">Вниз</option></select></td>";
                               print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Переместить\"></td>";
                               print "</tr>";
                               print "</form>";
                            }

                            if ( $i == $kategoriy-1 ) {
                               print "<form action=\"/adminka/navigation/index.php\" method=\"POST\">";
                               print "<input type=\"HIDDEN\" name=\"action\" value=\"edit_kategoria_position\">";
                               print "<input type=\"HIDDEN\" name=\"razdel\" value=\"". $razdel["id"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"kategoria\" value=\"". $kategoria["id"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"order\" value=\"". $kategoria["order"] ."\">";
                               print "<input type=\"HIDDEN\" name=\"way\" value=\"up\">";
                               print "<tr>";
                               print "    <td colspan=\"2\"><b class=por>". $kategoria["title"] ."</b></td>";
                               print "    <td><input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Вверх\"></td>";
                               print "</tr>";
                               print "</form>";
                            }

                            $i++;
                    endforeach;
            endforeach;
            
            print "</table>";
            
         } else {
            exit ( "<b class=porr>У вас слишком мало категорий!</b>" );
         }
         
}

function show_tree ( ) {
         global $sql;

         $query = "SELECT `id`, `title`, `url` FROM `". SQL_TABLE_LM_RAZDELS ."` ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );

         print "
                <table cellpadding=\"0\" cellspacing=\"2\" border=\"0\">
                <tr>
                    <td><b class=porr>Выберите производимое над элементом действие</b><br></td>
                </tr>
         ";
         
         while ( $razdel = mysql_fetch_assoc ( $data ) ) :
               print "
                      <tr>
                          <td>
                              <br>
                              <b class=date>
                              [<a href=\"/adminka/navigation/index.php?action=show_edit_razdel_form&razdel=". $razdel["id"] ."\"><b class=porr>E</b></a>]
                              [<a href=\"/adminka/navigation/index.php?action=show_delete_razdel_form&razdel=". $razdel["id"] ."\"><b class=porr>D</b></a>]
                              </b>
                              <b class=por>". $razdel["title"] ."</b> <b class=date>(". $razdel["url"] .")</b>
                          </td>
                      </tr>
               ";

               $query = "SELECT `id`, `url`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` ASC";
               $data2 = $sql->query ( $query, "print_error_and_exit" );
               
               while ( $kategoria = mysql_fetch_assoc ( $data2 ) ) :
                     print "
                            <tr>
                                <td style=\"padding-left : 23px; \">
                                    <b class=date>
                                    [<a href=\"/adminka/navigation/index.php?action=show_edit_kategoria_form&razdel=". $razdel["id"] ."&kategoria=". $kategoria["id"] ."\"><b class=porr>E</b></a>]
                                    [<a href=\"/adminka/navigation/index.php?action=show_delete_kategoria_form&razdel=". $razdel["id"] ."&kategoria=". $kategoria["id"] ."\"><b class=porr>D</b></a>]
                                    </b>
                                    <b class=por>". $kategoria["title"] ."</b> <b class=date>". $kategoria["url"] ."</b>
                                </td>
                            </tr>
                     ";
               endwhile;
         endwhile;
         print "</table>";
         
}

function add_new_razdel ( ) {
         global $security, $sql;

         $query = "SELECT `order` FROM `". SQL_TABLE_LM_RAZDELS ."` ORDER BY `order` DESC LIMIT 1";
         $c = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "INSERT INTO
                              `". SQL_TABLE_LM_RAZDELS ."`
                   VALUES (
                              '',
                              '". mysql_escape_string ( stripcslashes ( $_POST["url"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
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
            print "<b class=porr>Раздел <b class=por>". stripcslashes ( $_POST["title"] ) ."</b> успешно добавлен!</b>";

            $content = "New razdel(". $_POST["title"] .") added";
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

function add_new_kategoria ( ) {
         global $security, $sql;

         $query = "SELECT `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `id` = ". $_POST["razdel"] ."";
         $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "SELECT `order` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $_POST["razdel"] ." ORDER BY `order` DESC LIMIT 1";
         $c = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "INSERT INTO
                              `". SQL_TABLE_LM_KATEGORIES ."`
                   VALUES (
                              '',
                              '". mysql_escape_string ( stripcslashes ( $_POST["razdel"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["url"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
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
            print "<b class=porr>Категория <b class=por>". stripcslashes ( $_POST["title"] ) ."</b> успешно добавлена!</b>";

            $content = "New kategoria(". $_POST["title"] .") added to razdel(". $razdel["title"] ."[". $razdel["url"] ."])";
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
            print "<b class=porr>Error</b>". $sql->error_message;
         }
}

function edit_razdel ( ) {
         global $security, $sql;

         $query = "SELECT `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `id` = ". $_POST["razdel"] ."";
         $before = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "UPDATE
                         `". SQL_TABLE_LM_RAZDELS ."`
                   SET
                         `url` = '". mysql_escape_string ( stripcslashes ( $_POST["url"] ) ) ."',
                         `title` = '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
                         `last_modifier_id` = ". $security->user["userid"] .",
                         `last_modifier_name` = '". $security->user["username"] ."',
                         `last_modifier_time` = '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                   WHERE
                         `id` = ". $_POST["razdel"] ."
                   LIMIT
                         1
         ";
         $sql->query ( $query, "return_error" );
         
         if ( !$sql->error ) {
            print "<b class=porr>Раздел успешно обновлен!</b><br>";
            print "<b class=porr>Изменения :</b><br>";
            print "<b class=porr>Имя раздела : <b class=por>". $before["title"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["title"] ) ." </b></b><br>";
            print "<b class=porr>Ссылка раздела : <b class=por>". $before["url"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["url"] ) ." </b></b>";

            $content = "Change razdel(". $before["title"] .") to razdel(". $_POST["title"] .") and url(". $before["url"] .") to url(". $_POST["url"] .")";
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

function edit_kategoria ( ) {
         global $security, $sql;

         $query = "SELECT `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `id` = ". $_POST["kategoria"] ." and `razdel_id` = ". $_POST["razdel"] ."";
         $before = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "UPDATE
                         `". SQL_TABLE_LM_KATEGORIES ."`
                   SET
                         `url`                = '". mysql_escape_string ( stripcslashes ( $_POST["url"] ) ) ."',
                         `title`              = '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
                         `last_modifier_id`   = ". $security->user["userid"] .",
                         `last_modifier_name` = '". $security->user["username"] ."',
                         `last_modifier_time` = '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                   WHERE
                         `id` = ". $_POST["kategoria"] ." and `razdel_id` = ". $_POST["razdel"] ."
                   LIMIT
                         1
         ";
         $sql->query ( $query, "return_error" );
         
         if ( !$sql->error ) {
            print "<b class=porr>Категория успешно обновлена!</b><br>";
            print "<b class=porr>Изменения :</b><br>";
            print "<b class=porr>Имя категории : <b class=por>". $before["title"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["title"] ) ." </b></b><br>";

            $content = "Change kategoria(". $before["title"] .") to kategoria(". $_POST["title"] .")";
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

function delete_razdel ( ) {
         global $security, $sql;

         $query = "SELECT `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `id` = ". $_POST["razdel"] ."";
         $before = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "DELETE FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `id` = ". $_POST["razdel"] ." LIMIT 1";
         $sql->query ( $query, "return_error" );

         if ( !$sql->error ) {
            print "<b class=porr>Раздел <b class=por>". $before["title"] ."</b> успешно удален!</b><br>";

            $content = "Delete razdel(". $before["title"] ."[". $before["url"] ."])";
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

         $query = "SELECT `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $_POST["razdel"] ." ORDER BY `order` ASC";
         $data = $sql->query ( $query, "return_error" );
         
         if ( mysql_num_rows ( $data ) == 0 ) {
            exit ( );
         }
         
         print "<b class=porr>Категории данного раздела то же будут удалены!</b><br>";
         while ( $kategoria = mysql_fetch_assoc ( $data ) ) :
               print "<b class=porr>Категория : <b class=por>". $kategoria["title"] ."</b> - удалена!</b><br>";

               $content = "Delete kategoria(". $kategoria["title"] .") from razdel(". $before["title"] ."[". $before["url"] ."])";
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
               
         endwhile;
         
         $query = "DELETE FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $_POST["razdel"] ."";
         $sql->query ( $query, "print_error_and_exit" );
         
}

function delete_kategoria ( ) {
         global $security, $sql;

         $query = "SELECT `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `id` = ". $_POST["kategoria"] ." and `razdel_id` = ". $_POST["razdel"] ."";
         $b_kategoria = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "SELECT `url`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `id` = ". $_POST["razdel"] ."";
         $b_razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "DELETE FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `id` = ". $_POST["kategoria"] ." and `razdel_id` = ". $_POST["razdel"] ." LIMIT 1";
         $sql->query ( $query, "return_error" );
         
         if ( !$sql->error ) {
            print "<b class=porr>Категория <b class=por>". $b_kategoria["title"] ."</b> успешно удалена!</b><br>";

            $content = "Delete kategoria(". $b_kategoria["title"] .") from razdel(". $b_razdel["title"] .")";
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

function edit_razdel_position ( ) {
         global $sql;

         $razdels = array ( );
         if ( $_POST["way"] === "up" ) :

            $query = "SELECT `id`, `title`, `order`
                      FROM `". SQL_TABLE_LM_RAZDELS ."`
                      WHERE `order` <= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );
            
            $i = 0;
            while ( $razdel = mysql_fetch_assoc ( $data ) ) :
                  if ( $razdel["id"] === $_POST["razdel"] )
                     $moy = $i;
                  $razdels[$i] = $razdel;
                  $i++;
            endwhile;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $razdels[$i]["order"] = $i;
            endfor;
            $razdels[$moy-1]["order"] = $moy;
            $razdels[$moy]["order"] = $moy-1;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_LM_RAZDELS ."`
                          SET
                                `order` = ". $razdels[$i]["order"] ."
                          WHERE
                                `id` = ". $razdels[$i]["id"] ."
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
                      FROM `". SQL_TABLE_LM_RAZDELS ."`
                      WHERE `order` >= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );
            
            $razdel = mysql_fetch_assoc ( $data );
            $moy = $razdel["order"];
            $razdels[$moy] = $razdel;
            $i = $moy+1;
            while ( $razdel = mysql_fetch_assoc ( $data ) ) :
                  $razdels[$i] = $razdel;
                  $i++;
            endwhile;

            for ( $j = $moy+1; $j < $i; $j++ ) :
                $razdels[$j]["order"] = $j;
            endfor;
            $razdels[$moy+1]["order"] = $moy;
            $razdels[$moy]["order"] = $moy+1;

            for ( $j = $moy; $j < $i; $j++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_LM_RAZDELS ."`
                          SET
                                `order` = ". $razdels[$j]["order"] ."
                          WHERE
                                `id` = ". $razdels[$j]["id"] ."
                          LIMIT
                                1
                ";
                $sql->query ( $query, "return_error" );
                if ( $sql->error ) exit ( );
            endfor;

            
         endif;

         show_razdel_order_tree ( );
}

function edit_kategoria_position ( ) {
         global $sql;

         $kategories = array ( );
         if ( $_POST["way"] === "up" ) :

            $query = "SELECT `id`, `razdel_id`, `title`, `order`
                      FROM `". SQL_TABLE_LM_KATEGORIES ."`
                      WHERE `order` <= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );
            
            $i = 0;
            while ( $kategoria = mysql_fetch_assoc ( $data ) ) :
                  if ( $kategoria["id"] === $_POST["kategoria"] and $kategoria["razdel_id"] === $_POST["razdel"] )
                     $moy = $i;
                  $kategories[$i] = $kategoria;
                  $i++;
            endwhile;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $kategories[$i]["order"] = $i;
            endfor;
            $kategories[$moy-1]["order"] = $moy;
            $kategories[$moy]["order"] = $moy-1;

            for ( $i = 0; $i <= $moy; $i++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_LM_KATEGORIES ."`
                          SET
                                `order` = ". $kategories[$i]["order"] ."
                          WHERE
                                `id` = ". $kategories[$i]["id"] ." and `razdel_id` = ". $kategories[$i]["razdel_id"] ."
                          LIMIT
                                1
                ";
                $sql->query ( $query, "return_error" );
                if ( $sql->error ) exit ( );
            endfor;

         endif;

         if ( $_POST["way"] === "down" ) :

            $query = "SELECT `id`, `razdel_id`, `title`, `order`
                      FROM `". SQL_TABLE_LM_KATEGORIES ."`
                      WHERE `order` >= ". $_POST["order"] ."
                      ORDER BY `order` ASC
            ";
            $data = $sql->query ( $query, "print_error_and_exit" );

            $kategoria = mysql_fetch_assoc ( $data );
            $moy = $kategoria["order"];
            $kategories[$moy] = $kategoria;
            $i = $moy+1;
            while ( $kategoria = mysql_fetch_assoc ( $data ) ) :
                  $kategories[$i] = $kategoria;
                  $i++;
            endwhile;

            for ( $j = $moy+1; $j < $i; $j++ ) :
                $kategories[$j]["order"] = $j;
            endfor;
            $kategories[$moy+1]["order"] = $moy;
            $kategories[$moy]["order"] = $moy+1;

            for ( $j = $moy; $j < $i; $j++ ) :
                $query = "UPDATE
                                `". SQL_TABLE_LM_KATEGORIES ."`
                          SET
                                `order` = ". $kategories[$j]["order"] ."
                          WHERE
                                `id` = ". $kategories[$j]["id"] ." and `razdel_id` = ". $kategories[$j]["razdel_id"] ."
                          LIMIT
                                1
                ";
                $sql->query ( $query, "return_error" );
                if ( $sql->error ) exit ( );
            endfor;


         endif;

         show_kategoria_order_tree ( );
}


if ( isset ( $_GET["action"] ) or isset ( $_POST["action"] ) ) {
   $action = isset ( $_GET["action"] ) ? $_GET["action"] : $_POST["action"];
   switch ( $action ) :
          case "show_add_new_razdel_form" :
               show_add_new_razdel_form ( );
          break;

          case "show_select_razdel_to_add_new_kategoria_form" :
               show_select_razdel_to_add_new_kategoria_form ( );
          break;
          
          case "show_add_new_kategoria_form" :
               show_add_new_kategoria_form ( );
          break;
          
          case "show_edit_razdel_form" :
               show_edit_razdel_form ( );
          break;
          
          case "show_edit_kategoria_form" :
               show_edit_kategoria_form ( );
          break;
          
          case "show_delete_razdel_form" :
               show_delete_razdel_form ( );
          break;
          
          case "show_delete_kategoria_form" :
               show_delete_kategoria_form ( );
          break;
          
          case "show_razdel_order_tree" :
               show_razdel_order_tree ( );
          break;
          
          case "show_kategoria_order_tree" :
               show_kategoria_order_tree ( );
          break;
          
          case "show_tree" :
               show_tree ( );
          break;

          case "add_new_razdel" :
               add_new_razdel ( );
          break;
          
          case "add_new_kategoria" :
               add_new_kategoria ( );
          break;
          
          case "edit_razdel" :
               edit_razdel ( );
          break;
          
          case "edit_kategoria" :
               edit_kategoria ( );
          break;
          
          case "delete_razdel" :
               delete_razdel ( );
          break;

          case "delete_kategoria" :
               delete_kategoria ( );
          break;
          
          case "edit_razdel_position" :
               edit_razdel_position ( );
          break;
          
          case "edit_kategoria_position" :
               edit_kategoria_position ( );
          break;
          
   endswitch;
}

$sql->close ( );
?>

</body>

</html>