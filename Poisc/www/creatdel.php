<?php
//$dlnc=fopen("log.txt"."x+")
if (file_exists("log.txt"))
{
	print "<H1>�������� �������� ���� �������� ������</H1>";
	//$otcr=Fopen(log.txt,"r");//������ ������ ��� ������
	$s = file("log.txt");
	$a = array();
		for ($i = 0; $i < count($s) ; $i++) //׸ ��������� count ���������� ����� ����� 
		{
		//$a[] = $s[$i]; //��������� � ������ ������ �� ��������� �������
			if(file_exists(trim($s[$i])))
			{
			unlink(trim($s[$i]));
			print "<br> ��� ������ - ".$s[$i];
			}
				else
				{
				Print "<br>���� - |".$s[$i]."������������" ;
				}
		}
/*
print " ���� ��� �������";
while ($i != 0)
{
--$i;
print $a[$i]."<br>";
}
}

 $path_to_php ." ". 
*/
}
ELSE
{
print "<H1>������-1 log.txt ��� ������ ��� � ��� �� ����������� ������� ������</h1>";
}
print "<br> <H1>�������� ���������</h1>";


$this_dir = dirname(__FILE__) ."\\";
print $this_dir."<br>";
system ($this_dir . "1.wav" );
?>
<a href="erlog.php"><br>�������� ���</a>