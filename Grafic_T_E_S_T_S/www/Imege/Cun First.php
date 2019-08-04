<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//количество линий
$R =0.1*$sir  ;//Расстояние 
$X =$vih*0.5;
$Y = $sir*0.5;
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
function cun($X,$Y,$R)
{
	global $image;
	global $r;
	$ygol = 0;
  	$i=0;
	while($i<360)
	{
			$y =cos(rad2deg($ygol))*pi()*$R+$Y;
			$x =sin(rad2deg($ygol))*pi()*$R+$X;
			imageline($image, $X,$Y,$x,$y, 0xFFFF00);
			$ygol ++;
			$i++;
	  }
	  
}
cun($X,$Y,$R);

  // Устанавливаем тип документа - "изображение в формате PNG"...
  header('Content-type: image/png'); 
  // ...И, наконец, выведем сгенерированную картинку в формате PNG:
  imagepng($image);

  imagedestroy($image);                // освобождаем память, выделенную для изображения


?>
