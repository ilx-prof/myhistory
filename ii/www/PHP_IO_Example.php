<?
set_time_limit(0);
    function getInput($length = 255)//.. читает 255 байт с начала указател€ файла вырезает пробелы там вс€кие и возвращает значение 
	{
        $fr = fopen("stdout.txt", "r");
        $input = fgets($fr, $length);
        $input = rtrim($input);
        fclose($fr);
        return $input;
    }
    function setOutput($mes)//..ѕринимает сообщение мес и записывает его в файл out оборвав строку в конце
	{
        $fr = fopen("stdout.txt", "w");
        fwrite($fr,$mes);
        fwrite($fr,"\n");
        fclose($fr);
    }
	setOutput("@READY");//..ѕринимает сообщение @READY и записывает его в файл out оборвав строку в конце
	$done = false;//определ€ет done как фалсе
	while($done == false)// выполн€ет цыкл пока done равно false 
	{
	   $text = getInput();
	   print $done = ($text == "@STOP");
	    if($done == false)
		{
		    setOutput("@ANSWER ".$text);
	    }
    }
	print "ѕобеда  доне не равно false"

?>
