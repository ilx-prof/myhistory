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

function show_select_razdel_to_add_new_news_form ( ) {
         global $sql;

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'news'";
         $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         if ( empty ( $razdel["title"] ) ) {
            exit ( "<b class=porr>У вас не создан раздел для новостей</b><br><b class=date>Добавьте раздел с сылкой (news)</b>" );
         }

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         
         if ( mysql_num_rows ( $data ) == 0 ) {
            exit ( "<b class=porr>У вас не создана как минимум 1 категория для новостей!</b>" );
         }
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/news/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"show_add_new_news_form\">
                <tr>
                    <td><b class=porr>Выберите раздел в который вы хотите добавить новость</b><br><br></td>
                </tr>
         ";
         
         while ( $razdel = mysql_fetch_assoc ( $data ) ) :
               print "
                      <tr>
                          <td><input type=\"RADIO\" name=\"razdel\" value=\"". $razdel["id"] ."\"> <b class=por>". $razdel["title"] ."</b></td>
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

function show_add_new_news_form ( ) {

         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/news/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"add_new_news\">
                <input type=\"HIDDEN\" name=\"razdel\" value=\"". $_POST["razdel"] ."\">
                <tr>
                    <td><b class=porr>Добавление новости</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Заголовок новости : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\" style=\"width : 220px;\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Текст новости : </b><br>
                        <textarea class=\"button\" name=\"content\" style=\"width : 550px; background : white; height : 600px;\"></textarea>
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

function show_edit_news_form ( ) {
         global $sql;

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'news'";
         $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "SELECT `id`, `razdel_id`, `title`, `content` FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_GET["news"] ."";
         $news = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         $result = "<select class=\"button\" name=\"razdel_id\">";
         while ( $razdel = mysql_fetch_assoc ( $data ) ) :
               if ( $razdel["id"] == $news["razdel_id"] ) {
                  $result .= "<option value=\"". $razdel["id"] ."\" selected>". $razdel["title"] ."</option>";
               } else {
                  $result .= "<option value=\"". $razdel["id"] ."\">". $razdel["title"] ."</option>";
               }
         endwhile;
         $result .= "</select>";

         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/news/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"edit_news\">
                <input type=\"HIDDEN\" name=\"news\" value=\"". $news["id"] ."\">
                <tr>
                    <td><b class=porr>Редактирование новости</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Заголовок новости : </b><br>
                        <input type=\"TEXT\" class=\"button\" name=\"title\" style=\"width : 220px;\" value=\"". htmlspecialchars ( $news["title"], ENT_QUOTES ) ."\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Раздел новости : </b><br>
                        ". $result ."
                    </td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Текст новости : </b><br>
                        <textarea class=\"button\" name=\"content\" style=\"width : 550px; background : white; height : 600px;\">". htmlspecialchars ( $news["content"], ENT_QUOTES ) ."</textarea>
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

function show_delete_news_form ( ) {
         global $sql;

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_GET["news"] ."";
         $news = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/news/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"delete_news\">
                <input type=\"HIDDEN\" name=\"news\" value=\"". $news["id"] ."\">
                <tr>
                    <td><b class=porr>Удаление новости</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Заголовок новости : </b><b class=porr>". $news["title"] ."</b><br>
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

function show_edit_news_comments_form ( ) {
         global $sql;

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_GET["news"] ."";
         $news = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "SELECT `id`, `content`, `author_id`, `author_name`, `allow_html` FROM `". SQL_TABLE_NEWS_COMM ."` WHERE `news_id` = ". $_GET["news"] ." ORDER BY `id` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );
         
         print "
                <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                <form action=\"/adminka/news/index.php\" method=\"POST\">
                <input type=\"HIDDEN\" name=\"action\" value=\"edit_news_comments\">
                <input type=\"HIDDEN\" name=\"news\" value=\"". $news["id"] ."\">
                <tr>
                    <td><b class=porr>Редактирование комментариев</b><br><br></td>
                </tr>
                <tr>
                    <td>
                        <b class=por>Заголовок новости : </b><b class=porr>". $news["title"] ."</b><br>
                    </td>
                </tr>
         ";
         
         while ( $comment = mysql_fetch_assoc ( $data ) ) :
               $query = "SELECT
                               `usergroupid`
                         FROM
                               `". VBULLETIN_TABLE_PREFIX ."user`
                         WHERE
                               `userid` = ". $comment["allow_html"] ."
               ";
               $user = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               
               $query = "SELECT
                               `usergroupid`
                         FROM
                               `". VBULLETIN_TABLE_PREFIX ."user`
                         WHERE
                               `userid` = ". $comment["author_id"] ."
               ";
               $user_author = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               
               if ( $user_author["usergroupid"] != VBULLETIN_ADMIN_GROUP_ID ) {
                  if ( $user_author["usergroupid"] != $user["usergroupid"] ) {
                     $html = TRUE;
                  } else {
                     $html = FALSE;
                  }
                  $str = "
                          <b class=porr style=\"padding-left : 200px;\">HTML </b> <b class=date>[
                          <input type=\"RADIO\" style=\"height : 10px;\" name=\"html[". $comment["id"] ."]\" value=\"1\" ". ( $html ? "checked" : "" ) ."> - ВКЛ.
                          <input type=\"RADIO\" style=\"height : 10px;\" name=\"html[". $comment["id"] ."]\" value=\"0\" ". ( $html ? "" : "checked" ) ."> - ВЫКЛ. ]</b>
                  ";
               } else {
                  $str = "";
               }

               print "
                      <tr>
                          <td>
                              <br>
                              <b class=por>". $comment["author_name"] ."</b>
                              ". $str ."
                              <br>
                              <input type=\"HIDDEN\" name=\"user[". $comment["id"] ."]\" value=\"". $comment["author_id"] ."\">
                              <textarea class=\"button\" style=\"background : white; width : 440px; height : 55px;\" name=\"comment[". $comment["id"] ."]\">". htmlspecialchars ( $comment["content"], ENT_QUOTES ) ."</textarea>
                          </td>
                      </tr>
               ";
         endwhile;
         
         print "
                <tr>
                    <td>
                        <br>
                        <input type=\"SUBMIT\" class=\"button\" name=\"submit\" value=\"Изменить!\">
                    </td>
                </tr>
                </form>
                </table>
         ";
}

function show_tree ( ) {
         global $sql;

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_RAZDELS ."` WHERE `url` = 'news'";
         $razdel = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         if ( empty ( $razdel["title"] ) ) {
            exit ( "<b class=porr>У вас не создан раздел для новостей</b><br><b class=date>Добавьте раздел с сылкой (news)</b>" );
         }

         $query = "SELECT `id`, `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` ASC";
         $data = $sql->query ( $query, "print_error_and_exit" );

         if ( mysql_num_rows ( $data ) == 0 ) {
            exit ( "<b class=porr>У вас не создана как минимум 1 категория для новостей!</b>" );
         }

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
                              <b class=por>". $razdel["title"] ."</b></b>
                          </td>
                      </tr>
               ";


               $query = "SELECT `id`, `title` FROM `". SQL_TABLE_NEWS ."` WHERE `razdel_id` = ". $razdel["id"] ." ORDER BY `order` DESC LIMIT 10";
               $data2 = $sql->query ( $query, "print_error_and_exit" );
               
               if ( mysql_num_rows ( $data2 ) == 0 ) {
                  print "<tr>
                             <td style=\"padding-left : 23px;\"><b class=porr>Раздел пуст</b></td>
                         </tr>
                  ";
               } else {
               
                  while ( $news = mysql_fetch_assoc ( $data2 ) ) :
                        $query = "SELECT `id` FROM `". SQL_TABLE_NEWS_COMM ."` WHERE `news_id` = ". $news["id"] ."";
                        $c = $sql->query ( $query, "print_error_and_exit" );
                        print "
                               <tr>
                                   <td style=\"padding-left : 23px;\">
                                       <b class=date>
                                       [<a href=\"/adminka/news/index.php?action=show_edit_news_form&news=". $news["id"] ."\"><b class=porr>E</b></a>]
                                       [<a href=\"/adminka/news/index.php?action=show_delete_news_form&news=". $news["id"] ."\"><b class=porr>D</b></a>]
                                       </b>
                                       <b class=por>". $news["title"] ."</b></b>
                               ";
                        if ( mysql_num_rows ( $c ) > 0 )
                           print "
                                 <b class=date>[<a href=\"/adminka/news/index.php?action=show_edit_news_comments_form&news=". $news["id"] ."\"><b class=porr>C</b></a>]</b>
                           ";
                        print "
                                   </td>
                               </tr>
                        ";
                  endwhile;
                  
               }
         endwhile;
         
         print "</table>";
         
         
}

function add_new_news ( ) {
         global $security, $sql;

         $query = "SELECT `order` FROM `". SQL_TABLE_NEWS ."` WHERE `razdel_id` = ". $_POST["razdel"] ." ORDER BY `order` DESC LIMIT 1";
         $c = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
         
         $query = "SELECT `title` FROM `". SQL_TABLE_LM_KATEGORIES ."` WHERE `id` = ". $_POST["razdel"] ."";
         $b = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "INSERT INTO
                              `". SQL_TABLE_NEWS ."`
                   VALUES (
                              '',
                              '". $_POST["razdel"] ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
                              '". mysql_escape_string ( stripcslashes ( $_POST["content"] ) ) ."',
                              '". $security->user["userid"] ."',
                              '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                              '". date ( "Y-m-d H:i:s", time ( ) ) ."',
                              '". $security->user["userid"] ."',
                              '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                              '". date ( "Y-m-d H:i:s", time ( ) ) ."',
                              '". ( $c["order"] + 1 ) ."',
                              '0'
                   )
         ";
         $sql->query ( $query, "return_error" );
         
         $query = "UPDATE `". SQL_TABLE_STATISTICS ."` SET `news_count` = `news_count` + 1 WHERE `id` = 1";
         $sql->query ( $query, "print_error_and_exit" );
         
         if ( !$sql->error ) {
            print "<b class=porr>Новость <b class=por>". stripcslashes ( $_POST["title"] ) ."</b> успешно добавлена в раздел <b class=por>". $b["title"] ."</b>!</b>";

            $content = "New news(". $_POST["title"] .") to razdel(". $b["title"] .") added";
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

function edit_news ( ) {
         global $security, $sql;

         $query = "SELECT `title` FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_POST["news"] ."";
         $news = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "UPDATE
                         `". SQL_TABLE_NEWS ."`
                   SET
                         `razdel_id` = ". $_POST["razdel_id"] .",
                         `title` = '". mysql_escape_string ( stripcslashes ( $_POST["title"] ) ) ."',
                         `content` = '". mysql_escape_string ( stripcslashes ( $_POST["content"] ) ) ."',
                         `last_modifier_id` = ". $security->user["userid"] .",
                         `last_modifier_name` = '". $security->user["username"] ."',
                         `last_modifier_time` = '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                   WHERE
                         `id` = ". $_POST["news"] ."
                   LIMIT
                         1
         ";
         $sql->query ( $query, "return_error" );
         
         if ( !$sql->error ) {
            print "<b class=porr>Новость успешно обновлена!</b><br>";
            print "<b class=porr>Изменения :</b><br>";
            print "<b class=porr>Заголовок новости : <b class=por>". $news["title"] ." <b class=date>>>></b> ". stripcslashes ( $_POST["title"] ) ." </b></b><br>";

            $content = "Change news(". $news["title"] .") to news(". $_POST["title"] .")";
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

function delete_news ( ) {
         global $security, $sql;

         $query = "SELECT `title` FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_POST["news"] ."";
         $news = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         $query = "DELETE FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_POST["news"] ." LIMIT 1";
         $sql->query ( $query, "return_error" );

         $query = "UPDATE `". SQL_TABLE_STATISTICS ."` SET `news_count` = `news_count` - 1 WHERE `id` = 1";
         $sql->query ( $query, "print_error_and_exit" );

         if ( !$sql->error ) {
            print "<b class=porr>Новость <b class=por>". $news["title"] ."</b> успешно удалена!</b><br>";

            $content = "Delete news(". $news["title"] .")";
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

function edit_news_comments ( ) {
         global $security, $sql;
         
         $query = "SELECT `title` FROM `". SQL_TABLE_NEWS ."` WHERE `id` = ". $_POST["news"] ."";
         $news = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

         print "<b class=porr>Действия с комментариями к новости <b class=por>". $news["title"] ."</b></b><br>";

         foreach ( $_POST["comment"] as $id => $value ) :
                 if ( $_POST["comment"][$id] == "" ) {
                    $query = "DELETE FROM `". SQL_TABLE_NEWS_COMM ."` WHERE `id` = ". $id ." LIMIT 1";
                    $sql->query ( $query, "return_error" );
                    if ( !$sql->error ) {
                       print "<b class=porr>Комментарий <b class=por>id = ". $id ."</b> успешно удален!</b><bR>";
                    } else {
                       print "<b class=porr>Комментарий <b class=por>id = ". $id ."</b> не может быть удален!</b><br>";
                    }

                    $query = "UPDATE `". SQL_TABLE_STATISTICS ."` SET `news_comm_count` = `news_comm_count` - 1 WHERE `id` = 1";
                    $sql->query ( $query, "print_error_and_exit" );
                    
                 } else {
                    $query = "SELECT
                                    `usergroupid`
                              FROM
                                    `". VBULLETIN_TABLE_PREFIX ."user`
                              WHERE
                                    `userid` = ". $_POST["user"][$id] ."
                    ";
                    $user = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );

                    if ( $user["usergroupid"] != VBULLETIN_ADMIN_GROUP_ID ) {
                       $str = ", `allow_html` = ". ( $_POST["html"][$id] == 1 ? $security->user["userid"] : $_POST["user"][$id] ) ."";
                    } else {
                       $str = "";
                    }

                    $query = "UPDATE
                                    `". SQL_TABLE_NEWS_COMM ."`
                              SET
                                    `content` = '". mysql_escape_string ( stripcslashes ( $_POST["comment"][$id] ) ) ."',
                                    `last_modifier_id` = ". $security->user["userid"] .",
                                    `last_modifier_name` = '". mysql_escape_string ( stripcslashes ( $security->user["username"] ) ) ."',
                                    `last_modifier_time` = '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                                    ". $str ."
                              WHERE
                                    `id` = ". $id ."
                              LIMIT
                                    1
                              ";
                    $sql->query ( $query, "return_error" ) ;
                    if ( !$sql->error ) {
                       print "<b class=porr>Комментарий <b class=por>id = ". $id ."</b> успешно обновлен!</b><br>";
                    } else {
                       print "<b class=porr>Комментарий <b class=por>id = ". $id ."</b> не может быть обновлен!</b><br>";
                    }
                 }
         endforeach;
         
         $content = "Edit news(". $news["title"] .") comments";
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
}

if ( isset ( $_GET["action"] ) or isset ( $_POST["action"] ) ) {
   $action = isset ( $_GET["action"] ) ? $_GET["action"] : $_POST["action"];
   switch ( $action ) :

          case "show_select_razdel_to_add_new_news_form" :
               show_select_razdel_to_add_new_news_form ( );
          break;
          
          case "show_add_new_news_form" :
               show_add_new_news_form ( );
          break;
          
          case "show_edit_news_form" :
               show_edit_news_form ( );
          break;
          
          case "show_delete_news_form" :
               show_delete_news_form ( );
          break;
          
          case "show_edit_news_comments_form" :
               show_edit_news_comments_form ( );
          break;
          
          case "show_tree" :
               show_tree ( );
          break;

          case "add_new_news" :
               add_new_news ( );
          break;
          
          case "edit_news" :
               edit_news ( );
          break;

          case "delete_news" :
               delete_news ( );
          break;
          
          case "edit_news_comments" :
               edit_news_comments ( );
          break;

   endswitch;
}

$sql->close ( );
?>

</body>

</html>