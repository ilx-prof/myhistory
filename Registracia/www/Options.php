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
	//������� ������� ������ ��������� ������������
	Include ($include_moduls."creit_alluzer.php");
	//������� ��� ���������� ������� ��� ������� ���������
	Include ($include_moduls."VHOD.php");
	//��������� �� ������� ������������ ��������� - ������ ������ ������� ������ � �����
	Include ($include_moduls."Check_post.php");
	//�������� ������� ������������ - ��������� ������� ����� � ����������
	Include ($include_moduls."Check_user.php");
	//������� ���������� ��� ����� ������ �� ������ ����� ���� � ��������
	Include ($include_moduls."get_var_expload_USER.php");
	//��������� �� ���������� ������
	Include ($include_moduls."check_password.php");
	//������� ������ ������������ �������� �� ���� ��� ���
	Include ($include_moduls."pologenie_USERA.php");
	//��������� ��������
	Include ($include_moduls."LAST_CHEK_PARAMETR.php");
############################################################
	// ����������� �������� ������� ������� �������
	INCLUDE ($include_moduls_template."logo.php");
	// ����������� ������� ����� ��������
	INCLUDE ($include_moduls_template."LINC_FOR_VHOD.php");
	//����������� ����� ������� ��������� ������ � ����� � �������� ����
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INF.php");
############################################################

	creit_alluzer();
	//���� �������� ���� �� ������������ ����� �����
############################################################
	//�������� ������� �������
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INFCREDIT.php");
	//���������� ������� �������
	if (isset ($cookie)) {
    while (list ($name, $value) = each ($cookie)) {
        echo "$name == $value<br>\n";
    }
}
#######################################################################
	INCLUDE ($include_moduls_template."TABLE_UP_CLOSE_FOR_INFCREDIT.php");
	INCLUDE ($include_moduls_template."TABLE_UP_CLOSE_FOR_INF.php");
?>
