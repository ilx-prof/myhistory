<?
set_time_limit(0);
    function getInput($length = 255)//.. ������ 255 ���� � ������ ��������� ����� �������� ������� ��� ������ � ���������� �������� 
	{
        $fr = fopen("stdout.txt", "r");
        $input = fgets($fr, $length);
        $input = rtrim($input);
        fclose($fr);
        return $input;
    }
    function setOutput($mes)//..��������� ��������� ��� � ���������� ��� � ���� out ������� ������ � �����
	{
        $fr = fopen("stdout.txt", "w");
        fwrite($fr,$mes);
        fwrite($fr,"\n");
        fclose($fr);
    }
	setOutput("@READY");//..��������� ��������� @READY � ���������� ��� � ���� out ������� ������ � �����
	$done = false;//���������� done ��� �����
	while($done == false)// ��������� ���� ���� done ����� false 
	{
	   $text = getInput();
	   print $done = ($text == "@STOP");
	    if($done == false)
		{
		    setOutput("@ANSWER ".$text);
	    }
    }
	print "������  ���� �� ����� false"

?>
