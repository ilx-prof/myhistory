<?php

copy (__FILE__,"BACC.php");
	set_time_limit(0);
	$vih = 200;
	$sir = 200 ;
	$delta=0.222;
	$max_X=$dX= 1.2;//-0.35
	$max_Y=$dY= 1;//-0.5
	$min_x=$dx= -2.2;//-1
	$min_y=$dy= -1.2 ;//-0.5
	$n   = 25;
	$VINN=0.97;
	$FON = 0xffffff;
	$aa = 0;
	$bb = 85;//пиздатый 80 150
	$Rr     = 0.5 ;
	$Rr1    = 0.3 ;
	$cvet   = 0xff0000;
	$cvetmin = 0;
	$cvetmax = 0;
	$metod	 = "line";
	$zoom	= 1;
	$limit=1000000000000;
	$cof=0.00005;

	header('Content-type: image/png'); // устанавливаем тип документа - "изображение в формате PNG".
	$image = ImageCreateTrueColor($vih,$sir) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	imagedestroy($image);                // освобождаем память, выделенную для изображения
	$image = imagecreatetruecolor($vih,$sir) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
imagesetthickness($image,10); 
	//..*********РИСОВАНИЕ НАВСЕГДА*************,,
	  // "Зальем" фон картинки цветом $FON...
	imagefill($image, 0, 0, $FON);
$DX= ($max_X-$min_x)/$sir;
$DY= ($max_Y-$min_y)/$vih;
function P_Line($X,$Y,$cvet)
{
global $image; 
imagesetpixel($image, $X,$Y,$cvet);
}
function NamIt($x,$y)
{
	global $limit,$cof,$n;
	$i=0;
	$xx=$x;
	$yy=$y;
	while ($xx*$xx+$yy*$yy<=$limit)
	{
		$xk=$xx*$xx-$yy*$yy+$x;
		$yk=$cof*$yy*$xx+$y;
		$xx=$xk;
		$yy=$yk;
		$i++;
		if($i>=$n){break;}
	}
	return $i;
}
	function fractal($X,$Y)
	{
		global $vih,$sir,$n,$DX,$DY,$min_y,$min_x,$max_Y,$max_X;
		print "$vih,$sir,$n,$DX,$DY,$min_y,$min_x,$max_Y,$max_X;";
		$j=$i=0;
		$y=$min_y;
		while($j<$vih)
		{
			$j++;
			$x=$min_x;
			$i=0;
			while($i<$sir)
			{
				$i++;
			//	$cvet = 0xFFFFFF; 
				$cvet=8*($n-NamIt($x,$y));
				P_Line($j,$i,$cvet);
				$x +=$DX;
			}
			$y+=$DY;
		}
	}
	fractal(0,0);
  header('Content-type: image/png'); 
  // ...И, наконец, выведем сгенерированную картинку в формате PNG:
  imagepng($image);
?>
