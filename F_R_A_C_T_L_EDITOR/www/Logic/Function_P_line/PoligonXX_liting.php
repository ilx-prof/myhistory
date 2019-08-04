<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $metod,$image,$ygol,$bS,$bC;
$R=abs($X-$x)+abs($Y-$y);
							$verhini[0]=($X-$x)-($Y-$y)+$x;
							$verhini[1]=($X-$x)+($Y-$y)+$y;
							$verhini[2]=($verhini[0]-$x)*$bC-($verhini[1]-$y)*$bS+$x;
							$verhini[3]=($verhini[0]-$x)*$bS+($verhini[1]-$y)*$bC+$y;
							$verhini[4]=($verhini[0]-$x)*$bC+($verhini[1]-$y)*$bS+$x;
							$verhini[5]=-($verhini[0]-$x)*$bS+($verhini[1]-$y)*$bC+$y;
							$verhini[6]=-($X-$verhini[2])+$verhini[2];
							$verhini[7]=-($Y-$verhini[3])+$verhini[3];
							imagepolygon ($image,$verhini,4,$cvet);
}
?>