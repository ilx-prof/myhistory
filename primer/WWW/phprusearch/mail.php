<?

class Email
{
	var $EMAIL;
	var $HEADERS;
	var $ERROR;
	
	function Email($to,$subject,$content)
	{
		$HEADERS = "Content-Type: text/plain; charset=windows-1251\n";
		$HEADERS .= "From: mail_robot@".$_SERVER["SERVER_NAME"]."\n";
		$HEADERS .= "X-Sender: <mail_robot@".$_SERVER["SERVER_NAME"].">\n";
		$HEADERS .= "X-Mailer: PHP4\n";
		$HEADERS .= "X-Priority: 1\n";
		$HEADERS .= "Return-Path: <admin@".$_SERVER["SERVER_NAME"].">\n";
		$HEADERS .= "Content-Type: text/plain; charset=windows-1251\n\n";
			  
		if (mail ($to,$subject,$content,$HEADERS))
			$this->ERROR = 0;
		else
			$this->ERROR = 1;
	}
}

function PHPruSave($input,$file,$chmod='w+')
{
	$fp = fopen($file,$chmod);
	flock($fp,2);
	fputs ($fp,	$input);
	flock($fp,3);
	fclose($fp);
}

?>