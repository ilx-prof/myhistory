<?php
for ($i=0;$i<15;$i++)
{
	if ($i<8)
	{
		$Uzer1_parametrs[]=$i;
		$Uzer2_parametrs[]=-$i;
		$Uzer1_rpg[]=$i;
		$Uzer2_rpg[]=-$i;
	}
	if ($i<13)
	{
		$ACTION[]=5-$i;
	}
	
}

include ("include_functions.php");
if (isset($_POST["faer"]))
{
	print "������� - ".$_POST["Tactic"]."<br>";
	print "������ �� ����� ������ - ".$_POST["droket"]."<br>";
	print "������ �� ������ ������- ".$_POST["dener"]."<br>";
	print "����� �������� - ".$_POST["arocet"]."<br>";
	print "����� ������� - ".$_POST["aener"]."<br>";
//print_r ($_POST);
include ("sablon.php");
}
else
{
include ("sablon.php");
}
?>
