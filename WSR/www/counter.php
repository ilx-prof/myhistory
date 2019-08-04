<?php
function counter($dir){
	Header("Content-Type: image/PNG");

	if (is_dir("counters/".$dir)){}
	else{
		mkdir("counters/".$dir,0777);
	}
	$site="counters/".$dir."/";
	$ip=getenv("REMOTE_ADDR");
	$date=date("d.m.Y",time());

	if (is_file($site."counter.txt")){
		$f=file($site."counter.txt");
		list($d,$totalhits,$hits,$totalhosts,$hosts)=explode("|",$f[0]);
	}
	else{
		$mak=fopen($site."counter.txt","w+");
		fwrite($mak,"");
		fclose($mak);
		$d=$date;
		$totalhits=0;
		$hits=0;
		$totalhosts=0;
		$hosts=0;
	}

	if ($d!=$date)
	{
		$d=$date;
		$hits=0;
		$hosts=0;
		$erase=fopen($site."ip.txt","w+");
		flock($erase,2);
		fputs($erase," ");
		flock($erase,3);
		fclose($erase);
	}

	if (is_file($site."ip.txt")){
		$fo=fopen($site."ip.txt","r");
		flock($fo,2);
		$data=fread($fo,filesize($site."ip.txt"));
		flock($fo,3);
		fclose($fo);
	}
	else{
		$makip=fopen($site."ip.txt","w+");
		fwrite($makip,"");
		fclose($makip);
		$data=" ";
	}


	if (!stristr($data,$ip))
	{
		$file=fopen($site."ip.txt","a+");
		flock($file,2);
		fputs($file,$ip."\r\n");
		flock($file,3);
		fclose($file);
		$totalhits++;
		$hits++;
		$totalhosts++;
		$hosts++;
	}
	else
	{
		$totalhits++;
		$hits++;
	}

	$wfile=fopen($site."counter.txt","w+");
	flock($wfile,2);
	fputs($wfile,$d."|".$totalhits."|".$hits."|".$totalhosts."|".$hosts);
	flock($wfile,3);
	fclose($wfile);
	
	$image = ImageCreateFromPNG("counters/img.png");
	$white = ImageColorAllocate($image, 255, 255, 255);
	$yellow = ImageColorAllocate($image, 128, 128, 0);
	$font_width = ImageFontWidth(3);

	$tthi = (76)-(($font_width * strlen($totalhits))/2);
	imageString($image, 1, $tthi, 20, $totalhits, $white);

	$hi = (76)-(($font_width * strlen($hits))/2);
	imageString($image, 1, $hi, 28, $hits, $white);

	$ttho = (76)-(($font_width * strlen($totalhosts))/2);
	imageString($image, 1, $ttho, 46, $totalhosts, $white);

	$ho = (76)-(($font_width * strlen($hosts))/2);
	imageString($image, 1, $ho, 54, $hosts, $white);
	
	ImagePNG($image);
	ImageDestroy($image);
}

if (!empty($QUERY_STRING)) counter($QUERY_STRING);
?> 