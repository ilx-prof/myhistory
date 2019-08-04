<TABLE>
<TR>
<TD>
<?php
$filename = 'Infuser.ini';
// Вначале давайте убедимся, что файл существует и доступен для записи.
if (is_writable($filename)) 
{

    // В нашем примере мы открываем $filename в режиме "дописать в конец".
    // Таким образом, смещение установлено в конец файла и
    // наш $somecontent допишется в конец при использовании fwrite().
    if (!$handle = @fopen($filename, 'W'))
	 {
         echo "Не могу открыть файл ($filename)";
         exit;
    }
     fclose($handle);
	echo "Файл очишен";
 }
 else { echo "Файл $filename недоступен для записи";}
?>

<TD>

<TD bgcolor="fgfcg" >
<a href="index.php">НАЗАД</a>
</TD>
</TR>
</TABLE>
