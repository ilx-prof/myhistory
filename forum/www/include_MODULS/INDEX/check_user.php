<?php
function check_user($FNic,$Nic,$print)
		{
			if (true==file_exists($FNic))
			{
				if(True==$print)
				{
					print "��������� $Nic<br>";
				}
				return true;
			}
			else
			{
				if(True==$print)
				{
					print "��������� $Nic ������ �� ���� ��� � ������ ������������.<br>���� ��������� ������������������ >>><a href=\"reg.php\">�����������</a><<< <br>";
				}
				return false;
			}
		}
?>