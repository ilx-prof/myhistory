<?php
//print_r ($_POST);
//Принемаем переданные переменные
$skoko = $_POST['skoko']['skoko'];
$directoria = $_POST['skoko']['directoria'];
$ogran = $_POST['skoko']['ogran'];
//создаем переданную директорию
if(!is_dir($directoria))
{
	if (mkdir ($directoria,0700))
	{
		print "<h1>Создаеться ".$skoko." Файлов</h1> в директории F:\\WebServers\\home\\Poisc\\www\\".$directoria;
	}
}

//определяем дату события
$today = date("F j, Y, g:i a"); 

//устанавливаем перменную количества файлов как целое число
Settype ($skoko,"integer");

//опероделяем var для "удобства"
$dop='a+';//пробует создать файл Открывает файл для чтения и записи -- указатель в конец файла. Если файл не существует - пытается его сздать. 
$rem='w+';//пробует создать файл открывает для чтения и записи и обрезает файл до нулевой длинны

//Создаем функцию
function add($name,$dop)
	{
//открываем дескриптор файла и пишем переменную в файл через энтер
		$fil=Fopen("log.txt",$dop);
		fwrite($fil,$name);
		fwrite($fil,"
");
		print "<br> add in log.txt -->- ".$name;
//закрывае дескриптор
		fclose ($fil);
	}
	
//Функция времени
function stime() 
		{ 
  			  list($usec, $sec) = explode(" ", microtime()); 
  			  return ((float)$usec + (float)$sec); 
		}

//устанавоиваем вспомогательную переменную
$a=0;
$ogidanie = 0;
//пока переменная $a меньше $skoko выполнять
$Start_time = stime();

while($a<$skoko)
{
if( $ogidanie < $ogran)
{
		//устанавливаем имя файла
		$neme=$directoria."\\".rand().".php";
		// увеличить в каждом цикле а 
				//если произошло копирование выполнить
		if (copy("avil.php",$neme))
		{
			print "<br>создал файл с именем - |".$neme."|";
			$a++;
			//записываем имя файла в лог
			add($neme,$dop);
		}
$Stop = stime();
$ogidanie = $Stop-$Start_time;
print "<h3>за $ogidanie сек $a файлов </h3>";
}
else{break;}
}
$Stop_time = stime();
print "<br>Создание файлов длилось ".($Stop_time-$Start_time)."sek из возможных $ogran sek <br> создано $a файлов из $skoko ";
//считываем файл в массив и выводим первый элемент


$s = file("StatusCreit.txt");
	$colvo = $s[0]+$a;
	
$stat = fopen("Status.txt", $dop);
	Fwrite ($stat,$today." создано ".$a." Файлов
");
fclose($stat);

$stat=Fopen("StatusCreit.txt",$rem);
	fwrite($stat,$colvo);
		print "<br>Фаил статуса обзовлен";
fclose($stat);
print "<br>Этим скриптом создано уже более <a href=\"Status.php\">".$colvo."</a> файлов";


?>
<a href="dir.php"><br>Обзор содержимого папки</a>
<a href="Status.php"><br>Статус</a>
<a href="index.php"><br>Вернуться</a>
<a href="log.txt"><br>Посмотреть log.txt</a>

