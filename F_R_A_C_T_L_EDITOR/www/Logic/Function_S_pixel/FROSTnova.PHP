<?php
function S_color($x,$y,$iterac,$n)
{
	$i=0;
	$xx=$x;
	$yy=$y;
	while ($xx*$xx+$yy*$yy<=4)
	{
		$xk=$xx*$xx-$yy*$yy+$x;
		$yk=$yy*$xx+$y;
		$xx=$xk;
		$yy=$yk;
		$i++;
		if($i>=$n){break;}
	}
	return 66*$n^$i;
}
?>