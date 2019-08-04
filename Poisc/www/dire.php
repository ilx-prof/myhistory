<?php
$kat = "F:\\WebServers\\home\\Poisc\\www\\ilx\\";
print "<H2>".$kat."</H2>";
if (is_dir($kat))
{
if ($dh = opendir($kat))
{
while (($file = readdir($dh)) !== false)
{
	print "<br>"."$file";
}
	closedir($dh);
}
}
?>
<a href="index.php">Вернуться</a>
<a href="log.txt"><br>Посмотреть log.txt</a>
<a href="creatdel.php"><br>Удалить созданые файлы</a>
<a href="Status.php><br>Статус</a>
