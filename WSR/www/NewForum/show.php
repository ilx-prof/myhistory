<html>
<head>
	<title>���������� ��������� ::::: ��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> �����</title>
</head>
<body>
<?php
require("config.php");//���� ��������

$fileName="../stat.txt"; //��� ����� �� �����������
echo "<font face=\"Arial, Times New Roman, Verdana\" color=\"#000000\" size=\"1\">";
include("sshow.php");
echo " :::::: <b>���������� ��� ������� �������� �����</b> :::::: <br><hr></table></div>";
?>

<?php
$fileName="stat.txt"; //��� ����� �� �����������
include("sshow.php");
echo " :::::: <b>���������� ��� ������� �������� ������</b> :::::: <br><hr></table></div>";
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

$fileName="../promote.txt"; //��� ����� �� �����������
include("sshow.php");
echo " :::::: <b>���������� ��� �������� Promote</b> :::::: <br><hr></table></div>";


echo "</font>";
?>
</body></html>