<?

function image_cenetr_string_color ($image)//По количествам цветов в строку ВОЗВРАШАЕТ массив в котором выводяться строки с неповторяющимисся цветами цветами на которые
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$image_string_color = array();
	$y=$x=0;

	while($y <= $sise_Y)
	{
		$x=0;
		$temp_dump=array();
		while($x<$sise_X)
		{
			$col=imagecolorat ($image, $x,$y);
			IF(!in_array($col,$temp_dump))
			{
				$temp_dump[]=$col;
			}
			$x++;
		}
		$image_string_color[count($temp_dump)][$y]=$temp_dump;
		$y++;
	}
	krsort($image_string_color);
	$image_string_color = current($image_string_color);
	$arr = $masc_pered =array();
	foreach ($image_string_color as $string => $masc)
	{
		if(in_array( $masc,$arr))
		{
			$masc_pered[array_search($masc,$arr)]+=1;
		}
		else
		{
			$arr[$string]=$masc;
			$masc_pered[$string]=1;
		}
	}
	return $arr[array_search(max($masc_pered),$masc_pered)];
}


function array_control_analise (&$ITC,$image_string_color)//..функция проверки на попадпние под дальнейшее распознование
{
	global $sise_string;
	$max_itc= array_search(max($ITC),$ITC);
	
	$ITC_main = array_slice ($ITC,1,$sise_string);
	$end=array();
	foreach ($image_string_color as $num => $col)
	{
		if(in_array($col,$ITC_main));//Warning!еслиИмеюстьсяСлитыеБуквы далнейшее распознание будет невозможным!
		{
			if($max_itc!=$col)
			{
				$end[$num]=$col;
			}
		}
	}
	return $end;
}

function color_itc ($image)//Выводит массив используемых цветов с количеством каждого
{
	$sise_X=imagesx ($image)-1;
	$sise_Y=imagesy ($image)-1;
	$ITC=array();
	$y=0;
	 while($y <= $sise_Y)
	{
		$x=$i=0;
		while($x<$sise_X)
		{
		        if ( !isset ( $ITC[imagecolorat ($image , $x,$y)] ) )
		        {
				$ITC[imagecolorat ($image , $x,$y)] = 0;
		        }//if
			$ITC[imagecolorat ($image , $x,$y)]++;
 			$x++;
		}
		$y++;
	}
	arsort($ITC);
	return  $ITC;
}


function Bip_Map(&$image,$col=0)//По ресурсу $image Создает Bip_Map массив Y на Х с цветами картинки
{
	$void=true;
	$Bip_Map_array =array();
	$sir_X = imagesx($image)-1;//..ширима 
	$vih_Y = imagesy($image)-1;// высота
	//imagecolorat ($image , $x,$y) - цвет пиксела
	$y=0;
		while($y <= $vih_Y)
		{
			$x=$i=0;
			while($x<$sir_X)
			{
				$Bip_Map_array[$y][$x] = imagecolorat ($image , $x,$y);
				if($void)
				{
					if(imagecolorat ($image , $x,$y) == $col)
					{
						$void=false;
					}
				}
				$x++;
			}
			$y++;
		}
		if($void)
		{
			return "void";
		}
		else
		{
			return $Bip_Map_array;
		}
}

Function Rectangle_iso($Bip_Map_array,$col=0)//Определяет координаты границ (описанного прямоугольника) вокруг распознаваемого изображения
{
	$sir_X = count($Bip_Map_array[0])-1;//..ширима 
	$vih_Y = count($Bip_Map_array)-1;// высота
//Определение верхней границы непустого изображения
	for ($y=0;$y<$vih_Y;$y++)//..перебераем каждую координату по У начиная с ноля
	{
		for ($x=0;$x<$sir_X;$x++)//перебиреме каждую координату по Х
		{
			if($Bip_Map_array[$y][$x]==$col)//Где 0 цвет распозноваемго изображения
			{
				$y_Top = $y;
				break;
			}
		}
	}
//Определение нижней границы изображения
	for ($y=$vih_Y;$y>0;$y--)//..перебераем каждую координату по У начиная с конечной точки изображения
	{
		for ($x=0;$x<$sir_X;$x++)//перебиреме каждую координату по Х начиная с ноля
		{
			if($Bip_Map_array[$y][$x]==$col)
			{
				$y_Bottom  = $y;
				break;
			}
		}
	}
//Определяем Левую границу
	for ($x=0;$x<$sir_X;$x++)//..перебераем каждую координату по Х начиная с ноля
	{
		for ($y=0;$y<$vih_Y;$y++)//перебиреме каждую координату по Y начиная с ноля
		{
			if($Bip_Map_array[$y][$x]==$col)
			{
				$x_Left  = $x;
				break;
			}
		}
	}
//..Определяем правую границу 
	for ($x=$sir_X;$x>0;$x--)//..перебераем каждую координату по Х начиная с конечной точки изображения
	{
		for ($y=0;$y<$vih_Y;$y++)//перебиреме каждую координату по Y начиная с ноля
		{
			if($Bip_Map_array[$y][$x]==$col)
			{
				$x_Rigit  = $x;
				break;
			}
		}
	}
	return array("y_Top"=>$y_Bottom,
				 "x_Left"=>$x_Rigit,
				 "y_Bottom"=>$y_Top,
				 "x_Rigit"=>$x_Left);
}

function Persent_Bipmap($Rectangle,$Bip_Map_array,$percent,$defoult=0,$col=0)//..процент заполнения области картинки пикселями
{
	$n_Symbol=0;
	$Y=0;
	for ($y=$Rectangle["y_Top"];$y<=$Rectangle["y_Bottom"];$y++)
	{
		$X=0;
		for($x=$Rectangle["x_Left"];$x<=$Rectangle["x_Rigit"];$x++)
		{
			$xy_16[$Y][$X]=$Bip_Map_array[$y][$x];
			if($Bip_Map_array[$y][$x] == $col)//..$col цвет распознаваемого изображеня
			{
				$n_Symbol++;
			}
			$X++;
		}
		$Y++;
	}
	if ($defoult==0)
	{
		return array("xy_16"=>$xy_16,"percent"=>($n_Symbol / (($Rectangle["y_Bottom"] - $Rectangle["y_Top"])*($Rectangle["x_Rigit"]- $Rectangle["x_Left"])))*$percent);
	}
	else
	{
		return (($n_Symbol / (($Rectangle["y_Bottom"] - $Rectangle["y_Top"])*($Rectangle["x_Rigit"]- $Rectangle["x_Left"])))*$percent);
	}
}
function rectangle_16x16 ($image,$xy_16,$pesent,$col)
{
	global $delit,$Error_free;
	$Rectangle_16x16 = "";
	$sir_X = count($xy_16[0])-1;//..ширима 
	$vih_Y = count($xy_16)-1;// высота
	 	//$n_delitel = NOD (sir_X,vih_Y;// обший делитель высоты и длинны
	$delta_X=$sir_X/$delit;
	$delta_Y=$vih_Y/$delit;
$Y=0;
for($YY=0;$YY<=$delit-1;$YY++)
{
	$X=0;
	for($XX=0;$XX<=$delit-1;$XX++)
	{
		$Rectangle = array("y_Bottom"=>abs($Y+$delta_Y),
				"x_Rigit"=>abs($X+$delta_X),
				"y_Top"=>abs($Y),
				"x_Left"=>abs($X));
		$X+=$delta_X;
		$Rectangle_16x16.= Persent_Bipmap($Rectangle,$xy_16,$Error_free,1,$col) < $pesent ? 0 : 1 ;
	}
		$Y+=$delta_Y;
}
	$Rectangle_16x16 .= "
";
return $Rectangle_16x16;
}

	function analise ($arr_masca_16x16,$name_srift,$leter)
	{
		$f = file ("fonts/".$name_srift."/".$leter);
		$f[0]=TRIM($f[0]);
		$arr_masca_16x16=TRIM($arr_masca_16x16);
		$long = strlen ($arr_masca_16x16);
//		Print "<h1>Символ $long должен присутствовать в строке";
//		print_r ($f);
//		print" а длины строк также должны быть равны |".isset($f[0])."|</h1>";
		if(isset($f[0]) and strlen ($f[0]) == $long  )
		{
			$persent = anal($arr_masca_16x16,$f[0],$long);
		}
		else
		{
			foreach ($f as $key => $val)
			{
				if (strlen($val)== $long)
				{
					$persent = anal($arr_masca_16x16,$val,$long);
				}
				else
				{
					print "<h1>False ".strlen($val)." == $long</h1>";
					$persent = false;
				}
			}
		}
		return $persent;
	}

function anal($arr_masca_16x16,$string,$long)
		{
			$true=0;
			$long1=$long;
			$long -= 1;
			while (0!=$long)
			{
				if (trim($arr_masca_16x16[$long]) == trim($string[$long]))
				{
					$true++;
				}
				$long--;
			}
			return (($true/$long1)*100);
		}

function analitic_all ($arr_masca_16x16)//Распознает изображенеи по всем шрифтам
{
global $mass_leter;
	$path = getcwd()."/fonts/";
	$dir = opendir ( $path );
	$statistic = array();
	while ( $file = readdir ( $dir ) )
	{
		if ( $file != '.' && $file != '..' && is_dir ($path.$file))
  		{
			$fi=opendir($path.$file);
		  	while ( $fil = readdir ( $fi ) )
			{
				if ( $fil != '.' && $fil != '..' && in_array(str_replace ( ".txt", "", $fil),$mass_leter))
				{
							$statistic[$file][chr(str_replace ( ".txt", "", $fil))] = analise ($arr_masca_16x16,$file,$fil);
   				}
			}
			closedir($fi);
	     	}
	}
	closedir ($dir);
	return $statistic;
}

function analis_color_obgect (&$image,$ar_col)
{
	global $sise_string,$delit,$Error_free;
	$tmp_image = $image;
	$print="<table><tr>";
	$im_file="img/image3.png";
	$slovo = "";
	input_or_seve_img ($image,"img/image3.png");
	
	foreach ($ar_col as $KEY_MAIN => $col)
	{
	        $image = $tmp_image;
		$Bip_Map_array=Bip_Map($image,$col);
		$arr_masca_16x16 = "";
		if ($Bip_Map_array!="void")
		{
			$Rectangle=Rectangle_iso($Bip_Map_array,$col);
			$Persent_Bipmap = Persent_Bipmap($Rectangle,$Bip_Map_array,$Error_free,0,$col);
			$arr_masca_16x16 = arr_masca_16x16_image ($image,$col);
		}
		else
		{
			$arr_masca_16x16 = void_a ();
//			resrve_bin ($arr_masca_16x16);
		}
		
//		print_r ( chunk_split ( $arr_masca_16x16, 16 ) );
		
		$tmp = analitic_all ($arr_masca_16x16);
		$arr = array ( );
		foreach($tmp as $font => $let)
		{
			arsort ( $let );
			reset ( $let );
			for ( $i = 0; $i < 1; $i++ )
			{
				$cur = current ( $let );
				$arr["$cur"]=key( $let )." - ".ord(key( $let ))." - ".$font;
				next ( $let );
			}
		}
		krsort ( $arr );
		reset ( $arr );

		$print .='<td><table>';
		$i = 0;
		foreach ($arr as $cur => $str)
		{
			$str=explode (" - ",$str);
			if($i<10)
			{
			        if ( $i == 0 )
			        {
					$slovo .= chr ( $str[1] );
			        }//if
				$image = simbol_to_img($str[1],$str[2],$col);
				imagepng($image,"img/img/"."{$KEY_MAIN}_".$i.".png");
//				imagedestroy($image);
				$print .="<tr><td><img src=\"img/img/{$KEY_MAIN}_$i.png\" width=\"40\" height=\"40\"></td><td>[". chr ( $str[1] ) ."]". sprintf ( "%.2f", $cur ) ."% <small>". $str[2] ."</small></td></tr>";
				$i++;
			}
		}
		$print .='</table></td>';
	}
	
	print $print ."</tr></table>";
	var_dump ( $slovo );
	
}
?>