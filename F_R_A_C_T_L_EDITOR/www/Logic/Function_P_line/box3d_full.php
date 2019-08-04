<?
function P_line($X,$Y,$x,$y,$R,$a)
{
	global $image;
	$tmpx = $x;
	$tmpy = $y;
	if ($x <= $X)
	{
		$x = $X;
		$X = $tmpx;
	}
	if ($y <= $Y)
	{
		$y = $Y;
		$Y = $tmpy;
	}
	$dx=abs($x-$X);
	$dy=abs($y-$Y);
	$p1[0]=$x;	$p1[1]=$y-$dy;//точка 1
	$p1[2]=$X;	$p1[3]=$y+$dy/2;//точка 2
	$p1[4]=$X;	$p1[5]=$y+$dy*1.5;//точка 3
	$p1[6]=$x;	$p1[7]=$y;//точка x
	$p4[0]=$X-$dx;$p4[1]=$p1[5];//точка 4
	$p2[0]=$p4[0];	$p2[1]=$p1[3];//точка 5
	$p2[2]=$X;	$p2[3]=$y;//точка 6
	imagefilledpolygon ($image,array($X,$Y,$p1[0],$p1[1],$x,$y,$p2[2],$p2[3]),4,rand(0x000000,0xffffff));//0
	imagefilledpolygon ($image,array($X,$Y,$p2[2],$p2[3],$p4[0],$p4[1],$p2[0],$p2[1]),4,rand(0x000000,0xffffff));//4
	imagefilledpolygon ($image,array($p2[2],$p2[3],$p4[0],$p4[1],$p1[4],$p1[5],$x,$y),4,rand(0x000000,0xffffff));//5
	imagefilledpolygon ($image,$p1,4,rand(0x000000,0xffffff));//1
	imagefilledpolygon ($image,array($p4[0],$p4[1],$p1[4],$p1[5],$p1[2],$p1[3],$p2[0],$p1[3]),4,rand(0x000000,0xffffff));//2
	imagefilledpolygon ($image,array($X,$Y,$p1[0],$p1[1],$p1[2],$p1[3],$p2[0],$p2[1]),4,rand(0x000000,0xffffff));//3
}
?>