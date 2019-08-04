<?php
set_time_limit(0);
	$vih = 50;
	$sir = 110;
	$n   = 1256;
	$FON = 0xffffff;
	header('Content-type: image/jpg'); // устанавливаем тип документа - "изображение в формате PNG".
	$image = ImageCreateTrueColor($sir,$vih) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	imagedestroy($image);                // освобождаем память, выделенную для изображения
	$image = imagecreatetruecolor($sir,$vih) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	imagesetthickness($image,10); 
	//..*********РИСОВАНИЕ НАВСЕГДА*************,,
	  // "Зальем" фон картинки цветом $FON...
	imagefill($image, 0, 0, $FON);
/*	$DX= ($max_X-$min_x)/$sir;
	$DY= ($max_Y-$min_y)/$vih;
*/
function P_Line($X,$Y,$cvet)
{
	global $image;
	imagesetpixel($image, $X,$Y,$cvet);
}

function NamberIterac()
{
	return rand(48654484,48654486);
}
function rand_prob()
{
	return rand (10,20);
}
function fractal($X,$Y)
{
	global $image,$vih,$sir,$n/*,$DX,$DY,$min_y,$min_x,$max_Y,$max_X*/;//$cvet,$vih,$sir,$rand,$VINN,$image,$cvetmin,$cvetmax,$metod,$DX,$DY,$min_y,$min_x,$max_Y,$max_X;
	$y=$j=$i=0;
		while($j<$vih)
		{
			$j++;
			$x=0;
				$i=0;
			while($i<$sir)
			{
				$i++;
				$cvet=rand(0,546546)*($n-NamberIterac());
				if ($cvet&1)
				{
				$cvet=0x0;
				}
				else
				{
					$cvet=0xffffff;
				}
				P_Line($X+$i,$Y+$j,$cvet);
				$x++;
			}
			$y++;
		}

//imagepstext ($image,$TEXT,"Times New Roman","20","0xffffff", "0xffffff", 0, 0);
//imagestring ($image,"Times New Roman",0, 0,$TEXT,0xFFFFFF);
	 FUNCTION black()
{
	GLOBAL $image;
	RETURN imagecolorallocate($image, RAND(0,255),RAND(0,255),RAND(0,255));
}
	$n=20;
	$a=20;

	imagettftext($image, rand(18,25), rand(-10,10),$n,$a+rand_prob(), black(),'ARIAL.TTF', chr(rand(65, 90)));
		imagettftext($image, rand(18,25), rand(-10,10),$n+=rand_prob(),$a+rand_prob(), black(),'ARIAL.TTF', chr(rand(65, 90)));
			imagettftext($image, rand(18,25), rand(-10,10),$n+=rand_prob(),$a+rand_prob(), black(),'ARIAL.TTF', chr(rand(65, 90)));
				imagettftext($image, rand(18,25), rand(-10,10),$n+=rand_prob(),$a+rand_prob(), black(),'ARIAL.TTF', chr(rand(65, 90)));
					imagettftext($image, rand(18,25), rand(-10,10),$n+=rand_prob(),$a+rand_prob(), black(),'ARIAL.TTF', chr(rand(65, 90)));
}
	fractal(0,0);
  header('Content-type: image/jpg'); 

  imagepng($image);
?>
