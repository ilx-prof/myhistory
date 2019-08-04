<?php
## /* Вывод ответов на экран */ ##
//Значения $from и $to есть в файле index.php, в который собственно этот файл и вкладывается.
for ($no=$from; $no<$to; $no++){
if ($fp[$no]!="\r\n"):
	list($dateM, $nickM, $mailM, $mesM, $rasM)=explode("|Fuz|",$fp[$no]);
//if ((!empty($nickM))&&(!empty($dateM))):
if (!empty($rasM)){
	if (ereg("gaal",$rasM)){$rasM="<img src='G.gif' width='66' height='34' alt='' border='0'>";}
	if (ereg("fei",$rasM)){$rasM="<img src='F.gif' width='66' height='34' alt='' border='0'>";}
	if (ereg("human",$rasM)){$rasM="<img src='H.gif' width='66' height='34' alt='' border='0'>";}
	if (ereg("malok",$rasM)){$rasM="<img src='M.gif' width='66' height='34' alt='' border='0'>";}
	if (ereg("peleng",$rasM)){$rasM="<img src='P.gif' width='66' height='34' alt='' border='0'>";}
}
	if (!ereg("<img",$rasM)){$rasM="ПИРАТ";}

if (!eregi("^([0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-wyz][a-z](fo|g|l|m|mes|o|op|pa|ro|seum|t|u|v|z)?)$", $mailM))
			{$mailM="Нет электронки";}
			else
			{$mailM="<a href=\"mailto:".$mailM."\" style=\"cursor:hand;\">".$mailM."</a>";}

	#мини скриптец для определения подписи у того кто ответил:
	$size=StrLen($nickM);
	$encoded_nick=null;
	for($i=0;$i<$size;$i++) $encoded_nick.=base_convert(ord($nickM[$i]),10,32).chr(125);

	$name=strtolower($encoded_nick);
	$filename="reg/$name.txt";
	if (is_file($filename)){
		$cf=file($filename);
		$s6=explode("|",$cf[6]);//Подпись
		$podpM="<br><br><hr align=\"left\" width=\"300\"><em style=\"font-size:11px;\">".$s6[1]."</em>";
	}
	else {$podpM='';}

//Вывод сообщений (все тоже самое, что и у темы)
if ($admin=='26}3l}3q}3q}3p}')
echo "<a href=\"edit.php?i=$no&d=del&door=$door&fi=$show\" style=\"cursor:hand;\">Удалить</a><b style=\"color:white;\"> ----- </b><a href=\"edit.php?i=$i&d=edit&door=$door&fi=$show\">Редактировать</a>";
echo ("
<table align=\"center\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"filter: alpha(opacity=85);\">
<tr>
    <td><img src=\"lvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	<td width=\"100%\" background=\"bgF.gif\" align=\"center\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
    <td><img src=\"pvF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
</tr>
<tr>
    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
    <td background=\"bgF.gif\">
	<table border=\"0\" width=\"100%\" height=\"100%\" cellpadding=\"10\">
		<tr>
			<td width=\"167\" valign=\"top\" align=\"center\"><a href=\"user.php?user=".$nickM."\" style=\"cursor:hand;\"><div class=\"text\">".$nickM."</div><div class=\"shadow\" UNSELECTABLE=\"on\">".$nickM."</div></a>".$rasM."<br>".$mailM."<br><b class=\"small\">".$dateM."</b></td>
			<td class=\"Otvet\">".$mesM.$podpM."</td>
		</tr> 
	</table>
	</td>
    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
</tr>
");
if (($no==$to-1)&&($to>=11)){
	echo ("<tr>
	    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\" align=\"center\" colspan=\"2\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
	</tr>
	</table>");
}else{echo ("
<tr>
    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
    <td background=\"bgF.gif\" align=\"center\"><img src=\"ne.gif\" width=\"10\" border=\"0\"></td>
    <td><img src=\"pnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
</tr>
</table>");
}

if ($no==$to-1){
	if ($to>=11){

	if ($kol<=11){$kolvo=$kol;}else{$kolvo=11;$pages=floor(($kol-1)/10);}

if (!isset($f)){$f=1; $from=1; $to=$kolvo;} else {$from=($f*10)-9; if (($f*10)>($kol-1)){$to=$kol;}else{$to=($f*10)+1;}}

if (($kol-1)<=10){}else{
echo ("
	<table align=\"right\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"filter: alpha(opacity=85);\">
	<tr>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\"><em class=\"fuz\">Cтраницы: ");
for ($a=1; $a<=$pages; $a++){
if ($a==$f){$stul="style=\"color:Red;\"";}else{$stul='';}
echo ("\n<a href=\"?show=".$show."&door=$door&&f=".$a."\" $stul style=\"cursor:hand;\">=".$a."=</a>&nbsp;&nbsp;");
}
$os='';
if (($kol-($pages*10)-1>0)&&($kol-($pages*10)-1<10)){if($f==$pages+1){$stul="style=\"color:Red;\"";
	}else{
$stul='';}$dok=$pages+1;$os="\n<a href=\"?show=".$show."&door=$door&&f=".$dok."\" $stul style=\"cursor:hand;\">=".$dok."=</a>";}
echo "$os";
echo ("</em></td>
	<td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	<tr>
	    <td><img src=\"lnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td background=\"bgF.gif\"><img src=\"ne.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	    <td><img src=\"pnF.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
	</tr>
	</table><br><br><br>
");}}}else{echo ("<br>");}
endif;
}
//"Всё гениальное - просто"
?>