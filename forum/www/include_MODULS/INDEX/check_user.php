<?php
function check_user($FNic,$Nic,$print)
		{
			if (true==file_exists($FNic))
			{
				if(True==$print)
				{
					print "Здраствуй $Nic<br>";
				}
				return true;
			}
			else
			{
				if(True==$print)
				{
					print "Здраствуй $Nic извени но тебя нет в списке приглашенных.<br>Тебе придеться зарегистрироваться >>><a href=\"reg.php\">Регистрация</a><<< <br>";
				}
				return false;
			}
		}
?>