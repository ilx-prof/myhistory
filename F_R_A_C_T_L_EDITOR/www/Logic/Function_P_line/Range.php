<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;

	$dx = $X > $x ? $X-$x : $dx = $X < $x ? $x-$X : $dx = $Y<$y ? $dy = $y-$Y : $dx = $Y>$y ? $dy = $Y-$y : 0;

				$xy = long(array($x,$y),array($X,$Y),-0.5);
				imageellipse($image, $xy[0],$xy[1],$dx,$dx,$cvet);
				//imageline($image,$x,$y,$X,$Y,12345645);
}
?>