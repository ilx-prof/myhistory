<?php
function Check_post($Nic,$parol,$print)
	{
		if (empty($parol) or empty($Nic))
		{
			if (True==$print)
			{
				print "<h3>������!</h3><br>";
			}
			if (empty($Nic) and True==$print)
			{
				Print "<font color=\"#ff0000\">�� �������� ����� ���� ��������� ���</font><br>";
			}
			if (empty($parol) and True==$print)
			{
				print "<font color=\"#ff0000\">�� �������� ����� ���� ��������� ������</font><br>";
			}
			return false;
		}
		else
		{
			if (True==$print)
			{
				print "��� ���� ���������<br>";
			}
			return true;
		}
	}
?>