<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//���������� �����
$R =0.06*$sir  ;//���������� 
$X =$vih*0.2;
$Y = $sir*0.2;
  header('Content-type: image/png'); // ������������� ��� ��������� - "����������� � ������� PNG".
  $image = imagecreatetruecolor($vih,$sir) // ������� �����������...
	 or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
	  imagedestroy($image);                // ����������� ������, ���������� ��� �����������
   $image = imagecreatetruecolor($vih,$sir) // ������� �����������... 
    or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������ 

//..*********��������� ��������*************,,
  // "������" ��� �������� ������ 0x000000...
  imagefill($image, 0, 0, 0xffffffff);
  // ...������������ �����...
function cun($X,$Y,$R,$n,$YGOL)
{
	global $image;
	$cvet=rand(0x0,0x99999999);//�� �����  4294967295
	$ygol = 0;
  	$i=0;
	while($i<$n-1)
	{		if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			
			$y =cos(rad2deg($ygol))*pi()*$R+$Y;
			$x =sin(rad2deg($ygol))*pi()*$R+$X;
			
			imageline($image, $x,$y,$X,$Y,$cvet);
			$ygol+=$YGOL;
			$i++;$i++;
	  }
}

cun($X,$Y,$R,60,90);
$a=0;
while ($a<12)
{
$a++;
	cun($X+=$R,$Y+=$R,$R,100,$a);
		cun($X+=$R-80,$Y+=$R-80,$R,100,80-$a);
}
  // ������������� ��� ��������� - "����������� � ������� PNG"...
  header('Content-type: image/png'); 
  // ...�, �������, ������� ��������������� �������� � ������� PNG:
  imagepng($image);

  imagedestroy($image);                // ����������� ������, ���������� ��� �����������


?>
