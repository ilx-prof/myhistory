<pre>
<center><a href="/">index</a></center>
<?php
#copy ("Proga.php","Proga.bac");

print_R ($_GET);
$dir = $_GET['papca'];
$struct = $_GET['Struct'];
$folders= array();
if (isset ($_GET['wey']))
{
	copytofold();
}

vhod_prosmotr ($dir,0,$folders);
arsort ($folders);
print_r ($folders);
load($dir,$folders);

function copytofold()
{
	if (file_exists($_GET['img']) and is_dir($_GET['wey']) and copy ($_GET['img'],$_GET['wey']."/".basename($_GET['img'])) )
	{	
		print "���� ���������� � ". $_GET["wey"] ."<br>";
		if ( file_exists ( $_GET['img'] ) )
		{
			unlink($_GET['img']);
			print "������ �� ����� ". dirname ( $_GET["img"] ) ."<br>";
		}
		if ( file_exists ( "temp/".basename($_GET['img']) ) )
		{
			unlink( "temp/".basename($_GET['img']) );
			print "������ �� temp <br>";
		}
	}
	else
	{
		print "���������� �� �������<br>";
	}
}
function folders ($dir)
{
	$tmp = explode("/",trim($dir));
	return $tmp [count($tmp)-1];
}


FUNCTION matrca ($arr,$sir)
{
	$count=count($arr);
	$print="<table cellpadding=\"0\" cellspacing=\"0\">";
	$i=0;
	while($i<$count-1)
	{
		$print .="<tr>";
		$a=0;
		while($a++-1<=$sir and isset($arr[$i+++1]))
		{
			$print .= "<td>";
			$print .= $arr[$i-1];
			$print .="</td>";
		}
			$print .= "</tr>";
	}
	$print .="</table>";
	return $print;
}



function load($dir,$folders)
{
$Array = array();
if ($dh = opendir($dir))
	{
		while (false !== ($file = readdir($dh))) 
		{
				if ($file != "." && $file != ".." && $file!=get_current_user ())
				{
						if (!is_dir($dir."/".$file) and $file != "Thumbs.db" and $file != "Desktop.ini")
						{
							$And="";
							foreach($folders as $name => $wey)
							{
								$And .="<a href=\"Proga.php?
								img=$dir"."\\"."$file
								&papca=".$_GET['papca']."
								&Struct=".$_GET['Struct']."
								&wey=$wey\">".$name."</a> &nbsp;";
							}
							if (!file_exists("temp/".$file))
							{
								copy ($dir."\\".$file,"temp\\".$file);
								print "<br>���� -".$file." ���������� �� ��������� ����������";
							}
							$Array[]='<img src="temp\\'.$file.'" width="40%" height="40%" ><br>'.$And;
						}
				}
		}
	}
	closedir($dh);
	//print_R($Array);
	print matrca ($Array,2);
}



function vhod_prosmotr ($dir,$a,$folders)
{
global $folders;
$r=0;
if (is_dir($dir))
{
@$a++;
    if ($dh = opendir($dir))
	 {
     	   while (false !== ($file = readdir($dh))) 
		   {
				if ($file != "." && $file != ".." && $file!=get_current_user ())
				{
						if (!is_dir($dir."\\".$file))
						{
						}
						else
						{
							print $file ."<br>";
							$folders [$file] = ($dir."\\".$file);
							vhod_prosmotr($dir."\\".$file,$a,$folders);
						
						}
				}
			}
		
    }
	closedir($dh);
}
}


FUNCTION creit_obras($Wey,$f_d)//�����  ���������� ����� ����� ������� ������ �������������� ������ ����� ��������� ������� � ������� ������ ������� �.�. ���������� ����� �������� �� ����� ������� ����� ������ ��������� �� ����� ��� ���� �������� �������� ����� � ����� ���� ��������� ����� � �� stat ($Wey)
{
	if($f_d == "d")
	{
		mkdir (get_current_user ()."\\".str_replace (":","",$Wey), 0700);
	}
	if($f_d == "f")
	{
		$W=fopen (get_current_user ()."\\".str_replace (":","",$Wey),"w+");
		fwrite($W,filesize($Wey));
			fclose($W);
	}
}





function print_VAR()
{
	$a = array_slice (get_defined_vars(),0);
	print_r (array_keys($a));
	$a = get_defined_functions();
	print_r ($a['user']);
}
?>
</pre>