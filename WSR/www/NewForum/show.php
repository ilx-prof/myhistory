<html>
<head>
	<title>Статистика посещений ::::: СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум</title>
</head>
<body>
<?php
require("config.php");//Файл настроек

$fileName="../stat.txt"; //имя файла со статистикой
echo "<font face=\"Arial, Times New Roman, Verdana\" color=\"#000000\" size=\"1\">";
include("sshow.php");
echo " :::::: <b>Статистика для главной страницы сайта</b> :::::: <br><hr></table></div>";
?>

<?php
$fileName="stat.txt"; //имя файла со статистикой
include("sshow.php");
echo " :::::: <b>Статистика для главной страницы форума</b> :::::: <br><hr></table></div>";
?>

<?php
$shet=opendir("$messages_dir");
$kolvo=0;
while(($file = readdir($shet)) !== false) {
if (ereg(".txt$",$file)){
	$tema=file("$messages_dir/$file");
	$temane=explode("|Fuz|",$tema[0]);
	$filn=$file;
	$filn=str_replace("$rash_text","$rash_sniff",$filn);
if (file_exists("$mes_sniffer_dir/$filn")){
$fileName="$mes_sniffer_dir/$filn";
include("sshow.php");
echo " :::::: <b>$temane[0]</b> :::::: <br><hr></table></div>";}
}}
closedir($shet);
?>

<?php
$shet=opendir("$messages_other_dir");
$kolvo=0;
while(($file = readdir($shet)) !== false) {
if (ereg(".htm$",$file)){
	$tema=file("$messages_other_dir/$file");
	$temane=explode("|Fuz|",$tema[0]);
	$filn=$file;
	$filn=str_replace(".htm","$rash_sniff",$filn);
if (file_exists("$messages_other_dir/$filn")){
$fileName="$messages_other_dir/$filn";
include("sshow.php");
echo " :::::: <b>$temane[0]</b> :::::: <br><hr></table></div>";}
}}
closedir($shet);

$fileName="../promote.txt"; //имя файла со статистикой
include("sshow.php");
echo " :::::: <b>Статистика для страницы Promote</b> :::::: <br><hr></table></div>";


echo "</font>";
?>
</body></html>