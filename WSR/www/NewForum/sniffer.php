<?php
extract($HTTP_GET_VARS);
extract($HTTP_POST_VARS);
extract($HTTP_COOKIE_VARS);
extract($HTTP_SERVER_VARS);
//этот фрагмент кода был позаимствован
//из системы PHP Nuke ;)
//далее объявляю переменные
$maxVisitors=30; //количество записей, отображаемых
//при просмотре статистики
$cookieName="visitorOfMySite"; //имя куки
$cookieValue="1"; //значение куки
$timeLimit=0; //срок в секундах, который должен
//пройти с момента последнего посещения сайта, что бы
//информация о посетителе записалась повторно. Это
//значение равно 1 дню, т.е. один и тот же посетитель
//записывается в статистику раз в одни сутки. Если
//эту переменную приравнять к нулю, то будут учитываться
//все посещения одного и того же посетителя
//далее следуют переменные, отвечающие за отображение
//статистики
$headerColor="#808080";
$headerFontColor="#FFFFFF";
$fontFace="Arial, Times New Roman, Verdana";
$fontSize="1";
$tableColor="#000000";
$rowColor="#CECECE";
$fontColor="#0000A0";
$textFontColor="#000000";
//все переменные подготовлены.
//Функция записи данных о посетителе

 $curTime=date("d.m.Y @ H:i:s"); //текущее время и дата
 //подготавливаю данные для записи
 if (empty($HTTP_USER_AGENT)) {$HTTP_USER_AGENT = "Unkwnown";}
 if (empty($REMOTE_ADDR)) {$REMOTE_ADDR = "Not Resolved";}
 if (empty($REMOTE_HOST)) {$REMOTE_HOST = "Unknown";}
 if (empty($HTTP_REFERER)) {$HTTP_REFERER = "No Referer";}
 if (empty($REQUEST_URI)) {$REQUEST_URI = "Unknown";}
 $data_ = $HTTP_USER_AGENT."::".$REMOTE_ADDR."::".$REMOTE_HOST."::".$HTTP_REFERER."::".$REQUEST_URI."::".$curTime."\r\n";
//разделителем будут два ":"
//далее пишу в файл
 $fp = fopen($fileName, "a+b");
 fputs ($fp, $data_);
 fclose ($fp);
?>
