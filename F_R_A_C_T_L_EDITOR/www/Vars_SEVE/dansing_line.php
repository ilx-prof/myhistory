<?

//	print_r ($_POST);
	IF(!empty($_POST["vih"]))
	{
//		print  "ок";
		$imege_neme=$_POST["imege_neme"];
		$neme= $_POST["neme"]; 
		$vih = $_POST["vih"];
		$sir = $_POST["sir"];
		$R   = $_POST["R"];
		$dx  = $_POST["dx"];
		$dy  = $_POST["dy"];
		$ygol= $_POST["ygol"];
		$n   = $_POST["n"];
		$onedel = $_POST["onedel"];
		$alldel = $_POST["alldel"];
		$Rr     = $_POST["Rr"];
		$cvetmin = $_POST["cvetmin"];
		$cvetmax = $_POST["cvetmax"];
		$metod	 = $_POST["metod"];
		$FON = fon($_POST['fon']);
	}
	else
	{
//		print_r ($ARX);
			$i=0;
			$imege_neme= $ARX[$i++];
			$neme= $ARX[$i++];
			$vih = $ARX[$i++];
			$sir = $ARX[$i++];
			$R   = $ARX[$i++];
			$dx  = $ARX[$i++];
			$dy  = $ARX[$i++];
			$ygol= $ARX[$i++];
			$n   = $ARX[$i++];
			$onedel = $ARX[$i++];
			$alldel = $ARX[$i++];
			$Rr     = $ARX[$i++];
			$cvetmin = $ARX[$i++];
			$cvetmax = $ARX[$i++];
			$metod	 = $ARX[$i++];
			$FON   = $ARX[$i++];//..дырка для построения фрактала по умолчанию
	}
$SEVE=$imege_neme."*".$neme."*".$vih."*".$sir."*".$R."*".$dx."*".$dy."*".$ygol."*".$n."*".$onedel."*".$alldel."*".$Rr."*".$cvetmin."*".$cvetmax."*".$metod."*".$FON."
";
?>