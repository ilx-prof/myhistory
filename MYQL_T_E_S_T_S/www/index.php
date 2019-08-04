<body bgcolor="#F5F5F5">
<?php
$servak = isset($_POST['servak']) ? $_POST['servak'] : "localhost";
$log	= isset($_POST['log']) ? $_POST['log'] : "root";
$pass	= isset($_POST['pass'
]) ? $_POST['pass'] : "";
$DB 	= isset($_POST['DB']) ? $_POST['DB'] : "";
$comand = isset($_POST['comand']) ? $_POST['comand'] : "SHOW DATABASES";
?>

<table cellspacing="2" cellpadding="2" width="100%" >
<tr valign="top">
	<td align="center" >
		<table  width="90%" height="100%" style="border:1px solid grey;">
		<tr>
			<td>
				SHOW DATABASES - Вывести список баз<br><br>
				CREATE DATABASE base_name - создать новую базу <br><br>
				DROP DATABASE base_name - удалить базу <br><br>
				CREATE TABLE table_name - создать новую таблицу <br><br>
				DROP TABLE  table_name - удалить базу <br><br>
				ALTER TABLE table_name - измениеть таблицу <br><br>
							-//-RENAME table_name1- переименовать таблицу table_name в table_name1<br><br>
				INSERT INTO table_name(field_name1, field_name2,...) values('content1', 'content2',...) - вставка новой записи<br><br>
				<a href="mysql.htm">Читать Краткое содержание</a>
			</td>
		</tr>
		</table>
	</td>
	<td>
<table align="center" cellspacing="2" cellpadding="2" style="border:1px solid grey;">
<tr>
	<td>
		<table align="center" cellspacing="2" cellpadding="2" >
		<form action="index.php" method="post">
		<tr>
			<td>
				<input type="Text" name="servak" value="<? print $servak;?>" style="width:100%;">
			</td>
			<td>
				Сервер
			</td>
		</tr>
		<tr>
			<td>
				<input type="Text" name="log" value="<? print $log;?>" style="width:100%;">
			</td>
			<td>
				Логин
			</td>
		</tr>
		<tr>
			<td>
				<input type="Text" name="pass" value="<? print $pass;?>" style="width:100%;">
			</td>
			<td>
				Пароль
			</td>
		</tr>
		<tr>
			<td>
				<input type="Text" name="DB" value="<? print $DB;?>" style="width:100%;">
			</td>
			<td>
				База данных
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="comand" style="height:100px; width:100%;"><? print $comand;?></textarea><br>
				<input type="Submit" name="GO" value="Запрос">
				
			</td>
		</tr>
		</form>
		<tr>
			<td colspan="2">
				<table width="600"  style="border:1px solid grey;">
				<tr>
					<TD>
						<?php
						if (!empty($servak) && $dbres = mysql_connect($servak,$log,$pass))
						{
							mysql_select_db($DB,$dbres);
							$result = mysql_query($comand);
							print "$comand => <br><pre>";
							if (mysql_num_rows($result))
							{
								$Data=array();
								while ($tmp = mysql_fetch_assoc ($result))
								{
									$Data[] = $tmp;
								}
								print_r ($Data);
								
							}
						}
						print " </pre>";
						?>
					</TD>	
				</tr>
				</table>
			</td>
		</tr>		
		</table>
	</td>
</table>
	</td>
</tr>
</table>
</body>