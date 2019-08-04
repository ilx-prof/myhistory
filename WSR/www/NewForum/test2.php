<?php

$fp=file("fraz.txt");
$col=sizeof($fp);
for ($i=0; $i<=$col; $i++){
	list($date, $text)=explode("|",$fp[$i]);
	$a[$i]=$date;
}

sort($a);
for ($i=0; $i<=sizeof($a); $i++) echo $a[$i]."<br>";

echo "Время создания файла $filename: ".date("H:i:s. d m Y",filectime($filename))."<br>";
echo "Время последнего изменения файла $filename: ".date("H:i:s. d m Y",filemtime($filename))."<br>";

		$raz=opendir("messages/mess");
		$b=0;
		while (($file=readdir($raz))!=FALSE){
			if (eregi(".txt$",$file)){
				$tm=date("d m Y. H:i:s",filemtime("messages/mess/$file"));
				$arr[$b]=$tm;
				$brr[$b]=$file;
				$b++;
			}
		}
		closedir($raz);
sort($arr);
for ($i=0; $i<=sizeof($arr); $i++){

echo "$arr[$i]<br>";
}


/*
for ($j=0; $j<=sizeof($a); $j++){
	if ($next=='1')
	$next=0;
	for ($i=0; $i<=sizeof($a); $i++){
		if ()
	}
}
*/
?>