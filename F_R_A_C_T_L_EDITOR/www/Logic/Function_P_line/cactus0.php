<?php 
function P_Line($x,$y,$X,$Y,$n,$cvet = 0xFFFFFF)
{
global $image;

	// ����� �������� ���������� ������� ����� ��������� ����� ��������� �������� �� ������� �� ������������	
	$n1=turn($XY=array($X,$Y),$xy=array($x,$y),0,1);
	$n2=turn($XY,$xy,0,-1);
	//imageline($image, $x,$y,$n1[0],$n1[1],$cvet);
	imagepolygon($image, array ($n1[0],$n1[1],$x,$y,$n2[0],$n2[1]),3,$cvet);
	//imageline($image,$x,$y,$X,$Y,12345645);
}
?>