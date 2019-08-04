<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
		imagerectangle ($image, $x,$y,$X,$Y,$cvet);
}
?>