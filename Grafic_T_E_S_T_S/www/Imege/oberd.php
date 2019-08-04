<?php
	set_time_limit(0);
	set_time_limit(0);
	$vih = 1300 ;
	$sir = 1300 ;
	$dx  = 0.274 ;
	$dy  = 0.274;
	$dX  = 0.5 ;
	$dY  = 0.5 ;
	$n   = 10 ;
	$FON = 0xffffff;
	$aa = 0;
	$bb = 30 ;
	$Rr     = 0.1 ;
	$Rr1    = 0.3 ;
	$cvet   = 0x000000;
	$cvetmin = 0 ;
	$cvetmax = 0 ;
	$metod	 = "line";
	$zoom	= 0.01;
	$PL = 50.0;

	$x =$vih*$dx+$PL*$vih;
	$y =$sir*$dy+$PL*$sir;

	$X =$vih*$dX+$PL*$vih;
	$Y =$sir*$dY+$PL*$sir;

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
	$image = imagecreatetruecolor($vih,$sir) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	imagedestroy($image);                // освобождаем память, выделенную для изображения
	$image = imagecreatetruecolor($vih,$sir) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки


	//..*********РИСОВАНИЕ НАВСЕГДА*************,,
	  // "Зальем" фон картинки цветом $FON...
	imagefill($image, 0, 0, $FON);
imagesetthickness($image,1); 

	
	function P_Line($x,$y,$X,$Y,$cvet)
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
	global $image,$cvet,$cvetmin,$cvetmax,$metod,$bC,$bS,$aC,$aS,$RrX,$Rr1X,$Rr,$Rr1,$n;
	$iterac++ ;
	if (/*(($X-$x)*($X-$x)+($Y-$y)*($Y-$y))<1*/ $n>$iterac)
		{	
/*			
			$x4= $X*$RrX+$x3*$Rr;
			$y4= $Y*$RrX+$y3*$Rr;
			$x5= $x4*$Rr1X+$x3*$Rr;
			$y5= $y4*$Rr1X+$y3*$Rr1;
			$x6= ($x5-$x4)*$bC+$x4;
			$y6= ($x5-$x4)*$bS+$y4;
			$x7= ($x5-$x4)*$bC+$x4;
			$y7=-($x5-$x4)*$bS+$y4;
*/			
			@$x3= ($X-$x)*$aC-($Y-$y)*$aS+$x;
			@$y3= ($X-$x)*$aS+($Y-$y)*$aC+$y;
			@$x6= ($x3-$x)*$bC-($y3-$y)*$bS+$x;
			@$y6= ($x3-$x)*$bS+($y3-$y)*$bC+$y;
			@$x7= ($x3-$x)*$bC+($y3-$y)*$bS+$x;
			@$y7=-($x3-$x)*$bS+($y3-$y)*$bC+$y;



			$cvet = $cvet-rand($cvetmin,$cvetmax);
			//print $x." <br> ".$y." <br> ".$X." <br> ".$Y." <br> ".$x3." <br> ".$y3." <br> ".$x4." <br> ".$y4." <br> ".$x5." <br> ".$y5." <br> ".$x6." <br> ".$y6." <br> ".$x7." <br> ".$y7." <br> ".
		switch ($metod)
			{
				case "line" and $iterac !=0:
							P_Line($X,$Y,$x,$y,$cvet);
							break;
			}
				//fractal($x4,$y4,$x3,$y3,$iterac);//..продолжение ствола
				fractal($X,$Y,$x7,$y7,$iterac);//..право
				fractal($X,$Y,$x6,$y6,$iterac);//..лево 
			}
	}
		fractal($x,$y,$X,$Y,$iterac);
	header('Content-type: image/png');
	imagepng($image);
	imagedestroy($image);

?>
