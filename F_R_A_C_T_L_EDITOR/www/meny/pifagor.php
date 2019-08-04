<?
$dirr=$This_dir."/Logic/Function_P_line/";
$nemoption = 'Function_P_line';
include_once("options/Metod.php");?>
<br><br>Количество элементов-уровней в каждом уровне<br><input type="TEXT" 			name="tvig" value="2">
<br><br>Количество уровней<br><input type="TEXT" 			name="n" value="10">
<br><br>Маштабирование<br><input type="TEXT" 										name="delta" value="0.15">
<br><br>Положение X 2 точки <br><input type="TEXT"									name="dx1" value="0.5">
<br><br>Положение Y 2 точки <br><input type="TEXT" 									name="dy1" value="0.5">
<br><br>Угол отклонения главной ветви а<br><input type="TEXT" 						name="aa" value="0">
<br><br>Угол отклонения от главной ветви в<br><input type="TEXT" 					name="bb" value="85">
<br><br>Изменение по размеру по размеру<br><input type="TEXT" 						name="Rr" value="0.5">
<br><br>Изменение по размеру по размеру1<br><input type="TEXT" 						name="Rr1" value="0.3">
<br><br>Увеличение или уменьшение <br><input type="TEXT" 							name="VINN" value="0.47">
<br><br>Здвиг фрактала<br><input type="TEXT" 										name="PL" value="0">
<br><br>Azoooooooom <br><input type="TEXT" 											name="zoom" value="1">
<br><br>Вывести опорные линии <input type="Checkbox" 								name="tree" value="true">
<? include_once("options/XY.php"); ?>
<? include_once("options/rand_color.php"); ?>
<? include_once("options/dxdy.php"); ?>
<? include_once("options/cvet.php"); ?>
<? include_once("options/ygol.php"); 
?>
</FIELDSET>
</FIELDSET>
</form>