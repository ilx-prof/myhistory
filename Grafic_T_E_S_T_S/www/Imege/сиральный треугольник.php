<?php
set_time_limit(0);
$vih = 1000;
$sir = 1000;
$R =0.9;//���������� 
$X =$vih*0.4;
$Y = $sir*0.4;
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
function cun($X,$Y,$R,$n,$YGOL)
{	$XR=$X;
	$YR=$Y;
	global $image;
	$cvet=rand(0x99545588,0x99999999);//�� �����  4294967295
	$ygol=0;
  	$i=0;
	while($i<$n)
		{		
	$cvet=$cvet-60;
	if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			IF($i<$n/3)
			{
				$y =cos($ygol)*$R+$Y;
				$x =sin($ygol)*$R+$X;
				imageline($image, ABS($x),ABS($y),ABS($X),ABS($Y),$cvet);
				$ygol+=$YGOL/($i+1);
				$i++;
			}
			ELSE
			{
				if($i==$n/3)
				{
					$Y=$Y;
					$X=$X;
				}
				$x-=cos($ygol)*$R+$Y;
				$y=sin($ygol)*$R+$X;
				imageline($image, ABS($x),ABS($y),ABS($X),ABS($Y),$cvet);
				$ygol-=$YGOL/sin($i)*$i;
				$i++;
			}
	  }
	}

cun($X,$Y,$R,123213,60);
$a=0;
while ($a<-1)
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
