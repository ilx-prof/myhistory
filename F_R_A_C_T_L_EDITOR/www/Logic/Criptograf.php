<?php
include_once ($metod);
function criptograf ($string)
	{
		global $vih,$sir,$image;	
	$a=strlen($string);
	$n=0;
	$Y=0;
	while($vih!=$Y)
	{
		$Y++;
		$X = 0;
		while($sir!=$X)
		{
			$X++;
			$n++;
			if (isset($string[$n]))
			{
				imagesetpixel ($image,$X,$Y,(S_color($string,$n,$a)));
			}
		}
	}
	}
		IF(isset($_POST['String']) && $_POST['String']!="")
	{
		$string = strtr ($_POST['String'],"
","");
//print strlen($string)."длинна строки";
	}
	elseif (isset($_POST['file']))// && is_file($This_dir."/".$_POST['wey']))
	{
			$string = file_get_contents($_POST['wey']);
//			print $string;
	}
	else
	{
		$string = "no string";
	}
//	print_r ($_POST);
		criptograf($string);
?>
