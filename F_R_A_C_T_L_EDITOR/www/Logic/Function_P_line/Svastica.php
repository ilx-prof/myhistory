<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
	// Можно добавить переменную которая будет указывать номер сценарияы активная те зависит от пользователя	
				$xy = long(array($x,$y),array($X,$Y),-0.5);
	//imageline ($image,$x,$y,$xy[0],$xy[1],6725841);
	
				$xy1= turn($xy,array($x,$y),0,1);
				$xy2 =long($xy1,$xy,-1);
	imageline($image,$x,$y,$xy1[0],$xy1[1],$cvet);
	imageline($image,$xy2[0],$xy2[1],$xy1[0],$xy1[1],$cvet);
	imageline($image,$xy2[0],$xy2[1],$X,$Y,$cvet);

}
?>