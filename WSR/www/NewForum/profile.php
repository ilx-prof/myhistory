<?php
require("config.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Профиль - изменение информации о пользователе:</title>
	<link rel="STYLESHEET" type="text/css" href="style.css">
</head>
<script type="text/javascript" language="JavaScript">
function get()
{window.open ("Forum.php", "_parent");}
</script>
<body bgcolor="#000000" style="color:white;">
<?php
## /* Проверка на COOKIES данные(существуют в базе данных или нет) */ ##
$dogg[0]=null; $dogg[1]=null; $dogg[2]=null;
$addform="hide";
$tochno="no";
$anon="no";
if (!empty($_COOKIE["Worldkr"])):
	$dogg=explode("||",$_COOKIE["Worldkr"]);
	$dogg[0]=strtolower($dogg[0]);
	$dogg[1]=strtolower($dogg[1]);
	$file="reg/$dogg[0].txt";
	if (file_exists($file)){
		$fq=file($file);
		$v=explode("|",$fq[1]);
		$vn=explode("|",$fq[0]);
		$v[1]=strtolower($v[1]);
			if ($dogg[1]==$v[1]){
				$tochno="yes";
				if ($dogg[0]=='31}3e}3f}3e}3p}3d}')$anon="yes";
			}
	}

$array=explode(chr(125),$v[1]);
$decoded_pass=null; 
    while(list($s,$char)=each($array)) 
    $decoded_pass.=chr(base_convert($char,32,10)); 

	$s2=explode("|",$fq[2]);//E-mail
	$s3=explode("|",$fq[3]);//Аватар
	$s4=explode("|",$fq[4]);//Сайт
	$s5=explode("|",$fq[5]);//Хобби
	$s6=explode("|",$fq[6]);//Подпись
	$s7=explode("|",$fq[7]);//ICQ

/////////////////////////////<b>hobby is my hobby</b>
if ((isset($edit))&&($edit=='1')&&($tochno=='yes')):

	$fp=fopen("reg/$dogg[0].txt","w+");
	flock ($fp,LOCK_EX);

	$avatar=eregi_replace("^(((h)*)((t)*)((p)*)((:)*)(/{1,}))","",$avatar);
	$avatar=eregi_replace("((/)*)$","",$avatar);
	$site=eregi_replace("^(((h)*)((t)*)((p)*)((:)*)(/{2,}))","",$site);
	$site=eregi_replace("((/)*)$","",$site);
	$podpis=str_replace("\r\n","<br>",$podpis);

	$dano="nick      |$nick|\r\npassword  |$dogg[1]|\r\ne-mail    |$mail|\r\navatar    |$avatar|\r\nsite      |$site|\r\nhobby     |$hobby|\r\npodpis    |$podpis|\r\nICQ       |$icq|\r\n$mes";
	fwrite($fp,$dano);
	fflush ($fp);
	flock ($fp,LOCK_UN);
	fclose($fp);
endif;
###################################################

if (($tochno=='yes')&&(isset($edit))&&($edit!='1')&&($anon=='no')):
	$nick=$vn[1];
	$password=$decoded_pass;
	$mail=$s2[1];
	$avatar=$s3[1];
	$site=$s4[1];
	$hobby=$s5[1];
	$podpis=$s6[1];
	$icq=$s7[1];
$podpis=str_replace("<br>","\r\n",$podpis);

	echo ("
	<form action=\"profile.php?edit=1\" method=\"post\">
	<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"filter: alpha(opacity=85);\" width=\"600\">
	<tr>
	    <td><img src=\"lvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"1\" height=\"1\" border=\"0\"></td>
	    <td><img src=\"pvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	<tr>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"1\" border=\"0\"></td>
	    <td background=\"bgF.gif\"><h1 class=\"tim\" style=\"letter-spacing:1px;\">Изменение информации о пользователе<br><font style=\"text-decoration:underline;\" color=\"White\">".$nick."</font></h1>
	<table cellpadding=\"10\" cellspacing=\"0\">
	<tr><td class=\"spisock\"><em class=\"fuz\" style=\"font-weight:bold;\">LOGIN:</em><br></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><a href=\"user.php?user=".$nick."\" style=\"cursor:hand;\"><div class=\"text\" style=\"font-size:14px;\">".$nick."</div><div class=\"shadow\" style=\"font-size:13px;\" UNSELECTABLE=\"on\">".$nick."</div></a><input type=\"Hidden\" name=\"nick\" value=\"".$nick."\"></td></tr>

	<tr><td class=\"spisock\"><em class=\"fuz\" style=\"font-weight:bold;\">PASSWORD:</em><br></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><div class=\"text\" style=\"letter-spacing:1px;\">".$password."</div></td></tr>

	<tr><td class=\"spisock\"><em class=\"fuz\">E-mail:</em><br></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><INPUT class=\"forma\" TYPE=\"TEXT\"  size=\"60\" NAME=\"mail\" value=\"".$mail."\"></td></tr>

	<tr><td class=\"spisock\">&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <em class=\"fuz\">Аватар:</em>&nbsp;&nbsp;&nbsp;&nbsp;<font class=\"small\">http://</font></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><INPUT class=\"forma\" TYPE=\"TEXT\"  size=\"60\" NAME=\"avatar\" value=\"".$avatar."\"></td></tr>

	<tr><td class=\"spisock\"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<em class=\"fuz\">Сайт:</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class=\"small\">http://</font></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><INPUT class=\"forma\" TYPE=\"TEXT\"  size=\"60\" NAME=\"site\" value=\"".$site."\"></td></tr>

	<tr><td class=\"spisock\"><em class=\"fuz\">Хобби:</em><br></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><INPUT class=\"forma\" TYPE=\"TEXT\"  size=\"60\" NAME=\"hobby\" value=\"".$hobby."\"></td></tr>

	<tr><td class=\"spisock\"><em class=\"fuz\">ICQ:</em><br></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><INPUT class=\"forma\" TYPE=\"TEXT\"  size=\"60\" NAME=\"icq\" value=\"".$icq."\"></td></tr>

	<tr><td class=\"spisock\"><em class=\"fuz\">Подпись:</em><br><font class=\"small\">независимо от того как давно вы оставили сообщение на форуме, подпись всегда будет ниже вашего сообщения.</font></td>
		<td class=\"spisock\" style=\"border-right:0px;\"><textarea class=\"forma\" rows=\"6\" cols=\"46\" name=\"podpis\">".$podpis."</textarea></td></tr>
	</table>
	<p>
	<input type=\"Hidden\" name=\"mes\" value=\"".$fq[8]."\">
	<table align=\"center\" cellspacing=\"10\">
	<tr>
		<td><div align=\"center\"><div class=\"text\"><<<</div><div class=\"shadow\" UNSELECTABLE=\"on\"><<<</div></td>
		<td><INPUT class=\"fuzzy\" TYPE=SUBMIT style=\"cursor:hand;\" VALUE=\"Изменить информацию\"></td>
		<td><div class=\"text\">>>></div><div class=\"shadow\" UNSELECTABLE=\"on\">>>></div></td>
	</tr>
	</table>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"1\" border=\"0\"></td>
	</tr>
	<tr>
	    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"1\" height=\"10\" border=\"0\"></td>
	    <td><img src=\"pnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	</table><br><br>
	<div align=\"center\"><input class=\"fuzzy\" type=\"Button\" onclick=\"get()\" style=\"cursor:hand;\" value=\"Вернуться на форум\"></div>
	");
endif;

if ((isset($edit))&&($edit=='1')):
	echo("
	<div align=\"center\">Информация была успешно изменена.</div><br>
	<div align=\"center\"><input class=\"fuzzy\" type=\"Button\" onclick=\"get()\" style=\"cursor:hand;\" value=\"Вернуться на форум\"></div>
	");
endif;

endif;

if ((!isset($tochno))or($anon=='yes')):
	echo "
	<div align=\"center\" style=\"color:red; font-size:15px;\">Для изменения информации Вам надо авторизироваться.</div><br>
	<div align=\"center\"><input class=\"fuzzy\" type=\"Button\" onclick=\"get()\" style=\"cursor:hand;\" value=\"Вернуться на форум\"></div>
	";
endif;
?>
</body>
</html>
