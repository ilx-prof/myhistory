<?

//	print_r ($_POST);
	IF(!empty($_POST["vih"]))
	{
//		print  "ок";
		$imege_neme=$_POST["imege_neme"];
		$neme= $_POST["neme"]; 
		$vih = $_POST["vih"];
		$sir = $_POST["sir"];
		$n   = $_POST["n"];
		$cvet = $_POST["cvet"];
		$max_X= $_POST['max_X'];//2.2;//-0.35
		$max_Y= $_POST['max_Y']; //2.2;//-0.5
		$min_x= $_POST['min_x'];//-2.5;//-1
		$min_y= $_POST['min_y'];//-2.5 ;//-0.5
		$zoom=	$_POST['zoom'];
		$metod=$_POST['metod'];
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
		$n   = $ARX[$i++];
		$cvet = $ARX[$i++];
		$max_X= $ARX[$i++];
		$max_Y= $ARX[$i++];
		$min_x= $ARX[$i++];
		$min_y= $ARX[$i++];
		$zoom=$ARX[$i++];
		$metod=$ARX[$i++];
				$FON   = $ARX[$i++];
		}
$SEVE=$imege_neme."*".$neme."*".$vih."*".$sir."*".$n."*".$cvet."*".$max_X."*".$max_Y."*".$min_x."*".$min_y."*".$zoom."*".$metod."*".$FON."
";
?>