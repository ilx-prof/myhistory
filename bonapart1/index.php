<? 
//$user=array ("login"=>"ILX","password"=>"123");//массив с параметрами входа пользователя /login/password и пр
include_once ("functions.php");
GETS_qwest_aktion();

function GETS_qwest_aktion()
{

global $link;
	if (isset($_GET['mod']) or isset ($_POST['mod']))
	{
		if (isset ($_POST['mod']))
		{
			$_GET['mod']=$_POST['mod'];
		}
		switch ($_GET['mod'])
		{
			case "Ed":   include_once("editor.php"); break;
			case "Reg" : include_once("registracia.php"); break;
			case "ad"  : include_once("adminca.php"); break;
			default:	ob_start ();
				    	rasbor_get_paramert ();
						$data = ob_get_clean ( );
						$patt_array=array("Новые поступления","",navigation_meny(),$data,$link);
						include_once ("all.php");
		}
	}
	else
	{
		ob_start ();
		rasbor_get_paramert ();
			$data = ob_get_clean ( );
			$patt_array=array("Новые поступления",pattern_all(),navigation_meny(),$data,$link);
			include_once ("all.php");
	}
}

?>