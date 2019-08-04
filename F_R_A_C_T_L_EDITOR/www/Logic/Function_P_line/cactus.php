<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;

	// Можно добавить переменную которая будет указывать номер сценарияы активная те зависит от пользователя	
	
	$XY=long($xy=array($x,$y),array($X,$Y),0.5);
	$n1=turn($XY,$xy,0,1);//90 относительно последней точки $XY
	$n1 = long($n1,$XY,0.5);
	$n2=turn($XY,$xy,0,-1);
	$n2 = long($n2,$XY,0.5);
	//imageline($image, $x,$y,$n1[0],$n1[1],$cvet);
	imagepolygon($image, array ($n1[0],$n1[1],$x,$y,$n2[0],$n2[1]),3,$cvet);
	//imageline($image,$x,$y,$X,$Y,12345645);
}
?>