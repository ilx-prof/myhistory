<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//���������� �����
$R =30  ;//���������� 
$X =$vih*0.5;
$Y = $sir*0.1;
$x =$vih*0.8;
$y = $sir*0.4;
$a=40;
  header('Content-type: image/png'); // ������������� ��� ��������� - "����������� � ������� PNG".
  $image = imagecreatetruecolor($vih,$sir) // ������� �����������...
	 or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
	  imagedestroy($image);                // ����������� ������, ���������� ��� �����������
   $image = imagecreatetruecolor($vih,$sir) // ������� �����������... 
    or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������ 

//..*********��������� ��������*************,,
  // "������" ��� �������� ������ 0x000000...
  imagefill($image, 0, 0, 0x000000);
  // ...������������ �����...
function P_line($X,$Y,$x,$y,$R,$a)
{
	global $image;
	$tmpx = $x;
	$tmpy = $y;
	if ($x <= $X)
	{
		$x = $X;
		$X = $tmpx;
	}
	if ($y <= $Y)
	{
		$y = $Y;
		$Y = $tmpy;
	}
	$dx=abs($x-$X);
	$dy=abs($y-$Y);
	$p1[0]=$x;	$p1[1]=$y-$dy;//����� x
	$p1[2]=$X;	$p1[3]=$y+$dy/2;//����� 2
	$p1[4]=$X;	$p1[5]=$y+$dy*1.5;//����� 3
	$p1[6]=$x;	$p1[7]=$y;//����� x
	$p4[0]=$X-$dx;$p4[1]=$p1[5];//����� 4
	$p2[0]=$p4[0];	$p2[1]=$p1[3];//����� 5
	$p2[2]=$X;	$p2[3]=$y;//����� 6
	imagerectangle ($image,$X,$Y,$x,$y,rand(0x000000,0xffffff));//0
//	imagepolygon ($image,array($X,$Y,$p2[2],$p2[3],$p4[0],$p4[1],$p2[0],$p2[1]),4,rand(0x000000,0xffffff));//4
	imagepolygon ($image,array($p2[2],$p2[3],$p4[0],$p4[1],$p1[4],$p1[5],$x,$y),4,rand(0x000000,0xffffff));//5
//	imagepolygon ($image,$p1,4,$cvet);//1
	imagerectangle ($image,$p1[2],$p1[3],$p4[0],$p4[1],rand(0x000000,0xffffff));//2
	imagepolygon ($image,array($X,$Y,$p1[0],$p1[1],$p1[2],$p1[3],$p2[0],$p2[1]),4,rand(0x000000,0xffffff));//3
}
//P_line($X,$Y,$x,$y,$R,$a);
P_line(796.321388177,673.12640367,892.642776353,646.25280734,$R,$a);
//P_line($x,$y,$X,$Y,$R,$a);
 // ������������� ��� ��������� - "����������� � ������� PNG"...
  header('Content-type: image/png'); 
  // ...�, �������, ������� ��������������� �������� � ������� PNG:
  imagepng($image);
  imagedestroy($image);                // ����������� ������, ���������� ��� �����������


?>
