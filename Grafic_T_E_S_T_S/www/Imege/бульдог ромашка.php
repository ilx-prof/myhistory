<?php
set_time_limit(0);
$vih = 1000;
$sir = 1000;
$R =100 ;//���������� 
/*$X =$vih*0.6;
$Y = $sir*0.3;*/
$X =300;
$Y = 560;
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
	while($i<3300)//��� $i-���������� ������
	{		if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
		
			
			$y =cos(rad2deg($ygol))*pi()*$R+$Y;
			$x =sin(rad2deg($ygol))*pi()*$R+$X;
			
			if($i==0)
			{
			$ygol-=$ygol/0.000000006;
			}
			else
			{
				imageline($image, $x,$y,$X,$Y,$cvet);
				$ygol-=$ygol/202002000;
			}
			$i++;
			$R+=$i/($R+$i*20);
			$cvet=$cvet-50;
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
