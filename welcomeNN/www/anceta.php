<table align="center" cellspacing="2" cellpadding="2" border="0" width="80%">
<tr>
	<td  align="center">
	<FIELDSET><legend align="center">
	<a href="adm_base.php">Управление</a>
	<h1 align="center"> Анкета</h1>
<form action="anceta.php" name="forma"  method="POST" >
<select name="type" onchange="javascript:document.forms['forma'].submit ( );">
<? $i=0;
	if (is_dir(getcwd ()."/base"))
	{ 
	 	if ($dh = opendir(getcwd ()."/base"))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." && is_file(getcwd ()."/base/".$file))
				 {
					$files[]=$file;
					$i++;
				 }
			}
		}
	}
	if(empty ($_POST["type"]))
	{
			$_POST["type"]=$files[0];
	}
	$tmp = "";
	$form = $tmp;
	foreach ( $files as $id => $fname )
	{
		$select ="";
		if (isset ( $_POST["type"] ) && $_POST["type"]==$fname)
		{
			$select="selected";
		}
		$form .="	<option value=\"".$fname."\" $select>".$fname ."</option>\n";
	}
	$form .= "";
	print $form;
	
?>
</select>
</form>
</legend><FIELDSET>
<? 
if($_POST["type"]!=false)
{	print "<H3> $_POST[type] </H3>";
?>
	<form action="go_to_base.php" method="post">
	<input type="Hidden" name="Тип" value="<? print $_POST["type"] ?> ">
		<?include ("anceta/".$_POST["type"]);?>
	<table cellspacing="2" cellpadding="2" border="0">
<tr>
	<td><input type="Submit" name="Действие" value="Найти"></td>
	<td><input type="Submit" name="Действие" value="Добавить/Обновить">
	Вывести процесс?
		<input type="Checkbox" name="Вывести процесс" value="true" checked>
	</td>
</tr>
</table>
	</form>
		<?
}
?>
</FIELDSET>
</FIELDSET>
	</td>
</tr>
</table>
