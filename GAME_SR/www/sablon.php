<body bgcolor="#EDE9F8" text="#151644">
<table cellspacing="2" cellpadding="2" border="0">
<tr valign="top"">
	<td><h3>Вы</h3><img src="korp.gif" width="140" height="140" alt=""><br><br>
			<?php print translete_allay ("parametr.php", $Uzer1_parametrs); ?>
	
	</td>
	<td width="100%" >
	<form action="index.php" method="POST" name="">
	
<table align="center">
<tr ><td>
<h3>Тактика ведения боя</h3>
		<input type="Radio" name="Tactic" value="attack">Только атака<br>
		<input type="Radio" name="Tactic" value="a3d2">Нормальная атака, слабый шит<br>
		<input type="Radio" name="Tactic" value="a2d2" checked>Средняя атака, средний шит<br>
		<input type="Radio" name="Tactic" value="a1d3">Малая атака, нормальный шит<br>
		<input type="Radio" name="Tactic" value="defence">Только зашита<br>
</td></tr>
</table>

		<table cellspacing="2" cellpadding="2" border="0">
			<tr>
			<td colspan="2" valign="top" align="center">
			<h4>Зашита от</h4>
			</td>
</tr>
<tr>
	<td valign="top" width="45%">
		От ракетной атаки класса<br>
		<input type="Radio" name="droket" value="Trocet">Тяжелых ракет(возможэность - )<br>
		<input type="Radio" name="droket" value="Crocet">Средних ракет(возможэность - )<br>
		<input type="Radio" name="droket" value="Lrocet" checked>Легкиех ракет(возможэность - )<br>
		<input type="Radio" name="drocet" value="grant">Крупнокалибеного орудия (возможэность -)<br>
	</td>
	<td valign="top" width="55%">
		Энергетического оружия класса <br><!--- Только на перове время все дальше только то что имееться--->
		<input type="Radio" name="dener" value="Laser" checked>Лазерное(возможэность/энергия)<br>
		<input type="Radio" name="dener" value="EMP">ЕМП(возможэность/энергия)<br>
		<input type="Radio" name="dener" value="Mezon">Мезонноое(возможэность/энергия)<br>
		<input type="Radio" name="dener" value="Radio">Радиоактивное(возможэность/энергия)<br>
		<input type="Radio" name="dener" value="Gravit">Гравитационне(возможэность/энергия)<br>		
	</td>
</tr>
</table>	<table cellspacing="2" cellpadding="2" border="0">
			<tr>
			<td colspan="2" valign="top" align="center">
		
		<h4>Атака </h4>
	</td>
</tr>
<tr>
	<td valign="top">
			Огневым залпом ракет<br>
		<input type="Radio" name="arocet" value="Trocet">Тяжелые ракеты(в наличии - )<br>
		<input type="Radio" name="arocet" value="Crocet">Средние ракеты(в наличии - )<br>
		<input type="Radio" name="arocet" value="Lrocet" checked>Легкие ракеты (в наличии - )<br>
		<input type="Radio" name="arocet" value="grant">Крупнокалибеного орудия (в наличии - )<br>
	</td>
	<td valign="top">
			Энергетическим  оружием класса <br><!--- Только на перове время все дальше только то что имееться--->
		<input type="Radio" name="aener" value="Laser" checked>Лазерное(возможэность/энергия)<br>
		<input type="Radio" name="aener" value="EMP">ЕМП(возможэность/энергия)<br>
		<input type="Radio" name="aener" value="Mezon">Мезонноое(возможэность/энергия)<br>
		<input type="Radio" name="aener" value="Radio">Радиоактивное(возможэность/энергия)<br>
		<input type="Radio" name="aener" value="Gravit">Гравитационне(возможэность/энергия)<br>		
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
	<td><h3>Противник</h3><img src="hull.gif" width="140" height="140" alt=""><br><br>
	
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
<td colspan="2" align="center">Тип боя</td>
</tr>
<tr>
<td>Союзники кол-во</td>
<td>Противники кол-во</td>
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
	<td align="center">Чат тута</td>
	<td></td>
</tr>
</table>
</body>