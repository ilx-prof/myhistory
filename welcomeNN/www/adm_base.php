<?
//������ ��������� �������� �� � ������ ����� ������������� ������
function proverca ($wey)
{
	$DB_type=file ($wey);
	$count_do=count($DB_type);
	$DB_type=array_unique ($DB_type);
	$count_posle=count($DB_type);
	$string="";
	foreach($DB_type as $key => $val)
	{
		$string.=$val;
	}
	fwrite($f=fopen ($wey, "w"),$string);
	fclose($f);
	return $count_do-$count_posle;
}
//..������� ���������� ������� ������ �������� � ����� ������� �������
function assort_matrix ($wey)
{
	$a=array();
	$arr=array_base ($wey);
	$i=0;
	$count_table=$arr[1]+1;
	$count=count($arr[0])+1;
	$arr=$arr[0];
	while($i<$count_table)
	{
		for($a=$i;$a<=$count;$a+=$count_table)
		{
			$ar [$i] [] = $arr[$a];
		}
		$i++;
	}
	revers ($ar);
	print count ($ar);
	print_r ($ar);
	//sort_base_lenivai_user ($ar,0);
	sort_Base_binary_wol ($ar,0);
	print_r ($ar);
}
//..����������� ������� �� ������� ������� ������� ������ �������� ������������ (�����������) ��� $q - ����� ������
FUNCTION sort_base_lenivai_user (&$arr,$q)
{	$q0=count($arr);
	$n=count($arr[$q]);
    $i = $j = $tmp = 0;
    for($i=0; $i<=$n-1; $i++)
    {
        for($j=0; $j<=$n-2-$i; $j++)
        {
            if( $arr[$q][$j]>$arr[$q][$j+1] )
            {
                $tmp = $arr[$q][$j];//����� ����������
                $arr[$q][$j] = $arr[$q][$j+1];//������������
                $arr[$q][$j+1] = $tmp;//�����������
				$q1=0;
				while ($q1<$q0)
				{
					if ($q1!=$q)
					{
						$tmp2 = $arr[$q1][$j];//����� ����������
		                $arr[$q1][$j] = $arr[$q1][$j+1];//������������
        		        $arr[$q1][$j+1] = $tmp2;//�����������
					}
					$q1++;
				}
            }
        }
    }
}

//..���������� ������� �� ������ �������� �������� ����� ������� ������
FUNCTION sort_Base_binary_wol (&$arr,$q)
{
	$q0=count($arr);
	$n=count($arr[$q]);
	$j=$k=$t=$tmp=0;
    if( $n==1 )
    {
        return;
    }
    $i = 2;
    do
	{
        $t = $i;
        while($t!=1)
        {
            $k = $t/2;
            if( $arr[$q][$k-1]>=$arr[$q][$t-1] )
            {
                $t = 1;
            }
            else
            {
                $tmp = $arr[$q][$k-1];//������������
                $arr[$q][$k-1] = $arr[$q][$t-1];//
                $arr[$q][$t-1] = $tmp;//
				$q1=0;
				while ($q1<$q0)
				{
					if ($q1!=$q)
					{
          				$tmp = $arr[$q1][$k-1];//������������
	              		$arr[$q1][$k-1] = $arr[$q1][$t-1];//
    	       			$arr[$q1][$t-1] = $tmp;//
					}
					$q1++;
				}
                $t = $k;
            }
        }
        $i = $i+1;
    }
    while($i<=$n);
    $i = $n-1;
    do
    {
        $tmp = $arr[$q][$i];//������������
        $arr[$q][$i] = $arr[$q][0];
        $arr[$q][0] = $tmp;
		$q1=0;
		while ($q1<$q0)
		{
			if ($q1!=$q)
			{
      			$tmp = $arr[$q1][$i];//������������
      			$arr[$q1][$i] = $arr[$q1][0];
				$arr[$q1][0] = $tmp;
			}
			$q1++;
		}
        $t = 1;
        while($t!=0)
        {
            $k = 2*$t;
            if( $k>$i )
            {
                $t = 0;
            }
            else
            {
                if( $k<$i )
                {
                    if( $arr[$q][$k]>$arr[$q][$k-1] )
                    {
                        $k = $k+1;
                    }
                }
                if( $arr[$q][$t-1]>=$arr[$q][$k-1] )
                {
                   $t = 0;
                }
                else
                {
                    $tmp = $arr[$q][$k-1];//������������
                    $arr[$q][$k-1] = $arr[$q][$t-1];//
                    $arr[$q][$t-1] = $tmp;//
					$q1=0;
					while ($q1<$q0)
					{
						if ($q1!=$q)
						{
							$tmp = $arr[$q1][$k-1];//������������
							$arr[$q1][$k-1] = $arr[$q1][$t-1];//
							$arr[$q1][$t-1] = $tmp;//
						}
						$q1++;
					}
                    $t = $k;
                }
            }
        }
        $i = $i-1;
    }
    while($i>=1);
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

//..�������  ��������� � ���� ���������� ������ ��� ��������� ��� � ������� � ��������� �� ������
FUNCTION matrca ($arr,$sir)
{
	$count=count($arr);
	$print="<table cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#808080\" border=\"1\" >";
	$i=0;
	while($i<$count-1)
	{
		$print .="<tr>";
		$a=0;
		while($a<=$sir and isset($arr[$i]))
		{
			$print .= "<td  >";
			$print .= $arr[$i];
			$print .="</td>";
			$a++;
			$i++;
		}
			$print .= "</tr >";
			
	}
	$print .="</table>";
	return $print;
}
//..���������� � ������� ����� ���������� ������ ���� ���������� ����� ������ �� ����������� "	" � �� ������ ���������� ������ ��������� ������� (���������� ���������� � ����� ������)
Function array_base ($wey)
{	$String_base="";
	$file=file($wey);
	if (isset($file[0]))
	{
		$count_base=count (explode("	",$file[0]))-1;
		foreach ($file as $key => $val)
		{
			$String_base.=$val."	";
		}
		return array ($array_base=explode("	",$String_base),$count_base);
	}
	else
	{
		print "<h3>���� �����</h3>";
	}
}
?>
<a href="anceta.php">������</a>
<H2>���������� �����</H2>
<form action="adm_base" method="post">
<select name="���">
<? $i=0;
	if (is_dir(getcwd ()."/base"))
	{ 
	 	if ($dh = opendir(getcwd ()."/base"))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." && is_file(getcwd ()."/base/".$file))
				 {
					$files[]=$file;
					$i++;
				 }
			}
		}
	}
	if(empty ($_POST["���"]))
	{
			$_POST["���"]=$files[0];
	}
	$tmp = "";
	$form = $tmp;
	foreach ( $files as $id => $fname )
	{
		$select ="";
		if (isset ( $_POST["���"] ) && $_POST["���"]==$fname)
		{
			$select="selected";
		}
		$form .="	<option value=\"".$fname."\" $select>".$fname ."</option>\n";
	}
	$form .= "";
	print $form;
	
?>

</select><br><br>�������� ��� �����<br>
<input type="Radio" name="��������" value="�����������">�����������<br>
<input type="Radio" name="��������" value="����������� ����">����������� ����<br>
<input type="Radio" name="��������" value="����������� �� ����������"> ����������� �� ����������<br>
<input type="Radio" name="��������" value="�������� � �������">�������� � �������<br>
<input type="Radio" name="��������" value="��������">��������<br>
<input type="Submit" name="�������������" value="�����������">
</form>

<pre>
<?
if ( isset ($_POST["��������"]) and isset ($_POST["�������������"]) and $_POST["�������������"]=="�����������")
{
$wey="base/".$_POST["���"];
switch ($_POST["��������"])
{
case "�����������":
	print "<br>������� ����������<br>";
				break;

case "����������� ����":
						?>
						<form action="adm_base" method="post">
						<input type="Hidden" name="��������" value="����������� ����">
						����������� ��
						<input type="Radio" name="�����_����������" value="Bable"> ������������ ������
						<input type="Radio" name="�����_����������" value="�������� ��������"> ������ �������� ��������
						����������� ��
						<input type="Radio" name="���������_����������" value="Bable"> �����������
						<input type="Radio" name="���������_����������" value="�������� ��������"> ��������
						<input type="Submit" name="�������������" value="�����������">
						</form>
						<?
					if (isset($_POST ["�����_����������"]) and isset($_POST ["���������_����������"]))
					{
						assort_matrix ($wey);
					}
				break;

case "����������� �� ����������":
								$r = proverca ($wey);
								if ($r==0)
								{
									print "<H3> $wey - �������� ������ ������� ���������� �� �������</H3><br>";
								}
								else
								{
									print "<H3> $wey - ���������� $r ����������, ������� �������</H3><br>";
								}
								break;
case "�������� � �������":
					$a=array_base ($wey);
					print matrca ($a[0],$a[1]);
					break;
case "��������":
					if (fclose(fopen ($wey, "w")))
					{
						print "<H3> $wey - ������� �������</H3><br>";
					}
				break;
}
}
print_r ($_POST);
?>



</pre>