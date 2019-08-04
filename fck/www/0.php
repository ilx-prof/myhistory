0<?	print_r($_POST); ?>
<form action="index.php" method="post" name="forma1">
<? if (isset($_POST["func"]))
{
	print '<input type="text" name="func" value="'.$_POST["func"].'">';
}
?>



<select name="func1" onchange="javascript:document.forms['forma1'].submit ( );">

			<option value="nol"  <? print $a=(isset ( $_POST["func1"] ) && $_POST["func1"] == "nol" ? "selected" : "")?> > НОЛЬ </option>
			<option value="odin"  <? print $a=(isset ( $_POST["func1"] ) && $_POST["func1"] == "odin" ? "selected" : "")?> > Один </option>
</select>
</form>
<pre>
<?
	if (isset ($_POST["func1"]))
	{
		include ($_POST["func1"].".php");
	}
?>