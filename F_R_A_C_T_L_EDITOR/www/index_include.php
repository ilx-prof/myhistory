<style >
	.nlink	{color:#4F1C93; font-family: Comic Sans MS;  text-decoration: blink}
	.nlink2	{color:#CC133D; font-family: Comic Sans MS; font-size: larger; text-decoration:  line-through }
	</style>
<body bgcolor="#EFEFEF">
<table align="center" bgcolor="#c0c0c0">
<tr><td align="center">
<pre>
<FIELDSET><LEGEND align="center"><a href="F_R_A_T_A_L_Editor.php"><font color="#0000ff" face="aril" size="5" >F_R_A_T_A_L_Editor</font></a></LEGEND>
<p align="center">
 <FIELDSET><LEGEND align="center">Загрузить</LEGEND>
<form action="imege.php" method="POST">
<select size="10" name="load" >
<?php
$This_dir = getcwd ();
	function rasbor($string)
	{
		$Option = explode("*",trim($string));
		$name=$Option[1];
		$Options[$name] = $Option;
		return $Options;
	}

	
	$Arx = file(dirname (__FILE__)."/Fractal_seve/DataSAVE.Frsev");
	$i=0;
	while($i<=count($Arx)-1)
	{
		$ARX[]=rasbor($Arx[$i]);
		$i++;
	}
	$i=0;
	$r=true;
	$print ="";
	while($i<=count($Arx)-1)
	{
	$print.="
		<option  value=\"".$i."\">".($i+1)."-> ".key($ARX[$i])."</option>";
		$i++;
	
	}
	print $print;
?>
</select>
<input type="SUBMIT" name="submit" value="LOAD"><input type="SUBMIT" name="submit" value="Delete">
</form>
</FIELDSET>
<FIELDSET><LEGEND align="center"><font color="#0000ff">Метод построения</font></LEGEND>
<form action="index_include.php" name="forma"  method="POST">
<select name="func" onchange="javascript:document.forms['forma'].submit ( );">
<?
	if (is_dir(getcwd ()."/meny"))
	{ 
	 	if ($dh = opendir(getcwd ()."/meny"))
	 	{
     	 	while (false !== ($file = readdir($dh)))
			{
				 if ($file != "." && $file != ".." && is_file(getcwd ()."/meny/".$file))
				 {
					$files[]=$file;
					$i++;
				 }
			}
		}
	}
	
	$tmp = "";
	$form = $tmp;
	foreach ( $files as $id => $fname )
	{
		$select ="";
		if (isset ( $_POST["func"] ) && $_POST["func"]==$fname)
		{
			$select="selected";
		}
		$form .="	<option value=\"".$fname."\" $select>".$fname ."</option>\n";
	}
	$form .= "";
	print $form;
?>
</select>
</form>
</p>
<?
$fname="";
if ( isset ( $_POST["func"] ) )
{
?>
<? ob_start ( );?>
<FIELDSET> <legend align="center"><font color="#12590D" face="Comic Sans MS">Дополнительные параметры для <? print $_POST["func"] ?></font></legend> 
<?
	$fname = $_POST["func"];
	include (dirname (__FILE__)."/meny/".$fname);
}
else
{
	print "<FIELDSET><legend  align=\"center\">Для нчала выбери метод построения</legend><FIELDSET>";
}
?>
</FIELDSET>
<?
	$byfer = ob_get_contents();
	if ( !empty ($byfer))
	{
		ob_clean();
	
?>
<FIELDSET><LEGEND align="center">Как строим</LEGEND>

<?
?>
<form action="index_include.php" name="forma2"  method="POST" >
<input type="Hidden" name="func" value="<? print $fname;?>">
<select name="metod" onchange="javascript:document.forms['forma2'].submit ( );">
<?
if (is_dir($dirr))
	{ 
	 	if ($dh = opendir($dirr))
	 	{
     	 	while (false !== ($filem = readdir($dh)))
			{
				 if ($filem != "." && $filem != ".." )
				 {
					if (isset ($_POST["metod"] ) && basename($_POST["metod"])==$filem)
					{
						$select1="selected";
					}
					else
					{ $select1=""; }
					Print "<option value=\"$nemoption/$filem\" $select1>$filem</option><br>";
					$m++;
				 }
			}
		}
	}
	Print '</select>';
if ( isset ( $_POST["metod"] ))
{
?>
</form>
<FIELDSET> <legend align="center"><font color="#12590D" face="Comic Sans MS">Дополнительные параметры для <? print basename($_POST["metod"]) ?></font></legend> 
<?

	$fnam = $_POST["metod"];
	include (dirname (__FILE__)."/meny/metod/".$fnam);
}
else
{
	print "<FIELDSET><legend  align=\"center\">Выбири чем строить</legend><FIELDSET>";
}
?>
</FIELDSET>
<? print $byfer;
	}
?>
</td></tr>
</table></body>