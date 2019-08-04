<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Информация о пользователе <?php echo $user; ?></title>
	<link rel="STYLESHEET" type="text/css" href="style.css">
</head>
<script type="text/javascript" language="JavaScript">
function get()
{window.open ("Forum.php", "_parent");}
</script>
<body bgcolor="#000000" style="color:White; margin:30px;">
<?php
require("config.php");//Файл настроек

$size=StrLen($user);
$encoded_nick=null;
for($i=0;$i<$size;$i++) $encoded_nick.=base_convert(ord($user[$i]),10,32).chr(125);

$fname=strtolower($encoded_nick);
$file="reg/$fname.txt";
if (is_file($file)){
	$fp=file($file);

	$s0=explode("|",$fp[0]);//Nick
	$s2=explode("|",$fp[2]);//E-mail
	$s3=explode("|",$fp[3]);//Аватар
	$s4=explode("|",$fp[4]);//Сайт
	$s5=explode("|",$fp[5]);//Хобби
	$s7=explode("|",$fp[7]);//ICQ

	$nick=$s0[1];
	$mail=$s2[1];
	$avatar=$s3[1];
	$site=$s4[1];
	$hobby=$s5[1];
	$icq=$s7[1];

	echo ("
	<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"filter: alpha(opacity=85);\" width=\"500\">
	<tr>
	    <td width=\"10\" height=\"10\"><img src=\"lvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\" width=\"100%\"><img src=\"ne.gif\" width=\"1\" height=\"1\" border=\"0\"></td>
	    <td width=\"10\" height=\"10\"><img src=\"pvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	<tr>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"1\" border=\"0\"></td>
	    <td background=\"bgF.gif\" width=\"100%\"><h1 class=\"tim\" style=\"letter-spacing:1px;\">Информация о пользователе:</h1>
			<table cellpadding=\"10\" cellspacing=\"0\" width=\"100%\">
			<tr>
				<td class=\"spisock\" width=\"150\"><em class=\"fuz\" style=\"font-weight:bold;\">Пользователь:</em><br></td>
				<td class=\"spisock\" style=\"border-right:0px;\">
					<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
					<tr>
						<td align=\"center\" width=\"100%\"><b style=\"color:#ffff33; letter-spacing:2px; font-weight:bold;\">".$nick."</b></td>
						<td align=\"right\"><img src=\"../worldkr.gif\" width=\"100\" height=\"40\"></td>
					</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td class=\"spisock\" width=\"150\"><em class=\"fuz\" style=\"font-weight:bold;\">E-mail:</em><br></td>
				<td class=\"spisock\" style=\"border-right:0px;\"><a href=\"mailto:".$mail."\" target=\"_blank\">".$mail."</a></td>
			</tr>

			<tr>
				<td class=\"spisock\" width=\"150\"><em class=\"fuz\" style=\"font-weight:bold;\">Сайт:</em></td>
				<td class=\"spisock\" style=\"border-right:0px;\"><a href=\"http://".$site."\" target=\"_blank\" style=\"cursor:hand;\">".$site."</a></td>
			</tr>

			<tr>
				<td class=\"spisock\" width=\"150\"><em class=\"fuz\" style=\"font-weight:bold;\">Хобби:</em><br></td>
				<td class=\"spisock\" style=\"border-right:0px;\">".$hobby."</td>
			</tr>

			<tr>
				<td class=\"spisock\" width=\"150\"><em class=\"fuz\" style=\"font-weight:bold;\">ICQ:</em><br></td>
				<td class=\"spisock\" style=\"border-right:0px;\">".$icq."</td>
			</tr>
			</table>
			<p></p>
			<table align=\"center\" cellspacing=\"10\" width=\"100%\">
			<tr>
				<td align=\"right\"><div align=\"center\"><div class=\"text\"><<<</div><div class=\"shadow\" UNSELECTABLE=\"on\"><<<</div></td>
				<td align=\"center\"><INPUT class=\"fuzzy\" TYPE=BUTTON style=\"cursor:hand;\" onclick=\"get()\" VALUE=\"Вернуться на форум\"></td>
				<td align=\"left\"><div class=\"text\">>>></div><div class=\"shadow\" UNSELECTABLE=\"on\">>>></div></td>
			</tr>
			</table>
			</td>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"1\" border=\"0\"></td>
	</tr>
	<tr>
	    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"1\" height=\"10\" border=\"0\"></td>
	    <td><img src=\"pnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	</table>
	");

/*
echo "
<br><br><div align=\"center\"><em class=\"small\">Последние десять сообщений пользователя :</em></div>
<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"filter: alpha(opacity=80);\">
	<tr>
	    <td width=\"10\" height=\"10\"><img src=\"lvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\" width=\"100%\"><img src=\"ne.gif\" width=\"1\" height=\"1\" border=\"0\"></td>
	    <td width=\"10\" height=\"10\"><img src=\"pvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	<tr>
		<td background=\"bgF.gif\"></td>
		<td background=\"bgF.gif\">
		<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">
	";
$fname=str_replace("$rash_text","",$fname);
if (is_file("$user_files_dir/$fname")){
	$fm=file("$user_files_dir/$fname");
	
	$fm=str_replace("[r]","<font color='#FF0000'>",$fm);
	$fm=str_replace("[y]","<font color='#FFFF00'>",$fm);
	$fm=str_replace("[w]","<font color='#3E842F'>",$fm);
	$fm=str_replace("[/c]","</font>",$fm);
	$fm=str_replace("[url]","<a href='http://",$fm);
	$fm=str_replace("[/url]","' target='_blank'><font style='font-weight:bold;'>ссылка</font></a>",$fm);
	$fm=str_replace("[смущ]","<img src='blush.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[спок]","<img src='crazy.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[хммм]","<img src='frown.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[хаха]","<img src='laugh.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[зло]","<img src='mad.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[шок]","<img src='shocked.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[улыбка]","<img src='smile.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[бебе]","<img src='tongue.gif' width='15' height='15' alt='' border='0'>",$fm);
	$fm=str_replace("[миг]","<img src='wink.gif' width='15' height='15' alt='' border='0'>",$fm);
	
	$fm=array_reverse($fm);
	$count=sizeof($fm);
	if (isset($to)){$to=$count;}
		else {if ($count<11){$to=$count;}else{$to=10;}}
	for ($i=0; $i<=$to; $i++):
		list($tema, $date, $nick, $email, $mes)=explode("|Fuz|",$fm[$i]);
		echo "
		<tr>
			<td class=\"but2\" class=\"spisock\" width=\"100%\" align=\"left\" style=\"padding-left:10px;\">".$tema."</td>
			<td class=\"small\" style=\"background-color : #4F7FBF;	border-style : solid solid none none;	border : 1px solid #456374;	TEXT-DECORATION: none;	FONT-FAMILY: Tahoma, Verdana, sans-serif;\">".$date."</td>
		</tr>
		<tr>
			<td colspan=\"2\" class=\"spisock\" style=\"text-align:left; padding-left:20px; border-left : 1px solid #77959F;\">".$mes."</td>
		</tr>
		<tr>
			<td colspan=\"2\" width=\"100%\" height=\"10\"><img src=\"ne.gif\" width=\"100%\" height=\"100%\" border=\"0\"></td>
		</tr>
		";
	endfor;
}
echo "
		</table>
		</td>
		<td background=\"bgF.gif\"></td>
	</tr>
	<tr>
	    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"1\" height=\"10\" border=\"0\"></td>
	    <td><img src=\"pnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
</table>";

if ($count<11){}else{
print "
	<a href=\"user.php?user=$user&to=all\" target=\"_parent\" style=\"cursor:hand;\">Посмотреть ВСЕ сообщения пользователя</a>
	";
}
*/
}
else
{
	echo ("<div align='center'><font color='Yellow'><h2>...Извините...<br></h2><h3>Информация о пользователе <b style=\"color:Maroon;\">$user</b> не была найдена в базе данных</h3></font></div>");
}

?>
</body>
</html>
