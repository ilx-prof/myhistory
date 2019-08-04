<?php
	$dx  =$dx+$delta ;
	$dy  =$dx+$delta;
	$X =$vih*$dX+$PL*$vih;
	$Y =$sir*$dY+$PL*$sir;
    $x = $X;
	$y =$sir*$dy+$PL*$sir;
	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=0;
	$bC =cos(deg2rad($bb));
	$bS =sin(deg2rad($bb));
	$aC =cos(deg2rad($aa));
	$aS =sin(deg2rad($aa));
	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=-1;
	$rand=rand($cvetmin,$cvetmax);
	
	
include_once ($metod);
function fractal($x,$y,$X,$Y,$iterac,$cvet)
	{
		global $rand,$VINN,$image,$cvetmin,$cvetmax,$metod,$bC,$bS,$aC,$aS,$RrX,$Rr1X,$Rr,$Rr1,$n;
		$iterac++;
		if ($n>$iterac /*|| abs($x-$X)>0.5 && abs($y-$Y)>0.5*/)
		{	
			$x3= ($X-$x)*$aC-($Y-$y)*$aS+$x;
			$y3= ($X-$x)*$aS+($Y-$y)*$aC+$y;
			$x6= ($x-$x3)*$bC-($y-$y3)*$bS+$x3;
			$y6= ($x-$x3)*$bS+($y-$y3)*$bC+$y3;
			$x7= ($x-$x3)*$bC+($y-$y3)*$bS+$x3;
			$y7=-($x-$x3)*$bS+($y-$y3)*$bC+$y3;
			$x4= -($X-$x6)*$VINN+$x6;
			$y4= -($Y-$y6)*$VINN+$y6;
			$x5= -($X-$x7)*$VINN+$x7;
			$y5= -($Y-$y7)*$VINN+$y7;
		P_Line($X,$Y,$x6,$y6,$n-$iterac,$cvet);
		P_Line($X,$Y,$x7,$y7,$n-$iterac,$cvet);
				//P_Line($X,$Y,$x,$y,$n-$iterac,16725841);
			fractal($x5,$y5,$x7,$y7,$iterac,$cvet);//..право
			$cvet = $cvet-$rand;
			fractal($x4,$y4,$x6,$y6,$iterac,$cvet);//..лево
		}
	}
		fractal($x,$y,$X,$Y,$iterac,$cvet);
?>
