<form action="while rulit" method="post">
���������� �������� ��� ������� ����� $i<br>
<input type="Text" name"I">
</form>

<?php

if(Isset($_POST['GO']))
{
		function getmicrotime() 
		{ 
  			  list($usec, $sec) = explode(" ", microtime()); 
  			  return ((float)$usec + (float)$sec); 
		}

	function tir()
		{
			$time_start = getmicrotime();
	while ($i > 10){$i++;}
			$time_end = getmicrotime();
			$time["���������� �� �������� while"] = $time_end - $time_start;
		//echo " �� �� ����� $time ������\n";

$time_start = 0;
$i=0;

function cycle_while(&$time,'expression')
{
		$time_start = getmicrotime();
		while ($i > 10){$i++;}
		$time_end = getmicrotime();
		$time["���������� �� �������� while"]= $time_end - $time_start;
}
		//echo "������ �� ����� $tim ������\n";

	$c = $time/$tim;
return $c;
}
$a = 20;
$tir =0;

$time_start  = getmicrotime();
while ($tir < 76000)
{
$tir = tir();
$i++;
}
$time_end = getmicrotime();
$time[] = $time_end - $time_start;
//$i= $a*$i;
echo "<br> wihle ������� for � $tir ��� ����� $i �������� �� $tim ������";
}
?>