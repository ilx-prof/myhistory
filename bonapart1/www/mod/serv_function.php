<?

function pattarn ($data_atrray,$patt_array,$file)//����������� ������ � ������ � ������������ ���������
{
//	$mas = array ("{image}","{Prise}","{Title}","{Mess}");
	$pat = file_get_contents ($file);
	return str_ireplace ($patt_array,$data_atrray,$pat);
}

function find_prise($id,$mes,$data)
{
	switch ($_POST['Prise_action'])
	{
		case "more": 
					if ($_POST['Prise']<=$data[0][0]['Prise'])
					{
						return $find =$id."/".$mes;
					}
		break;
		case "litle":
					if ($_POST['Prise']>=$data[0][0]['Prise'])
					{
						return $find =$id."/".$mes;
					}
		break;
		case "qvality": 
						if ($_POST['Prise']==$data[0][0]['Prise'])
						{
							return $find =$id."/".$mes;
						}
		break;
		default: return false;
					}
}

function find()
{
	$cat =cat();
	$categoria = $cat[0];
	$find = array ();
	if($_POST["Category"]!="All" && in_array ($_POST["Category"],$categoria))
	{
		$mes_find = file ("baraholca/SORT/".$_POST["Category"].".kat");
		foreach ($mes_find as $key => $id_mes)
		{
			$tmp = explode ("/",$id_mes);
  			$id = $tmp[0];
			$mes = trim($tmp[1]);
			$data = mesage($id,$mes);
			if(		$_POST['name']!="" &&
					strstr($data[0][0]['name'],$_POST['name'])&&
					$_POST['Mesaege']!="" &&
					strstr($data[0][0]['Mesaege'],$_POST['Mesaege']) &&
					$_POST['Prise']!=""
			  )
			{
							//..����� ����� ��  ����
				if( $a = find_prise($id,$mes,$data))
				{
					$find [] =  $a;
				}
			}
			elseif($_POST['Mesaege']!="" && 
					strstr($data[0][0]['Mesaege'],$_POST['Mesaege']) &&
					$_POST['Prise']!="")
			{
				if( $a = find_prise($id,$mes,$data))
				{
					$find [] =  $a;
				}
			}
			elseIF($_POST['Prise']!="")
			{
				if( $a = find_prise($id,$mes,$data))
				{
					$find [] =  $a;
				}
			}
		}
		if($find!=array() && count ($find) != 0)
		{
			$return = "<table>";
			foreach( $find as $nam => $idmes)
			{
				$tmp = explode ("/",$idmes);
  				$id = $tmp[0];
				$mes = trim($tmp[1]);
				$link = '<a href="index.php?action=have&us='.$id.'&mes='.$mes.'">���� �������!</a>|';//��� ���������� ����� �������� ����
				$return .=  "<tr><td>".return_mes("baraholca/USERS/".$id."/mes/".$mes.".mes")."</td></tr>";
			}
			$return .=  "</table>";
			print $return;
		}
		else
		{
			print "�������� ��������� �� ������� !!";
		}
	}
}




FUNCTION pattern_all($bag_mess = 'baraholca/SORT/Last.sort',$rev=false,$linc=false)
{
	$return = "";
	if ($bag_mess = file ($bag_mess))
	{
	}
	if ($bag_mess!=array())
	{
		if($rev==true)
		{
			array_reverse ($bag_mess);
		}
		$return .= "<table>";
		foreach ($bag_mess as $key => $mes)
		{
			$I = explode ('/',$mes);
			if($linc == "moder")
			{
					$link = '<a href="index.php?mod=Ed&edit['.$I[0].']='.$I[1].'">�������������</a>
					|<a href="index.php?mod=Ed&del_mes['.$I[0].']='.$I[1].'">�������</a>';
					;
			}
			else
			{
					$link ="";
//					$link = '<a href="index.php?action=have&us='.$I[0].'&mes='.$I[1].'">���� ������!</a>|';
			}
			$return .=  "<tr><td>".return_mes("baraholca/USERS/".$I[0]."/mes/".trim($I[1]).".mes",$link)."</td></tr>";
		}
		$return .=  "</table>";
	}
	else
	{
		$return .=  "��� �����������";
	}
	return $return;
}

function is_admin ()
{
	$Admins=array('ILX'=>md5('ILXILX'),'wsr'=>md5('123456'));
  	if(	isset ($Admins[$_COOKIE["baraholca"]["Password"]]) && $Admins[$_COOKIE["baraholca"]["Password"]]==$_COOKIE["baraholca"]["login"])
	{
		return true;
	}
	else
	{
		return false;
	}
}

function chek_cokie () //�������� ���� ������������ ����� ���� ���������� ���������� �� ���������� ��������
{
	$return =false;
	if(
		 	isset($_COOKIE["baraholca"]["login"])&&
		 	isset($_COOKIE["baraholca"]["Password"])&&
		 	isset($_COOKIE["baraholca"]["id"]) &&
			($login = $_COOKIE ["baraholca"]["Password"])!=false &&
			($Password = $_COOKIE ["baraholca"]["login"])!=false
	   )//..����� ����� � ������ ������ ���� �������������� ����������� 
	{
		$id = $_COOKIE ["baraholca"]["id"];//..���� �����������
		$file = file ("baraholca/reg.id");
		$id_log = array_search ($login."
",$file);
		if ($id!=="" && $id!==false && $id>=0 && $id == $id_log)
		{
			$user = unserialize(file_get_contents("baraholca/USERS/".$id."/p.id"));
			if ($login===$user["Login"] && $Password === $user["Password"])
			{
				 $return = array(true,"Log"=>$login,"pas"=>$Password,"id"=>$id);
			}
		}	else {$return = array(false,"Log"=>$login,"pas"=>$Password,"id"=>false);}
	}	else {$return = array(false,"Log"=>false,"pas"=>false,"id"=>false);}
	return $return;
}

function User_chek_rules ()//..�������� ���� ������������ � �������� ��������� ������������ �� �������� ���������� ���� �� �����
{
$return = array();
	if (($login = $_POST["user"]["Login"])!=false &&
	($Password = md5($_POST["user"]["Password"]))!=false )
	{
		$file = file ("baraholca/reg.id");
		$id = array_search ($login."
",$file);
		if ($id!=="" && $id!==false && $id>=0)
		{
			$user = unserialize(file_get_contents("baraholca/USERS/".$id."/p.id"));
			if ($login===$user["Login"] && $Password === $user["Password"])
			{
				//..����� �������� ������ ���� �������� ����� ������
					setcookie ("baraholca[login]", $Password); //..����� ������� �������� ������
					setcookie ("baraholca[Password]" , $login   ); //..����� ������� �������� ������ ������ ������ �������� =)
					setcookie ("baraholca[id]" , $id   ); //..����� ������� �������� id
					
				$return[] = true;
				$return[] = $id;
			}
		}	else { $return[] = false; }
	}
	return $return;
}


function chek_bag()
{
	if(file_exists("baraholca/USERS/".$_COOKIE["baraholca"]["id"]."/rights.u"))
	{
		return true;
	}
	else {	return false; }
}

function last_mes($id)//������ ����� ������ ��������������� � ���������������� ��������� �������������
{
	$name='';
	$mesage=array('mes'=>array(),'bag_mess'=>array(),'all'=>array());
	$dir =  opendir( getcwd ()."/baraholca/USERS/".$id."/mes");
	while (false !== ($file = readdir($dir)))
	{
       if ( $file!='.' && $file!='..' && !is_dir($file) )
	   {
	   		$name = explode('.',$file);
			if ($name[1]=='mes')
			{
				$mesage['mes'][]=$file;
			}
			if ($name[1]=='bag_mess')
			{
				$mesage['bag_mess'][]=$file;
			}
			$mesage['all'][]=$file;
	   }
    }
	
	return $mesage;
}

function mesage($id,$mes)//..���������� ������ �� ��������� 1 
{
 $mess = array();
	if ( file_exists ("baraholca/USERS/".$id."/mes/".$mes.".bag_mess"))
	{
	   $mess[0]= unserialize (file_get_contents(getcwd()."/baraholca/USERS/$id/mes/$mes.bag_mess"));
   	   $mess[1]= "bag_mess";
       $mess[2]= $id;
	}
	elseif(	file_exists ("baraholca/USERS/".$id."/mes/".$mes.".mes") )
	{
		$mess[0] = unserialize (file_get_contents(getcwd()."/baraholca/USERS/$id/mes/$mes.mes"));
	  	$mess[1]= "mes";
        $mess[2]= $id;
	}
	else 
	{
		print "������ ��������� �����������!";
		return false;
	}
		return $mess;
}

function serch_mess($data,$id)//.. �������� �������� ���������� ����������
{
	$unset= true;
	$mess = last_mes($id);
	$all = $mess['all'];
	foreach($all as $key => $mes)
	{
		$temp = file_get_contents (getcwd ()."/baraholca/USERS/$id/mes/$mes");
		if ($temp === $data)
		{
			$unset= false;
			break;
		}
	}
	return $unset;
}

function chek_mess($mess)//��������� ������������ ���������
{
	$return =false;
	$cat =cat();
	$categoria = $cat[0];
		//...�������� �������
		if( isset($mess["id"]) && $mess["id"]==$_COOKIE["baraholca"]["id"] &&
			isset($mess["name"]) && $mess["name"] !="" && strlen ($mess["name"] ) < 1024 &&
			isset($mess["Prise"]) && $mess["Prise"] !="" && strlen ($mess["Prise"]) < 60 &&
			isset($mess["Mesaege"]) && $mess["Mesaege"] !="" && strlen ($mess["Mesaege"]) < 20480 )
		{
				if (in_array($mess["Category"],$categoria))
				{
					$return = true;
				}
		}
		else
		{
			print "�� ��������� ";
		}
	return	$return;
}

function chek_edit_mess ($id,$mess)//..���������� �� ����������� ��������� ������ ���������
{
	$return=false;
	if($id==$_COOKIE["baraholca"]["id"] && ( file_exists ("baraholca/USERS/".$id."/mes/".$mess.".bag_mess") or file_exists ("baraholca/USERS/".$id."/mes/".$mess.".mes") ))
	{
		$return=true;
	}
	elseif(is_admin())
	{
		if( file_exists ("baraholca/USERS/".$id."/mes/".$mess.".bag_mess") or
		    file_exists ("baraholca/USERS/".$id."/mes/".$mess.".mes")
		  )
		{
			$return=true;
		}
	}
	return $return;
}

function log_ini ($string)
{
	$date=date("F j, Y, g:i:s T").":";
	$getday=gettimeofday();
	$string = str_replace ("
"," ",$string);
	fwrite ($f = fopen("baraholca/USERS/".$_COOKIE["baraholca"]["id"]."/log.txt","a"), $date.$getday["usec"]."-".$string."
");
	fclose ($f);
}


function translit($string)
{
	if (is_string($string))
	{
		$string = strtolower ($string);
	$rustr=array("�","a","�","b","�","b","�","g","�","d","�","e","�","e","�","g","�","z","�","i","�","i","�","k","�","l","�","m","�","n","�","o","�","p","�","r","�","s","�","t","�","y","�","f","�","x","�","ce","�","h","�","h","�","h","�","gi","�","e","�","y","�","a","�",chr (0),"�",chr (0));
		for ($i=0;$i<count($rustr)-1;$i++)
		{
			//print $rustr[$i]." - ".$rustr[++$i]."<br>";
			$string = strtr ($string,$rustr[$i],$rustr[++$i]);
		}
		return $string;
	}
}

	function cat ()
	{
		$cat = file ('baraholca/SORT/cat.r');
		$cats_file =array();
		foreach ($cat as $key => $val)
		{
			$tmp = explode("/",$val);
			$cats_file[0][] = trim($tmp[0]);
			$cats_file[1][] = trim($tmp[1]);
		}
		return $cats_file;
	}

function sise($file,$h)
{
	$sise = getimagesize($file);
	return	'width="'.$sise[0]*($h/$sise[1]).'" height="'.$h.'"';
}

function new_data_id()
{
print "<pre>";
	$id=$_COOKIE["baraholca"]["id"];
	print_r ($data_id = unserialize (file_get_contents (getcwd()."/baraholca/USERS/$id/p.id")));
	$return = "";
	if (isset ($_POST["user_data"]["Password"]) &&
	 ($pass = $_POST["user_data"]["Password"])!="" &&
			$pass == $_POST["user_data"]["Password0"] && strlen($pass)>4 
		)
	{
		if (isset ($_POST["user_data"]["e_mail"]) && ($pass = $_POST["user_data"]["e_mail"])!="")
		{
			$m =false;
			if( strlen($_POST["user_data"]["Password_new"]) >4 )
			{
				print "����� ������ ������ ".$_POST["user_data"]["Password_new"]."-".md5($_POST["user_data"]["Password_new"]);
				$m = true;
				$user_data["Login"]=$data_id["Login"];
				$user_data["Password"]=md5($_POST["user_data"]["Password_new"]);
				$user_data["Password0"]=md5($_POST["user_data"]["Password_new"]);
				$user_data["e_mail"]=$_POST["user_data"]["e_mail"];
			}
			elseif($_POST["user_data"]["Password_new"]=="")
			{
				print "����� ������ ��������";
				$m = 2;
				//..������ ������
				$user_data["Login"]=$data_id["user_data"]["Login"];
				$user_data["Password"]=$data_id["Password"];
				$user_data["Password0"]=$data_id["Password0"];
				$user_data["e_mail"]=$_POST["user_data"]["e_mail"];
				
			}
			else
			{
				print "<p align=\"center\">������ �� ������� ��������� ���������� ��������</p><br>";
				include_once ("htm/profile.php");
			}
			if ($m==true)
			{
				print_r ($user_data);
				fwrite ($f = fopen("baraholca/USERS/".$id."/p.id","w+"), serialize($user_data));
				fclose($f);
				print "Ecgtiyj!!";
				setcookie ("baraholca[login]", $user_data['Password']); //..����� ������� �������� ������
				$_COOKIE["baraholca"]["login"] = $user_data['Password'];
				print "������ ���������";
			}
			elseif($m==2)
			{
				print_r ($user_data);
				fwrite ($f = fopen("baraholca/USERS/".$id."/p.id","w+"), serialize($user_data));
				print "������ ���������";
			}
		}
		else
		{
			print "<p align=\"center\">����� �������� ���� �����������</p><br>";
			include_once ("htm/profile.php");
		}
	}
	else
	{
	
		print "<p align=\"center\">����� ��������� �� ���������� ��������� ���� </p><br>";
		include_once ("htm/profile.php");
	}
}
?>