<?php
extract($HTTP_GET_VARS);
extract($HTTP_POST_VARS);
extract($HTTP_COOKIE_VARS);
extract($HTTP_SERVER_VARS);
//���� �������� ���� ��� �������������
//�� ������� PHP Nuke ;)

//����� �������� ����������
$maxVisitors=60;
$headerColor="#808080";
$headerFontColor="#FFFFFF";
$fontFace="Arial, Times New Roman, Verdana";
$fontSize="1";
$tableColor="#000000";
$fontColor="#0000A0";
$textFontColor="#000000";
//��� ���������� ������������.

 echo "<div align=\"center\">
 <table cellpadding=\"2\" cellspacing=\"1\" width=\"95%\" border=\"0\" bgcolor=\"$tableColor\">";
 echo "
 <tr bgcolor=\"$headerColor\">
 	<td><font face=\"$fontFace\" color=\"$headerFontColor\" size=\"$fontSize\">�������</font></td>
	<td><font face=\"$fontFace\" color=\"$headerFontColor\" size=\"$fontSize\">IP</font></td>
	<td><font face=\"$fontFace\" color=\"$headerFontColor\" size=\"$fontSize\">����</font></td>
	<td><font face=\"$fontFace\" color=\"$headerFontColor\" size=\"$fontSize\">������</font></td>
	<td><font face=\"$fontFace\" color=\"$headerFontColor\" size=\"$fontSize\">��������</font></td>
	<td><font face=\"$fontFace\" color=\"$headerFontColor\" size=\"$fontSize\">����� ������</font></td></tr>";
 //�������� ���� � �������� ����
 $fbase=file($fileName);
 $fbase = array_reverse($fbase);
 $count = sizeOf($fbase);

$m=explode("::",$fbase[0]);
$m2=explode("@",$m[5]);
$m3=explode(".",$m2[0]);
$max=$m3[0];

for ($i=0; $i<$maxVisitors; $i++) :
 if ($i>= $count) {break;}

//��������
$strr = explode("::",$fbase[$i]);

//��� ����������� �����.
$v=explode("@",$strr[5]);
$v2=explode(".",$v[0]);
if ($v2[0]!=$max){$rowColor="#CECECE";
}else{$rowColor="#ff9933";}
//����� �����������.

$decoded=$strr[3];
UrlDecode($decoded);

//$strr[3]=base_convert("$strr[4]",16,10);
 //������ ������
echo "
<tr>
	<td bgcolor=\"$rowColor\"><font face=\"$fontFace\" color=\"$fontColor\" size=\"$fontSize\">$strr[0]</font></td>
	<td bgcolor=\"$rowColor\"><font face=\"$fontFace\" color=\"$fontColor\" size=\"$fontSize\">$strr[1]</font></td>
	<td bgcolor=\"$rowColor\"><font face=\"$fontFace\" color=\"$fontColor\" size=\"$fontSize\">$strr[2]</font></td>
	<td bgcolor=\"$rowColor\"><font face=\"$fontFace\" color=\"$fontColor\" size=\"$fontSize\">$decoded</font></td>
	<td bgcolor=\"$rowColor\"><font face=\"$fontFace\" color=\"$fontColor\" size=\"$fontSize\">$strr[4]</font></td>
	<td bgcolor=\"$rowColor\"><font face=\"$fontFace\" color=\"$fontColor\" size=\"$fontSize\">$strr[5]</font></td>
</tr>";
endfor;
echo ("<br><br>����� ���������: $count");
?>
