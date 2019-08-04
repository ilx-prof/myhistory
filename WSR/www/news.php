<?php
if (!empty($all)){
	print "
<head>
<link rel=\"STYLESHEET\" type=\"text/css\" href=\"style.css\">
</head>
";
}
?>
<?php
function news(){
	print "
	<hr size=\"1\">
	<table class=\"but2\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">
	<tr>
		<td colspan=\"2\" class=\"porh2\">НОВОСТИ WSR</td>
	</tr>";
	$fp=file("news.txt");
	$fp=array_reverse($fp);
	$col=count($fp);
	if($col<=10){}else{$col=10;};
	for ($i=0; $i<=$col-3; $i++):
		$val=explode("||",$fp[$i]);
		$bad="good";
		if (empty($val[1])){$bad=$i;}
		else{
		$date=$val[0];
		$nick=$val[1];
		$mail=$val[2];
		$mess=$val[3];
		echo ("
		<tr>\n
			<td class=\"butt2\" width=\"30%\" align=\"center\"><b class=\"small\">$date</b><br><div class='text'>$nick</div><div class='shadow' UNSELECTABLE='on'>$nick</div><a href=\"mailto:$mail\" target=\"_blank\" style=\"cursor:hand;\">E-mail</a></td>
			<td class=\"butt\" width=\"70%\" align=\"center\">$mess</td>
		\n</tr>\n");
		}
	endfor;
	print "</table><br>";
}
?>
<?php
function rating($all){
	print "<table cellpadding=\"3\" cellspacing=\"0\" class=\"but2\">";
	$fp=file("rating.txt");
	$b=sizeof($fp);
	$summ=0;
	$fp=str_replace("\n","",$fp);
	$fp=str_replace("\r","",$fp);

	function sor($str1,$str2){
		list($name1,$skok1)=explode("|",$str1);
		list($name2,$skok2)=explode("|",$str2);
		if ($skok1==$skok2) return 0;
		if ($skok1<$skok2) return 1;
		else return -1;
	}
	usort($fp, "sor");

	for ($i=0; $i<$b; $i++):
		list($name, $skok)=explode("|",$fp[$i]);
		$summ+=$skok;
	endfor;
	print "
	<tr>
		<td class=\"porh2\">Рейтинг популярности:</td>
	</tr>";
	@$a=($summ/($b-1))/2;
	$a=round($a,2);
	if ($a>50) $a=$a-1;
	print "
	<tr>
		<td class=\"butt2\"><small>В рейтинге находятся страницы с показателем не ниже ".$a."%</small></td>
	</tr>";
	for ($i=0; $i<$b; $i++){
		list($name, $skok)=explode("|",$fp[$i]);
		$s=($skok/$summ)*100;
		$s=round($s,2);
		if (($s>=$a)or(!empty($all))):
			print "<tr>\n\t<td class=\"butt\">";
			if($name[2]=='='){
				$name=eregi_replace("^sh=","",$name);
				switch ($name){
					case "search"; print "Поиск по сайту\n"; break;
					case "okr2files"; print "<a href=\"?sh=okr2files\">Файлы (Космические Рейнджеры 2: Доминаторы)</a>\n"; break;
					case "okrfiles"; print "<a href=\"?sh=okrfiles\">Файлы (Космические Рейнджеры)</a>\n"; break;
					case "okr"; print "<a href=\"?sh=okr\">Скриншоты (Космические Рейнджеры)</a>\n"; break;
					case "okr2"; print "<a href=\"?sh=okr2\">Скриншоты (Космические Рейнджеры 2: Доминаторы)</a>\n"; break;
					case "news"; print "<a href=\"?sh=news\">Главная (Новости, Рейтинг популярноси)</a>\n"; break;
					case "opros"; print "<a href=\"?sh=news\">Главная (Голосования)</a>\n"; break;
				}
			}
			else{
				$fr=fopen($name,"r");
				$head=fread($fr, 256);
				$pos=strpos($head, "</h1>")+5;
				rewind($fr);
				$link=fread($fr, $pos);
				$link=eregi_replace("<h1>","",$link);
				$link=eregi_replace("</h1>","",$link);
				print "<a href=\"?show=".$name."\">".$link."</a>\n";
			}
			if (empty($all)) print " (<tt style=\"color:#320c03; font-weight:bold;\">".$s."%</tt>)</td>\n</tr>\n";
			else print " (<tt style=\"color:#320c03; font-weight:bold;\">".$s."%</tt>) -- ".$skok."</td>\n</tr>\n";
		endif;
	}
	$dob=round(100/($summ+1),2);
	print "
	<tr>
		<td class=\"butt2\"><small style=\"color:#320c03\">Хочешь повысить рейтинг любимой странички, тогда привлекай друзей к её промотру. Каждый просмотр</small><small> + ".$dob."%</small>.</td>
	</tr>";
	
	print "</table>";
}

news();
if (!empty($all)){rating($all);}
else {$all=null; rating($all);}
print "<h3 class=\"logo\">by Fuzzy</h3>";

?>

