<pre>
<?
ob_start ();
if ($_POST["��������"]=="��������/��������")
{
	$Go_to_base = $_POST;
	unset ($Go_to_base['��������']);
	unset ($Go_to_base['���']);
	unset ($Go_to_base['�������_�������']);
	unset ($Go_to_base['type']);
	//print_R ($Go_to_base);
	$DB_type=file ("base/".$_POST["���"]);
	$error=false;
	foreach ($DB_type as $str => $val)
	{
		$Org_base=explode("	",$val);
		$er=0;
		$ir=0;
		foreach($Go_to_base as $keyy => $vall)
		{
				$valll=$Org_base[$ir];
				if($vall==$valll)
				{
					if(++$er==count($Go_to_base))
					{
						print "<br>� ������ $str - ������� ��� ".(count($Go_to_base))." ����������";
						
						$Go_to_base;
						$i=0;
						foreach ($Go_to_base as $vopr => $v)
						{
							$Org_basee[]=array("$vopr"=>$Org_base[$i]);
							$i++;
						}
						$error=true;
						$WARNING[]=array("���������� � ������ $str"=>$Org_basee);
						unset ($Org_basee);
						$er=0;
					}
				}
				$ir++;
		}
	}
	if (isset($WARNING) and $error)
	{
		print "<br><H3>�������� ������� ������������ � ������</H3>";
		//print_r ($WARNING);
		$Bufer=ob_get_contents();
		ob_clean ();
		include ("anceta.php");
		if (isset ($_POST["�������_�������"]))
		{
			print "<font color=\"#800000\">WARNING</font> �������� ������ /������ ��� ������������ � ����/|$_POST[���]| - ������ �� ��������<br>".$Bufer;
		}
	}
	else
	{
		$f=fopen("Base/".$_POST["���"],"a");
		$string="";
		foreach($Go_to_base as $key => $val)
		{
			$string.=$val."	";
		}
			$string.="
";
		if (fwrite($f,$string) and	fclose($f))
		{
			print "<br>������ ������� ���������";
		}
		else
		{
			print '<br>���� <font color="#ff0000" >'.$_POST['���'].'</font> �� ����� ���� �����������';
		}
		include ("anceta.php");
	}
}
?></pre>