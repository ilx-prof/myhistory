<table border="1" bordercolor="#c0c0c0" align="center" width="45%">
<form action="index.php?mod=Ed&Profile=0&profile" method="post">
<tr>
	<td colspan="2"><p align="center"><font face="Times New Roman">��������� ��������� �����</font></p></td>
</tr>
<tr>
	<td>�����</td>
	<td><? print $_COOKIE["baraholca"]['Password']?></td>
</tr>
<tr>
	<td>������ ������</td>
	<td><input type="Password" name="user_data[Password]" ></td>
</tr>
<tr>
	<td>��������� ������</td>
	<td><input type="Password" name="user_data[Password0]" ></td>
</tr>
<tr>
	<td>����� ������ �� ����� 5�� ��������</td>
	<td><input type="Password" name="user_data[Password_new]"></td>
</tr>
<tr>
	<td>e-mail</td>
	<td><input type="Text" name="user_data[e_mail]" value="<?print $data_id['e_mail']?>"></td>
</tr>
<tr>
	<td colspan="2"><input type="Submit" name="submit_reveit" value="��������"></td>
</tr>
</form>
</table>