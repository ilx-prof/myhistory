<?php
function Test($a)
 {
$s=1;
while ($i<$a)
 {
$i = $i + 1 ;
$s *= $i;
 }
return $s; 
 }
//���������� �� �������
print test(3) . "<br>";
print test(4) . "<br>";
$t = test(4) * (test(3));
print $t . "<br>". "��������� ��������� �� ���� �������";
//������� �� �������  ���� ����
$s=1;
while ($i<test(3))
 {
$i = $i + 1 ;
$s *= $i;
 }
print $s . "&nbsp;&nbsp; ������� �� �������  ���� ����";
//������� �� �������
function Test1($m)
 {
$m = $m * test(6) ;
return $m ;
 }
print "<br>" ."<br>" .Test1(2). "&nbsp;&nbsp;&nbsp;������� �� �������" . "<br>";
//��� ������� ������� �� ����� ���������� 
function Test2($g,$e)
 {
$g = test($g) * test($e) ;
return $g ;
 }
print "<br>" . Test2(4,4) . "&nbsp;&nbsp;&nbsp;������� �� 2 � ����������". "<br>";
//� ������ ���������� ����
$array = array(test2($s,1),test2(($i-$s),1));
print "������� ������� � ������� <br>" ;
print_r ($array)




// ������ ��������� � �������
//print "<br>" ."<br>" .Test2($array); ��� ����
// ������ ��������� � ������� tit ��� �������� ����� �� �����������
/*
function Test3($array($r,$t))
 {
$array[1] = test($array[1]) * test($array[2]) ;
return $array[1] ;
 }
//������ ��������� ����������
*/?>
