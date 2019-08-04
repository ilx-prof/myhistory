<?
include_once ("functions.php");

function print_all_bag_mess()
{
	$bag_mess = file('baraholca/SORT/Last_mod.mes');
	if ($bag_mess!=array())
	{
		print "<table>";
		foreach ($bag_mess as $key => $mes)
		{
			$I = explode ('/',$mes);
			$link = '<a href="index.php?mod=ad&action=public&us='.$I[0].'&mes='.$I[1].'">Опубликовать сообщение</a>|
					|<a href="index.php?mod=ad&action=del_mes&us='.$I[0].'&mes='.$I[1].'">Удалить</a>';
					/////////А так же
					//|<a href="adminca.php ? action=Пользователь& us='.$I[0].'">Все сообщения пользователя</a>
					// <a href="adminca.php ? action=Редактировать&us='.$I[0].'&mes='.$I[1].'">Редактировать</a>
			print "<tr><td>".return_mes("baraholca/USERS/".$I[0]."/mes/".trim($I[1]).".bag_mess",$link)."</td></tr>";
		}
		print "</table>";
	}
	else
	{
		print "новые сообщениея отсутствуют";
	}
}
function print_all_bag_use()
{
	return "Вывести последних зарегистрировавшихся пользователей<pre>";
}

function replay_last_list ($string,$last = 15)
{
	$string .="
";
	$last_mes = file("baraholca/SORT/Last.sort");
	array_unshift ($last_mes,$string);
	if(count($last_mes)>$last)
	{
		for($i=$last;$i<=count($last_mes);$i++)
		{
			unset($last_mes[$i]);
		}
	}
	$f = fopen("baraholca/SORT/Last.sort","w+");
	foreach($last_mes as $key => $mes)
	{
		fwrite ($f,$mes);
	}
	fclose($f);
}

function public_message($id,$mes )
{
	if (
			file_exists(($name = "baraholca/USERS/".$id."/mes/".trim($mes)).".bag_mess")
		)
	{
		copy  ($name.".bag_mess",$name.".mes");
		$data = del_message ($id,$mes,false);
		if ($data != array())
		{
				$kat = $data[0][0]['Category'];
				$f = fopen("baraholca/SORT/".$kat.".kat","a+");
				fwrite ($f,"$id/$mes
");
				fclose($f);
				replay_last_list ("$id/$mes");
		}
	}
}

function cat_edit()
{
	$cat = cat();
	if ( $_POST == array())
	{
		print "вывести форму с категориями и деиствиям к ним";
		include_once ("htm/kat.php");
		
	}
	else
	{	
		print "<pre>";
		if(isset($_POST['Category']) and in_array($_POST['Category'],$cat[0]))
		{
			if($_POST['Action'])
			{
				switch ($_POST['Action'])
				{
					case "Moder": print "<br>Вывести категорию  снужными ссылками !";
								print pattern_all ('baraholca/SORT/'.$_POST['Category'].'.kat',true,"moder");
					 break;
					case "ban":  print "<br>Удалить из файла категорий данную запись без удаления сообщений и ее самой!"; break;
					case "fatal_del": print "<br>удаление всей категории в месте с сообщениями !"; break;
					 break;
					default : include_once ("htm/kat.php");
				}
				if (isset($_POST['new_cat']) && $_POST['new_cat']!="")
				{
					print "<br>Добавить категорию!";
				}
			}
		}
		else
		{
			print "Неправильная форма !";
		}
	}
}


function adm()
{
	if(is_admin ())
	{
		$return = "";
		switch ($_GET['action'])
		{
			case "new_mes" : $return = print_all_bag_mess(); break;
			case "cat" : $return = cat_edit(); break;
			case "new_us" :$return = print_all_bag_use(); break;
			case "del_us" : $return = del_use(); break;

			case "public" : 
								if(isset($_GET['us']) && $_GET['us']>=0 && isset($_GET['mes']) && $_GET['mes']>=1)
								{
									$return = public_message($_GET['us'],$_GET['mes'] );
			 						header("Location: index.php?mod=ad&us=adm&action=new_mes");
									 break;
								}
			case "del_mes" : 	if(isset($_GET['us']) && $_GET['us']>=0 && isset($_GET['mes']) && $_GET['mes']>=1)
								{
									del_message ($_GET['us'],$_GET['mes']);
									header("Location: index.php?mod=ad&us=adm&action=new_mes");
									break;
								}
			case "user" : if(isset($_GET['us']) && $_GET['us']>=0)
								  {
										//$return = print_all_bag_use(); break;
								  }
			case "edit_mes" :
									if(isset($_GET['us']) && $_GET['us']>=0)
									{
										// $return = edit(); break;
									}
				print "неверный запрос!";
				print_r ($_GET);
		}

		return $return ;
	}
	else
	{
		print "Хренос два<pre>";
		print_r($_COOKIE);
	}
}

ob_start ();
print adm();//проверка правильности запроса
$data = ob_get_clean ( );
$patt_array=array("Новые поступления",pattern_all(),navigation_meny(),$data);
include_once ("all.php");


?>