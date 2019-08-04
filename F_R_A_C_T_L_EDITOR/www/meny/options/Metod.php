<?
	$submit = isset ($_POST["metod"]) ? "Создать изображение" : "Загрузить надстройку";
 ?>
<input type="Hidden" name="imege_neme" value="<? print $fname;?>">
<? if ($submit =="Создать изображение" ){ ?>
Введите имя рисунка<br>
<input type="text" name="neme" value="">
<?}?>
<input type="SUBMIT" name="submit" value="<? print $submit ?>">
<FIELDSET><LEGEND align="center">Настройки построения</LEGEND>
