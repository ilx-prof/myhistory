<TABLE>
<TR>
<TD>
<?php
$filename = 'Infuser.ini';
// ������� ������� ��������, ��� ���� ���������� � �������� ��� ������.
if (is_writable($filename)) 
{

    // � ����� ������� �� ��������� $filename � ������ "�������� � �����".
    // ����� �������, �������� ����������� � ����� ����� �
    // ��� $somecontent ��������� � ����� ��� ������������� fwrite().
    if (!$handle = @fopen($filename, 'W'))
	 {
         echo "�� ���� ������� ���� ($filename)";
         exit;
    }
     fclose($handle);
	echo "���� ������";
 }
 else { echo "���� $filename ���������� ��� ������";}
?>

<TD>

<TD bgcolor="fgfcg" >
<a href="index.php">�����</a>
</TD>
</TR>
</TABLE>
