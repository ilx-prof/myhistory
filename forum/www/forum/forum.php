<pre>
<?
DEFINE("START_TIME", MICROTIME(TRUE));
include ("include_functions.php");
//print translete_to_pattern("FORUM","дерьмо бля","forms/list.php");
			//print_r (array_values(preg_grep("<!--\.*?.\-->",file("forms/List.php"))));
//var_dump (array_values(preg_grep("<!--.*\-->",preg_grep("<!--.*?\-->",file("forms/List.php")))));


$Rplese_blok=array ("Категория"
					,"Глобальная тема"
					,"Дата"
					,"Пользователь");
$Rplese_list=array ('<p align="center"><font face="Comic Sans MS" size="+4">ПИЗДАТО</font></p>'
					,delay() /* print_cat()//translete_allay ("blok.php",$Rplese_blok)/*Что находиться в реплейс форме*/
					,"Дата");

	print (translete_allay ("List.php",$Rplese_list));
	print date("G:i:s:ss").rand(-89998898989,56464123189978)."<br>";               


DEFINE("bitime", MICROTIME(TRUE));
//print_r(Categoria_MAP(true));
print_r (out_put_tema("Categoria/Categoria1/Aaaa)",TRUE));
//print_r (map_tems_categories ("Categoria/Categoria1/Aaaa",TRUE));

PRINT (MICROTIME(TRUE)-bitime)."<br>";

PRINT (MICROTIME(TRUE)-START_TIME);
?>