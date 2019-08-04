<?php
FUNCTION matrca ($i,$sir)
{
	$count=$i;
	$print="<table cellpadding=\"0\" cellspacing=\"0\">";
	$i=0;
	while($i<=$count-1)
	{
		$print .="<tr>";
		$a=0;
		while($a<=$sir)
		{
			$print .= "<td>";
			$print .='<a href="index.php ? cimBol='.$i.'">'. htmlentities (chr($i)).'</a>';
			$print .="</td>";
			$a++;
			$i++;
		}
			$print .= "</tr>";
			
	}
	$print .="</table>";
	return $print;
}
print matrca (256,15);
if( isset($_GET["cimBol"]))
{
 Print '
 <table cellspacing="2" cellpadding="2" border="1">
<tr>
	<td align="center">Символ №</td>
	<td bgcolor="#DDDDDD">htmlentities ()</td>
	<td bgcolor="#B5A8C4">htmlspecialchars ()</td>
</tr>
<tr>
	<td align="center">'.$_GET["cimBol"].'</td>
	<td bgcolor="#DDDDDD">'.htmlentities (chr($_GET["cimBol"])).'</td>
	<td bgcolor="#B5A8C4">'.htmlspecialchars (chr($_GET["cimBol"])).'</td>
</tr>
</table>
';
}
?> 