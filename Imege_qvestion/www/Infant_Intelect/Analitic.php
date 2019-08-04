<pre>
Before - <img src="img/image2.png"><br>
After - <img src="img/image3.png">
<?
set_time_limit ( 0 );
include ("analis_blov_functions.php");//..функции аннализа данных
include ("COMPILE_SRIFT.PHP");//Функции приготовления шрифтов
include ("servise.php");//Дополнительные функции
include ("system_functions.php");//Обшие Системные функции
$sise_string = 5 ;
$delit = 16;
$Error_free=0.99;
$im_file="img/image2.png";
$mass_leter=load_mass_leter ();
$image = imagecreatefrompng($im_file) // создаем изображение из файла... ...или прерываем работу скрипта в случае ошибки
or die('Cannot create image');
include ("my_ILX.gd.php");//..функции предварительной обработки изображения
//include ("image_Prepar.php");

image_to_gray ( $image );
$ITC=color_itc($image);
reset ( $ITC );
//print_r ( $ITC );
$max = current ( $ITC );
if ( key ( $ITC ) != 0 )
{
	image_invert_black_white ($image,key($ITC),$col_2=16777215);
	foreach ( $ITC as $color_id => $count )
	{
	        $summ = array_sum ( $ITC );
	        $percent = 100 * $count / $summ;
		if ( $count < $ITC[0] )
		{
			image_invert_black_white ($image,$color_id,$col_2=16777215);
		}//if
	}//foreach

	
}//if
//$image=MaxSizeThumbnail($image,201);
//image_invert_black_white ($image,$col_2=16777215, $col_1 = 0x0);
image_plunder_black_XY ($image);//Обкрадывание чернобелого изображения по X
image_plunder_black_XY ($image,0,0);//вотсановление черного цвета Y
image_plunder_black_XY ($image,0,0);//вотсановление черного цвета Y
//image_plunder_black_XY ($image,0,0);//вотсановление черного цвета Y
//image_plunder_black_XY ($image,0,0);//вотсановление черного цвета Y
$analis_obgect = image_to_vector ($image);
$ITC=color_itc($image);
$image_string_color = image_cenetr_string_color ($image);
$end = array_control_analise ($ITC,$image_string_color);
analis_color_obgect ($image,$end);
//print_r (array($image_string_color,$ITC));
/*
$i=0;
while (++$i<=0)
{
image_plunder_black_XY ($image,0,0);//вотсановление черного цвета Y
}
$i=0;
image_plunder_black_X ($image);//Обкрадывание чернобелого изображения по Y
   image_plunder_black_Y ($image,0,0);
image_plunder_black_Y ($image);//Обкрадывание чернобелого изображения по Y
   image_plunder_black_X ($image,0,0);
while (++$i<=0)
{
image_plunder_black_XY ($image);//вотсановление черного цвета Y
}
image_plunder_black_X ($image);//Обкрадывание чернобелого изображения по Y
   image_plunder_black_Y ($image,0,0);
image_plunder_black_Y ($image);//Обкрадывание чернобелого изображения по Y
   image_plunder_black_Y ($image,0,0);
//image_plunder_black_XY ($image);//Обкрадывание чернобелого изображения по Y
$i=0;
while (++$i<=0)
{
image_plunder_black_XY ($image,0,0);//вотсановление черного цвета Y
}
*/
/*
input_or_seve_img ($image,"img/image3.png");
$im_file="img/image3.png";
$print = '<table>
<tr>
<td><img align="baseline" src="img/image2.png"><br>До обработки</td>
<td><img align="baseline" src="img/image3.png"><br>После обработки</td>
</tr>
</table><br>
';
$Bip_Map_array=Bip_Map($image);
if ($Bip_Map_array!="void")
{
	$Rectangle=Rectangle_iso($Bip_Map_array);
	$Persent_Bipmap = Persent_Bipmap($Rectangle,$Bip_Map_array,$Error_free);
	$arr_masca_16x16 = arr_masca_16x16_image ($im_file);
}
else
{
	$arr_masca_16x16 = void_a ();
}
//$anal = anal($arr_masca_16x16,$str,strlen($arr_masca_16x16));
		$tmp =		array(//"anal"=>$anal,
				//"Bip_map_arr"=>$Bip_Map_array,
				//"Rectangle_iso_arr"=>$Rectangle,
//				"Persent_Bipmap"=>$Persent_Bipmap,
//				"arr_masca_16x16"=>$arr_masca_16x16 ,
				
//		"fatal_rendring_srift"=>fatal_rendring_srift (),
			"analise_all"=> analitic_all ($arr_masca_16x16)
				);
   $max = 0;
   $letter = "";
   $font = "";
   $arr=array();
   
   foreach ( $tmp['analise_all'] as $font => $let )
   {
	   // print $font ."\n";
		arsort ( $let );
		reset ( $let );
		for ( $i = 0; $i < 1; $i++ )
		{
			$cur=current ( $let );
	      	$arr["$cur"]=key( $let )." - ".ord(key( $let ))." - ".$font;
	        next ( $let );
		}
   }
   krsort ( $arr );
	reset ( $arr );
	$print .='<table>';
	foreach ($arr as $cur => $str)
	{
		$str=explode (" - ",$str);
		if($i<5)
		{
			$image = simbol_to_img($str[1],$str[2]);
			imagepng($image,"img/".$i.".png");
			imagedestroy($image);
			$print .="<tr><td><img src=\"img/$i.png\"></td><td><font size=\"".(7-$i)."\">".$cur." - ".$str[0]." - [".$str[1]."] - ".$str[2]."</font></td></tr>";
			$i++;
		}
	}
	$print .='</table>';
	print $print .="Список самы высоких процентов по шрифтам<br>";
print_r($arr);*/
/*
imagerectangle($image, $Rectangle["x_Left"],$Rectangle["y_Top"],$Rectangle["x_Rigit"],$Rectangle["y_Bottom"], 0x000000); //..разобраться почему не отображееться на картинке
imagepng($image);//ввывод изображени
imagedestroy($image);//очишение памяти и удаление переменной
<img src="img/img/1_1.png"><img src="img/img/2_1.png"><img src="img/img/3_1.png"><img src="img/img/4_1.png"><img src="img/img/5_1.png"></pre>
*/ 
?>
