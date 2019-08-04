<form action="imege.php" method="POST" >
Введите имя рисунка<br>
<input type="Hidden" name="imege_neme" value="<? print $fname;?>">
<input type="text" name="neme" value="">
<input type="SUBMIT" name="submit" value="СОЗДАТЬ!">
<br><font color="#12590D" face="Comic Sans MS">Дополнительные параметры</font>
<?
print 'Чем строим<br><select size="1" name="metod" >';
if (is_dir($dirr))
	{ 
	 	if ($dh = opendir($dirr))
	 	{
     	 	while (false !== ($filem = readdir($dh)))
			{
				 if ($filem != "." && $filem != ".." )
				 {
					Print "<option value=\"Function_S_pixel/$filem\">$filem</option><br>";
					$m++;
				 }
			}
		}
	}
	Print '</select>'
?>
