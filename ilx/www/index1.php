<pre>
<?php
$dir="z:";
$a=0;
function vhod_prosmotr ($dir,$a)
{
$r=0;
if (is_dir($dir))
{
@$a++;
print "Это директория - |$dir| \n";
    if ($dh = opendir($dir))
	 {
		 print "<br>Открытый дескриптор $dh \n";
     	   while (false !== ($file = readdir($dh))) 
		   {
				if ($file != "." && $file != "..")
				{
						if (!is_dir($dir."/".$file))
						{
							print $file.": тип |Файл|\n";
						}
						else
						{
							print $dh."<br> &nbsp;&nbsp;";
							
							print " - был $dh - стал \n		";
							vhod_prosmotr($dir."/".$file,$a);
						}
				}
			}
		
    }
	closedir($dh);
}
}
vhod_prosmotr($dir,0);
?>
</pre>
