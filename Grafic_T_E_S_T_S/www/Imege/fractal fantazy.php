<?php
$vih = 2300;
$sir = 2300;
$r = 0.1*$sir ;//количество линий
$R =2  ;//Расстояние 
$X =0;
$Y =$sir;
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
function cun($X,$Y,$R/*,$n,$YGOL*/)
{
	global $image;
	$cvet=0xFFFFFFF;//rand(0x0,0x99999999);//По идеее  4294967295
	$ygol = 1;
  	$i=0;
	$n=rand(30,300000);
	while($i<$n)//где $i-количество граней
	{		if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			
			$y =cos(rad2deg($ygol))*pi()*$R+$Y;
			$x =sin(rad2deg($ygol))*pi()*$R+$X;
			imageline($image, $x,$y,$X,$Y,$cvet);
			if($i==0)
			{
			$ygol-=$ygol/0.0000000000036;
			}
			$ygol-=$ygol/2020222;
			$i++;
			$cvet=$cvet-rand(1,4500);
	  }
}

cun($X,$Y,$R/*,60,90*/);/*
$a=0;
while ($a<12)
{
$a++;
	cun($X+=$R,$Y+=$R,$R,100,$a);
		cun($X+=$R-80,$Y+=$R-80,$R,100,80-$a);
}*/
  // Устанавливаем тип документа - "изображение в формате PNG"...
  header('Content-type: image/png'); 
  // ...И, наконец, выведем сгенерированную картинку в формате PNG:
  imagepng($image);

  imagedestroy($image);                // освобождаем память, выделенную для изображения


?>
