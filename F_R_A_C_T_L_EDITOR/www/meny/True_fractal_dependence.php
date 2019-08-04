<? 
$dirr=$This_dir."/Logic/Function_P_line/";
$nemoption = 'Function_P_line';
include_once("options/Metod.php"); ?>
<br><br>Размер фрактала(количество итераций) <br><input type="TEXT" 	name="n" value="10">
<br><br>Azoooooooom <br><input type="TEXT" 								name="zoom" value="1">
<br><br>Изменение по размеру по размеру<br><input type="TEXT" 						name="Rr" value="0.14">
<br><br>Изменение по размеру по размеру<br><input type="TEXT" 						name="Rr1" value="0.6">
<br><br>Положение X 2 точки <br><input type="TEXT"	name="dx1" value="0.2">
<br><br>Положение Y 2 точки <br><input type="TEXT" 	name="dy1" value="0.5">
<br><br>Угол отклонения главной ветви а<br><input type="TEXT" 					name="aa" value="0">
<br><br>Угол отклонения от главной ветви в<br><input type="TEXT" 					name="bb" value="45">
<? include_once("options/XY.php"); ?>
<? include_once("options/dxdy.php"); ?>
<? include_once("options/ygol.php"); ?>
<? include_once("options/rand_color.php"); ?>

</form>
