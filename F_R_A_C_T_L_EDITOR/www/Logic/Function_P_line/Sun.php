<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
// Можно добавить переменную которая будет указывать номер сценарияы активная те зависит от пользователя
//$R = sqrt($dx*$dx+$dy*$dy)/$n;
$ygol =0;
	while($ygol<360)
	{
			$y =cos(rad2deg($ygol))*pi()*$n+$Y;
			$x =sin(rad2deg($ygol))*pi()*$n+$X;
			imageline($image, $X,$Y,$x,$y, $cvet);
			$ygol ++;
	  }
}
?>