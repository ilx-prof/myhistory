<TABLE>
<TR>
<TD>

<?php
foreach ($_POST as $varname => $varvalue)
$post = $varvalue;
$filename = 'tet.txt';
$today = "<br>"."<br><H1>".date("F j, Y, g:i a")."</H1> <br>"; 
fopen($filename, 'a');
// ������� ������� ��������, ��� ���� ���������� � �������� ��� ������.
if (is_writable($filename)) {
     if (!$handle = fopen($filename, 'a')) {
         echo "�� ���� ������� ���� ($filename)";
         exit;
    }

    // ���������� $post + todey � �������� ����.
    if (fwrite($handle,$today."&nbsp;&nbsp;&nbsp;".$post) === FALSE) {
        echo "�� ���� ���������� ������ � ���� ($filename)";
        exit;
    }
    
    echo "���! �������� ($post) � ���� ($filename)";
    
    fclose($handle);

} else {
    echo "���� $filename ���������� ��� ������";
}
?>
<TD>

<TD bgcolor="fgfcg" >
<a href="index.php">�����</a>
</TD>
</TR>
</TABLE>
