<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;
// ����� �������� ���������� ������� ����� ��������� ����� ��������� �������� �� ������� �� ������������
$dx=($x-$X);
$dy=($y-$Y);
		imagefilledarc  ($image, $x+$dx/2,$y+$dy/2,
		 $w=sqrt($dx*$dx+$dy*$dy),$w/3,
		 180, 0, $cvet,0);
}
?>