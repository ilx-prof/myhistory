<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
	//imagesetpixel($image, $X,$Y,$cvet);
	imagettftext($image,$n*$n*(rand(1,2)/rand(1,2)),rand(-6,6),$x,$y,$cvet*$n,'ARIAL.ttf',chr(rand(65, 90)));//;

}
?>