<?php
Function nik_data ($nik)//возврашаетмассив данных юзера
{
	$hash = md5($nik);
	if (is_dir("users/".$hash))
	{
		print "Снова привет $nik";
	  $nik_data	= load_user("users/".$hash."/user.set");
	  print $nik_data;
	  return $nik_data;	
	}
	else
	{
		return  new_user($nik,$hash);
	}
}


function new_user($nik,$hash)
{
		mkdir ("users/".$hash, 0700);
		print "Приветствую новый пользователь $nik ! <br>";
		$work_nacledstvo = new_work_cenge("work");
		seve_data($work_nacledstvo,"users/".$hash."/user.set");
		return $work_nacledstvo;
}

//массив содержащий параметры начального положения рабочего -  
//здесь происходит генерация типа рабочего и его характеристик 
function new_work_cenge($delay)
{
		$work = scan_folder(dirname (__FILE__)."/$delay/");
		shuffle ($work);
		
		include ( $wey = $work[rand(0,count($work)-1)]);//Подключает файл генерирующий данные в той или иной профессии
		print "<h1>$wey</h1>";
		print_r ($work_data);
		return $work_data;
}

function seve_data($data,$wey,$metod = "w+",$perenos = "
")//сохраняет стек данных
{
print "пре $perenos нос";
	if(($file = fopen($wey,"$metod")) && fwrite($file, serialize($data).$perenos) && fclose ($file))
	{
		return "файл успешно сохранен";
	}
	else
	{
		return false;
	}
}

function load_data($way,$nomer = "all",$perenos = "
")//загружает стоку номер $nomer из файла
{
if (is_file($way))
{
	if ($nomer == "all" && $perenos =="
")
	{
		$data_file = file($way);
		unset($data_file[count($data_file)-1]);
		if (count ($data_file)>0)
		{
			foreach ($data_file as $key => $value)
			{
				$data[] = unserialize($value);
			}
			return $data;
		}
		else
		{
			print "<br>load_data ($way) -> Пустой файл<br>";
		}
	}
	elseif($nomer == "all" && $perenos !="" && $perenos !="
")
	{
		$data_file = explode($perenos,trim(file_get_contents($way)));
		unset($data_file[count($data_file)-1]);
		foreach ($data_file as $key => $value)
		{
			if ($data[$key] = @unserialize($value))
			{}
			else
			{
				print "<br>возможно неверный разделитель $perenos";
			}
		}
		return $data;
	}
	elseif ( gettype ($nomer)=="integer")
	{
		$data_file = explode($perenos,trim(file_get_contents($way)));
		if($nomer < count($data_file))
		{
			return unserialize($data_file[$nomer]);
		}
	}
	else
	{
		print "Проверьте параметры функции $nomer $perenos $wey ";
		return false;
	}
}
return false;
}



function load_user($way)//загружает стек данных
{
	if($Nic_data = file_get_contents ($way) )
	{
		  $Nic_data = unserialize($Nic_data);
	}
	else
	{
		print "Attention the user is not found";
		return false;
	}
return $Nic_data;
}


function scan_folder($wey)
{
	if ($dh = opendir($wey))
	{
   	 	while (false !== ($file = readdir($dh)))
		{
			if ($file != "." && $file != "..")
			{
				$work[]=$wey.$file;
			}
		}
		return $work = isset($work) ? $work : false;
	}
	else
	{
		return false;
	}
}

function luck ($against,$for,$happy)
{
	$start = 100;
	
	$center = $start/2+($start*$happy)/100;
	$for =rand(0,$start*($for-1)/100);
	$against = rand($center,$start-$start*$against/100);
	$resylt = rand ($for, $against+$start/4);
	//print $resylt ."-". $center;
	return $resylt  = $center > $resylt ? "good" : "Bad" ;
}

//..возврашает псевдостлучайный знак действия
function mark($p_min,$p_plus,$p_mult,$p_div,$happy)
{
	if ( luck ($p_min*$p_plus,$p_mult*$p_div,$happy) == "good" )
	{
		if (luck (rand(0,$p_mult),rand(0,$p_div),$happy) == "good")
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "*" : "/";
		}
		else
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "*" : "/";
		}
	}
	else
	{
		if (luck (rand(0,$p_min),rand(0,$p_plus),$happy) == "good")
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "+" : "-";
		}
		else
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "+" : "-";
		}
	}
	
	return $snak;
}




function translete_allay ($neme_patt,$arrayr)//..вставка  в шаблон $neme_patt параметров $arrayr
{
	$file=file_get_contents("forms/".$neme_patt );
// Не забудь разделители :)))
	preg_match_all("|<!---([^>]+)--->|is", $file, $regs );
	
// В массиве regs[0] будут находиться все свпадения с шаблоном.
// В массиве regs[1] все совпадения с первой скобкой и т.д.

	$arrayzs = array ( );
	if ( isset ( $regs[0] ) )
	{
		foreach ( $regs[0] as $key => $val )
		{
			$arrayzs[$key] = $val;
		}
	}
	$AZ=count ($arrayr);
	$neme_patt=&$file;
	for ($i=0;$i<$AZ;$i++)
	{
		$neme_patt=str_replace ( $arrayzs[$i],$arrayr[$i],$neme_patt);
	}
	return $neme_patt;
}

function General_status($Nic_data,$Nic_data_cenge)//Подщет Имя,наличность,доходы,расходы,итого приход,дата,дней до расчета,удача
{
	;
}

function charges_status($Nic_data,$Nic_data_cenge)//Подщет доходы,работа,проценты от акций,проценты по вкладам,Доход от недвижимости,Случайный доход
{
;
}

function income_status($Nic_data,$Nic_data_cenge)//Подщет Расходы,На самосодержание,На содержание семьи,На содержание имущества,Выплата кредитов,Налоги,Случайный расход
{
;
}

function common_status($Nic_data,$Nic_data_cenge)//Подщет Имушество,Недвижимость,Своих фирм,Авто,Утварь
{
;
}

function luck_status($Nic_data,$Nic_data_cenge)//Подщет Счастье/удача/ ,По доходам, По детям,По сделкам
{
;
}



function include_files_in_dir($dir)
{
	$i=0;
	if (is_dir($dir))
	{ 
	 	if ($dh = opendir($dir))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." )
				 {
					include (getcwd ()."/".$dir.$file);
					$i++;
				 }
			}
		}
	}
}


Function Nic_Creat_Cenge($wey)
{
	if ($wey <= 0)
	{
		$wey = "cenge/bad/";
		$Cenge_data = new_work_cenge($wey);
	}
	else
	{
		$wey = "cenge/good/";
		$Cenge_data = new_work_cenge($wey);
	}
}

//Функцмя удаляет пустые элементы в одномерном массиве
function perebor($arr)
{ 
	for($i=$a=0;$i<count($arr);$i++)
	{
		if (!empty($arr[$i]))
		{
			$new[$a]=$arr[$i];
			$a++;
		}
	}
	return $new;
}

?>

