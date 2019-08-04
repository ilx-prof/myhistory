<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//количество линий
$R =30  ;//Расстояние 
$X =$vih*0.1;
$Y = $sir*0.1;
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
function cun($X,$Y,$R,$a)
{
	global $image;
	$cvet=rand(0x0,0x99999999);//По идеее  4294967295
	$ygol = 0;
  	$i=0;
	while($i<133)
	{		
			if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			
			$y =cos($ygol)*pi()*$R+$Y;
			$x =sin($ygol)*pi()*$R+$X;
			
			imageline($image, $x,$y,$X,$Y,$cvet);
			$ygol+=$a;
			$i++;
			$yi =cos(-$ygol)*pi()*$R+$Y;
			$xi =sin(-$ygol)*pi()*$R+$X;
			imageline($image, $xi,$yi,$X,$Y,$cvet-$cvet/2);
	  }
}
$a=1;
cun($X,$Y,$R,$a);
while ($a<12)
{
$a++;
	cun($X+=$R+$R+$R,$Y+=3*$R,$R,$a);
		cun($X+=$R-80,$Y+=$R-80,$R-=1,-$a);
}
  // Устанавливаем тип документа - "изображение в формате PNG"...
  header('Content-type: image/png'); 
  // ...И, наконец, выведем сгенерированную картинку в формате PNG:
  imagepng($image);

  imagedestroy($image);                // освобождаем память, выделенную для изображения


?>
