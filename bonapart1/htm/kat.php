<?
$cat = cat ();
?>
<table cellspacing="2" cellpadding="2" border="1">
<form action="index.php?mod=ad&us=adm&action=cat" method="post">
<tr>
	<td>���������</td>
	<td>��������</td>
</tr>
<tr>
	<td>
		<select name="Category" >
<?
				foreach($cat[0] as $key => $name_post)
				{
						$sel = $name_post==$chec ? "selected" : "";
						print '<option value="'.$name_post.'"'.$sel.'>'.$cat[1][$key].'</option>';
				}
?>	
	</select>
	</td>
	<td>
		<select name="Action">
		<option value="Moder">������� ��������� �� ���������</option>
		<option value="ban">�������� ���������</option>
		<option value="fatal_del">������� ��������� ������ � �����������</option>
		</select>
	</td>
</tr>
<tr>
	<td>������� ����� (������ �������� ����� �� ������������� �����)</td>
	<td><input type="Text" name="new_cat"></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="Submit" name="Submit_moder" value="��������� !"></td>
</tr>
</form>
</table>
