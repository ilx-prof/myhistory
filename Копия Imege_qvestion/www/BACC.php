<?php

copy (__FILE__,"BACC.php");
	set_time_limit(0);
	$vih = 160 ;
	$sir = 160 ;
	$delta=0.222;
	$max_X=$dX= 1.2;//-0.35
	$max_Y=$dY= 1;//-0.5
	$min_x=$dx= -2.2;//-1
	$min_y=$dy= -1.2 ;//-0.5
	$n   = 10;
	$VINN=0.97;
	$FON = 0xffffff;
	$aa = 0;
	$bb = 85;//�������� 80 150
	$Rr     = 0.5 ;
	$Rr1    = 0.3 ;
	$cvet   = 0xff0000;
	$cvetmin = 0;
	$cvetmax = 0;
	$metod	 = "line";
	$zoom	= 1;
	$limit=4;
	$cof=2;
	$TEXT="��� ���";

	header('Content-type: image/jpg'); // ������������� ��� ��������� - "����������� � ������� PNG".
	$image = ImageCreateTrueColor($vih,$sir) // ������� �����������...
	or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
	imagedestroy($image);                // ����������� ������, ���������� ��� �����������
	$image = imagecreatetruecolor($vih,$sir) // ������� �����������...
	or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
imagesetthickness($image,10); 
	//..*********��������� ��������*************,,
	  // "������" ��� �������� ������ $FON...
	imagefill($image, 0, 0, $FON);
$DX= ($max_X-$min_x)/$sir;
$DY= ($max_Y-$min_y)/$vih;
function P_Line($X,$Y,$cvet)
{
global $image;
	imagesetpixel($image, $X,$Y,$cvet);
}
function NamberIterac($x,$y)
{
	global $limit,$cof,$n;
	$i=0;
	$xx=$x;
	$yy=$y;
	while ($xx*$xx+$yy*$yy<=$limit)
	{
		$xk=$xx*$xx-$yy*$yy+$x;
		$yk=$cof*$yy*$xx+$y;
		$xx=$xk;
		$yy=$yk;
		$i++;
		if($i>=$n){break;}
	}
	return $i;
}
	function fractal($X,$Y)
	{
		global $image,$TEXT,$vih,$sir,$n,$DX,$DY,$min_y,$min_x,$max_Y,$max_X;//$cvet,$vih,$sir,$rand,$VINN,$image,$cvetmin,$cvetmax,$metod,$DX,$DY,$min_y,$min_x,$max_Y,$max_X;
		
		$j=$i=0;
		$y=$min_y;
		while($j<$vih)
		{
			$j++;
			$x=$min_x;
				$i=0;
			while($i<$sir)
			{
				$i++;
			//	$cvet = 0xFFFFFF; 
				$cvet=9999999*($n-NamberIterac($x,$y));
				P_Line($X+$i,$Y+$j,$cvet);
				$x +=$DX;
			}
			$y+=$DY;
		}
//	imagepstext ($image,$TEXT,"Times New Roman","20","0xffffff", "0xffffff", 0, 0);
	//imagestring ($image,"Times New Roman",0, 0,$TEXT,0xFFFFFF);
	imagechar ($image,"5",10,10,"World",0x006540);
	imagecharup ($image,"5",40,40,"World",0x006540);
	
	}
	fractal(0,0);
  header('Content-type: image/jpg'); 
  // ...�, �������, ������� ��������������� �������� � ������� PNG:><body bgcolor="#ffffff"
  imagepng($image);
?>
