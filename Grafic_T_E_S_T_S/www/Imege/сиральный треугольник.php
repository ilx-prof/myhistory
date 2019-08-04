<?php
set_time_limit(0);
$vih = 1000;
$sir = 1000;
$R =0.9;//Расстояние 
$X =$vih*0.4;
$Y = $sir*0.4;
  header('Content-type: image/png'); // устанавливаем тип документа - "изображение в формате PNG".
  $image = imagecreatetruecolor($vih,$sir) // создаем изображение...
	 or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	  imagedestroy($image);                // освобождаем память, выделенную для изображения
   $image = imagecreatetruecolor($vih,$sir) // создаем изображение... 
    or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки 

//..*********РИСОВАНИЕ НАВСЕГДА*************,,
  // "Зальем" фон картинки цветом 0x000000...
  imagefill($image, 0, 0, 0x000000);
  // ...вертикальную линию...
function cun($X,$Y,$R,$n,$YGOL)
{	$XR=$X;
	$YR=$Y;
	global $image;
	$cvet=rand(0x99545588,0x99999999);//По идеее  4294967295
	$ygol=0;
  	$i=0;
	while($i<$n)
		{		
	$cvet=$cvet-60;
	if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			IF($i<$n/3)
			{
				$y =cos($ygol)*$R+$Y;
				$x =sin($ygol)*$R+$X;
				imageline($image, ABS($x),ABS($y),ABS($X),ABS($Y),$cvet);
				$ygol+=$YGOL/($i+1);
				$i++;
			}
			ELSE
			{
				if($i==$n/3)
				{
					$Y=$Y;
					$X=$X;
				}
				$x-=cos($ygol)*$R+$Y;
				$y=sin($ygol)*$R+$X;
				imageline($image, ABS($x),ABS($y),ABS($X),ABS($Y),$cvet);
				$ygol-=$YGOL/sin($i)*$i;
				$i++;
			}
	  }
	}

cun($X,$Y,$R,123213,60);
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
