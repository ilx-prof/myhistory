<?php
	$X =$vih*$dx/$zoom;
	$Y =$sir*$dx/$zoom;
	$x =$vih*$dx;
	$y =$sir*$dy;

	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=0;

	$bC =cos(rad2deg($bb));
	$bS =sin(rad2deg($bb));
	$aC =cos(rad2deg($aa));
	$aS =sin(rad2deg($aa));
	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=-1;

include_once ($metod);
	function fractal($x,$y,$X,$Y,$iterac)
	{
	global $image,$cvet,$cvetmin,$cvetmax,$metod,$bC,$aa,$bC,$bS,$aC,$aS,$RrX,$Rr1X,$Rr,$Rr1,$n;
	$iterac++ ;
		if (/*(($X-$x)*($X-$x)+($Y-$y)*($Y-$y))<1*/ $n>$iterac)
		{	
			$x3= /*($X-$x)*$aC*/-($Y-$y)*$aS/**$iterac*/+$X;
			$y3= /*($X-$x)*$aS*/-($Y-$y)*$aC/**$iterac*/+$Y;
			$x4= $X*$RrX+$x3*$Rr;
			$y4= $Y*$RrX+$y3*$Rr;
			$x5= $x4*$Rr1X+$x4*$Rr1X+$x3*$Rr;
			$y5= $y4*$Rr1X+$x4*$Rr1X+$y3*$Rr1;
			$x6= ($x5-$x4)*$bC/*-($y5-$y4)*$bS*/+$x4;
			$y6= ($x5-$x4)*$bS/*+($y5-$y4)*$bC*/+$y4;
			$x7= ($x5-$x4)*$bC/*+($y5-$y4)*$bS*/+$x4;
			$y7=-($x5-$x4)*$bS/*+($y5-$y4)*$bC*/+$y4;
			
			$cvet +=rand($cvetmin,$cvetmax);
					if ($iterac !=0)
						{
							P_Line($x,$y,$x4,$y4,$n,$cvet);
						}
				fractal($x4,$y4,$x3,$y3,$iterac);//..продолжение ствола
				fractal($x4,$y4,$x7,$y7,$iterac);//..право
				fractal($x4,$y4,$x6,$y6,$iterac);//..лево 
		}
	}
		fractal($x,$y,$X,$Y,$iterac);

?>
