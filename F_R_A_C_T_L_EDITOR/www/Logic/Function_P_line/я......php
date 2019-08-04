<?php 
function P_Line($x,$y,$X,$Y,$cvet)
{
global $metod,$image,$ygol,$bS,$bC;
$R=abs($X-$x)+abs($Y-$y);
			switch ($metod)
			{
				case "line": 
							imageline($image, $x,$y,$X,$Y,$cvet);
							break;
				case "pixXpix":
							imagesetpixel($image, $x,$y,$cvet);
							imagesetpixel($image, $X,$Y,$cvet);
							break;
				case "pixCOnec": 
							imagesetpixel($image, $x,$y,$cvet);
							break;
				case "pixHOME": 
							imagesetpixel($image, $X,$Y,$cvet);
							break;
				case "rangeXone": 
							imageellipse($image, $x,$y,$X,$Y,$cvet);
							break;
				case "rangeXty": 
							imageellipse($image, $X,$Y,$x,$y,$cvet);
							break;
				case "boxXone": 
							imagerectangle ($image, $x,$y,$X,$Y,$cvet);
							break;
				case "boxXty": 
							imagerectangle ($image, $X,$Y,$x,$y,$cvet);
							break;
				case "PoligonXone": 
							$verhini[0]=$x;
							$verhini[1]=$y;
							$verhini[2]=$X;
							$verhini[3]=$Y;
							$verhini[4]=$Y-$y;
							$verhini[5]=$X-$x;
							imagepolygon ($image,$verhini,3,$cvet);
							break;
				case "PoligonXty": 
							$verhini[0]=$X;
							$verhini[1]=$Y;
							$verhini[2]=$x;
							$verhini[3]=$y;
							$verhini[4]=$X-$x*COs($x);
							$verhini[5]=$Y-$y*Sin($y);
							imagepolygon ($image,$verhini,3,$cvet);
							break;
				case "PoligonXX": 
							$verhini[0]=($X-$x)-($Y-$y)+$x;
							$verhini[1]=($X-$x)+($Y-$y)+$y;
							$verhini[2]=($verhini[0]-$x)*$bC-($verhini[1]-$y)*$bS+$x;
							$verhini[3]=($verhini[0]-$x)*$bS+($verhini[1]-$y)*$bC+$y;
							$verhini[4]=($verhini[0]-$x)*$bC+($verhini[1]-$y)*$bS+$x;
							$verhini[5]=-($verhini[0]-$x)*$bS+($verhini[1]-$y)*$bC+$y;
							$verhini[6]=-($X-$verhini[2])+$verhini[2];
							$verhini[7]=-($Y-$verhini[3])+$verhini[3];
							imagepolygon ($image,$verhini,4,$cvet);
							break;
			}
}
?>