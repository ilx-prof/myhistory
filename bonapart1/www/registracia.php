<?
include_once ("functions.php");
ob_start ();
print chek_qwest ();//проверка правильности запроса
$data = ob_get_clean ( );
$patt_array=array("Ќовые поступлени€",pattern_all(),navigation_meny(),$data);
include_once ("all.php");
?>