<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
		imageellipse($image, $X,$Y,$x,$y,$cvet);
}
?>