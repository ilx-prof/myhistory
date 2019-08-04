<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//количество линий
$R =180  ;//Расстояние 
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
FUNCTION MERIDIAN ($X,$Y,$x,$y,$R,$a)
{
global $image;
$dl=10;
$db = 10;
	FOR($L=0; $L<360; $L+=$dl )
	{
		for ($B=-90; $B<=90 ; $B+=$db)
		{
			$XX = $R*cos($B)*sin($L)+$x;
			$YY = $R*cos($B)*cos($L)+$y;
			$ZZ = $R*sin($B)+1;
			$xy = z_bufer($XX,$YY,$ZZ);
			imagesetpixel ($image,$XX,$YY,0x000000);
//			imagesetpixel ($image,$xy[0],$xy[1],0x000000);
			//imageline($image, $XX,$YY,$xy[0],$xy[1],0x000000);
		}
	}
}

MERIDIAN ($X,$Y,$x,$y,$R,$a); 
 
 
function  P_line($X,$Y,$x,$y,$R,$a)
{
global $image;
	$h=-0.05;
	$dh=0.05;
	$l=0;
	$dl=1;
	
	while(($h +=$dh) < 0.5)
	{
		while(($l +=$dl) < 360)
		{
			$P[0]=$h+$x;			$P[1]=$l+$y;
			$P[2]=$h+$dh+$x;		$P[3]=$l+$y;
			$P[4]=$h+$dh+$x;		$P[5]=$l+$dh+$y;
			$P[6]=$h+$x;			$P[7]=$l+$dh+$y;
			imagepolygon ($image,$P,4,0x000000);
		}
	}
} 
//P_line($X,$Y,$x,$y,$R,$a);
//P_line($x,$y,$X,$Y,$R,$a);
 // Устанавливаем тип документа - "изображение в формате PNG"...
  header('Content-type: image/png'); 
  // ...И, наконец, выведем сгенерированную картинку в формате PNG:
  imagepng($image);
  imagedestroy($image);                // освобождаем память, выделенную для изображения


?>
