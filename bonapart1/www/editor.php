<?
$user_id=array ();//массив с параметрами пользовател€/id/login/email/password и пр
//√лавна€ страница барахолки
ob_start ();
select_action ();
$data = ob_get_clean ( );
$patt_array=array("Ќовые поступлени€",pattern_all(),navigation_meny(),$data);
include_once ("all.php");
?>
