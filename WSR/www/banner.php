<head>
<link rel="STYLESHEET" type="text/css" href="style.css">
</head>
<body style="background-color:#b6b6b6; margin:0px; position:absolute; left:0px; top:0px;">
<?php
function reg(){
print "
	<form action=\"\" method=\"post\">
	<input type=\"Text\" name=\"str\"> URL сайта(пример:www.worldkr.fatal.ru)<br>
	<input type=\"Text\" name=\"mail\"> E-mail<br>
	<input type=\"Hidden\" name=\"reg\" value=\"reg\">
	<input type=\"Password\" name=\"pass\"> Пароль<br>
	<input type=\"Submit\" value=\"Зарегистрировать свой сайт\">
	</form>
	";
}
function vhod(){
print "
	<form action=\"\" method=\"post\">
	<input type=\"Hidden\" name=\"vhod\" value=\"vhod\">
	<input type=\"Hidden\" name=\"reg\" value=\"reg\">
	<input type=\"Text\" name=\"site\"> Login (url)<br>
	<input type=\"Password\" name=\"pass\"> Password<br>
	<input type=\"Submit\" value=\"ВХОД на Аккаунт\">
	</form>
";
}

if (empty($reg)) reg();
if (empty($vhod)) vhod();

function add(){
	global $str;
	$dir=opendir("banners");
	$a=0; $b=0;
	while (($f=readdir($dir))!=FALSE):
		if (($f!='.')or($f!='..')):
			$site[$b]=$f;
			$b++;
		endif;
	endwhile;
	for ($i=0; $i<$b; $i++):
		if ($str==$site[$i]){
			return 1;
			$a=1;
			break;
		}
	endfor;
	if ($a!=1) return 0;
}

function make($a){
	global $str, $pass, $mail;
	if ((isset($a))&&($a==1)):
		print "Извините, но этот сайт уже учавствует в баннерной системе";
	endif;
	if ((isset($a))&&($a==0)):
		mkdir("banners/".$str,0777);
		mkdir("banners/".$str."/468x60",0777);
		mkdir("banners/".$str."/text",0777);
		mkdir("banners/".$str."/468x60/img",0777);
		mkdir("banners/".$str."/468x60/alt",0777);
		$fp=fopen("banners/".$str."/reg.txt","w+");
		$data=$pass."|@|".$mail;
		fputs($fp,$data);
		fclose($fp);
		print "Ваш аккаунт успешно зарегистрирован";
	endif;
}

if ((!empty($str))&&(!empty($mail))&&(!empty($pass))){
	$str=eregi_replace("^((.*)w{1,3}\.)","",$str);
	$str=eregi_replace("/{1,}(.*)$","",$str);
		if (eregi("\\.",$str))
		make(add());
}

function check(){
	global $site, $pass;
	if (is_dir("banners/".$site)):
		$fp=file("banners/".$site."/reg.txt");
		list($pas,)=explode("|@|",$fp[0]);
		if ($pas==$pass) return 1;
		else return 0;
	endif;
}

function statis(){
	global $add_fil, $add_url, $add_alt, $site;
	$dir=opendir("banners/".$site."/468x60/img");
	$b=0;
	while (($f=readdir($dir))!=FALSE):
		if ((eregi("\.jpg$",$f))or(eregi("\.gif$",$f))):
			$ban[$b]=$f;
			$b++;
		endif;
	endwhile;
	function addban($f){
		global $add_fil, $add_url, $add_alt, $site;
		$s=basename($add_fil);
		if (eregi("\.gif$",$s)) $a=".gif";
		if (eregi("\.jpg$",$s)) $a=".jpg";
		copy($add_fil,"banners/".$site."/468x60/img/".$f.$a);
		$fp=fopen("banners/".$site."/468x60/".$f.".txt","w+");
		fputs($fp,$add_url);
		fclose($fp);
		$fp=fopen("banners/".$site."/468x60/alt/".$f.".alt","w+");
		fputs($fp,$add_alt);
		fclose($fp);
	}
	if ((!empty($add_fil))&&(!empty($add_alt))&&(!empty($add_url))&&(!empty($site)))
	addban($b+1);
	
	function shaddban(){
		global $site, $pass;
		print "
			<tr>
			<form action=\"\" method=\"post\">
				<td align=\"center\" class=\"butt2\"><input type=\"Text\" name=\"add_url\" size=\"30\"></td>
				<td align=\"center\" class=\"butt2\"><input type=\"Text\" name=\"add_alt\" size=\"70\"></td>
				<td align=\"center\" class=\"butt2\"><input type=\"File\" name=\"add_fil\" size=\"30\"></td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"butt2\">
				<input type=\"Submit\" value=\"Добавить\">
				<input type=\"Hidden\" name=\"site\" value=\"".$site."\">
				<input type=\"Hidden\" name=\"vhod\" value=\"vhod\">
				<input type=\"Hidden\" name=\"reg\" value=\"reg\">
				<input type=\"Hidden\" name=\"pass\" value=\"".$pass."\">
				</td>
			</form>
			</tr>
			";
	}
	print "<table cellpadding=\"3\" cellspacing=\"0\" class=\"but2\" style=\"width:1\" align=\"center\">";
	print "
	<tr>
		<td class=\"butt2\"><b>Показов</b></td>
		<td class=\"butt2\"><b>Баннер</b></td>
		<td class=\"butt2\"><b>Ссылка</b></td>
	</tr>";
	for ($i=0; $i<$b; $i++):
		print "\n<tr>\n\t";
		$c=str_replace(".gif",".txt",$ban[$i]);
		$c=str_replace(".jpg",".txt",$c);
		$fp=@file("banners/".$site."/468x60/dat/".$c);
		print "<td align=\"center\" valign=\"middle\" class=\"butt\">".$fp[0]."</td>\n\t";
		$a=str_replace(".gif",".alt",$ban[$i]);
		$a=str_replace(".jpg",".alt",$a);
		$fp=@file("banners/".$site."/468x60/alt/".$a);
		print "<td width=\"468\" height=\"60\" class=\"butt2\"><img src=\"banners/".$site."/468x60/img/".$ban[$i]."\" alt=\"".$fp[0]."\" width=\"468\" height=\"60\"></td>\n\t";
		$f=str_replace(".gif",".txt",$ban[$i]);
		$f=str_replace(".jpg",".txt",$f);
		$fp=@file("banners/".$site."/468x60/".$f);
		print "<td width=\"300\" class=\"butt\">".$fp[0]."</td>\n";
		print "</tr>\n";
	endfor;
	print "
	<tr>
		<td colspan=\"3\" class=\"butt2\"><b class=\"porh2\"><br>Добавление нового баннера</b></td>
	</tr>
	<tr>
		<td class=\"butt2\">Ссылка (при клике...)</td>
		<td class=\"butt2\">Подпись при наведении на баннер</td>
		<td class=\"butt2\">Сам баннер(*.JPG или *.GIF)</td>
	</tr>";
	shaddban();
	print "</table>";
}

if ((!empty($site))&&(!empty($pass))){
	$site=eregi_replace("^((.*)w{1,3}\.)","",$site);
	$site=eregi_replace("/{1,}(.*)$","",$site);
		if (eregi("\\.",$site)){
			if (check()==1) statis();
		}
		else {print "Голимый пароль или имя сайта";}
}
print "<div align=\"center\" style=\"background-color:#737173;\"><br><a href=\"banner.php\" style=\"font-size:15px; letter-spacing:3px;\">Вернуться на главную</a><br><br></div>";


?>
</body>