<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
///есть возможность
$i=deg2rad(10);
$a=deg2rad(0);
$dl=deg2rad(360);
	While (($a +=$i) < $dl)
	{	
		
		$x=($X-$x)*cos($a)-($Y-$y)*Sin($a)+$X;
		$y=($X-$x)*Sin($a)+($Y-$y)*cos($a)+$Y;
		imageline($image,$X,$Y,$x,$y,$cvet);
	}
}
?>