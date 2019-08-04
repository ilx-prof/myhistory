<?php

copy (__FILE__,"BACC.php");
	set_time_limit(0);
	$vih = 130;
	$sir = 130 ;
	$max_X=$dX= 1.2;//-0.35
	$max_Y=$dY= 1;//-0.5
	$min_x=$dx= -2.2;//-1
	$min_y=$dy= -1.2 ;//-0.5
	$n   =100;
	$limit=4;
	$cof=2;
	$FON= 0xFFFFFF;
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


function Julia($x0,$y0)
{global $cof;
	$r=1;
	$xx=0.36; $yy=0.36;
	$x=$x0; $y=$y0;
	$n=100;
	while ($r<2 ) 
	{		
		$x2 = $x*$x;
		$y2 = $y*$y;
		$xy = $x*$y;
		$x = $x2-$y2+$xx;
		$y = $cof*$xy+$yy;
		$r = $x2+$y2;
		$n--;
		if(0>=$n){$n=16777215; break; }
	}
	switch ($n)
	{
	case $n<30:
		$n=16777215;
		 break;
	}
	return $n*66;
}

	function fractal($X,$Y)
	{
		global $vih,$sir,$n,$DX,$DY,$min_y,$min_x,$max_Y,$max_X;
		$j=$i=0;
					$b=0;
		$y=$min_y;
		while($j<$vih)
		{
			$j++;
			$x=$min_x;
				$i=0;
			while($i<$sir)
			{
				$i++;
				$cvet=8*(Julia($x,$y));
				P_Line($i,$j,$cvet);
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
