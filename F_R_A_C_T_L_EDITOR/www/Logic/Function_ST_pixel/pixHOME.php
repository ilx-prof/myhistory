<?php 
function S_color(&$string,$n,$a)
{	
	$simbol = $string[$n];
	 return $cvet = 192<=ord($simbol) && ord($simbol)<=223 ? 0xffffff :// РУССКИЕ
		 		$cvet = 65<=ord($simbol) && ord($simbol)<=90 ? 0x000000 ://ENGLISH
				$cvet = 97<=ord($simbol) && ord($simbol)<122 ? 0xff0000 ://english
				$cvet = 90<ord($simbol) && ord($simbol)<192 ? 0x0000ff :// русские
				0x008000;// другое
}
?>