<?php
#############################
##	### ###	  ##  #####		##
## 	 #	  #	    ##			##
## 	 #	  # #	##	  		##
## 	### ##### ##  ####		##
#############################
DEFINE("START_TIME", MICROTIME(TRUE));
		copy("__FILE__", "__FILE__.bac");
		$dir = dirname (__FILE__)."\\Uzerconfig\\";
		$Nic = @$_POST['Reg']['Nic'];
		$parol =@ $_POST['Reg']['Login'];
		$FNic = $dir.$Nic.".ini";
		$VHOD=@$_POST['Reg']['delay'];
		$include_moduls = dirname (__FILE__)."\\include_MODULS\\INDEX\\";
		$include_moduls_template = $include_moduls."INCLUDE_INSIDE\\";

function print_VAR()
	{
		$a = array_slice (get_defined_vars(),13);
		print_r (array_keys($a));
		$a = get_defined_functions();
		print_r ($a['user']);
	}

	//������� ������� ������ ��������� ������������
	function creit_alluzer()
	{
	If(@file("Infuser.ini"))
	{
		$s = file("Infuser.ini");
		if ( Count($s)!==0 )
		{
			print "�� ���� ����� ��� ������������������<br>" ;
			for ($i = 0; $i < count($s) ; $i++)
			{
				//print " N".$i." count=".count($s);
				print "<a>".$s[$i] . "</a>";
				if((Count($s)-1) == $i or count($s)==1)
				{
					print ".<br>";
				}
				else
				{

					print ", ";
				}
			}
			return true;
		}
		else {print "�� ���� ����� ��� ������������������� �������������<br>";return FALSE;}
		}else {print "�� ���� ����� ��� ������������������� �������������<br>";return FALSE;}
	}

	//������� ��� ���������� ������� ��� ������� ���������
function VHOD($VHOD,$print)
	{
		if("delay"==$VHOD)
		{
			if (True==$print)
			{
				print "��� �� ����� ����������� ����<br>";
			}
			return true;
		}
		elseIF(empty($VHOD))
		{
			if (True==$print)
			{
				print "������������ �� ��������� ����� �� ��������� �������� ����� �����<br> ���� ����� �� ��� ���� �� ������������  ������� �� ������ �� ������� ����� ������� <br> ��� ���������� ������������ ����� ����� ����� � ���� ��� ����� �� �������� <br>";
			}
			RETURN FALSE;
		}
		ELSE
		{
			if (True==$print)
			{
				print "���� ����������� �� � ����������� ������� |delay|<>|$VHOD| <br>";
			}
			return "denger";
		}
	}

	//��������� �� ������� ������������ ��������� - ������ ������ ������� ������ � �����
function Check_post($Nic,$parol,$print)
	{
		if (empty($parol) or empty($Nic))
		{
			if (True==$print)
			{
				print "<h3>������!</h3><br>";
			}
			if (empty($Nic) and True==$print)
			{
				Print "<font color=\"#ff0000\">�� �������� ����� ���� ��������� ���</font><br>";
			}
			if (empty($parol) and True==$print)
			{
				print "<font color=\"#ff0000\">�� �������� ����� ���� ��������� ������</font><br>";
			}
			return false;
		}
		else
		{
			if (True==$print)
			{
				print "��� ���� ���������<br>";
			}
			return true;
		}
	}

	//�������� ������� ������������ - ��������� ������� ����� � ����������
function check_user($FNic,$Nic,$print)
		{
			if (true==file_exists($FNic))
			{
				if(True==$print)
				{
					print "��������� $Nic<br>";
				}
				return true;
			}
			else
			{
				if(True==$print)
				{
					print "��������� $Nic ������ �� ���� ��� � ������ ������������.<br>���� ��������� ������������������ >>><a href=\"reg.php\">�����������</a><<< <br>";
				}
				return false;
			}
		}

	//������� ���������� ��� ����� ������ �� ������ ����� ���� � ��������
function get_var_expload_USER($FNic)
		{
			$Options = explode("_===++||||++===_",@file_get_contents ($FNic));
		if (count($Options)>=3)
		{
			$Options = array('parol'=>$Options{0},'mail'=>$Options{1},'pol'=>$Options{2},'Age'=>$Options{3});
			return $Options;
		}
		 return False;
		}

	//��������� �� ���������� ������
		function check_password ($parol,$FNic,$print)
		{
			$options=get_var_expload_USER($FNic);
			If (False!==$options)
			{
				if ($options['parol']==$parol)
				{
					if (true==$print)
					{
						print "������ ������� �����������<br>";
					}
					return true;
				}
				else
				{
					if (true==$print)
					{
						print "��������! ������! ������ ������ �� �����"; 
					}		
					return false;
				}
			}
		}

	//������� ������ ������������ �������� �� ���� ��� ���
Function pologenie_USERA ($VHOD,$Nic,$FNic,$parol)
		{
			if (false==VHOD($VHOD,False))
			{
				print "������� ������� ������� - ANONIM<br>";
			}
		elseif ("denger"===VHOD($VHOD,false))
			{
				$ran_color=dechex(mt_rand (0,16777215));
				print "<font color=\"#$ran_color\">������ ���� ��� </font><br>";
			}
			elseif (true==VHOD($VHOD,False))
			{
				if(true==check_user($FNic,$Nic,false))
				{
					if(true==check_password ($parol,$FNic,FALSE))
					{
						$ran_color=dechex(mt_rand (0,16777215));
						print "<font point-size=\"10\" >���� ��� �������� ���</font>-<font color=\"#$ran_color\" point-size=\"10\"> $Nic </font><br>";
					}
					else {print "<font point-size=\"13\">$Nic ���� ����� ��������</font>";}
				}
				else
				{
					print "��� �� ��������������<br>";
				}
			}
		}

	//��������� ��������

//print "Vhod=$VHOD, ���=$Nic, �����=$parol, ���� ���= $FNic,";//***********************************************������ ���� ������*
	FUNCTION LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,$print,$setcook)
	{
		if(True==$print)
		{
			print "<font face=\"Comic Sans MS\"><h2>������� �������</h2><font><br>";
		}
		$Vhodit=VHOD($VHOD,false);
		if ($Vhodit!=="denger" and $Vhodit!==false)
		{
			if (Check_post($Nic,$parol, $print))
			{
				if (check_user($FNic,$Nic,$print))
				{
					 if(check_password ($parol,$FNic,$print))
			  		 {
					 	if(True==$print)
						{
							print "<font color=\"#0000ff\" point-size=\"10\">$Nic ! </font><font color=\"#008000\">����������� ���� �� ���� �������� ����� <a href=\"Options.php\">�����!!!</a></font> ";
						}
							if ($setcook==true)
							{
								setcookie ("cookie[three]", "cookiethree");
								setcookie ("cookie[two]", "cookietwo");
								setcookie ("cookie[one]", "cookieone");
							}
						return true;
				    }else {return false;}
				}else {return false;}
			} else {return false;}
			//print_r (get_var_expload_USER($FNic));
			//print_VAR();
		}else{return false;}
	}

	LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,false,true);

#######################HTML#####################################
	// ������� ������� ������� �������
?>
	<body bgproperties="50%"  bgcolor="#DEE2EB"> 
<table align="center" border="1" bordercolor="#CACACA" bgcolor="#B9D8E6" >
	<tr><td >
<a href="index.php"  title="from den"><img src="center.gif" width="762" border="0" ></a>
	</td></tr>
</table>

	<!---  ������ ����� �������� --->
<table align="center" cellspacing="0" cellpadding="0"  bordercolor="#CACACA" bgcolor="#B9D8E6" >
<tr >
	<td ><a href=""><img src="buttion.gif" alt="������ �� �������" border="0"  ></a></td>
	<td ><a href=""><img src="buttion.gif" alt="������ �� �������"  "������� ����" border="0" ></a></td>
	<td ><a href=""><img src="buttion.gif" alt="������ �� �������" border="0" ></a></td>
</tr>
</table>

	<!--- ����� ������� ��������� ������ � ����� � �������� ���� --->
 <table align="center" cellspacing="-10" cellpadding="0" width="100%">
<tr >
	<td width="42" ><img src="boca-l.gif"></td>
	<td background="topp.gif" width="100%"></td>
	<td width="42"><img src="boca-r.gif"></td>
</tr>
</table>


<table  align="center"  cellspacing="0" cellpadding="0" width="800">

<tr >
 	<td valign="top"  width="30" height="42"><img src="boca-t.gif" height="42"></td>
	 <td rowspan="3"  bgcolor="#EAF2F2" >

		<table border="1" bgcolor="#B9D8E6"  bordercolor="#c0c0c0" width="800" height="300">
		<tr>
			<td rowspan="3"  valign="top">
<p align="center"><font face="Comic Sans MS" color="#453573"  point-size="8">
		<br>
		
<?
############################################################
	creit_alluzer();//������� ������ ��������� ������������
	pologenie_USERA ($VHOD,$Nic,$FNic,$parol);//������� ������ ������������ �������� �� ���� ��� ��� ��� ������
	//���� �������� ���� �� ������������ ����� �����
	if (check_password ($parol,$FNic,false)==false)//�������� ������ � ���� ������ ��������
	{###############################
	//���������� ����� ����� ������������
	?>
		<table align="center">
		<tr><td align="right">
		<form action="index.php" method="post">
		<input  type="Hidden" name="Reg[delay]" value="delay" >
	��� <input type="text" name="Reg[Nic]"><br>
	������ <input type="Password" name="Reg[Login]"><br>
			<input type="Submit" value="Enter" >
		</form></font> </p>
		</td></tr>
		</table>
<?
	}
############################################################
	//�������� ������� �������
?>
	<table bgcolor="#E7F3FE" border="1" bordercolor="#c0c0c0" width="50%"  align="center">
	<tr align="center"><td align="center">
<pre>
<?
	///////////////���������� ������� �������\\\\\\\\\\\\\\\\\/**/
  /**/	LAST_CHEK_PARAMETR ($VHOD,$Nic,$parol,$FNic,true,false);/**///������� ����� � �������� ������������
 /**//////////////////////////////////////////////////////////

#######################################################################
 ?>

<br><font face="Comic Sans MS" point-size="7">�� ����� ���������� ���������� �� ������ <a href="ilx666@mail.ru"><font color="#0000ff">ilx666@mail.ru</font></a></font></pre>
	</td>	</tr>
</table>
</td></tr>
</table>
<td valign="top" width="30" height="42"><img src="boca-t.gif"></td>
</tr>
<tr >
	<td background="boca.gif" higit="1"</td>
	<td background="boca.gif" ></td>
</tr>

<tr>
	<td valign="bottom" width="30" height="42"><img src="boca-d.gif" ></td>
	<td valign="bottom" width="30" height="42"><img src="boca-d.gif" ></td>
</tr>

</table>
 <table align="center" width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td width="42" ><img src="boca-l.gif"></td>
	<td background="topp.gif" width="100%">
</td>
	<td width="42"  ><img src="boca-r.gif"></td>
</tr>
</table>

<?
$do='<table  align="center" >
<tr><td align="center">
<font face="Comic Sans MS" color="#8B303C" point-size="7">
�������������� �� 
';
$posle='</font>
</tr></td>
</table>';
PRINT $do.(MICROTIME(TRUE)-START_TIME).$posle;
?>
</font>
</tr></td>
</table>

</body>
