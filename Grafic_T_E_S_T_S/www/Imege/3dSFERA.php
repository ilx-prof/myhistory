<?php
$vih = 1000;
$sir = 1000;
$r = 0.1*$sir ;//���������� �����
$R =30  ;//���������� 
$X =$vih*0.5;
$Y = $sir*0.5;
$x =$vih*0.49;
$y = $sir*0.49;
$a=40;
  header('Content-type: image/png'); // ������������� ��� ��������� - "����������� � ������� PNG".
  $image = imagecreatetruecolor($vih,$sir) // ������� �����������...
	 or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
	  imagedestroy($image);                // ����������� ������, ���������� ��� �����������
   $image = imagecreatetruecolor($vih,$sir) // ������� �����������... 
    or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������ 

//..*********��������� ��������*************,,
  // "������" ��� �������� ������ 0x000000...
  imagefill($image, 0, 0, 0xffffff);
  // ...������������ �����...
 function RotateXYZ(&$X,&$Y,&$Z,$x,$y,$z,$L,$B)//..������� ��������� ������������ ������
 {
 	$X=$x*cos($L)-$y*sin($L);
	$Y=$x*sin($L)*cos($B)+$y*cos($L)*cos($B)-$z*sin($B);
	$Z=$x*sin($L)*sin($B)+$y*cos($L)*sin($B)+$z*cos($B);
 }
  
function P_line($X,$Y,$x,$y,$R,$a)
{
	Global	$image,$sir;
	$dx=abs($x-$X);
	$dy=abs($y-$Y);
	$R=0.5^($dx*$dx+$dy*$dy);
	$Z=$sir*0.0001;
	$dl=10;
	$bd=10;

	for($L=0;$L<=360;$L+=$dl)
	{
		$start=false;
		$ai = deg2rad($L);
		for($B=-90;$B<=90;$B+=$bd)
		{
			$aj = deg2rad($B);
			$x = $R*cos($B)*sin($L);
			$y = $R*cos($B)*cos($L);
			$z = $R*sin($B);
			
			RotateXYZ(&$X,&$Y,&$Z,$x,$y,$z,$L,$B);
			if($start)
			{
				if($Z<0)
				{
					$start = false ;
					imageline($image, $XX,$YY,$X+$dx/2,$Y+$dy/2,0x000000);
				}
			}
			else
			{
				IF($Z>=0)
				{
					$start=true;
					$XX=$X+$dx/2;$YY=$Y+$dy/2;
				}
			}
		}
	}
}
P_line($X,$Y,$x,$y,$R,$a);
//P_line($x,$y,$X,$Y,$R,$a);
 // ������������� ��� ��������� - "����������� � ������� PNG"...
  header('Content-type: image/png'); 
  // ...�, �������, ������� ��������������� �������� � ������� PNG:
  imagepng($image);
  imagedestroy($image);                // ����������� ������, ���������� ��� �����������


?>
