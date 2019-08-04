<?
function print_select_meny($file_dir,$dirs_or_files,$name)
{
	switch($dirs_or_files)
	{
		case 'files': 
			$dirs_or_files = files_in_dir ($file_dir);
			break;
		case 'dirs':
			$dirs_or_files = files_in_dir ($file_dir,true);
							
			break;
	}
	
	print '<br><select size="'.count($dirs_or_files).'" name="'.$name.'" >';
	$print="";
	$i=1;
	$selected="";
	foreach($dirs_or_files as $key => $neme)
	{
		$selected = $neme == $_POST["file_dir"] ? $selected = "selected" : "";
			$print.='
					<option  value="'.$neme.'" '.$selected .' >'.($i++).'-> '.$neme.'</option>';
	}
	print $print.'</select>';
}

function print_meny($dir,$dirs_or_files)
{
	switch($dirs_or_files)
	{
		case 'files': 
			$dirs_or_files = files_in_dir ($file_dir);
			break;
		case 'dirs':
			$dirs_or_files = files_in_dir ($file_dir,true);

			break;
	}
	print '<table >';
	foreach($dirs_or_files as $key => $neme)
	{
			$print.="<tr><td>$key</td><td>$neme</td></tr>";
	}
	print '</table>';
}

//..заменяет в файле номер строки на строку заменитель
function correct_head_function ($file_name,$serh_string,$past_string = false)
{
	$file=file($file_name);
	if ($past_string != false)
	{
		$file[$serh_string]=$past_string;
		if (is_writable($file_name) &&  $fo=fopen($file_name,"W+") )
		{
			
			foreach ($file as $string => $data)
			{
				fwrite($fo,$file[$string]);
				print "Запись в файл - $file_name строки ".$file[$string]."<br>";
			}
			fclose($file_name);
			return (isset($file[$serh_string])) ? trim ($file[$serh_string]) : "VOID";
		}
	}
	else
	{
		return (isset($file[$serh_string])) ? trim ($file[$serh_string]) : "VOID";
	}
}
//..Создает массив с именами файлов в директории

function files_in_dir ($file_dir,$dir = false)
{
	if (is_dir("$file_dir"))
	{ 
	 	if ($dh = opendir(getcwd ()."/$file_dir"))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				if($dir == false)
				{
					if ($file != "." && $file != ".." && is_file(getcwd ()."/$file_dir/".$file))
					{
						$files[]=$file;
						
					}
				}
				else
				{
					if ($file != "." && $file != ".." && is_dir(getcwd ()."/$file_dir/".$file))
					{
						$files[]=$file;
					}
				}
			}
		}
	}
	if (isset($files) and is_array($files))
	{
		return $files;
				print "$file_dir";
	}
	else
	{
	return false;
	}
}

//
function input_string_file($file_dir,$serh_string,$past_string = false)
{
	$files = files_in_dir ($file_dir);
	if(isset($_POST['on']) && $past_string !=false )
	{
		foreach($_POST['on'] as $key => $file)
		{
			 correct_head_function ($file_dir."/".$files[$key],$serh_string,$past_string);
		}
	}
	if ($past_string == false)
	{
		$print='<table align="center" border="1" cellpadding="0" cellspacing="0">';
		foreach($files as $key => $file)
		{
		
		$print.="<tr><td width=\"40%\">".$key.'<input type="Checkbox" name="on['.$key.']"> '." - ".$file."</td><td>".trim(correct_head_function($file_dir."/".$file,$serh_string,$past_string))."</td></tr>
";	
		}
			$print .="</table>";
			print $print;
	}
}
?>

<style >
	.nlink	{color:#4F1C93; font-family: Comic Sans MS;  text-decoration: blink}
	.nlink2	{color:#CC133D; font-family: Comic Sans MS; font-size: larger; text-decoration:  line-through }
	</style>
<body bgcolor="#EFEFEF">

<table align="center" bgcolor="#c0c0c0">
<tr><td align="center" >
<pre>
<a href="F_R_A_T_A_L_Editor.php"><font color="#0000ff" face="aril" size="5" >F_R_A_T_A_L_Editor</font></a>
Че смотриш?) делай!!!
<p align="center">
<table align="center"  width="800" cellspacing="2" cellpadding="2" border="1">
<tr>
	<td colspan="2" align="center" >
		<h3><em>Редактор обших заголовков функций второго уровня</em></h3>
		<form action="F_R_A_T_A_L_Editor.php" method="post">
		<table>
		<tr>
			<td>Местонахождение файлов =></td>
			<td><select name="type">
			<option value="Logic" <? print (isset($_POST["type"]) and $_POST["type"]=="Logic" ) ? "selected" : "";?>> Logic</option>
			<option value="meny/metod" <? print (isset($_POST["type"]) and $_POST["type"]=="meny/metod" )? "selected" : "" ; ?>> meny/metod</option>			
			</select>
			</td>
		</tr>
		<tr>
			<td><? if (isset ($_POST["type"])){ print $_POST["type"];}?> =></td>
			<td><? print_select_meny("Logic",'dirs',"file_dir"); ?></td>
		</tr>
				<tr>
			<td>String № </td>
			<td><input type="text" name="serh_string" value="<? print ( isset ($_POST["serh_string"] ))? $_POST["serh_string"] : "" ;?>"></td>
		</tr>
		<tr>
				<td colspan="2"><input type="Submit" name="Go">	</td>

		</tr>		
		</table>		
	</td>
</tr>

<tr>
	<td><pre>
<?
	if ( isset ($_POST["file_dir"] ) and isset ($_POST["serh_string"]) and $_POST["serh_string"] !="" and isset ($_POST["type"] ) )
	{
		
		input_string_file (  $_POST["type"]."/".$_POST["file_dir"],$_POST["serh_string"],$_POST["past_string"]);
	}
	else
	{
		print "Отсутствует запрос";
	}
?>
	</td>
</tr>
<tr>
	<td>
		<input type="Text" name="past_string" style="height:100%; width:100% " value="">
	</td>
</tr>
	</form>
</table>
</td></tr>
<tr>
<td>
<pre>
<? print_r ($_POST) ?>
</td>
</tr>
</pre>
</table></body>