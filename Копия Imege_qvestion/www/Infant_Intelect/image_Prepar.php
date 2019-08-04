<?
$im_file="img/image2.png";
include("GD2.class.php");
$gd = new GD2;
//................Вместо gd испольховать следуюцие функции
//$rotate = imagerotate($img, $degrees, 0);
//imagefilter($img, IMG_FILTER_MEAN_REMOVAL);
//imagefilter($img, IMG_FILTER_GAUSSIAN_BLUR,$val);
//imagefilter($img, IMG_FILTER_EMBOSS);
//imagefilter($img, IMG_FILTER_SMOOTH,$val);
//imagefilter($img, IMG_FILTER_BRIGHTNESS,$val);
//imagefilter($img, IMG_FILTER_CONTRAST,$val);
//imagefilter($img, IMG_FILTER_SELECTIVE_BLUR);
//imagefilter($img, IMG_FILTER_EDGEDETECT);
//imagefilter($img, IMG_FILTER_GRAYSCALE);
//imagefilter($img, IMG_FILTER_NEGATE);
//$gd->MaxSizeThumbnail($im_file,150);
#$gd->OneSizeThumbnail($_GET['Img'],$_GET['Size']);
#$gd->CropImage($im_file,250,250,1000,70);//незнай че такое,,,
#$gd->SetTransparent($im_file,"#000000)
//include("system_functions.php");
//$image=crate_img($im_file);
//include("my_ILX.gd.php");
//$ITC=color_itc ($image);//Выводит массив используемых цветов с количеством каждого
//$ITC_coll=array_sum($ITC);

//invert_black_white (&$image,$col_1=16777215,$col_2 = 0x0)//..Приводит изображение на $col_1 фоне к $col_2-$col_1 варианту по умолчанию черное на белом
//print_r(array("Итк цвта"=>color_itc ($image)));
//$image=crate_img($im_file);
//image_invert_black_white ($image);//..ПЕРИНВЕНТИРОВАНИЕ ИЗОБРАЖЕНИЯ СОГЛАСНО МАСКЕ ДВУЦХ ЦВЕТОВ
//image_invert_black_white ($image,0,0xFFFFFF);
//image_plunder_black_X ($image);
//image_plunder_black_Y ($image);
//input_or_seve_img ($image,"img/gradient.jpg");

/* построение палитры цветов
$image = imagecreatetruecolor (2048+1,1000);
$image = image_palite ($image);
input_or_seve_img($image,"img/gradient.jpg");
*/
?>
