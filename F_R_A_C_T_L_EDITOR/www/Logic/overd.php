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
	$bC =cos(rad2deg($bb));
	$bS =sin(rad2deg($bb));
	$aC =cos(rad2deg($aa));
	$aS =sin(rad2deg($aa));
	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=-1;
	$rand=rand($cvetmin,$cvetmax);

	include_once ($metod);
	function fractal($x,$y,$X,$Y,$iterac)
	{
	global $image,$cvet,$cvetmin,$cvetmax,$metod,$bC,$bS,$aC,$aS,$RrX,$Rr1X,$Rr,$Rr1,$n;
	$iterac++ ;
	if (/*(($X-$x)*($X-$x)+($Y-$y)*($Y-$y))<1*/ $n>$iterac)
		{	
			@$x3= ($X-$x)*$aC-($Y-$y)*$aS+$x;
			@$y3= ($X-$x)*$aS+($Y-$y)*$aC+$y;
			@$x6= ($x3-$x)*$bC-($y3-$y)*$bS+$x;
			@$y6= ($x3-$x)*$bS+($y3-$y)*$bC+$y;
			@$x7= ($x3-$x)*$bC+($y3-$y)*$bS+$x;
			@$y7=-($x3-$x)*$bS+($y3-$y)*$bC+$y;
			$cvet = $cvet-rand($cvetmin,$cvetmax);
							if ($iterac !=0)
							{
								P_Line($X,$Y,$x,$y,$n-$iterac,rand($cvetmin,$cvetmax));
							}
				//fractal($x4,$y4,$x3,$y3,$iterac);//..продолжение ствола
				fractal($X,$Y,$x7,$y7,$iterac);//..право
				fractal($X,$Y,$x6,$y6,$iterac);//..лево 
			}
	}
		fractal($x,$y,$X,$Y,$iterac);

?>
