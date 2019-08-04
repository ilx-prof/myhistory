<?php
$ar = $_POST['papca'];
$dir = opendir($ar);
$fp = fopen ("E:\\Myzûka\\Music from DEN\\1.txt", "w");
while ($file = readdir($dir)):
       if (eregi("\.mp3$", $file)):
           list ($base, $dir) = explode(" - ", $file);
           if (is_dir($ar."\\".$base)){
               copy ($ar."\\".$file, $ar."\\".$base."\\".$file);
               if (file_exists($ar."\\".$base."\\".$file) and (filesize($ar."\\".$base."\\".$file) == filesize($ar."\\".$file))) unlink ($ar."\\".$file);
           }
		   else{
               if (!empty($base)):
                    mkdir ($ar."\\".$base);
                    copy ($ar."\\".$file, $ar."\\".$base."\\".$file);
                    if (file_exists($ar."\\".$base."\\".$file) and (filesize($ar."\\".$base."\\".$file) == filesize($ar."\\".$file))) unlink ($ar."\\".$file);
                    fputs ($fp, $base."\n");
               endif;
           }
       endif;
endwhile;
fclose($fp);
closedir($dir);
?>