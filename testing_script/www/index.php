
<pre>
<?php 

set_time_limit(0);
print_R ($_POST);
if(Isset($_POST['GO']))
{
	function getmicrotime() 
	{ 
  		list($usec, $sec) = explode(" ", microtime()); 
	  	return ((float)$usec + (float)$sec); 
	}

	function Creat_exp($exp)
	{
	fwrite ($f=fopen("expension.php","w+"),"<?php function go(){".$exp."} ?>");
		fclose ($f);
	}

	function cycle_while_os(&$time)
	{
			$I=$_POST['I']+1;
			$time_start = getmicrotime();
			while (0 < $I--);
			$time_end = getmicrotime();
			$time["����� ���������� ����������� �����"] = ($time_end - $time_start);
			$time["����� ���������� ����� ��������"]= $time["����� ���������� ����������� �����"]/($_POST['I']*4);
			$time["�������� ����������������� �������"]= 1/$time["����� ���������� ����� ��������"]." �������� � �������";
	}
	function cycle_wihle_exp(&$time)
	{
		if (isset($_POST['metod']))
		{
			if($_POST['metod']=="one")
			{
				$I=$_POST['I']+1;
				Creat_exp($_POST['exp']);
				include_once("expension.php");
				$time_start = getmicrotime();
				while (0 < $I--){go();}
				$time_end = getmicrotime();
				$time["����� ���������� ������� ���� ��������� ����������� �������"] = $time_end - $time_start;
				$time["����� ���������� �� ���������� �������������� �������"] = $time["����� ���������� ������� ���� ��������� ����������� �������"]-$time["����� ���������� ����������� �����"];
			}
			elseif($_POST['metod']=="echo")
			{	$I=$_POST['I']+1;
				$exp = $_POST['exp'];
				$time_start = getmicrotime();
				while (0 < $I--){echo `$exp`;}	
				$time_end = getmicrotime();
				$time["����� ���������� ������� ���� ����� ������"] = $time_end - $time_start;
				$time["����� ���������� �� ���������� �������������� �������"] = $time["����� ���������� ������� ���� ����� ������"]-$time["����� ���������� ����������� �����"];
			}
		}
	}
	
	$time = array ();
	cycle_while_os($time);
	cycle_wihle_exp($time);
	print_r ($time);
	//echo "<br> wihle ������� for � $tir ��� ����� $i �������� �� $tim ������";
}
?>
<form action="index.php" method="post">
���������� �������� ��� ������� ����� $i<br>
<input type="Text" name="I"  value="<? print $i = isset($_POST['I'])? $_POST["I"]:10000;?>"><br>
<input type="Radio" name="metod"  value="one" <? print $i = isset($_POST['metod']) && $_POST['metod']=='one'? " checked": "";?>>����� ��������� �����������<br>
<input type="Radio" name="metod"  value="echo" <? print $i = isset($_POST['metod']) && $_POST['metod']=='echo'? " checked": "";?> >����� ������� �����<br>
<textarea name="exp" rows="15" cols="100" wrap="off"><? if (isset($_POST['exp'])){print $_POST["exp"];}?></textarea>
<input type="Submit" name="GO"  value="GO">
</form>
</pre>