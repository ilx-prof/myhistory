<?
function all_my_message ($user_id,$revers  = true) // ���������� ��� ��� ��������� � ������������� /���������� ������ ��������� / �������� ��������� /�������������� ���������
{
		$dir = getcwd()."/baraholca/USERS/$user_id/mes/";
		print "������� ��� ��� ���������<pre>";
		$mes = last_mes($user_id);
		$return = "<table>";
		if ($revers)
		{
			$mes['mes'] = array_reverse($mes['mes']);
			$mes['bag_mess'] = array_reverse($mes['bag_mess']);
		}
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
			$way = str_replace ("med","min",$way);
			$sise = sise($way,120);
			
			$image .='<span tooltip="������ ��������"><a href="index.php?action=input_img&id='.$id .'&input_img='.$type[0].'"><img src="'.$way.'" '.$sise.'"></a><br>';
			BREAK;//...................����  �������� ������� ������ ���� �������� ������ ������ ������!
		}
		if ($type[1] == "bag_mess")
		{
			$status = "<H3>����������� ���������� ��������� � �������� ������������ � </H3>".$mess["Time"];
		}
		else
		{
			$status = "��������� ������������� ".$mess["Time"];
		}
		$cat = cat();
		$kat = $cat[1][array_search($mess["Category"],$cat[0])];//..����� �� ������������� ���� ������� �������� ��������� 
		$patt_array=array($image,"<br>���� - ".$mess["Prise"],
		"��������� ����� - ".$kat."<br>�������� ���� - ".$mess["name"],/*$mess["Mesaege"]*/"<br>".$status,$link);
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
		$file_name = str_replace ("med","min",$file_name);
		$sise = sise($file_name,120);
		$print_im .='<a href="index.php?action=input_im&id='.$id .'&input_im='.$num_mes.'&im='.$num.'"><img src="'.$file_name.'" '.$sise.'></a>';
	}
	$opisanie = "�������� ���� - ".$mess["name"].
				"<br>���� - ".$mess["Prise"].
				"<br>������������<br>".$mess["Mesaege"].
				"<br>����� ����������".$mess["Time"];
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
				if(file_exists(getcwd()."/".$file) && $file != "12345678900987y6t5r4e3w21wserahdblkjasfksjdnfkb.jpg")
				{
					unlink (getcwd()."/".$file);
					unlink (getcwd()."/".str_replace ("med","min",$file));
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
			$last_mod_mes = file($file = 'baraholca/SORT/Last.sort');
			$f = fopen($file,'w+');
			foreach ($last_mod_mes as $num => $wey)
			{
				if($wey!="$id/$mess
")
				{
					fwrite($f,$wey);
				}
			}
			fclose($f);
			$last_mod_mes = file($file = 'baraholca/SORT/'.$data[0][0]["Category"].'.kat');
			$f = fopen($file,'w+');
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
			new_data_id();
		}
	}
}

function edit ($id,$num_mes)// �������������� ���������
{
	$mesage = mesage($id,$num_mes);
	include_once ("htm/edit_mess.php");
}

function chek_im_file ($id)
{
	$i=0;
	$summ = 0;
	$Image = array();
	$error = array ();
	while ($i<= count ($_FILES['image']['name'])-1)
	{
		foreach ($_FILES as $image => $chek)
		{
			if (isset ($chek['size'][$i]) and $chek['size'][$i]!=0)
			{
				if( $chek['type'][$i]=='image/jpeg')
				{
					if($chek['error'][$i]==0)
					{
						if(!file_exists("baraholca/USERS/$id/img/".translit(basename ($chek["name"][$i]))))
						{
							if( ($summ += $chek['size'][$i])<=2097152)
							{
									$Image[$i]="baraholca/USERS/$id/img/".translit(basename ($chek["name"][$i]));
							}
							else
							{
								$error[$i]["�������� ������"]=
						"��������� ������ ����������� ������������ �� ��������� �������� ����  N $i - ".$chek["name"][$i];
							}
						}
						else
						{
							$error[$i]["�������� ����"] ="� ������ ����� N $i - ".$chek["name"][$i]." ���������� ���������";
						}
					}
					else
					{
						$error[$i]["�������� ������"] ="� �����������  N $i - ".$chek["name"][$i]." ����������� ������!";
					}
				}
				else
				{
					$error[$i]["�������� �������"] ="����������� � N $i - ".$chek["name"][$i]." ����� ������ �������� �� Jpeg !";
				}
			}
			else
			{
				if($chek["name"][$i]!="")
				{
					$error[$i]["�������� ������ �������"] ="����������� � N $i - ".$chek["name"][$i]." ����������� !";
				}
				else
				{
					$error[$i]["�������� ����� �����"] = "���� ��� �������� ����������� !";
				}
			}
		}
		$i++;
	}
	return array($Image,$error);
}

function chek_del_file ($id)
{
	$Delite = array();
	$error = array ();
	if (isset($_POST["image_repl"]))
	{
		foreach ($_POST["image_repl"] as $i => $file)
		{
			if($file!="12345678900987y6t5r4e3w21wserahdblkjasfksjdnfkb.jpg")
			{
				$file = "baraholca/USERS/$id/img/".$file;
				if(file_exists($file))
				{
						$Delite[$i]=$file;
				}
				else
				{
				$error[$i]["���������� �� ������������� �����"]="����������� � N $i - ".$file." ����������� !";			
				}
			}
			else
			{
			$error[$i]["���������� �� ������������� �����"]="����������� � N $i - ".$file." ����������� � �� �������� ��������";
				$Delite[$i]=$file;
			}
		}
	}
	return array($Delite,$error);
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
	if (isset ($_POST['num_mes']) && isset ($_POST["text"]))
	{
		if(chek_mess($_POST["text"]))
		{
			print "<pre>";
			$error = array ();
			$CF = chek_im_file ($id);//������ ������� ������� �������� ��������� � ������ � \� ������ ������� ������ ���������!
			$mess=mesage($id,$nym_mess = $_POST['num_mes']);
			$IM = $mess[0][1];
			$DF = chek_del_file ($id);//������ ������� ������� �������� ������� � ������ � \� ������ ������� ������ �������!
			foreach ($CF as $key => $f)
			{
				if (isset($mess[0][1][$key]))
				{
					print_r ($CF);
					print "����� ������� ���� ������� ������������! $key ".$mess[0][1][$key];
					$DF[0][]=$mess[0][1][$key];
				}
			}
			if($DF[0]!=array())
			{
				foreach($DF[0] as $key => $file )
				{
					if (file_exists($file) && $file!="12345678900987y6t5r4e3w21wserahdblkjasfksjdnfkb.jpg")
					{
						print "<br>��������� �������� ����� - ".$file;
						unlink($file);
						unset ($mess[0][1][array_search($file,$mess[0][1])]);
						unset ($DF[0][$key]);
					}
					else
					{
						print "<br>�������� ����� - ".$file." �� ���������!";
						unset ($mess[0][1][array_search($file,$mess[0][1])]);
						unset ($DF[0][$key]);
					}
				}
			}
			$CF = chek_im_file ($id);
//........................................������ � ��������� � ����� ��� �������!!!
			if($CF[0]!=array())
			{
				foreach($CF[0] as $I => $file)
				{
					$name = "baraholca/USERS/$id/img/".translit(basename ($_FILES["image"]["name"][$I]));
					if ( is_uploaded_file ($_FILES["image"]["tmp_name"][$I]) &&
						move_uploaded_file ($_FILES["image"]["tmp_name"][$I],$name)
					   )
					{
						$mess[0][1][$I] = $name;
					}
					ELSE
					{
						PRINT "����� �� ���������!";
					}
				}
			}
			$mes=$mess[0];
			$mes[0]=$_POST["text"];
			$mes[0]["Time"]= date("F j, Y, g:i a");
			if ($mes[1] != array())
			{
				$tmp = array ();
				foreach ($mes[1] as $key => $val)
				{
					if(!in_array ($val,$tmp))
					{
						$tmp[]=$val;
					}
				}
				$mes[1]=$tmp;
			}
			else
			{
				Print "������ �������� �� ������ ���� ������!";
				PRINT_R ($mes[1]);
				$mes[1][]="12345678900987y6t5r4e3w21wserahdblkjasfksjdnfkb.jpg";
			}
			del_message ($id,$_POST['num_mes'],$del_im = FALSE);// �������� ��������� ��� �������� ��������!
			$data = serialize($mes);
			$f = fopen("baraholca/USERS/$id/mes/$nym_mess.bag_mess","w+");
			     fwrite ($f,$data);
			     fclose($f);
			$f = fopen ("baraholca/SORT/Last_mod.mes","w+");
				 fwrite ($f, "$id/$nym_mess"."
");
				 fclose($f);
			$error["������� �������� ����������� ������"]=$CF[1];
			$error["������� �������� ��������� ������"]=$DF[1];
			PRINT_R (array(
							"���� � ��������� �����"=>$mes[1],
							"���� � ��������� ��"=>$IM,
							"�������� ����������� �������� ������!"=>$DF[0],
							"�������� �������� �� �������������!"=>$CF[0],"���������"=>$mess,$error,
							"����"=>$_POST,
							"�����"=>$_FILES));
			//header ("Location: index.php?mod=Ed&edit[$id]=$nym_mess");
		}
	}
	else
	{
		header ("Location: index.php?mod=Ed&edit&My_Anonce=$id");
	}
//				log_ini ("������ ������ �� ��������� � $nym_mess ������ ��������� - ".count($mes[1]).", ����� ��� ".( strlen ($mes[0]["name"].$mes[0]["Prise"].$mes[0]["Mesaege"])/1024+$summ/1024) ." ��");
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
		$i=-1;
		foreach ($_FILES as $image => $chek)
		{
			$i++;
			if($chek['error']==0)
			{
				if( $chek['type']=='image/jpeg')
				{

					$mes = last_mes($id);
					$nym_mess=(count($mes['mes'])+count($mes['bag_mess']))+1;
					$TMP = getcwd()."/baraholca/USERS/$id/img/temp.jpg";
					if (is_uploaded_file ( $chek['tmp_name']) && move_uploaded_file ($chek['tmp_name'],$TMP))
					{
						 // ������� �������� �������� ��������� � ������� ������������
						//..������ ������ �������� 
						//.. ���� ������ ������� ������ ���������� �� ����������� ! 
						// ���� ������ ��������� �� �������� ������ ������� � ������� �������� �������� ������ ! ��� ������ ��� ������
						//  ���� ������ ������� �� ������� ������� �������� 800x600 ��� �� ������� ������ �� ���� ���������� !
						if($summ + $chek['size']<=2097152 )
						//����� 2048 ��������� ��������� ���� ��� ���������� ������ �������� � ������������� ����
						{
							IF (creat_img_summ($id,$chek['name']))
							{
								$NAME = "baraholca/USERS/$id/img/"."med_".$nym_mess."_".$i.".jpg";
								rename ("baraholca/USERS/$id/img/med.jpg",$NAME);
								rename ("baraholca/USERS/$id/img/min.jpg", str_replace ("med","min",$NAME));
								$summ+=$chek['size'];
								$Image[$i]=$NAME;
								$im=true;
							}
							ELSE
							{
								print "<br>����������� ".$chek['name']." ������� ������� ��� �������� ������";
							}
						}
						else
						{
								print "<br>����������� ".$chek['name']." ��������� ���� ������ �������� � ��������� 2097152 byte";
						}
							//���������� ���������� � ���� ���������� last_mod.mes
					}
					else
					{
						print "<br>�������� ���������� �������� �� ����������� ���������<br>";
					}
				}
				else
				{
					if ($chek['name']!="")
					{
						print "<br>������������ ������ ����������� � ".$chek['name']."-".$chek['type']."<br>";
					}
				}

			}
        		else
			{
				if($chek['error']<=3)
				{
					print "<br>��� �������� ����������� ".$chek['name']." ��������� ������ ���� �� ��������<br>";
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
		print "<br>��������� �� ���������! ����������� �������� ��������� � ����������! <br>";
	}
}

?>