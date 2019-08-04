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
$config['protect']  = 0;	     # включить для защиты
$config['debug']    = 0;             # для отладки
$config['log']      = 0;             # записывать логи разговоров?
$config['login']    = "lock-team";   # логин и...
$config['password'] = "t3rr4nbot";   # пароль
$config['log_dir']  = "";            # папка для логов
$config['hello']    = "hello.txt";   # файл с сообщениями приветствия
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
$mese[1] ="Январь";
$mese[2] ="Февраль";
$mese[3] ="Март";
$mese[4] ="Апрель";
$mese[5] ="Май";
$mese[6] ="Июнь";
$mese[7] ="Июль";
$mese[8] ="Август";
$mese[9] ="Сеньтябрь";
$mese[10]="Октябрь";
$mese[11]="Ноябрь";
$mese[12]="Декабрь";

$giorno[0]="Воскресенье";
$giorno[1]="Понедельник";
$giorno[2]="Вторник";
$giorno[3]="Среда";
$giorno[4]="Четверг";
$giorno[5]="Пятница";
$giorno[6]="Суббота";

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
	if(stristr($line, "выберите, пожалуйста, другой ник.")) { $flag=1; break; }
	if($config['debug']) { fwrite($file, $line); }
}
fwrite($socket, "NICKSERV identify qwesdzxc\n");
$flag=0;
while(!feof($socket) && !$flag) {
   	if($config['debug']) { fwrite($file, $line); }
   	$line=fgets($socket, 1024);
   	if (stristr($line, "Пароль принят")) { $flag=1; break; }
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
fwrite($log_file, "Начало записи логов ".date("m/d/y")." в: ".date("H:i:s")."\n");
$flag=0;
while(1) {
	$line=fgets($socket, 1024);

	if(stristr($line, "PING :")) {
		fwrite($socket, "PONG :irc.nn.ru\n");
		fwrite($file, "PONG!!!!\n");
	}

	if($config['debug']) { fwrite($file, $line); }

	if (stristr($line, ":!хозяин")) {
		fwrite($socket, "PRIVMSG #c14 : Мой хозяин - t3rr4n. C14 Stuff\n");
	}

	if ((stristr($line, ":!пшёлнах")) && ((substr($line, 0, 7)==":t3rr4n") || ((substr($line, 0, 4)==":wsr") || (substr($line, 0, 6)==":lsass") || (substr($line, 0, 6)==":Rain0")))) {
		fwrite($socket, "QUIT :сцуки посидеть не дали...\n");
		$content = date("[H:i:s]")." С какала ушёл: DooM\n";
		fwrite($log, $content);
		$icq->disconnect();
	}

	if ((stristr($line, "JOIN")) && (substr($line, 0, 8)==":t3rr4n!")) {
		fwrite($socket, "PRIVMSG #c14 : ХОЗЯИН ПРИШЁЛ!!!!\n");
	} elseif ((stristr($line, "JOIN"))  && ((substr($line, 0, 5)==":wsr!") or (substr($line, 0, 7)==":lsass!") or (substr($line, 0, 7)==":Rain0!"))) {
    	fwrite($socket, "PRIVMSG #c14 : Друг пришел!!!!\n");
    } elseif (stristr($line, "JOIN :#")) {
    	$name = explode("!", $line);
    	$name[0]=substr($name[0], 1, strlen($name[0])-1);
    	if ($name[0]==$bot['nick']) {
    		$fhandle = file($config['hello']);
    		$x=rand(0, sizeof($fhandle)-1);
    		fwrite($socket, "PRIVMSG #c14 : ".$fhandle[$x]."\n");
    	} else {
    		fwrite($socket, "PRIVMSG #c14 : 4Приветствую ".$name[0]." !!!! Как дела ?\n");
    	}
    }

	if (stristr($line, ":!дата")) {
		fwrite($socket, "PRIVMSG #c14 : Текущая дата: ".$mese[$mesnum]." ".date("d")." ".$giorno[$gisett]."\n");
	}

	if (stristr($line, ":!время")) {
		fwrite($socket, "PRIVMSG #c14 : Текущее время: ".date("H:i:s")."\n");
	}

	if (stristr($line, ":!новости")) {
		output_news();
	}

	if (stristr($line, ":!хелп")) {
		output_help();
	}

	if (stristr($line, ":!мылить")) {
		msg_mail($line);
	}

	if (stristr($line, ":!версия")) {
		fwrite($socket, "PRIVMSG #c14 : Текущая версия DooM'а: ".$bot['version']."\n");
	}

	if (stristr($line, ":!прокси")) {
		proxy();
	}

	if (stristr($line, ":!фраз")) {
    	$random = file($config['fraz']);
    	$z=rand(0, sizeof($random)-1);
    	fwrite($socket, "PRIVMSG #c14 : ".$random[$z]."\n");
    }

    if (stristr($line, ":!цитата")) {
    	$show_quote();
    }

	if (stristr($line, "KICK #c14 DooM")) {
		join_channel();
	}

	#### Пишем логи ####

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
    		$content = date("[H:i:s]")." На канал пришёл: ".$name."\n";
    		fwrite($log, $content);
		}

		if(stristr($line, "QUIT :")) {
			$fuck = explode("!", $line);
    		$name = substr($fuck[0], 1, strlen($fuck[0])-1);
    		$content = date("[H:i:s]")." С какала ушёл: ".$name."\n";
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
		fwrite($socket, "PRIVMSG #c14 : Тема: ".$mas[$i][0]."\n");
		fwrite($socket, "PRIVMSG #c14 : Дата: ".$mas[$i][1]."\n");
		fwrite($socket, "PRIVMSG #c14 : Новость: ".$mas[$i][2]."\n");
		fwrite($socket, "PRIVMSG #c14 : Автор: ".$mas[$i][3]."\n");
		sleep(2);
	}
}

function output_help() {
	global $socket;
	fwrite($socket, "PRIVMSG #c14 : Доступные комманды для DooM:\n");
	fwrite($socket, "PRIVMSG #c14 : !новости - берёт последние три новости с сайта lock-team.org\n");
	fwrite($socket, "PRIVMSG #c14 : !дата    - выводит текущую дату\n");
	fwrite($socket, "PRIVMSG #c14 : !время   - выводит текущее время\n");
	fwrite($socket, "PRIVMSG #c14 : !хозяин  - имя создателя бота\n");
	fwrite($socket, "PRIVMSG #c14 : !версия  - доступная версия\n");
	fwrite($socket, "PRIVMSG #c14 : !прокси  - выдаёт список анонимных прокси на день\n");
	fwrite($socket, "PRIVMSG #c14 : !хелп    - то что вы читаете в данный момент\n");
	fwrite($socket, "PRIVMSG #c14 : !мылить  - например !мылить support@microsoft.com ПРИВЕТ_БИЛЛ\n");
	fwrite($socket, "PRIVMSG #c14 : !фраз    - говорит всякую чушь\n");
	fwrite($socket, "PRIVMSG #c14 : !пшёлнах - выгоняет бота из сети (доступно только для хозяина и друзей)\n");
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
        if (($sux[3]==":!мылить") && (!empty($sux[4])) && (!empty($sux[5]))) {
                if (mail($sux[4], "MSG from IRC (C14) [".$nick[0].":]", $sux[5], $headers)) {
                        fwrite($socket, "PRIVMSG #c14 : to: ".$sux[4]." отправлено\n");
                } else {
                        fwrite($socket, "PRIVMSG #c14 : to: ".$sux[4]." неотправлено\n");
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