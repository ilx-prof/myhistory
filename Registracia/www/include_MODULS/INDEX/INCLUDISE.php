<?php
function print_VAR()
	{
		$a = array_slice (get_defined_vars(),13);
		print_r (array_keys($a));
		$a = get_defined_functions();
		print_r ($a['user']);
	}
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
	LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,false);
############################################################
	// ����������� �������� ������� ������� �������
	INCLUDE ($include_moduls_template."logo.php");
	// ����������� ������� ����� ��������
	INCLUDE ($include_moduls_template."LINC_FOR_VHOD.php");
	//����������� ����� ������� ��������� ������ � ����� � �������� ����
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INF.php");
############################################################
	creit_alluzer();
	@pologenie_USERA ($VHOD,$Nic,$FNic,$parol);
	//���� �������� ���� �� ������������ ����� �����
	if (check_password ($parol,$FNic,false)==false)
	{###############################
	INCLUDE ($include_moduls_template."FORM_USER_VHOD.php");
	}
############################################################
	//�������� ������� �������
	INCLUDE ($include_moduls_template."TABLE_UP_OPEN_FOR_INFCREDIT.php");

	///////////////���������� ������� �������\\\\\\\\\\\\\\\\\/**/
  /**/	LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,true);/**/
 /**//////////////////////////////////////////////////////////

#######################################################################
	INCLUDE ($include_moduls_template."TABLE_UP_CLOSE_FOR_INFCREDIT.php");
	INCLUDE ($include_moduls_template.      "TABLE_UP_CLOSE_FOR_INF.php");
?>