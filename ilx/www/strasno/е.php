<?php
Print "привет". "<br>";
#число е=2+1/2!+1/3!+..+1/n!
function n($n) #это факториал числа n
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
function e($d)#вычисление числа е с точностью д
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
print $a . "&nbsp;&nbsp;стандарт"."<br>";#вывод числа е стандартногo
print  e($d) . "&nbsp;&nbsp;свое"."<br>";#е с точностью до 3/(н+1)! почислу итераций d
$m = $d+1;
print "<br>" . (3)/(n($m)). "&nbsp;&nbsp;3/(н+1)! погрешность"  . "<br>";
$i = 1;
while ($i<$d)
{
$i = $i + 1 ;

print "<br>" . ";&nbsp;итерация №" . ($i-1) . "<br>";
print  "<br>". $a ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;стандарт <br>" . e($i) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;свое"  ."<br>" ;
print $a-e($i)."&nbsp;&nbsp;раздница"."<br>";
}


?>
