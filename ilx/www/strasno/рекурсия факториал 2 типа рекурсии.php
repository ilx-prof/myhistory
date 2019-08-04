<?php
//задачи на рекурсию старый добрый n! с конца 4*3*2*1
function n($n)
{
	if ($n<2 and $n>-2 )//выполняеться в сочитании
	{
	return 1;
	}
		else
		{
			if ($n>1)
			{
			return (integer) $n*n($n-1);
			}
				else 
				{
				return (integer) $n*n($n+1);
				}
				
}
}
print n(-4.6);

//вместо функции теперь цикл рекурсия для цикла те факториал считается с начала 1*2*3*4
$s = 6.2;
settype($s, "integer"); //принудительный тип
$a = $s;
$i = 1;
if($s>0)
	{
		while ($i < $s)
		{
		$a *= $i;
		$i = $i + 1 ;
		}
	}
		else
		{
		$i=-1;
			while ($i > $s)
			{
			$a *= $i;
			$i = $i - 1 ;
			}
		$a *=-1;
		}
 print "<br>" . $a ;



$s = -2;
$a = -1;
print "<br>" . $s*$a;
?>
