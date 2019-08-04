<?php
if ((isset($d))&&($d=='del')){
	setcookie("Worldkr", "", time()-10000);
}
	require("config.php");

if ((isset($nick))&&(isset($pass))){
	$size=StrLen($nick);
	$encoded_nick=null;
	for($i=0;$i<$size;$i++) $encoded_nick.=base_convert(ord($nick[$i]),10,32).chr(125);

	$size=StrLen($pass);
	$encoded_pass=null;
	for($i=0;$i<$size;$i++) $encoded_pass.=base_convert(ord($pass[$i]),10,32).chr(125);

	$fname=strtolower($encoded_nick);
	if (file_exists("reg/$fname.txt")){
		$fp=file("reg/$fname.txt");
		$v2=explode("|",$fp[1]);
		$v2[1]=strtolower($v2[1]);
		if ($encoded_pass==$v2[1]){
		$data="$encoded_nick||$encoded_pass";
			setcookie("Worldkr", $data, time()+2592000);
		}
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<=Форум=>></title>
	<meta http-equiv="refresh" content="0; url=Forum.php"> 
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=Windows-1251">
</head>
<body bgcolor="#000000">

</body>
</html>
