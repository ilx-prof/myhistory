<?php
IF(@!empty($_POST["vih"]))
	{
	$imege_neme=$_POST["imege_neme"];
	@$neme = $_POST["neme"];
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
	$cvetmin = $_POST["cvetmin"] ;
	$cvetmax = $_POST["cvetmax"] ;
	$metod	 = $_POST["metod"] ;
	$zoom	= $_POST["zoom"] ;
	$PL		= $_POST["PL"] ;
	$ygol= $_POST["ygol"];
	$FON = fon($_POST['fon']);
	}
	else
	{
			//D случае если зашли не по нормальной ссылке загружаеться стандартныйц массив который здесь и создается
		$imege_neme=$ARX[$i++];
		$neme= $ARX[$i++];
		$vih = $ARX[$i++];
		$sir = $ARX[$i++];
		$delta=$ARX[$i++];
		$dx  = $ARX[$i++];
		$dy  = $ARX[$i++];
		$dX  = $ARX[$i++];
		$dY  = $ARX[$i++];
		$n   = $ARX[$i++];
		$aa  = $ARX[$i++];
		$bb  = $ARX[$i++];
		$Rr  = $ARX[$i++];
		$Rr1 = $ARX[$i++];
		$cvetmin = $ARX[$i++];
		$cvetmax = $ARX[$i++];
		$metod	 = $ARX[$i++];
		$zoom	= $ARX[$i++];
		$PL		= $ARX[$i++];
		$ygol	= $ARX[$i++];
				$FON   = $ARX[$i++];
		
}
$SEVE=$imege_neme."*".$neme."*".$vih."*".$sir."*".$delta."*".$dx."*".$dy."*".$dX."*".$dY."*".$n."*".$aa."*".$bb."*".$Rr."*".$Rr1."*".$cvetmin."*".$cvetmax."*".$metod."*".$zoom."*".$PL."*".$ygol."*".$FON."
";
?>