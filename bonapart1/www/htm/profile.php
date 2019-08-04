<table border="1" bordercolor="#c0c0c0" align="center" width="45%">
<form action="index.php?mod=Ed&Profile=0&profile" method="post">
<tr>
	<td colspan="2"><p align="center"><font face="Times New Roman">Заполните следуюшюю форму</font></p></td>
</tr>
<tr>
	<td>Логин</td>
	<td><? print $_COOKIE["baraholca"]['Password']?></td>
</tr>
<tr>
	<td>Старый пароль</td>
	<td><input type="Password" name="user_data[Password]" ></td>
</tr>
<tr>
	<td>Повторите пароль</td>
	<td><input type="Password" name="user_data[Password0]" ></td>
</tr>
<tr>
	<td>Новый пароль не менне 5ти символов</td>
	<td><input type="Password" name="user_data[Password_new]"></td>
</tr>
<tr>
	<td>e-mail</td>
	<td><input type="Text" name="user_data[e_mail]" value="<?print $data_id['e_mail']?>"></td>
</tr>
<tr>
	<td colspan="2"><input type="Submit" name="submit_reveit" value="Изменить"></td>
</tr>
</form>
</table>