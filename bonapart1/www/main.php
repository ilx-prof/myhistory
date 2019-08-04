<?//..здесь выводяться последние картинки к категориям 
	$cat = cat () ;//список последних сообщений/
	$a = array();
	foreach ( $cat[0] as  $key => $file_name)
	{
		$file = file("baraholca/SORT/".$file_name.".kat");
		if($file!=array())
		{
			$a [] = $file[count($file)-1];
		}
	}
	foreach($a as $key => $id_mes)
	{
		$tmp = explode ("/",$id_mes);
		$id = trim($tmp[0]);
		$mes = trim($tmp[1]);
		$mess = mesage($id,$mes);
		print "<pre>";
		
		$ctegor = $mess[0][0]["Category"];
		$kateg = $cat[1][array_search ($ctegor,$cat[0])];
		$image = $mess[0][1][0];
		$input_img_a = "<a href=\"index.php?action=kat&kat=$ctegor\">".'<img src="'.$image.'" width="100%" height="120">'."</a>"; 
		$da_atrray = array($kateg,$input_img_a);
		$pa_array= array("{title}","{img}");
		print pattarn ($da_atrray,$pa_array,"htm/img.htm");
	}
?>