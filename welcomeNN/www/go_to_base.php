<pre>
<?
ob_start ();
if ($_POST["Действие"]=="Добавить/Обновить")
{
	$Go_to_base = $_POST;
	unset ($Go_to_base['Действие']);
	unset ($Go_to_base['Тип']);
	unset ($Go_to_base['Вывести_процесс']);
	unset ($Go_to_base['type']);
	//print_R ($Go_to_base);
	$DB_type=file ("base/".$_POST["Тип"]);
	$error=false;
	foreach ($DB_type as $str => $val)
	{
		$Org_base=explode("	",$val);
		$er=0;
		$ir=0;
		foreach($Go_to_base as $keyy => $vall)
		{
				$valll=$Org_base[$ir];
				if($vall==$valll)
				{
					if(++$er==count($Go_to_base))
					{
						print "<br>В строке $str - совпали все ".(count($Go_to_base))." параметров";
						
						$Go_to_base;
						$i=0;
						foreach ($Go_to_base as $vopr => $v)
						{
							$Org_basee[]=array("$vopr"=>$Org_base[$i]);
							$i++;
						}
						$error=true;
						$WARNING[]=array("Совпадение в строке $str"=>$Org_basee);
						unset ($Org_basee);
						$er=0;
					}
				}
				$ir++;
		}
	}
	if (isset($WARNING) and $error)
	{
		print "<br><H3>Внимание элемент присутствует в списке</H3>";
		//print_r ($WARNING);
		$Bufer=ob_get_contents();
		ob_clean ();
		include ("anceta.php");
		if (isset ($_POST["Вывести_процесс"]))
		{
			print "<font color=\"#800000\">WARNING</font> возникла ошибка /данные уже присудствуют в базе/|$_POST[Тип]| - Обьект не добавлен<br>".$Bufer;
		}
	}
	else
	{
		$f=fopen("Base/".$_POST["Тип"],"a");
		$string="";
		foreach($Go_to_base as $key => $val)
		{
			$string.=$val."	";
		}
			$string.="
";
		if (fwrite($f,$string) and	fclose($f))
		{
			print "<br>Данные успешно добавлены";
		}
		else
		{
			print '<br>Фаил <font color="#ff0000" >'.$_POST['Тип'].'</font> не может быть перезаписан';
		}
		include ("anceta.php");
	}
}
?></pre>