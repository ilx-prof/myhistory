<?php
Print "������". "<br>";
#����� �=2+1/2!+1/3!+..+1/n!
function n($n) #��� ��������� ����� n
{
$s=1;
while ($i<$n)
{
$i = $i + 1 ;
$s *= $i;
}
return $s;
}
$d =18;
function e($d)#���������� ����� � � ��������� �
{
$s=2;
while ($n<$d)
{
$n = $n + 1 ;
$s += 1 / n($n);
}
$s -= 1;
return $s;
}
$a = M_E;
print $a . "&nbsp;&nbsp;��������"."<br>";#����� ����� � �����������o
print  e($d) . "&nbsp;&nbsp;����"."<br>";#� � ��������� �� 3/(�+1)! ������� �������� d
$m = $d+1;
print "<br>" . (3)/(n($m)). "&nbsp;&nbsp;3/(�+1)! �����������"  . "<br>";
$i = 1;
while ($i<$d)
{
$i = $i + 1 ;

print "<br>" . ";&nbsp;�������� �" . ($i-1) . "<br>";
print  "<br>". $a ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�������� <br>" . e($i) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����"  ."<br>" ;
print $a-e($i)."&nbsp;&nbsp;��������"."<br>";
}


?>
