<HTML>
<HEAD>
<TITLE>����������� ������ ������������</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<LINK href="../phpru.css" type=text/css rel=STYLESHEET>
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BGCOLOR=#2A3747>
<CENTER><BR><BR>
��� ��������� ������� � �������� ����, 
��� ���������� ������������������.<BR>
�� ��� e-mail ����� ������ ��� ���������.<BR>
���� ������� ������ ����� ������������, ������ ����� ������������� ���� ����.<BR><BR> 
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
	<TD>�����: </TD>
	<TD><INPUT class=auth TYPE="text" NAME="login"></TD>
</TR>
<TR>
	<TD>������: </TD>
	<TD><INPUT class=auth TYPE="text" NAME="pass"></TD>
</TR>
<TR>
	<TD>E-mail: </TD>
	<TD><INPUT class=auth TYPE="text" NAME="email"></TD>
</TR>
<TR>
	<TD COLSPAN=2><INPUT class=auth TYPE="submit" NAME="join" VALUE='��������'></TD>
</TR>
</TABLE>
</FORM>
<?
}

function JoinUser()
{
	$error = '';
	if (trim($_POST["login"]) == '' or trim($_POST["pass"]) == '' or trim($_POST["email"]) == '')
		$error .= ' �� ��������� ������������ ����.<BR>';
	if (!ereg("^[a-z0-9_\.\-]+@([a-z0-9][a-z0-9-]+\.)+[a-z]{2,4}$", $_POST["email"]))
		$error .= ' �������� ����� e-mail.<BR>';
	$check = file('../users.php');
	foreach($check as $string)
	{
		list($user,$pass,$email,$code,$time) = explode("^^",$string);
		if(trim($_POST["login"]) == trim($user))
		{
			$error .= ' ������������ � ����� ������� ��� ���������������.<BR>';
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
	$subject = '����������� �����������.';
	$content = '�� ������������������ �� ����� '.$_SERVER["SERVER_NAME"]."\n\n";
	$content .= '��� ������������� ����������� ��������� �� ������';
	$content .= "\nhttp://".$_SERVER["SERVER_NAME"].'/protect/confirm/?email=';
	$content .= trim($_POST["email"]).'&code='.$code."\n\n";
	$content .= '� ��� ���� 3 ��� (�� '.date("H:m, d.m.Y�.",$live).') ��� ������������� �����������';
	$content .= "\n\n".'�������� ����� ����� http://'.$_SERVER["SERVER_NAME"];
	$mail = new Email(trim($_POST["email"]),$subject,$content);
	if( $mail->ERROR == 0)
		echo '<CENTER><BR><BR>��� ��������� ��������� �� ��������� ���� e-mail.<BR> ����� ��� ������������� �� �������� ������ � �������� ����.</CENTER><BR><BR>';
	else
		echo '<CENTER><BR><BR>������ �������� ���������!<BR>�������� ������ ����������, ���������� ������� �����.</CENTER><BR><BR>';
}

?>
</BODY>
</HTML>