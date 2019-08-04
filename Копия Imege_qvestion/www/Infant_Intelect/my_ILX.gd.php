<?
//imagefilltoborder - заполняет заливкой специфицированного цвета
//imagecolorat - получает индекс цвета пиксела
//imagesetpixel - устанавливает одиночный пиксел
//imagesx - получает ширину изображения
//imagesy - получает высоту изображения
//imagetruecolortopalette - конвертирует изображение true color в палитровое изображение.
//imagecolorclosesthwb - получает индекс цвета, оттенок, белизну и черноту, ближайшие к данному цвету



function image_to_vector (&$image)
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$im_fill_obgect = array();
	$im_fill_obgect[]=$im_fil_color = 16777215;
	$x=0;
	$y=0;
	array();
	while($y <= $sise_Y)
	{
		$x=0;
		while($x<=$sise_X)
		{
			$col=imagecolorat ($image, $x,$y);
			if ($col == $im_fil_color or in_array ($col,$im_fill_obgect))
			{
					$x++;
			}
			else
			{
					$im_fil_color += $x*($y+1);
					imagefill ($image,$x,$y,$im_fil_color);
					$im_fill_obgect[] = $im_fil_color;
					$x++;
			}
		}
		$y++;
	}
	return $im_fill_obgect ;
}

function image_to_gray (&$image)
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$y=0;
	 while($y <= $sise_Y)
	{
		$x=$i=0;
		while($x<=$sise_X)
		{
			$color_index = imagecolorat ($image, $x,$y);
			$color = imagecolorsforindex ( $image, $color_index );
			$gray = ceil ( array_sum ( $color ) / 3 );
			imagesetpixel ($image,$x,$y,imagecolorallocate ( $image, $gray, $gray, $gray ));

 			$x++;
		}
		$y++;
	}
	return $image ;
}


function image_invert_black_white (&$image,$col_1 = 0x0,$col_2=16777215)//..Заменяет цвет с $col_1 на $col_2-$col_1 варианту
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$y=0;
	 while($y <= $sise_Y)
	{
		$x=$i=0;
		while($x<=$sise_X)
		{
		        if (imagecolorat ($image, $x,$y)==$col_1)
		        {
				imagesetpixel ($image,$x,$y,$col_2);
		        }
 			$x++;
		}
		$y++;
	}
return $image ;
}

function image_plunder_black_X (&$image,$noBlac=16777215)//..заливает убирает один пиксель черного цвета по всем его контурам
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$y=0;
	while($y <= $sise_Y)//по Х
	{
		$x=$i=0;
		$one = imagecolorat ($image, $x,$y);
		while($x<$sise_X)
		{
			$ty  = imagecolorat ($image, $x+1,$y);
			if ($one==$ty)
			{
				$x++;
				$ty=$one;
			}
			else
			{
				if($one==$noBlac)
				{
					 imagesetpixel ($image,$x+1,$y,$noBlac);
					 if ($x+2<=$sise_X)
					 {
						 $one=imagecolorat ($image, $x+2,$y);
					 }
					 $x+=2;
				}
				elseif($one==0)
				{
					imagesetpixel ($image,$x,$y,$noBlac);
					$one=$ty;
					$x++;
				}
				else
				{
					$one=$ty;
					$x++;
				}
			}
		}
		$y++;
	}
return $image ;
}

function image_plunder_black_Y (&$image,$noBlac=16777215)//..Граница переходит на сторону цвета
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$x=0;
	while($x <= $sise_X)//по Х
	{
		$y=0;
		$one = imagecolorat ($image, $x,$y);
		while($y<$sise_Y)
		{
		$ty  = imagecolorat ($image, $x,$y+1);
			if ($one==$ty)
			{
				$y++;
				$ty=$one;
			}
			else
			{
				if($one==$noBlac)
				{
					 imagesetpixel ($image,$x,$y+1,$noBlac);
					 if ($y+2<=$sise_Y)
					 {
						 $one=imagecolorat ($image, $x,$y+2);
					 }
					 $y+=2;
				}
				elseif($one==0)
				{
					imagesetpixel ($image,$x,$y,$noBlac);
					$one=$ty;
					$y++;
				}
				else
				{
					$one=$ty;
					$y++;
				}
			}
		}
		$x++;
	}
return $image ;
}
function image_plunder_black_XY (&$image,$noBlac1=16777215,$noBlac2=16777215)//..заливает убирает один пиксель черного цвета по всем его контурам
{
image_plunder_black_X ($image,$noBlac1);
image_plunder_black_Y ($image,$noBlac2);
}

function image_palite (&$image)//Экстперементальная палдитра
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$y=0;
	$a=8290687;
	$a=8290682/2;
	 while($y <= $sise_Y)
	{
		$x=$i=0;
		while($x<$sise_X)
		{
                             imagesetpixel($image, $x,$y,$a);
                       $a++;
		$x++;
		}
		$y++;
	}
return $image ;
}

  ##################################

	function ResizeImage(&$image,$new_width,$new_height,$x,$y,$size=0)
	{
		$width=imagesx ($image)-1;
		$height=imagesy ($image)-1;
		$image_p = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($image_p, $image, 0, 0,0,0, $new_width, $new_height, $width, $height);
		if($size == 0)
		{
			return $image_p;
		}
		else
		{
	        	$image2 = imagecreatetruecolor($size, $size);
			$bg=imagecolorallocate($image2,255,255,255);
			imagefill( $image2, 0, 0, $bg );
			imagecopymerge($image2,$image_p,$x,$y,0,0,$size,$size,100);
			imagefill( $image2, $x, $y, $bg );
			return $image2;
		}
	}
function MaxSizeThumbnail(&$image,$size) {
			$width=imagesx ($image)-1;
			$height=imagesy ($image)-1;
			if($width > $height) {
				$size_percent = (int)($size / ($width / 100));
				$new_height = (int) ($size_percent * ($height/100));
				$new_width  = $size;
				$y = ($size - $new_height) / 2;
				$x = 0;
				//echo $x;
			} else {
				$size_percent = (int)($size / ($height / 100));
				$new_width = (int) ($size_percent * ($width/100));
				$new_height  = $size;
				$x = ($size - $new_width) / 2;
				$y = 0;
			}
			return ResizeImage($image,$new_width,$new_height,$x,$y);
     	}


?>