<?php
function screen($kr,$st){
	echo "<table class=\"but2\" cellpadding=\"2\" cellspacing=\"0\" style=\"width:90%;\" align=\"center\">\n";//Вывод на экран начала таблицы
	$d="screenshots/".$kr;
	$dir=opendir($d);
	$a=0; $b=0;
	$skok=6;//Сколько изображений должно находиться в одной строке
	
	while (($fil=readdir($dir))!=FALSE):
		if ((eregi("^($st)",$fil))&&(eregi(".gif$",$fil))):
			$mass[$b]=$fil;
			$b++;
		endif;
	endwhile;
	
	for ($i=0; $i<$b; $i++):
		if ($a==0) print "<tr>\n";
		if ($a<$skok){
				$a++;
				$gif=$mass[$i];
				$jpg=str_replace(".gif",".jpg",$mass[$i]);
				print "\t<td align=\"center\" width=\"100\" height=\"75\" class=\"butt2\"><a href=\"".$d."/".$jpg."\" target=\"_blank\"><img src=\"".$d."/".$gif."\" width=\"100\" height=\"75\" border=\"0\" alt=\"Скриншоты: Космические Рейнджеры\"></a></td>\n";
			}
		if (($a==$skok)or($i==($b-1))){print "</tr>\n"; $a=0;}
	endfor;
	echo "</table>\n<br><br>";
}
// background=\"images/bg-screen.gif\"
switch($scr){
	case "kr1"; print "<h2>Какими они могли быть:</h2>"; screen('kr0','kr0'); print "<h2>Какими они есть сейчас:</h2>"; screen('kr1','kr1'); print "<h2>Приколы на тему КР-1</h2>"; screen('prikr1','pri'); break;
	case "kr2"; screen('kr2','kr2'); break;
}
?>