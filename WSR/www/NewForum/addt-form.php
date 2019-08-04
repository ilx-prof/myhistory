<?php
$dogg[0]=null; $dogg[1]=null; $dogg[2]=null;
$tochno="no";
$anon="no";
if (!empty($_COOKIE["Worldkr"])):
	$dogg=explode("||",$_COOKIE["Worldkr"]);
	$dogg[0]=strtolower($dogg[0]);
	$dogg[1]=strtolower($dogg[1]);
	$file="reg/$dogg[0].txt";
	if (file_exists($file)){
		$fq=file($file);
		$v=explode("|",$fq[1]);
		$v[1]=strtolower($v[1]);
		$vm=explode("|",$fq[2]);
			if ($dogg[1]==$v[1]){
				$tochno="yes";
				if ($dogg[0]=='31}3e}3f}3e}3p}3d}')$anon="yes";
				$vn=explode("|",$fq[0]);
				$dogg[0]=$vn[1];
				$mail=$vm[1];
			}
	}
endif;
?>
<script language="JavaScript">
function CheckForm(form)
{
 var i;
 var str = '';

 var bad_field;
 var fields = new Array();
 var prompts = new Array();
 var patterns = new Array();
 var minVal = new Array();
 var maxVal = new Array();
 var maxLen = new Array();
 var errors = new Array();

 fields[fields.length] = 'tema';
 prompts[prompts.length] = 'Ќазвание темы';
 patterns[patterns.length] = '';
 minVal[minVal.length] = 0;
 maxVal[maxVal.length] = 0;
 maxLen[maxLen.length] = 16;
 errors[errors.length] = '';

 fields[fields.length] = 'mes';
 prompts[prompts.length] = '—ообщение';
 patterns[patterns.length] = '';
 minVal[minVal.length] = 0;
 maxVal[maxVal.length] = 0;
 maxLen[maxLen.length] = 16;
 errors[errors.length] = '';

 for (i = 0; i < fields.length; i++){
  var field = form[fields[i]];
  if (field.value == ''){
   if (str != ''){
     str += '\n';
   }else{
     bad_field = field;
   }
   str += prompts[i];
  }
 }
 if (str != ''){
   alert("Ќе заполнены необходимые пол€:\n" + str);
   bad_field.focus();
   return false;
 }


 return true;
}

function CheckPassword(form)
{
 if (!CheckForm(form)) return false;

 return true;
}


function TAOnSelect(_eEvent,_sName){if ((_eEvent.type=="select")&&(_eEvent.srcElement.name==_sName)) {
		g_oSelectionRange=document.selection.createRange();
		if (g_oSelectionRange!=null) {
			if (g_oSelectionRange.text=="")	{ g_oSelectionRange=null; }
		}
	} else { g_oSelectionRange=null; }
}
function AddText(text) {
	if (document.addnew.mes.createTextRange && document.addnew.mes.caretPos) {
		var caretPos = document.addnew.mes.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
	} else document.addnew.mes.value += text;  
}
</script><p></p>

<script type="text/javascript" language="JavaScript">
//var imageTag = false;
//var theSelection = false;

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav  = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));

var is_win   = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac    = (clientPC.indexOf("mac")!=-1);

function bbfontstyle(bbopen, bbclose) {
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			document.addnew.mess.value += bbopen + bbclose;
			document.addnew.mess.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		document.addnew.mess.focus();
		return;
	} else {
		document.addnew.mess.value += bbopen + bbclose;
		document.addnew.mess.focus();
		return;
	}
	storeCaret(document.addnew.mess);
}
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
</script>
<head>
<link rel="STYLESHEET" type="text/css" href="style.css">
</head>

<body bgcolor="#000000" style="color:white;">
<form action="addt.php" onsubmit="return CheckPassword(this);" method="post" name="addnew">
<table align="center" cellspacing="0" cellpadding="0" border="0" style="filter: alpha(opacity=85);">
<tr>
    <td><img src="lvF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="1" border="0"></td>
    <td><img src="pvF.gif" width="10" height="10" border="0"></td>
</tr>
<tr>
    <td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
    <td background="bgF.gif">
<h1 class="Tim">ƒобавление новой темы</h1>
<em class="fuz">“ема </em><font color=#FF0000>*</font>
<INPUT class="forma" TYPE=TEXT  size=75 NAME=tema><br><br>
<?php echo("
<table border=\"1\" width=\"100%\">
	<tr>
		<td align=\"center\"><em class='fuz'>»м€(Ќик)</em></td>
		<td align=\"center\"><a href=\"user.php?user=$dogg[0]\" style=\"cursor:hand;\"><div class='text'>$dogg[0]</div><div class='shadow' UNSELECTABLE='on'>$dogg[0]</div></a></td>
	</tr>
	<tr>
		<td align=\"center\"><em class='fuz'>E-mail </em></td>
		<td align=\"center\"><a href=\"mailto:$mail\">$mail</a></td>
	</tr>
</table>
	<INPUT class='forma' TYPE=HIDDEN SIZE=20 NAME=nick value='$dogg[0]'>
	<INPUT class='forma' TYPE=HIDDEN SIZE=65  NAME=mail value='$mail'>
	");
?><br>
<em class="fuz">—ообщение </em><font color=#FF0000>*</font><br>
<TEXTAREA class="forma" onclick="storeCaret(this);" onchange="storeCaret(this);" onselect="storeCaret(this);" name="mes" rows=6 cols=65></TEXTAREA><p><p>
<SELECT onchange="bbfontstyle('[color=' + this.form.red.options[this.form.red.selectedIndex].value + ']', '[/color]')" name=red>
<OPTION style="COLOR: #500000; BACKGROUND-COLOR: #4F7FBF" value="r0" selected> расный:</OPTION> 
<OPTION style="COLOR: #690000; BACKGROUND-COLOR: #4F7FBF" value="r1">€ркость 1</OPTION>
<OPTION style="COLOR: #820000; BACKGROUND-COLOR: #4F7FBF" value="r2">€ркость 2</OPTION>
<OPTION style="COLOR: #9b0000; BACKGROUND-COLOR: #4F7FBF" value="r3">€ркость 3</OPTION>
<OPTION style="COLOR: #b40000; BACKGROUND-COLOR: #4F7FBF" value="r4">€ркость 4</OPTION>
<OPTION style="COLOR: #cd0000; BACKGROUND-COLOR: #4F7FBF" value="r5">€ркость 5</OPTION>
</SELECT>
<SELECT onchange="bbfontstyle('[color=' + this.form.green.options[this.form.green.selectedIndex].value + ']', '[/color]')" name=green>
<OPTION style="COLOR: #005000; BACKGROUND-COLOR: #4F7FBF" value="g0" selected>«еленый:</OPTION> 
<OPTION style="COLOR: #006900; BACKGROUND-COLOR: #4F7FBF" value="g1">€ркость 1</OPTION>
<OPTION style="COLOR: #008200; BACKGROUND-COLOR: #4F7FBF" value="g2">€ркость 2</OPTION>
<OPTION style="COLOR: #009b00; BACKGROUND-COLOR: #4F7FBF" value="g3">€ркость 3</OPTION>
<OPTION style="COLOR: #00b400; BACKGROUND-COLOR: #4F7FBF" value="g4">€ркость 4</OPTION>
<OPTION style="COLOR: #00cd00; BACKGROUND-COLOR: #4F7FBF" value="g5">€ркость 5</OPTION>
</SELECT>
<SELECT onchange="bbfontstyle('[color=' + this.form.orange.options[this.form.orange.selectedIndex].value + ']', '[/color]')" name=orange>
<OPTION style="COLOR: #bf4000; BACKGROUND-COLOR: #4F7FBF" value="o0" selected>ќранжевый:</OPTION> 
<OPTION style="COLOR: #d85900; BACKGROUND-COLOR: #4F7FBF" value="o1">€ркость 1</OPTION>
<OPTION style="COLOR: #f17200; BACKGROUND-COLOR: #4F7FBF" value="o2">€ркость 2</OPTION>
<OPTION style="COLOR: #ff8040; BACKGROUND-COLOR: #4F7FBF" value="o3">€ркость 3</OPTION>
<OPTION style="COLOR: #ff9959; BACKGROUND-COLOR: #4F7FBF" value="o4">€ркость 4</OPTION>
<OPTION style="COLOR: #ffb272; BACKGROUND-COLOR: #4F7FBF" value="o5">€ркость 5</OPTION>
</SELECT>
<SELECT onchange="bbfontstyle('[color=' + this.form.fiolet.options[this.form.fiolet.selectedIndex].value + ']', '[/color]')" name=fiolet>
<OPTION style="COLOR: #400080; BACKGROUND-COLOR: #4F7FBF" value="f0" selected>‘иолетовый:</OPTION> 
<OPTION style="COLOR: #591998; BACKGROUND-COLOR: #4F7FBF" value="f1">€ркость 1</OPTION>
<OPTION style="COLOR: #7232b2; BACKGROUND-COLOR: #4F7FBF" value="f2">€ркость 2</OPTION>
<OPTION style="COLOR: #8b4bcb; BACKGROUND-COLOR: #4F7FBF" value="f3">€ркость 3</OPTION>
<OPTION style="COLOR: #a364e4; BACKGROUND-COLOR: #4F7FBF" value="f4">€ркость 4</OPTION>
<OPTION style="COLOR: #bc7dfd; BACKGROUND-COLOR: #4F7FBF" value="f5">€ркость 5</OPTION>
</SELECT>
<br>
<SELECT onchange="bbfontstyle('[color=' + this.form.xaki.options[this.form.xaki.selectedIndex].value + ']', '[/color]')" name=xaki>
<OPTION style="COLOR: #505000; BACKGROUND-COLOR: #4F7FBF" value="x0" selected>’аки:</OPTION> 
<OPTION style="COLOR: #696900; BACKGROUND-COLOR: #4F7FBF" value="x1">€ркость 1</OPTION>
<OPTION style="COLOR: #828200; BACKGROUND-COLOR: #4F7FBF" value="x2">€ркость 2</OPTION>
<OPTION style="COLOR: #9b9b00; BACKGROUND-COLOR: #4F7FBF" value="x3">€ркость 3</OPTION>
<OPTION style="COLOR: #b4b400; BACKGROUND-COLOR: #4F7FBF" value="x4">€ркость 4</OPTION>
<OPTION style="COLOR: #cdcd00; BACKGROUND-COLOR: #4F7FBF" value="x5">€ркость 5</OPTION>
</SELECT>
<SELECT onchange="bbfontstyle('[color=' + this.form.blue.options[this.form.blue.selectedIndex].value + ']', '[/color]')" name=blue>
<OPTION style="COLOR: #000050; BACKGROUND-COLOR: #4F7FBF" value="b0" selected>—иний:</OPTION> 
<OPTION style="COLOR: #000069; BACKGROUND-COLOR: #4F7FBF" value="b1">€ркость 1</OPTION>
<OPTION style="COLOR: #000082; BACKGROUND-COLOR: #4F7FBF" value="b2">€ркость 2</OPTION>
<OPTION style="COLOR: #00009b; BACKGROUND-COLOR: #4F7FBF" value="b3">€ркость 3</OPTION>
<OPTION style="COLOR: #0000b4; BACKGROUND-COLOR: #4F7FBF" value="b4">€ркость 4</OPTION>
<OPTION style="COLOR: #0000cd; BACKGROUND-COLOR: #4F7FBF" value="b5">€ркость 5</OPTION>
</SELECT>
<SELECT onchange="bbfontstyle('[color=' + this.form.purpur.options[this.form.purpur.selectedIndex].value + ']', '[/color]')" name=purpur>
<OPTION style="COLOR: #500050; BACKGROUND-COLOR: #4F7FBF" value="p0" selected>ѕурпурный:</OPTION> 
<OPTION style="COLOR: #690069; BACKGROUND-COLOR: #4F7FBF" value="p1">€ркость 1</OPTION>
<OPTION style="COLOR: #820082; BACKGROUND-COLOR: #4F7FBF" value="p2">€ркость 2</OPTION>
<OPTION style="COLOR: #9b009b; BACKGROUND-COLOR: #4F7FBF" value="p3">€ркость 3</OPTION>
<OPTION style="COLOR: #b400b4; BACKGROUND-COLOR: #4F7FBF" value="p4">€ркость 4</OPTION>
<OPTION style="COLOR: #cd00cd; BACKGROUND-COLOR: #4F7FBF" value="p5">€ркость 5</OPTION>
</SELECT>
<SELECT onchange="bbfontstyle('[color=' + this.form.aqua.options[this.form.aqua.selectedIndex].value + ']', '[/color]')" name=aqua>
<OPTION style="COLOR: #005050; BACKGROUND-COLOR: #4F7FBF" value="a0" selected>јквамариновый:</OPTION> 
<OPTION style="COLOR: #006969; BACKGROUND-COLOR: #4F7FBF" value="a1">€ркость 1</OPTION>
<OPTION style="COLOR: #008282; BACKGROUND-COLOR: #4F7FBF" value="a2">€ркость 2</OPTION>
<OPTION style="COLOR: #009b9b; BACKGROUND-COLOR: #4F7FBF" value="a3">€ркость 3</OPTION>
<OPTION style="COLOR: #00b4b4; BACKGROUND-COLOR: #4F7FBF" value="a4">€ркость 4</OPTION>
<OPTION style="COLOR: #00cdcd; BACKGROUND-COLOR: #4F7FBF" value="a5">€ркость 5</OPTION>
</SELECT>

<A onclick="javascript:AddText('[url]www.worldkr.fatal.ru[/url]'); return false;" href="http://www.worldkr.fatal.ru/#" style="cursor:hand;"><FONT color="#3E842F" style="text-decoration:none; font-size: 12px;">—сылка</FONT></A></div><br>
<INPUT class="fuzzy" TYPE=SUBMIT VALUE="ƒобавить тему" style="cursor:hand;">&nbsp;&nbsp;&nbsp;<font style="font-size:13; font-weight:normal;" color="#ffffff">—майлы:</font>
<A onclick="javascript:AddText('[смущ]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="blush.gif" width="15" height="15" alt="—мущенный" border="0"></A>
<A onclick="javascript:AddText('[спок]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="crazy.gif" width="15" height="15" alt="—покойный" border="0"></A>
<A onclick="javascript:AddText('[хммм]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="frown.gif" width="15" height="15" alt="’ммм" border="0"></A>
<A onclick="javascript:AddText('[хаха]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="laugh.gif" width="15" height="15" alt="’а’а" border="0"></A>
<A onclick="javascript:AddText('[зло]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="mad.gif" width="15" height="15" alt="«ло" border="0"></A>
<A onclick="javascript:AddText('[шок]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="shocked.gif" width="15" height="15" alt="Ўок" border="0"></A>
<A onclick="javascript:AddText('[улыбка]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="smile.gif" width="15" height="15" alt="”лыбка" border="0"></A>
<A onclick="javascript:AddText('[бебе]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="tongue.gif" width="15" height="15" alt="ЅеЅе" border="0"></A>
<A onclick="javascript:AddText('[миг]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="wink.gif" width="15" height="15" alt="миг" border="0"></A>

<?
$date=date("d.m.y");
$time=date("H:i:s");
echo("<input type='Hidden' name=time readonly=0 value=$time>");
echo("<input type='Hidden' name=date readonly=0 value=$date>");
echo("<input type='Hidden' name=ra readonly=0 value=$door>");
echo("<input type='Hidden' name=to readonly=0 value=$to>");
?></td>
    <td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
</tr>
<tr>
    <td><img src="lnF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="10" border="0"></td>
    <td><img src="pnF.gif" width="10" height="10" border="0"></td>
</tr>
</table>
</form>
</body>