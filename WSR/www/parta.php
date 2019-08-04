<?php
function site($whois){
	$d=opendir("banners");
	rewinddir($d);
	$b=0;
	while (($f=readdir($d))!=FALSE):
		$url[$b]=$f;
		$b++;
	endwhile;
	closedir($d);
	srand ((double) microtime() * 1000000);
	$r=rand(2,sizeof($url)-1);
	$site=$url[$r];
	$file="banners/".$site."/lim.txt";
	if (is_file($file)) $fall=file($file);
	else $fall[0]=0;
	$count=$fall[0]+1;
	$fp=fopen($file,"w+");
	flock($fp,LOCK_EX);
	fputs($fp,$count);
	flock($fp,LOCK_UN);
	fclose($fp);
	$dir="banners/".$whois;
	if (is_dir($dir)) {
		$fp=@file($dir."/you.txt");
		$fy=fopen($dir."/you.txt","w+");
		flock($fy, LOCK_EX);
		@$fp[0]++;
		fputs($fy, $fp[0]);
		flock($fy, LOCK_UN);
		fclose($fy);
	}
	else {
		mkdir($dir,0777);
		$fy=fopen($dir."/you.txt","w+");
		flock($fy, LOCK_EX);
		fputs($fy,"");
		flock($fy, LOCK_UN);
		fclose($fy);
	}
	return $site;
}

function getban($dir){
	$di="banners/".$dir."/468x60";
	$d=opendir($di);
	rewinddir($d);
	$b=0;
	while (($f=readdir($d))!=FALSE):
		if (!is_dir($f)):
			$b++;
		endif;
	endwhile;
	$b=$b-3;
	srand ((double) microtime() * 1000000);
	$f=rand(1,$b);
	$file=$di."/".$f.".txt";
	$fr=fopen($file,"r");
	$link=fread($fr,filesize($file));
	$link=str_replace("\n"," ",$link);
	$link=str_replace("\r"," ",$link);
	fclose($fr);
	if (is_dir($di."/dat")){}else mkdir($di."/dat",0777);

	$datafile=$di."/dat/".$f.".txt";
	$fd=@file($datafile);
	$fdat=fopen($datafile,"w+");
	flock($fdat,LOCK_EX);
	$fd[0]=$fd[0]+1;
	fputs($fdat,$fd[0]);
	flock($fdat,LOCK_UN);
	fclose($fdat);

	$ftun="banners/worldkr.fatal.ru/text/1.txt";
	if ($link[1]=='w'){
		$alt="Баннерная сеть WSR";
		$fname=$di."/alt/".$f.".alt";
		if (is_file($fname)){
			$fa=fopen($fname,"r");
			$alt=fread($fa,filesize($fname));
			$alt=str_replace("\n"," ",$alt);
			$alt=str_replace("\r"," ",$alt);
			fclose($fa);
		}
		$imgn=$alt;
		if (is_file($di."/img/".$f.".jpg")){
			$imgn=$di."/img/".$f.".jpg";
		}else if (is_file($di."/img/".$f.".gif")){$imgn=$di."/img/".$f.".gif";}
		print "
		var b = '<div align=\"center\"><a href=\"http://$link\" target=\"_blank\"><img src=\"http://www.cbt-olymp.ru/$imgn\" alt=\"$alt\" width=\"468\" height=\"60\" border=\"1\" style=\"border: 1px #737173 dashed;\"></a></div>';
		document.write(b);";
		print "document.write('<div align=\"center\">');\n";
		$q=file($ftun);
		print "document.write('$q[0]');\n";
		print "document.write('</div>');\n";
	}
	else{
		print "document.write('<div align=\"center\">$link</div>');\n";
		print "document.write('<div align=\"center\">');\n";
		$q=file($ftun);
		print "document.write('$q[0]');\n";
		print "document.write('</div>');\n";
	}
	closedir($d);
}

function stats($site){
	$fp=file("banners/".$site."/lim.txt");
	print "Всего показов: ".$fp[0]."<br>\n";
	$d=opendir("banners/".$site."/468x60/dat");
	rewinddir($d);
	$b=0;
	while (($f=readdir($d))!=FALSE):
		if (eregi(".txt$",$f)):
			$b++;
			$fp=file("banners/".$site."/468x60/dat/".$f);
			print "Показов баннера ".$b."- ".$fp[0]."<br>\n";
		endif;
	endwhile;
}

if (empty($QUERY_STRING)) stats("worldkr.fatal.ru");
else getban(site($QUERY_STRING));
?>