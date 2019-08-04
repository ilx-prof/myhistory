<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
							imagesetpixel($image, $x,$y,$cvet);
							imagesetpixel($image, $X,$Y,$cvet);
}
?>