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

 fields[fields.length] = 'mes';
 prompts[prompts.length] = 'Сообщение';
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
   alert("Не заполнены необходимые поля:\n" + str);
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

function storeCaret(text) {
	if (text.createTextRange) {text.caretPos = document.selection.createRange().duplicate();}}
function TAOnSelect(_eEvent,_sName){if ((_eEvent.type=="select")&&(_eEvent.srcElement.name==_sName)) {
		g_oSelectionRange=document.selection.createRange();
		if (g_oSelectionRange!=null) {
			if (g_oSelectionRange.text=="")	{ g_oSelectionRange=null; }
		}
	} else { g_oSelectionRange=null; }
}
function AddText(text) {
	if (document.addm.mes.createTextRange && document.addm.mes.caretPos) {
		var caretPos = document.addm.mes.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
	} else document.addm.mes.value += text;  
}
</script>
<head>
<link rel="STYLESHEET" type="text/css" href="style.css">
</head>

<body bgcolor="#000000" style="color:white;">
<p></p>
<form action="addn.php?ra=<?php echo ("$ra"); ?>" onsubmit="return CheckPassword(this);" method="post" name="addm">
<table align="center" cellspacing="0" cellpadding="0" border="0" style="filter: alpha(opacity=85);">
<tr>
    <td><img src="lvF.gif" width="10" height="10" border="0"></td>
    <td background="bgF.gif"><img src="ne.gif" width="1" height="1" border="0"></td>
    <td><img src="pvF.gif" width="10" height="10" border="0"></td>
</tr>
<tr>
    <td background="bgF.gif"><img src="ne.gif" width="10" height="1" border="0"></td>
    <td background="bgF.gif">
<h1 class="Tim">Добавление ответа</h1>
<?php
if($anon!='yes'){
	echo("
<table border=\"1\" width=\"100%\">
	<tr>
		<td align=\"center\"><em class='fuz'>Имя(Ник)</em></td>
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
}
else
{
	echo ("
	<INPUT class='forma' TYPE=HIDDEN SIZE=20 NAME=nick value='$dogg[0]'>
	<INPUT class='forma' TYPE=HIDDEN SIZE=65  NAME=mail value='$mail'>
	");
}
?>
<em class="fuz">Сообщение </em><font color=#FF0000>*</font><br>
<TEXTAREA class="forma" onclick="javascript:storeCaret(this);" onchange="javascript:storeCaret(this);" onselect="TAOnSelect(event,'message'); storeCaret(this);" name="mes" rows=6 cols=65></TEXTAREA><p><p>
<table align="center"><tr align="center">
	<td><img src="G.gif" width="66" height="34" alt="" border="0"><br><input name="ras" type="Radio" value="gaal"></td>
	<td><img src="F.gif" width="66" height="34" alt="" border="0"><br><input name="ras" type="Radio" value="fei"></td>
	<td><img src="H.gif" width="66" height="34" alt="" border="0"><br><input name="ras" type="Radio" value="human"></td>
	<td><img src="M.gif" width="66" height="34" alt="" border="0"><br><input name="ras" type="Radio" value="malok"></td>
	<td><img src="P.gif" width="66" height="34" alt="" border="0"><br><input name="ras" type="Radio" value="peleng"></td>
</tr></table>
<hr color="#ffffff" width="100%">
<div align="center">
<A onclick="javascript:AddText('[смущ]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="blush.gif" width="15" height="15" alt="Смущенный" border="0"></A>
<A onclick="javascript:AddText('[спок]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="crazy.gif" width="15" height="15" alt="Спокойный" border="0"></A>
<A onclick="javascript:AddText('[хммм]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="frown.gif" width="15" height="15" alt="Хммм" border="0"></A>
<A onclick="javascript:AddText('[хаха]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="laugh.gif" width="15" height="15" alt="ХаХа" border="0"></A>
<A onclick="javascript:AddText('[зло]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="mad.gif" width="15" height="15" alt="Зло" border="0"></A>
<A onclick="javascript:AddText('[шок]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="shocked.gif" width="15" height="15" alt="Шок" border="0"></A>
<A onclick="javascript:AddText('[улыбка]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="smile.gif" width="15" height="15" alt="Улыбка" border="0"></A>
<A onclick="javascript:AddText('[бебе]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="tongue.gif" width="15" height="15" alt="БеБе" border="0"></A>
<A onclick="javascript:AddText('[миг]'); return false;" href="http://www.worldkr.fatal.ru/#"><img src="wink.gif" width="15" height="15" alt="миг" border="0"></A>
<=|||=>
<A onclick="javascript:AddText('[r]красный текст[/c]'); return false;" href="http://www.worldkr.fatal.ru/#"><FONT color="#ff0000" style="text-decoration:none; font-weight:bold; font-size: 12px;">Красный текст</FONT></A>
<A onclick="javascript:AddText('[y]желтый текст[/c]'); return false;" href="http://www.worldkr.fatal.ru/#"><FONT color="#ffff00" style="text-decoration:none; font-weight:bold; font-size: 12px;">Желтый текст</FONT></A>
<A onclick="javascript:AddText('[w]белый текст[/c]'); return false;" href="http://www.worldkr.fatal.ru/#"><FONT color="#3e4859" style="text-decoration:none; font-weight:bold; font-size: 12px;">Тёмный текст</FONT></A>
<A onclick="javascript:AddText('[url]www.worldkr.fatal.ru[/url]'); return false;" href="http://www.worldkr.fatal.ru/#"><FONT color="#3E842F" style="text-decoration:none; font-weight:bold; font-size: 12px;">Ссылка</FONT></A><br><br>
<?php
$date=date("d.m.y");
$time=date("H:i:s");
echo("<input type='Hidden' name=time readonly=0 value=$time>\n");
echo("<input type='Hidden' name=date readonly=0 value=$date>\n");
echo("<input type='Hidden' name=no readonly=0 value=$show>\n");
echo("<input type='Hidden' name=f readonly=0 value=$f>\n");
?>
<script type="text/javascript" language="JavaScript">
function get()
{
window.open ("Forum.php", "_parent");}
</script>
<INPUT class="fuzzy" TYPE=SUBMIT VALUE="Ответить" style="cursor:hand;">
<input class="fuzzy" type="Button" onclick="get()" value="Вернуться к списку тем" style="cursor:hand;">
</div>

</td>   
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