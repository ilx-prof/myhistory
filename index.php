<pre><p align="center">
<?php
if (is_dir(getcwd ()))
	{ 
	$wey=getcwd ();
	$ar=array();
	$table='<body bgcolor="#c0c0c0"><table width="100%">
	<tr>
			<td align="left">
				<h3>Проект</h3>
			</td>
			<td>
				<h3>Постледнее изменеие</h3>
			</td>
			<td>
				<h3>Послендний доступ</h3>
			</td>
	</tr>
							';
	 	if ($dh = opendir($wey))
	 	{
     	 	 while (false !== ($file = readdir($dh)))
			 {
				 if ($file != "." && $file != ".." && is_dir( $wey."/".$file))
				 {
				 	$A=lstat ($wey."/".$file);
					$fil=$file;
					if (is_dir( $wey."/".$file."/www"))
					{
						$fil=$file;
						$file.="/www/";
					}
				 	$table.='<tr>
								<td align="left">
									&nbsp;<a href="'.$file.'"><font face="Comic Sans MS" color="#0000ff">'.$fil.'</font></a>
								</td>
								<td>'
									.@strftime ("%b %d %Y %H:%M:%S",@filemtime  ($wey."/".$file)).'
								</td>
								<td>
									'.strftime ("%b %d %Y %H:%M:%S",fileatime ($wey."/".$file)).'
								</td>
			';
				 }
				}
				closedir($dh);
			}
		}
	print $table.'</table></body>';
?>