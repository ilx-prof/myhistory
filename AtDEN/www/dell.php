<TABLE>
<TR>
<TD>
<?php
$filename = 'tet.txt';
// ������� ������� ��������, ��� ���� ���������� � �������� ��� ������.
if (is_writable($filename)) {
    // � ����� ������� �� ��������� $filename � ������ "�������� � �����".
    // ����� �������, �������� ����������� � ����� ����� �
    // ��� $somecontent ��������� � ����� ��� ������������� fwrite().
    if (!$handle = unlink($filename)) {
         echo "�� ���� ������� ���� ($filename)";
         exit;
    }

    // ���������� $somecontent � ��� �������� ����.
    if (unlink($filename) === FALSE) {
        echo "�� ���� ������� ���� ($filename)";
        exit;
    }
    
    echo "���! ������� ($post) ���� ($filename)";

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
