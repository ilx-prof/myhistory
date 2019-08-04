<TABLE>
<TR>
<TD>
<?php
$filename = 'tet.txt';
// Вначале давайте убедимся, что файл существует и доступен для записи.
if (is_writable($filename)) {
    // В нашем примере мы открываем $filename в режиме "дописать в конец".
    // Таким образом, смещение установлено в конец файла и
    // наш $somecontent допишется в конец при использовании fwrite().
    if (!$handle = unlink($filename)) {
         echo "Не могу удалить файл ($filename)";
         exit;
    }

    // Записываем $somecontent в наш открытый файл.
    if (unlink($filename) === FALSE) {
        echo "Не могу УДАЛИТЬ файл ($filename)";
        exit;
    }
    
    echo "Ура! УДАЛИЛИ ($post) файл ($filename)";

} else {
    echo "Файл $filename недоступен для записи";
}
?>
<TD>

<TD bgcolor="fgfcg" >
<a href="index.php">НАЗАД</a>
</TD>
</TR>
</TABLE>
