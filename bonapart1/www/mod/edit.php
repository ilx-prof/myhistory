<?
function all_my_message ($user_id) // ���������� ��� ��� ��������� � ������������� /���������� ������ ��������� / �������� ��������� /�������������� ���������
{
		$dir = getcwd()."/baraholca/USERS/$user_id/mes/";
		print "������� ��� ��� ���������<pre>";
		$mes = last_mes($user_id);
		$return = "<table>";
		foreach ($mes['mes'] as $key => $f_name)
		{
			$type = explode (".",basename ($f_name));
			$link = '<a href="index.php?mod=Ed&edit['.$user_id.']='.$type[0].'">�������������</a>
					|<a href="index.php?mod=Ed&del_mes['.$user_id.']='.$type[0].'">�������</a>';
			$return .= '<tr><td>'.return_mes( $dir.$f_name,$link).'</tr></td>';
		}
		foreach ($mes['bag_mess'] as $key => $f_name)
		{
			$type = explode (".",basename ($f_name));
			$link = '<a href="index.php?mod=Ed&edit['.$user_id.']='.$type[0].'">�������������</a>
					|<a href="index.php?mod=Ed&del_mes['.$user_id.']='.$type[0].'">�������</a>';
			$return .= '<tr><td>'.return_mes( $dir.$f_name,$link).'</tr></td>';
		}
	print $return.'</table>';
}

function return_mes($file_mess ,$link = "" ,$shablon = "htm/brahlo.htm")//..���������� ���������� � ������ ���������
{
	if (file_exists($file_mess))
	{
		$mess = unserialize (file_get_contents($file_mess));
		$type = explode (".",basename ($file_mess));
		$img=$mess[1];
		$mess=$mess[0];
		$image="";
		foreach ($img as $key => $way)
		{
			$id_falt=explode ("/",$file_mess);
			$id = $id_falt[array_search ("USERS",$id_falt)+1];
			$sise = sise($way,120);
			$image .='<span tooltip="������ ��������"><a href="index.php?action=input_img&id='.$id .'&input_img='.$type[0].'"><img src="'.$way.'" '.$sise.'"></a><br>';
			BREAK;//...................����  �������� ������� ������ ���� �������� ������ ������ ������!
		}
		if ($type[1] == "bag_mess")
		{
			$mess["name"] .= "<H3>����������� ���������� ��������� � �������� ������������</H3>";
		}
		$cat = cat();
		$kat = $cat[1][array_search($mess["Category"],$cat[0])];//..����� �� ������������� ���� ������� �������� ��������� 
		$patt_array=array($image,$mess["Prise"],$mess["name"],$mess["Mesaege"]."<br>".$mess["Time"],$link);
		$data_atrray=array("{image}","{Prise}","{Title}","{Mess}","{link}");
		return pattarn ($patt_array,$data_atrray,$shablon );
	}
}


function input_im ($id,$num_mes,$im)
{
	$mesage = mesage($id,$num_mes);
	print '<img src="'.$mesage[0][1][$im].'">';
}



function input_img ($id,$num_mes)
{
	$mesage = mesage($id,$num_mes);
	$mess = $mesage[0][0];
	$print_im=""; 
	foreach ($mesage[0][1] as $num => $file_name)
	{
		$sise = sise($file_name,120);
		$print_im .='<a href="index.php?action=input_im&id='.$id .'&input_im='.$num_mes.'&im='.$num.'"><img src="'.$file_name.'" '.$sise.'></a>';
	}
	$opisanie = $mess["name"]." - ".$mess["Prise"]."<br>".$mess["Mesaege"]."<br>".$mess["Time"];
	$mail_to ="";//"����� ������� ����� �������� ��� �������";
	$patt_array=array($print_im,$opisanie,$mail_to/*,$link*/);
	$data_atrray=array("{img}","{opisanie}","{mail_to}");
	print pattarn ($patt_array,$data_atrray,"htm/have.htm");
}

function del_message ($id,$mess,$del_im = true)// �������� ���������
{
	$data = mesage($id,$mess);

	if($data!=array())
	{
		if($del_im)//�������� ��������
		{
			foreach ($data[0][1] as $key => $file)
			{
				if(file_exists(getcwd()."/".$file))
				{
					unlink (getcwd()."/".$file);
				}
			}
		}
		unlink (getcwd()."/baraholca/USERS/$id/mes/$mess.".$data[1]);
		if ($data[1] == 'bag_mess')
		{
			print "<pre>";
			$last_mod_mes = file('baraholca\SORT\Last_mod.mes');
			$f = fopen('baraholca\SORT\Last_mod.mes','w+');
			foreach ($last_mod_mes as $num => $wey)
			{
				if($wey!="$id/$mess
")
				{
					fwrite($f,$wey);
				}
			}
			fclose($f);
		}
		else
		{
		//...........................................................�������� ������� �� ��������� ������ � ��������� 	������!!!
		}
		return $data;
	}
}

function profile ($id) // �������� ������ ������� //���������� ������
{
	if (!isset($_GET['profile']))
	{
		print '<a href="index.php?mod=Ed&Profile='.$id.'&profile">�������� �������</a>';
		print file_get_contents (getcwd()."/baraholca/USERS/$id/bonys.l");
	}
	else
	{
		if(!isset($_POST['submit_reveit']))
		{
			$data_id = unserialize (file_get_contents (getcwd()."/baraholca/USERS/$id/p.id"));
			include_once("htm/profile.php");
		}
		else
		{
			print_r ($_POST);
			new_data_id();
		}
	}
}

function edit ($id,$num_mes)// �������������� ���������
{
	$mesage = mesage($id,$num_mes);
	include_once ("htm/edit_mess.php");
}

function dell_image ($image_repl,$id,&$mes )
{
	foreach($image_repl as $nym_im => $file_name)
	{
			if(file_exists($file_name))
			{
				if ($file_name!="1.jpg")
		        {
					unlink($file_name);
				}
				$m_temp = $mes[1];
				foreach ($m_temp as $im_num => $file )
				{
					if ($file==$file_name)
					{
						unset ($mes[1][$im_num]);
					}
				}
			}
	}
}

FUNCTION add_image (&$mes)
{
$summ = 0;
$i=0;
$id = $mes[0]["id"];
$Image=array();
while ($i<= count ($_FILES['image']['name'])-1)
{
	foreach ($_FILES as $image => $chek)
		{
			if (isset ($chek['size'][$i]))
			{
				$summ += $chek['size'][$i];
			}
			if( $chek['type'][$i]=='image/jpeg')
			{
				if( $summ<=2097152)
				{
					if($chek['error'][$i]==0)
					{
						if(!file_exists(getcwd()."/baraholca/USERS/$id/img/".translit(basename ($chek["name"][$i]))))
						{
						
							if ( is_uploaded_file ( $chek['tmp_name'][$i] ))
							{
								$mess = last_mes($id);
								$nym_mess=(count($mess['mes'])+ count($mess['bag_mess']))+1;
								move_uploaded_file ($chek['tmp_name'][$i],getcwd()."/baraholca/USERS/$id/img/".translit(basename ($chek["name"][$i]) ) );// ������� �������� �������� ��������� � ������� ������������
								//���������� ���������� � ���� ���������� last_mod.mes
								$Image[]="baraholca/USERS/$id/img/".translit(basename ($chek["name"][$i]));
								$im=true;
							}
							else
							{
								print "<br>�������� ���������� �������� �� ����������� ���������<br>";
							}
						}
						else
						{
							print "<br>". $chek["name"][$i]." - � ������ ������������ ���� ��� ���������� ���������<br>";
						}
					}
					else
					{
					print "<br>��������� ������ �������� ����������� ��������� ���, ������ � ������ ����� ".$chek["name"][$i]."<br>";
					}
				}
			}
		}//foreach
		$i++;
	}
		foreach($Image as $key => $val)
		{
			$mes[1][$key]=$val;
		}
		if($mes[1]==array())
		{
			$mes[1][0]="1.jpg";
		}
	return $summ;
}

function replase_edit()
{
 	if (is_admin() && isset ($_POST["id"]))
 	{
		$id = $_POST["id"];
	}
	else
	{
		$id = $_COOKIE["baraholca"]["id"];
	}
	if (isset ($_POST['num_mes']) && chek_mess($_POST["text"]))
	{
		$mess=mesage($id,$_POST['num_mes']);
		$mes=$mess[0];
		if (isset($_POST['image_repl']))
		{
			$image_repl = $_POST['image_repl'];//�������� ������� ���������� �������
		}
		else
		{
			$image_repl=array();
		}
		//������� ������� �������� �� �������� mess[1] ��� ��������� �������� 
		
		foreach ($_FILES['image']["name"] as $key => $val)//������ ���������� ���������� ����� �������� �����������
		{
			if ($val!="" && isset ($mes[1][$key]))
			{
				$image_repl[]=$mes[1][$key];
			}
		}
		if(isset($image_repl) && $image_repl != array ())
		{
			
			while (array_search ("1.jpg",$image_repl))
			{
				unset($image_repl[array_search ("1.jpg",$image_repl)]);
			}
	    	dell_image ($image_repl,$id,$mes);//..������ ��� � ��������� ���� ������� �� ������ ��������� ��
		}
			$summ = add_image ($mes);	//..������ �������� �������� ����� �������� 
			$mes[0]=$_POST["text"];// ����� ���� �������� ������� �������� ����������
			$mes[0]["Time"]= date("F j, Y, g:i a");
			$nym_mess = $_POST['num_mes'];
			del_message ($id,$nym_mess,$del_im = FALSE);// �������� ���������
			$data = serialize($mes);
				$f = fopen(getcwd()."/baraholca/USERS/$id/mes/$nym_mess.bag_mess","w+");
				     fwrite ($f,$data);
				    fclose($f);
				$f = fopen (getcwd()."/baraholca/SORT/Last_mod.mes","w+");
				     fwrite ($f, "$id/$nym_mess"."
");
					 fclose($f);
				log_ini ("������ ������ �� ��������� � $nym_mess ������ ��������� - ".count($mes[1]).", ����� ��� ".( strlen ($mes[0]["name"].$mes[0]["Prise"].$mes[0]["Mesaege"])/1024+$summ/1024) ." ��");
				print "<br>���������� ������ �� ������������ ������� <a href=\"index.php\"> �� ������� </a>";
	}
	else
	{
			print "������������ �����!";
	}
}

function  add_message ($mess)// ���������� ���������
{
	$id = $_COOKIE["baraholca"]["id"];
	$summ=0;//���-�� ���� 
	$im=false;
	$mess["Time"]=date("F j, Y, g:i a");
	if(chek_mess($mess))
	{
		$Image=array();
		$i=0;
		foreach ($_FILES as $image => $chek)
		{
			$i++;
			$summ+=$chek['size'];
			if( $chek['type']=='image/jpeg')
			{
				if( $summ<=2097152)
				{
					if($chek['error']==0)
					{
						if(!file_exists(getcwd()."/baraholca/USERS/$id/img/".translit(basename ($chek["name"]))))
						{
						
							if ( is_uploaded_file ( $chek['tmp_name'] ))
							{
								$mes = last_mes($id);
								$nym_mess=(count($mes['mes'])+ count($mes['bag_mess']))+1;
								move_uploaded_file ($chek['tmp_name'],getcwd()."/baraholca/USERS/$id/img/".translit(basename ($chek["name"]) ) );// ������� �������� �������� ��������� � ������� ������������
								//���������� ���������� � ���� ���������� last_mod.mes
								$Image[]="baraholca/USERS/$id/img/".translit(basename ($chek["name"]));
								$im=true;
							}
							else
							{
								print "<br>�������� ���������� �������� �� ����������� ���������<br>";
							}
						}
						else
						{
							print "<br>". $chek["name"]." - � ������ ������������ ���� ��� ���������� ���������<br>";
						}
					}
					else
					{
					print "<br>��������� ������ �������� ����������� ��������� ���, ������ � ������ ����� ".$chek["name"]."<br>";
					}
				}
			}
		}//foreach
		if($im)
		{
			if(serch_mess($data = serialize(array($mess,$Image)),$id))
			{
				$f = fopen(getcwd()."/baraholca/USERS/$id/mes/$nym_mess.bag_mess","a+");
				     fwrite ($f,$data);
				    fclose($f);
				$f = fopen (getcwd()."/baraholca/SORT/Last_mod.mes","a+");
				     fwrite ($f, "$id/$nym_mess"."
");
					 fclose($f);
				log_ini ("������ ������ �� ��������� � $nym_mess ������ ��������� - ".count($Image).", ����� ��� ".( strlen ($mess["name"].$mess["Prise"].$mess["Mesaege"])/1024+$summ/1024) ." ��");
				print "<br>���������� ������ �� ������������ ������� <a href=\"index.php\"> �� ������� </a>";
			}
			else
			{
				print "<br>������ ��������� ��� ������������ � ������ ����� ���������<br>";
			}
		}
		else
		{
			print "<br>��������� �����������!<br>";
		}
	}
}

?>