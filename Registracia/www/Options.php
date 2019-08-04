<<?php
#############################
##		### ###	  ##  ##		##
## 	 #	  #	    ##		##
## 	 #	  #  #	 ##		##
## 	### ###### ##  ##		##
#############################
		$dir = dirname (__FILE__)."\\Uzerconfig\\";
		$Nic = @$_POST['Reg']['Nic'];
		$parol =@ $_POST['Reg']['Login'];
		$FNic = $dir.$Nic.".ini";
		$VHOD=@$_POST['Reg']['delay'];
		$include_moduls = dirname (__FILE__)."\\include_MODULS\\INDEX\\";
		$include_moduls_template = $include_moduls."INCLUDE_INSIDE\\";
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
############################################################
	// Подключение логотипа верхней строчки таблицы
	INCLUDE ($include_moduls_template."logo.php");
	// Подключение кнополк после логотипа
	INCLUDE ($include_moduls_template."LINC_FOR_VHOD.php");
	//Подключение шапки таблицы основного экрана в месте с полоской бока
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INF.php");
############################################################

	creit_alluzer();
	//если выполнен вход то неотображать форму входа
############################################################
	//Открытие таблицы КОНСОЛИ
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INFCREDIT.php");
	//СОДЕРЖАНИЕ ТАБЛИЦЫ КОНСОЛИ
	if (isset ($cookie)) {
    while (list ($name, $value) = each ($cookie)) {
        echo "$name == $value<br>\n";
    }
}
#######################################################################
	INCLUDE ($include_moduls_template."TABLE_UP_CLOSE_FOR_INFCREDIT.php");
	INCLUDE ($include_moduls_template."TABLE_UP_CLOSE_FOR_INF.php");
?>
