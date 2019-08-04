<?

$error = array('Вы не успели вовремя активировать Вашу учетную запись.<BR>Для 						получения доступа в закрытую зону, придется зарегистрироваться 						снова.',
				'Ваша учетная запись активирована.<BR> Доступ в закрытую зону для Вас открыт.');

if(!isset($_GET["code"]))
	HEADER("Location: http://".$_SERVER["SERVER_NAME"]."/protect/");

?>
<HTML>
<HEAD>
<TITLE>Подтверждение регистрации</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<LINK href="../phpru.css" type=text/css rel=STYLESHEET>
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BGCOLOR=#2A3747>
<CENTER><BR><BR>
<?
require('../mail.php');
$check = file('../users.php');
for($a = 0; $a < count($check); $a++)
{
	list($user,$pass,$email,$code,$time) = explode("^^",$check[$a]);
	$new[$a] = $check[$a];

	if(trim($_GET["code"]) == trim($code) && trim($_GET["email"] == trim($email)))
	{
		if($time < time())
		{
			unset($new[$a]);
			echo $error[0];
			flush();
		}
		else
		{
			$new[$a] = $user.'^^'.$pass.'^^'.$email.'^^yes^^'.time()."\n";
			echo $error[1];
			flush();
		}
	}
	else
	{
		if($time < time() && $code != 'yes')
		{
			unset($new[$a]);
			$subject = $_SERVER["SERVER_NAME"].' - Ваш доступ закрыт.';
			$content = trim(str_replace("<BR>","\n", $error[0]));
			$mail = new Email($email,$subject,$content);
		}
	}
}
$user_info = str_replace("\r","",join("",$new));
PHPruSave($user_info,'../users.php','w+');
sleep(3);
?>
<SCRIPT LANGUAGE="JavaScript">window.location="http://<?=$_SERVER["SERVER_NAME"]?>/protect/"</SCRIPT>
</BODY>
</HTML>