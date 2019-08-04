<?php
$ar = "Music";
$dir = opendir($ar);
$fp = fopen ("Music/Artists.txt", "a+");
while ($file = readdir($dir)):
       if (eregi("\.mp3$", $file)):
           list ($base, $o1) = explode(" - ", $file);
           if (is_dir($ar."/".$base)){
               copy ($ar."/".$file, $ar."/".$base."/".$file);
               if (file_exists($ar."/".$base."/".$file) and (filesize($ar."/".$base."/".$file) == filesize($ar."/".$file))) unlink ($ar."/".$file);
           }else{
               if (!empty($base)):
                    mkdir ($ar."/".$base);
                    copy ($ar."/".$file, $ar."/".$base."/".$file);
                    if (file_exists($ar."/".$base."/".$file) and (filesize($ar."/".$base."/".$file) == filesize($ar."/".$file))) unlink ($ar."/".$file);
                    fputs ($fp, $base."\n");
               endif;
           }
       endif;
endwhile;
fclose($fp);
closedir($dir);
?>