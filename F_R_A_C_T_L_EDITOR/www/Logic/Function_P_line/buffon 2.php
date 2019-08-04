<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
//добавление коэфициента
$a=0.5;
	While (($a +=$a) < 360)
	{
		
		$x3=($X-$x)*cos($a)-($Y-$y)*Sin($a)+$x;
		$y3=($X-$x)*Sin($a)+($Y-$y)*cos($a)+$y;
		imagepolygon($image, array ($X,$Y,$x,$y,$x3,$y3),3,$cvet);
	}
}
?>