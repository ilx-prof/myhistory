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
		$x3=($X-$x)*cos($a)-($Y-$y)*Sin($a)+$x;
		$y3=($X-$x)*Sin($a)+($Y-$y)*cos($a)+$y;
		imagepolygon($image, array ($X,$Y,$x,$y,$x3,$y3),3,$cvet);
	}
}
?>