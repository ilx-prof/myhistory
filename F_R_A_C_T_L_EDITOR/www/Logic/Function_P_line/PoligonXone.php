<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
							$verhini[0]=$x;
							$verhini[1]=$y;
							$verhini[2]=$X;
							$verhini[3]=$Y;
							$verhini[4]=0;
							$verhini[5]=0;
							imagepolygon ($image,$verhini,3,$cvet);
}
?>