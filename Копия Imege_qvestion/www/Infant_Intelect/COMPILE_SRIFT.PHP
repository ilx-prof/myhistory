<?
	function add($name_srift,$arr_masca_16x16,$letter)
	{
	    global $delit;
		$file = fopen ("fonts/".$name_srift."/".$letter .".txt",'w+');
		fwrite ($file,$arr_masca_16x16);
		fclose ($file);
	}
	
function safe_dump ($arr_masca_16x16,$name_srift,$letter)//..сохран€ет в имени шрифта данный символ не использу€ распознавани€ »—ѕќЋ№«”≈“№—я “ќЋ№ ќ ƒЋя ќЅ”„≈Ќ»я ѕ–ќ√–јћћџ
{
	if (!is_dir (getcwd ()."/fonts/".$name_srift))
	{
		mkdir ( getcwd ()."/fonts/".$name_srift, 0600);
	}
		add($name_srift,$arr_masca_16x16,$letter);
	return true;
}
function fatal_rendring_srift ()
{
	global $delit;
	$path = getcwd()."/font_etalon/";
	$dir = opendir ( $path );
	$statistic = array();
	while ( $file = readdir ( $dir ) )
	{
		if ( $file != '.' && $file != '..' && is_file ($path.$file))
  		{
			for ($leter=0;$leter<=255;$leter++)
			{
					$statistic[$file] = safe_dump (arr_masca_16x16 ($file,$leter),$file,$leter);
			}
     	}
	}
	closedir ($dir);
	return $statistic;
}
?>