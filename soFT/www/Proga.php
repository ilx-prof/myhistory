<pre>
<?php
copy ("Proga.php","Proga.bac");
$WAY = $_POST['papca'];
function print_VAR()
{
	$a = array_slice (get_defined_vars(),0);
	print_r (array_keys($a));
	$a = get_defined_functions();
	print_r ($a['user']);
}

$file_copy=array("tilde.gif","Skeleton.gif","new.gif","Hend.gif","back1.gif","crack.txt","readme.txt","readme_rus.txt");

function copy_files ($file_copy)
{
global $WAY;
if (!file_exists($WAY."\\$file_copy"))
{
copy ("$file_copy",$WAY."\\$file_copy");
print "<br>��������� ���� $file_copy";
}
}

array_walk ($file_copy,'copy_files');


function randomes_gif()
{
$i=rand (1,4);
switch ($i) {
    case 1:
        return "new.gif";
        break;
    case 2:
        return "tilde.gif";
        break;
    case 3:
        return "Hend.gif";
        break;
	case 4:
        return "Skeleton.gif";
        break;
}
}
function Categoria ($WAY)//����� �������� ������������� �������
{
$a=0;
$idprograms = 0;
	if (is_dir($WAY))
	{
	 	if ($dh = opendir($WAY))
	 	{
			  while (false !== ($file = readdir($dh)))
			 {
				 if ($file != "." && $file != "..")
				 {
						if (TRUE==is_dir($WAY.$file))
						{
							print "<br><br>��� ���������� ".$WAY.$file;
							if($contein = @file($WAY.$file."/contein.txt"))
							{
								$soft[]=$contein[0];
								print "- ��� �������� ����� ����� �������� - <h3>".$soft[$a]."</h3>";
								$a++;
								unlink($WAY.$file."/contein.txt");
							}
							else
							{	$contein[0]=$file;
								$soft[]=$contein[0];
								print "- ��� �������� ����� ����� �������� - <h3>".$soft[$a]."</h3>";
								$a++;
							}
									 	if ($dd = opendir($WAY.$file))
									 	{	
											print "<br>������ ���������� - ".$WAY.$file;
											 $b=0;
								     	 	 while (false !== ($fileL = readdir($dd)))
											 {
												 if ($fileL!= "." && $fileL != "..")
												 {
													if (TRUE==is_dir($WAY.$file."\\".$fileL))
													{
														$soft[$contein[0]][]=$fileL;
														print "<br><br>��� ���������� ".$WAY.$file."\\".$fileL."<br>";
														$idprograms ++;
															if(file_exists($WAY.$file."\\".$fileL."\\".$fileL.".exe"))
															{	
																$soft[$contein[0]][$fileL][0]=$file."\\".$fileL."\\".$fileL.".exe";
																PRINT " - ������ *.EXE ���� ��������� ��������� - ".$WAY.$file."\\".$fileL."\\".$fileL.".exe <br>";
															}
															elseif(file_exists($WAY.$file."\\".$fileL."\\".$fileL.".msi"))
															{	
																$soft[$contein[0]][$fileL][0]=$file."\\".$fileL."\\".$fileL.".msi";
																PRINT " - ������ *.MSI ���� ��������� ��������� - ".$WAY.$file."\\".$fileL."\\".$fileL.".msi <br>";
															}
															elseIF(file_exists($WAY.$file."\\".$fileL."\\setup.exe"))
															{
																$soft[$contein[0]][$fileL][0]=$file."\\".$fileL."\\setup.exe";
																PRINT " - ������ ���� Setup.exe ��������� ��������� - ".$WAY.$file."\\".$fileL."\\"."Setup.exe <br>";
															}
															elseIF(file_exists($WAY.$file."\\".$fileL."\\setup.msi"))
															{
																$soft[$contein[0]][$fileL][0]=$file."\\".$fileL."\\setup.msi";
																PRINT " - ������ ���� Setup.msi ��������� ��������� - ".$WAY.$file."\\".$fileL."\\"."Setup.msi <br>";
															}
															else
															{
																$soft[$contein[0]][$fileL][0]=$file."\\".$fileL;
																print '<font color="#ff0000"> - ������������ ���� �� ������ </font>'."<br>";
															}
															
															if(file_exists($WAY.$file."/".$fileL."/ReadMe_rus.txt"))
															{	
																if (rename($WAY.$file."/".$fileL."/ReadMe_rus.txt",$WAY.$file."/".$fileL."/ReadMe_rus.htm"))
																{
																	print "- ������ ���� ������� � ������� txt ��������� ������������� ".$WAY.$file."/".$fileL."/ReadMe_rus.txt"." -> <font color=\"#8C85D3\">".$WAY.$file."/".$fileL."/ReadMe_rus.htm"."</font>  <br>";
																	$soft[$contein[0]][$fileL][1]=$file."\\".$fileL."\\ReadMe_rus.htm";
																	
																}
																else
																{
																	print "<font color=\"#ff0000\">��������� ������������".$WAY.$file."/".$fileL."/ReadMe_rus.txt"." -> ".$WAY.$file."/".$fileL."/ReadMe_rus.htm"."</font>  <br>";
																}
																
															}
															elseif (file_exists($WAY.$file."/".$fileL."/ReadMe_rus.htm"))
															{
																$soft[$contein[0]][$fileL][1]=$file."\\".$fileL."\\ReadMe_rus.htm";
																PRINT " - ������ ���� ������� ".$soft[$contein[0]][$fileL][1]."<br>";
															}
															else
															{
																$soft[$contein[0]][$fileL][1]="ReadMe_rus.txt";
																print '<font color="#0000ff"> - ���� ���� ������� �� ������ </font>'."<br>";
															}
															if(file_exists($WAY.$file."\\".$fileL."\\"."Crack.exe"))
															{
																$soft[$contein[0]][$fileL][2]=$file."\\".$fileL."\\"."Crack.exe";
																PRINT " - ������ ���� Crack.exe - ".$soft[$contein[0]][$fileL][2]."<br>";
															}
															elseIF(file_exists($WAY.$file."\\".$fileL."\\"."Crack.msi"))
															{
																$soft[$contein[0]][$fileL][2]=$file."\\".$fileL."\\"."Crack.msi";
																PRINT " - ������ ���� Crack.exe - ".$soft[$contein[0]][$fileL][2]."<br>";
															}
															elseIF(file_exists($WAY.$file."\\".$fileL."\\"."Crack.rar"))
															{
																$soft[$contein[0]][$fileL][2]=$file."\\".$fileL."\\"."Crack.rar";
																PRINT " - ������ ���� Crack.rar - ".$soft[$contein[0]][$fileL][2]."<br>";
															}
															else
															{
																$soft[$contein[0]][$fileL][2]="crack.txt";
																print '<font color="#ff00ff"> - ���� Crack.*(rar,msi,exe) �� ������ </font>';
																PRINT " ";
															}
															$soft[$contein[0]][$fileL][5]=$file."\\".$fileL;
													}
													else {print "<br>file".$WAY.$file."/".$fileL;}
											 	} 
												$b++;
											}
									}
			 		}
				}
			}
		}
	}
return array($soft,$idprograms);
}
//*************************
function processing_array ($soft,$WAY)//����� ���� � ������������� �������� + ���� � ��������� 2 ������ 
{
global $Categoria;
//----------------------------���������� �������
	$writ_Coder='<head><style>
	.normal1	{color:#FFFFFF; font-size: larger}
	.normal2    {color:#FFFFFF; font-family: Comic Sans MS; font-size: x-small; font-weight: bold}
	.normal3	{color:#990000; font-family: Comic Sans MS; font-size: x-small; font-weight: bold}
	.Upperlink	{color:#999999; font-family: Comic Sans MS; font-size: x-small; font-weight: bold; text-decoration: none}
	.Upperlink2	{color:#796AD0; font-family: Comic Sans MS; font-size: x-small; font-weight: bold; text-decoration: none}
	.nlink		{color:#FFFF33; font-family: Comic Sans MS; font-size: larger; text-decoration: blink}
	.llink		{color:#00CCFF; font-family: Comic Sans MS; font-size: x-small; text-decoration: none}
	.linkYellow {color:#FFFF33; font-family: Comic Sans MS; font-size: x-small; font-weight: lighter; text-decoration: none }
	</style>
	</head>
	<table align="center">
		<tr><td align="center">
			<body bgcolor="#000000" text="#00CCCC" link="#FFFF00">
				<p class="Upperlink" align="center">
				<hr><a href="'.$WAY.'"><font class="Upperlink2" >��� ���� - �������� ['.count($soft).'] �������� - '.$Categoria[1].'</font></a>
				<hr>
				<a name="home"></a>';
	$writ_buka='';
	if ($Coderganie = fopen("Coderganie.php",'w') and $buka = fopen("buka.php",'w'))
	{
		print "<br>������ ���� Coderganie.php � buka.php";
		fwrite ($Coderganie,$writ_Coder);
		fwrite ($buka,$writ_buka);
	}
	else
	{
		print "<br>���� �� ������";
	}
//----------------------------
//��������� �������
	if (is_array($soft))
	{	
		$Nasvanie_rus=0;
//		..����� ��������� �������� � �����������
		while (next($soft))
		{
			 if($Nasvanie_rus==0)
			 {//�������� �������
					prev($soft);
					//11111111111111111111111111111����� ������ ������� ������ �������
					$writ_Coder='<a href="#'.current($soft).'" class="Upperlink">'.current($soft).'</a><br>';
					$writ_buka='<table border="1" width="510" height="25" bordercolor="#FFFF00" bgcolor="#006666" align="center">
				<tr><td colspan="3" height="13">

			 	    <p align="center"><font color="#FFCC33">&nbsp;</font>
					 <a href="'.$WAY.current($soft).'"><font size="4" color="#FFCC33"><strong>'.current($soft).'</strong></font></a><a name="'.current($soft).'"></a>
					</td>
					<td width="30" height="13"><a href="#home"><img src="back1.gif" width="30" height="18" border="0"></a>
					</td>
				</tr>
			</table>';
	      			fwrite ($Coderganie,$writ_Coder);
					fwrite ($buka,$writ_buka);
							$Proga=0;
							while (next($soft[current($soft)]))
							{
								if($Proga==0 )//���������� - ������ ���������
								{
									print "<br><br> ������ - ".(current($soft));
									prev($soft[current($soft)]);
									print "<H2>".current($soft[current($soft)])."</h2>";
									$writ_buka='<table border="0"  bordercolor="#000000" width="510" height="65" align="center">
			  	<tr><td width="62" rowspan="2" height="63"> 
			     	 <p align="center"><img src="'.randomes_gif().'" width="50" height="40" alt="ImageFile"> 
			    	  </td>
					  <td colspan="3" height="30">
								  <strong>
				  				<a href="'.$soft[current($soft)][current($soft[current($soft)])][5].'"><font face="MS Sans Serif" class="normal1" color="#00FF00">&nbsp;'.current($soft[current($soft)]).'</font></a>
					  </strong>
					  </td>
				</tr>
				<tr>
			  		  <td width="112" height="32"> 
				  		  <p align="center">
						  <a href="'.$soft[current($soft)][current($soft[current($soft)])][1].'"><font face="MS Sans Serif"size="2"><span class="llink"><b><font color="#66FF00">� ���������</font></b></span></font></a>
					  </td>
			  		  <td width="238" height="32"> 
     					<p align="center">
				  		<a href="'.$soft[current($soft)][current($soft[current($soft)])][2].'" face="MS Sans Serif" color="#ffff00" size="2">����</font></a> 
			   		 </td>
			  		 <td width="86" height="32"> 
    					<p align="center">
						<a href="'.$soft[current($soft)][current($soft[current($soft)])][0].'"><small><font face="MS Sans Serif"><span class="llink"><font color="#00FFFF"><b>����������</b></font></span></font></small></a> 
				 	 </td>
			  	</tr>
			</table>';
									fwrite ($buka,$writ_buka);
//									print_r ($soft[current($soft)][current($soft[current($soft)])]);
									$Proga++;//��� �� ������ ���������
									next($soft[current($soft)]);
								}
								else//���������� - ��� �� ������ ���������
								{
									if (is_array($soft[current($soft)]) and !is_int(key($soft[current($soft)])))
									{
										print "<h2>".key($soft[current($soft)])."</h2>";
										$writ_buka='<table border="0" width="510" height="65" align="center">
			  	<tr><td width="62" rowspan="2" height="63"> 
			     	 <p align="center"><img src="'.randomes_gif().'" width="50" height="40" alt="ImageFile"> 
			    	  </td>
					  <td colspan="3" height="30">
								  <strong>
				  				<a href="'.$soft[current($soft)][key($soft[current($soft)])][5].'"><font face="MS Sans Serif" class="normal1" color="#00FF00">&nbsp;'.key($soft[current($soft)]).'</font></a>
					  </strong>
					  </td>
				</tr>
				<tr>
			  		  <td width="112" height="32"> 
				  		  <p align="center">
						  <a href="'.$soft[current($soft)][key($soft[current($soft)])][2].'"><font face="MS Sans Serif"size="2"><span class="llink"><b><font color="#66FF00">� ���������</font></b></span></font></a>
					  </td>
			  		  <td width="238" height="32"> 
     					<p align="center">
				  		<a href="'.$soft[current($soft)][key($soft[current($soft)])][1].'" face="MS Sans Serif" color="#ffff00" size="2">����</font></a> 
			   		 </td>
			  		 <td width="86" height="32"> 
    					<p align="center">
						<a href="'.$soft[current($soft)][key($soft[current($soft)])][0].'"><small><font face="MS Sans Serif"><span class="llink"><font color="#00FFFF"><b>����������</b></font></span></font></small></a> 
				 	 </td>
			  	</tr>
			</table>';
									fwrite ($buka,$writ_buka);
									}
								}
							
							}
							$Nasvanie_rus++;
				}
				else
				{
					if (!is_array(current($soft)))
					{
					print "������ - ".(current($soft));// ����������� ��������
					
					$writ_Coder='<a href="#'.current($soft).'" class="Upperlink">'.current($soft).'</a><br>';
					$writ_buka='<table border="1" width="510" height="25" bordercolor="#FFFF00" bgcolor="#006666" align="center">
				<tr><td colspan="3" height="13">
			 	    <p align="center"><font color="#FFCC33">&nbsp;</font>
					 <a href="'.$WAY.current($soft).'"><font size="4" color="#FFCC33"><strong>'.current($soft).'</strong></font></a><a name="'.current($soft).'"></a>
					</td>
					<td width="30" height="13"><a href="#home"><img src="back1.gif" width="30" height="18" border="0"></a>
					</td>
				</tr>
			</table>';
	      			fwrite ($Coderganie,$writ_Coder);
					fwrite ($buka,$writ_buka);
							$Proga=0;
							while (next($soft[current($soft)]))
							{
								if($Proga==0 )//���������� - ������ ���������
								{
									prev($soft[current($soft)]);
									print "<H2>".current($soft[current($soft)])."</h2>";
									$writ_buka='<table border="0"  bordercolor="#000000" width="510" height="65" align="center">
			  	<tr><td width="62" rowspan="2" height="63"> 
			     	 <p align="center"><img src="'.randomes_gif().'" width="50" height="40" alt="ImageFile"> 
			    	  </td>
					  <td colspan="3" height="30">
								  <strong>
				  				<a href="'.$soft[current($soft)][current($soft[current($soft)])][5].'"><font face="MS Sans Serif" class="normal1" color="#00FF00">&nbsp;'.current($soft[current($soft)]).'</font></a>
					  </strong>
					  </td>
				</tr>
				<tr>
			  		  <td width="112" height="32"> 
				  		  <p align="center">
						  <a href="'.$soft[current($soft)][current($soft[current($soft)])][2].'"><font face="MS Sans Serif"size="2"><span class="llink"><b><font color="#66FF00">� ���������</font></b></span></font></a>
					  </td>
			  		  <td width="238" height="32"> 
     					<p align="center">
				  		<a href="'.$soft[current($soft)][current($soft[current($soft)])][1].'" face="MS Sans Serif" color="#ffff00" size="2">����</font></a> 
			   		 </td>
			  		 <td width="86" height="32"> 
    					<p align="center">
						<a href="'.$soft[current($soft)][current($soft[current($soft)])][0].'"><small><font face="MS Sans Serif"><span class="llink"><font color="#00FFFF"><b>����������</b></font></span></font></small></a> 
				 	 </td>
			  	</tr>
			</table>';
									fwrite ($buka,$writ_buka);
									$Proga++;//��� �� ������ ���������
									next($soft[current($soft)]);
								}
								else//���������� - ��� �� ������ ���������
								{
									if (is_array($soft[current($soft)]) and !is_int(key($soft[current($soft)])))
									{
										print "<h2>".key($soft[current($soft)])."</h2>";
										$writ_buka='<table border="0" width="510" height="65" align="center">
			  	<tr><td width="62" rowspan="2" height="63"> 
			     	 <p align="center"><img src="'.randomes_gif().'" width="50" height="40" alt="ImageFile"> 
			    	  </td>
					  <td colspan="3" height="30">
								  <strong>
				  				<a href="'.$soft[current($soft)][key($soft[current($soft)])][5].'"><font face="MS Sans Serif" class="normal1" color="#00FF00">&nbsp;'.key($soft[current($soft)]).'</font></a>
					  </strong>
					  </td>
				</tr>
				<tr>
			  		  <td width="112" height="32"> 
				  		  <p align="center">
						  <a href="'.$soft[current($soft)][key($soft[current($soft)])][1].'"><font face="MS Sans Serif"size="2"><span class="llink"><b><font color="#66FF00">� ���������</font></b></span></font></a>
					  </td>
			  		  <td width="238" height="32"> 
     					<p align="center">
				  		<a href="'.$soft[current($soft)][key($soft[current($soft)])][2].'" face="MS Sans Serif" color="#ffff00" size="2">����</font></a> 
			   		 </td>
			  		 <td width="86" height="32"> 
    					<p align="center">
						<a href="'.$soft[current($soft)][key($soft[current($soft)])][0].'"><small><font face="MS Sans Serif"><span class="llink"><font color="#00FFFF"><b>����������</b></font></span></font></small></a> 
				 	 </td>
			  	</tr>
			</table>';
									fwrite ($buka,$writ_buka);
									}
								}
							}
				 		}
				}
					@$M++;
		}//������ �� ��� ���������� ����� �������� ��������� � ��� ��� ������������ �����jqn ������
	}
	else
	{
		print "ne massiv<br>";
	}//�������� ������� 
	$writ_buka='<hr>
</td></tr>
</table>
</body>';
	$writ_Coder='<hr>';
	fwrite ($buka,$writ_buka);
	fwrite ($Coderganie,$writ_Coder);
	fclose($Coderganie);
	fclose($buka);
}
//**********************
function OpenWrite($WAY,$writ,$w)
{
	if ($Coderganie = fopen($WAY."Katalog.htm",$w))
	{
      fwrite ($Coderganie,$writ);
	}
	else {print "<br>���� �� ������";}
	fclose($Coderganie);
}

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-----����������------!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\\
$Categoria = Categoria($WAY);
$SOFT = $Categoria[0];
//print_r ($SOFT);
processing_array ($SOFT,$WAY);
OpenWrite($WAY,file_get_contents("Coderganie.php"),"w+");
OpenWrite($WAY,file_get_contents("buka.php"),"a+");
exec($WAY."Katalog.htm");
?>
</pre>
