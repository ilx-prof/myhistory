<?
function rasbor_get_paramert ()//...���� ������ ���  ������������� ������ ������ �� ��� � �����
{
	if(isset($_GET['action']))
	{
		switch($_GET['action'])
		{
			case "have" : if(isset($_GET['us']) &&  isset($_GET['mes'])&&   $_GET['us']>=0 && $_GET['mes']>=1)
							{
								print "����� ��� �������� ��������� ����� ������";
							}
						  break;
			case "find" : 
							if (isset($_POST) and $_POST!=array () and isset ($_POST['Submit_faind']))
							{
								print "���������� ������<pre>";
								find();
							}
							else
							{
								print file_get_contents("htm/find.htm");
							}
								break;
								
			case "kat" : if(isset($_GET['kat']))
							{
								$cat=cat();
								IF(in_array($_GET['kat'],$categoria=$cat[0]))
								{
									print pattern_all ('baraholca/SORT/'.$_GET['kat'].'.kat',true);
								}
								else{header("Location: index.php");}
							}else {header("Location: index.php");}
							break;
			case "news" : print pattern_all(); break;
			case "input_img" : 
									if(isset($_GET["input_img"]) and isset($_GET["id"]))
						          	{
										input_img ($_GET["id"],$_GET["input_img"]);
									}
									break;
			case "input_im" : 
									if(isset($_GET["input_im"]) and isset($_GET["id"]) and isset($_GET["im"]))
						          	{
										input_im ($_GET["id"],$_GET["input_im"],$_GET["im"]);
									}
									break;
			default :	header("Location: index.php");
		}
	}
	else
	{
		include_once('main.php') ;
	}
}

/////////////////////////////...........................................................................................��������� 

function navigation_meny()//������������� ���� ��� �������� ���������
{
	if (isset ($_POST["user"]) )
	{
		$user = $_POST["user"];
		$User_chek_id = User_chek_rules ($_POST["user"]);
	}
	$chek_cokie = chek_cokie ();
	$menu = "";
	if ( isset($user) && isset ($User_chek_id[0]) && $User_chek_id [0] )
	{
		$menu = file_get_contents ("htm/navigation.htm");
		$mas = array ("{Login}","{id}");
		$menu = str_ireplace ($mas,array($user["Login"],$User_chek_id[1]),$menu);
	}
	elseif($chek_cokie[0] )
	{
		$menu = file_get_contents ("htm/navigation.htm");
		$mas = array ("{Login}","{id}");
		$menu = str_ireplace ($mas,array($chek_cokie["Log"],$chek_cokie["id"]),$menu);
	}
	else { $menu = file_get_contents ("htm/no_ent_navigation.htm"); }
	return $menu ;
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////........������ 
function select_action ()
{
	$chek_cokie = chek_cokie () ;
	if(!$chek_cokie[0])
	{
		header("Location: index.php");
		exit;
	}
	$user_id=$chek_cokie["id"];
	Global $main;
	if (isset($_GET) and $_GET!=array() and chek_cokie ())
	{
		if(/*cdatabag()*/true)
		{
					//print "������ ���";
			if (isset($_GET["Profile"]))			//�������� ����� � ������� ������� ��� ������� ������������
			{
				profile ($user_id);
			}
			elseif(isset($_GET["My_Anonce"]))			//..�������� ���� ���� ���������� � ������� �������������
			{
				all_my_message ($user_id);
			}
			elseif(isset($_GET["New_Anonce"]))			//�������� ����� ���������� ����������
			{
				include_once ("htm/new_mes.php");
			}
			elseif(isset($_GET["End_session"]))			//�������� ������� � ����������� � �������� ��������
			{
				del_cookie();
				header("Location: index.php");
				exit;
			}
			elseif(isset($_GET["ad_mes"]))
			{
				if(isset($_POST) && $_POST!=array() && chek_cokie ())
				{
					if (isset($_POST["Submit_new_mes"]))//
					{
						if (isset($_POST["Category"]) && isset($_POST["name"]) && isset($_POST["Prise"]) && isset($_POST["Mesaege"]))
						{
							$mess=$_POST;//�� ����������� ����������
							unset($mess["Submit_new_mes"]);
							unset($mess["mod"]);
							add_message ($mess);// ���������� ���������
						}
						else
						{
							print  '<p align="center">����� ��������� �� ���������</p>';
						}
					}
					else{print "������ � ����� ��������!";}
				}
			}
			elseif(isset($_GET["del_mes"]) && is_array($mes = $_GET["del_mes"]))
			{
				//..�������� ������������� ��������
				foreach ($mes as $id => $mess)
				{
					if (chek_edit_mess ($id,$mess) )
					{
						del_message ($id,$mess);
						header("Location: index.php?mod=Ed&My_Anonce=$id");
					}
					else
					{
						print "������ ������� ��� ����������";
					}
				}
			}
			elseif(isset($_GET["edit"]))
			{
				if (is_array($mes = $_GET["edit"]))
				{
					foreach ($mes as $id => $mess)
					{
						if (chek_edit_mess ($id,$mess) )
						{
							edit ($id,$mess);
						}
						else
						{
							print "������ ������� ��� ����������";
						}
					}
				}
				elseif($_GET["edit"]=="replase")
				{
					if(isset($_POST) && $_POST!=array() )
					{
						if (isset($_POST["Submit_new_mes"]))//
						{
							if ( isset($_POST["text"]["Category"]) &&
								 isset($_POST["text"]["name"]) &&
								 isset($_POST["text"]["Prise"]) &&
								 isset($_POST["text"]["Mesaege"]))
							{
									
        							replase_edit();// �������������� ��������� � �������� ������
							}
							else
							{
								print  '<p align="center">����� ��������� �� ���������</p>';
							}
						}
						else{print "������ � ����� ��������!";}
				}
                                print "�������� ���� ���� � ������� �������";
				}
				else
				{
					PRINT "������������ ���������� !";
				}
			}
		}
		else
		{
			print "���� ������� ������ ���������� �� ������������";
		}
	}
	else
	{
		print "����������� ���������� �������!"  ;
	}
}

//....................................................................................................................����������� 

	function chek_qwest ()//�������� ������������ �������
	{
		$return = "";
		if (isset($_POST["user_data"]) && $_POST["submit_reg"]==="������������������")
		{
			// ����� ���� ������� ��������� � ����� ��� ����
			if ( isset ($_POST["user_data"]["Login"]) && ($login = $_POST["user_data"]["Login"])!="")
			{
				if (isset ($_POST["user_data"]["Password"]) && ($pass = $_POST["user_data"]["Password"])!="" &&
					$pass == $_POST["user_data"]["Password0"] && strlen($pass)>4
					)
				{
					if (isset ($_POST["user_data"]["e_mail"]) && ($pass = $_POST["user_data"]["e_mail"])!="")
					{
						//����� ��� �������� ������ �� ������������ ��������� =)
						$file = file ("baraholca/reg.id");
						if (!in_array($login."
",$file))
						{
							if (fwrite ($f = fopen("baraholca/reg.id","a"),$login."
"))
							{
								fclose ($f);
								if	(add_new (count($file)))
								{
									print "<p align=\"center\">���������� ������ ������������ ������ �������</p>";
								}
							}
						}
						else
						{
							$return .="<p align=\"center\">������ ����� ��� ��������������� </p><br>".file_get_contents ("htm/reg.htm");
						}
					}
					else
					{
						$return .="<p align=\"center\">����� ��������� �� ��������� ��������� ���� </p><br>".file_get_contents ("htm/reg.htm");
					}
				}
				else
				{
					$return .="<p align=\"center\">����� ��������� �� ��������� ��������� ���� </p><br>".file_get_contents ("htm/reg.htm");
				}
			}
			else
			{
				$return .="<p align=\"center\">����� ��������� �� ��������� ��������� ���� </p><br>".file_get_contents ("htm/reg.htm");
			}
		}
		else
		{
			$return .= file_get_contents ("htm/reg.htm");
		}
		return $return;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>