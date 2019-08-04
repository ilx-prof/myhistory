<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
							imageline($image, $x,$y,$X,$Y,$cvet);
}
?>