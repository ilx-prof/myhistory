<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Список всех пользователей форума ::: СВЧ и Мир КР</title>
</head>

<body bgcolor="#000000" style="color:white;">
<?php
require("config.php");

$dir=opendir($reg_files_dir);
while (($file=readdir($dir))!=FALSE):
	if (eregi(".txt$",$file)):
		$fp=file("reg/$file");
		$v=explode("|",$fp[0]);
		$file=str_replace(".txt","",$file);
		echo ("
			<a href=\"user.php?user=$v[1]\">$v[1]</a><br>
		");
	endif;
endwhile;
?>
</body>
</html>
