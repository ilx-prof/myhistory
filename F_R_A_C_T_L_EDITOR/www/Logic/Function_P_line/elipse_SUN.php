<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
$tmpx=$x;
$tmpy=$y;
$dx=($x-$X);
$dy=($y-$Y);
$cy= $y;//..центр прямой xy----XY
$cx= $x;
$radiys = sqrt($dx*$dx+$dy*$dy)*0.1;//*exp(1);//НЕобходим коэффициент пропорциональностиc dvtcnj n
$r2=$radiys*$radiys;
$dst = 4*$r2;
$dxt =  $radiys/1.414213562373;
$t=0;
$s=-$dst*$radiys;
$e=(-$s/2)-3*$r2;
$ca=-6*$r2;
$cd=-10*$r2;
$x=0;
$y= $radiys;

imagesetpixel($image,$cx,$cy+$radiys,$cvet);
imagesetpixel($image,$cx,$cy-$radiys,$cvet);
imagesetpixel($image,$cx+$radiys,$cy,$cvet);
imagesetpixel($image,$cx-$radiys,$cy,$cvet);
for($ind=0;$ind<=$dxt; $ind++)
{
	$x++;
	if($e>=0)
	{
		$e+=$t+$ca;
	}
	else
	{
		$y--;
		$e+=$t-$s+$cd;
		$s+=$dst;
	}
	$t-=$dst;
	imagesetpixel($image,$cx+$x,$cy+$y,$cvet);
	imagesetpixel($image,$cx+$y,$cy+$x,$cvet);
	imagesetpixel($image,$cx+$y,$cy-$x,$cvet);
	imagesetpixel($image,$cx+$x,$cy-$y,$cvet);
	imagesetpixel($image,$cx-$x,$cy-$y,$cvet);
	imagesetpixel($image,$cx-$y,$cy-$x,$cvet);
	imagesetpixel($image,$cx-$y,$cy+$x,$cvet);
	imagesetpixel($image,$cx-$x,$cy+$y,$cvet);
}
}
?>