<?php

function ip_addr ( ) {
         if ( $ip = getenv ( "HTTP_CLIENT_IP" ) )
            return $ip;

         if ( $ip = getenv ( "HTTP_X_FORWARDED_FOR" ) ) {
            if ( $ip == '' || $ip == "unknown" )
               $ip = getenv ( "REMOTE_ADDR" );
            return $ip;
         }

         if ( $ip = getenv ( "REMOTE_ADDR" ) )
            return $ip;
}

function counter ( ) {

         $date = date ( "d.m.Y", time ( ) );
         $faqq = "./counter.txt"; //Файл со статистикой посещений сайта!!!
	 if ( is_file ( $faqq ) ) {
            $f = file($faqq);
            list ($d, $totalhits, $hits, $totalhosts, $hosts) = explode("|", $f[0]);
         } else {
            $mak = fopen ( $faqq, "w+" );
            flock ( $mak, LOCK_EX );
            fputs ( $mak, "" );
            flock ( $mak, LOCK_UN );
            fclose ( $mak );
            $d = $date;
            $totalhits = 0;
            $hits = 0;
            $totalhosts = 0;
            $hosts = 0;
         }

         if ( $d != $date ) {
            $d = $date;
            $hits = 0;
            $hosts = 0;
            $erase = fopen ( "./ip.txt", "w+" );
            flock ( $erase, LOCK_EX );
            fputs ( $erase, "" );
            flock ( $erase, LOCK_UN );
            fclose ( $erase );
         }

         $fadd = "./ip.txt"; //Файл с ip_addr ( )'шниками пользователей!!!
         if ( is_file ( $fadd ) ) {
            $fo = fopen ( $fadd, "r" );
            flock ( $fo, LOCK_SH );
            $data = fread ( $fo, filesize ( $fadd ) );
            flock ( $fo, LOCK_UN );
            fclose ( $fo );
         } else{
            $makip = fopen ( $fadd, "w+" );
            flock ( $makip, LOCK_EX );
            fputs ( $makip, "" );
            flock ( $makip, LOCK_UN );
            fclose ( $makip );
            $data = " ";
         }

         if ( !stristr ( $data, ip_addr ( ) ) ) {
            $file = fopen ( $fadd, "a+" );
            flock ( $file, LOCK_EX );
            fputs ( $file, ip_addr ( ) ."\n" );
            flock ( $file, LOCK_UN );
            fclose ( $file );
            $totalhits++;
            $hits++;
            $totalhosts++;
            $hosts++;
         } else	{
            $totalhits++;
            $hits++;
         }

         $wfile = fopen ( $faqq, "w+" );
         flock ( $wfile, LOCK_EX );
         fputs ( $wfile, $d."|".$totalhits."|".$hits."|".$totalhosts."|".$hosts );
         flock ( $wfile, LOCK_UN );
         fclose ( $wfile );

         Header ( "Content-Type: image/gif" );
         $image = ImageCreateFromGIF ( "./img.gif" );
         $white = ImageColorAllocate ( $image, 255, 255, 255 );
         $yellow = ImageColorAllocate ( $image, 128, 128, 0 );
         $font_width = ImageFontWidth ( 3 );

         $tthi =  76 - ( $font_width * strlen ( $totalhits ) ) / 2;
         imageString ( $image, 1, $tthi, 20, $totalhits, $white );

         $hi = 76 - ( $font_width * strlen ( $hits ) ) / 2;
         imageString ( $image, 1, $hi, 28, $hits, $white );

         $ttho = 76 - ( $font_width * strlen ($totalhosts ) ) / 2;
         imageString ( $image, 1, $ttho, 46, $totalhosts, $white );

         $ho = 76 - ( $font_width * strlen ( $hosts ) ) / 2;
         imageString ( $image, 1, $ho, 54, $hosts, $white );
	
         ImageGIF ( $image );
         ImageDestroy ( $image );

}
counter ( );

?> 