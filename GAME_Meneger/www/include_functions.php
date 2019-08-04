<?php
Function nik_data ($nik)//���������������� ������ �����
{
	$hash = md5($nik);
	if (is_dir("users/".$hash))
	{
		print "����� ������ $nik";
	  $nik_data	= load_user("users/".$hash."/user.set");
	  print $nik_data;
	  return $nik_data;	
	}
	else
	{
		return  new_user($nik,$hash);
	}
}


function new_user($nik,$hash)
{
		mkdir ("users/".$hash, 0700);
		print "����������� ����� ������������ $nik ! <br>";
		$work_nacledstvo = new_work_cenge("work");
		seve_data($work_nacledstvo,"users/".$hash."/user.set");
		return $work_nacledstvo;
}

//������ ���������� ��������� ���������� ��������� �������� -  
//����� ���������� ��������� ���� �������� � ��� ������������� 
function new_work_cenge($delay)
{
		$work = scan_folder(dirname (__FILE__)."/$delay/");
		shuffle ($work);
		
		include ( $wey = $work[rand(0,count($work)-1)]);//���������� ���� ������������ ������ � ��� ��� ���� ���������
		print "<h1>$wey</h1>";
		print_r ($work_data);
		return $work_data;
}

function seve_data($data,$wey,$metod = "w+",$perenos = "
")//��������� ���� ������
{
print "��� $perenos ���";
	if(($file = fopen($wey,"$metod")) && fwrite($file, serialize($data).$perenos) && fclose ($file))
	{
		return "���� ������� ��������";
	}
	else
	{
		return false;
	}
}

function load_data($way,$nomer = "all",$perenos = "
")//��������� ����� ����� $nomer �� �����
{
if (is_file($way))
{
	if ($nomer == "all" && $perenos =="
")
	{
		$data_file = file($way);
		unset($data_file[count($data_file)-1]);
		if (count ($data_file)>0)
		{
			foreach ($data_file as $key => $value)
			{
				$data[] = unserialize($value);
			}
			return $data;
		}
		else
		{
			print "<br>load_data ($way) -> ������ ����<br>";
		}
	}
	elseif($nomer == "all" && $perenos !="" && $perenos !="
")
	{
		$data_file = explode($perenos,trim(file_get_contents($way)));
		unset($data_file[count($data_file)-1]);
		foreach ($data_file as $key => $value)
		{
			if ($data[$key] = @unserialize($value))
			{}
			else
			{
				print "<br>�������� �������� ����������� $perenos";
			}
		}
		return $data;
	}
	elseif ( gettype ($nomer)=="integer")
	{
		$data_file = explode($perenos,trim(file_get_contents($way)));
		if($nomer < count($data_file))
		{
			return unserialize($data_file[$nomer]);
		}
	}
	else
	{
		print "��������� ��������� ������� $nomer $perenos $wey ";
		return false;
	}
}
return false;
}



function load_user($way)//��������� ���� ������
{
	if($Nic_data = file_get_contents ($way) )
	{
		  $Nic_data = unserialize($Nic_data);
	}
	else
	{
		print "Attention the user is not found";
		return false;
	}
return $Nic_data;
}


function scan_folder($wey)
{
	if ($dh = opendir($wey))
	{
   	 	while (false !== ($file = readdir($dh)))
		{
			if ($file != "." && $file != "..")
			{
				$work[]=$wey.$file;
			}
		}
		return $work = isset($work) ? $work : false;
	}
	else
	{
		return false;
	}
}

function luck ($against,$for,$happy)
{
	$start = 100;
	
	$center = $start/2+($start*$happy)/100;
	$for =rand(0,$start*($for-1)/100);
	$against = rand($center,$start-$start*$against/100);
	$resylt = rand ($for, $against+$start/4);
	//print $resylt ."-". $center;
	return $resylt  = $center > $resylt ? "good" : "Bad" ;
}

//..���������� ���������������� ���� ��������
function mark($p_min,$p_plus,$p_mult,$p_div,$happy)
{
	if ( luck ($p_min*$p_plus,$p_mult*$p_div,$happy) == "good" )
	{
		if (luck (rand(0,$p_mult),rand(0,$p_div),$happy) == "good")
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "*" : "/";
		}
		else
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "*" : "/";
		}
	}
	else
	{
		if (luck (rand(0,$p_min),rand(0,$p_plus),$happy) == "good")
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "+" : "-";
		}
		else
		{
			$snak = luck ($p_div,$p_mult,$happy) == "good" ? "+" : "-";
		}
	}
	
	return $snak;
}




function translete_allay ($neme_patt,$arrayr)//..�������  � ������ $neme_patt ���������� $arrayr
{
	$file=file_get_contents("forms/".$neme_patt );
// �� ������ ����������� :)))
	preg_match_all("|<!---([^>]+)--->|is", $file, $regs );
	
// � ������� regs[0] ����� ���������� ��� ��������� � ��������.
// � ������� regs[1] ��� ���������� � ������ ������� � �.�.

	$arrayzs = array ( );
	if ( isset ( $regs[0] ) )
	{
		foreach ( $regs[0] as $key => $val )
		{
			$arrayzs[$key] = $val;
		}
	}
	$AZ=count ($arrayr);
	$neme_patt=&$file;
	for ($i=0;$i<$AZ;$i++)
	{
		$neme_patt=str_replace ( $arrayzs[$i],$arrayr[$i],$neme_patt);
	}
	return $neme_patt;
}

function General_status($Nic_data,$Nic_data_cenge)//������ ���,����������,������,�������,����� ������,����,���� �� �������,�����
{
	;
}

function charges_status($Nic_data,$Nic_data_cenge)//������ ������,������,�������� �� �����,�������� �� �������,����� �� ������������,��������� �����
{
;
}

function income_status($Nic_data,$Nic_data_cenge)//������ �������,�� ��������������,�� ���������� �����,�� ���������� ���������,������� ��������,������,��������� ������
{
;
}

function common_status($Nic_data,$Nic_data_cenge)//������ ���������,������������,����� ����,����,������
{
;
}

function luck_status($Nic_data,$Nic_data_cenge)//������ �������/�����/ ,�� �������, �� �����,�� �������
{
;
}



function include_files_in_dir($dir)
{
	$i=0;
	if (is_dir($dir))
	{ 
	 	if ($dh = opendir($dir))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." )
				 {
					include (getcwd ()."/".$dir.$file);
					$i++;
				 }
			}
		}
	}
}


Function Nic_Creat_Cenge($wey)
{
	if ($wey <= 0)
	{
		$wey = "cenge/bad/";
		$Cenge_data = new_work_cenge($wey);
	}
	else
	{
		$wey = "cenge/good/";
		$Cenge_data = new_work_cenge($wey);
	}
}

//������� ������� ������ �������� � ���������� �������
function perebor($arr)
{ 
	for($i=$a=0;$i<count($arr);$i++)
	{
		if (!empty($arr[$i]))
		{
			$new[$a]=$arr[$i];
			$a++;
		}
	}
	return $new;
}

?>

