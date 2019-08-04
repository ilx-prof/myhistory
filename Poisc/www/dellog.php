<?php

if (file_exists("log.txt"))
{
unlink("log.txt");
print "<H1>log.txt успешно удален</h1>";
}
else{
print "<H1>The file does not exist</h1>";
}
?>
<a href="index.php">Вернуться</a>
