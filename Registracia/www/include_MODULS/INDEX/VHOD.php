<?php
	function VHOD($VHOD,$print)
	{
		if("delay"==$VHOD)
		{
			if (True==$print)
			{
				print "��� �� ����� ����������� ����<br>";
			}
			return true;
		}
		elseIF(empty($VHOD))
		{
			if (True==$print)
			{
				print "������������ �� ��������� ����� �� ��������� �������� ����� �����<br> ���� ����� �� ��� ���� �� ������������  ������� �� ������ �� ������� ����� ������� <br> ��� ���������� ������������ ����� ����� ����� � ���� ��� ����� �� �������� <br>";
			}
			RETURN FALSE;
		}
		ELSE
		{
			if (True==$print)
			{
				print "���� ����������� �� � ����������� ������� |delay|<>|$VHOD| <br>";
			}
			return "denger";
		}
	}
?>