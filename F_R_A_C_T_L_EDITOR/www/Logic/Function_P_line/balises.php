<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
///есть возможность
$i=deg2rad(1);
$a=deg2rad(0);
$dl=deg2rad(360);
	While (($a +=$i) < $dl)
	{	
		$x3=($X-$x)*cos($a)-($Y-$y)*Sin($a)+$x;
		$y3=($X-$x)*Sin($a)+($Y-$y)*cos($a)+$y;
		$x4=($X-$x)*cos(-$a)-($Y-$y)*Sin(-$a)+$X;
		$y4=($X-$x)*Sin(-$a)+($Y-$y)*cos(-$a)+$Y;
		imageline($image,$x3,$y3,$x4,$y4,rand($cvet -=100,999999) );
	}
}
?>