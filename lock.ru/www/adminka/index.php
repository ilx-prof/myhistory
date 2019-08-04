<?php
require_once "../config.php";
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
        exit ( );
     }
  }
} else {
  exit ( );
}

$sql->close ( );

?>
<html>
<head>
      <meta HTTP-EQUIV="Content-Type" Content="text-html; charset=windows-1251">
      <title>Lock-Team Admin Panel</title>
      <link rel="stylesheet" type="text/css" href="/style/templates/lock-team/css/style.css">
      <link rel="shortcut icon" href="/style/templates/lock-team/images/favicon.ico">
</head>

<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0" style"position: absolute; left:0px; top:0px; background:white;">

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%" bgcolor="white">
<tr>
    <td width="200" height="100%">
        <table cellpadding="0" cellspacing="0" border="0" width="200" height="100%">
        <tr>
            <td width="200" height="169">
                <div style="height:169px;">
                     <table cellpadding="0" cellspacing="1" border="0" width="200" style="background:url(/style/templates/lock-team/images/1.jpg); background-repeat: no-repeat;" height="169">
                     <tr>
                         <td valign="top" align="center" width="200"><b class=por>Админская панель<br>хак-комманды</b><br><b class=porr>Lock-Team</b></td>
                     </tr>
                     <tr>
                         <td height="100%" width="200"></td>
                     </tr>
                     </table>
                     <br>
                </div>
            </td>
        </tr>
        <tr>
            <td height="100%" width="200">
                <div style="height:100%">
                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr>..::[ MySQL ]::..</b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="create_all.php" target="pole">: создать всё :</a></td>
                     </tr>
                     </table>
                     
                     <br>
                     
                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr><?php print INF_MENU_LEFT_NAME; ?></b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="navigation/index.php?action=show_add_new_razdel_form" target="pole">: новый <b class=date>раздел</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="navigation/index.php?action=show_select_razdel_to_add_new_kategoria_form" target="pole">: новая <b class=date>категория</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="navigation/index.php?action=show_razdel_order_tree" target="pole">: порядок <b class=date>разделов</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="navigation/index.php?action=show_kategoria_order_tree" target="pole">: порядок <b class=date>категорий</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="navigation/index.php?action=show_tree" target="pole">: операции с <b class=date>[р]</b> и <b class=date>[к]</b> :</a></td>
                     </tr>
                     </table>
                     
                     <br>

                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr>::..[ Articles ]..::</b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="articles/index.php?action=show_select_razdel_to_add_new_article_form" target="pole">: добавить <b class=date>статью</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="articles/index.php?action=show_articles_order_tree" target="pole">: порядок <b class=date>статей</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="articles/index.php?action=show_tree" target="pole">: операции со <b class=date>статьями</b> :</a></td>
                     </tr>
                     </table>

                     <br>

                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr>::..[ News ]..::</b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="news/index.php?action=show_select_razdel_to_add_new_news_form" target="pole">: добавить <b class=date>новость</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="news/index.php?action=show_tree" target="pole">: операции с <b class=date>новостями</b> :</a></td>
                     </tr>
                     </table>

                     <br>

                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr><?php print INF_MENU_FRIENDS_NAME; ?></b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="friends/index.php?action=show_add_new_friend_form" target="pole">: добавить <b class=date>"друга"</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="friends/index.php?action=show_friend_order_tree" target="pole">: порядок <b class=date>"друзей"</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="friends/index.php?action=show_tree" target="pole">: операции с <b class=date>"друзьями"</b> :</a></td>
                     </tr>
                     </table>
                     
                     <br>

                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr><?php print INF_MENU_MEMBERS_NAME; ?></b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="members/index.php?action=show_add_new_member_form" target="pole">: добавить <b class=date>"члена"</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="members/index.php?action=show_member_order_tree" target="pole">: порядок <b class=date>"членов"</b> :</a></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="members/index.php?action=show_tree" target="pole">: операции с <b class=date>"членами"</b> :</a></td>
                     </tr>
                     </table>

                     <br>

                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr>.:.[ Service ].:.</b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="service/index.php?action=show_requests" target="pole">: запросы :</a></td>
                     </tr>
                     </table>

                     <br>

                     <table cellpadding="0" cellspacing="1" border="0" width="200" bgColor="#999999">
                     <tr>
                         <td align="center" valign="top" style="background-color : #fcfcfc; background-image:url(/style/templates/lock-team/images/001.gif)"><b class=porr>.:.[ Statistics ].:.</b></td>
                     </tr>
                     <tr>
                         <td align="center" valign="top" style="background-color:rgb(252,252,252);"><a href="statistics/index.php?action=recount" target="pole">: пересчитать :</a></td>
                     </tr>
                     </table>
                     
                </div>
            </td>
        </tr>
        <tr>
            <td height="139" width="200">
                <div style="height:139px;">
                     <table cellpadding="0" cellspacing="0" border="0" width="200" height="139" style="background-image:url(/style/templates/lock-team/images/2.jpg);">
                     <tr>
                         <td height="100%"></td>
                     </tr>
                     </table>
                </div>
            </td>
        </tr>
        </table>
    </td>
    <td width="100%" height="100%">
        <iframe src="/" name="pole" class="button" style="background:white; width:100%; height:100%;">
    </td>
</tr>
</table>

</body>

</html>