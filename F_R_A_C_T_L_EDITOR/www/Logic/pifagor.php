<?php
	$dx  =$dx+$delta ;
	$dy  =$dx+$delta;

	$XY[] = $vih*$dX+$PL*$vih;
	$XY[] = $sir*$dY+$PL*$sir;
	$xy[] = $XY[0];
	$xy[] = $sir*$dy+$PL*$sir;
	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=0;
	
	$bC =cos(deg2rad ($bb));//правильная
	$bS =sin(deg2rad ($bb));
	$aC =cos(deg2rad ($aa));
	$aS =sin(deg2rad ($aa));

	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=-1;
	$rand=rand($cvetmin,$cvetmax);
	$tvig --;
	$tvig = $tvig == 0 ? 1 :$tvig;
	$atvig=2*$bb/$tvig;
	$i=0;
			while($i++<$tvig)
			{
				$cs[]=array(cos(deg2rad($atvig*$i)),-sin(deg2rad($atvig*$i)));
			}
//include("functionals_addon.php");

include_once ($metod);
function fractal($xy,$XY,$iterac,$cvet)
	{
		global $rand,$VINN,$image,$bC,$bS,$aC,$aS,$n,$bb,$tvig,$atvig,$cs,$tree;
		$iterac++;
		if ($n>$iterac /*|| abs($x-$X)>0.5 && abs($y-$Y)>0.5*/)
		{
			$xy3=turn($xy,$XY,$aC,$aS);//ПОВЕРНУТЬ ОТРЕЗОК $xy,$XY НА УГОЛ а с центром поворота в $xy
			$xy6=turn($xy3,$xy,$bC,$bS);//Онтезокполучившийся приэтом $xy,$XY  $xy,$XY НА УГОЛ а
			$xy4=long($XY,$xy6,$VINN);
			$cvet = $cvet-$rand;
		P_Line($XY[0],$XY[1],$xy6[0],$xy6[1],$n-$iterac,$cvet);
		fractal($xy4,$xy6,$iterac,$cvet);//..лево

			$i=0;
			while($i++<$tvig)
			{
					$cvet = $cvet-$rand;
					$temp = turn($xy3,$xy6,($cs[$i-1][0]),($cs[$i-1][1]));
					P_Line($XY[0],$XY[1],$temp[0],$temp[1],$n-$iterac,$cvet);
					$cel = long($XY,$temp,$VINN);
					fractal($cel,$temp,$iterac,$cvet);
			}
			$cvet = $cvet-$rand;
		if( $tree )//Прямая ветвления центер
		{
				imageline ($image,$XY[0],$XY[1],$xy[0],$xy[1],16725841);
		}
		}
	}
	fractal($xy,$XY,$iterac,$cvet)

?>
