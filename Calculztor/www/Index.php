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
"><-- Введи число
	</td>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="+" checked>Сложить
	</td>
	<td rowspan="4">
		<input  type="Text" name="ARIA[tu]" value="" ><-- Введи число
	</td>
</tr>
<tr>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="-" >Вычесть
	</td>
</tr>
<tr>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="*" >Умножить
	</td>
</tr>
<tr>
	<td>
		<input type="RADIO" name="ARIA[Action]" value="/" >Поделить
	</td>
</tr>

</table>
<table width="50%" align="center" bgcolor="#00ffff" >
	<tr>
	<td align="center">
		<INPUT TYPE=SUBMIT VALUE="Обработать" > 
	</td>
	</tr>
</FORM>
<table>
</td>
