<pre>
<?php
$neme = $_POST['skoko']['neme'];
$dir = $_POST['skoko']['dir'];
$a=true;
print "<br><H2>���������� ����� ����� ".$neme." � ���������� ".$dir."</H2>";
if(is_dir($dir))
{
if ($handle = opendir($dir))
{
$i=-1;
    while (false !== ($file = readdir($handle)))
	{

	if($file==$neme)
	{
		print "<br>� ���������� $dir $file ���� ��� � $i ";
		$a=false;
	}
$i++;
}
    closedir($handle); 
}
if($a)
{
print "File not found";
}
}
else{print "Directory not found";}

?>
</pre>
<a href="index.php"><br>���������</a>
