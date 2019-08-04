<?php
//$dlnc=fopen("log.txt"."x+")
if (file_exists("log.txt"))
{
	print "<H1>Запущено удаление всех созданых файлов</H1>";
	//$otcr=Fopen(log.txt,"r");//открыл только для чтения
	$s = file("log.txt");
	$a = array();
		for ($i = 0; $i < count($s) ; $i++) //Чё непонятно count возврашает число строк 
		{
		//$a[] = $s[$i]; //добавляет в массив строку со следуюшем номером
			if(file_exists(trim($s[$i])))
			{
			unlink(trim($s[$i]));
			print "<br> был удален - ".$s[$i];
			}
				else
				{
				Print "<br>Файл - |".$s[$i]."несуществует" ;
				}
		}
/*
print " Чето бля зависла";
while ($i != 0)
{
--$i;
print $a[$i]."<br>";
}
}

 $path_to_php ." ". 
*/
}
ELSE
{
print "<H1>Ошибка-1 log.txt был удален или в нем не содержиться неодной строки</h1>";
}
print "<br> <H1>Удаление завершено</h1>";


$this_dir = dirname(__FILE__) ."\\";
print $this_dir."<br>";
system ($this_dir . "1.wav" );
?>
<a href="erlog.php"><br>Очистить лог</a>