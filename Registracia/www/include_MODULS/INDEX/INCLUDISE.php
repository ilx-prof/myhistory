<?php
function print_VAR()
	{
		$a = array_slice (get_defined_vars(),13);
		print_r (array_keys($a));
		$a = get_defined_functions();
		print_r ($a['user']);
	}
	//Функция выводит список зарегеных пльзователей
	Include ($include_moduls."creit_alluzer.php");
	//функция для выполнения скрипта при предаче параметра
	Include ($include_moduls."VHOD.php");
	//проверяем на наличие пересылаемых пременных - пустые строки находит короче в форме
	Include ($include_moduls."Check_post.php");
	//Проверка наличия пользователя - проверяет наличие файла в директории
	Include ($include_moduls."Check_user.php");
	//Функция возврашает при удаче список из пароля почты пола и возраста
	Include ($include_moduls."get_var_expload_USER.php");
	//Проверяет на совпадение пароля
	Include ($include_moduls."check_password.php");
	//Выводит статус пользователя выполнил он вход или нет
	Include ($include_moduls."pologenie_USERA.php");
	//Последняя проверка
	Include ($include_moduls."LAST_CHEK_PARAMETR.php");
	LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,false);
############################################################
	// Подключение логотипа верхней строчки таблицы
	INCLUDE ($include_moduls_template."logo.php");
	// Подключение кнополк после логотипа
	INCLUDE ($include_moduls_template."LINC_FOR_VHOD.php");
	//Подключение шапки таблицы основного экрана в месте с полоской бока
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INF.php");
############################################################
	creit_alluzer();
	@pologenie_USERA ($VHOD,$Nic,$FNic,$parol);
	//если выполнен вход то неотображать форму входа
	if (check_password ($parol,$FNic,false)==false)
	{###############################
	INCLUDE ($include_moduls_template."FORM_USER_VHOD.php");
	}
############################################################
	//Открытие таблицы КОНСОЛИ
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INFCREDIT.php");

	///////////////СОДЕРЖАНИЕ ТАБЛИЦЫ КОНСОЛИ\\\\\\\\\\\\\\\\\/**/
  /**/	LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,true);/**/
 /**//////////////////////////////////////////////////////////

#######################################################################
	INCLUDE ($include_moduls_template."TABLE_UP_CLOSE_FOR_INFCREDIT.php");
	INCLUDE ($include_moduls_template.      "TABLE_UP_CLOSE_FOR_INF.php");
?>