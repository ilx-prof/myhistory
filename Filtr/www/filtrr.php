<pre>
<?php
if($txt = $_POST["text"] and $lang = $_POST["lang"] and $perevod=file("txt.txt"))
{	
	$txt = strtolower($txt);
	$pieces = explode("
", $txt);
	$pieces = array_unique ($pieces);
	
	for ($i = 0; $i <= count($pieces)-1; $i++)
	{
	switch ($lang)
	{case "rus":
	@print "<br>".trim($pieces[$i])." - ".trim($perevod[$i]);
	  break;
	case "eng":
	@print "<br>".trim($perevod[$i])." - ".trim($pieces[$i]);
	  break;
	 }
	}
}
?></pre>
