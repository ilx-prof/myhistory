<?php

if (file_exists("log.txt"))
{
$f=fopen("log.txt","w+");
fwrite($f,"");
fclose($f);
print "<H1>log.txt ������� ������ </h1>";
}
?>
<a href="index.php">���������</a>
