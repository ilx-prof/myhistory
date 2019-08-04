<?php
function creit_alluzer()
	{
	If(@file("Infuser.ini"))
	{
		$s = file("Infuser.ini");
		if ( Count($s)!==0 )
		{
			print "Ќа этом сайте уже зарегистрировались<br>" ;
			for ($i = 0; $i < count($s) ; $i++)
			{
				//print " N".$i." count=".count($s);
				print "<a>".$s[$i] . "</a>";
				if((Count($s)-1) == $i or count($s)==1)
				{
					print ".<br>";
				}
				else
				{

					print ", ";
				}
			}
			return true;
		}
		else {print "Ќа этом сайте нет зарегистрироватнных пользователей<br>";return FALSE;}
		}else {print "Ќа этом сайте нет зарегистрироватнных пользователей<br>";return FALSE;}
	}
?>