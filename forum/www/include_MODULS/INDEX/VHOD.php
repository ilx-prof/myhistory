<?php
	function VHOD($VHOD,$print)
	{
		if("delay"==$VHOD)
		{
			if (True==$print)
			{
				print "ТАК МЫ ХОТИМ ОСУШЕСТВИТЬ ВХОД<br>";
			}
			return true;
		}
		elseIF(empty($VHOD))
		{
			if (True==$print)
			{
				print "Здравствуйте вы толькочто зашли на стартовую страницу этого сайта<br> Этот режим не для чего не придназначен  поэтому вы ничего не сможете здесь сделать <br> Для расширения возможностей сайта нужно войти в него под одним из окаунтов <br>";
			}
			RETURN FALSE;
		}
		ELSE
		{
			if (True==$print)
			{
				print "Вход осушествлен не с неизвестной локации |delay|<>|$VHOD| <br>";
			}
			return "denger";
		}
	}
?>