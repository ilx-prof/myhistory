<?
$dirr=$This_dir."/Logic/Function_P_line/";
$nemoption = 'Function_P_line';
 include_once("options/Metod.php"); ?>
<br><br>Множетель количества элементов (итерации)<br><input type="TEXT" 			name="n" value="10000">
<br><br>Размер элементов фрактала <br><input type="TEXT" 				name="R" value="3">
<br><br>Множитель размера <br><input type="TEXT" 						name="Rr" value="0.1">
<br><br>Делитель угла поворота 1 <br><input type="TEXT" 				name="onedel" value="0.0000000000030">
<br><br>Делитель угла поворота all <br><input type="TEXT" 				name="alldel" value="20202223333">
<? include_once("options/XY.php"); ?>
<? include_once("options/rand_color.php");?>
<? include_once("options/dxdy.php");?>
<? include_once("options/ygol.php");?>
</form>