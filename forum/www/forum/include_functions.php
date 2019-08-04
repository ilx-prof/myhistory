<?php


function get_var_expload_AVTOR($way)
{
	if ( file_exists($way))
	{
		$Options = explode("_===++||||++===_",file_get_contents ($way));
		$Options = array('nic'=>$Options{0},'mail'=>$Options{1},'cat'=>$Options{2},'dey'=>$Options{3},'other'=>$Options{4});
		return $Options;
	}
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
	
	if(count($arrayzs)==($AZ=count($arrayr)))
	{
		$neme_patt=&$file;
		for ($i=0;$i<$AZ;$i++)
		{
			$neme_patt=str_replace ( $arrayzs[$i],$arrayr[$i],$neme_patt);
		}
		return $neme_patt;
	}
	else
	{
		return False;
	}
}
function print_cat($WAY)
{
	$CAT=map_tems_categories($WAY,false);
	$content="";
	if ($CAT)
	{
		while (next($CAT))
		{
			$Categoria=prev($CAT);
			if (!is_array($Categoria) )
			{
				if(file_exists($WAY."GLOBALS"))
				{
					$avtor_cat=(get_var_expload_AVTOR($CAT[current($CAT)][0]));//$CAT[current($CAT)][0];
					$Rplese_blok=array ($Categoria
										,"<a href=\"forum.php?SHOW=$Categoria&delay=Categoria\">".$avtor_cat['cat']."</a>"
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										,$avtor_cat['dey']);
					$content.=translete_allay ("blok.php",$Rplese_blok);
				}
				elseIF(file_exists($WAY."Avtor_cat.rul"))
				{
					$avtor_cat=(get_var_expload_AVTOR($CAT[current($CAT)][0]));
					$Rplese_blok=array ($Categoria
										,"<a href=\"forum.php?SHOW=$WAY$Categoria&delay=tems\">".$avtor_cat['cat']."</a>"
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										,$avtor_cat['dey']);
					$content.=translete_allay ("blok.php",$Rplese_blok);
				}
				elseIF(file_exists($WAY."Avtor_tems.rul"))
				{
					$avtor_cat=(get_var_expload_AVTOR($CAT[current($CAT)][0]));
					$Rplese_blok=array ($Categoria
										,"<a href=\"forum.php?SHOW=$WAY$Categoria&delay=tems\">".$avtor_cat['cat']."</a>"
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										,$avtor_cat['dey']);
					$content.=translete_allay ("blok.php",$Rplese_blok);
				}
				else
				{
					return (false);
				}
			}
			next($CAT);
		}
		return ($content);
	}
	else
	{
	return (false);
	}
}



FUNCTION delay()
{
	if (isset($_GET["delay"]) && isset($_GET["SHOW"]))
	{
		if ($_GET["delay"]=="Categoria")
		{
			if($_GET["SHOW"]!=".." && $_GET["SHOW"]!="." && is_dir ("Categoria/".$_GET["SHOW"]) && is_file("Categoria/".$_GET["SHOW"]."/Avtor_cat.rul") )
			{
				return print_cat("Categoria/".$_GET["SHOW"]."/");
			}
			else
			{
				return "необнаружена категория".$_GET["SHOW"];
			}
		}
		elseif($_GET["delay"]=="tems")
		{
			if($_GET["SHOW"]!=".." && $_GET["SHOW"]!="." && is_dir ($_GET["SHOW"]) && is_file ($_GET["SHOW"]."/Avtor_tems.rul"))
			{
				return out_put_tema(print_temses($_GET["SHOW"],false), false)."<table><tr><td><a href=\"forum.php\">Назад</a></td></tr></table>";// print_cat("Categoria/");//"печать темы ".$_GET["SHOW"];
			}
			else
			{
				return "Ненайдена тема ".$_GET["SHOW"];
			}
		}
		else
		{
			return "неверный запрос-|".$_GET["delay"]."|";
		}
	}
	else
	{
		return print_cat("Categoria/");
	}
}


Function print_temses($WAY,$INP)
{
	ob_start ();
	if (is_dir($WAY))
	{
		if ($dh = opendir($WAY))
		{
			print "<br><br>Это директория ".$WAY."<br>";
			if( file_exists( $WAY."/Avtor_tems.rul") && file_exists($WAY."/".basename($WAY).".txt"))
			{
				print "<br>Фаил создателя категории существует ".$WAY."/Avtor_tems.rul<br>";
				print "<br>Найден первый файл ".$WAY."/".basename($WAY).".txt"."<br>";
				$soft[basename($WAY)][0]="";
				$i=1;
				while (false !== ($file = readdir($dh)))
				{
					if ($file != "." && $file != ".." && $file != "Avtor_tems.rul" && $file != "Scaler.sc" && $file!= "SNIF.snif" && $file!= basename($WAY).".txt")
					{
						
						print "ответ nomer - $i-|".$file."|<br>";
						$soft[basename($WAY)][]=$WAY."/".$file;
						//$soft[$file][]=map_tems ($WAY,$file,$fileL);
						$i++;
					}
				}
				sort($soft[basename($WAY)]);//только для unix
				reset($soft[basename($WAY)]);//только для unix
				Closedir($dh);
				$soft[basename($WAY)][0]=$WAY."/".basename($WAY).".txt";
			}
		}
	}
	print_r ($soft);
	$INPUT = ob_get_clean ( );
	IF ($INP==TRUE)
	{
		PRINT $INPUT;
	}
	if (isset($soft)&&is_array($soft))
	{
		return $soft;
	}
}

function out_put_tema($WAY,$INP)
{
	if(is_string($WAY))
	{
		$CAT=map_tems_categories($WAY,true);
	}
	elseif(is_array($WAY))
	{
		$CAT=$WAY;
	}
	$content="";
	if ($CAT)
	{
		reset($CAT);
		while (pos($CAT))
		{
			$Categoria=prev($CAT);
			if (!is_array($Categoria) )
			{
				IF(is_array($WAY))
				{
					foreach ($CAT as $key => $val)
					{
						foreach ($CAT[$key] as $keyy => $vall)
						{
							$avtor_cat=get_var_expload_AVTOR($CAT[$key][$keyy]);
							if ($keyy==0)//для автора темы
							{
										$Rplese_blok=array ($key
										,$avtor_cat['other']
										,$avtor_cat['dey']
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										);
							}
							else//для ответов
							{
										$Rplese_blok=array (""
										,$avtor_cat['other']
										,$avtor_cat['dey']
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										);
							}
							$content.=translete_allay ("blok.php",$Rplese_blok);
						}
					}
				}
				ELSEif(file_exists($WAY."GLOBALS"))
				{
					$avtor_cat=(get_var_expload_AVTOR($CAT[current($CAT)][0]));//$CAT[current($CAT)][0];
					$Rplese_blok=array ($Categoria
										,"<a href=\"forum.php?SHOW=$Categoria&delay=Categoria\">".$avtor_cat['cat']."</a>"
										,$avtor_cat['dey']
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										);
					$content.=translete_allay ("blok.php",$Rplese_blok);
				}
				elseIF(file_exists($WAY."Avtor_cat.rul"))
				{
					$avtor_cat=(get_var_expload_AVTOR($CAT[current($CAT)][0]));
					$Rplese_blok=array ($Categoria
										,"<a href=\"forum.php?SHOW=$WAY$Categoria&delay=tems\">".$avtor_cat['cat']."</a>"
										,$avtor_cat['dey']
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										);
					$content.=translete_allay ("blok.php",$Rplese_blok);
				}
				elseIF(file_exists($WAY."Avtor_tems.rul"))
				{
					$avtor_cat=(get_var_expload_AVTOR($CAT[current($CAT)][0]));
					$Rplese_blok=array ($Categoria
										,"<a href=\"forum.php?SHOW=$WAY$Categoria&delay=tems\">".$avtor_cat['cat']."</a>"
										,$avtor_cat['dey']
										,'<font face="Comic Sans MS" size="-2" align="center">'.$avtor_cat["nic"].' '. $avtor_cat["mail"].'</font>'//тут должна быть ссылка на почту и инфру про юзера
										);
					$content.=translete_allay ("blok.php",$Rplese_blok);
				}
				else
				{
					return (false);
				}
			}
			next($CAT);
			next($CAT);
		}
		return ($content);
	}
	else
	{
	return (false);
	}
}


function map_tems_categories ($WAY,$INP)
{
	ob_start ();
	$a=0;
	if (is_dir($WAY))
	{
		if ($dh = opendir($WAY))
		{
			while (false !== ($file = readdir($dh)))
			{
				if ($file != "." && $file != ".." && $file != "Avtor_cat.rul"&& $file != "Scaler.sc" && $file!= "SNIF.snif" )
				{print "да<br>";
					if (file_exists($WAY."/".$file."/Avtor_cat.rul"))
					{
						print "<br><br>Это директория ".$WAY.$file."<br>";
						print "<br>Фаил создателя категории существует ".$WAY.$file."/Avtor_cat.rul<br>";
						print "Глобальная категория - <h3>".$file."</h3>";
						$soft[]=$file;
						$soft[$file][0]=$WAY.$file."/Avtor_cat.rul";
						//$soft[$file][]=map_tems ($WAY,$file,$fileL);
					}
					if (file_exists($WAY."/".$file."/Avtor_tems.rul"))
					{
						print "<br><br>Это директория ".'$WAY/$file'."<br>";
						print "<br>Фаил создателя категории существует ".'$WAY/$file'."/Avtor_tems.rul<br>";
						print "Глобальная категория - <h3>".$file."</h3>";
						$soft[]=$file;
						$soft[$file][0]=$WAY."/".$file."/Avtor_tems.rul";
						//$soft[$file][]=map_tems ($WAY,$file,$fileL);
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
	if (isset($soft))
	{
		return $soft;
	}
	else
	{
		return false;
	}
}
?>

