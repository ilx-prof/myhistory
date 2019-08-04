<TABLE>
<TR>
<TD>

<?php
foreach ($_POST as $varname => $varvalue)
$post = $varvalue;
$filename = 'tet.txt';
$today = "<br>"."<br><H1>".date("F j, Y, g:i a")."</H1> <br>"; 
fopen($filename, 'a');
// Вначале давайте убедимся, что файл существует и доступен для записи.
if (is_writable($filename)) {
     if (!$handle = fopen($filename, 'a')) {
         echo "Не могу открыть файл ($filename)";
         exit;
    }

    // Записываем $post + todey в открытый файл.
    if (fwrite($handle,$today."&nbsp;&nbsp;&nbsp;".$post) === FALSE) {
        echo "Не могу произвести запись в файл ($filename)";
        exit;
    }
    
    echo "Ура! Записали ($post) в файл ($filename)";
    
    fclose($handle);

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
