<?
function S_color($x0,$y0,$iterac,$n = 100)
{	$n = 100;
	$r=1;
	$i=0;
	$xx=0.36; $yy=0.36;
	$x=$x0; $y=$y0;
	while (abs($r^4-1)^2 >0.0001 ) 
	{
		$x2 = $x*$x;
		$y2 = $y*$y;
		$xy = $x*$y;
		$x = $x2-$y2+$xx;
		$y = 2*$xy+$yy;
		$r = $x2+$y2;
		$n--;
		if(0>=$n){$n=16777215; break; }
	}
	switch ($n)
	{
	case $n<30:
		$n=16777215;
		 break;
	}
	//$n=round(($n/100)*255);
	return 66*$n;
}

?>
