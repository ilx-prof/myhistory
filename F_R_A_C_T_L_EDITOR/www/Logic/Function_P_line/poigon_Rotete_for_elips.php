<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
							$verhini[0]=$X;
							$verhini[1]=$Y;
							$verhini[2]=$x+$X*sin(rad2deg($n++));;
							$verhini[3]=$y+$Y*cos(rad2deg($n++));;
							$verhini[4]=$X-$x*sin(rad2deg($n++));
							$verhini[5]=$Y-$y*cos(rad2deg($n++));
							imagepolygon ($image,$verhini,3,$cvet);
}
?>