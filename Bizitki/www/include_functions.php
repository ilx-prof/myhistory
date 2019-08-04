<?php


function get_var_expload_AVTOR($way)
{
	$Options = explode("_===++||||++===_",file_get_contents ($way));
	//if (count($Options)>=4)
	//{
		$Options = array('nic'=>$Options{0},'mail'=>$Options{1},'cat'=>$Options{2},'dey'=>$Options{3},'other'=>$Options{4});
		return $Options;
	//}
	 //return False;
}

function get_var_expload_string($Options,$inc)
{
	//if (count($Options)>=4)
	//{
	$Options = explode("	",$Options);
		$Options = array('Familia'=>$Options{0},'IMA'=>$Options{1}[0],'OThestvo'=>$Options{2}[0],'mesto'=>$Options{3});
		
if(		$inc==true)
{
return $Options['mesto']."<br>".$Options['Familia']." ".$Options['IMA'].".".$Options['OThestvo'].".";
}
else
{
		return $Options;
}
	//}
	 //return False;
}

FUNCTION matrca ($arr,$sir)
{
	$count=count($arr);
	$print="<table cellpadding=\"0\" cellspacing=\"0\">";
	$i=0;
	while($i<$count-1)
	{
		$print .="<tr>";
		$a=0;
		while($a<=$sir and isset($arr[$i]))
		{
			$print .= "<td>";
			$print .= $arr[$i];
			$print .="</td>";
			$a++;
			$i++;
		}
			$print .= "</tr>";
			
	}
	$print .="</table>";
	return $print;
}

function get_string($way)
{
$f=file ($way);

foreach ($f as $key => $val )
{
  //  print $key."|".$val."<br>";
	$Print_string[]=get_var_expload_string($val,true);
}
return $Print_string ;
}
function bstavka($neme_part,$ellement)
{

	$file=file_get_contents($neme_part );
	preg_match_all("|<!---([^>]+)--->|is",$file,$reg);
	$patt=str_replace ($reg[0],$ellement, $file);
return $patt;
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
				return print_cat("Categoria/");//"печать темы ".$_GET["SHOW"];
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

function out_put_tema($WAY,$INP)
{
$CAT=map_tems_categories($WAY,true);
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

