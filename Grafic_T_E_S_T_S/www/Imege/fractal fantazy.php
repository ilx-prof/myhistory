<?php
$vih = 2300;
$sir = 2300;
$r = 0.1*$sir ;//���������� �����
$R =2  ;//���������� 
$X =0;
$Y =$sir;
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
function cun($X,$Y,$R/*,$n,$YGOL*/)
{
	global $image;
	$cvet=0xFFFFFFF;//rand(0x0,0x99999999);//�� �����  4294967295
	$ygol = 1;
  	$i=0;
	$n=rand(30,300000);
	while($i<$n)//��� $i-���������� ������
	{		if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			
			$y =cos(rad2deg($ygol))*pi()*$R+$Y;
			$x =sin(rad2deg($ygol))*pi()*$R+$X;
			imageline($image, $x,$y,$X,$Y,$cvet);
			if($i==0)
			{
			$ygol-=$ygol/0.0000000000036;
			}
			$ygol-=$ygol/2020222;
			$i++;
			$cvet=$cvet-rand(1,4500);
	  }
}

cun($X,$Y,$R/*,60,90*/);/*
$a=0;
while ($a<12)
{
$a++;
	cun($X+=$R,$Y+=$R,$R,100,$a);
		cun($X+=$R-80,$Y+=$R-80,$R,100,80-$a);
}*/
  // ������������� ��� ��������� - "����������� � ������� PNG"...
  header('Content-type: image/png'); 
  // ...�, �������, ������� ��������������� �������� � ������� PNG:
  imagepng($image);

  imagedestroy($image);                // ����������� ������, ���������� ��� �����������


?>
