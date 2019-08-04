<pre>
<?
include ("include_functions.php");
$neme_part="Users.txt";
//print_r ($bis=get_string($neme_part));
$bis=get_string($neme_part);
foreach ($bis as $key => $val )
{
//print $val;
	$arr[]=bstavka("blok.php",$val);
}

//print_r ($arr);
print matrca ($arr,5);

?>