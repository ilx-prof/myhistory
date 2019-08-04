<?	print_r($_POST); ?>
<form action="index.php" method="post" name="forma">
<select name="func" onchange="javascript:document.forms['forma'].submit ( );">
			<option value="0"  <? print $a=(isset ( $_POST["func"] ) && $_POST["func"] == "0" ? "selected" : "")?> > НОЛЬ </option>
			<option value="1"  <? print $a=(isset ( $_POST["func"] ) && $_POST["func"] == "1" ? "selected" : "")?> > Один </option>
</select>
</form>
<pre>
<?
	if (isset ($_POST["func"]))
	{
		include ($_POST["func"].".php");
	}
?>