<?//..этот фаил подключаеться к функции едит $id & $num _mes выше
	$meny=6;
	$chec = $mesage[0][0]["Category"];
	$cat = cat ();
	$imges =  $mesage[0][1];
	$img = array_pad ($imges,$meny, false);
?>

<table cellspacing="2" cellpadding="2" border="1" align="center" width="60%" height="60%">
<form action="index.php?mod=Ed&edit=replase" method="post" enctype="multipart/form-data">
<tr>
	<td>Наименование категории</td>
	<td>
		<input type="Hidden" name="text[id]" value="<? print $id ?>">
		<input type="Hidden" name="num_mes" value="<? print $num_mes ?>">		
		<input type="Hidden" name="mod" value="Ed">
		<select name="text[Category]" >
			<?
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
	<td><input type="Text" name="text[name]" value="<? print $mesage[0][0]["name"]; ?>"></td>
</tr>
<tr>
	<td>Цена</td>
	<td><input type="Text" name="text[Prise]" value="<? print $mesage[0][0]["Prise"]; ?>"></td>
</tr>
<tr>
	<td>Описание предложения</td>
	<td><textarea name="text[Mesaege]" wrap="on" style="width:100% ; height:100%"><? print $mesage[0][0]["Mesaege"]; ?></textarea></td>
</tr>
<tr>
	<td colspan="2" align="center">Картинки (при замене на пустую или неверную строку удаляються!)</td>
</tr>
		<?
			$print="";
			$im = $img;
			$img=array ();
			foreach ($im as $key => $val )
			{
				$img[]=$val;
			}
			foreach ($img as $key => $file_name)
			{
				$print.='<tr>';
				if($file_name==false)
				{
					$file_name = "12345678900987y6t5r4e3w21wserahdblkjasfksjdnfkb.jpg";
				}
					$sise = sise($file_name,120);
					
					$print.='<td align="center"><img src="'.str_replace ("med","min",$file_name).'" '.$sise.'></td>' ;
					$file_name = explode("/",$file_name);
					$file_name = $file_name[count($file_name)-1];
					$print.='<td><table>
			<tr>
				<td align="center"><input align="left" type="Checkbox" name="image_repl['.$key.']" value="'.$file_name.'">Удалить</td>
				</tr>
			<tr>
				<td> Заменить <input type="file" name="image['.$key.']"><br></td>
			</tr>
								</table>
							 </td>';
				$print.='</tr>';
			}
print $print;
		?>
<tr>
	<td colspan="2" align="center"><input type="Submit" name="Submit_new_mes" value="Оопубликовать объявление"></td>
</tr>
</form>
</table>
