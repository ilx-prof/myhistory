<?php
$This_dir = dirname (__FILE__);
set_time_limit(0);
if( "Delete"==$_POST["submit"] && $_POST["load"]!=false )
{
	$DaMp = file($This_dir."/Fractal_seve/DataSAVE.Frsev");
	unset($DaMp[$_POST["load"]]);
	$s=fopen($This_dir."/Fractal_seve/DataSAVE.Frsev", "w");
	fwrite ($s,join("",$DaMp));
	fclose ($s);
	//print "da блин";
	include_once ("index_include.php");
}
else
{
	function rasbor($string)
	{
		return explode("*",trim($string));;
	}
	IF(isset($_POST["load"]))
	{
		$Arx = file($This_dir."/Fractal_seve/DataSAVE.Frsev");
		$ARX = rasbor($Arx[$_POST["load"]]);
		//print "лад";
		$imege_neme=$ARX[0];
	}
	//print $imege_neme;
	function fon($fon)
	{
		switch($fon)
		{
			case "White":
			return 0xffffff;
			case "Black":
			return 0x000000;
			case "Red":
			return 0xff0000;
			case "Green":
			return 0x008000;
			case "Blue":
			return 0x0000ff;
		}
	}
	function getmicrotime()
	{
	    list($usec, $sec) = explode(" ",microtime()); 
    	return ((float)$usec + (float)$sec); 
    }
	//print_r ($_POST);
	if (isset ($_POST ['imege_neme']))
	{
		$imege_neme = $_POST ['imege_neme'];
	}
		include($This_dir."/Vars_SEVE/".$imege_neme);
	function save_fractal()
	{
		global $This_dir,$SEVE;
		$Dir=$This_dir."/Fractal_seve/";
		If (!opendir($Dir))
		{
			mkdir($Dir,0700);
		}
		if ($Fneme = @Fopen($Dir."/DataSAVE.Frsev","a+"))
		{
			fwrite($Fneme,$SEVE);
			fclose($Fneme);
			return true;
		}
	}
	if( "Создать изображение"==$_POST["submit"] and ""!=$neme )
	{
		save_fractal();
	}
	//print $vih."\\//".$sir;
		if (isset($_POST['time']))
	{
		$time_start = getmicrotime();
	}
	header('Content-type: image/jpg'); // устанавливаем тип документа - "изображение в формате PNG".
	$image = imagecreatetruecolor($sir,$vih) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	//..*********РИСОВАНИЕ НАВСЕГДА*************,,
	// "Зальем" фон картинки цветом $FON...
	imagefilledrectangle($image, 0, 0,$sir,$vih,$FON);
	include_once("functionals_addon.php");
	include(dirname (__FILE__)."/Logic/".$imege_neme);
	if (isset ($_POST['time']))
	{
		getmicrotime();
	
	imagettftext($image,$sir/(50),rand(-6,6),$vih*0.3,$sir*0.2,imagecolorallocate($image,rand(0,255),rand(0,255),rand(0,255)),'ARIAL.ttf',"Expenses time ".(getmicrotime() - $time_start));//;
	}
	header('Content-type: image/jpg');
	imagepng($image);
	imagedestroy($image);
}?>