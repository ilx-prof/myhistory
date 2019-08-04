<?
$i=0;
	if (is_dir("Form/"))
	{ 
	 	if ($dh = opendir("Form/"))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." )
				 {
					include (getcwd ()."/Form/".$file);
					$i++;
				 }
			}
		}
	}

?>