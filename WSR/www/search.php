<?php
function search($dir,$str){
$str=strtolower($str);
$d=opendir($dir);
$skok=0;
print "<table cellpadding=\"3\" cellspacing=\"0\" class=\"but2\">\n";
while (($f=readdir($d))!=FALSE):
	if ((eregi(".html$",$f))or(eregi(".php$",$f))or(eregi(".txt$",$f))):
		$pos=false;
		$file=$dir."/".$f;
		$fp=fopen($file,"r");
		$data=fread($fp, filesize($file));
		if (stristr($data,$str)){
			$skok++;
			$pos=strpos($data,"</h1>")+5;
			rewind($fp);
			$head=fread($fp,$pos);
			$head=str_replace("<h1>","",$head);
			$head=str_replace("</h1>","",$head);
			$head=str_replace("<!--","",$head);
			if (eregi(".php$",$f)){
				$f=eregi_replace(".php$","",$f);
				$url="?sh=".$dir.$f;
			}
			else $url="?show=".$dir."/".$f;
			print "<tr>\n\t<td class=\"butt\">";
			print "<a href=\"index.php$url\">".$head."</a>";
			print "</td>\n</tr>\n";
		}
		fclose($fp);
	endif;
endwhile;
if ($skok==0)print "<tr>\n\t<td class=\"butt\">Извините, но запрашиваемая Вами информация не найдена в этом разделе</td>\n</tr>\n";
print "</table>";
}


$dirs=array("okr|Космические Рейнджеры","okr2|Космические Рейнджеры-2 Доминаторы","refer|Ссылки");
for ($i=0; $i<=sizeof($dirs)-1; $i++){
list($dir, $name)=explode("|",$dirs[$i]);
print "<h2>".$name."</h2>";
search($dir,$stroka);
print "<br><br><br>";
}

?>
<h3 class="logo">by Fuzzy</h3>