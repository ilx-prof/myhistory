<?//..здесь выводяться последние картинки к категориям 
	$cat = cat () ;
	$a = array();
	foreach ( $cat[0] as  $key => $file_name)
	{
		if (file_exists("baraholca/SORT/".$file_name.".kat"))
		{
			$file = file("baraholca/SORT/".$file_name.".kat");
			if($file!=array())
			{
				$a [] = $file[count($file)-1];
			}
		}
	}
	if($a != array())
	{
			$print = ARRAY();
		foreach($a as $key => $id_mes)
		{
			$tmp = explode ("/",$id_mes);
			$id = trim($tmp[0]);
			$mes = trim($tmp[1]);
			$mess = mesage($id,$mes);
			if ($mess!=false && $mess[1]!="bag_mess" && Isset ($mess[0][1][0]))
			{
				$ctegor = $mess[0][0]["Category"];
				$kateg = $cat[1][array_search ($ctegor,$cat[0])];
				$image = $mess[0][1][0];
				$image = str_replace ("med","min",$image);
				
				$input_img_a = "<a href=\"index.php?action=kat&kat=$ctegor\">".'<img src="'.$image.'">'."</a>"; 
				$da_atrray = array($kateg,$input_img_a);
				$pa_array= array("{title}","{img}");
			 	$print[] = pattarn ($da_atrray,$pa_array,"htm/img.htm");
			}
		}
		if ( $print !=array())
		{
			print implode ("
",$print);
		}
		else
		{
				print "Категорий с собщениями необнаружено!";
		}
	}
	else
	{
		print "Категорий с собщениями необнаружено!";
	}
?>