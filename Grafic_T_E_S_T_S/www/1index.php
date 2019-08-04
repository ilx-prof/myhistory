<h2> Типа галерея картинок</h2>

<pre><p align="center">
<?php
//unlink(getcwd ()."\Imege".) 
if (is_dir(getcwd ()."\Imege"))
	{ 
	 	if ($dh = opendir(getcwd ()."\Imege"))
	 	{
     	 	 while (false !== ($file = readdir($dh)))
			 {
				 if ($file != "." && $file != ".." )
				 {
					$rid= $file.'<table align="center" border="1" >
								<tr><td><img align="absmiddle" height="100%"  width="100%" "src="Imege/';
					$dir ='">
								</tr></td>
							</table>';
				 print $rid.$file.$dir;
				 }
				}
			}
		}
?>
</p></pre>
