<form action="reg.php" onsubmit="return TestFillForm(this)" method="post" name="reg">
<table align="center" cellspacing="0" cellpadding="0" border="0" style="filter: alpha(opacity=85);">
<tr>
    <td><img src="lvF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="1" border="0"></td>
    <td><img src="pvF.gif" width="10" height="10" border="0"></td>
</tr>
<tr>
    <td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
    <td background="bgF.gif">
<h1 class="tim">Регистрация нового пользователя</h1>
<table cellpadding="10" cellspacing="0">
<tr><td class="spisock"><font color=#FF0000>*</font><em class="fuz">Login (не больше 25 символов):</em><br></td>
	<td class="spisock" style="border-right:0px;"><INPUT class="forma" TYPE=TEXT SIZE=25 NAME=nick value="<?php echo $nick;?>"></td></tr>
<tr><td class="spisock"><font color=#ff0000>*</font><em class="fuz">Пароль:</em><br></td>
	<td class="spisock" style="border-right:0px;"><INPUT class="forma" TYPE=PASSWORD size=25 NAME=pass1></td></tr>
<tr><td class="spisock"><font color=#ff0000>*<em class="fuz">Подтверждение пароля:</em><br></td>
	<td class="spisock" style="border-right:0px;"><INPUT class="forma" TYPE=PASSWORD size=25 NAME=pass2></td></tr>
<tr><td class="spisock"><font color=#FF0000>*</font><em class="fuz">Em@il:</em><br></td>
	<td class="spisock" style="border-right:0px;"><INPUT class="forma" TYPE=EDIT maxlength="60" SIZE=25  NAME=mail value="<?php echo $mail;?>"></td></tr>
<tr><td class="spisock" colspan="2" style="border-right:0px;"><font color=#FF0000>*</font><em class="fuz">Откуда узнал о сушествовании нашего сайта?</em></td></tr>
<tr><td class="spisock" colspan="2" style="border-right:0px;"><TEXTAREA class="forma" name="mes" rows=6 cols=65><?php echo $mes;?></TEXTAREA></td></tr>
</table>
<p>
<table align="center" cellspacing="10">
<tr>
	<td><div align="center"><div class="text"><<<</div><div class="shadow" UNSELECTABLE="on"><<<</div></td>
	<td><INPUT class="fuzzy" TYPE=SUBMIT style="cursor:hand;" VALUE="Зарегистрироваться"></td>
	<td><div class="text">>>></div><div class="shadow" UNSELECTABLE="on">>>></div></td>
</tr>
</table>
    <td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
</tr>
<tr>
    <td><img src="lnF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="10" border="0"></td>
    <td><img src="pnF.gif" width="10" height="10" border="0"></td>
</tr>
</table>
<div align="center" style="color:white;">Все поля обязательны для заполнения</div>
</form>