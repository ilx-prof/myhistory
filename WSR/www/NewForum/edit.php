<?php
$tochno="no";
if (!empty($_COOKIE["Worldkr"])):
	$dogg=explode("||",$_COOKIE["Worldkr"]);
	$dogg[0]=strtolower($dogg[0]);
	$dogg[1]=strtolower($dogg[1]);
	if ($dogg[0]=='26}3l}3q}3q}3p}'){
		$file="reg/$dogg[0].txt";
		$fq=file($file);
		$v=explode("|",$fq[1]);
		$v[1]=strtolower($v[1]);
			if ($dogg[1]==$v[1]){
				$tochno="yes";
			}
			else
			{
				echo "У вас нет прав на редактирование или удаление сообщений";
				$tochno="no";
			}
	}
endif;

function del($file,$f){
	$fp=file($file);
	$fp=str_replace("\r","",$fp);
	$fp=str_replace("\n","",$fp);
	$d=sizeof($fp);
	$frw=fopen("$file","w+");
	flock ($frw, LOCK_EX);
	for ($a=0; $a<=$d; $a++):
		if (($a!=$f)&&($a<$d))
		{
			fputs($frw,$fp[$a]."\n");
		}
		if (($a!=$f)&&($a==$d)) fputs($frw,$fp[$a]);
	endfor;
	flock ($frw, LOCK_UN);
	fclose($frw);
}

//function edit(){}

$filename="messages/$door/$fi.txt";
if ((is_file($filename))&&($d=='del')&&($tochno=='yes')):
	del($filename,$i);
	echo "Сообщение удалено. <a href=\"index.php?show=$fi&door=$door\">Вернуться</a>";
endif;
?>