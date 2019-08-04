<?php
function add(){
echo 
("
<form action=\"addban.php\" method=\"post\">
<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" align=\"center\">
<tr>
	<td colspan=\"2\"><b style=\"color:red;\">ВСЕ ПОЛЯ ОБЯЗАТЕЛЬНЫ ДЛЯ ЗАПОНЕНИЯ!</b></td>
</tr>
<tr>
	<td align=\"center\" bgcolor=\"#c0c0c0\">Баннер:<br>(ссылка на картинку)</td>
	<td><input type=\"Text\" name=\"image\" size=\"100\" value=\"http://\"></td>
</tr>
<tr>
	<td align=\"center\" bgcolor=\"#c0c0c0\">Куда переходить<br>при нажатии:</td>
	<td><input type=\"Text\" name=\"target\" size=\"100\" value=\"http://\"></td>
</tr>
<tr>
	<td align=\"center\" bgcolor=\"#c0c0c0\">Надпись при наведении<br>на баннер</td>
	<td><input type=\"Text\" name=\"alt\" size=\"100\"></td>
</tr>
<tr>
	<td colspan=\"2\" align=\"center\"><!--input type=\"File\" name=\"ban\"--><input type=\"Submit\" value=\"Add Banner!!!\" style=\"cursor:hand;\"></td>
</tr>
</table>
</form>
");}
function ends(){
echo ("Успешно добавлено<br><a href=\"addban.php\">Добавить ещё</a>");
}

$next=1;
$image=eregi_replace("^(((h)*)((t)*)((p)*)((:)*)(/{1,}))","",$image);
$target=eregi_replace("^(((h)*)((t)*)((p)*)((:)*)(/{1,}))","",$target);
if ((!empty($image))&&(!empty($target))&&(!empty($alt))):
//$name=basename($ban);
//copy($ban,"r/$name");

$fp=fopen("banners/banners.txt","a+b");
flock($fp, LOCK_EX);
$str="$image|$target|$alt|";
fwrite($fp,"\r\n$str");
flock($fp, LOCK_UN);
fclose($fp);
$next=0;
ends();
endif;
if (empty($image)):
	if ($next!=0){add();} else {}
endif;
?>