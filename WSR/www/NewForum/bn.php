<?php
$fp=file("banners/banners.txt");
$col=sizeof($fp);
	$def_url=null;
	$def_to=null;
	$def_alt=null;
srand((double)microtime()*1000000);
$r=mt_rand(0,$col-1);
list($url, $to, $alt)=explode("|",$fp[$r]);
	if (empty($url)){$url=$def_url;}
	$url=eregi_replace("^(((h)*)((t)*)((p)*)((:)*)(/{1,}))","",$url);
	$to=eregi_replace("^(((h)*)((t)*)((p)*)((:)*)(/{1,}))","",$to);
echo ("
var b = '<a href=\"http://".$to."\" target=\"_blank\"><img src=\"http://".$url."\" alt=\"".$alt."\" border=\"0\" style=\"cursor:hand;\" width=\"468\" height=\"60\"></a>';\n
document.write(b);
");
?>