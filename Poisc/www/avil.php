<?php
//print_r ($_POST);
//��������� ���������� ����������
$skoko = $_POST['skoko']['skoko'];
$directoria = $_POST['skoko']['directoria'];
$ogran = $_POST['skoko']['ogran'];
//������� ���������� ����������
if(!is_dir($directoria))
{
	if (mkdir ($directoria,0700))
	{
		print "<h1>���������� ".$skoko." ������</h1> � ���������� F:\\WebServers\\home\\Poisc\\www\\".$directoria;
	}
}

//���������� ���� �������
$today = date("F j, Y, g:i a"); 

//������������� ��������� ���������� ������ ��� ����� �����
Settype ($skoko,"integer");

//����������� var ��� "��������"
$dop='a+';//������� ������� ���� ��������� ���� ��� ������ � ������ -- ��������� � ����� �����. ���� ���� �� ���������� - �������� ��� ������. 
$rem='w+';//������� ������� ���� ��������� ��� ������ � ������ � �������� ���� �� ������� ������

//������� �������
function add($name,$dop)
	{
//��������� ���������� ����� � ����� ���������� � ���� ����� �����
		$fil=Fopen("log.txt",$dop);
		fwrite($fil,$name);
		fwrite($fil,"
");
		print "<br> add in log.txt -->- ".$name;
//�������� ����������
		fclose ($fil);
	}
	
//������� �������
function stime() 
		{ 
  			  list($usec, $sec) = explode(" ", microtime()); 
  			  return ((float)$usec + (float)$sec); 
		}

//������������� ��������������� ����������
$a=0;
$ogidanie = 0;
//���� ���������� $a ������ $skoko ���������
$Start_time = stime();

while($a<$skoko)
{
if( $ogidanie < $ogran)
{
		//������������� ��� �����
		$neme=$directoria."\\".rand().".php";
		// ��������� � ������ ����� � 
				//���� ��������� ����������� ���������
		if (copy("avil.php",$neme))
		{
			print "<br>������ ���� � ������ - |".$neme."|";
			$a++;
			//���������� ��� ����� � ���
			add($neme,$dop);
		}
$Stop = stime();
$ogidanie = $Stop-$Start_time;
print "<h3>�� $ogidanie ��� $a ������ </h3>";
}
else{break;}
}
$Stop_time = stime();
print "<br>�������� ������ ������� ".($Stop_time-$Start_time)."sek �� ��������� $ogran sek <br> ������� $a ������ �� $skoko ";
//��������� ���� � ������ � ������� ������ �������


$s = file("StatusCreit.txt");
	$colvo = $s[0]+$a;
	
$stat = fopen("Status.txt", $dop);
	Fwrite ($stat,$today." ������� ".$a." ������
");
fclose($stat);

$stat=Fopen("StatusCreit.txt",$rem);
	fwrite($stat,$colvo);
		print "<br>���� ������� ��������";
fclose($stat);
print "<br>���� �������� ������� ��� ����� <a href=\"Status.php\">".$colvo."</a> ������";


?>
<a href="dir.php"><br>����� ����������� �����</a>
<a href="Status.php"><br>������</a>
<a href="index.php"><br>���������</a>
<a href="log.txt"><br>���������� log.txt</a>

