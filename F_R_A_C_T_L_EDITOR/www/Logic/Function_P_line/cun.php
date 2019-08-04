<?
function P_line($X,$Y,$x,$y,$R,$a)
{
	global $image;
	$cvet=rand(0x0,0xFFFFFF);//По идеее  4294967295
	$ygol = 0;
  	$i=0;
while($i<$R/0.05)
	{		
			if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			$y =cos($ygol)*pi()*$R+$Y;
			$x =sin($ygol)*pi()*$R+$X;
			imageline($image, $x,$y,$X,$Y,$cvet);
			$ygol+=$a;
			$i++;
			$yi =cos(-$ygol)*pi()*$R+$Y;
			$xi =sin(-$ygol)*pi()*$R+$X;
			imageline($image, $xi,$yi,$X,$Y,$cvet-$cvet/2);
	  }
}
?>