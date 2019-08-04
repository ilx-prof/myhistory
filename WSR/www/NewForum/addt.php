<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script src="ban.js" type="text/javascript"></script>
<?
error_reporting (E_ALL);
require("config.php");

for ($got=0; $got<=$to; $got++):
	if (file_exists("messages/$ra/$got.txt")){
		$g=$to;
	}
	else{
		$g=$got;
		break;
	}
endfor;

	if (!isset($ras)){
		$ras='none';
	}
//абсолютная запись.
$fp=fopen("glukaddtem.txt","a+b");
flock ($fp,LOCK_EX);
$str="$tema|Fuz|$date&nbsp;&nbsp;$time|Fuz|$nick|Fuz|$mail|Fuz|$mes|Fuz|$ras|Fuz|$g|Fuz|\r\n";
fwrite($fp,$str);
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
//закончилась

if ((isset($mes))&&(isset($nick))&&(isset($mail))&&(isset($tema))&&(isset($date))&&(isset($time))&&(isset($ras)))
{
	$file=fopen("messages/$ra/$g.txt","a+");
	flock ($file,LOCK_EX);
	$mes=htmlspecialchars($mes);
		$mes=eregi_replace("\n","<br>",$mes);
	$nick=htmlspecialchars($nick);
	$tema=htmlspecialchars($tema);
	$mail=htmlspecialchars($mail);
	$mail=strtolower($mail);
	$mail=ereg_replace(" ","",$mail);
		$mes=str_replace("\&quot;","&q",$mes);
		$mes=str_replace("\'","'",$mes);
	$tema=str_replace("\&quot;","&q",$tema);
	$tema=str_replace("\'","'",$tema);
	$dan="$tema|Fuz|$date&nbsp;&nbsp;$time|Fuz|$nick|Fuz|$mail";
		$dan=str_replace("[r]","",$dan);$dan=str_replace("[/r]","",$dan);
		$dan=str_replace("[y]","",$dan);$dan=str_replace("[/y]","",$dan);
		$dan=str_replace("[w]","",$dan);$dan=str_replace("[/w]","",$dan);
		$dan=str_replace("[url]","",$dan);$dan=str_replace("[/url]","",$dan);
		$dan=str_replace("[смущ]","",$dan);
		$dan=str_replace("[спок]","",$dan);
		$dan=str_replace("[хммм]","",$dan);
		$dan=str_replace("[хаха]","",$dan);
		$dan=str_replace("[зло]","",$dan);
		$dan=str_replace("[шок]","",$dan);
		$dan=str_replace("[улыбка]","",$dan);
		$dan=str_replace("[бебе]","",$dan);
		$dan=str_replace("[миг]","",$dan);

	$dana="$dan|Fuz|$mes|Fuz|$ras|Fuz|";
	fwrite($file,"$dana");
	fflush ($file);
	flock ($file,LOCK_UN);
	fclose($file);

	$fname=strtolower($nick);
	$fp=fopen("user/$nick","a+b");
	flock ($fp,LOCK_EX);
	$all="$tema|Fuz|$date&nbsp;&nbsp;$time|Fuz|$nick|Fuz|$mail|Fuz|$mes|Fuz|$ras|Fuz|";
	fwrite($fp,"$all\r\n");
	fflush ($fp);
	flock ($fp,LOCK_UN);
	fclose($fp);
}
?>
	<title>Создание новой темы ::::: СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум</title>
	<meta http-equiv="refresh" content="5; url=Forum.php"> 
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=Windows-1251">
	<META NAME="page-topic" CONTENT="СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум"> 
	<META NAME="title" CONTENT="СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум">
	<META NAME="description" CONTENT="Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.">
	<META NAME="abstract" CONTENT="Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.">
	<META Name="keywords" Content="реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты">
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
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->

</head>

<body bgcolor="#000000" style="margin:30px;">
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->

<table align="center" cellspacing="0" cellpadding="0" border="0" style="filter: alpha(opacity=85);">
<tr>
    <td><img src="lvF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="1" border="0"></td>
    <td><img src="pvF.gif" width="10" height="10" border="0"></td>
</tr>
<tr>
    <td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
    <td background="bgF.gif"><h1 class="Tim">Ваша тема добавлена!</h1>
	<hr color="#77959F" size="1">
	<div align="center"><em class="fuz">Подождите несколко секунд.<br> Страница автоматически перейдет на форум.</em></div>
	<hr color="#77959F" size="1">
	<p></p>
<table align="center" cellspacing="10">
	<tr>
	<td><div align="center"><div class="text"><<<</div><div class="shadow" UNSELECTABLE="on"><<<</div></td>
	<td style="cursor:hand;"><a href='<?php echo ("Forum.php");?>' style="cursor:hand;"><em class="fuzzy">&nbsp;&nbsp;&nbsp;Перейти к списку тем&nbsp;&nbsp;&nbsp;</em></a></td>
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
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
</body>
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
</html>
