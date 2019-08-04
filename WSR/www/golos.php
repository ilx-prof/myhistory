<?php
####################################
#/*        Created by FUZZY      */#
#/*                              */#
#/*     Coryrated by WSR 2005    */#
#/*                              */#
#/*     E-mail: vpah@mail.ru     */#
####################################

function golrnd(){
	$dir=opendir("golosovanie");
	$b=0;
	while (($file=readdir($dir))!=FALSE):
	if (eregi(".txt$",$file)) $b++;
	endwhile;
	closedir($dir);

	srand((double)microtime()*1000000);
	$b=$b-2;
	$fname=rand(0,$b);
	$file="golosovanie/".$fname.".txt";
	$fp=file($file);
	$kol=sizeof($fp)-1;
	$golos=str_replace("\n","",$fp[0]);
	$golos=str_replace("\r","",$golos);
	print "<form action=\"index.php?sh=opros\" method=\"post\">\n";
	print "<input type=\"Hidden\" name=\"filn\" value=\"".$fname."\">\n";
	print "<table cellpadding=\"2\" cellspacing=\"0\" class=\"but2\" style=\"background: url(images/bg3.gif)\" align=\"center\">\n";
	print "<tr>\n\t<td colspan=\"2\" class=\"porh2\">".$golos."</td>\n</tr>\n";
	for ($i=1; $i<=$kol; $i++):
		$name=eregi_replace("[|](.*)","",$fp[$i]);
		print "<tr>\n\t";
		switch($i){
			case 1; print "<td class=\"butt2\"><input type=\"Radio\" name=\"os\" value=\"".$i."\" checked></td>\n\t"; break;
			default; print "<td class=\"butt2\"><input type=\"Radio\" name=\"os\" value=\"".$i."\"></td>\n\t"; break;
		}
		print "<td class=\"butt2\">".$name."</td>\n";
		print "</tr>\n";
	endfor;
	print "<tr>\n\t<td colspan=\"2\" class=\"butt2\"><input class=\"golos\" type=\"submit\" name=\"gol\" onmouseover=\"this.style.background='#b6b6b6'\" onmouseout=\"this.style.background='url(bgt.gif)'\" value=\"Голосовать\"></td>\n</tr>\n";
	print "</table>\n";
	print "</form>";
}

function add($gol,$fn){
	$file="golosovanie/".$fn.".txt";
	$fp=file($file);
	$fp=str_replace("\n","",$fp);
	$fp=str_replace("\r","",$fp);
	$kol=sizeof($fp)-1;
	$fr=fopen($file,"w+");
	fputs($fr,$fp[0]."\n");
	for ($i=1; $i<=$kol; $i++):
		list($name,$skok)=explode("|",$fp[$i]);
		if ($i==$gol){$f=($skok+1); fputs($fr, $name."|".$f."\n");}
		if (($i!=$gol)&&($i<$kol)) fputs($fr, $name."|".$skok."\n");
		if (($i==$kol)&&($i!=$gol)) fputs($fr, $name."|".$skok);
	endfor;
	fclose($fr);
}

function show($fn){
	$file="golosovanie/".$fn.".txt";
	$fp=file($file);
	$fp=str_replace("\n","",$fp);
	$fp=str_replace("\r","",$fp);
	$summ=null;
	$k=0;
	for ($i=1; $i<=(sizeof($fp)-1); $i++):
		list($name,$s)=explode("|",$fp[$i]);
		if ($s>=$k){$k=$s; $max=$i;}
		$summ+=$s;
	endfor;
	$golos=$fp[0];
	print "
	<table cellpadding=\"3\" cellspacing=\"0\" class=\"but2\" align=\"center\" style=\"background: url(bg3.gif)\">
	<tr>\n\t
		<td colspan=\"3\" class=\"porh2\">".$golos."</td>
	</tr>
	<tr>\n\t
		<td class=\"butt\" align=\"center\" style=\"color:maroon; font-weight:bold; letter-spacing:1px;\">Вариант:</td>\t
		<td class=\"butt\" align=\"center\" style=\"color:maroon; font-weight:bold; letter-spacing:1px;\">Голосов</td>\t
		<td class=\"butt\" align=\"center\" style=\"color:maroon; font-weight:bold; letter-spacing:1px;\">В процентах</td>
	</tr>\n";
	$color="#320c03";
	list($m,$ma)=explode("|",$fp[$max]);
	$maxproc=round(($ma/$summ)*100,1);
	for ($i=1; $i<=(sizeof($fp)-1); $i++):
		list($name,$s)=explode("|",$fp[$i]);
		$proc=@round(($s/$summ)*100,1);
		print "<tr>\n\t";
		$as="\n\t<td class=\"butt\" align=\"center\">".$s."</td>\n\t<td class=\"butt\" align=\"center\" drt>".$proc."%</td>\n";
		if (($i==$max)or($proc==$maxproc)){print "<td class=\"butt2\" style=\"color:".$color.";\">".$name."</td>"; $as=str_replace("drt","style=\"color:".$color.";\"",$as); print $as;} else {print "<td class=\"butt2\">".$name."</td>"; $as=str_replace("drt","",$as); print $as;}
		print "</tr>\n";
	endfor;
	print "<tr>\n\t<td colspan=\"3\" class=\"butt2\">Всего голосов: <b style=\"color:".$color."; font-size:11px;\">".$summ."</b></td>\n</tr>
	</table>\n";
	print "<div align=\"center\"><br><a href=\"?\">Вернуться</a></div><br>";
}
?>

<?php
if (!empty($log))
switch($log){
	case "add"; add($os,$filn); show($filn); break;
	case "show"; show($sox); break;
	case "golrnd"; golrnd(); break;
}
?>