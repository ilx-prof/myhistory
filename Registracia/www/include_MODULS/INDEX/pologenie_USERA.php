<?php
Function pologenie_USERA ($VHOD,$Nic,$FNic,$parol)
		{
			if (false==VHOD($VHOD,False))
			{
				print "������� ������� ������� - ANONIM<br>";
			}
		elseif ("denger"===VHOD($VHOD,false))
			{
				$ran_color=dechex(mt_rand (0,16777215));
				print "<font color=\"#$ran_color\">������ ���� ��� </font><br>";
			}
			elseif (true==VHOD($VHOD,False))
			{
				if(true==check_user($FNic,$Nic,false))
				{
					if(true==check_password ($parol,$FNic,FALSE))
					{
						$ran_color=dechex(mt_rand (0,16777215));
						print "<font point-size=\"10\" >���� ��� �������� ���</font>-<font color=\"#$ran_color\" point-size=\"10\"> $Nic </font><br>";
					}
					else {print "<font point-size=\"13\">$Nic ���� ����� ��������</font>";}
				}
				else
				{
					print "��� �� ��������������<br>";
				}
			}

		}
?>