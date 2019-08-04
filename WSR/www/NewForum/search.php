<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
</head>

<body>
<form action="search.php" method="post">
<input class="forma" type="Text" name="what" size="30">&nbsp;<input class="fuzzy" type="Submit" style="cursor:hand;" value="Поиск">
</form>

<?php
require("config.php");//Файл настроек

	$fileName="search.txt"; //имя файла со статистикой
	include("sniffer.php");

$sea=fopen("fraz.txt","a+b");
fwrite($sea,"$what\r\n");
fclose($sea);

echo "Информация была найдена в следующих темах:<br>";
$fname=$what;
	$shet=opendir("$messages_dir");
	while(($file = readdir($shet)) !== false) {
		if (eregi("$rash_text$",$file)){
			$tema=file("$messages_dir/$file");
			$count=count($tema);
			$max=(floor(($count-1)/10)*10);
			for ($i=1; $i<=$count; $i++):
				if (fnmatch("$fname",$tema[$i])){
					$temane=explode("|Fuz|",$tema[0]);
					$filstr=str_replace("$rash_text","",$file);
					$f=1;
					if (($count<=11)&&($i<=11)){}
					else{
						//explode on pages//
						$f=floor($i/10)+1;
						if ($i==floor($i/10)*10){$f=floor($i/10);}
						if (($i<=$count)&&($i>$max)){
						$f=($max/10)+1;
						}
					}
					//end explode//
					echo ("<a href=\"index.php?show=$filstr&f=$f\" target=\"_blank\">$i--$temane[0]</a>--(page-$f)<br>");
				}
			endfor;
		}
	}
	closedir($shet);

?>

<h3 class="logo">by Fuzzy</h3>
</body>
</html>
