<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//���������� �����
$R =40  ;//���������� 
$X =$vih*0.5;
$Y = $sir*0.9;
  header('Content-type: image/png'); // ������������� ��� ��������� - "����������� � ������� PNG".
  $image = imagecreatetruecolor($vih,$sir) // ������� �����������...
	 or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
	  imagedestroy($image);                // ����������� ������, ���������� ��� �����������
   $image = imagecreatetruecolor($vih,$sir) // ������� �����������... 
    or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������ 

//..*********��������� ��������*************,,
  // "������" ��� �������� ������ 0x000000...
  imagefill($image, 0, 0, 0x0);
  // ...������������ �����...
  
  function ygol($X,$Y,$R,$i)
  {	
  	$cvet=0x0005445;//..������ 
  		$x=$X;
		$y=$Y;
		$Xr=-sin(rad2deg(120))*($R+$i)+$X;
		$Yr=-cos(rad2deg(0))*($R+$i)+$Y;

	imageline($image, $x,$y,$Xr,$Yr,$cvet);
		$Xl=-sin(rad2deg(360))*($R+$i)+$X;
		$Yl=-cos(rad2deg(0))*($R+$i)+$Y;
	imageline($image, $x,$y,$Xl,$Yl,$cvet);//..�� ���� �������� 
  }
  
function cun($X,$Y,$R,$n,$YGOL)
{
	global $image;
;//�� �����  4294967295
	$ygol = 0;
  	$i=0;
	
	$y =cos($ygol)*$R+$Y;
	$x =sin($ygol)*$R+$X;
	imageline($image, $x,$y,$X,$Y,0xFFFFFFF);

ygol($X,$Y,$R,$i);//����� �� ��������
/*	while($i<$n-1)
	{		if($i<>0)
			{
				$Y=$y;
				$X=$x;
			}
			
			$y =cos($ygol)*$R+$Y;
			$x =sin($ygol)*$R+$X;
			
			imageline($image, $x,$y,$X,$Y,$cvet);
			$ygol+=$YGOL;
			$i++;
	  }*/
}

cun($X,$Y,$R,60,90);
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
