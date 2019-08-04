<?php
include_once ("include_functions.php");

//...Проверка  работы выбора от удачи////////////////////////
$stat=2;
$b=0;
$g=0;
$h=0;
for ($good=$bad=$i=0;$i<$stat;$i++)
{
	$luck = luck($g,$b,$h);
	$bad += ($luck == "Bad") ? 1 : 0;
	$good += ($luck == "good") ? 1 : 0;
}
print "good - ".($good*100/$stat)."%<BR> bad - ".($bad*100/$stat)."%<br>";
print "<HI>".($res = $good < $bad ? "bad" : "good")."</h1>";
////////////////////////////////////////////////////////////


// проверка выбора знака //////////////////////////////////
$stat=2;
$p_min = 90;//..проценты выора знака
$p_plus= 50;
$p_mult= 20;
$p_div = 33;
$h=0;

for ($plus=$min=$mult=$div=$i=0;$i<$stat;$i++)
{
	$mark = mark($p_min,$p_plus,$p_mult,$p_div,$h);
	$min += ($mark == "-") ? 1 : 0;
	$plus += ($mark == "+") ? 1 : 0;
	$mult += ($mark == "*") ? 1 : 0;
	$div += ($mark == "/") ? 1 : 0;
}
print "plus - ".($plus*100/$stat)."%<br>
		 min - ".($min*100/$stat)."%<br>
		 	mult - ".($mult*100/$stat)."%<br>
				div - ".($div*100/$stat)."%<br>	";
$ar = array ($plus => "+",$min => "-",$mult=> "*",$div=>"*");
print "$stat";
anal ($ar);
///////////////////////////////////////////////////////////////
function anal($ar)
{
	foreach ($ar as $k => $v)
	{
    	print "\$a[$k] => $v.\n";
	}
}




?>