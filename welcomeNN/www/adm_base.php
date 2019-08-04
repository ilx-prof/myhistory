<?
//Функия проверяет имееться ли в данном файле повторяющиеся строки
function proverca ($wey)
{
	$DB_type=file ($wey);
	$count_do=count($DB_type);
	$DB_type=array_unique ($DB_type);
	$count_posle=count($DB_type);
	$string="";
	foreach($DB_type as $key => $val)
	{
		$string.=$val;
	}
	fwrite($f=fopen ($wey, "w"),$string);
	fclose($f);
	return $count_do-$count_posle;
}
//..Функция рекурсивно удаляет пустые элементы в любом массиве массиве
function assort_matrix ($wey)
{
	$a=array();
	$arr=array_base ($wey);
	$i=0;
	$count_table=$arr[1]+1;
	$count=count($arr[0])+1;
	$arr=$arr[0];
	while($i<$count_table)
	{
		for($a=$i;$a<=$count;$a+=$count_table)
		{
			$ar [$i] [] = $arr[$a];
		}
		$i++;
	}
	revers ($ar);
	print count ($ar);
	print_r ($ar);
	//sort_base_lenivai_user ($ar,0);
	sort_Base_binary_wol ($ar,0);
	print_r ($ar);
}
//..Сотртировка массива по столбам массива методом самого ленивого пользователя (пузырьковый) где $q - номер столба
FUNCTION sort_base_lenivai_user (&$arr,$q)
{	$q0=count($arr);
	$n=count($arr[$q]);
    $i = $j = $tmp = 0;
    for($i=0; $i<=$n-1; $i++)
    {
        for($j=0; $j<=$n-2-$i; $j++)
        {
            if( $arr[$q][$j]>$arr[$q][$j+1] )
            {
                $tmp = $arr[$q][$j];//новая переменнвя
                $arr[$q][$j] = $arr[$q][$j+1];//перестановка
                $arr[$q][$j+1] = $tmp;//возврашение
				$q1=0;
				while ($q1<$q0)
				{
					if ($q1!=$q)
					{
						$tmp2 = $arr[$q1][$j];//новая переменнвя
		                $arr[$q1][$j] = $arr[$q1][$j+1];//перестановка
        		        $arr[$q1][$j+1] = $tmp2;//возврашение
					}
					$q1++;
				}
            }
        }
    }
}

//..сортировка массива по методу бинарных деревьев имени Уильяма Флойда
FUNCTION sort_Base_binary_wol (&$arr,$q)
{
	$q0=count($arr);
	$n=count($arr[$q]);
	$j=$k=$t=$tmp=0;
    if( $n==1 )
    {
        return;
    }
    $i = 2;
    do
	{
        $t = $i;
        while($t!=1)
        {
            $k = $t/2;
            if( $arr[$q][$k-1]>=$arr[$q][$t-1] )
            {
                $t = 1;
            }
            else
            {
                $tmp = $arr[$q][$k-1];//перестановка
                $arr[$q][$k-1] = $arr[$q][$t-1];//
                $arr[$q][$t-1] = $tmp;//
				$q1=0;
				while ($q1<$q0)
				{
					if ($q1!=$q)
					{
          				$tmp = $arr[$q1][$k-1];//перестановка
	              		$arr[$q1][$k-1] = $arr[$q1][$t-1];//
    	       			$arr[$q1][$t-1] = $tmp;//
					}
					$q1++;
				}
                $t = $k;
            }
        }
        $i = $i+1;
    }
    while($i<=$n);
    $i = $n-1;
    do
    {
        $tmp = $arr[$q][$i];//перестановка
        $arr[$q][$i] = $arr[$q][0];
        $arr[$q][0] = $tmp;
		$q1=0;
		while ($q1<$q0)
		{
			if ($q1!=$q)
			{
      			$tmp = $arr[$q1][$i];//перестановка
      			$arr[$q1][$i] = $arr[$q1][0];
				$arr[$q1][0] = $tmp;
			}
			$q1++;
		}
        $t = 1;
        while($t!=0)
        {
            $k = 2*$t;
            if( $k>$i )
            {
                $t = 0;
            }
            else
            {
                if( $k<$i )
                {
                    if( $arr[$q][$k]>$arr[$q][$k-1] )
                    {
                        $k = $k+1;
                    }
                }
                if( $arr[$q][$t-1]>=$arr[$q][$k-1] )
                {
                   $t = 0;
                }
                else
                {
                    $tmp = $arr[$q][$k-1];//перестановка
                    $arr[$q][$k-1] = $arr[$q][$t-1];//
                    $arr[$q][$t-1] = $tmp;//
					$q1=0;
					while ($q1<$q0)
					{
						if ($q1!=$q)
						{
							$tmp = $arr[$q1][$k-1];//перестановка
							$arr[$q1][$k-1] = $arr[$q1][$t-1];//
							$arr[$q1][$t-1] = $tmp;//
						}
						$q1++;
					}
                    $t = $k;
                }
            }
        }
        $i = $i-1;
    }
    while($i>=1);
}

//Функцмя рекурсивно удаляет пустые ветви элементов в многомерном массиве// рекурсия рулит
function revers( &$var )
{
	if( is_array ($var))
	{
		foreach($var as $key => $val)
		{
			if(is_array($val) && count ($val) != 0 )
			{
				revers( $var[$key] );
			}
			else
			{
				if ( $val == "" ||  count ($val) == 0 )
				{
					unset($var[$key]);
				}
			}
		}
	}
}

//..Функция  принимает в себя одномерный массив гда разбивает его в таблицу с указанием ее ширины
FUNCTION matrca ($arr,$sir)
{
	$count=count($arr);
	$print="<table cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#808080\" border=\"1\" >";
	$i=0;
	while($i<$count-1)
	{
		$print .="<tr>";
		$a=0;
		while($a<=$sir and isset($arr[$i]))
		{
			$print .= "<td  >";
			$print .= $arr[$i];
			$print .="</td>";
			$a++;
			$i++;
		}
			$print .= "</tr >";
			
	}
	$print .="</table>";
	return $print;
}
//..Возврашяет в перквом ключе одномерный массив всех параметров файла данных по разделителю "	" а во втором возврашяет длинну исхордной таблицы (количество параметров в одной строке)
Function array_base ($wey)
{	$String_base="";
	$file=file($wey);
	if (isset($file[0]))
	{
		$count_base=count (explode("	",$file[0]))-1;
		foreach ($file as $key => $val)
		{
			$String_base.=$val."	";
		}
		return array ($array_base=explode("	",$String_base),$count_base);
	}
	else
	{
		print "<h3>База пуста</h3>";
	}
}
?>
<a href="anceta.php">Анкета</a>
<H2>управление базой</H2>
<form action="adm_base" method="post">
<select name="Тип">
<? $i=0;
	if (is_dir(getcwd ()."/base"))
	{ 
	 	if ($dh = opendir(getcwd ()."/base"))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." && is_file(getcwd ()."/base/".$file))
				 {
					$files[]=$file;
					$i++;
				 }
			}
		}
	}
	if(empty ($_POST["Тип"]))
	{
			$_POST["Тип"]=$files[0];
	}
	$tmp = "";
	$form = $tmp;
	foreach ( $files as $id => $fname )
	{
		$select ="";
		if (isset ( $_POST["Тип"] ) && $_POST["Тип"]==$fname)
		{
			$select="selected";
		}
		$form .="	<option value=\"".$fname."\" $select>".$fname ."</option>\n";
	}
	$form .= "";
	print $form;
	
?>

</select><br><br>Действие над базой<br>
<input type="Radio" name="Действие" value="Сканировать">Сканировать<br>
<input type="Radio" name="Действие" value="Сортировать базу">Сортировать базу<br>
<input type="Radio" name="Действие" value="Проверееить на совпадения"> Проверееить на совпадения<br>
<input type="Radio" name="Действие" value="Показать в таблице">Показать в таблице<br>
<input type="Radio" name="Действие" value="Затереть">Затереть<br>
<input type="Submit" name="Подтверджение" value="Подтверждаю">
</form>

<pre>
<?
if ( isset ($_POST["Действие"]) and isset ($_POST["Подтверджение"]) and $_POST["Подтверджение"]=="Подтверждаю")
{
$wey="base/".$_POST["Тип"];
switch ($_POST["Действие"])
{
case "Сканировать":
	print "<br>Фунцкия недоступна<br>";
				break;

case "Сортировать базу":
						?>
						<form action="adm_base" method="post">
						<input type="Hidden" name="Действие" value="Сортировать базу">
						Сортировать по
						<input type="Radio" name="Метод_Сортировки" value="Bable"> Пузырьковаму методу
						<input type="Radio" name="Метод_Сортировки" value="Бинарных деревьев"> Методу бинарных деревьев
						Сортировать по
						<input type="Radio" name="Приоретет_Сортировки" value="Bable"> Возрастанию
						<input type="Radio" name="Приоретет_Сортировки" value="Бинарных деревьев"> Убыванию
						<input type="Submit" name="Подтверджение" value="Подтверждаю">
						</form>
						<?
					if (isset($_POST ["Метод_Сортировки"]) and isset($_POST ["Приоретет_Сортировки"]))
					{
						assort_matrix ($wey);
					}
				break;

case "Проверееить на совпадения":
								$r = proverca ($wey);
								if ($r==0)
								{
									print "<H3> $wey - Проверка прошла успешно совпадений не найдено</H3><br>";
								}
								else
								{
									print "<H3> $wey - Обнаружено $r повторений, Повторы удалены</H3><br>";
								}
								break;
case "Показать в таблице":
					$a=array_base ($wey);
					print matrca ($a[0],$a[1]);
					break;
case "Затереть":
					if (fclose(fopen ($wey, "w")))
					{
						print "<H3> $wey - Успешно очищена</H3><br>";
					}
				break;
}
}
print_r ($_POST);
?>



</pre>