<HTML>
<HEAD>
<TITLE>Регистрация нового пользователя</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<LINK href="../phpru.css" type=text/css rel=STYLESHEET>
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BGCOLOR=#2A3747>
<CENTER><BR><BR>
Для получения доступа в закрытую зону, 
Вам необходимо зарегистрироваться.<BR>
На Ваш e-mail будет выслан код активации.<BR>
Ваша учетная запись будет активирована, только после подтверждения Вами кода.<BR><BR> 
<?

require ('../mail.php');

if(isset($_POST["join"]))
	JoinUser();
else
	ShowForm();

function ShowForm()
{
?>
<FORM METHOD=POST ACTION="">
<TABLE>
<TR>
	<TD>Логин: </TD>
	<TD><INPUT class=auth TYPE="text" NAME="login"></TD>
</TR>
<TR>
	<TD>Пароль: </TD>
	<TD><INPUT class=auth TYPE="text" NAME="pass"></TD>
</TR>
<TR>
	<TD>E-mail: </TD>
	<TD><INPUT class=auth TYPE="text" NAME="email"></TD>
</TR>
<TR>
	<TD COLSPAN=2><INPUT class=auth TYPE="submit" NAME="join" VALUE='Добавить'></TD>
</TR>
</TABLE>
</FORM>
<?
}

function JoinUser()
{
	$error = '';
	if (trim($_POST["login"]) == '' or trim($_POST["pass"]) == '' or trim($_POST["email"]) == '')
		$error .= ' Не заполнены обязательные поля.<BR>';
	if (!ereg("^[a-z0-9_\.\-]+@([a-z0-9][a-z0-9-]+\.)+[a-z]{2,4}$", $_POST["email"]))
		$error .= ' Неверный адрес e-mail.<BR>';
	$check = file('../users.php');
	foreach($check as $string)
	{
		list($user,$pass,$email,$code,$time) = explode("^^",$string);
		if(trim($_POST["login"]) == trim($user))
		{
			$error .= ' Пользователь с таким логином уже зарегистрирован.<BR>';
			break;
		}
	}
	if ($error == '')
		SendCode();
	else
	{
		echo '<CENTER><BR><FONT COLOR=RED>'.$error.'</FONT><BR></CENTER>';
		ShowForm();
	}
}

function SendCode()
{
	$code = md5(time().rand(1,9999));
	$live = strtotime("+ 3 days");
	$input = trim($_POST["login"]).'^^'.trim($_POST["pass"]).'^^'.trim($_POST["email"]);
	$input .= '^^'.$code.'^^'.$live."\n";
	PHPruSave($input,'../users.php','a+');
	$subject = 'Подтвердите регистрацию.';
	$content = 'Вы зарегистрировались на сайте '.$_SERVER["SERVER_NAME"]."\n\n";
	$content .= 'Для подтверждения регистрации перейдите по ссылке';
	$content .= "\nhttp://".$_SERVER["SERVER_NAME"].'/protect/confirm/?email=';
	$content .= trim($_POST["email"]).'&code='.$code."\n\n";
	$content .= 'У Вас есть 3 дня (до '.date("H:m, d.m.Yг.",$live).') для подтверждения регистрации';
	$content .= "\n\n".'Почтовый робот сайта http://'.$_SERVER["SERVER_NAME"];
	$mail = new Email(trim($_POST["email"]),$subject,$content);
	if( $mail->ERROR == 0)
		echo '<CENTER><BR><BR>Код активации отправлен на указанный Вами e-mail.<BR> После его подтверждения Вы получите доступ в закрытую зону.</CENTER><BR><BR>';
	else
		echo '<CENTER><BR><BR>Ошибка отправки сообщения!<BR>Возможно сервер перегружен, попробуйте немного позже.</CENTER><BR><BR>';
}

?>
</BODY>
</HTML>