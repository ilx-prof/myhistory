<?php
extract($HTTP_GET_VARS);
extract($HTTP_POST_VARS);
extract($HTTP_COOKIE_VARS);
extract($HTTP_SERVER_VARS);
//���� �������� ���� ��� �������������
//�� ������� PHP Nuke ;)
//����� �������� ����������
$maxVisitors=30; //���������� �������, ������������
//��� ��������� ����������
$cookieName="visitorOfMySite"; //��� ����
$cookieValue="1"; //�������� ����
$timeLimit=0; //���� � ��������, ������� ������
//������ � ������� ���������� ��������� �����, ��� ��
//���������� � ���������� ���������� ��������. ���
//�������� ����� 1 ���, �.�. ���� � ��� �� ����������
//������������ � ���������� ��� � ���� �����. ����
//��� ���������� ���������� � ����, �� ����� �����������
//��� ��������� ������ � ���� �� ����������
//����� ������� ����������, ���������� �� �����������
//����������
$headerColor="#808080";
$headerFontColor="#FFFFFF";
$fontFace="Arial, Times New Roman, Verdana";
$fontSize="1";
$tableColor="#000000";
$rowColor="#CECECE";
$fontColor="#0000A0";
$textFontColor="#000000";
//��� ���������� ������������.
//������� ������ ������ � ����������

 $curTime=date("d.m.Y @ H:i:s"); //������� ����� � ����
 //������������� ������ ��� ������
 if (empty($HTTP_USER_AGENT)) {$HTTP_USER_AGENT = "Unkwnown";}
 if (empty($REMOTE_ADDR)) {$REMOTE_ADDR = "Not Resolved";}
 if (empty($REMOTE_HOST)) {$REMOTE_HOST = "Unknown";}
 if (empty($HTTP_REFERER)) {$HTTP_REFERER = "No Referer";}
 if (empty($REQUEST_URI)) {$REQUEST_URI = "Unknown";}
 $data_ = $HTTP_USER_AGENT."::".$REMOTE_ADDR."::".$REMOTE_HOST."::".$HTTP_REFERER."::".$REQUEST_URI."::".$curTime."\r\n";
//������������ ����� ��� ":"
//����� ���� � ����
 $fp = fopen($fileName, "a+b");
 fputs ($fp, $data_);
 fclose ($fp);
?>
