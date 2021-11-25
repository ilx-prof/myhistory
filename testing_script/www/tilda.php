<!DOCTYPE HTML>
<html>
	<head>
   <meta charset="windows-1251">

  </head>
<body>
<pre>
<?php
	$R=rand(6,100);
	print "Cлучайное число r=".$R."<br>";
	$r=0;//счетчик уровня
	$s=1;//следуюший уровень
	$arr = range (1,$R);
	print "Лесенка по ячейкам цифр <br>";
	foreach ($arr as $key => $value)
	{
		print $value." ";
		if($r==($s-1))
		{
			print "<br>";
			$s++;
			$r=0;
		}
		else
		{
			$r++;
		}
	}
	print "<br> Строгая лесенка по строке<br>";
	$r=0;//счетчик уровня
	$s=1;//следуюший уровень
	$S="";
	foreach ($arr as $key => $value)
	{
		$S.=$value;
	}
	$S=str_split($S,1);
	foreach ($S as $key => $value)
	{
		print $value;
		if($r==($s-1))
		{
			print "<br>";
			$s++;
			$r=0;
		}
		else
		{
			$r++;
		}
	}
print "<br> <br> массив 5х7 заполненый случано от 1 до 1000<br>";
$l=7;
$s=5;
$a = array_map(function($n) { return rand(1,1000); }, range(0, $l*$s-1));
$a = array_chunk ($a,$l);
print_r ($a);
print ("<br>Сумма по строкам<br>");
$st=array_map(function($n) { return array_sum($n); },$a);
print_r ($st);
print ("<br>Сумма по столбцам<br>");
//транспонируем матрицу
array_unshift($a, null);
$a = call_user_func_array('array_map', $a);
$st=array_map(function($n) { return array_sum($n); },$a);
print_r ($st);
function ip_data($ip = 0)//Функция вернет массив с данными 
{	
	if ($ip==0)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
//	print $ip;
	$ch = curl_init('https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=' . $ip);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token f7cc45e47b3f214723acb106f9abb8660b993d57'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);
	curl_close($ch);
	$res = json_decode($res, true);
	return $res;
}
 

$switch  = ["Москва" => "8800[филиалМосква]","Санкт-Петербург" => "8800[филиалПитер]","Новосибирск" => "8800[филиалНовосибирск]"];
$res=ip_data ();
//print_r ($res);
print ("<br>Вы находитесь в ".$res["location"]["data"]["city_with_type"]."<br>");
//print ('<a href="https://www.google.com/maps/search/"'.$res["location"]["data"]["geo_lat"].",".$res["location"]["data"]["geo_lon"].'">Гдето тут на гугл карте</a><br>');
if (isset ($switch[$res["location"]["data"]["city"]]))
{
	$tel = $switch[$res["location"]["data"]["city"]];
}
else{
	$tel = $switch["Москва"];
}

print ("<br><H1>Позвоните по телефону ".$tel." </h1>");
	?>
	</body>
		</html>