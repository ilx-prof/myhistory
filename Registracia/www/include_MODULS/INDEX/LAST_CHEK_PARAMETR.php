<?php
print "Vhod=$VHOD, ник=$Nic, ПАРОл=$parol, ФАил ник= $FNic,";

	FUNCTION LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,$print)
	{
		if(True==$print)
		{
			print "<font face=\"Comic Sans MS\"><h2>Консоль событий</h2><font><br>";
		}
		$Vhodit=VHOD($VHOD,true);
		if ($Vhodit!=="denger" and $Vhodit!==false)
		{
			if (Check_post($Nic,$parol, $print))
			{
				if (check_user($FNic,$Nic,$print))
				{
					 if(check_password ($parol,$FNic,$print))
			  		 {

					 	if(True==$print)
						{

							print "<font color=\"#0000ff\" point-size=\"10\">$Nic ! </font><font color=\"#008000\">Осушествлен вход на сайт доступны онвые <a href=\"Options.php\">опции!!!</a></font> ";

						}
													setcookie ("cookie[three]", "cookiethree");
setcookie ("cookie[two]", "cookietwo");
setcookie ("cookie[one]", "cookieone");

						return true;
				    }else {return false;}
				}else {return false;}
			} else {return false;}
			//print_r (get_var_expload_USER($FNic));
			//print_VAR();
		}else{return false;}
	}
?>