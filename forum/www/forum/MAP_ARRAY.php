<?php
function Categoria_MAP ($INP)//����� �������� ������������� ������� ������
{
	ob_start ( );
	$a=0;
	$WAY="Categoria/";
	if (is_dir($WAY))
	{
		if ($dh = opendir($WAY))
		{
			while (false !== ($file = readdir($dh)))
			{
				if ($file != "." && $file != "..")
				{
					if (TRUE==is_dir($WAY.$file) && file_exists($WAY.$file."/Avtor_cat.rul"))
					{
						print "<br><br>��� ���������� ".$WAY.$file."<br>";
						print "<br>���� ��������� ���������� ".$WAY.$file."/Avtor_cat.rul<br>";
						print "���������� ��������� - <h3>".$file."</h3>";
						$soft[]=$file;
						$soft[$file][0]=$WAY.$file."/Avtor_cat.rul";
						if ($dd = opendir($WAY.$file))
					 	{
							print "<br>������ ���������� - ".$WAY.$file;
							while (false !== ($fileL = readdir($dd)))
							{
								 if ($fileL!= "." && $fileL != "..")
								 {
									if (TRUE==is_dir($WAY.$file."/".$fileL))
									{
										$soft[$file][]=$fileL;
										print "<br>��� ���������� ".$WAY.$file."/".$fileL."<br>";
										if ($fd = opendir($WAY.$file."/".$fileL))
								 		{
											while (false !== ($fileLL = readdir($fd)))
											{
												if (TRUE==is_file($WAY.$file."/".$fileL."/".$fileLL))
												{
													$soft[$file][$fileL][]=$fileLL;
													//print "<br>���� ������ ������ ".$WAY.$file."\\".$fileL."\\".$fileLL;
													if($fileLL=="Avtor_tems.rul")
													{
														print $WAY.$file."/".$fileL."/".$fileLL."- ��� ���� ������� �������� ����� ��� ������ <br>";
													}
													elseif($fileLL=="SNIF.snif")
													{
														print $WAY.$file."/".$fileL."/".$fileLL."- ��� ���� ������� �������� ����� ��� ���������<br>";
													}
														elseif($fileLL=="Scaler.sc")
													{
														print $WAY.$file."/".$fileL."/".$fileLL."- ��� ���� ������� �������� ����� ��� ���������� ���������� <br>";
													}
													else
													{
														print $WAY.$file."/".$fileL."/".$fileLL." - ���� �������<br>";
														//unlink($WAY.$file."/".$fileL);
													}
												}
											}
											Closedir($fd);
										}
									}
								}
							}
							Closedir($dd);
						}
			 		}
				}
			}
			Closedir($dh);
		}
	}
	$INPUT = ob_get_clean ( );
	IF ($INP==TRUE)
	{
		PRINT $INPUT;
	}
	return $soft;
}
?>

