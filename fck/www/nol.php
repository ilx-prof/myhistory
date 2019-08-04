nol
<?	print_r($_POST); ?>

<form action="index.php" method="post" name="forma2">
<? if (isset($_POST["func"]) and isset($_POST["func1"]))
{
	print '<input type="text" name="func" value="'.$_POST["func"].'">';
	print '<input type="text" name="func1" value="'.$_POST["func1"].'">';
}
?>
<select name="func2" onchange="javascript:document.forms['forma2'].submit ( );">
			<option value="one"  <? print $a=(isset ( $_POST["func2"] ) && $_POST["func2"] == "one" ? "selected" : "")?> > НОЛЬ 			</option>
			<option value="ty"  <? print $a=(isset ( $_POST["func2"] ) && $_POST["func2"] == "ty" ? "selected" : "")?> > Один </option>
</select>
</form>
<pre>
<?
	if (isset ($_POST["func2"]))
	{
		include ($_POST["func2"].".php");
	}
?>