<?php
		function check_password ($parol,$FNic,$print)
		{
			$options=get_var_expload_USER($FNic);
			If (False!==$options)
			{
				if ($options['parol']==$parol)
				{
					if (true==$print)
					{
						print "������ ������� �����������<br>";
					}
					return true;
				}
				else
				{
					if (true==$print)
					{
						print "������ ������?"; return false;
					}		
				}
			}
		}
?>