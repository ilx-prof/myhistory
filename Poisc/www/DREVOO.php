<pre>
<?php
$dir="z:";
$a=0;
function vhod_prosmotr ($dir,$a)
{
if (is_dir($dir))
{
@$a++;
print "��� ���������� - |$dir| \n";
    if ($dh = opendir($dir))
	 {
		 print "<br>�������� ���������� $dh \n";
     	   while (false !== ($file = readdir($dh))) 
		   {
				if ($file != "." && $file != "..")
				{ 
						if (!is_dir($dir."/".$file))
						{
							print $file.": ��� |����|\n";
						}
						else
						{
							print $dh;
							
							print " - ��� $dh - ���� \n		";
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
