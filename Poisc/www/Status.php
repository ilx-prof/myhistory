
<table align="center" border="1">
<tr>
<td>
<?php
$s = file("StatusCreit.txt");
print "<h1> STATUS $s[0]</h1>"; ?>
</td>
</tr>
<tr >
<td>
<?php

print "<br><h4> Этот скрипт создал уже более  ".$s[0]." файлов <br> Ниже  приведен хронологический порядок создания </h4><br>";
$s = file("Status.txt");
for ($i = 0; $i < count($s) ; $i++)
{
print trim($s[$i]) . "<br>";
}
?>
<a href="index.php"><br>Вернуться</a>
</td>
</tr>
</table>
