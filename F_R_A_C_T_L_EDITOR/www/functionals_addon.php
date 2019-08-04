<?
// ����� $X,$Y ��������� ������������ $y,$x �� ���� $a
function turn($xy,$XY,$cos,$sin)
{
	return array (($XY[0]-$xy[0])*$cos-($XY[1]-$xy[1])*$sin+$xy[0],
				  ($XY[0]-$xy[0])*$sin+($XY[1]-$xy[1])*$cos+$xy[1]);
}
// ����� $X,$Y ��������� ������������ $y,$x �� ���� $a � ���������� ������������� $XY
function turn_long($xy,$XY,$cos,$sin,$a)
{
	$turn = array (($XY[0]-$xy[0])*$cos-($XY[1]-$xy[1])*$sin+$xy[0],
				  ($XY[0]-$xy[0])*$sin+($XY[1]-$xy[1])*$cos+$xy[1]);
	return long($XY,$turn,$a);
}

function long($XY,$xy,$a)
{
	return array (-($XY[0]-$xy[0])*$a+$xy[0],
				  -($XY[1]-$xy[1])*$a+$xy[1]);
}

function turnX($x,$y,$X,$Y,$cos,$sin)
{
	return ($X-$x)*$cos-($Y-$y)*$sin+$x;
}

function turnY($x,$y,$X,$Y,$cos,$sin)
{
	return ($X-$x)*$sin+($Y-$y)*$cos+$y;
}

//..����� �� ���� ���������� ����� -$y,$x - $X,$Y- �������� ������������ $a -���������� ��������� ������� $x,$y- ����� ����� � ��������������� �������


function shift($XY,$xy,$a)
{
	return array ( $xy[0]*(1-$a)+$XY[0]*$a,
				   $xy[1]*(1-$a)+$XY[1]*$a);
}
?>