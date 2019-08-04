<?php
DEFINE("START_TIME", MICROTIME(TRUE));
		copy("index.php", "indexINDEX.bac");

	ob_start ( );
		$include_moduls = dirname (__FILE__)."\\include_MODULS\\INDEX\\";
		$dir = dirname (__FILE__)."\\Uzerconfig\\";
		$Nic = @$_POST['Reg']['Nic'];
		$parol =@ $_POST['Reg']['Login'];
		$FNic = $dir.$Nic.".ini";
		$VHOD=@$_POST['Reg']['delay'];
		$include_moduls = dirname (__FILE__)."\\include_MODULS\\INDEX\\";
		$include_moduls_template = $include_moduls."INCLUDE_INSIDE\\";
#############################
##		### ###	  ##  ##		##
## 	 #	  #	    ##		##
## 	 #	  #  #	 ##		##
## 	### ###### ##  ##		##
#############################
		Include ($include_moduls."INCLUDISE.php");

	$data = ob_get_clean ( );
$a=fopen("dump.php", "w+");
fwrite ($a,$data);
	fclose ($a);
	include ("dump.php");
PRINT (MICROTIME(TRUE)-START_TIME);
?>
</body>
