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
//Упражнения по функции
print test(3) . "<br>";
print test(4) . "<br>";
$t = test(4) * (test(3));
print $t . "<br>". "посчитать выражение из двух функций";
//функция от функции  один цикл
$s=1;
while ($i<test(3))
 {
$i = $i + 1 ;
$s *= $i;
 }
print $s . "&nbsp;&nbsp; функция от функции  один цикл";
//функция из функции
function Test1($m)
 {
$m = $m * test(6) ;
return $m ;
 }
print "<br>" ."<br>" .Test1(2). "&nbsp;&nbsp;&nbsp;функция из функции" . "<br>";
//как сделать аункцию по обоим патаметрам 
function Test2($g,$e)
 {
$g = test($g) * test($e) ;
return $g ;
 }
print "<br>" . Test2(4,4) . "&nbsp;&nbsp;&nbsp;функция по 2 м патаметрам". "<br>";
//а дальше нацинается ЗОНА
$array = array(test2($s,1),test2(($i-$s),1));
print "записал функцию в массивэ <br>" ;
print_r ($array)




// пробую присвоить к функции
//print "<br>" ."<br>" .Test2($array); это жопа
// пробую присвоить к функции tit раз дляэтого нужно ее приспособть
/*
function Test3($array($r,$t))
 {
$array[1] = test($array[1]) * test($array[2]) ;
return $array[1] ;
 }
//видимо придеться спрашивать
*/?>
