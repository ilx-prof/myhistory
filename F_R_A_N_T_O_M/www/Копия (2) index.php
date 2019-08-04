<pre>
<?php
set_time_limit(0);
$dir="z:";
$a=0;
$disc_nime_check=array("b:","c:","d:","e:","f:","g:","h:","i:","j:","k:","l:","m:","n:","o:","p:","q:","r:","s:","t:","u:","v:","w:","x:","y:","z:");
function copy_files ($disc_nime_check)
{
GLOBAL $DISC_CECED;
		if (file_exists($disc_nime_check))
		{
			$DISC_CECED[]=$disc_nime_check;
		}
}
function vhod_prosmotr ($dir,$a)
{
$r=0;
if (is_dir($dir))
{
@$a++;
print "Это директория - |$dir| \n";
creit_obras($dir,"d");
    if ($dh = opendir($dir))
	 {
		// print "<br>Открытый дескриптор $dh \n";
     	   while (false !== ($file = readdir($dh))) 
		   {
				if ($file != "." && $file != ".." && $file!=get_current_user ())
				{
						if (!is_dir($dir."/".$file))
						{
							print $file.": тип |Файл|\n";
							creit_obras($dir."/".$file,"f");
						}
						else
						{
					//		print $dh."<br> &nbsp;&nbsp;";
					//		print " - был $dh - стал \n		";
							vhod_prosmotr($dir."/".$file,$a);
							print"<H1>этот путь приведет к ошибке скрипта </H1>";
						}
				}/*else{print"<H1>".$file." - этот путь приведет к ошибке скрипта</H1>";}*///это просто проверка
			}
		
    }
	closedir($dh);
}
}
FUNCTION creit_obras($Wey,$f_d)
{
if($f_d == "d")
{
			mkdir (/*getcwd()."/".*/get_current_user ()."/".str_replace (":","",$Wey), 0700);
}
if($f_d == "f")
{
			$W=fopen (/*getcwd()."/".*/get_current_user ()."/".str_replace (":","",$Wey),"w+");
			fwrite($W,filesize($Wey));//здесь  происходит выбор между вызовом многих информационных данных между единичным вызовом и вызовом целого массива т.к. переменная очень горячаяя то вызов массива будет сильно тормозить но всеже там есть коекакая полезная инфра и всеже пока единичный метод а не stat ($Wey)
			fclose($W);
}
}
print "Владелец скрипта - ".get_current_user ()."<BR>";
IF(!iS_DIR (get_current_user ()))
{
mkdir(get_current_user (),0700);
/*creit_obras("C:/","d");
creit_obras("C:/report.zip","f");*/
array_walk($disc_nime_check,"copy_files");
//PRINT_R ($DISC_CECED);
array_walk($DISC_CECED,"vhod_prosmotr"); //!!!!!!!!!!!!!!!!!
//vhod_prosmotr("F:\\",0);
}
ELSE
{
	PRINT "Лучше удали  УДАЛИ СТАРУЮ ДИРЕКТОРИЮ - ".get_current_user ()."<BR>ОНА НАХОДИТЬСЯ ПО АДРЕСУ - ".getcwd()."\\".get_current_user ();
	@mkdir(get_current_user (),0700);
	/*creit_obras("C:/","d");
	creit_obras("C:/report.zip","f");*/
	@array_walk($disc_nime_check,"copy_files");
	//PRINT_R ($DISC_CECED);
	@array_walk($DISC_CECED,"vhod_prosmotr"); //!!!!!!!!!!!!!!!!!
	//@vhod_prosmotr("f:\\",0);
}
?>
</pre>
