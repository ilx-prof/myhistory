<?
	$meny=4;
?>
<table cellspacing="2" cellpadding="2" border="1" align="center" width="60%" height="60%">
<form action="index.php?mod=Ed&ad_mes=<? print $_GET["New_Anonce"] ?>" method="post" enctype="multipart/form-data">
<tr>
	<td>Наименование категории</td>
	<td>
		<input type="Hidden" name="id" value="<? print $_GET["New_Anonce"] ?>">
		<input type="Hidden" name="mod" value="Ed">
		<select name="Category" >
			<?
				$cat = cat();
				foreach($cat[0] as $key => $name_post)
				{
						$sel = $name_post==$chec ? "selected" : "";
						print '<option value="'.$name_post.'"'.$sel.'>'.$cat[1][$key].'</option>';
				}
			?>
		</select>
	</td>
</tr>
<tr>
	<td>Полное наименование товара</td>
	<td><input type="Text" name="name" value=""></td>
</tr>
<tr>
	<td>Цена</td>
	<td><input type="Text" name="Prise" value=""></td>
</tr>
<tr>
	<td>Описание предложения</td>
	<td><textarea name="Mesaege" wrap="on" style="width:100% ; height:100%"></textarea></td>
</tr>
<tr>
	<td>Загрузить картинки<br><h5>*примечание вы можете загружать до <? print $meny; ?> картинок не более 1024 кб каждая</h5>
	</td>
	<td id="one"  align="center">
<?
		for ($i=0;$i<$meny;$i++)
		{
			print '<input type="file" name="Image_'.$i.'">';
		}
	?>
	</td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="Submit" name="Submit_new_mes" value="Оопубликовать объявление"></td>
</tr>
</form>
</table>
