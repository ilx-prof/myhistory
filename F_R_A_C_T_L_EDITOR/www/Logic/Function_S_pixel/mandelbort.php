<?
function S_color($x,$y,$iterac,$n)
{
global $cvet;
	$i=0;
	$xx=$x;
	$yy=$y;
	while ($xx*$xx+$yy*$yy<=4)//$limit)
	{
		$xk=$xx*$xx-$yy*$yy+$x;
		$yk=2*$yy*$xx+$y;
		$xx=$xk;
		$yy=$yk;
		$i++;
		if($i>=$n){break;}
	}
	 return 1048575-($n-$i)*$cvet;
}
?>
