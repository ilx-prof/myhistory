<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script src="ban.js" type="text/javascript"></script>
<?
error_reporting (E_ALL);
require("config.php");

	if (!isset($ras)){
		$ras=' ';
	}
//���������� ������.
$fp=fopen("glukaddmes.txt","a+b");
flock ($fp,LOCK_EX);
$str="$date&nbsp;&nbsp;$time|Fuz|$nick|Fuz|$mail|Fuz|$mes|Fuz|$ras|Fuz|$no|Fuz|\r\n";
fwrite($fp,$str);
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
//�����������

if ((isset($no))&&(isset($mes))&&(isset($nick))&&(isset($mail))&&(isset($date))&&(isset($time))&&(isset($ras)))
{
	$file=fopen("messages/$ra/$no.txt","a+");
	flock ($file,LOCK_EX);
	$mes=htmlspecialchars($mes);
		$mes=eregi_replace("\n","<br>",$mes);
	$nick=htmlspecialchars($nick);
	$mail=htmlspecialchars($mail);
	$mail=strtolower($mail);
	$mail=ereg_replace(" ","",$mail);
		$mes=str_replace("\&quot;","&q",$mes);
		$mes=str_replace("\'","'",$mes);
	$dan="$date&nbsp;&nbsp;$time|Fuz|$nick|Fuz|$mail|Fuz|";
		$dan=str_replace("[r]","",$dan);$dan=str_replace("[/r]","",$dan);
		$dan=str_replace("[y]","",$dan);$dan=str_replace("[/y]","",$dan);
		$dan=str_replace("[w]","",$dan);$dan=str_replace("[/w]","",$dan);
		$dan=str_replace("[url]","",$dan);$dan=str_replace("[/url]","",$dan);
		$dan=str_replace("[����]","",$dan);
		$dan=str_replace("[����]","",$dan);
		$dan=str_replace("[����]","",$dan);
		$dan=str_replace("[����]","",$dan);
		$dan=str_replace("[���]","",$dan);
		$dan=str_replace("[���]","",$dan);
		$dan=str_replace("[������]","",$dan);
		$dan=str_replace("[����]","",$dan);
		$dan=str_replace("[���]","",$dan);

	$dana="$dan$mes|Fuz|$ras|Fuz|";
	fwrite($file,"\n$dana");
	fflush ($file);
	flock ($file,LOCK_UN);
	fclose($file);
	
	$fname=strtolower($nick);
	$ft=file("messages/$ra/$no.txt");
	list($tema)=explode("|Fuz|",$ft[0]);
	$fp=fopen("user/$nick","a+b");
	flock ($fp,LOCK_EX);
	$all="$tema|Fuz|$date&nbsp;&nbsp;$time|Fuz|$nick|Fuz|$mail|Fuz|$mes|Fuz|$ras|Fuz|";
	fwrite($fp,"$all\r\n");
	fflush ($fp);
	flock ($fp,LOCK_UN);
	fclose($fp);
}
?>
	<title>���������� ������! ::::: ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> �����</title>
	<meta http-equiv="refresh" content="5; url=<?php echo ("index.php?show=$no&door=$ra");?>"> 
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
	<link rel="STYLESHEET" type="text/css" href="style.css">
<!-- ���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������. -->
<!-- �������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������ -->
<!-- ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> ����� -->
<!-- ��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
</head>

<body bgcolor="#000000" style="margin:30px;">

<!-- ���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������. -->
<!-- �������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������ -->
<!-- ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> ����� -->
<!-- ��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<table align="center" cellspacing="0" cellpadding="0" border="0" style="filter: alpha(opacity=85);">
<tr>
    <td><img src="lvF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="1" border="0"></td>
    <td><img src="pvF.gif" width="10" height="10" border="0"></td>
</tr>
<tr>
    <td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
    <td background="bgF.gif"><h1 class="Tim">���� ��������� ���������!</h1>
	<hr color="#77959F" size="1">
	<div align="center"><em class="fuz">��������� �������� ������.<br> �������� ������������� �������� � ����.</em></div>
	<hr color="#77959F" size="1">
	<p></p>
<table align="center" cellspacing="10">
	<tr>
	<td><div align="center"><div class="text"><<<</div><div class="shadow" UNSELECTABLE="on"><<<</div></td>
	<td align="center" style="cursor:hand;"><a href='<?php echo ("Forum.php");?>' style="cursor:hand;"><em class="fuzzy">&nbsp;&nbsp;&nbsp;������� � ������ ���&nbsp;&nbsp;&nbsp;</em></a><br><br><a href='<?php echo ("index.php?show=$no&f=$f&door=$ra");?>' style="cursor:hand;"><em class="fuzzy">&nbsp;&nbsp;&nbsp;��������� � ����&nbsp;&nbsp;&nbsp;</em></a></td>
	<td><div class="text">>>></div><div class="shadow" UNSELECTABLE="on">>>></div></td>
</tr>
</table>
</td>
	<td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
</tr>
<tr>
    <td><img src="lnF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="10" border="0"></td>
    <td><img src="pnF.gif" width="10" height="10" border="0"></td>
</tr>
</table>
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
