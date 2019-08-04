<?
$PATH = '/������_����_�_������_�����/www/protect/'; 
	/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	+         ��������: | PHPru_Auth                             +
	+ ---------------------------------------------------------- + 
	+           ������: | 2.1                                    +
	+        ���������: | ���������� ������                      +
	+       ����������: | PHP4                                   +
	+        ���������: | �����                                  +
	+             ����: | �������                                +
	+            �����: | Alex (http://www.phpru.net)            +
	+   Copyright 2004: | PHPru.net� - All Rights Reserved.      +
	+ ---------------------------------------------------------- + 
	+         ��������: | 23 ���� 2004                           +
	+ + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */ 

#######################################################################

class PHPruAuth
{
	var $LOGIN;
	var $PASSWORD;
	var $USER;
	var $PASS;

	function Error()
	{
		echo '<CENTER><BR><BR><FONT COLOR=RED><B>ACCESS DENIED!...</B></FONT>';
		exit("<BR>\n</BODY>\n</HTML>");
	}
	
	function CheckUser()
	{
		$this->LOGIN = 'admin'; // ����� ��������������
		$this->PASSWORD = 'pass'; // ������ ��������������

		if($this->LOGIN === $_SERVER["PHP_AUTH_USER"] && $this->PASSWORD === $_SERVER["PHP_AUTH_PW"])
		{
			$_SESSION["admin_online"] = 'true';
			$AUTH = array(trim($this->LOGIN),trim($this->PASSWORD));
			return ($AUTH); 
		}
		global $PATH;
		$user = file($PATH.'users.php');
		foreach($user as $value)
		{
			list($this->USER,$this->PASS,$email,$code,$time) = explode("^^",$value);
			if(($this->USER === $_SERVER["PHP_AUTH_USER"]) && ($code == 'yes'))
			{
				$AUTH = array(trim($this->USER),trim($this->PASS));
				return ($AUTH); 
			}
		}
	}

	function PHPruAuth()
	{
		if(isset($_SERVER["PHP_AUTH_USER"]))
			$AUTH = $this->CheckUser();
		if ( (!isset($_SERVER["PHP_AUTH_USER"])) || ! (($_SERVER["PHP_AUTH_USER"] === $AUTH[0]) && ( $_SERVER["PHP_AUTH_PW"] === $AUTH[1] )) )
		{
			header("HTTP/1.0 401 Unauthorized");
			header("WWW-Authenticate: Basic entrer=\"Form2txt admin\"");
			header("WWW-Authenticate: Basic Realm=\"PROTECTED AREA\"");
			$this->Error(); 
		}
	}
}

session_name('PROTECT');
session_start();
$MEMBER = new PHPruAuth;

?>
<HTML>
<HEAD>
<TITLE>�������� ����</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<LINK href="/protect/phpru.css" type=text/css rel=STYLESHEET>
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BGCOLOR=#2A3747>
<CENTER><BR>
<?

function ListUser()
{
	global $PATH;
	$list = file($PATH.'users.php');
	$all = count($list);
?>
<TABLE WIDTH=600 CELLPADDING=5 CELLSPACING=1 BGCOLOR=#FFFFFF>
<TR ALIGN=CENTER BGCOLOR=#444444>
	<TD><B>�����</B></TD>
	<TD><B>������</B></TD>
	<TD><B>E-mail</B></TD>
	<TD><B>���� �����������</B></TD>
	<TD><B>�������</B></TD>
</TR>
<?
	$act = 0;
	foreach($list as $string)
	{
		list($user,$pass,$email,$code,$time) = explode("^^",$string);
		if ($code != 'yes')
		{
			if($time > time())
				$txt = '<FONT COLOR=#66CC00>������� ��</FONT> ';
			else
				$txt = '<FONT COLOR=#FF0000>�� ��������</FONT> ';
		}
		else
		{
			$txt = '';	$act++;
		}
		echo '<TR ALIGN=CENTER BGCOLOR=#2A3747><TD>'.$user.'</TD><TD>'.$pass."</TD><TD><A HREF='mailto:".trim($email)."'>".trim($email)."</A></TD><TD>".$txt.date("d.m.Y�.",$time)."</TD><TD><A HREF='?user=del&login=".$user."' TITLE='�������'><FONT COLOR='#FF0000'><B>X</B></FONT></A></TD></TR>\n";
	}
?>
</TABLE>
<BR>�������������, ������� ������ � �������� ���� - <B><?=$act?></B>
<BR>����� ������������� - 
<?
	echo '<B>'.$all.'</B>';
}

function AddUser()
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
	<TD COLSPAN=2><INPUT class=auth TYPE="submit" NAME="protect" VALUE='��������'></TD>
</TR>
</TABLE>
</FORM>
<?
}

function DelUser()
{
	global $PATH;
	$list = file($PATH.'users.php');
	for($a = 0; $a < count($list); $a++)
	{
		list($user,$pass,$email,$code,$time) = explode("^^",$list[$a]);
		if($user == trim($_GET["login"]))
		{
			$fix = 1;
			unset($list[$a]);
			echo '������������ '.$user.' ������!';
			break;
		}
	}
	if(!isset($fix))
		echo '������. ������������ '.$_GET["login"].' � ���� �� ������.';
	else
	{
		$user_info = str_replace("\r","",join("",$list));
		PHPruSave($user_info,$PATH.'users.php','w+');
	}
}

function PHPruSave($input,$file,$chmod='w+')
{
	$fp = fopen($file,$chmod);
	flock($fp,2);
	fputs ($fp,	$input);
	flock($fp,3);
	fclose($fp);
}


if (isset($_SESSION["admin_online"]))
{
	ShowAdmin();
	exit("\n</BODY>\n</HTML>");
}

function ShowAdmin()
{
?>
<CENTER><BR><BR>
<P><B>���� ��������������:</B><BR><BR>
<A HREF="?user=add">������� ������ ������������</A><BR><BR>
<A HREF="?user=list">����������� ������ �������������</A><BR><BR>
<?

if(isset($_POST["protect"]))
{
	global $PATH;
	$check = file($PATH.'users.php');
	foreach($check as $string)
	{
		list($user,$pass,$email,$code,$time) = explode("^^",$string);
		if(trim($_POST["login"]) == trim($user))
		{
			$fix = 1;
			break;
		}
	}
	if(!isset($fix))
	{
		$user_info = trim($_POST["login"]).'^^'.trim($_POST["pass"]).'^^'.trim($_POST["email"]).'^^yes^^'.time()."\n";
		PHPruSave($user_info,$PATH.'users.php','a+');
		echo '����� ������������ ��������.';
		unset($_GET["user"]);
	}
	else
	{
		echo '������. ������������ � ����� ������� ��� ����.<BR><BR>';
	}
}

if(isset($_GET["user"]))
{
	if($_GET["user"] == 'add')
		AddUser();
	elseif($_GET["user"] == 'list')
		ListUser();
	elseif($_GET["user"] == 'del')
		DelUser();
}

?>
<BR><BR><BR>
<FONT CLASS=stat>Copyright &copy; 2004 <A HREF='http://phpru.net'>PHPru.net&trade;</A><BR><BR>
<?
}
?>