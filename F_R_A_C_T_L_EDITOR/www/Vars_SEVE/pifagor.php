<?php
IF(@!empty($_POST["vih"]))
	{
	$imege_neme=$_POST["imege_neme"];
	$neme =  $_POST["neme"];
	$vih = $_POST["vih"] ;
	$sir = $_POST["sir"] ;
	$delta=$_POST["delta"] ;
	$dx  = $_POST["dx"] ;
	$dy  = $_POST["dy"] ;
	$dX  = $_POST["dx1"] ;
	$dY  = $_POST["dy1"] ;
	$n   = $_POST["n"] ;
	$aa = $_POST["aa"] ;
	$bb = $_POST["bb"] ;
	$Rr     = $_POST["Rr"] ;
	$Rr1    = $_POST["Rr1"] ;
	$VINN = $_POST["VINN"];
	$cvetmin = $_POST["cvetmin"] ;
	$cvetmax = $_POST["cvetmax"] ;
	$metod	 = $_POST["metod"];
	$zoom	= $_POST["zoom"] ;
	$PL		= $_POST["PL"] ;
	$ygol	= $_POST["ygol"];
	$cvet	= $_POST["cvet"];
	$FON    = fon($_POST['fon']);
	$tvig   = $_POST['tvig'];
	$tree	= isset ($_POST['tree'])? $_POST['tree'] : false ;
	}
	else
	{
			$i=0;
		//D случае если зашли не по нормальной ссылке загружаеться стандартныйц массив который здесь и создается
		$imege_neme=$ARX[$i++];
		$neme= $ARX[$i++];//2
		$vih = $ARX[$i++];//3
		$sir = $ARX[$i++];//4
		$delta=$ARX[$i++];//6
		$dx  = $ARX[$i++];//7
		$dy  = $ARX[$i++];//8
		$dX  = $ARX[$i++];//9
		$dY  = $ARX[$i++];//10
		$n   = $ARX[$i++];//11
		$aa  = $ARX[$i++];//12
		$bb  = $ARX[$i++];//13
		$Rr  = $ARX[$i++];//14
		$Rr1 = $ARX[$i++];//15
		$VINN = $ARX[$i++];
		$cvetmin = $ARX[$i++];//16
		$cvetmax = $ARX[$i++];//17
		$metod	 = $ARX[$i++];//18
		$zoom	= $ARX[$i++];//19
		$PL		= $ARX[$i++];//20
		$ygol	= $ARX[$i++];
		$cvet   = $ARX[$i++];
		$FON   = $ARX[$i++];
		$tvig  = $ARX[$i++];
		$tree  = $ARX[$i++];
		//print_r ($ARX);
}
$SEVE =$imege_neme."*".$neme."*".$vih."*".$sir."*".$delta."*".$dx."*".$dy."*".$dX."*".$dY."*".$n."*".$aa."*".$bb."*".$Rr."*".$Rr1."*".$VINN."*".$cvetmin."*".$cvetmax."*".$metod."*".$zoom."*".$PL."*".$ygol."*".$cvet."*".$FON."*".$tvig."*".$tree."
";
?>