<?php
if (isset ($_POST['Reg']))
{
		$Nic = $_POST['Reg']['Nic'];
		$parol = $_POST['Reg']['Login'];
		$VHOD=$_POST['Reg']['delay'];
		$FNic = $dir.$Nic.".ini";
		$go=true;
}
else
{
$go=false;
}
?>