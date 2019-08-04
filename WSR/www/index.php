<!--ul>
	<li>Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.</li>
	<li>реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты</li>
	<li>СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум</li>
	<li>Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo</li>
</ul-->
<?php
$fileName="stat.txt";
include("NewForum/sniffer.php");

function ratepage($page){
	$fp=file("rating.txt");
	$fp=str_replace("\n","",$fp);
	$fp=str_replace("\r","",$fp);
	$b=sizeof($fp);
	$fr=fopen("rating.txt","w+");
	$c=0;
	for ($i=0; $i<=$b; $i++):
	@list($name, $skok)=explode("|",$fp[$i]);
		$a=0;
		if (($name==$page)&&($c==0)){
			if ($page!='sh=news') $skok=$skok+1;
			$a=1;
			$c=1;
			fputs($fr, $name."|".$skok."\n");
		}
		if (($c!=1)&&($a==0)&&($i==$b)) {if ($page!='sh=news') fputs($fr,$page."|1"); $a=1; break;}
		if (($a==0)&&($i!=$b)){fputs($fr, $fp[$i]."\n");}
	endfor;
	fclose($fr);
}

if(!empty($show)){
	$file=$show;
	$fp=@file($file);
	$col=sizeof($fp);
	$title=str_replace("<h1>","",$fp[0]);
	$title=str_replace("</h1>","",$title);
	ratepage($show);
}else{
	if(empty($sh)) $sh="news";
		switch($sh){
			 case "okr"; $title="Скриншоты (Космические Рейнджеры)"; break;
			 case "okr2"; $title="Скриншоты (Космические Рейнджеры  2: Доминаторы)"; break;
			 case "opros"; $title="Голосование"; break;
			 case "okrfiles"; $title="Файлы (Космические Рейнджеры)"; break;
			 case "okr2files"; $title="Файлы (Космические Рейнджеры 2: Доминаторы)"; break;
			 case "search"; $title="Поиск"; break;
			 case "news"; $title="Главная(Новости)"; break;
		}
	ratepage("sh=".$sh);
}

function text($f,$to){
	for ($i=1; $i<=$to-1; $i++)
		print $f[$i];
}
?>
<html>
<head>
	<title>WSR ::: <?php print $title; ?> ::: Форум ::: Самый полный ресурс по серии игр Космические Рейнджеры</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=Windows-1251">
	<META NAME="page-topic" CONTENT="WSR ::: <?php print $title; ?> ::: Мир Космических Рейнджеров ::: Форум --- самый полный ресурс по серии игр Космические Рейнджеры"> 
	<META NAME="title" CONTENT="WSR ::: <?php print $title; ?> ::: Мир Космических Рейнджеров ::: Форум --- самый полный ресурс по серии игр Космические Рейнджеры">
	<META NAME="description" CONTENT="Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.">
	<META NAME="abstract" CONTENT="Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.">
	<META Name="keywords" Content="квесты, starforce, starforce 3, starforce 2, доминаторы, келлер, клисане, блазер, терон, космические рейнджеры 2, космические рейнджеры, рейнджеры, спутник, чит-коды, читы, космичкские доминаторы, рекорды, самая крутая игра, патчи, rangers, флуд, ария, сайт, музыка, mp3, скачать mp3, свч и мир кр, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка">
	<META NAME="revisit" CONTENT="1 day">
	<META NAME="revisit-after" CONTENT="1 days">
	<META NAME="Content-Language" CONTENT="english">
	<META NAME="audience" CONTENT="all">
	<META NAME="robots" CONTENT="all">
	<META NAME="Author" CONTENT="Denis Korneev, Copyright © 2004-2005 - vpah@mail.ru">
	<META NAME="Copyright" CONTENT="Copyright © WSR 2004-2005">
	<META NAME="Reply-to" CONTENT="vpah@mail.ru">
	<META NAME="home_url" CONTENT="http://www.worldkr.fatal.ru/index.php">
	<META NAME="Generator" CONTENT="Notepad!">
	<META NAME="distribution" CONTENT="Global"> 
	<META NAME="rating" CONTENT="General">
	<META NAME="site-created" CONTENT="1-01-2004">
	<link rel="Shortcut Icon" href="http://www.worldkr.fatal.ru/logo.ico">
	<link rel="STYLESHEET" type="text/css" href="style.css">
	<!-- saved from url=http://www.worldkr.fatal.ru -->
</head>
<?php
srand((double)microtime()*1000000);
$frm=mt_rand(1,8);
?>
<SCRIPT SRC="left.js" language="JavaScript1.2"></SCRIPT><SCRIPT SRC="leftItems.js" language="JavaScript1.2"></SCRIPT>
<SCRIPT SRC="right.js" language="JavaScript1.2"></SCRIPT><SCRIPT SRC="rightItems.js" language="JavaScript1.2"></SCRIPT>
<script language="JavaScript" type="text/javascript">
	status="WSR";
</script>
<script language = "JavaScript">
<!-- //
if (document.images){

img0on = new Image();
img0on.src ="images/leftbut-2-active.gif";
img0off = new Image();
img0off.src ="images/leftbut-2-passive.gif";

img1on = new Image();
img1on.src ="images/rightbut-2-active.gif";
img1off = new Image();
img1off.src ="images/rightbut-2-passive.gif";

imgfon = new Image();
imgfon.src ="images/forum<?php print "$frm-2-a"; ?>.gif";
imgfoff = new Image();
imgfoff.src ="images/forum<?php print "$frm-2"; ?>.gif";

imguon = new Image();
imguon.src = "images/time-2-a.gif";
imguoff = new Image();
imguoff.src = "images/time-2.gif";

} 

function imgon(NameI) {
	if (document.images) {
		document[NameI].src = eval(NameI + "on.src");
	} 
}
function imgoff(NameI) {
	if (document.images) {
		document[NameI].src = eval(NameI + "off.src");
	} 
} 
// -->
</script> 
<body>

<table cellpadding="0" cellspacing="0" border="0" width="950" style="background:url(/images/bg.gif);" align="center">
<tr>
	<td rowspan="100" class="bgperleft"><img src="images/ne.gif" width="25" alt="" border="0"></td>
	<td width="900" height="5"><img src="images/ne.gif" width="1" height="5" alt=""></td>
	<td rowspan="100" class="bgperight"><img src="images/ne.gif" width="25" alt="" border="0"></td>
</tr>
<tr>
	<td align="center" width="900">
		<table cellpadding="0" cellspacing="0" border="0" width="832">
		<tr>
			<td width="41" height="16"><img src="images/leftverxugl-2.gif" width="41" height="16" alt="" border="0"></td>
			<td class="verxbgper" width="100%" height="16"><img src="images/ne.gif" width="100%" height="16" alt="" border="0"></td>
			<td width="41" height="16"><img src="images/rightverxugl-2.gif" width="41" height="16" alt="" border="0"></td>
		</tr>
		</table>
		<table cellpadding="0" cellspacing="0" border="0" width="832">
		<tr>
			<td width="16" height="26"><img src="images/leftnc2per-2.gif" width="16" height="26" alt="" border="0"></td>
			<td width="800" height="26"><a href="http://<?php print $HTTP_HOST; ?>/" target="_parent"><img src="images/logoV.jpg" width="800" height="26" alt="Самый полный ресурс по серии игр Космические Рейнджеры" border="0"></a></td>
			<td width="16" height="26"><img src="images/rightnc2per-2.gif" width="16" height="26" alt="" border="0"></td>
		</tr>
		<tr>
			<td background="images/leftbgper.gif" width="16" height="100%"><img src="images/ne.gif" width="16" height="100%" alt="" border="0"></td>
			<td width="800" height="118"><a href="http://<?php print $HTTP_HOST; ?>" target="_parent"><img src="images/logoC.jpg" width="800" height="118" alt="Самый полный ресурс по серии игр Космические Рейнджеры" border="0"></a></td>
			<td background="images/rightbgper.gif" width="16" height="100%"><img src="images/ne.gif" width="16" height="100%" alt="" border="0"></td>
		</tr>
		<tr>
			<td width="16" height="26"><img src="images/leftncper-2.gif" width="16" height="26" alt="" border="0"></td>
			<td width="800" height="26" background="images/logoN.jpg" align="center"></td>
			<td width="16" height="26"><img src="images/rightncper-2.gif" width="16" height="26" alt="" border="0"></td>
		</tr>
		</table>
		<table cellpadding="0" cellspacing="0" border="0" width="832">
		<tr>
			<td width="41" height="16"><img src="images/leftnizugl-2.gif" width="41" height="16" alt="" border="0"></td>
			<td class="nizbgper" width="100%" height="16"><img src="images/ne.gif" width="100%" height="16" alt="" border="0"></td>
			<td width="41" height="16"><img src="images/rightnizugl-2.gif" width="41" height="16" alt="" border="0"></td>
		</tr>
		</table>
	</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="950" style="background:url(/images/bg.gif);" align="center">
<tr>
	<td rowspan="100" class="bgperleft"><img src="images/ne.gif" width="25" alt="" border="0"></td>
	<td width="900"></td>
	<td rowspan="100" class="bgperight"><img src="images/ne.gif" width="25" alt="" border="0"></td>
</tr>
<tr>
	<td valign="top" align="center" width="900">
		<table cellpadding="0" cellspacing="0" border="0" width="900" height="17" align="center">
		<tr valign="top" align="center">
			<td width="100%" height="17" align="center" valign="top"><img src="images/perverx.gif" width="164" height="17" alt="" border="0"></td>
		</tr>
		</table>
		<table cellpadding="0" cellspacing="0" border="0" width="900" height="26" align="center">
		<tr align="center" valign="top">
			<td width="55" align="left"><img src="images/ugll-2.gif" width="55" height="26" alt="" border="0"></td>
			<td width="135" class="bgpusk"><img src="images/ne.gif" width="100%" height="1" alt="" border="0"></td>
			<td width="160" align="right" class="bgpusk"><a href="?show=okr/about.html" onmouseover="imgon('img0'); return true;" onmouseout="imgoff('img0')"><img src="images/leftbut-2-passive.gif" width="160" height="26" alt="Информация о ПЕРВОЙ части Космических Рейнджеров" border="0" name="img0"></a></td>
			<td width="36" class="bgpusk"><img src="images/ne.gif" width="100%" height="1" alt="" border="0"></td>
			<td width="128" align="center" class="bgpusk"><a href="NewForum" target="_blank" onmouseover="imgon('imgf'); return true;" onmouseout="imgoff('imgf')"><img src="images/forum<?php print "$frm-2"; ?>.gif" width="128" height="26" alt="Общаться или не общаться? Вот в чём вопрос" border="0" name="imgf"></a></td>
			<td width="36" class="bgpusk"><img src="images/ne.gif" width="100%" height="1" alt="" border="0"></td>
			<td width="160" align="left" class="bgpusk"><a href="?show=okr2/about.html" onmouseover="imgon('img1'); return true;" onmouseout="imgoff('img1')"><img src="images/rightbut-2-passive.gif" width="160" height="26" alt="Информация о ВТОРОЙ части Космических Рейнджеров" border="0" name="img1"></a></td>
			<td width="135" class="bgpusk"><img src="images/ne.gif" width="100%" height="1" alt="" border="0"></td>
			<td width="55" align="right"><img src="images/uglr-2.gif" width="55" height="26" alt="" border="0"></td>
		</tr>
		<tr align="center" valign="top">
			<td colspan="3" width="350"></td>
			<td align="center" valign="top" width="200" colspan="3"><img src="images/perrrr.gif" width="164" height="17" alt="Если Вы ещё не поняли, то разъясняю: вся информация находится ниже" align="middle" border="0"></td>		
			<td colspan="3" width="350" align="center" valign="bottom">
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="950" align="center" style="background:url(/images/bg.gif);">
<tr>
	<td class="bgperleft"><img src="images/ne.gif" width="25" alt="" border="0"></td>
	<td width="30"><img src="images/ne.gif" width="30" alt="" border="0"></td>
	<td width="840" align="center">
		<table cellpadding="0" cellspacing="0" border="0" width="840" align="center">
		<tr>
			<td width="61" height="99" rowspan="2"><img src="images/left-verh-ugl-2.gif" width="61" height="99" alt=""></td>
			<td background="images/verh-bg.gif" width="718" height="39">
			<div align="center" style="position: relative; bottom:9px; left:219px; right:0px;">
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<form action="?sh=search" method="post" name="se">
					<td height="17" valign="middle">
						<input type="Text" name="stroka" class="searchtext" style="width:280px" onblur="if (value == ''){value = ' Введите строку для поиска и нажмите ENTER'};" onfocus="if (value == ' Введите строку для поиска и нажмите ENTER'){value =''};" onclick="this.focus(); value='';" value=" Введите строку для поиска и нажмите ENTER"><input type="submit" name="but" style="width:0px;" value="">
					</td>
					</form>
				</tr>
				</table></div>
			</td>
			<td width="61" height="99" rowspan="2"><img src="images/right-verh-ugl-2.gif" width="61" height="99" alt=""></td>
		</tr>
		<tr>
			<td width="100%" height="60" bgcolor="#b6b6b6">
			<?php if (!empty($show)) print $fp[0]; else
				switch($sh){
			 		case "okr2"; print "<h1>Скриншоты КР-2</h1>"; break;
					case "okr"; print "<h1>Скриншоты КР-1</h1>"; break;
					case "opros"; print "<h1>Голосование:</h1>"; break;
					case "okrfiles"; print "<h1>Файлы КР-1</h1>"; break;
					case "okr2files"; print "<h1>Файлы КР-2</h1>"; break;
					case "search"; print "<h1>Поиск</h1>"; break;
					default; print "<h1>Голосование:</h1>"; break;
					};?>
			</td>
		</tr>
		<tr>
			<td background="images/left-stor-bg2.gif" width="61" height="100%"><img src="images/ne.gif" width="1" height="100%" alt="" align="left"></td>
			<td width="718" height="100%" bgcolor="#b6b6b6" valign="top">
			<?php if (!empty($show)){text($fp,$col); print "<br><br><table cellpadding=\"0\" cellspacing=\"0\" class=\"but2\" style=\"background: url(images/bg3.gif)\"><tr><td class=\"butt2\"><a href=\"http://".$HTTP_HOST."\">Голосование</a></td></tr></table><br>";} else {
			switch($sh){
				case "okr2"; $scr="kr2"; include_once("screenshots.php"); break;
				case "okr"; $scr="kr1"; include_once("screenshots.php"); break;
				case "opros"; $log="add"; include_once("golos.php"); break;
				case "okrfiles"; include_once("okr/files.php"); break;
				case "okr2files"; include_once("okr2/files.php"); break;
				case "search"; include_once("search.php"); break;
				default; $log="golrnd"; include_once("golos.php"); include_once("news.php"); break;
				}}?>
			</td>
			<td background="images/right-stor-bg2.gif" width="61" height="100%"><img src="images/ne.gif" width="1" height="100%" alt="" align="right"></td>
		</tr>
		<tr>
			<td width="61" height="99" rowspan="2"><img src="images/left-niz-ugl-2.gif" width="61" height="99" alt=""></td>
			<td height="60" width="100%" bgcolor="#b6b6b6" align="center">
				<font class="prim">При копировании материалов с сайта, ссылка на <a href="http://www.worldkr.fatal.ru" target="_parent" style="font-size:11px; letter-spacing:1px;" title="Самый полный ресурс по серии игр Космические Рейнджеры">WSR</a> обязательна.</font><br>
				<hr size="1" noshade>
				<font class="prim">Created © <a href="mailto:vpah@mail.ru" style="font-size: 11px; color:maroon;" title="Написать письмо Web-мастеру">Fuzzy Logic</a><br>
				Copyright © <tt style="color:maroon; font-size:12px; font-weight:bold; letter-spacing: 1px;" title="World of Space Rangers">WSR</tt>, 2004-2005</font>
			</td>
			<td width="61" height="99" rowspan="2"><img src="images/right-niz-ugl-2.gif" width="61" height="99" alt=""></td>
		</tr>
		<tr>
			<td background="images/niz-bg.gif" height="39" width="100%"><img src="images/ne.gif" height="39" alt="" border="0"></td>
		</tr>
		</table>	
	</td>
	<td width="30"><img src="images/ne.gif" width="30" alt="" border="0"></td>
	<td class="bgperight"><img src="images/ne.gif" width="25" alt="" border="0"></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="950" style="background:url(/images/bg.gif);">
<tr>
	<td class="bgperleft" rowspan="100"><img src="images/ne.gif" width="25" alt="" border="0"></td>
	<td width="900" colspan="3"></td>
	<td class="bgperight" rowspan="100"><img src="images/ne.gif" width="25" alt="" border="0"></td>
</tr>
<tr>
	<td class="leftparta"><A HREF='http://www.hotcd.ru/cgi-bin/index.pl?0==0==0==morfeus'><IMG SRC='http://www.hotcd.ru/generik/1x1.jpg' height="100" BORDER=0 ALT='Интернет магазин HotCD.ru' align="right"></A></td>
	<td class="parta"><script src="http://www.cbt-olymp.ru/parta.php?worldkr.fatal.ru" type="text/javascript"></script></td>
	<td class="rightparta"><a href="mailto:vpah@mail.ru?subject=Хочу%20себе%20такой%20счетчик!&body=Здравствуйте!%20Я%20(ФИО;%20Сайт)%20хочу%20установить%20такой%20счетчик%20у%20себя%20на%20сайте!%20Что%20мне%20для%20этого%20надо%20сделать?"><img src="http://www.cbt-olymp.ru/counter.php?worldkr.fatal.ru" width="88" height="97" border="0" alt="Хочешь себе такой счетчик?" align="left"></a></td>
</tr>
<tr>
	<td width="900" colspan="3">
		<table cellpadding="0" cellspacing="0" border="0" width="900" height="26" align="center">
		<tr>
			<td width="158"><img src="images/wsr<?php $r=mt_rand(0,5); print "$r-2"; ?>.gif" width="158" height="26" alt="World of Space Rangers"></td>
			<td width="611" class="bgpusk" align="center" style="letter-spacing:5px; font-size:11px;">World of Space Rangers</td>
			<td width="131"><a href="?show=refer/refer.html" target="_blank" onmouseover="imgon('imgu'); return true;" onmouseout="imgoff('imgu')"><img src="images/time-2.gif" width="131" height="26" alt="Ссылки на наших друзей и партнеров" border="0" name="imgu"></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="5" colspan="3"><img src="images/ne.gif" height="5" alt=""></td>
</tr>
</table>
<!--ul>
	<li>Один из лучших неоффициальных сайтов по игре Космические Рейнджеры. Отличный дизайн, множество полезной информации по самой игре делает исследование сайта увлекательным и позновательным.</li>
	<li>реферат, доклад, курсовая, диплом, StarForce, StarForce 3, StarForce 2, Доминаторы, Келлер, Клисане, Блазер, Космические Рейнджеры 2, Космические Рейнджеры, Рейнджеры, Спутник, Чит-коды, Читеры, Космичкские доминаторы, Рекорды, Саная крутая игра, Патчи, Rangers, Мастер флуд, Ария, сайт, музыка, mp3, скачать mp3, СВЧ и МИР КР, звезды, квазары, диссертация, сайтостроение, web-design, олимп, герои, дом 2, максимум, рок, готическая музыка, квесты</li>
	<li>СВЧ и Мир КР ::::: Форум ::::: Союз Вольных Читеров и Мир Космических Рейнджеров <<==>> Форум</li>
	<li>Ноутбуки, Компьютеры, высокие технологии, куча полезной информации, драйвера, видеокарты, процессоры, мониторы, клавиатуры, бесперебойники, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo</li>
</ul-->
</body>
</html>