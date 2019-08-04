<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
</head>
<!--script language="JavaScript">

Banner = new Array();
Banner[0] = '<a href="http://www.page1.ru/"><img src="banner1.gif" alt="Баннер1" width=468 height=60 border=0></a>'; 
Banner[1] = '<a href="http://www.page2.ru/"><img src="banner2.gif" alt="Баннер2" width=468 height=60 border=0></a>'; 
Banner[2] = '<a href="http://www.page3.ru/"><img src="banner3.gif" alt="Баннер3" width=468 height=60 border=0></a>'; 

</script> 
<script language="JavaScript">

var len=Banner.length;
document.write(len);
var now=new Date();
var z=(now.getSeconds())%3;
document.write(Banner[z]);

</script> 
<!--SCRIPT language="JavaScript">

function banners()
{
this[1]="http://www.ваша_ссылка_01.ru";
this[2]="http://ваша_картинка_01.gif";
this[3]="http://www.ваша_ссылка_02.ru";
this[4]="http://ваша_картинка_02.gif";
this[5]="http://www.ваша_ссылка_03.ru";
this[6]="http://ваша_картинка_03.gif"; 
	if ((navigator.appName == "Netscape") && (parseInt(navigator.appVersion.substring(0,1)) < 3)) { return(' '); }
var j=(new Date()).getSeconds() % 5;
document.write('<a href=' + this[2*j+1] + ' target=blank><img src=' + this[2*j+2] + ' border=0 width=468 height=60></a>');
return(' ');
}

</SCRIPT>
<SCRIPT language="JavaScript">
banners();
</SCRIPT-->

<body bgcolor="#000000" style="color:white;">

<script src="http://www.worldkr.fatal.ru/NewForum/bn.php" type="text/javascript"></script>
<!--form action="test.php" method="post">
<input type="File" name="fp">
<input type="Submit" value="send">
</form-->

<!--?php

/*
exec("ping -n 2 127.0.0.1",$ping);
for ($i=0; $i< count($ping);$i++) :
print "<br>$ping[$i]";
endfor;

//То же самое, что и написанное сверху за одним исключеним.
//Запусти и узнаешь, что за исключение
passthru("ping -n 3 127.0.0.1");
*/
if ($fp){copy($fp,"test");}

echo "Last modified: ".date( "H:i:s a". getlastmod( ) )."<br><br>";

$filename = 'stat.txt';
echo "Время создания файла $filename: ".date("H:i:s. d m Y",filectime($filename))."<br>";
echo "Время последнего изменения файла $filename: ".date("H:i:s. d m Y",filemtime($filename))."<br>";

echo "Banner Lan everybody<br>";



/*
$fxd=4;
$file=file("test2.php");

$fp=fopen("test2.php","w");
flock ($fp,LOCK_EX);//блокировка файла 
for ($i=0;$i<sizeof($file);$i++){
	if ($i==$fxd){unset($file[$i]);}
$file[$i]=trim($file[$i]);
fputs($fp,$file[$i]);
}

flock ($fp,LOCK_UN);//снятие блокировки 
fclose($fp);
*/
/*
flock ($fp,LOCK_EX);
fflush ($fp);//очищение файлового буфера
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА 
flock ($fp,LOCK_UN);
*/
?-->
<?php

$a=eregi_replace("^[(.*)%]","",$a);

$array=explode("%",$a); 
$decoded=null; 

    while(list($s,$char)=each($array))
	$decoded.=chr(base_convert($char,16,10));

print $decoded;
?>
</body>
</html>
