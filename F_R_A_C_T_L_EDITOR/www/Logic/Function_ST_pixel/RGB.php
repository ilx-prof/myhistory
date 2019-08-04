<?php 
function S_color(&$string,$n,$a)
{	
	global $image;
	 return imagecolorallocate($image, @ord($string[$n-1]),ord($string[$n]),@ord($string[$n+1]));
}
?>