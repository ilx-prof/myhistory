<body bgcolor="#EDE9F8" text="#151644">
<table cellspacing="2" cellpadding="2" border="0">
<tr valign="top"">
	<td><h3>��</h3><img src="korp.gif" width="140" height="140" alt=""><br><br>
			<?php print translete_allay ("parametr.php", $Uzer1_parametrs); ?>
	
	</td>
	<td width="100%" >
	<form action="index.php" method="POST" name="">
	
<table align="center">
<tr ><td>
<h3>������� ������� ���</h3>
		<input type="Radio" name="Tactic" value="attack">������ �����<br>
		<input type="Radio" name="Tactic" value="a3d2">���������� �����, ������ ���<br>
		<input type="Radio" name="Tactic" value="a2d2" checked>������� �����, ������� ���<br>
		<input type="Radio" name="Tactic" value="a1d3">����� �����, ���������� ���<br>
		<input type="Radio" name="Tactic" value="defence">������ ������<br>
</td></tr>
</table>

		<table cellspacing="2" cellpadding="2" border="0">
			<tr>
			<td colspan="2" valign="top" align="center">
			<h4>������ ��</h4>
			</td>
</tr>
<tr>
	<td valign="top" width="45%">
		�� �������� ����� ������<br>
		<input type="Radio" name="droket" value="Trocet">������� �����(������������ - )<br>
		<input type="Radio" name="droket" value="Crocet">������� �����(������������ - )<br>
		<input type="Radio" name="droket" value="Lrocet" checked>������� �����(������������ - )<br>
		<input type="Radio" name="drocet" value="grant">���������������� ������ (������������ -)<br>
	</td>
	<td valign="top" width="55%">
		��������������� ������ ������ <br><!--- ������ �� ������ ����� ��� ������ ������ �� ��� ��������--->
		<input type="Radio" name="dener" value="Laser" checked>��������(������������/�������)<br>
		<input type="Radio" name="dener" value="EMP">���(������������/�������)<br>
		<input type="Radio" name="dener" value="Mezon">���������(������������/�������)<br>
		<input type="Radio" name="dener" value="Radio">�������������(������������/�������)<br>
		<input type="Radio" name="dener" value="Gravit">�������������(������������/�������)<br>		
	</td>
</tr>
</table>	<table cellspacing="2" cellpadding="2" border="0">
			<tr>
			<td colspan="2" valign="top" align="center">
		
		<h4>����� </h4>
	</td>
</tr>
<tr>
	<td valign="top">
			������� ������ �����<br>
		<input type="Radio" name="arocet" value="Trocet">������� ������(� ������� - )<br>
		<input type="Radio" name="arocet" value="Crocet">������� ������(� ������� - )<br>
		<input type="Radio" name="arocet" value="Lrocet" checked>������ ������ (� ������� - )<br>
		<input type="Radio" name="arocet" value="grant">���������������� ������ (� ������� - )<br>
	</td>
	<td valign="top">
			��������������  ������� ������ <br><!--- ������ �� ������ ����� ��� ������ ������ �� ��� ��������--->
		<input type="Radio" name="aener" value="Laser" checked>��������(������������/�������)<br>
		<input type="Radio" name="aener" value="EMP">���(������������/�������)<br>
		<input type="Radio" name="aener" value="Mezon">���������(������������/�������)<br>
		<input type="Radio" name="aener" value="Radio">�������������(������������/�������)<br>
		<input type="Radio" name="aener" value="Gravit">�������������(������������/�������)<br>		
	</td>
</tr>
</table>	
<table>
<tr><td>
		<input type="Submit" name="faer" value="faer" >
</td></tr>
</table>
</form>	


	</td>
	<td><h3>���������</h3><img src="hull.gif" width="140" height="140" alt=""><br><br>
	
			<?php print translete_allay ("parametr.php", $Uzer1_parametrs); ?>
	
	</td>
</tr>
<tr>
	<td>
				<? print translete_allay ("rpg.php", $Uzer1_rpg);  ?>
	</td>
	<td>
	
<table align="center"  cellspacing="3" cellpadding="3" border="1" >
<tr>
<td colspan="2" align="center">��� ���</td>
</tr>
<tr>
<td>�������� ���-��</td>
<td>���������� ���-��</td>
</tr>
</table>
			<?php print translete_allay ("action.php", $ACTION); ?>
	</td>
	<td>
				<? print translete_allay ("rpg.php", $Uzer2_rpg);  ?>
	</td>
</tr>
<tr>
	<td></td>
	<td align="center">��� ����</td>
	<td></td>
</tr>
</table>
</body>