<pre>
<?php
if($txt = $_POST["jfdsghdfhf"])
{	$slovar=fopen("txt.txt","w+");
	$txt = strtolower($txt);
	$pieces = explode(" ", $txt);
	$pieces = array_unique ($pieces);
	sort($pieces);
	print "��� �������� ����� ������ ���������� ����� ����� ".(count($pieces)-1)." ����: <br>";
	for ($i = 0; $i <= count($pieces)-1; $i++)
	{	fwrite($slovar,$pieces[$i]."
");
	}
	fclose($slovar);
	readfile("txt.txt");
	$pieces = implode("<br>", $pieces);
}

/*if($txt = $_POST['text'])
{
	$txt = strtolower($txt);
	$pieces = explode(" ", $txt);
	$pieces = array_unique ($pieces);
	sort($pieces);
	print "��� �������� ����� ������ ���������� ����� ����� ".(count($pieces)-1)." ����: <br>";
	for ($i = 0; $i <= count($pieces)-1; $i++)
	{
		print $pieces[$i]."<br>";
	}
	$pieces = implode("<br>", $pieces);
}*/
?>
</pre>
<form action="filtrr.php" method="post">
� ������� <input type="Radio"  name="lang" value="eng" checked><br>
C ����������<input type="Radio"  name="lang" value="rus"><br> 
<br>������� ������� ���� ����� �������� ����<br>
<textarea name="text" value="text" rows="20" cols="100" ></textarea>
<input type="Submit" value="��������">
</form>