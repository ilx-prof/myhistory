<?
$user_id=array ();//������ � ����������� ������������/id/login/email/password � ��
//������� �������� ���������
ob_start ();
select_action ();
$data = ob_get_clean ( );
$patt_array=array("����� �����������",pattern_all(),navigation_meny(),$data);
include_once ("all.php");
?>
