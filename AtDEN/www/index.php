<html>

<body bgproperties="50%" bgcolor="ffffff" >

<table align="center" >
<tr>
  
	<td><a href="index.php"  title="from den"><img src="center.gif" width="762"  border="0"  ></a></td>
  
</tr>
<tr>
	<td height="3" colspan="5"></td>
</tr>
</table>

<table align="center" cellspacing="0" cellpadding="0"   >
<tr >
	<td ><a href="deres" ><img src="buttion.gif" alt="руками не трогать" border="0"></a></td>
	<td ><a href="dell.php" ><img src="buttion.gif" alt="руками не трогать" border="0" "Удалить фаил"></a></td>
	<td ><a href="" ><img src="buttion.gif" alt="руками не трогать" border="0"></a></td>
</tr>
</table>

 <table align="center" cellspacing="-10" cellpadding="0" width="100%">
<tr >
	<td width="42" ><img src="boca-l.gif"></td>
	<td background="topp.gif" width="100%"></td>
	<td width="42"><img src="boca-r.gif"></td>
</tr>
</table>


<table  align="center"  cellspacing="0" cellpadding="0" width="800">

<tr >
 	<td valign="top"  width="30" height="42"><img src="boca-t.gif" height="42"></td>
	 <td rowspan="3"  bgcolor="#EAF2F2" >

		<table border="3" bordercolor="#59636A"  width="800">
			<td rowspan="3"  bgcolor="#EAF2F2"  valign="top">
<?php
$s = file("tet.txt");
for ($i = 0; $i < count($s) ; $i++)
{
print $s[$i] . "<br>";
}
?></table>
	 </td>
	<td valign="top" width="30" height="42"><img src="boca-t.gif"></td>
</tr>

<tr bordercolor="#000000"  >
	<td background="boca.gif" higit="1"</td>
	<td background="boca.gif" ></td>
</tr>

<tr>
	<td valign="bottom" width="30" height="42"><img src="boca-d.gif" ></td>
	<td valign="bottom" width="30" height="42"><img src="boca-d.gif" ></td>
</tr>

</table>
 <table align="center" width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td width="42" ><img src="boca-l.gif"></td>
	<td background="topp.gif" width="100%">
</td>
	<td width="42"  ><img src="boca-r.gif"></td>
</tr>
</table>
<table  align="center" >
	<FORM ACTION="1.php" METHOD=POST > 
<TEXTAREA  ROWS=3 COLS=100 NAME=Com ></TEXTAREA> 
<P> 
<INPUT TYPE=SUBMIT VALUE=Send  align="right"> 
</FORM> 
</table>


</body>
</html>