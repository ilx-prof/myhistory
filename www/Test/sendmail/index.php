<html>
<head><title>�������� ���������� �������� ��� sendmail</title></head>
<body>

<?
@extract($_SERVER, EXTR_SKIP); @extract($_POST, EXTR_SKIP); @extract($_GET, EXTR_SKIP);
if(!@$to) $to="me@somehost.ru";
if(!@$subject) $subject="Congratulations!";
if(!@$body) $body="Hello!\nToday is ".date("Y-m-d").".\nThis is the test\nmail body.\n\nIf you see this, sendmail stub seems to be OK.";
?>

<h2>������� �������� ������:</h2>
<form action="<?=$_SERVER["SCRIPT_NAME"]?>" method=POST>
<table width=70% cellpadding=5 cellspacing=2>
<tr valign=top>
	<td>To:</td>
	<td><input type=text name=to value="<?=@HtmlSpecialChars($to)?>"></td>
</tr>
<tr valign=top>
	<td>Subject:</td>
	<td><input type=text name=subject value="<?=@HtmlSpecialChars($subject)?>"></td>
</tr>
<tr valign=top>
	<td>�����:</td>
	<td><textarea name=body cols=50 rows=4><?=@HtmlSpecialChars($body)?></textarea></td>
</tr>
<tr valign=top>
	<td colspan=2>
		<input type=submit name=doSend value="������� ������">
		<input type=submit name=doDel value="�������� ���������� ����������">
	</td>
</tr>
</table>
</form>

<?
$dir = "/tmp/!sendmail";

if (@$doDel) {
	if ($d = @opendir($dir)) {
		while (false !== ($e = readdir($d))) {
			if ($e[0] == ".") continue;
			unlink("$dir/$e");
		}
	}
	echo "<h3>������ �������.</h3>";
}

if(@$doSend) {
	echo "<h2>�������� ������...</h2>\n";
	if(mail($to,$subject,$body,"From: \"PHP mail()\" <mail@php.net>")) {
		echo "OK, ������� mail() ��������� ���������.<br>\n";
	} else {
		echo "��� ������ mail() ��������� ������.<br>\n";
	}
}

$d = @opendir($dir);
if ($d) {
	echo "<h2>���������� ������ � ���������� <tt>$dir</tt></h2>\n";
	$list = array();
	while (false !== ($e = readdir($d))) {
		if ($e[0] == ".") continue;
		$list[] = "$dir/$e";
	}
	rsort($list);

	if ($list) {
		foreach ($list as $fname) {
			$f = @fopen($fname, "r"); if (!$f) continue;
			echo "<h3>���� <tt>$fname</tt>:</h3>\n";
			echo "<pre>\n";
			echo HtmlSpecialChars(fread($f,filesize($fname)));
			echo "</pre>\n";
			echo "<hr>";
		}
	} else {
		echo "���������� �����.";
	}
}
?>

</body>
</html>