<!--ul>
	<li>���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������.</li>
	<li>�������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������</li>
	<li>��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> �����</li>
	<li>��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo</li>
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
			 case "okr"; $title="��������� (����������� ���������)"; break;
			 case "okr2"; $title="��������� (����������� ���������  2: ����������)"; break;
			 case "opros"; $title="�����������"; break;
			 case "okrfiles"; $title="����� (����������� ���������)"; break;
			 case "okr2files"; $title="����� (����������� ��������� 2: ����������)"; break;
			 case "search"; $title="�����"; break;
			 case "news"; $title="�������(�������)"; break;
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
	<title>WSR ::: <?php print $title; ?> ::: ����� ::: ����� ������ ������ �� ����� ��� ����������� ���������</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=Windows-1251">
	<META NAME="page-topic" CONTENT="WSR ::: <?php print $title; ?> ::: ��� ����������� ���������� ::: ����� --- ����� ������ ������ �� ����� ��� ����������� ���������"> 
	<META NAME="title" CONTENT="WSR ::: <?php print $title; ?> ::: ��� ����������� ���������� ::: ����� --- ����� ������ ������ �� ����� ��� ����������� ���������">
	<META NAME="description" CONTENT="���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������.">
	<META NAME="abstract" CONTENT="���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������.">
	<META Name="keywords" Content="������, starforce, starforce 3, starforce 2, ����������, ������, �������, ������, �����, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ����, ����������� ����������, �������, ����� ������ ����, �����, rangers, ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������">
	<META NAME="revisit" CONTENT="1 day">
	<META NAME="revisit-after" CONTENT="1 days">
	<META NAME="Content-Language" CONTENT="english">
	<META NAME="audience" CONTENT="all">
	<META NAME="robots" CONTENT="all">
	<META NAME="Author" CONTENT="Denis Korneev, Copyright � 2004-2005 - vpah@mail.ru">
	<META NAME="Copyright" CONTENT="Copyright � WSR 2004-2005">
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
			<td width="800" height="26"><a href="http://<?php print $HTTP_HOST; ?>/" target="_parent"><img src="images/logoV.jpg" width="800" height="26" alt="����� ������ ������ �� ����� ��� ����������� ���������" border="0"></a></td>
			<td width="16" height="26"><img src="images/rightnc2per-2.gif" width="16" height="26" alt="" border="0"></td>
		</tr>
		<tr>
			<td background="images/leftbgper.gif" width="16" height="100%"><img src="images/ne.gif" width="16" height="100%" alt="" border="0"></td>
			<td width="800" height="118"><a href="http://<?php print $HTTP_HOST; ?>" target="_parent"><img src="images/logoC.jpg" width="800" height="118" alt="����� ������ ������ �� ����� ��� ����������� ���������" border="0"></a></td>
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
			<td width="160" align="right" class="bgpusk"><a href="?show=okr/about.html" onmouseover="imgon('img0'); return true;" onmouseout="imgoff('img0')"><img src="images/leftbut-2-passive.gif" width="160" height="26" alt="���������� � ������ ����� ����������� ����������" border="0" name="img0"></a></td>
			<td width="36" class="bgpusk"><img src="images/ne.gif" width="100%" height="1" alt="" border="0"></td>
			<td width="128" align="center" class="bgpusk"><a href="NewForum" target="_blank" onmouseover="imgon('imgf'); return true;" onmouseout="imgoff('imgf')"><img src="images/forum<?php print "$frm-2"; ?>.gif" width="128" height="26" alt="�������� ��� �� ��������? ��� � ��� ������" border="0" name="imgf"></a></td>
			<td width="36" class="bgpusk"><img src="images/ne.gif" width="100%" height="1" alt="" border="0"></td>
			<td width="160" align="left" class="bgpusk"><a href="?show=okr2/about.html" onmouseover="imgon('img1'); return true;" onmouseout="imgoff('img1')"><img src="images/rightbut-2-passive.gif" width="160" height="26" alt="���������� � ������ ����� ����������� ����������" border="0" name="img1"></a></td>
			<td width="135" class="bgpusk"><img src="images/ne.gif" width="100%" height="1" alt="" border="0"></td>
			<td width="55" align="right"><img src="images/uglr-2.gif" width="55" height="26" alt="" border="0"></td>
		</tr>
		<tr align="center" valign="top">
			<td colspan="3" width="350"></td>
			<td align="center" valign="top" width="200" colspan="3"><img src="images/perrrr.gif" width="164" height="17" alt="���� �� ��� �� ������, �� ���������: ��� ���������� ��������� ����" align="middle" border="0"></td>		
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
						<input type="Text" name="stroka" class="searchtext" style="width:280px" onblur="if (value == ''){value = ' ������� ������ ��� ������ � ������� ENTER'};" onfocus="if (value == ' ������� ������ ��� ������ � ������� ENTER'){value =''};" onclick="this.focus(); value='';" value=" ������� ������ ��� ������ � ������� ENTER"><input type="submit" name="but" style="width:0px;" value="">
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
			 		case "okr2"; print "<h1>��������� ��-2</h1>"; break;
					case "okr"; print "<h1>��������� ��-1</h1>"; break;
					case "opros"; print "<h1>�����������:</h1>"; break;
					case "okrfiles"; print "<h1>����� ��-1</h1>"; break;
					case "okr2files"; print "<h1>����� ��-2</h1>"; break;
					case "search"; print "<h1>�����</h1>"; break;
					default; print "<h1>�����������:</h1>"; break;
					};?>
			</td>
		</tr>
		<tr>
			<td background="images/left-stor-bg2.gif" width="61" height="100%"><img src="images/ne.gif" width="1" height="100%" alt="" align="left"></td>
			<td width="718" height="100%" bgcolor="#b6b6b6" valign="top">
			<?php if (!empty($show)){text($fp,$col); print "<br><br><table cellpadding=\"0\" cellspacing=\"0\" class=\"but2\" style=\"background: url(images/bg3.gif)\"><tr><td class=\"butt2\"><a href=\"http://".$HTTP_HOST."\">�����������</a></td></tr></table><br>";} else {
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
				<font class="prim">��� ����������� ���������� � �����, ������ �� <a href="http://www.worldkr.fatal.ru" target="_parent" style="font-size:11px; letter-spacing:1px;" title="����� ������ ������ �� ����� ��� ����������� ���������">WSR</a> �����������.</font><br>
				<hr size="1" noshade>
				<font class="prim">Created � <a href="mailto:vpah@mail.ru" style="font-size: 11px; color:maroon;" title="�������� ������ Web-�������">Fuzzy Logic</a><br>
				Copyright � <tt style="color:maroon; font-size:12px; font-weight:bold; letter-spacing: 1px;" title="World of Space Rangers">WSR</tt>, 2004-2005</font>
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
	<td class="leftparta"><A HREF='http://www.hotcd.ru/cgi-bin/index.pl?0==0==0==morfeus'><IMG SRC='http://www.hotcd.ru/generik/1x1.jpg' height="100" BORDER=0 ALT='�������� ������� HotCD.ru' align="right"></A></td>
	<td class="parta"><script src="http://www.cbt-olymp.ru/parta.php?worldkr.fatal.ru" type="text/javascript"></script></td>
	<td class="rightparta"><a href="mailto:vpah@mail.ru?subject=����%20����%20�����%20�������!&body=������������!%20�%20(���;%20����)%20����%20����������%20�����%20�������%20�%20����%20��%20�����!%20���%20���%20���%20�����%20����%20�������?"><img src="http://www.cbt-olymp.ru/counter.php?worldkr.fatal.ru" width="88" height="97" border="0" alt="������ ���� ����� �������?" align="left"></a></td>
</tr>
<tr>
	<td width="900" colspan="3">
		<table cellpadding="0" cellspacing="0" border="0" width="900" height="26" align="center">
		<tr>
			<td width="158"><img src="images/wsr<?php $r=mt_rand(0,5); print "$r-2"; ?>.gif" width="158" height="26" alt="World of Space Rangers"></td>
			<td width="611" class="bgpusk" align="center" style="letter-spacing:5px; font-size:11px;">World of Space Rangers</td>
			<td width="131"><a href="?show=refer/refer.html" target="_blank" onmouseover="imgon('imgu'); return true;" onmouseout="imgoff('imgu')"><img src="images/time-2.gif" width="131" height="26" alt="������ �� ����� ������ � ���������" border="0" name="imgu"></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="5" colspan="3"><img src="images/ne.gif" height="5" alt=""></td>
</tr>
</table>
<!--ul>
	<li>���� �� ������ �������������� ������ �� ���� ����������� ���������. �������� ������, ��������� �������� ���������� �� ����� ���� ������ ������������ ����� ������������� � ��������������.</li>
	<li>�������, ������, ��������, ������, StarForce, StarForce 3, StarForce 2, ����������, ������, �������, ������, ����������� ��������� 2, ����������� ���������, ���������, �������, ���-����, ������, ����������� ����������, �������, ����� ������ ����, �����, Rangers, ������ ����, ����, ����, ������, mp3, ������� mp3, ��� � ��� ��, ������, �������, �����������, �������������, web-design, �����, �����, ��� 2, ��������, ���, ���������� ������, ������</li>
	<li>��� � ��� �� ::::: ����� ::::: ���� ������� ������� � ��� ����������� ���������� <<==>> �����</li>
	<li>��������, ����������, ������� ����������, ���� �������� ����������, ��������, ����������, ����������, ��������, ����������, ��������������, sub-woofer, pascal, perl, java, php, cgi, design, robot, wars,topik, zoom, www.muz-tv.ru, www.rambler.ru, yandex.ru, ya.ru, google.ru, yahoo</li>
</ul-->
</body>
</html>