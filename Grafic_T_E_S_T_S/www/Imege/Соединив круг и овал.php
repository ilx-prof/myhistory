<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//���������� �����
$R =30  ;//���������� 
$X =$vih*0.1;
$Y = $sir*0.1;
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
function cun($X,$Y,$R,$a)
{
	global $image;
	$cvet=rand(0x0,0x99999999);//�� �����  4294967295
	$ygol = 0;
  	$i=0;
	while($i<133)
	{		
			if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			
			$y =cos($ygol)*pi()*$R+$Y;
			$x =sin($ygol)*pi()*$R+$X;
			
			imageline($image, $x,$y,$X,$Y,$cvet);
			$ygol+=$a;
			$i++;
			$yi =cos(-$ygol)*pi()*$R+$Y;
			$xi =sin(-$ygol)*pi()*$R+$X;
			imageline($image, $xi,$yi,$X,$Y,$cvet-$cvet/2);
	  }
}
$a=1;
cun($X,$Y,$R,$a);
while ($a<12)
{
$a++;
	cun($X+=$R+$R+$R,$Y+=3*$R,$R,$a);
		cun($X+=$R-80,$Y+=$R-80,$R-=1,-$a);
}
  // ������������� ��� ��������� - "����������� � ������� PNG"...
  header('Content-type: image/png'); 
  // ...�, �������, ������� ��������������� �������� � ������� PNG:
  imagepng($image);

  imagedestroy($image);                // ����������� ������, ���������� ��� �����������


?>
