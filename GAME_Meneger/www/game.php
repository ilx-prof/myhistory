<?php
include ("include_functions.php");

$Nic_data = isset ($_POST['Nic']) ? nik_data ($_POST['Nic']) : nik_data ("Nuser");
/*$Nal = isset ($_POST['Nal']) ? $_POST['Nic'] : nal ($Nic_data);
$coup= isset ($_POST['coup']) ? $_POST['coup'] : coup ($Nic_data);
$gains= isset ($_POST['gains']) ? $_POST['gains'] : gains ($Nic_data);
$charges=isset ($_POST['charges']) ? $_POST['charges'] : charges ($Nic_data);
$property=isset ($_POST['property']) ? $_POST['property'] : property ($Nic_data);
$luck=isset ($_POST['luck']) ? $_POST['luck'] : luck ($Nic_data);*/

$Nic_data_cenge = Nic_Creat_Cenge(rand(-1000,1000));//..�������� �� �������� ������ ��� �� ������� ������ � �������� ���������� ��� �� ��������������

$General_status = translete_allay("General_status.php",General_status($Nic_data,$Nic_data_cenge));//������� � ����� ���������� �������� ���,����������,������,�������,����� ������,����,���� �� �������,�����
$charges_status = translete_allay("charges_status.php",charges_status($Nic_data,$Nic_data_cenge));//������� � ����� ������,������,�������� �� �����,�������� �� �������,����� �� ������������,��������� �����
$income_status = translete_allay("income_status.php",income_status($Nic_data,$Nic_data_cenge));//������� � ����� �������,�� ��������������,�� ���������� �����,�� ���������� ���������,������� ��������,������,��������� ������
$common_status = translete_allay("common_status.php",common_status($Nic_data,$Nic_data_cenge));//������� � ����� ���������,������������,����� ����,����,������
$luck_status = translete_allay("luck_status.php",luck_status($Nic_data,$Nic_data_cenge));//������� � ����� �������/�����/ ,�� �������, �� �����,�� �������

//��������� ��������� ��������� � ������������ ���������
//���������� ���� � ��������
//���������� ������� ���������

function nacdj()
{
	$work_nacledstvo = new_work_cenge("cenge");
}
?>