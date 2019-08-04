<?php
	set_time_limit(0);

	$vih = 1000 ;
	$sir = 1000 ;
	/*$dxA = $_POST["dxA"] ;
	$dyA = $_POST["dyA"] ;*/
	$n   = 10 ;
	$FON = 0x000000;
	$aa = 90 ;
	$bb = 86;
	$Rr     = 0.14 ;
	$Rr1    = 0.1 ;
	$cvet   = 0xffffff;
	$cvetmin = 0;
	$cvetmax = 4500 ;
	$metod	 = "line";
	$X =500;
	$Y =300;
	$x =200;
	$y =500;

	$bC =cos(rad2deg($bb));
	$bS =sin(rad2deg($bb));
	$aC =cos(rad2deg($aa));
	$aS =sin(rad2deg($aa));
	$RrX=(1-$Rr);
	$Rr1X=(1-$Rr1);
	$iterac=0;
		header('Content-type: image/png'); // ������������� ��� ��������� - "����������� � ������� PNG".
	$image = imagecreatetruecolor($vih,$sir) // ������� �����������...
	or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
	imagedestroy($image);                // ����������� ������, ���������� ��� �����������
	$image = imagecreatetruecolor($vih,$sir) // ������� �����������...
	or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������


	//..*********��������� ��������*************,,
	  // "������" ��� �������� ������ $FON...
	imagefill($image, 0, 0, $FON);


	
	function P_Line($x,$y,$X,$Y,$cvet)
	{
	global $image, $cvet;
	settype($x, "integer");
	settype($y, "integer");
	settype($X, "integer");
	settype($Y, "integer");
	//print "1 ����� x,y - $x,$y <br> 2 ����� X,Y - $X,$Y";
	imageline($image, $X,$Y,$x,$y,$cvet);
	}

	function fractal($x,$y,$X,$Y,$iterac)
	{
	global $image,$cvet,$cvetmin,$cvetmax,$metod,$bC,$bS,$aC,$aS,$RrX,$Rr1X,$Rr,$Rr1,$n;
	$iterac++ ;
		if (/*(($X-$x)*($X-$x)+($Y-$y)*($Y-$y))<1*/ $n>$iterac)
		{	
			$x3= ($X-$x)*$aC-($Y-$y)*$aS+$X;
			$y3= ($X-$x)*$aS-($Y-$y)*$aC+$Y;
			$x4= $X*$RrX+$x3*$Rr;
			$y4= $Y*$RrX+$y3*$Rr;
			$x5= $x4*$Rr1X+$x3*$Rr;
			$y5= $y4*$Rr1X+$y3*$Rr1;
			$x6= ($x5-$x4)*$bC-($y5-$y4)*$bS+$x4;
			$y6= ($x5-$x4)*$bS+($y5-$y4)*$bC+$y4;
			$x7= ($x5-$x4)*$bC+($y5-$y4)*$bS+$x4;
			$y7=-($x5-$x4)*$bS+($y5-$y4)*$bC+$y4;
			$cvet = $cvet-rand($cvetmin,$cvetmax);
			//print $x." <br> ".$y." <br> ".$X." <br> ".$Y." <br> ".$x3." <br> ".$y3." <br> ".$x4." <br> ".$y4." <br> ".$x5." <br> ".$y5." <br> ".$x6." <br> ".$y6." <br> ".$x7." <br> ".$y7." <br> ".
		switch ($metod)
			{
				case "line":
							P_Line($x,$y,$x4,$y4,$cvet);
							break;
			}
				fractal($x4,$y4,$x3,$y3,$iterac);//..����������� ������
				fractal($x4,$y4,$x7,$y7,$iterac++);//..�����
				fractal($x4,$y4,$x6,$y6,$iterac++);//..���� 

		}
		else
		{
		;
		}
	}
		fractal($x,$y,$X,$Y,$iterac);
	header('Content-type: image/png');
	imagepng($image);
	imagedestroy($image);

?>
