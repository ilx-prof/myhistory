<?
	$submit = isset ($_POST["metod"]) ? "������� �����������" : "��������� ����������";
 ?>
<input type="Hidden" name="imege_neme" value="<? print $fname;?>">
<? if ($submit =="������� �����������" ){ ?>
������� ��� �������<br>
<input type="text" name="neme" value="">
<?}?>
<input type="SUBMIT" name="submit" value="<? print $submit ?>">
<FIELDSET><LEGEND align="center">��������� ����������</LEGEND>
