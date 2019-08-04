<?php
include_once ($metod);
function fractal($X,$Y,$R,$n,$ygol,$onedel,$alldel,$Rr,$cvetmin,$cvetmax)
	{
		global $image, $cvet;
		$i=$n;
		$RrR = $Rr*$R;
		$ygol-=$ygol/$onedel;
		$yg = rad2deg($ygol-=$ygol/$alldel);
		$y = cos($yg)*$RrR+$Y;
		$x = sin($yg)*$RrR+$X;
		$Y=$y;
		$X=$x;
		while($i>0)
		{
			$Y=$y;
			$X=$x;
			$y = cos($yg)*$RrR+$Y;
			$x = sin($yg)*$RrR+$X;
			P_Line($x,$y,$X,$Y,$i,$cvet=rand($cvetmin,$cvetmax));// -= rand($cvetmin,$cvetmax));
			$yg = rad2deg($ygol-=$ygol/$alldel);
			$i--;
		 }
	}

fractal($vih*$dx,$sir*$dy,$R,$n++,$ygol,$onedel,$alldel,$Rr,$cvetmin,$cvetmax);
	?>