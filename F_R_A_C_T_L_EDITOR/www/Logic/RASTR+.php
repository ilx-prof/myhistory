<?php
//$zoom;
$max_X= 2.2;//-0.35
$max_Y= 2.2;//-0.5
$min_x= -2.5;//-1
$min_y= -2.5 ;//-0.5
$DX= ($max_X-$min_x)/$sir;
$DY= ($max_Y-$min_y)/$vih;
include_once ($metod);
function fractal($iterac)
{
	global $vih,$sir,$image,$DX,$DY,$min_x,$min_y,$n;
	//print "$vih,$sir,$image,$DX,$DY;";
	$y=$x=$X=$Y=$iterac=0;
	$y=$min_x;
	while($vih!=$Y)
	{
		$Y++;
		$X = 0;
		$x=$min_x;
		while($sir!=$X)
		{
			$X++;
			$iterac++;
			imagesetpixel ($image,$X,$Y,(S_color($x,$y,$iterac,$n)));
			$x +=$DX;
		}
		$y += $DY;
	}
}
		fractal($n);
?>