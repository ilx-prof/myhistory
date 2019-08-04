<?

function del_cookie()
{
	setcookie ("baraholca[login]", "", time() - 3600);
	setcookie ("baraholca[Password]", "", time() - 3600);
	setcookie ("baraholca[id]", "", time() - 3600);
}

function add_new ($id)
{
	$user_data = $_POST["user_data"];
	$user_data['Password']=	md5 ($user_data['Password']);
	$user_data['Password0']=md5 ($user_data['Password0']);
	if (
		mkdir("baraholca/USERS/".$id,0700) &&
		mkdir("baraholca/USERS/".$id."/img",0700) &&
		mkdir("baraholca/USERS/".$id."/mes",0700) &&
		fwrite ($f = fopen("baraholca/USERS/".$id."/p.id","a"), serialize($user_data))
		)
		{
			fclose ($f);
			setcookie ("baraholca[login]", md5($_POST["user_data"]['Password'])); //..здесь фунския шифрации пароля
			setcookie ("baraholca[Password]" , $_POST["user_data"]['Login'] ); //..здесь фунския шифрации логина причем именно наоборот =)
			setcookie ("baraholca[id]" , $id   ); //..здесь фунския шифрации id
			$_COOKIE["baraholca"]["id"]=$id;
			$_COOKIE["baraholca"]["Password"]=$_POST["user_data"]['Login'];
			$_COOKIE["baraholca"]["login"]=md5($_POST["user_data"]['Password']);

			fwrite ($f = fopen("baraholca/USERS/".$id."/bonys.l","a+"),"");
			fclose ($f);
			fwrite ($f = fopen("baraholca/SORT/Last_mod.us","a+"),$id."
");
			fclose ($f);
			log_ini ("Регистрация пользователя");
			return true;
		}
		else
		{
			return false;
		}
}

?>