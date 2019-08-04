<?php

function from_dir($basedir){
         $basedir = "i:\Myzûka\Music from DEN".$basedir;
         $dor = opendir ($basedir);
         $fp = fopen("Music.m3u", "a+");
         while ($file = readdir($dor)):
                if (eregi("\.mp3$",$file)):
                   $bezmp3 = ereg_replace("\.mp3$", "", $file);
                   fputs($fp, "#EXTINF:,".$bezmp3."\n");
                   fputs($fp, $basedir."/".$file."\n");
                endif;
         endwhile;
         fclose($fp);
         closedir($dor);
}

$fp = fopen ("Music.m3u", "w+");
fputs ($fp, "#EXTM3U\n");
fclose ($fp);
$dir = opendir("Music");
while ($f = readdir($dir)):
      if (eregi ("^\.+$", $f)){}
      elseif (eregi ("\.ini$", $f)){}
      elseif (eregi ("\.txt$", $f)){}
      elseif (eregi ("\.mp3$", $f)){}      
      else from_dir($f);
endwhile;
closedir($dir);

if (exec("i:\\Music.m3u")){
    exit;
}else{
    exit;
}

?>