<?php
$kat = "c:/";

print "<H2>������� �������� ������������ ������� � ������ ��������� ��� ����������</H2><br>";

if (is_dir($kat))
{
if ($dh = opendir($kat))
{
while (($file = readdir($dh)) !== false)
{
	print "$file".  "<br>";
}
	closedir($dh);
}
}

?>
