4<html>
<head>
	<title>������</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<style>
	body, table
	{
		font-family: Arial;
		font-size: 14px;
		font-weight: bold;
		color: #4e4e4e;
	}
	#maintable
	{
		border: 1px solid black;
		width: 800px;
		height: 100%;
	}
	#maintitle
	{
		font-size: 60px;
		color: #0099cf;
		text-align: center;
		vertical-align: top;
		height: 100px;
		font-family: "Times New Roman";
	}
	.text
	{
		width: 200px;
		height: 17px;
		font-family: Tahoma;
		font-weight: bold;
		font-size: 11px;
		color: #000000;
		border: 1px solid #000000;
	}
	.bigtext
	{
		width: 100%;
		height: 55px;
		font-family: Tahoma;
		font-weight: bold;
		font-size: 11px;
		color: #000000;
		border: 1px solid #000000;
	}
	.submit
	{
		width: 240px;
		height: 30px;
		font-family: Tahoma;
		font-weight: bold;
		font-size: 13px;
		color: #000000;
		border: 1px solid #000000;
		background-color: #ece9d8;
	}
	.question
	{
		color: #000000;
		vertical-align: bottom;
		height: 40px;
	}
	</style>
</head>
<body bgcolor="#a9a9a9" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<? $radio_type="type=\"radio\" ";
	$other="������";
	$i=0;//..������� 1 � personality
	$s=0;// ������� 1 � static
?>
<table id="maintable" align="center" bgcolor="#ffffff"><tr><td>
<table width="730" height="100%" align="center" cellspacing="0" cellpadding="4">
<form method="post" action="static.php">
<tr>
	<td id="maintitle" colspan="4">� � � � � �&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;� � � � �</td>
</tr>
<tr>
	<td>�������</td>
	<td><input type="text" checked class="text" value="" name="personality[<? print $i++ ?>]"></td>
	<td>���</td>
	<td><input type="text" class="text" value="" name="personality[<? print $i++ ?>]"></td>
</tr>
<tr>
	<td>����� �������</td>
	<td><input type="text" class="text" value="" name="personality[<? print $i++ ?>]"></td>
	<td>������ ����������</td>
	<td><input type="text" class="text" value="" name="personality[<? print $i++ ?>]"></td>
</tr>
<tr>
	<td>��� ���</td>

	<td><input <? print $radio_type?> class="radio" value="���" name="static[<? print $s++ ?>][���]"> ��� <input <? print $radio_type?> class="radio" value="���" name="static[<? print $s ?>][���]"> ���</td>
	<td>����� ��. �����</td>
	<td><input type="text" class="text" value="" name="personality[<? print $i++ ?>]"></td>
</tr>
<tr>
	<td colspan="4">��� �������&nbsp;&nbsp;&nbsp;&nbsp;<input <? print $radio_type?> class="radio" value="�� 31" name="static[<? print $s++ ?>][�������]"> �� 31 <input <? print $radio_type?> class="radio" value="31-40" name="static[<? print $s ?>][�������]"> 31-40 <input <? print $radio_type?> class="radio" value="41-50" name="static[�������][�������]"> 41-50 <input <? print $radio_type?> class="radio" value="�� 50" name="static[�������][�������]"> �� 50
</td>
</tr>

<tr>
	<td colspan="4" class="question">��� �� ������ � ��������� "�����������"?</td>
</tr>
<tr>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="���������� �����" name="static[<? print $s++ ?>][��� �� ������ � ��������� �����������?]"> ���������� �����</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="���������� � ������������" name="static[<<? print $s?>][��� �� ������ � ��������� �����������?]"> ���������� � ������������</td>
</tr>
<tr>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="������������" name="static[<? print $s ?>][��� �� ������ � ��������� �����������?]">������������</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="���������� � ���" name="static[<? print $s ?>][��� �� ������ � ��������� �����������?]"> ���������� � ���</td>
</tr>
<tr>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="��������" name="static[<? print $s ?>][��� �� ������ � ��������� �����������?]"> ��������</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="������� � ���������" name="static[<? print $s ?>][��� �� ������ � ��������� �����������?]"> ������� � ���������</td>
</tr>
<tr>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="������������" name="static[<? print $s ?>][��� �� ������ � ��������� �����������?]"> ������������</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="������" name="static[<? print $s ?>][��� �� ������ � ��������� �����������?]"> ������</td>
</tr>

<tr>
	<td colspan="4" class="question">����� ������� ���� ������� ������������ ������ ������?</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="���� ����� �� �������� ��� �����" name="static[<? print $s++ ?>][����� ������� ���� ������� ������������ ������ ������?]"> ���� ����� �� �������� ��� �����</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="���� ����� ����������� ���� �������� ��� ��. �����" name="static[<? print $s ?>][����� ������� ���� ������� ������������ ������ ������?]"> ���� ����� ����������� ���� �������� ��� ��. �����</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="���� ���������" name="static[<? print $s ?>][����� ������� ���� ������� ������������ ������ ������?]"> ���� ���������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="����������� ��������" name="static[<? print $s ?>][����� ������� ���� ������� ������������ ������ ������?]"> ����������� ��������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="�������������" name="static[<? print $s ?>][����� ������� ���� ������� ������������ ������ ������?]"> �������������</td>
</tr>

<tr>
	<td colspan="4" class="question">����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="������������" name="static[<? print $s++ ?>][����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?]"> ������������&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="text" value="" name="������������"> (����������, ������� �����)</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="�������� ������" name="static[<? print $s ?>][����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?]"> �������� ������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="����������" name="static[<? print $s ?>][����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?]"> ����������</td>
</tr>

<tr>
	<td colspan="4" class="question">����� ������ ������������� �� ������ �� ������ � "�����������"?</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[<? print $i++ ?>]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">��� �� ��������, � ��� ������� ��������� "�����������" �� �������� ������� ���������?</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[<? print $i++ ?>]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">��������� ���������� ������� �������� ����� ���������</td>
</tr>
<tr>
	<td colspan="4">
		<table cellspacing="0" cellpadding="4" width="100%">
		<tr>
			<td>&nbsp;</td>
			<td align="center" width="130">�����������</td>
			<td align="center" width="130">������</td>
			<td align="center" width="130">�����</td>
		</tr>
		<tr>
			<td>������������ ������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������]" value="�����"></td>
		</tr>
		<tr>
			<td>����� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][����� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">��������</td>
		</tr>
		<tr>
			<td>����������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][����������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>������� ������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� ����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����������]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">�����</td>
		</tr>
		<tr>
			<td>����� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][����� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� ��������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ��������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ��������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ��������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������� �����</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������� �����]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������� �����]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������� �����]" value="�����"></td>
		</tr>
		<tr>
			<td>������������ � ������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ � ������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ � ������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ � ������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������, ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������, ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������, ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������, ���������]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">�������</td>
		</tr>
		<tr>
			<td>�������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][�������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>������� ��� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� ����</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="�����"></td>
		</tr>
		<tr>
			<td>������������ ����</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">�������� "�������"</td>
		</tr>
		<tr>
			<td>�������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][�������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>������� ��� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� ����</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="�����"></td>
		</tr>
		<tr>
			<td>������������ ����</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">�����-���/����</td>
		</tr>
		<tr>
			<td>�������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][�������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>������� ��� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ��� �����������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� ����</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ����]" value="�����"></td>
		</tr>
		<tr>
			<td>������������ ����</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������������ ����]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">������-�����</td>
		</tr>
		<tr>
			<td>�������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][�������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>������� ������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="�����"></td>
		</tr>
		<tr>
			<td>����������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ������������]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">���������-���</td>
		</tr>
		<tr>
			<td>�������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][�������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>����������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">��������������</td>
		</tr>
		<tr>
			<td>����� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][����� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[��������������][����� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[��������������][����� �����������]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">��������������� �����</td>
		</tr>
		<tr>
			<td>����� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][����� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="�����"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">����������� ���</td>
		</tr>
		<tr>
			<td>����� �����������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][����� �����������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����� �����������]" value="�����"></td>
		</tr>

		<tr>
			<td colspan="4" class="question">�����</td>
		</tr>
		<tr>
			<td>����������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s++ ?>][����������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][����������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� ������������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� ������������]" value="�����"></td>
		</tr>
		<tr>
			<td>���������������� ���������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][���������������� ���������]" value="�����"></td>
		</tr>
		<tr>
			<td>������� ������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][������� ������]" value="�����"></td>
		</tr>
		<tr>
			<td>�������� �������</td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� �������]" value="�����������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� �������]" value="������"></td>
			<td align="center"><input <? print $radio_type?> name="static[<? print $s ?>][�������� �������]" value="�����"></td>
		</tr>
		</table>
	</td>
</tr>

<tr>
	<td colspan="4" class="question">�� ������ �� ������������ �������� ����� ������ � ����� �������, ������������ � "�����������". ����� ������� ��������� �� �������� �������� ��������������?</td>
</td>
	<td align="center">
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="���������� � ��������" name="static[<? print $s++ ?>][����� ������� ��������� �� �������� �������� ��������������?]"> ���������� � ��������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="���������� � ���" name="static[<? print $s ?>][����� ������� ��������� �� �������� �������� ��������������?]"> ���������� � ���</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="�������� �������" name="static[<? print $s ?>][����� ������� ��������� �� �������� �������� ��������������?]"> �������� �������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="��������� �������" name="static[<? print $s ?>][����� ������� ��������� �� �������� �������� ��������������?]"> ��������� �������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="���������� ���������" name="static[<? print $s ?>][����� ������� ��������� �� �������� �������� ��������������?]"> ���������� ���������</td>
</tr>
<tr>
			<td colspan="4" class="question">��������� ��������?</td>
</tr>
<tr>
	<td colspan="4" class="question">����������� �� �� � ������-���� ���������� ������� ���������� � ���������?</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="���" name="static[<? print $s++ ?>][����������� �� �� � ������-���� ���������� ������� ���������� � ���������?]"> ���</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="��" name="static[<? print $s ?>][����������� �� �� � ������-���� ���������� ������� ���������� � ���������?]"> �� (���������, ������� ��������)</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[<? print $i++ ?>]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">��������� ������ ��������� ��������� ���������� � ���������?</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="�����, ��� � ������(�)" name="static[<? print $s++ ?>][��������� ������ ��������� ��������� ���������� � ���������?]"> �����, ��� � ������(�)</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="�������� ���������" name="static[<? print $s ?>][��������� ������ ��������� ��������� ���������� � ���������?]"> �������� ���������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="����, ��� � ������(�)" name="static[<? print $s ?>][��������� ������ ��������� ��������� ���������� � ���������?]"> ����, ��� � ������(�)</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="�������� ��� � �� ���� ������" name="static[<? print $s ?>][��������� ������ ��������� ��������� ���������� � ���������?]"> �������� ��� � �� ���� ������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="� �������� �� �������(�)" name="static[<? print $s ?>][��������� ������ ��������� ��������� ���������� � ���������?]"> � �������� �� �������(�)</td>
</tr>

<tr>
	<td colspan="4" class="question">���� �� ��������, ��� ���-�� �� ����� ����������� ������ �������� ��� � ����� ���� �������, ����������, ������� ���(�) ���:</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[<? print $i++ ?>]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="����������� ��" name="static[<? print $s ?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?]"> ����������� ��</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="��������" name="static[<? print $s?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?]"> ��������</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="������� ���" name="static[<? print $s?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?]"> ������� ���</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="����������� ���" name="static[<? print $s?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?]"> ����������� ���</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="" name=""> ���� ����� �������������, �������, ����������, ������� <input type="text" class="text" value="" name="personality[<? print $i++ ?>]"></td>
</tr>

<tr>
	<td colspan="4" class="question">���� ����������� � ����������</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[<? print $i++ ?>]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">
		<br>
		<br>
		������� �� ���� �����. ���� ������ ����� ����� ��� ���.<br>
		�������� ������ ����� �������������� ��� � ������ ���������, � ��������� "�����������"***!
	</td>
</tr>
<tr>
	<td colspan="4" align="center" valign="middle" height="225" style="background: url('oktbr.jpg') bottom right no-repeat;"><input type="submit" class="submit" value="" name="submit" value="��������� ������ ������"></td>
</tr>
</form>
</table>
</td></tr></table>
</div>
</body>
</html>