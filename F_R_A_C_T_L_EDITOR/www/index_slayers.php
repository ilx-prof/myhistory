
<body bgcolor="#EFEFEF">
<table align="center" bgcolor="#c0c0c0">
<tr><td><script>
	function fetch_object ( idname )
	{
		if ( document.getElementById ){return document.getElementById ( idname );}
		else if ( document.all ){return document.all[idname];}
		else if ( document.layers ){return document.layers[idname];}
		else {return null;}
	}
	function Open ( group )
	{
		var curdiv = fetch_object ( group );
		curdiv.style.display = "";
	}
	function Close ( group )
	{
		var curdiv = fetch_object ( group );
		curdiv.style.display = "none";
	}
</script>
<pre>
<font color="#0000ff" face="Impact" size="5" >Вас приветствукетс мастер фломастер для создания навящивых изображений </font>
<form action="imege.php" method="POST">
<select size="10" name="load">
<?php
	function rasbor($string)
	{
		$Option = explode("*",trim($string));
		$name=$Option[1];
		$Options[$name] = $Option;
		return $Options;
	}

	$Arx = file(dirname (__FILE__)."\Fractal_seve"."\\DataSAVE.Frsev");
	$i=0;
	while($i<=count($Arx)-1)
	{
		$ARX[]=rasbor($Arx[$i]);
		$i++;
	}
	$i=0;
	$r=true;
	while($i<=count($Arx)-1)
	{
	$print.="
		<option value=\"".$i."\">".($i+1)."-> ".key($ARX[$i])."</option>";
		$i++;
	
	}
	print $print;
?>
<input type="SUBMIT" name="submit" value="LOAD">
</select>
</form>
Метод построения<br>
<?php
	if (is_dir(getcwd ()."\meny"))
	{ 
	 	if ($dh = opendir(getcwd ()."\meny"))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." )
				 {
					$files[]=$file;
					$i++;
				 }
			}
		}
	}
	// print $metod;
	$tmp = "";
	foreach ( $files as $id => $fname )
	{
		$tmp .= "Close ( '". $fname ."' ); ";
	}
	$form = "<form  action=\"imege.php\" method=\"POST\"><select >";
	foreach ( $files as $id => $fname )
	{
		ob_start ( );
		include dirname (__FILE__)."\meny\\".$fname ;
		$data[$fname] = ob_get_clean ( );
		$form .= "<option  onclick=\"$tmp Open ('". $fname ."');\" value=\".$fname.\">".$fname ."</option>";
	}
	$form .= "</select></form>";
	print $form;
	foreach ( $data as $id => $text )
	{
		print "<div style=\"display : none;\" id=\"". $id ."\">";
		print $data[$id];
		print "</div>";
	}
?>
</td></tr>
</table></body>