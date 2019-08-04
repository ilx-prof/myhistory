<?php
IF(@!empty($_POST["vih"]))
	{
	$imege_neme=$_POST["imege_neme"];
	$neme = $_POST["neme"];
	$vih = $_POST["vih"] ;
	$sir = $_POST["sir"] ;
	$metod	 = $_POST["metod"] ;
	@$file	= $_POST["file"];
	$wey	= $_POST["wey"];
	@$string	= $_POST["string"];
	$FON = fon($_POST['fon']);
	}
	else
	{
		//D случае если зашли не по нормальной ссылке загружаеться стандартныйц массив который здесь и создается
		$imege_neme= $ARX[$i++];
		@$neme= $ARX[$i++];//2
		$vih = $ARX[$i++];//3
		$sir = $ARX[$i++];//4
		$metod	 = $ARX[$i++];//5
		$file	= $ARX[$i++];//6
		$wey	= $ARX[$i++];
		$string   = $ARX[$i++];
		$FON   = $ARX[$i++];
		//print_r ($ARX);
}
$SEVE =$imege_neme."*".$neme."*".$vih."*".$sir."*".$metod."*".$file."*".$wey."*".$string."*".$FON."
";
?>
