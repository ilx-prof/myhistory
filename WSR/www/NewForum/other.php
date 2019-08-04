<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум</title>
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
<link rel='STYLESHEET' type='text/css' href='style.css'>
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->

</head>
<script src="ban.js" type="text/javascript"></script>
<body style="margin:30px;">
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->

<?php
error_reporting (E_ALL);
require("config.php");//Файл настроек

//счетчик
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
	$ourfile=str_replace("[/url]","' target='_blank'><font style='font-weight:bold;'>ссылка</font></a>",$ourfile);
	$ourfile=str_replace("[смущ]","<img src='blush.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[спок]","<img src='crazy.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[хммм]","<img src='frown.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[хаха]","<img src='laugh.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[зло]","<img src='mad.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[шок]","<img src='shocked.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[улыбка]","<img src='smile.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[бебе]","<img src='tongue.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("[миг]","<img src='wink.gif' width='15' height='15' alt='' border='0'>",$ourfile);
	$ourfile=str_replace("&q","&quot;",$ourfile);
	list($dateO, $nickO, $mailO, $mesO)=explode("|Fuz|",$ourfile);

	if (!eregi("^([0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-wyz][a-z](fo|g|l|m|mes|o|op|pa|ro|seum|t|u|v|z)?)$", $mailO))
	{$mailO="Нет электронки";}
	else
	{$mailO="<a href=\"mailto:".$mailO."\">".$mailO."</a>";}


$priz=str_replace(".dat",".snif",$priz);
$fileName="$priz"; //имя файла со статистикой
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
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
<script type="text/javascript" language="JavaScript">
function get()
{window.open ("Forum.php", "_parent");}
</script>
<div align="center"><input class="fuzzy" type="Button" onclick="get()" style="cursor:hand;" value="Вернуться к списку тем"></div><br><br><br>
<?php if(file_exists("ban")){include("ban");} ?>
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