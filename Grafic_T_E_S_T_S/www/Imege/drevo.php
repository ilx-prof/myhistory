<?php
	set_time_limit(0);

	$vih = 1300 ;
	$sir = 1300 ;
	$delta=0.222;
	$dx  = 0.49+$delta ;
	$dy  = 0.49+$delta;
	$dX  = 0.5 ;
	$dY  = 0.5 ;
	$n   =12;
	$VINN=0.97;
	$FON = 0x000000;
	$aa = 0;
	$bb = 85;//пиздатый 80 150
	$Rr     = 0.5 ;
	$Rr1    = 0.3 ;
	$cvet   = 0xffffff;
	$cvetmin = 0 ;
	$cvetmax = 0 ;
	$metod	 = "line";
	$zoom	= 1;
	$PL=0;
/*	$x =$vih*$dx+$PL*$vih;
	$y =$sir*$dy+$PL*$sir;*/

	$X =$vih*$dX+$PL*$vih;
	$Y =$sir*$dY+$PL*$sir;

        $x = $X;
	$y =$sir*$dy+$PL*$sir;


	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=0;

	$bC =cos(rad2deg($bb));
	$bS =sin(rad2deg($bb));
	$aC =cos(rad2deg($aa));
	$aS =sin(rad2deg($aa));
	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=-1;
	header('Content-type: image/png'); // устанавливаем тип документа - "изображение в формате PNG".
	$image = ImageCreateTrueColor($vih,$sir) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	imagedestroy($image);                // освобождаем память, выделенную для изображения
	$image = imagecreatetruecolor($vih,$sir) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки


	//..*********РИСОВАНИЕ НАВСЕГДА*************,,
	  // "Зальем" фон картинки цветом $FON...
	imagefill($image, 0, 0, $FON);
imagesetthickness($image,1); 

	
	function P_Line($X,$Y,$x,$y,$cvet)
	{
		global $image,$zoom;
		settype($x, "integer");
		settype($y, "integer");
		settype($X, "integer");
		settype($Y, "integer");
		//print "1 точка x,y - $x,$y <br> 2 точка X,Y - $X,$Y";
		imageline($image, $X*$zoom,$Y*$zoom,$x*$zoom,$y*$zoom,$cvet);
	}
	
	function fractal($x,$y,$X,$Y,$iterac)
	{
		global $VINN,$image,$cvet,$cvetmin,$cvetmax,$metod,$bC,$bS,$aC,$aS,$RrX,$Rr1X,$Rr,$Rr1,$n;
		$iterac++ ;

		if (/*(($X-$x)*($X-$x)+($Y-$y)*($Y-$y))<1*/ $n>$iterac)
		{
			/*$x3= ($X-$x)*$aC-($Y-$y)*$aS+$x;
			$y3= ($X-$x)*$aS+($Y-$y)*$aC+$y;*/
			$x6= ($X-$x)*$bC-($Y-$y)*$bS+$x;
			$y6= ($X-$x)*$bS+($Y-$y)*$bC+$y;
			$x7= ($X-$x)*$bC+($Y-$y)*$bS+$x;
			$y7=-($X-$x)*$bS+($Y-$y)*$bC+$y;

			$x4= -($X-$x6)*$VINN+$x6;
			$y4= -($Y-$y6)*$VINN+$y6;
			$x5= -($X-$x7)*$VINN+$x7;
			$y5= -($Y-$y7)*$VINN+$y7;

			$cvet = $cvet-rand($cvetmin,$cvetmax);
			//print $x." <br> ".$y." <br> ".$X." <br> ".$Y." <br> ".$x3." <br> ".$y3." <br> ".$x4." <br> ".$y4." <br> ".$x5." <br> ".$y5." <br> ".$x6." <br> ".$y6." <br> ".$x7." <br> ".$y7." <br> ".
			
			switch ($metod)
			{
				case "line" :
					case $iterac != 0 :
						P_Line($X,$Y,$x6,$y6,$cvet);
						P_Line($X,$Y,$x7,$y7,$cvet);
					break;
				break;
			}

			fractal($x5,$y5,$x7,$y7,$iterac);//..право
			fractal($x4,$y4,$x6,$y6,$iterac);//..лево

		}
	}
		fractal($x,$y,$X,$Y,$iterac);

	header('Content-type: image/vnd.wap.wbmp');

	
	
	imagewbmp($image);

	imagedestroy($image);

?>
