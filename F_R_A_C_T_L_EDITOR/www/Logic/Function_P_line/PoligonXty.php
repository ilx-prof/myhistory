<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $metod,$image,$ygol,$bS,$bC;
							$verhini[0]=$X;
							$verhini[1]=$Y;
							$verhini[2]=$x;
							$verhini[3]=$y;
							$verhini[4]=$X-$x*COs(rad2deg($n));
							$verhini[5]=$Y-$y*Sin(rad2deg($n));
							imagepolygon ($image,$verhini,3,$cvet);
}
?>