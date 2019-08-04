<?
function crate_img($file_naeme)//создает новое изображение по имени файла
{
      	$regs=explode (".",$file_naeme);

       switch ($regs[1])
       {
	       case "jpg" : return imagecreatefromjpeg ($file_naeme);
               case "png" : return imagecreatefrompng ($file_naeme);
               case "gif" : return imagecreatefrompng ($file_naeme);
	           default: return "Fatal error format incorect";
	}

}
function  input_or_seve_img(&$image,$file_naeme = false,$inpt_tupe = "png") //выводит изображение в файл или браузер
{
	if($file_naeme)
	{
	 	$regs=explode (".",$file_naeme);
        switch ($regs[1])
		{
		case "gif" : return imagegif ($image,$file_naeme);
		case "jpg" : return imagejpeg ($image,$file_naeme);
		case "png" : return imagepng ($image,$file_naeme);
	            default: return "Fatal error format incorect";
		}
	}
	else
	{
                switch ($inpt_tupe)
		{
		case "gif" : return imagegif ($image);
		case "jpg" : return imagejpeg ($image);
		case "png" : return imagepng ($image);
	            default: return "Fatal error format incorect";
		}
	}
}

function resrve_bin ($arr_masca_16x16)
{
	global $delit;
	$f = fopen ("img/img/.".rand(0,100000)."_bin.bac","w+");
	fwrite ($f,chunk_split ($arr_masca_16x16,$delit));
	fclose($f);
}

function arr_masca_16x16 ($name_srift,$leter,$col=0)
{
	global $delit,$Error_free;
	$image = simbol_to_img($leter,$name_srift,$col);
	$Bip_Map_array=Bip_Map($image,$col);
	if($Bip_Map_array!="void")
	{
		$Rectangle=Rectangle_iso($Bip_Map_array,$col);
		$Persent_Bipmap = Persent_Bipmap($Rectangle,$Bip_Map_array,$Error_free,0,$col);
//		imagepng($image,$leter);
		imagedestroy($image);
		return $arr_masca_16x16 = rectangle_16x16 ($image,$Persent_Bipmap["xy_16"],$Persent_Bipmap["percent"],$col);
	}
	else
	{
		return void_a ();
	}
}
function void_a ()
{
	global $delit;
	$q=$delit*$delit;
	$arr_masca_16x16="";
	while (0!=$q--)
	{
		$arr_masca_16x16 .="0";
	}
	print "<br><br><br><br><br><br>VOid 75 fs";
	return $arr_masca_16x16; 
}
function arr_masca_16x16_image (&$image,$col=0)
{
	global $delit,$Error_free;
//	$regs=explode (".",$file_naeme);
//	if ($regs[1]=="jpg" or $regs[1]=="JPEG")
//	{
//		if ($image = imagecreatefromjpeg ($file_naeme))
//		{
			$Bip_Map_array=Bip_Map($image,$col);
			if($Bip_Map_array!="void")
			{
				$Rectangle=Rectangle_iso($Bip_Map_array,$col);
				$Persent_Bipmap = Persent_Bipmap($Rectangle,$Bip_Map_array,$Error_free,0,$col);
//								imagedestroy($image);
				$arr_masca_16x16 = rectangle_16x16($image,$Persent_Bipmap["xy_16"],$Persent_Bipmap["percent"],$col);
				return $arr_masca_16x16;
			}
			else
			{
				return void_a ();
			}
/*		}
		else
		{
			return "Fatal error format incorect";
		}
	}
	ELSEif ($regs[1]=="png")
	{
		if ($image = imagecreatefrompng($file_naeme))
		{
			$Bip_Map_array=Bip_Map($image,$col);
			if($Bip_Map_array!="void")
			{
					$Rectangle=Rectangle_iso($Bip_Map_array,$col);
					$Persent_Bipmap = Persent_Bipmap($Rectangle,$Bip_Map_array,$Error_free,0,$col);
					imagedestroy($image);
					return $arr_masca_16x16 = rectangle_16x16 ($image,$Persent_Bipmap["xy_16"],$Persent_Bipmap["percent"],$col);
			}
			else
			{
					return void_a ();
			}
		}
		else
		{
			return "Fatal error format incorect";
		}
	}
	else
	{
		return "Fatal error format incorect";
	}*/
}
function simbol_to_img($leter,$name_srift,$col=0)
{
	$image = imagecreatefrompng ("img/image1.png") or die('Cannot create image');
	if(imagettftext($image,80,0,5,100,$col,"font_etalon/".$name_srift,iconv("windows-1251", "UTF-8", chr($leter)))){;} //20*22/220707 lty
	else
	{
		imagettftext($image, 80,0,5,100,$col,"font_etalon/".$name_srift, chr($leter));
	}
	return $image;
}


?>