<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> �����</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=Windows-1251">
	<META NAME="page-topic" CONTENT="��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> �����"> 
	<META NAME="title" CONTENT="��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> �����">
	<META NAME="description" CONTENT="���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������.">
	<META NAME="abstract" CONTENT="���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������.">
	<META Name="keywords" Content="�������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������">
	<META NAME="revisit" CONTENT="15 days">
	<META NAME="revisit-after" CONTENT="15 days">
	<META NAME="Content-Language" CONTENT="english">
	<META NAME="audience" CONTENT="all">
	<META NAME="robots" CONTENT="index,all">
	<META NAME="Author" CONTENT="Denis Korneev, Copyright 2003-2005 - fuzzy@worldkr.fatal.ru">
	<META NAME="Copyright" CONTENT="Denis Korneev - fuzzy@worldkr.fatal.ru">
	<META NAME="Reply-to" CONTENT="fuzzy@worldkr.fatal.ru">
	<META NAME="home_url" CONTENT="http://www.worldkr.fatal.ru/index.php">
	<META NAME="Generator" CONTENT="Notepad!">
	<META NAME="distribution" CONTENT="Global"> 
	<META NAME="rating" CONTENT="General">
	<META NAME="site-created" CONTENT="25-08-2003">
<link rel='STYLESHEET' type='text/css' href='style.css'>
<!-- ���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������. -->
<!-- �������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������ -->
<!-- ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> ����� -->
<!-- ��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->

</head>
<script src="ban.js" type="text/javascript"></script>
<body style="margin:30px;">
<!-- ���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������. -->
<!-- �������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������ -->
<!-- ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> ����� -->
<!-- ��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->

<?php
error_reporting (E_ALL);
require("config.php");//���� ��������

//�������
$show="messages/mess/other/$show.htm";

$priz=eregi_replace(".htm$",".dat", $show);
$filename=$priz;
if (file_exists($priz)){$fp = @fopen($filename,"rb");
$counter=fgets($fp,10);
$counter=$counter+1;
fclose($fp);
$fp=fopen($filename,"r+b");
fwrite($fp,$counter);
fclose($fp);}
else{$fa = @fopen($filename,"w+");$counter=1; $asd="$counter\n\n\n\n\n"; fwrite($fa,$asd); fclose($fa);}
echo $show;
$m=fopen($show,"rb");
$ourfile=fread($m,filesize($show));
	$ourfile=str_replace("[r]","<font color='#FF0000'>",$ourfile);
	$ourfile=str_replace("[/c]","</font>",$ourfile);
	$ourfile=str_replace("[y]","<font color='#FFFF00'>",$ourfile);
	$ourfile=str_replace("[w]","<font color='#FFFFFF'>",$ourfile);
	$ourfile=str_replace("[url]","<a href='http://",$ourfile);
	$ourfile=str_replace("[/url]","' target='_blank'><font style='font-weight:bold;'>������</font></a>",$ourfile);
	$ourfile=str_replace("[����]","<img src='blush.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[����]","<img src='crazy.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[����]","<img src='frown.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[����]","<img src='laugh.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[���]","<img src='mad.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[���]","<img src='shocked.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[������]","<img src='smile.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[����]","<img src='tongue.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[���]","<img src='wink.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("&q","&quot;",$ourfile);
	list($dateO, $nickO, $mailO, $mesO)=explode("|Fuz|",$ourfile);

	if (!eregi("^([0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-wyz][a-z](fo|g|l|m|mes|o|op|pa|ro|seum|t|u|v|z)?)$", $mailO))
	{$mailO="��� ����������";}
	else
	{$mailO="<a href=\"mailto:".$mailO."\">".$mailO."</a>";}


$priz=str_replace(".dat",".snif",$priz);
$fileName="$priz"; //��� ����� �� �����������
include("sniffer.php");


echo ("
<table align=\"center\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"filter: alpha(opacity=85);\">
<tr>
    <td><img src=\"lvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	<td width=\"100%\" background=\"bgF.gif\" align=\"center\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
    <td><img src=\"pvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
</tr>
<tr>
    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
    <td background=\"bgF.gif\">
	<table border=\"0\" width=\"100%\" height=\"100%\" cellpadding=\"10\">
		<tr>
<td width=\"150\" valign=\"top\" align=\"center\"><div class=\"text\">".$nickO."</div><div class=\"shadow\" UNSELECTABLE=\"on\">".$nickO."</div><br>".$mailO."<br><h2 class=\"small\">".$dateO."</h2></td>
<td class=\"Otvet\">");
echo $mesO;
echo 		("</td>
		</tr> 
	</table>
	</td>
    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
</tr>
<tr>
    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
    <td background=\"bgF.gif\" align=\"center\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
    <td><img src=\"pnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
</tr>
</table><br><br>
");
?>
<!-- ��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- ���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������. -->
<!-- �������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������ -->
<!-- ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> ����� -->
<script type="text/javascript" language="JavaScript">
function get()
{window.open ("Forum.php", "_parent");}
</script>
<div align="center"><input class="fuzzy" type="Button" onclick="get()" style="cursor:hand;" value="��������� � ������ ���"></div><br><br><br>
<?php if(file_exists("ban")){include("ban");} ?>
<!-- ��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- ���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������. -->
<!-- �������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������ -->
<!-- ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> ����� -->
</body>
<!-- ��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- ���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������. -->
<!-- �������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������ -->
<!-- ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> ����� -->
</html>