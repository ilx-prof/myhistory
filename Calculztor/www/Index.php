<pre>
<?php
print_r ($_POST);
?>
</pre>
<table cellspacing="2" cellpadding="2" bordercolor="#000000" align="center">
<FORM ACTION="1.php" METHOD=POST > 
<tr>
	<td rowspan="4">
		<input  type="Text" name="ARIA[one]" value="
<?php
print $_POST['ARIA']['Action'];
?>
"><-- ����� �����
	</td>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="+" checked>�������
	</td>
	<td rowspan="4">
		<input  type="Text" name="ARIA[tu]" value="" ><-- ����� �����
	</td>
</tr>
<tr>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="-" >�������
	</td>
</tr>
<tr>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="*" >��������
	</td>
</tr>
<tr>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="/" >��������
	</td>
</tr>

</table>
<table width="50%" align="center" bgcolor="#00ffff" >
	<tr>
	<td align="center">
		<INPUT TYPE=SUBMIT VALUE="����������" > 
	</td>
	</tr>
</FORM>
<table>
</td>
