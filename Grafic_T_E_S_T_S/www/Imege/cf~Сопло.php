<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//количество линий
$R =30  ;//Расстояние 
$X =$vih*0.5;
$Y = $sir*0.5;
$x =$vih*0.49;
$y = $sir*0.49;
$a=40;
  header('Content-type: image/png'); // устанавливаем тип документа - "изображение в формате PNG".
  $image = imagecreatetruecolor($vih,$sir) // создаем изображение...
	 or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	  imagedestroy($image);                // освобождаем память, выделенную для изображения
   $image = imagecreatetruecolor($vih,$sir) // создаем изображение... 
    or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки 

//..*********РИСОВАНИЕ НАВСЕГДА*************,,
  // "Зальем" фон картинки цветом 0x000000...
  imagefill($image, 0, 0, 0xffffff);
  // ...вертикальную линию...
 function RotateXYZ(&$X,&$Y,&$Z,$x,$y,$z,$L,$B)//..поворот координат относительно камеры
 {
 	$X=$x*cos($L)-$y*sin($L);
	$Y=$x*sin($L)*cos($B)+$y*cos($L)*cos($B)-$z*sin($B);
	$Z=$x*sin($L)*sin($B)+$y*cos($L)*sin($B)+$z*cos($B);
}
 
 function z_bufer($X,$Y,$Z)
 {
	return array($X/$Z,$Y/$Z);
 }

function  P_line($X,$Y,$x,$y,$R,$a)
{
	$h=1;
	$dh=0.5;
	$l=360;
	$dl=10;
	while(($h -=$dh) >= 0)
	{
		while(($l -=$dl) >= 0)
		{
			$P[]=
						$P[]=<br>
									$P[]=<br>
												$P[]=<br
															$P[]=
		}
	}
}
 
P_line($X,$Y,$x,$y,$R,$a);
//P_line($x,$y,$X,$Y,$R,$a);
 // Устанавливаем тип документа - "изображение в формате PNG"...
  header('Content-type: image/png'); 
  // ...И, наконец, выведем сгенерированную картинку в формате PNG:
  imagepng($image);
  imagedestroy($image);                // освобождаем память, выделенную для изображения


?>
