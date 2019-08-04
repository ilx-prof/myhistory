<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image,$bC,$bS;
							$R=abs($X-$x)+abs($Y-$y);
							$verhini[0]=($X-$x)-($Y-$y)+$x;
							$verhini[1]=($X-$x)+($Y-$y)+$y;
							$verhini[2]=($verhini[0]-$x)*$bC-($verhini[1]-$y)*$bS+$x;
							$verhini[3]=($verhini[0]-$x)*$bS+($verhini[1]-$y)*$bC+$y;
							$verhini[4]=($verhini[0]-$X)*$bC+($verhini[1]-$Y)*$bS+$X;
							$verhini[5]=-($verhini[0]-$X)*$bS+($verhini[1]-$Y)*$bC+$Y;
							$verhini[6]=-($X-$verhini[2])+$verhini[2];
							$verhini[7]=-($Y-$verhini[3])+$verhini[3];
							imagefilledpolygon  ($image,$verhini,4,$cvet);
}
?>