#!/usr/local/bin/php -q
<?php
###################################
# php irc-bot by t3rr4n           #
# thx for beta-test and help:     #
#  - wsr                          #
#  - rain0                        #
# private!                        #
###################################

####### SYSTEM CONFIGURATION#######
set_time_limit(0);
ignore_user_abort(1);
$config=array();
$config['protect']  = 0;	     # �������� ��� ������
$config['debug']    = 0;             # ��� �������
$config['log']      = 0;             # ���������� ���� ����������?
$config['login']    = "lock-team";   # ����� �...
$config['password'] = "t3rr4nbot";   # ������
$config['log_dir']  = "";            # ����� ��� �����
$config['hello']    = "hello.txt";   # ���� � ����������� �����������
##################################

####### IRC CONFIGURATION #########
$irc=array();
$irc['ip']      = "213.177.110.21";
$irc['port']    = "6667";
$irc['name']    = "irc.nn.ru";
$irc['channel'] = "#c14";
###################################

####### BOT CONFIGURATION #########
$bot=array();
$bot['nick'] = "DooM";
$bot['user'] = "DooM";
$bot['host'] = "c14.org";
$bot['ip']   = "82.146.41.163";
$bot['version']  = "0.3-beta";
###################################


if ($config['protect']) {
	if(!isset($PHP_AUTH_USER)) {
  		Header('WWW-Authenticate: Basic realm="DooM"');
  		Header('HTTP/1.0 401 Unauthorized');
  		exit;
  	} else {
  		if(($PHP_AUTH_USER != $config['login']) || ($PHP_AUTH_PW != $config['password'])) {
    		Header('WWW-Authenticate: Basic realm="DooM"');
    		Header('HTTP/1.0 401 Unauthorized');
    		exit;
    	}
	}
}

$mese[0] ="-";
$mese[1] ="������";
$mese[2] ="�������";
$mese[3] ="����";
$mese[4] ="������";
$mese[5] ="���";
$mese[6] ="����";
$mese[7] ="����";
$mese[8] ="������";
$mese[9] ="���������";
$mese[10]="�������";
$mese[11]="������";
$mese[12]="�������";

$giorno[0]="�����������";
$giorno[1]="�����������";
$giorno[2]="�������";
$giorno[3]="�����";
$giorno[4]="�������";
$giorno[5]="�������";
$giorno[6]="�������";

$gisett=(int)date("w");
$mesnum=(int)date("m");

if($config['debug']) { $file=fopen("debug.txt", "w"); }

$socket = fsockopen($irc["name"], $irc["port"], $errno, $errstr, 30);
if (!$socket) { die($errstr($errno)); }
$flag=0;
while(!$flag && !feof($socket)) {
	$line = fgets($socket, 1024);
	if(stristr($line, "Found your hostname")) { $flag=1; }
	if($config['debug']) { fwrite($file, $line); }
}
fwrite($socket, "NICK ".$bot["nick"]."\n");
fwrite($socket, "USER ".$bot["user"]." ".$bot["host"]." ".$bot["ip"]." :".$bot["user"]."\n");
$flag=0;
while(!$flag && !feof($socket)) {
	$line= fgets($socket, 1024);
	if(stristr($line, "PING :")) {
		$suck=trim(substr($line, 6, 8));
		$flag=1;
	}
	if($config['debug']) { fwrite($file, $line); }
}
fwrite($socket, "PONG :".$suck."\n");
sleep(2);
$flag=0;

while(!feof($socket) && !$flag) {
  	fwrite($file, $line);
   	$line=fgets($socket, 1024);
	if(stristr($line, "��������, ����������, ������ ���.")) { $flag=1; break; }
	if($config['debug']) { fwrite($file, $line); }
}
fwrite($socket, "NICKSERV identify qwesdzxc\n");
$flag=0;
while(!feof($socket) && !$flag) {
   	if($config['debug']) { fwrite($file, $line); }
   	$line=fgets($socket, 1024);
   	if (stristr($line, "������ ������")) { $flag=1; break; }
}

fwrite($socket, "JOIN #c14\n");
fwrite($socket, "MODE #c14\n");

if($config['log']) {
	$log_file = $config['log_dir'].date("m-d-y").".log";
	if(!file_exists($log_file)) {
		$log = fopen($log_file, "w");
	} else {
		$log = fopen($log_file, "a");
	}
}
fwrite($log_file, "������ ������ ����� ".date("m/d/y")." �: ".date("H:i:s")."\n");
$flag=0;
while(1) {
	$line=fgets($socket, 1024);

	if(stristr($line, "PING :")) {
		fwrite($socket, "PONG :irc.nn.ru\n");
		fwrite($file, "PONG!!!!\n");
	}

	if($config['debug']) { fwrite($file, $line); }

	if (stristr($line, ":!������")) {
		fwrite($socket, "PRIVMSG #c14 : ��� ������ - t3rr4n. C14 Stuff\n");
	}

	if ((stristr($line, ":!�������")) && ((substr($line, 0, 7)==":t3rr4n") || ((substr($line, 0, 4)==":wsr") || (substr($line, 0, 6)==":lsass") || (substr($line, 0, 6)==":Rain0")))) {
		fwrite($socket, "QUIT :����� �������� �� ����...\n");
		$content = date("[H:i:s]")." � ������ ����: DooM\n";
		fwrite($log, $content);
		$icq->disconnect();
	}

	if ((stristr($line, "JOIN")) && (substr($line, 0, 8)==":t3rr4n!")) {
		fwrite($socket, "PRIVMSG #c14 : ������ ���ب�!!!!\n");
	} elseif ((stristr($line, "JOIN"))  && ((substr($line, 0, 5)==":wsr!") or (substr($line, 0, 7)==":lsass!") or (substr($line, 0, 7)==":Rain0!"))) {
    	fwrite($socket, "PRIVMSG #c14 : ���� ������!!!!\n");
    } elseif (stristr($line, "JOIN :#")) {
    	$name = explode("!", $line);
    	$name[0]=substr($name[0], 1, strlen($name[0])-1);
    	if ($name[0]==$bot['nick']) {
    		$fhandle = file($config['hello']);
    		$x=rand(0, sizeof($fhandle)-1);
    		fwrite($socket, "PRIVMSG #c14 : ".$fhandle[$x]."\n");
    	} else {
    		fwrite($socket, "PRIVMSG #c14 : 4����������� ".$name[0]." !!!! ��� ���� ?\n");
    	}
    }

	if (stristr($line, ":!����")) {
		fwrite($socket, "PRIVMSG #c14 : ������� ����: ".$mese[$mesnum]." ".date("d")." ".$giorno[$gisett]."\n");
	}

	if (stristr($line, ":!�����")) {
		fwrite($socket, "PRIVMSG #c14 : ������� �����: ".date("H:i:s")."\n");
	}

	if (stristr($line, ":!�������")) {
		output_news();
	}

	if (stristr($line, ":!����")) {
		output_help();
	}

	if (stristr($line, ":!������")) {
		msg_mail($line);
	}

	if (stristr($line, ":!������")) {
		fwrite($socket, "PRIVMSG #c14 : ������� ������ DooM'�: ".$bot['version']."\n");
	}

	if (stristr($line, ":!������")) {
		proxy();
	}

	if (stristr($line, ":!����")) {
    	$random = file($config['fraz']);
    	$z=rand(0, sizeof($random)-1);
    	fwrite($socket, "PRIVMSG #c14 : ".$random[$z]."\n");
    }

    if (stristr($line, ":!������")) {
    	$show_quote();
    }

	if (stristr($line, "KICK #c14 DooM")) {
		join_channel();
	}

	#### ����� ���� ####

	if($config['log']) {
		if(stristr($line, "PRIVMSG")) {
			$fuck = explode("!", $line);
    		$name = substr($fuck[0], 1, strlen($fuck[0])-1);
    		$fuck = explode(" ", $line);
    		$x = strlen($fuck[0])+strlen($fuck[1])+strlen($fuck[2])+3;
    		$message = substr($line, $x, strlen($line));
    		$content = date("[H:i:s]")." <".$name."> ".$message."";
    		fwrite($log, $content);
		}

		if(stristr($line, "JOIN :")) {
			$fuck = explode("!", $line);
    		$name = substr($fuck[0], 1, strlen($fuck[0])-1);
    		$content = date("[H:i:s]")." �� ����� ������: ".$name."\n";
    		fwrite($log, $content);
		}

		if(stristr($line, "QUIT :")) {
			$fuck = explode("!", $line);
    		$name = substr($fuck[0], 1, strlen($fuck[0])-1);
    		$content = date("[H:i:s]")." � ������ ����: ".$name."\n";
    		fwrite($log, $content);
		}
	}

	####################
sleep(1);
}
if($config['log'])   { fclose($log);  }
if($config['debug']) { fclose($file); }
fclose($socket);

############## END ################


####### FUNCTIONS #################

function output_news() {
	global $socket;
	$file = @fopen("http://lock-team.org/filez_db/news.txt", "r");
	while(!feof($file)) {
		$sux[$i] = fgets($file, 1024);
		$i++;
	}
	fclose($file);
	$mas[0]=explode("|", $sux[$i-1]);
	$mas[1]=explode("|", $sux[$i-2]);
	$mas[2]=explode("|", $sux[$i-3]);
	for($i=0;$i<3;$i++){
		fwrite($socket, "PRIVMSG #c14 : ����: ".$mas[$i][0]."\n");
		fwrite($socket, "PRIVMSG #c14 : ����: ".$mas[$i][1]."\n");
		fwrite($socket, "PRIVMSG #c14 : �������: ".$mas[$i][2]."\n");
		fwrite($socket, "PRIVMSG #c14 : �����: ".$mas[$i][3]."\n");
		sleep(2);
	}
}

function output_help() {
	global $socket;
	fwrite($socket, "PRIVMSG #c14 : ��������� �������� ��� DooM:\n");
	fwrite($socket, "PRIVMSG #c14 : !������� - ���� ��������� ��� ������� � ����� lock-team.org\n");
	fwrite($socket, "PRIVMSG #c14 : !����    - ������� ������� ����\n");
	fwrite($socket, "PRIVMSG #c14 : !�����   - ������� ������� �����\n");
	fwrite($socket, "PRIVMSG #c14 : !������  - ��� ��������� ����\n");
	fwrite($socket, "PRIVMSG #c14 : !������  - ��������� ������\n");
	fwrite($socket, "PRIVMSG #c14 : !������  - ����� ������ ��������� ������ �� ����\n");
	fwrite($socket, "PRIVMSG #c14 : !����    - �� ��� �� ������� � ������ ������\n");
	fwrite($socket, "PRIVMSG #c14 : !������  - �������� !������ support@microsoft.com ������_����\n");
	fwrite($socket, "PRIVMSG #c14 : !����    - ������� ������ ����\n");
	fwrite($socket, "PRIVMSG #c14 : !������� - �������� ���� �� ���� (�������� ������ ��� ������� � ������)\n");
}

function proxy() {
	global $socket;
	$file = fopen("http://www.multiproxy.org/txt_anon/proxy.txt", "r");
	$i=0;
	while(!feof($file)) {
		$mas[$i] = fgets($file, 1024);
		$i++;
	}
	for ($i=0; $i<10; $i++) {
		$x=rand(0, sizeof($mas));
		fwrite($socket, "PRIVMSG #c14 : ".$mas[$x]."\n");
	}
}

function msg_mail($line) {
		global $socket;
        $milk = "support@microsoft.com";
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=Windows-1251\r\n";
        $headers .= "From: $milk\r\n";
        $headers .= "Reply-To: $milk\r\n";

		$sux=explode(" ", $line);
        $z = sizeof($sux);

        for ($j=6; $j<$z; $j++) {
             @$sux[5] .= " ".$sux[$j];
        }

		$nick = explode("!", $sux[0]);
        if (($sux[3]==":!������") && (!empty($sux[4])) && (!empty($sux[5]))) {
                if (mail($sux[4], "MSG from IRC (C14) [".$nick[0].":]", $sux[5], $headers)) {
                        fwrite($socket, "PRIVMSG #c14 : to: ".$sux[4]." ����������\n");
                } else {
                        fwrite($socket, "PRIVMSG #c14 : to: ".$sux[4]." ������������\n");
                }
        }
}

function join_channel() {
	global $socket;
	for($i=0; $i<3;$i++) {
		fwrite($socket, "JOIN #c14\n");
		fwrite($socket, "MODE #c14\n");
	}
}
?>