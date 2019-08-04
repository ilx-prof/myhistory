<?php 
//Резервное копирование файлов
	copy("reg.php","reg1.bac");
if(isset($_POST['Reg']['delay']) and $_POST['Reg']['delay'] =="Delay")
{
//определяем перменные
$dir = dirname (__FILE__)."\\Uzerconfig\\";
$data = date("F j, Y, g:i a");
$Nic = ( $_POST['Reg']['Nic']);
$parol = $_POST['Reg']['Login'];
$povtorparol = $_POST['Reg']['Loginp'];
$mail = $_POST['Reg']['mail'];
$pol = $_POST['Reg']['pol'];
$Age = $_POST['Reg']['Age'];Settype($Age,'double');
$logo = $_POST['Reg']['logo'];
$FNic = $Nic.".ini";
//функция регистрации в быстром файле
function add($Nic,$dop)
{
	$fil=Fopen("Infuser.ini",$dop);
	fwrite($fil,$Nic);
	fwrite($fil,"
");
	fclose ($fil);
}
//ФУНКЦИИ ПРОВЕРКИ ЗНАЧЕНИЙ
//Функция неполной проверки посылаемых данных

function Check_post($Nic,$parol,$povtorparol,$mail,$Age)
{
	if (empty($Nic) or empty($parol) or empty($povtorparol) or empty($mail) or $parol<>$povtorparol or ($Age < 5 and $Age > 0 or $Age < 0))
	{
		print "<h3>Ошибка!</h3><br>";
		if (empty($Nic))
		{
			Print "<font color=\"#ff0000\">Неуказан ник</font><br>";
		}
		if (empty($parol))
		{
			print "<font color=\"#ff0000\">Неуказан пароль</font><br>";
		}
		if (empty($povtorparol))
		{
			print "<font color=\"#ff0000\">Пароль не поттвержден</font><br>";
		}
		if (empty($mail))
		{
			print "<font color=\"#ff0000\">Неуказан почтовый адрес</font><br>";
		}
		if ($parol <> $povtorparol)
		{
			print "<font color=\"#ff0000\">Несовпадают пароли |$parol|<>|$povtorparol|</font><br>";;
		}
		if ($Age < 5 and $Age > 0 or$Age < 0)
		{
			print"<font color=\"#ff0000\">Указан неверный возраст |$Age|</font><br>";
			print"<font color=\"#ff0000\"><h2>Кыш от компа хм.. мелочь</h2></font><br>";
		}	

		return false;
	}
}
//Проверка пути лого
function Check_logo($logo)
{
	$net = "Есть лого";
	if(false==empty($logo))//..если переменная лого не пустой
	{
		if (false==file_exists($logo))//и если файла нет то
		{
			$net = false ;
			print "<font color=\"#ff0000\">Указанный вами файл не сушествует </font><br>";
			
		}
		else{print "Файл вашего лого $logo<br>";}
	}
	else
	{
		$net = true;
		print "<br>У вас Нет фотки но вы всегда сможете ее добавить<br>";
	}
	return $net;
}
//Функция ппроверяет фолможность создания директории на сервере
function cehek_dir($dir,$Nic)
{
	if(!is_dir($dir))
	{
		print "<br><h4>Это первое посешение по данной форме</h4><br>";
		
		if(mkdir($dir,0700))
		{
			print "<br><h2><font color=\"#B8323C\">Heloy. $Nic you first uzer on this site</font></h2><br>";
		}
		else
		{
			print "<br>I/'m Sory. Произошла административная ошибка обратитесь за помошью к разарботчикам<br>";
			return false;
		}
	}
	else{return true;}
}
//проверка сушествования в директории файла юзера при удачном исходе true
function check_user($dir,$FNic)
{
$return=true;
	if ($open_dir = opendir($dir))
	{
		$return=true;
  		while (false !== ($file = readdir($open_dir)))
		{
			if($FNic == $file)//Как ты помниш $FNic это файл юзверя
			{
			print "<font color=\"#ff0000\">Данный пользователь уже зарегистрирован</font><br>";
			$return=false;
		break;
			}
	}
	closedir($open_dir);
return $return;
}
	
	{
		print "<br>I/'m Sory. Произошла системная ошибка n\ если вас чтото неустаевает обратитесь за помошью к разарботчикам<br>";
		return false;
	}
}
//Функця возврашает провереныые и исправоенные переменные возраста пола и окончания слова
Function check_pol_vosr($Age,$pol)
{
	if(0 == $Age)
	{
		$Age="неуказан.";
	}
	else {$Age=$Age." лет";}
		if("men"==$pol)
	{
		$pol="Мужской";
	$oc="ой";
		}
	else {$pol="Женский";$oc="ая";}
	$pol_Age_oc=array("pol"=>$pol,"age"=>$Age,"oc"=>$oc);
	return $pol_Age_oc;
}
//функция выполяет запись в файл конечной пользовательской информации 
function creat_file_uzer($Nic,$FNic,$dir,$parol,$mail,$pol,$logo,$oc,$Age,$data)
{
	$dop='a+';
	$rem='w+';
	if ($Fneme = @Fopen($dir.$FNic,$rem))
	{
	
	
	
	//Как ты помниш $FNic это файл юзверя
	/*if(false==Check_logo($logo) or true==Check_logo($logo))
	{
		$logo="Нет изображения";
		print "<h1>$logo</h1>";
	}*/
	if(@fwrite($Fneme,$parol."_===++||||++===_".$mail."_===++||||++===_".$pol."_===++||||++===_".$Age/*." ".$logo*/))
	{
		add($Nic,$dop);
		print "<br>$data --><h3> Дорог$oc <font color=\"#008080\">$Nic.<font></h3> Поздравляю Вас, \n Вы толькочто зарегистрировались на нашем сайте. Ваш возраст $Age<br>";
		return true;
	}else { print "<br>I/'m Sory. Произошла административная ошибка возможно в имени пользователя присутствуют недопустимые символы ?:%;№\"\'!%:?()_+=\\ \n попытайтесь ввести имя без этих символов \n в случае если это не поможет обратитесь за помошью к разарботчикам<br>";}
	
	}else {print "<br>I/'m Sory. Произошла административная ошибка возможно в имени пользователя присутствуют недопустимые символы ?:%;№\"\'!%:?()_+=\\ \n попытайтесь ввести имя без этих символов \n в случае если это не поможет обратитесь за помошью к разарботчикам<br>";}
}
//Функция печатает список всех доступных пременных
function print_VAR()
{
	$a = array_slice (get_defined_vars(),13);
	print_r (array_keys($a));
	$a = get_defined_functions();
	print_r ($a['user']);
}


//Function PROGRAM
function Vipolnit_ssript($Nic,$parol,$povtorparol,$mail,$dir,$FNic,$Age,$pol,$logo,$data)
{
if (FALSE!==Check_post($Nic,$parol,$povtorparol,$mail,$Age))
{
	//print "Проверка первых параметров завершена";
	//Check_logo($logo);
	cehek_dir($dir,$Nic);
	if (true == check_user($dir,$FNic))
	{
		$temp = check_pol_vosr($Age,$pol);
		
		$pol=$temp['pol'];
		$Age=$temp['age'];
		$oc=$temp['oc'];
		
		if(true==creat_file_uzer($Nic,$FNic,$dir,$parol,$mail,$pol,$logo,$oc,$Age,$data))
		{ //print "Проверка данных завершена, добавлен новый пользовательы";
			return true;
		}
	}
}
}




}
?>

<body bgcolor="#DEE2EB">
<table align="center" border="1" bordercolor="#c0c0c0" bgcolor="#B9D8E6">
	<tr><td>
		<P align="center"> <font color="#303263" face="Comic Sans MS">&nbsp;&nbsp; Зарегистригуйте нового пользователя <br>или войдите через <a href="index.php" ><font color="#EAF2F2">главную страницу</font></a> &nbsp;&nbsp;</font></P>
	</td></tr>
	<tr><td align="center">
		<p align="center"><font face="Comic Sans MS">Заполните следуюшюю форму</font></p>
<font face="Comic Sans MS" color="#453573" >
<form action="reg.php" method="post">
<input  type="Hidden" name="Reg[delay]" value="Delay" >
	Ник* <input type="Text" name="Reg[Nic]" maxlength="20" value="<?php print rand (1,9999999999999);?>"><br><br>
	Пароль* <input type="Password" name="Reg[Login]" maxlength="30" value="<?php $print=rand (1,9999999999999); print $print?>"><br><br>
	Еше раз* <input type="Password" name="Reg[Loginp]"maxlength="30" value="<?php  print $print;?>"><br><br>
	E-mail* <input type="Text" name="Reg[mail]"maxlength="30" value="<?php print rand (1,9999999999999)."@".rand (1,9999).".ru";?>"><br><br>
	Укажите пол <select size="1" name="Reg[pol]">
									<option value="men" >Мужской</option>
									<option value="women">Женский</option>
								  </select>
	&nbsp;&nbsp;&nbsp;&nbsp;Возраст <input type="Text" size="2" name="Reg[Age]" maxlength="2"  value="<?php print rand (6,99);?>"><br><br>
<input type="Hidden" name="Reg[logo]" >
		<input  type="Submit" value="Зарегистрироваться">
</form>
</font>
</table>
<table bgcolor="#E7F3FE" border="1" bordercolor="#c0c0c0" width=600 align="center">
	<tr align="center"><td align="center">
<pre>
<?php
print "<font face=\"Comic Sans MS\"><h2>Консоль событий</h2><font>";
if (@!empty($_POST['Reg']['delay']))
{
	Vipolnit_ssript($Nic,$parol,$povtorparol,$mail,$dir,$FNic,$Age,$pol,$logo,$data);
}
?>
<br><font face="Comic Sans MS" point-size="7">Со всеми вопреосами обрашаться по адресу <a href="ilx666@mail.ru"><font color="#0000ff">ilx666@mail.ru</font></a></font></pre>
	</td>	</tr>
</table>
</body>