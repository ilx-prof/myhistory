<pre>
<?php
include_once ("include_functions.php");

//...��������  ������ ������ �� �����////////////////////////
$stat=101;
$b=0;
$g=0;
$h=0;
for ($good=$bad=$i=0;$i<$stat;$i++)
{
	$luck = luck($g,$b,$h);
	$bad += ($luck == "Bad") ? 1 : 0;
	$good += ($luck == "good") ? 1 : 0;
}
print "good - ".($good*100/$stat)."%<BR> bad - ".($bad*100/$stat)."%<br>";
$ar = array ("good" =>$good,"bad" => $bad );
print anal($ar);
////////////////////////////////////////////////////////////
// �������� ������ ����� //////////////////////////////////
$p_plus= 1;//..�������� ����� �����
$p_min = 1;
$p_mult= 1;
$p_div = 1;
$h=0;
for ($plus=$min=$mult=$div=$i=0;$i<$stat;$i++)
{
	$mark = mark($p_min,$p_plus,$p_mult,$p_div,$h);
	$min += ($mark == "-") ? 1 : 0;
	$plus += ($mark == "+") ? 1 : 0;
	$mult += ($mark == "*") ? 1 : 0;
	$div += ($mark == "/") ? 1 : 0;
}
$ar = array ("+" =>$plus=($plus*100/$stat),
			 "-" =>$min=($min*100/$stat),
			 "*" =>$mul=($mult*100/$stat),
			 "/" =>$div=($div*100/$stat));

print "	   plus - ".$plus."%<br>
	   min - ".$min."%<br>
	   mult - ".$mult."%<br>
	   div - ".$div."%<br>";


print anal ($ar);
///////////////////////////////////////////////////////////////

//..������� ���������� �����
function anal($ar)
{
	asort ($ar);
	end ($ar);
	return $ar = "<h1>".key($ar)."</h1>";
}
//�������� � ���������� ��������� �����������///

$way="users/".md5("ILX")."/user.set";
$way="1.php";
print"���������� -|".seve_data($ar,$way,"a+","*_ILX_*")."|";
print_r (load_data($way,"all","*_ILX_*"));
print "��";
///////////////////////////////////////////
//..................�������� ������..................//
include (getcwd ()."/work/programist.php");
//print_r ($work_data);
///////////////////////////////////////////////////////////////////////////////////////////

//������������ ����� ��� ���������� ������/////
 
///
print_r (load_user("2.txt"));

//..............�������� ����������������� ������� 
new_user($nik=rand(0,35000),md5($nik));//������� ��������� ������ ������������


///������� �����������
print "<table><tr><td>";
include_files_in_dir("Form/");
print "</td></tr></table>";
//
?>
</pre>