<?
include_once ("functions.php");
ob_start ();
print chek_qwest ();//�������� ������������ �������
$data = ob_get_clean ( );
$patt_array=array("����� �����������",pattern_all(),navigation_meny(),$data,$link);
include_once ("all.php");
?>