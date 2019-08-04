
<pre>
<?php
//�������������� ������ ������ � ��������� ������
function translit($string)
{
	if (is_string($string))
	{
		$string = strtolower ($string);
	$rustr=array("�","a","�","b","�","b","�","g","�","d","�","e","�","e","�","g","�","z","�","i","�","i","�","k","�","l","�","m","�","n","�","o","�","p","�","r","�","s","�","t","�","y","�","f","�","x","�","ce","�","h","�","h","�","h","�","gi","�","e","�","y","�","a","�",chr (0),"�",chr (0));
		for ($i=0;$i<count($rustr)-1;$i++)
		{
			//print $rustr[$i]." - ".$rustr[++$i]."<br>";
			$string = strtr ($string,$rustr[$i],$rustr[++$i]);
		}
		return $string;
	}
}
//..����� �� �������� �� ����� � ������ ��������� ����������� ��������� ������ ��� ������ ������������ ���������
function Sel_work ($wey = "work/Sel_work.php",$del=false,$col = 2)
{
	$sel_work = file($wey);
	shuffle ($sel_work);
	if ($col<count($sel_work)-1)
	{
	for ($i=0;$i<$col+1;$i++)
	{
		$sel_work[] = $sel_work [$i++];
	}
	if ($del == false)
	{
		return $sel_work;
	}
	}
/*	elseif($del == 'data') //��� �������� ������ ������� �������� �� �������������
	{
		foreach ($sel_work as $key => $val)
		{
			$sel_work[$key] = unserialize($val);
		}
		return $sel_work;
	}
	elseIf($del!="")
	{		
		foreach ($sel_work as $key => $val)
		{
			$sel_work[$key] = explode($del,trim($val));
		}
		return $sel_work;
	}
	else
	{
		return false;
	}*/
}






//������� ���������� ������� ������ ����� ��������� � ����������� �������// �������� �����
function revers( &$var )
{
	if( is_array ($var))
	{
		foreach($var as $key => $val)
		{
			if(is_array($val) && count ($val) != 0 )
			{
				revers( $var[$key] );
			}
			else
			{
				if ( $val == "" ||  count ($val) == 0 )
				{
					unset($var[$key]);
				}
			}
		}
	}
}

//..��������� ����������� ������� ����� �� ���������
Function mnog_xsp ($arr_x,$arr_s,$arr_p)
{
	$ar=0;
	for($i=0;$i<count($arr_s);$i++)
	{
		$ar+=$arr_x[$i]*$arr_s[$i]*$arr_p[$i]/100;
	}
	return $ar;
}

//��������� ����� �������� ��� ������ ����� �������
Function mnog_xs ($arr_x,$arr_s)
{
	$ar=0;
	for($i=0;$i<count($arr_s);$i++)
	{
		$ar+=$arr_x[$i]*$arr_s[$i];
	}
	return $ar;
}




function calk_array($ar,$znac)
{
	$r=0;
	$r0=1;
	for($i=0;$i<count($ar);$i++)
	{
		switch ($znac)
		{
		case "+":
			$r +=$ar[$i];
			break;
		case "-":
			$r +=-$ar[$i];
			break;
		case "*":
			$r0 = $r0*$ar[$i];
			break;
		case "/":
			$r0 = $r0/$ar[$i];
			break;
		}
	}
	return $r = $znac=="+" || $znac=="-" ? $r : $r0 ;
}


//
Function mesace_sum (&$data,$boll)
{
	//print_r ($data);
	foreach ($data as $key => $val)
	{
		if ( is_array($val) )
		{
			foreach($val as $key1 => $val1)
			{
				switch ($key)
				{
					case "work":
						$cumm_Wx[]= $val1[1];
						$cumm_Ws[]= $val1[2];
						$cumm_Wp[]= $val1[3];
						$cumm_Wl[]= $val1[4];
						break;
					case "rashod":
						$cumm_Rx[]= $val1[1];
						$cumm_Rs[]= $val1[2];
						$cumm_Rp[]= $val1[3];
						$cumm_Rl[]= $val1[4];
						break;
					case "nedvig":
						$cumm_Nx[]= $val1[1];
						$cumm_Ns[]= $val1[2];
						$cumm_Np[]= $val1[3];
						$cumm_Nl[]= $val1[4];
					break;
					case "invest":
						$cumm_Ix[]= $val1[1];
						$cumm_Is[]= $val1[2];
						$cumm_Ip[]= $val1[3];
						$cumm_Il[]= $val1[4];
						break;
				}
				$cumm_x[]= $val1[1];
				$cumm_s[]= $val1[2];
				$cumm_p[]= $val1[3];
				$cumm_l[]= $val1[4];
			}
		}
	}
	print "��������� ������� �� ������ =".$W=(mnog_xsp($cumm_Wx,$cumm_Ws,$cumm_Wp)+mnog_xs($cumm_Wx,$cumm_Ws))."<br>";
	print "�������� ������� �� �������� =".$R=(-mnog_xsp($cumm_Rx,$cumm_Rs,$cumm_Rp)+mnog_xs($cumm_Rx,$cumm_Rs))."<br>";
	print "�������� ������ �� ������������ =".$N=(mnog_xsp($cumm_Nx,$cumm_Ns,$cumm_Np))."<br>";
	print "������ �� ����� =".$I=(mnog_xsp($cumm_Ix,$cumm_Is,$cumm_Ip))."<br>";
	print "����� =".($W+$R+$N+$I)."�<br>";
/*
print " cumm_Wx ->"; print_r ($cumm_Wx);
print " calk_array ->".calk_array($cumm_l,"+")."<br>" ;
print_r (array($cumm_x,$cumm_s,$cumm_p));
print "����� ����� ������ ���� ".calk_array($cumm_x,"+")*calk_array($cumm_s,"+")*calk_array($cumm_p,"+")/100;
print "mnog_xsp  sxs";  var_dump ( mnog_xsp ($cumm_x,$cumm_s,$cumm_p));*/
}


Function generate_newuser_array($arr,$bol,$categoria = "all" )
{
	if($categoria = "all")
	{
		if( $nal = $arr["nal"][0] + $arr["nal"][0]*rand(-0.25,0.25) &&
			$work 	= array (array("����������"		,2,10000	,0,2))&&
			$action = array (array("SVGA" 			,1,5000		,3,1))&&
			$nedvig = array (array("����� � �������",1,2000000	,1,5))&&
			$rand	= array (array("�������"		,2,500		,0,2))&&
			$family = array (array("����"			,1,20000	,10,2))&&
			$dela	= array (array("����� � �������",1,2000000	,1,5))&&
			$credit = array (array("����� � �������",1,2000000	,1,5))&&
			$rashod = array (array("����� � �������",1,2000000	,1,5))&&
			$nalogi = array (array("����� � �������",1,2000000	,1,5)))
			{
				return $work_data = array ("work" 		=> $work,
											"rashod" 	=> $action,
											"nedvig" 	=> $nedvig,
											"dela" 		=> $dela,
											"credit" 	=> $credit,
											"rashod"	=> $rashod,
											"nalogi" 	=> $nalogi,
											"nal"		=> $nal);
			}
	}
}

if (isset($_POST["NEW"]) && isset($_POST["data"]["work"][0][0]))
{
	include_once ("include_functions.php");
	$data = $_POST["data"];
	revers($data);
	revers($data);
//	print_r ($data);
	if (mesace_sum($data,"boll"))
	{
		seve_data($data,"work/works.php","a+","
"); print "��� ��������";
	}
	else
	{
		PRINT "BAG ARREY<br>";
	}

var_dump ( load_data("work/works.php"));

	$i = -1;
}
else
{
	$i= -1;
}
 ?>
<table align="center" cellspacing="2" cellpadding="2" border="1" bgcolor="#F2F2F2">
<form action="constructor.php" method="post">
<tr>
	<td colspan="5" align="center" valign="top" bgcolor="#B4CAEB">����������� ��� �������� ��������� ���������
	<font color="#ff0000">��� ���� � ������ ������ ���� ���������!</font>
	</td>
</tr>
<tr align="center">
	<td>������������</td>
	<td>���������</td>
	<td>�����</td>
	<td>�.�. ������� %</td>
	<td>�����������</td>
</tr>
<tr>
	<td colspan="5" align="center" valign="top">� ������</td>
</tr>
<tr>
	<td><input type="Text" name="data[work][0][0]" value="<?php $work1 = Sel_work(); print trim($work1[$a=rand(0,1)]) ?>"></td>
	<td><input type="Text" name="data[work][0][1]" value="<?php print rand(11,20)/10 ?>"></td>
	<td><input type="Text" name="data[work][0][2]" value="<?php print rand(5000,20000) ?>"></td>
	<td><input type="Text" name="data[work][0][3]" value="<?php print rand(1.1,3.5) ?>"></td>
	<td><input type="Text" name="data[work][0][4]" value="<?php print rand(-2,5) ?>"></td>
</tr>
<tr>
	<td><input type="Text" name="data[work][1][0]" value="<?php print trim($work1[1-$a]) ?>"></td>
	<td><input type="Text" name="data[work][1][1]" value="<?php print rand(5,10)/10 ?>"></td>
	<td><input type="Text" name="data[work][1][2]" value="<?php print rand(1000,20000) ?>"></td>
	<td><input type="Text" name="data[work][1][3]" value="<?php print rand(0,1.1) ?>"></td>
	<td><input type="Text" name="data[work][1][4]" value="<?php print rand(-2,5) ?>"></td>
</tr>
<tr>
	<td colspan="5" align="center" valign="top">����������� ������� </td>
</tr>

<tr>
	<td><input type="Text" name="data[rashod][0][0]" value="�������"></td>
	<td><input type="Text" name="data[rashod][0][1]" value="<?php print rand(1,3)?>"></td>
	<td><input type="Text" name="data[rashod][0][2]" value="<?php print rand(-3000,-6000)?>"></td>
	<td><input type="Text" name="data[rashod][0][3]" value="0"></td>
	<td><input type="Text" name="data[rashod][0][4]" value="<?php print rand(-2,-1) ?>"></td>
</tr>

<tr>
	<td><input type="Text" name="data[rashod][1][0]" value="������� �� ��������"></td>
	<td><input type="Text" name="data[rashod][1][1]" value="<?php print rand(6,19)/10?>"></td>
	<td><input type="Text" name="data[rashod][1][2]" value="<?php print rand(-3000,-18000) ?>"></td>
	<td><input type="Text" name="data[rashod][1][3]" value="<?php print rand(-25,-2) ?>"></td>
	<td><input type="Text" name="data[rashod][1][4]" value="<?php print rand(-10,-2) ?>"></td>
</tr>
<tr>
	<td><input type="Text" name="data[rashod][2][0]" value="����"></td>
	<td><input type="Text" name="data[rashod][2][1]" value="1"></td>
	<td><input type="Text" name="data[rashod][2][2]" value="<?php print  rand(-1000,-10000) ?>"></td>
	<td><input type="Text" name="data[rashod][2][3]" value="<?php print  rand(-10,-2) ?>"></td>
	<td><input type="Text" name="data[rashod][2][4]" value="<?php print  rand(-9,-2) ?>"></td>
</tr>
<tr>
	<td><input type="Text" name="data[rashod][3][0]" value="������� ������"></td>
	<td><input type="Text" name="data[rashod][3][1]" value="<?php print  rand(1,10) ?>"></td>
	<td><input type="Text" name="data[rashod][3][2]" value="<?php print  rand(-10,-500) ?>"></td>
	<td><input type="Text" name="data[rashod][3][3]" value="<?php print  rand(-0.01,0.01) ?>"></td>
	<td><input type="Text" name="data[rashod][3][4]" value="<?php print  rand(1,20)/10 ?>"></td>
</tr>
<tr>
	<td colspan="5" align="center" valign="top">������� ���������</td>
</tr>

<tr>
	<td><input type="Text" name="data[nedvig][0][0]" value="���"></td>
	<td><input type="Text" name="data[nedvig][0][1]" value="1"></td>
	<td><input type="Text" name="data[nedvig][0][2]" value="<?php print  rand(100000,1500000) ?>"></td>
	<td><input type="Text" name="data[nedvig][0][3]" value="<?php print  rand(-1,-10)/10 ?>"></td>
	<td><input type="Text" name="data[nedvig][0][4]" value="<? print rand(9,20) ?>"></td>
</tr>

<tr>
	<td><input type="Text" name="data[nedvig][1][0]" value="��������"></td>
	<td><input type="Text" name="data[nedvig][1][1]" value="<?php print  rand(1,2) ?>"></td>
	<td><input type="Text" name="data[nedvig][1][2]" value="<?php print rand(30000,1000000) ?>"></td>
	<td><input type="Text" name="data[nedvig][1][3]" value="<?php print  rand(-9,9)/10 ?>"></td>
	<td><input type="Text" name="data[nedvig][1][4]" value="<?php print  rand(5,9) ?>"></td>
</tr>

<tr>
	<td><input type="Text" name="data[nedvig][2][0]" value="������"></td>
	<td><input type="Text" name="data[nedvig][2][1]" value="<?php print  rand(1,2) ?>"></td>
	<td><input type="Text" name="data[nedvig][2][2]" value="<?php print  rand(20000,300000) ?>"></td>
	<td><input type="Text" name="data[nedvig][2][3]" value="<?php print  rand(-5,10)/10 ?>"></td>
	<td><input type="Text" name="data[nedvig][2][4]" value="<?php print  rand(-5,10) ?>"></td>
</tr>
<tr>
	<td colspan="5" align="center" valign="top">��������</td>
</tr>

<tr>
	<td><input type="Text" name="data[invest][0][0]" value="<? $action = sel_work("work/actions.php",false,2); print $action[$a=rand(0,1)]?>"></td>
	<td><input type="Text" name="data[invest][0][1]" value="<?php print  rand(1,10) ?>"></td>
	<td><input type="Text" name="data[invest][0][2]" value="<?php print  rand(500,3000) ?>"></td>
	<td><input type="Text" name="data[invest][0][3]" value="<?php print  rand(1,10) ?>"></td>
	<td><input type="Text" name="data[invest][0][4]" value="<?php print  rand(1,3) ?>"></td>
</tr>
<tr>
	<td><input type="Text" name="data[invest][1][0]" value="<? print $action[1-$a]?>"></td>
	<td><input type="Text" name="data[invest][1][1]" value="<?php print  rand(10,100) ?>"></td>
	<td><input type="Text" name="data[invest][1][2]" value="<?php print  rand(0,50) ?>"></td>
	<td><input type="Text" name="data[invest][1][3]" value="0"></td>
	<td><input type="Text" name="data[invest][1][4]" value="<?php print  rand(-2,2) ?>"></td>
</tr>
<tr>
	<td><input type="Text" name="data[invest][2][0]" value="����� ���������"></td>
	<td><input type="Text" name="data[invest][2][1]" value="1"></td>
	<td><input type="Text" name="data[invest][2][2]" value="<?php print  rand(30000,100000) ?>"></td>
	<td><input type="Text" name="data[invest][2][3]" value="<?php print  rand(1,2) ?>"></td>
	<td><input type="Text" name="data[invest][2][4]" value="2"></td>
</tr>
<tr>
	<td colspan="2" align="center" valign="top">��������� ����������</td>
	<td colspan="3" align="left" valign="top"><input type="Text" name="data[nal]" value="<?print rand (1000,6000) ?>"><td></td>
</tr>

<tr>
	<td colspan="5" align="center" valign="top"><input type="submit" name="NEW" value="NEW"></td>
</tr>
</form>
</table>




