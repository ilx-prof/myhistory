<?php
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$tstart = $mtime; 
require("config.php");//Файл настроек

//сбор информации о клиенте
	if (!is_dir("messages/$door/snif"))mkdir("messages/$door/snif",0777);
	$fileName="messages/$door/snif/$show.snif"; //имя файла со статистикой
	include("sniffer.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=Windows-1251">
	<META NAME="page-topic" CONTENT="СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум"> 
	<META NAME="title" CONTENT="СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум">
	<META NAME="description" CONTENT="Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.">
	<META NAME="abstract" CONTENT="Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.">
	<META Name="keywords" Content="реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты">
	<META NAME="revisit" CONTENT="15 days">
	<META NAME="revisit-after" CONTENT="15 days">
	<META NAME="Content-Language" CONTENT="english">
	<META NAME="audience" CONTENT="all">
	<META NAME="robots" CONTENT="index,all">
	<META NAME="Author" CONTENT="Denis Korneev, Copyright 2003-2005 - fuzzy@worldkr.fatal.ru">
	<META NAME="Copyright" CONTENT="Denis Korneev - fuzzy@worldkr.fatal.ru">
	<META NAME="Reply-to" CONTENT="fuzzy@worldkr.fatal.ru">
	<META NAME="home_url" CONTENT="http://www.worldkr.fatal.ru/index.php">
	<META NAME="Generator" CONTENT="Notepad!">
	<META NAME="distribution" CONTENT="Global"> 
	<META NAME="rating" CONTENT="General">
	<META NAME="site-created" CONTENT="25-08-2003">
<link rel='STYLESHEET' type='text/css' href='style.css'>
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<script src="ban.js" type="text/javascript"></script>
<?php 
error_reporting (E_ALL);

## /* Проверка на COOKIES данные(существуют в базе данных или нет) */ ##
$dogg[0]=null; $dogg[1]=null; $dogg[2]=null;
$addform="hide";
$tochno="no";
$anon="no";
if (!empty($_COOKIE["Worldkr"])):
	$dogg=explode("||",$_COOKIE["Worldkr"]);
	$dogg[0]=strtolower($dogg[0]);
	$dogg[1]=strtolower($dogg[1]);
	$file="reg/$dogg[0].txt";
	if (file_exists($file)){
		$fq=file($file);
		$v=explode("|",$fq[1]);
		$v[1]=strtolower($v[1]);
			if ($dogg[1]==$v[1]){
			$tochno="yes";
			$addform="show";
				if ($dogg[0]=='31}3e}3f}3e}3p}3d}')$anon="yes";
			$vn=explode("|",$fq[0]);
			$admin=$dogg[0];
			$dogg[0]=$vn[1];
			}
	}
endif;



//Простая проверка на существование заданной темы. Просто если кто-то зайдет по ссылке с несуществующей темой, то
//ему выдастся соответствующее сообщение.
if ((isset($show))&&(ereg("[0-9]",$show))&&(is_file("messages/$door/$show.txt"))){
	//счетчик посещений
	$filename = "messages/$door/dat/$show.dat";
		if (file_exists($filename)){$fp = fopen($filename,"r");
			$counter=fgets($fp,10);
			$counter=$counter+1;
			fclose($fp);
			$fp=fopen($filename,"r+");
			fwrite($fp,$counter);
			fclose($fp);
		}
		else
		{
			$fa = fopen($filename,"w+");
			$counter=1;
			fwrite($fa,$counter);
			fclose($fa);
		}

	//Вывод темы
	$fp=file("messages/$door/$show.txt");//Открытие файла с темой
	$kol=count($fp);//Чтение количества сообщений в файле

	//Оранжевый
	$fp=str_replace("[color=o0]","<font color=\"#bf4000\">",$fp);
	$fp=str_replace("[color=o1]","<font color=\"#d85900\">",$fp);
	$fp=str_replace("[color=o2]","<font color=\"#f17200\">",$fp);
	$fp=str_replace("[color=o3]","<font color=\"#ff8040\">",$fp);
	$fp=str_replace("[color=o4]","<font color=\"#ff9959\">",$fp);
	$fp=str_replace("[color=o5]","<font color=\"#ffb272\">",$fp);

	//Красный
	$fp=str_replace("[color=r0]","<font color=\"#500000\">",$fp);
	$fp=str_replace("[color=r1]","<font color=\"#690000\">",$fp);
	$fp=str_replace("[color=r2]","<font color=\"#820000\">",$fp);
	$fp=str_replace("[color=r3]","<font color=\"#9b0000\">",$fp);
	$fp=str_replace("[color=r4]","<font color=\"#b40000\">",$fp);
	$fp=str_replace("[color=r5]","<font color=\"#cd0000\">",$fp);

	//Зеленый
	$fp=str_replace("[color=g0]","<font color=\"#005000\">",$fp);
	$fp=str_replace("[color=g1]","<font color=\"#006900\">",$fp);
	$fp=str_replace("[color=g2]","<font color=\"#008200\">",$fp);
	$fp=str_replace("[color=g3]","<font color=\"#009b00\">",$fp);
	$fp=str_replace("[color=g4]","<font color=\"#00b400\">",$fp);
	$fp=str_replace("[color=g5]","<font color=\"#00cd00\">",$fp);

	//Пурпурный
	$fp=str_replace("[color=p0]","<font color=\"#500050\">",$fp);
	$fp=str_replace("[color=p1]","<font color=\"#690069\">",$fp);
	$fp=str_replace("[color=p2]","<font color=\"#820082\">",$fp);
	$fp=str_replace("[color=p3]","<font color=\"#9b009b\">",$fp);
	$fp=str_replace("[color=p4]","<font color=\"#b400b4\">",$fp);
	$fp=str_replace("[color=p5]","<font color=\"#cd00cd\">",$fp);

	//Аквамариновый
	$fp=str_replace("[color=a0]","<font color=\"#005050\">",$fp);
	$fp=str_replace("[color=a1]","<font color=\"#006969\">",$fp);
	$fp=str_replace("[color=a2]","<font color=\"#008282\">",$fp);
	$fp=str_replace("[color=a3]","<font color=\"#009b9b\">",$fp);
	$fp=str_replace("[color=a4]","<font color=\"#00b4b4\">",$fp);
	$fp=str_replace("[color=a5]","<font color=\"#00cdcd\">",$fp);

	//Синий
	$fp=str_replace("[color=b0]","<font color=\"#000050\">",$fp);
	$fp=str_replace("[color=b1]","<font color=\"#000069\">",$fp);
	$fp=str_replace("[color=b2]","<font color=\"#000082\">",$fp);
	$fp=str_replace("[color=b3]","<font color=\"#00009b\">",$fp);
	$fp=str_replace("[color=b4]","<font color=\"#0000b4\">",$fp);
	$fp=str_replace("[color=b5]","<font color=\"#0000cd\">",$fp);

	//Хаки
	$fp=str_replace("[color=x0]","<font color=\"#505000\">",$fp);
	$fp=str_replace("[color=x1]","<font color=\"#696900\">",$fp);
	$fp=str_replace("[color=x2]","<font color=\"#828200\">",$fp);
	$fp=str_replace("[color=x3]","<font color=\"#9b9b00\">",$fp);
	$fp=str_replace("[color=x4]","<font color=\"#b4b400\">",$fp);
	$fp=str_replace("[color=x5]","<font color=\"#cdcd00\">",$fp);

	//Фиолетовый
	$fp=str_replace("[color=f0]","<font color=\"#400080\">",$fp);
	$fp=str_replace("[color=f1]","<font color=\"#591998\">",$fp);
	$fp=str_replace("[color=f2]","<font color=\"#7232b2\">",$fp);
	$fp=str_replace("[color=f3]","<font color=\"#8b4bcb\">",$fp);
	$fp=str_replace("[color=f4]","<font color=\"#a364e4\">",$fp);
	$fp=str_replace("[color=f5]","<font color=\"#bc7dfd\">",$fp);

	$fp=str_replace("[/color]","</font>",$fp);

	//далее идет замена всех спец символов
	$fp=str_replace("[r]","<font color='#FF0000'>",$fp);
	$fp=str_replace("[y]","<font color='#FFFF00'>",$fp);
	$fp=str_replace("[w]","<font color='#3E842F'>",$fp);
	$fp=str_replace("[/c]","</font>",$fp);
	$fp=str_replace("[url]","<a href='http://",$fp);
	$fp=str_replace("[/url]","' target='_blank'><font style='font-weight:bold;'>ссылка</font></a>",$fp);
	$fp=str_replace("[смущ]","<img src='blush.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[спок]","<img src='crazy.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[хммм]","<img src='frown.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[хаха]","<img src='laugh.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[зло]","<img src='mad.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[шок]","<img src='shocked.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[улыбка]","<img src='smile.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[бебе]","<img src='tongue.gif' width='15' height='15' alt='' border='0'>",$fp);
	$fp=str_replace("[миг]","<img src='wink.gif' width='15' height='15' alt='' border='0'>",$fp);
	// замена закончилась.

	list($temaT, $dateT, $nickT, $mailT, $mesT, $rasT)=explode("|Fuz|",$fp[0]);//разделение по переменным

	#мини скриптец для определения подписи у того кто ответил:
	$size=StrLen($nickT);
	$encoded_nick=null;
	for($i=0;$i<$size;$i++) $encoded_nick.=base_convert(ord($nickT[$i]),10,32).chr(125);

	$name=strtolower($encoded_nick);
	$filename="reg/$name.txt";
	if (is_file($filename)){
		$cf=file($filename);
		$s6=explode("|",$cf[6]);//Подпись
		$podpT="<br><br><hr align=\"left\" width=\"300\"><em style=\"font-size:11px;\">".$s6[1]."</em>";
	}
	else {$podpT=' ';}

	//определение рассы.
	if (!empty($rasT)){
		if (ereg("gaal",$rasT)){$rasT="<img src='G.gif' width='66' height='34' alt='' border='0'>";}
		if (ereg("fei",$rasT)){$rasT="<img src='F.gif' width='66' height='34' alt='' border='0'>";}
		if (ereg("human",$rasT)){$rasT="<img src='H.gif' width='66' height='34' alt='' border='0'>";}
		if (ereg("malok",$rasT)){$rasT="<img src='M.gif' width='66' height='34' alt='' border='0'>";}
		if (ereg("peleng",$rasT)){$rasT="<img src='P.gif' width='66' height='34' alt='' border='0'>";}
	}
	if (!ereg("<img",$rasT)){$rasT="ПИРАТ";}

	//проверка на e-mail
	if (!eregi("^([0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-wyz][a-z](fo|g|l|m|mes|o|op|pa|ro|seum|t|u|v|z)?)$", $mailT))
	{
		$mailT="Нет электронки";
	}
	else
	{
		$mailT="<a href=\"mailto:".$mailT."\" style=\"cursor:hand;\">".$mailT."</a>";
	}

	//Обработка красного выделения у темы.
	##<font style='color:maroon;font-weight:bold;'>VS</font>##
	//Это специальная фишка. Её можно сделать, только если ты админ

	$temaT=eregi_replace("<font style='color:maroon;font-weight:bold;'>[0-9a-zA-Z]</font>","\\0",$temaT);
//	$temaT=str_replace("</font>","",$temaT);

	//заголовок страницы
	echo("
		<title>".$temaT." - Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум</title>
	</head>
	<body style='margin:30px;'>
	");

	//Собственно выводим саму тему
	if ($admin=='26}3l}3q}3q}3p}')
		echo "<a href=\"edit.php?i=0&d=edit&door=$door&fi=$show\">Редактировать</a>";
	echo ("
	<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"filter: alpha(opacity=85);\">
	<tr>
	    <td><img src=\"lvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
		<td width=\"100%\" background=\"bgF.gif\" align=\"center\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
	    <td><img src=\"pvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	<tr>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\">
		<table width=\"100%\" cellpadding=\"10\" border=\"0\">
			<tr>
				<TD colspan=\"4\" width=\"100%\" align=\"center\" valign=\"center\"><b class=\"tim\">".$temaT."</b></td>
			</tr>
			<tr>
				<TD colspan=\"4\" width=\"100%\" class=\"tema\">".$mesT."<br>".$podpT."</td>
			</tr>
			<tr>
				<td class=\"spisock\" style=\"border-bottom:0px; border-top:0px;\" width=\"15%\"><a href=\"user.php?user=".$nickT."\" style=\"cursor:hand;\"><div class=\"text\">".$nickT."</div><div class=\"shadow\" UNSELECTABLE=\"on\">".$nickT."</div></a></td>
				<td style=\"border-right: 1px solid #77959F;\" align=\"center\" width=\"10%\">".$rasT."</td>
				<td style=\"border-right: 1px solid #77959F;\" align=\"center\" width=\"30%\">".$mailT."</td>
				<td align=\"center\" width=\"30%\"><b class=\"small\">Дата и время создания: ".$dateT."</b></td>
			</tr>
		</table>
		</td>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
	</tr>
	");

	//Далее пошло разделение на страницы. если разделение не нужно, то производятся соответствующие действия
	if ($kol<=11){
		echo("
		<tr>
		    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
		    <td background=\"bgF.gif\" align=\"center\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
		    <td><img src=\"PnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
		</tr>");
	}
	else
	{
		echo("
		<tr>
		    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
		    <td background=\"bgF.gif\" align=\"center\" colspan=\"2\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
		</tr>
		");
	}

	if ($kol<=11){
		$kolvo=$kol;
	}
	else
	{
		$kolvo=11;$pages=floor(($kol-1)/10);
	}


	if (!isset($f)){
		$f=1; $from=1; $to=$kolvo;
	}
	else
	{
		$from=($f*10)-9;
			if (($f*10)>($kol-1)){
				$to=$kol;
			}
			else
			{
				$to=($f*10)+1;
			}
	}

	if (($kol-1)<=10)
	{}
	
	else
	{
		echo ("
		<tr><td colspan=\"3\">
			<table align=\"right\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"filter: alpha(opacity=85);\">
			<tr>
			    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
			    <td background=\"bgF.gif\"><em class=\"fuz\">Cтраницы: 
		");

		for ($a=1; $a<=$pages; $a++){
			if ($a==$f){
				$stul="style=\"color:Red;\"";
			}
			else
			{
				$stul='';
			}
			echo ("\n<a href=\"?show=".$show."&door=$door&f=".$a."\" $stul style=\"cursor:hand;\">=".$a."=</a>&nbsp;&nbsp;");
		}

		$os='';
		if (($kol-($pages*10)-1>0)&&($kol-($pages*10)-1<10)){
			if($f==$pages+1){
				$stul="style=\"color:Red;\"";
			}
			else
			{
				$stul='';
			}
			$dok=$pages+1;
			$os="\n<a href=\"?show=".$show."&door=$door&&f=".$dok."\" $stul style=\"cursor:hand;\">=".$dok."=</a>";
		}

		echo "$os";
		echo ("</em></td>
			<td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
			</tr>
			<tr>
			    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
			    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
			    <td><img src=\"pnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
			</tr>
			</table>
		</td></tr>");
	}

	echo ("</table><br>");

	//Файл в котором происходит вывод сообщений от указанной темы.
	include("ix-otv.php");

}
else
{
	echo ("<div align=\"center\"><font color=\"Yellow\"><h2>...Извините...<br></h2><h3>Запрашиваемая вами тема не была найдена в базе данных</h3></font></div>");
}
?>

<script type="text/javascript" language="JavaScript">
function get()
{window.open ("Forum.php", "_parent");}
</script>

<?php
//Опять же для добавления сообщения нужно зарегистрироваться.
if (($addform=='show')&&(isset($show))&&(file_exists("messages/$door/$show.txt"))){
	if (!isset($f)){
		$f=1;
	}
	if (!empty($dogg[0]))
	print "<div align=\"right\" style=\"color:yellow;\"><a href=\"addn-form.php?show=$show&ra=$door&f=$f\" style=\"cursor:hand;\">Добавить ответ</a></div>";
	echo("<br><div align=\"center\"><input class=\"fuzzy\" type=\"Button\" onclick=\"get()\" style=\"cursor:hand;\" value=\"Вернуться к списку тем\"></div>");
}
else
{
	echo("<br><br><div align=\"center\"><input class=\"fuzzy\" type=\"Button\" onclick=\"get()\" style=\"cursor:hand;\" value=\"Вернуться к списку тем\"></div>");
}
?>

<?php
if(file_exists("ban")){
	include("ban");
}
?>
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
<!-- Вычисление скорости выполнения скрипта -->
<?php
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$tend = $mtime; 
$totaltime = ($tend - $tstart); 
echo ("<font color=\"Silver\" style=\"font-size:9px;\">Страница сгенерирована за ".$totaltime." секунд!</font>");
?>
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
</body>
<!-- Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo -->
<!-- Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным. -->
<!-- реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты -->
<!-- СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум -->
</html>
