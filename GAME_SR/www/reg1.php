<?php 
//��������� ����������� ������
	copy("reg.php","reg1.bac");
if(isset($_POST['Reg']['delay']) and $_POST['Reg']['delay'] =="Delay")
{
//���������� ���������
$dir = dirname (__FILE__)."\\Uzerconfig\\";
$data = date("F j, Y, g:i a");
$Nic = ( $_POST['Reg']['Nic']);
$parol = $_POST['Reg']['Login'];
$povtorparol = $_POST['Reg']['Loginp'];
$mail = $_POST['Reg']['mail'];
$pol = $_POST['Reg']['pol'];
$Age = $_POST['Reg']['Age'];Settype($Age,'double');
$logo = $_POST['Reg']['logo'];
$FNic = $Nic.".ini";
//������� ����������� � ������� �����
function add($Nic,$dop)
{
	$fil=Fopen("Infuser.ini",$dop);
	fwrite($fil,$Nic);
	fwrite($fil,"
");
	fclose ($fil);
}
//������� �������� ��������
//������� �������� �������� ���������� ������

function Check_post($Nic,$parol,$povtorparol,$mail,$Age)
{
	if (empty($Nic) or empty($parol) or empty($povtorparol) or empty($mail) or $parol<>$povtorparol or ($Age < 5 and $Age > 0 or $Age < 0))
	{
		print "<h3>������!</h3><br>";
		if (empty($Nic))
		{
			Print "<font color=\"#ff0000\">�������� ���</font><br>";
		}
		if (empty($parol))
		{
			print "<font color=\"#ff0000\">�������� ������</font><br>";
		}
		if (empty($povtorparol))
		{
			print "<font color=\"#ff0000\">������ �� �����������</font><br>";
		}
		if (empty($mail))
		{
			print "<font color=\"#ff0000\">�������� �������� �����</font><br>";
		}
		if ($parol <> $povtorparol)
		{
			print "<font color=\"#ff0000\">����������� ������ |$parol|<>|$povtorparol|</font><br>";;
		}
		if ($Age < 5 and $Age > 0 or$Age < 0)
		{
			print"<font color=\"#ff0000\">������ �������� ������� |$Age|</font><br>";
			print"<font color=\"#ff0000\"><h2>��� �� ����� ��.. ������</h2></font><br>";
		}	

		return false;
	}
}
//�������� ���� ����
function Check_logo($logo)
{
	$net = "���� ����";
	if(false==empty($logo))//..���� ���������� ���� �� ������
	{
		if (false==file_exists($logo))//� ���� ����� ��� ��
		{
			$net = false ;
			print "<font color=\"#ff0000\">��������� ���� ���� �� ���������� </font><br>";
			
		}
		else{print "���� ������ ���� $logo<br>";}
	}
	else
	{
		$net = true;
		print "<br>� ��� ��� ����� �� �� ������ ������� �� ��������<br>";
	}
	return $net;
}
//������� ���������� ����������� �������� ���������� �� �������
function cehek_dir($dir,$Nic)
{
	if(!is_dir($dir))
	{
		print "<br><h4>��� ������ ��������� �� ������ �����</h4><br>";
		
		if(mkdir($dir,0700))
		{
			print "<br><h2><font color=\"#B8323C\">Heloy. $Nic you first uzer on this site</font></h2><br>";
		}
		else
		{
			print "<br>I/'m Sory. ��������� ���������������� ������ ���������� �� ������� � �������������<br>";
			return false;
		}
	}
	else{return true;}
}
//�������� ������������� � ���������� ����� ����� ��� ������� ������ true
function check_user($dir,$FNic)
{
$return=true;
	if ($open_dir = opendir($dir))
	{
		$return=true;
  		while (false !== ($file = readdir($open_dir)))
		{
			if($FNic == $file)//��� �� ������ $FNic ��� ���� ������
			{
			print "<font color=\"#ff0000\">������ ������������ ��� ���������������</font><br>";
			$return=false;
		break;
			}
	}
	closedir($open_dir);
return $return;
}
	
	{
		print "<br>I/'m Sory. ��������� ��������� ������ n\ ���� ��� ����� ����������� ���������� �� ������� � �������������<br>";
		return false;
	}
}
//������ ���������� ����������� � ������������ ���������� �������� ���� � ��������� �����
Function check_pol_vosr($Age,$pol)
{
	if(0 == $Age)
	{
		$Age="��������.";
	}
	else {$Age=$Age." ���";}
		if("men"==$pol)
	{
		$pol="�������";
	$oc="��";
		}
	else {$pol="�������";$oc="��";}
	$pol_Age_oc=array("pol"=>$pol,"age"=>$Age,"oc"=>$oc);
	return $pol_Age_oc;
}
//������� �������� ������ � ���� �������� ���������������� ���������� 
function creat_file_uzer($Nic,$FNic,$dir,$parol,$mail,$pol,$logo,$oc,$Age,$data)
{
	$dop='a+';
	$rem='w+';
	if ($Fneme = @Fopen($dir.$FNic,$rem))
	{
	
	
	
	//��� �� ������ $FNic ��� ���� ������
	/*if(false==Check_logo($logo) or true==Check_logo($logo))
	{
		$logo="��� �����������";
		print "<h1>$logo</h1>";
	}*/
	if(@fwrite($Fneme,$parol."_===++||||++===_".$mail."_===++||||++===_".$pol."_===++||||++===_".$Age/*." ".$logo*/))
	{
		add($Nic,$dop);
		print "<br>$data --><h3> �����$oc <font color=\"#008080\">$Nic.<font></h3> ���������� ���, \n �� ��������� ������������������ �� ����� �����. ��� ������� $Age<br>";
		return true;
	}else { print "<br>I/'m Sory. ��������� ���������������� ������ �������� � ����� ������������ ������������ ������������ ������� ?:%;�\"\'!%:?()_+=\\ \n ����������� ������ ��� ��� ���� �������� \n � ������ ���� ��� �� ������� ���������� �� ������� � �������������<br>";}
	
	}else {print "<br>I/'m Sory. ��������� ���������������� ������ �������� � ����� ������������ ������������ ������������ ������� ?:%;�\"\'!%:?()_+=\\ \n ����������� ������ ��� ��� ���� �������� \n � ������ ���� ��� �� ������� ���������� �� ������� � �������������<br>";}
}
//������� �������� ������ ���� ��������� ���������
function print_VAR()
{
	$a = array_slice (get_defined_vars(),13);
	print_r (array_keys($a));
	$a = get_defined_functions();
	print_r ($a['user']);
}


//Function PROGRAM
function Vipolnit_ssript($Nic,$parol,$povtorparol,$mail,$dir,$FNic,$Age,$pol,$logo,$data)
{
if (FALSE!==Check_post($Nic,$parol,$povtorparol,$mail,$Age))
{
	//print "�������� ������ ���������� ���������";
	//Check_logo($logo);
	cehek_dir($dir,$Nic);
	if (true == check_user($dir,$FNic))
	{
		$temp = check_pol_vosr($Age,$pol);
		
		$pol=$temp['pol'];
		$Age=$temp['age'];
		$oc=$temp['oc'];
		
		if(true==creat_file_uzer($Nic,$FNic,$dir,$parol,$mail,$pol,$logo,$oc,$Age,$data))
		{ //print "�������� ������ ���������, �������� ����� �������������";
			return true;
		}
	}
}
}




}
?>

<body bgcolor="#DEE2EB">
<table align="center" border="1" bordercolor="#c0c0c0" bgcolor="#B9D8E6">
	<tr><td>
		<P align="center"> <font color="#303263" face="Comic Sans MS">&nbsp;&nbsp; ��������������� ������ ������������ <br>��� ������� ����� <a href="index.php" ><font color="#EAF2F2">������� ��������</font></a> &nbsp;&nbsp;</font></P>
	</td></tr>
	<tr><td align="center">
		<p align="center"><font face="Comic Sans MS">��������� ��������� �����</font></p>
<font face="Comic Sans MS" color="#453573" >
<form action="reg.php" method="post">
<input  type="Hidden" name="Reg[delay]" value="Delay" >
	���* <input type="Text" name="Reg[Nic]" maxlength="20" value="<?php print rand (1,9999999999999);?>"><br><br>
	������* <input type="Password" name="Reg[Login]" maxlength="30" value="<?php $print=rand (1,9999999999999); print $print?>"><br><br>
	��� ���* <input type="Password" name="Reg[Loginp]"maxlength="30" value="<?php  print $print;?>"><br><br>
	E-mail* <input type="Text" name="Reg[mail]"maxlength="30" value="<?php print rand (1,9999999999999)."@".rand (1,9999).".ru";?>"><br><br>
	������� ��� <select size="1" name="Reg[pol]">
									<option value="men" >�������</option>
									<option value="women">�������</option>
								  </select>
	&nbsp;&nbsp;&nbsp;&nbsp;������� <input type="Text" size="2" name="Reg[Age]" maxlength="2"  value="<?php print rand (6,99);?>"><br><br>
<input type="Hidden" name="Reg[logo]" >
		<input  type="Submit" value="������������������">
</form>
</font>
</table>
<table bgcolor="#E7F3FE" border="1" bordercolor="#c0c0c0" width=600 align="center">
	<tr align="center"><td align="center">
<pre>
<?php
print "<font face=\"Comic Sans MS\"><h2>������� �������</h2><font>";
if (@!empty($_POST['Reg']['delay']))
{
	Vipolnit_ssript($Nic,$parol,$povtorparol,$mail,$dir,$FNic,$Age,$pol,$logo,$data);
}
?>
<br><font face="Comic Sans MS" point-size="7">�� ����� ���������� ���������� �� ������ <a href="ilx666@mail.ru"><font color="#0000ff">ilx666@mail.ru</font></a></font></pre>
	</td>	</tr>
</table>
</body>