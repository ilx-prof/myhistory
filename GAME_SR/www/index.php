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
	print "Тактика - ".$_POST["Tactic"]."<br>";
	print "Зашита от ракет класса - ".$_POST["droket"]."<br>";
	print "Зашита от оружия класса- ".$_POST["dener"]."<br>";
	print "Атака ракетами - ".$_POST["arocet"]."<br>";
	print "Атака оружием - ".$_POST["aener"]."<br>";
//print_r ($_POST);
include ("sablon.php");
}
else
{
include ("sablon.php");
}
?>
