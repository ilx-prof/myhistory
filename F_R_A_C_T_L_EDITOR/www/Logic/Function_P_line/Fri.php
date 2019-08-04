<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
	// Можно добавить переменную которая будет указывать номер сценарияы активная те зависит от пользователя	
	//$R = sqrt($dx*$dx+$dy*$dy)/$n;
	$dx=abs($x-$X);	
	$dy=abs($y-$Y);
	//$dlina = sqrt($dx*$dx+$dy*$dy);
	//$ygol = $dx <> 0 ? atan($dy/$dx) : 90;
	$dx1=$dx/4;
	$dy1=$dy/4;
	$i=0;
	while(++$i<4)
	{
		$x=$dx1*cos($i*90)+$x;
		$y=$dy1*sin($i*90)+$y;
		imageline($image, $X,$Y,$x,$y, $cvet);
	}
}
?>