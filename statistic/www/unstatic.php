4<html>
<head>
	<title>������1</title>
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
<? $radio_type="type=\"Checkbox\" checked";
	$other="������";
	$_POST=array();
?>
<table id="maintable" align="center" bgcolor="#ffffff"><tr><td>
<table width="730" height="100%" align="center" cellspacing="0" cellpadding="4">
<form method="post" action="static.php">
<tr>
	<td id="maintitle" colspan="4">� � � � � �&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;� � � � �</td>
</tr>
<tr>
	<td>�������</td>
	<td><input type="text" checked class="text" value="" name="last_name"></td>
	<td>����� �������</td>
	<td><input type="text" class="text" value="" name="room_number"></td>
</tr>
<tr>
	<td>���</td>
	<td><input type="text" class="text" value="" name="first_name"></td>
	<td>������ ����������</td>
	<td><input type="text" class="text" value="" name="length_of_stay"></td>
</tr>
<tr>
	<td>��� ���</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[���][���][���]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[���][���][���]">	
	<td>����� ��. �����</td>
	<td><input type="text" class="text" value="" name="e-mail"></td>
</tr>
<tr>
	<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������][�� 31]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������][31-40]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������][41-50]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������][�� 50]">
</tr>
<tr>
	<td colspan="4" class="question">��� �� ������ � ��������� "�����������"?</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][��� �� ������ � ��������� �����������?][���������� �����]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][��� �� ������ � ��������� �����������?][���������� � ������������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][��� �� ������ � ��������� �����������?][������������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][��� �� ������ � ��������� �����������?][���������� � ���]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][��� �� ������ � ��������� �����������?][��������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][��� �� ������ � ��������� �����������?][������� � ���������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][��� �� ������ � ��������� �����������?][������]">
</tr>
<tr>
	<td colspan="4" class="question">����� ������� ���� ������� ������������ ������ ������?</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ������� ���� ������� ������������ ������ ������?][���� ����� �� �������� ��� �����]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ������� ���� ������� ������������ ������ ������?][���� ����� ����������� ���� �������� ��� ��. �����]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ������� ���� ������� ������������ ������ ������?][���� ���������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ������� ���� ������� ������������ ������ ������?][����������� ��������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ������� ���� ������� ������������ ������ ������?][��������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ������� ���� ������� ������������ ������ ������?][������� � ���������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ������� ���� ������� ������������ ������ ������?][�������������]">
</tr>
<tr>
	<td colspan="4" class="question">����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?][������������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?][�������� ������]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][����� ����� ���������� �� ������������� ������������, �������� ������� � ������ ��������?][����������]">
</tr>
<tr>
	<td colspan="4" class="question">����� ������ ������������� �� ������ �� ������ � "�����������"?</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="����� ������ ������������� �� ������ �� ������ � �����������?"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">��� �� ��������, � ��� ������� ��������� "�����������" �� �������� ������� ���������?</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="��� �� ��������, � ��� ������� ��������� ����������� �� �������� ������� ���������?"></textarea></td>
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
			<td colspan="4" class="question">������������ ������</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[������������ ������][������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������������ ������][������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������������ ������][������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[������������ ������][����� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������������ ������][����� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������������ ������][����� �����������][�����]">
		
		</tr>
		
		<tr>
			<td colspan="4" class="question">��������</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][����������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][����������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][����������� ���������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][�������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][���������������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][���������������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][���������������� ���������][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][������� ������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][������� ������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][������� ������][�����]">
			
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][�������� ����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][�������� ����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������][�������� ����������][�����]">
		</tr>
	
		<tr>
			<td colspan="4" class="question">�����</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][����� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][����� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][����� �����������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ��������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ��������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ��������������][�����]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������� �����][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������� �����][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������� �����][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][������������ � ������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][������������ � ������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][������������ � ������][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������, ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������, ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������, ���������][�����]">
			
		</tr>

		<tr>
			<td colspan="4" class="question">�������</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][���������������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][���������������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][���������������� ���������][�����]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][������� ��� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][������� ��� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][������� ��� �����������][�����]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������� ����][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������� ����][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][�������� ����][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][������������ ����][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][������������ ����][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������][������������ ����][�����]">
		</tr>
		
		<tr>
			<td colspan="4" class="question">�������� "�������"</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][�������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][���������������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][���������������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][���������������� ���������][�����]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][������� ��� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][������� ��� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][������� ��� �����������][�����]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][�������� ����][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][�������� ����][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][�������� ����][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][������������ ����][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][������������ ����][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�������� �������][������������ ����][�����]">
			
		</tr>
		
		<tr>
			<td colspan="4" class="question">�����-���/����</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][�������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][���������������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][���������������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][���������������� ���������][�����]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][������� ��� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][������� ��� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][������� ��� �����������][�����]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][�������� ����][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][�������� ����][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][�������� ����][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][������������ ����][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][������������ ����][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����-���/����][������������ ����][�����]">
		</tr>
		
		<tr>
			<td colspan="4" class="question">������-�����</td>
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][�������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][���������������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][���������������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][���������������� ���������][�����]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][������� ������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][������� ������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][������� ������][�����]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][����������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][����������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[������-�����][����������� ������������][�����]">

		</tr>
		
		<tr>
			<td colspan="4" class="question">���������-���</td>
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][�������� ������������][�����]">
				
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][����������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][����������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][����������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[���������-���][���������][�����]">	

		</tr>
		
		<tr>
			<td colspan="4" class="question">��������������</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������������][����� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������������][����� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������������][����� �����������][�����]">

		</tr>
	
		<tr>
			<td colspan="4" class="question">��������������� �����</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������������� �����][����� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������������� �����][����� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[��������������� �����][����� �����������][�����]">

		</tr>
		<tr>
			<td colspan="4" class="question">����������� ���</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[����������� ���][����� �����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[����������� ���][����� �����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[����������� ���][����� �����������][�����]">
			
		</tr>
		<tr>
			<td colspan="4" class="question">�����</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][����������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][����������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][����������� ���������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ������������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ������������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ������������][�����]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������������� ���������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������������� ���������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][���������������� ���������][�����]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][������� ������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][������� ������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][������� ������][�����]">
			
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ����������][�����������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ����������][������]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[�����][�������� ����������][�����]">
		</tr>
<tr>
	<td colspan="4" class="question">�� ������ �� ������������ �������� ����� ������ � ����� �������, ������������ � "�����������". ����� ������� ��������� �� �������� �������� ��������������?</td>
<input type="Hidden" name="unstatic[<? print $other?>][����� ������� ��������� �� �������� �������� ��������������?][���������� � ��������]"  value="">
<input type="Hidden" name="unstatic[<? print $other?>][����� ������� ��������� �� �������� �������� ��������������?][���������� � ���]" value="">
<input type="Hidden" name="unstatic[<? print $other?>][����� ������� ��������� �� �������� �������� ��������������?][�������� �������]" value="">
<input type="Hidden"name="unstatic[<? print $other?>][����� ������� ��������� �� �������� �������� ��������������?][��������� �������]" value="">
<input type="Hidden" name="unstatic[<? print $other?>][����� ������� ��������� �� �������� �������� ��������������?][���������� ���������]" value="">

<tr>
			<td colspan="4" class="question">��������� ��������?</td>
</tr>
<tr>
	<td colspan="4" class="question">����������� �� �� � ������-���� ���������� ������� ���������� � ���������?</td>
	
	<input type="Hidden" name="unstatic[��������� ��������?][����������� �� �� � ������-���� ���������� ������� ���������� � ���������?][���]" value="">
	<input type="Hidden" name="unstatic[��������� ��������?][����������� �� �� � ������-���� ���������� ������� ���������� � ���������?][��]" value="">
	
</tr>
<tr>
	<td colspan="4" class="question">��������� ������ ��������� ��������� ���������� � ���������?</td>
	
	<input type="Hidden" name="unstatic[��������� ��������?][��������� ������ ��������� ��������� ���������� � ���������?][�����, ��� � ������(�)]" value="">
	<input type="Hidden"name="unstatic[��������� ��������?][��������� ������ ��������� ��������� ���������� � ���������?][�������� ���������]" value="">
	<input type="Hidden" name="unstatic[��������� ��������?][��������� ������ ��������� ��������� ���������� � ���������?][����, ��� � ������(�)]" value="">
	<input type="Hidden" name="unstatic[��������� ��������?][��������� ������ ��������� ��������� ���������� � ���������?][�������� ��� � �� ���� ������]" value="">
	
</tr>
<tr>
	<td colspan="4" class="question">����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?</td>
	
				<input type="Hidden" name="unstatic[<? print $other?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?][����������� ��]" value="">
				<input type="Hidden" name="unstatic[<? print $other?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?][��������]" value="">
				<input type="Hidden" name="unstatic[<? print $other?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?][������� ���]" value="">
				<input type="Hidden" name="unstatic[<? print $other?>][����� ���������� � ������ ���������, �������������� �� �� �������� ����� ��������� �����?][����������� ���]" value="">

</tr>
<tr>
	<td colspan="4" align="center" valign="middle" height="225" style="background: url('oktbr.jpg') bottom right no-repeat;"><input type="submit" class="submit" value="" name="submit" value="��������� ������ ������"></td>
</tr>
</form>
