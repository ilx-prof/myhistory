<?php 
function P_Line($x,$y,$X,$Y,$cvet = 0xFFFFFF)
{
global $image;
	imagesetpixel($image, $X,$Y,$cvet);
}
?>