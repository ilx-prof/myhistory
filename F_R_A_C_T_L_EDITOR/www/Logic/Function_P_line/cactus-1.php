<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;

	// Можно добавить переменную которая будет указывать номер сценарияы активная те зависит от пользователя	
	$n1=turn($xy=array($x,$y),$XY=array($X,$Y),0,1);
	$n2=turn($xy,$XY,0,-1);
	//imageline($image, $x,$y,$n1[0],$n1[1],$cvet);
	imagepolygon($image, array ($n1[0],$n1[1],$X,$Y,$n2[0],$n2[1]),3,$cvet);
	//imageline($image,$x,$y,$X,$Y,12345645);
}
?>