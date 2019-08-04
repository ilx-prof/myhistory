<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//количество линий
$R =40  ;//Расстояние 
$X =$vih*0.5;
$Y = $sir*0.9;
  header('Content-type: image/png'); // устанавливаем тип документа - "изображение в формате PNG".
  $image = imagecreatetruecolor($vih,$sir) // создаем изображение...
	 or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	  imagedestroy($image);                // освобождаем память, выделенную для изображения
   $image = imagecreatetruecolor($vih,$sir) // создаем изображение... 
    or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки 

//..*********РИСОВАНИЕ НАВСЕГДА*************,,
  // "Зальем" фон картинки цветом 0x000000...
  imagefill($image, 0, 0, 0x0);
  // ...вертикальную линию...
  
  function ygol($X,$Y,$R,$i)
  {	
  	$cvet=0x0005445;//..осюдам 
  		$x=$X;
		$y=$Y;
		$Xr=-sin(rad2deg(120))*($R+$i)+$X;
		$Yr=-cos(rad2deg(0))*($R+$i)+$Y;

	imageline($image, $x,$y,$Xr,$Yr,$cvet);
		$Xl=-sin(rad2deg(360))*($R+$i)+$X;
		$Yl=-cos(rad2deg(0))*($R+$i)+$Y;
	imageline($image, $x,$y,$Xl,$Yl,$cvet);//..до сюды работает 
  }
  
function cun($X,$Y,$R,$n,$YGOL)
{
	global $image;
;//По идеее  4294967295
	$ygol = 0;
  	$i=0;
	
	$y =cos($ygol)*$R+$Y;
	$x =sin($ygol)*$R+$X;
	imageline($image, $x,$y,$X,$Y,0xFFFFFFF);

ygol($X,$Y,$R,$i);//вызов не работает
/*	while($i<$n-1)
	{		if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			
			$y =cos($ygol)*$R+$Y;
			$x =sin($ygol)*$R+$X;
			
			imageline($image, $x,$y,$X,$Y,$cvet);
			$ygol+=$YGOL;
			$i++;
	  }*/
}

cun($X,$Y,$R,60,90);
$a=0;

while ($a<-1)
{
$a++;
	cun($X+=$R,$Y+=$R,$R,100,$a);
		cun($X+=$R-80,$Y+=$R-80,$R,100,80-$a);
}
  // Устанавливаем тип документа - "изображение в формате PNG"...
  header('Content-type: image/png'); 
  // ...И, наконец, выведем сгенерированную картинку в формате PNG:
  imagepng($image);

  imagedestroy($image);                // освобождаем память, выделенную для изображения


?>
