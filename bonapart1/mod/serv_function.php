<?

		$cat = cat();
		$link="";
		foreach($cat[0] as $key => $name_post)
		{
				$link .='&nbsp;&nbsp;<A href="index.php?action=kat&kat='.$name_post.'">'.$cat[1][$key].'</A>';
		}
	$link .='&nbsp;&nbsp;<A href="index.php?action=news">����� �����������</A>
			&nbsp;&nbsp;<a href="index.php?action=find">�����</a>
			&nbsp;&nbsp;<A href="index.php">�������</A>';



function pattarn ($data_atrray,$patt_array,$file)//����������� ������ � ������ � ������������ ���������
{
//	$mas = array ("{image}","{Prise}","{Title}","{Mess}");
	$pat = file_get_contents ($file);
	return str_ireplace ($patt_array,$data_atrray,$pat);
}

function find_prise($id,$mes,&$data)
{
	switch ($_POST['Prise_action'])
	{
		case "more": 
					if ($_POST['Prise']<$data[0][0]['Prise'])
					{
						return $find = $id."/".$mes;
					}
		break;
		case "litle":
					if ($_POST['Prise']>$data[0][0]['Prise'])
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
		default:
		 return false;
					}
}

function find()
{
	$cat =cat();
	$categoria = $cat[0];
	$find = array ();
	print "<pre>";
	print_r ($_POST);
	if($_POST["Category"]!="All" && in_array ($_POST["Category"],$categoria))
	{
		$mes_find = file ("baraholca/SORT/".$_POST["Category"].".kat");
		foreach ($mes_find as $key => $id_mes)
		{
			$tmp = explode ("/",$id_mes);
  			$id = $tmp[0];
			$mes = trim($tmp[1]);
			$data = mesage($id,$mes);
			if(	$_POST['name']!="" &&$_POST['Mesaege']!="" )
			{
				//..����� ����� ��  ����
				if(strpos ($data[0][0]['name'],$_POST['name'])!==FALSE &&
				   strpos ($data[0][0]['Mesaege'],$_POST['Mesaege'])!==FALSE &&
				 $a = find_prise($id,$mes,$data))
				{
					$find [] =  $a;
				}
			}
			elseif($_POST['Mesaege']!="")
			{
				if(strpos ($data[0][0]['Mesaege'],$_POST['Mesaege'])!==FALSE && $a = find_prise($id,$mes,$data))
				{
					$find [] =  $a;
				}
			}
			elseif($_POST['name']!="" )
			{
				if(	strpos ($data[0][0]['name'],$_POST['name'])!==FALSE && $a = find_prise($id,$mes,$data))
				{
					$find [] =  $a;
				}
			}
			else
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
	if (file_exists ($bag_mess))
	{
		$bag_mess = file ($bag_mess);
	}
	else 
	{
		$bag_mess=array();
	}
	if ($bag_mess!=array())
	{
		//array_reverse ($bag_mess);
		if($rev)
		{
			$tmp=array();
			for ($i = count($bag_mess)-1;$i>=0;$i--)
			{
				$tmp[]=$bag_mess[$i];
			}
			$bag_mess=$tmp;
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
	   $mess[3]= $mes;
	}
	elseif(	file_exists ("baraholca/USERS/".$id."/mes/".$mes.".mes") )
	{
		$mess[0] = unserialize (file_get_contents(getcwd()."/baraholca/USERS/$id/mes/$mes.mes"));
	  	$mess[1]= "mes";
        $mess[2]= $id;
	   $mess[3]= $mes;
	}
	else 
	{
		print "������ ��������� "."baraholca/USERS/".$id."/mes/".$mes.".mes"." �����������!";
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
	if(isset($mess["id"]) && ($mess["id"]==$_COOKIE["baraholca"]["id"] or is_admin()))
	{
		if(isset($mess["name"]) && $mess["name"] !="" && strlen ($mess["name"] ) < 1024)
		{
			if(isset($mess["Prise"]) && $mess["Prise"] !="" && strlen ($mess["Prise"]) < 60)
			{
				if(isset($mess["Mesaege"]) && $mess["Mesaege"] !="" && strlen ($mess["Mesaege"]) < 1048606 )
				{
					if (in_array($mess["Category"],$categoria))
					{
						$return = true;
					}
					else
					{
						print "<br>����������� �������� ��������!";
					}
				}
				else
				{
					print "<br>����������� �������� �������� ���� ���� ��� ����� ��������� 1048606 �������!";
				}
			}
			else
			{
				print "<br>����������� �������� ���� ���� ���� ��� ����� ��������� 60 �������!" ;
			}
		}
		else
		{
			print "<br>����������� �������� ����� ���� ���� ��� ����� ������� �������";
		}
	}
	else
	{
		print "<br> ��� ���� �� ���������� ������� ���������!";
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
	$sise = getimagesize(getcwd().'/'.$file);
	return	'width="'.$sise[0]*($h/$sise[1]).'" height="'.$h.'"';
}

function new_data_id()
{
	$id=$_COOKIE["baraholca"]["id"];
	$data_id = unserialize (file_get_contents (getcwd()."/baraholca/USERS/$id/p.id"));
	$return = "";
	//print_r ($data_id);
	if (isset ($_POST["user_data"]["Password"]) &&
	 	md5($_POST["user_data"]["Password"]) === $_COOKIE["baraholca"]["login"]&&
		 $_COOKIE["baraholca"]["login"] ===	$data_id['Password']&&
		($pass = $_POST["user_data"]["Password_new"]) === $_POST["user_data"]["Password0"] &&
		 strlen($pass)>4 
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
				print "����� ������ �����������!";
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
//				print_r ($user_data);
				fwrite ($f = fopen("baraholca/USERS/".$id."/p.id","w+"), serialize($user_data));
				fclose($f);
				print "Ecgtiyj!!";
				setcookie ("baraholca[login]", $user_data['Password']); //..����� ������� �������� ������
				$_COOKIE["baraholca"]["login"] = $user_data['Password'];
				print "<br>���� ������ ���������";
			}
			elseif($m==2)
			{
				fwrite ($f = fopen("baraholca/USERS/".$id."/p.id","w+"), serialize($user_data));
				print "<br>���� ������ ���������";
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

function ResizeImage(&$image,$new_width,$new_height)
	{
		$width = imagesx ($image)-1;
		$height = imagesy ($image)-1;
		$image_p = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($image_p, $image, 0, 0,0,0, $new_width, $new_height, $width, $height);
		return $image_p;
	}
	
function chek_sise($id,$fil_nam)
{
	$s = filesize ("baraholca/USERS/$id/img/med.jpg");
	$sise = true;
	$dh = opendir("baraholca/USERS/$id/img/");
	while (false != ($fil = readdir($dh)))
	{
		$m = explode("_",$fil);
		$m = $m[0];
		if ($fil != "." && $fil != ".." && $fil != "temp.jpg" && $fil != "med.jpg" && $fil != "min.jpg")
		{
			$stat = filesize ("baraholca/USERS/$id/img/".$fil);
			if($stat == $s)
			{
				$sise = false;
				print "<br>����������� $fil_nam ��� ������������ � ����� ����������";
			}
		}
	}
	return $sise;
}
	
function creat_img_summ($id,$fil_nam)
{
	$TMP = getcwd()."/baraholca/USERS/$id/img/temp.jpg";
	$IM = @imagecreatefromjpeg($TMP);
	IF ($IM)
	{
		$xy = ARRAY(imagesx ($IM),imagesy($IM));
		$h=imagesy ($IM)-1;
		$w=imagesx ($IM)-1;
		$TMP = "baraholca/USERS/$id/img/med.jpg";
		IF ($xy[0]>=$xy[1])
		{
			imagejpeg (ResizeImage($IM,160,floor(160*$h/$w)),"baraholca/USERS/$id/img/"."min.jpg");
			IF ($xy[0] <= 800 )
			{
				imagejpeg ($IM,$TMP);
			}
			ELSE
			{
				imagejpeg (ResizeImage($IM,800,floor(800*$h/$w)),$TMP);
			}
		}
		else
		{
			imagejpeg (ResizeImage($IM,160,floor(160*$h/$w)),"baraholca/USERS/$id/img/min.jpg");
			IF ($xy[1] <= 600 )
			{
				imagejpeg ($IM,$TMP);
			}
			ELSE
			{
				imagejpeg (ResizeImage($IM,floor(600*$h/$w),600),$TMP);
			}
		}
		RETURN chek_sise($id,$fil_nam);
	}
	else
	{
		RETURN false;
	}
	
}
?>