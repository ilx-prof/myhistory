<?php
/*function translete_to_pattern($replese,$conteint,$neme_patt)
{
	if($neme_patt=file ($neme_patt))
	{
		$neme_patt=str_replace ("<!--==".$replese."==-->",$conteint,$neme_patt);
		$neme_patt=implode ("",$neme_patt);
			return $neme_patt;
	}
	else
	{
	return false;
	}
}
function translete_HEADlist ($forum,$Conteint_list,$Infra_list)
{
$List=translete_to_pattern("FORUM","$forum","forms/list.php");
$List=translete_to_pattern("Conteint_list","$Conteint_list","$List");
$List=translete_to_pattern("Infra_list","$Infra_list","$List");
return $List;
}*/

/*
function map_tems1 ($WAY,$file,$fileL)//Походу создание карты массива со следующими параметрами
{
	if ($dd = opendir($WAY.$file))
	{
		print "<br>открыл директорию - ".$WAY.$file;
		while (false !== ($fileL = readdir($dd)))
		{
			if ($fileL!= "." && $fileL != "..")
			{
				if (TRUE==is_dir($WAY.$file."\\".$fileL))
				{
					$soft[$file][]=$fileL;
					print "<br>Это директория ".$WAY.$file."\\".$fileL."<br>";
					if ($fd = opendir($WAY.$file."\\".$fileL))
					{
						while (false !== ($fileLL = readdir($fd)))
						{
							if (TRUE==is_file($WAY.$file."\\".$fileL."\\".$fileLL))
							{
								$soft[$file][$fileL][]=$fileLL;
				//print "<br>Файл данных найден ".$WAY.$file."\\".$fileL."\\".$fileLL;
								if($fileLL=="Avtor_tems.rul")
								{
									print $WAY.$file."\\".$fileL."\\".$fileLL."- это Файл который содержит инфру про раздел <br>";
								}
								elseif($fileLL=="SNIF.snif")
								{
									print $WAY.$file."\\".$fileL."\\".$fileLL."- это Файл который содержит инфру про посешения<br>";
								}
									elseif($fileLL=="Scaler.sc")
								{
									print $WAY.$file."\\".$fileL."\\".$fileLL."- это Файл который содержит инфру про количеству просмотров <br>";
								}
								else
								{
									print $WAY.$file."\\".$fileL."\\".$fileLL." - Фаил Ответов<br>";
									//unlink($WAY.$file."/".$fileL);
								}
							}
						}
						Closedir($fd);
					}
					return $soft;
				}
			}
		}
		Closedir($dd);
	}
}
*/
/*function map_categories ($INP)//вуаля создание массива форума ипа название категории ее краткое описание
{
	ob_start ();
	$a=0;
	$WAY="Categoria/";
	if (is_dir($WAY))
	{
		if ($dh = opendir($WAY))
		{
			while (false !== ($file = readdir($dh)))
			{
				if ($file != "." && $file != "..")
				{
					if (TRUE==is_dir($WAY.$file) && file_exists($WAY.$file."/Avtor_cat.rul"))
					{
						print "<br><br>Это директория ".$WAY.$file."<br>";
						print "<br>Фаил создателя категории существует ".$WAY.$file."/Avtor_cat.rul<br>";
						print "Глобальная категория - <h3>".$file."</h3>";
						$soft[]=$file;
						$soft[$file][0]=$WAY.$file."\\Avtor_cat.rul";
//						$soft[$file][]=map_tems ($WAY,$file,$fileL);
					}
				}
			}
			Closedir($dh);
		}
	}
	$INPUT = ob_get_clean ( );
	IF ($INP==TRUE)
	{
		PRINT $INPUT;
	}
	return $soft;
}*/
/*function print_tems($wey)
{
	$CAT=map_tems(false);
	$content="";
	while (next($CAT))
	{
		$Categoria=prev($CAT);
		if (!is_array($Categoria) )
		{
			$avtor_cat=(get_var_expload_AVTOR($CAT[current($CAT)][0]));//$CAT[current($CAT)][0];
			$Rplese_blok=array ($Categoria
					,$avtor_cat['cat']
					,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
					,$avtor_cat['dey']);
			$content.=translete_allay ("blok.php",$Rplese_blok);
		}
		next($CAT);
	}
	return ($content);

}*/
/*
function map_tems1w ($WAY)
{
	if ($dd = opendir($WAY))
	{
		print "<br>открыл директорию - ".$WAY;
		while (false !== ($fileL = readdir($dd)))
		{
			if ($fileL!= "." && $fileL != "..")
			{
				if (TRUE==is_dir($WAY."\\".$fileL))
				{
					$soft[]=$fileL;
					print "<br>Это директория ".$WAY."\\".$fileL."<br>";
					if ($fd = opendir($WAY."\\".$fileL))
					{
						while (false !== ($fileLL = readdir($fd)))
						{
							if (TRUE==is_file($WAY."\\".$fileL."\\".$fileLL))
							{
								$soft[$fileL][]=$fileLL;
				//print "<br>Файл данных найден ".$WAY.$file."\\".$fileL."\\".$fileLL;
								if($fileLL=="Avtor_tems.rul")
								{
									print $WAY."\\".$fileL."\\".$fileLL."- это Файл который содержит инфру про раздел <br>";
								}
								elseif($fileLL=="SNIF.snif")
								{
									print $WAY."\\".$fileL."\\".$fileLL."- это Файл который содержит инфру про посешения<br>";
								}
									elseif($fileLL=="Scaler.sc")
								{
									print $WAY."\\".$fileL."\\".$fileLL."- это Файл который содержит инфру про количеству просмотров <br>";
								}
								else
								{
									print $WAY."\\".$fileL."\\".$fileLL." - Фаил Ответов<br>";
									//unlink($WAY.$file."/".$fileL);
								}
							}
						}
						Closedir($fd);
					}
					return $soft;
				}
			}
		}
		Closedir($dd);
	}
}
*/
?>

