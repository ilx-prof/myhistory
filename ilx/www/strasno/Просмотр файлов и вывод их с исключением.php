<h2> Выбери фрактал</h2>

<pre><p align="center">
<?php
@unlink(getcwd ()."\FRATALS.CodeSweeper");
if (is_dir(getcwd ()."\FRATALS"))
	{ 
	 	if ($dh = opendir(getcwd ()."\FRATALS"))
	 	{
     	 	 while (false !== ($file = readdir($dh)))
			 {
				 if ($file != "." && $file != ".." && $file != "imege.php" && $file != "Logic" && $file != "Fractal_seve" )
				 {
					$rid= '<table align="center" border="1" >
								<tr><td><a href="FRATALS/';
					$dir ='"><H1>'.$file.'</H1></a>
								</tr></td>
							</table>';
				 print $rid.$file.$dir;
				 }
				}
			}
		}
?>
</p></pre>
