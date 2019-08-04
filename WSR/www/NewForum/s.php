<?
 ############################################################################
 # WFSearch Engine by jID     Version 0.8 (PHP4) (09 jan 2003)              #
 # Copyright (C) jID, 2002-2003                                             #
 #               Jean-Charles Meyrignac 2003                                #
 #                                                                          #
 # Search unit :: Модуль поиска                                             #
 ############################################################################

require ("config.php");
require ("language/".$languagefile);

$time=explode(' ', microtime());
$start_time=$time[1]+$time[0];

// Функция возвращает:
//
// 0=неавторизированный доступ к файлу
// 1=в файле нельзя вести поиск
// 2=файл годится для поиска
function IsAllowed($f)
{
  global $allowed_names, $disallowed_names;
  for ($i=0; $i<count($disallowed_names); ++$i)
    if (stristr(realpath($f), $disallowed_names[$i])) return 0;
  for ($i=0; $i<count($allowed_names); ++$i)
    if (stristr(realpath($f), $allowed_names[$i])) return 2;
  return 1;
}

// Проверка буфера на совпадение с запросом
function FindQuery($buffer)
{
  global $query, $m;
  $t=explode(" ", $query);
   if ($m=="or")
   {
     for ($j=0; $j<count($t); ++$j)
     {
       if (stristr($buffer, $t[$j])) return 1;
       $key=htmlentities($t[$j]);
       if ($key!=$t[$j])
       {
         if (stristr($buffer, $key)) return 1;
       }
     }
     return 0;
   } else
   {
     for ($j=0; $j<count($t); ++$j)
       if (!stristr($buffer, $t[$j]))
       {
         $key=htmlentities($t[$j]);
         if ($key!=$t[$j])
         {
           if (!stristr($buffer, $key)) return 0;
         } else
         {
           return 0;
         }
       }
     return 1;
   }
}

// Первый проход: мы строим список всех файлов, удволетворяющих условиям
function countdirs($dirname)
{
  global $filesearch;
  $dir=opendir(".");
  while(($f=readdir($dir))!==false)
  {
    if (is_dir($f))
    {
      if (($f!=".") && ($f!=".."))
      {
        if (IsAllowed($f))
        {
          chdir($f);
          countdirs($dirname."/".$f);
          chdir("..");
        }
      }
    } else
    {
      $n=IsAllowed($f);
      if ($n)
      {
        // Имя файла совпадает с запросом ?
        if (FindQuery($f))
        {
          $filesearch[] = $dirname.'/'.$f;
        } else
        if ($n==2)
        {
          // Содержимое совпадает с запросом ?
          $fd=fopen($f,"r");
          $buffer=fread($fd, filesize($f));
          fclose($fd);
          if (FindQuery($buffer))
          {
            $filesearch[] = $dirname.'/'.$f;
          }
        }
      }
    }
  }
  closedir($dir);
}

// Второй проход: обрабатываем файл
function Render($dirname, $filenumber)
{
  global $rootdir, $query, $m, $from, $showed, $pages, $color1, $color2, $explodestring, $maxoccurrences, $desc_header, $desc_footer, $lang_bytes, $interface_all;
  $f=$rootdir.$dirname;
  ++$showed;
  if ($showed&1)
    echo "<tr><td bgcolor=$color2>";
  else
    echo "<tr><td bgcolor=$color1>";
  echo str_replace("%1", $filenumber, $interface_all);
  echo "<a href=\"$dirname\">$dirname</a> ";
  echo filesize($f)." $lang_bytes, ".date("d M Y", filectime($f)).". ";

  if (IsAllowed($dirname)==2)
  {
    $fc=file($f);
    $filet=join("", $fc);
    if (preg_match("/<title.*>(.*)<\/title.*>/isU", $filet, $match))
    {
      // показать заголовок
      echo trim($match[1]);
    }
    // показать содержимое
    //$s=implode($fc, $explodestring);
    //$s=strip_tags($s);
    $fc=explode($explodestring, $s);
    $q=explode(" ",$query);
    $occurrence=0;
    echo "<br>$desc_header";
    for ($i=0; $i<count($fc); ++$i)
    {
      $occ=0;
      $s=strtolower(strip_tags($fc[$i]));
      for ($j=0; $j<count($q); ++$j)
      {
        if (stristr($s, $q[$j]))
        {
          $s=str_replace($q[$j], "<b>$q[$j]</b>", $s);
          $occ=1;
        }
        else
        {
          $key=htmlentities($q[$j]);
          if (stristr($s, $key))
          {
            $s=str_replace($key, "<b>$key</b>", $s);
            $occ=1;
          }
        }
      }
      if ($occ)
      {
        $occ=0;
        echo "...$s...";
        ++$occurrence;
        if ($occurrence > $maxoccurrences) break;
      }
    }
    echo $desc_footer;
  }
  echo "</td></tr>\n";
}

// Вывести панель навигации
function DisplayNavbar($all)
{
  global $PHP_SELF;
  global $color0, $pages, $query, $m, $search_separator;
  echo "<tr bgcolor=$color0><td align=center>";
  for ($k=1; $k<=$all; $k+=$pages)
  {
    if ($k!=1) echo $search_separator;
    echo "<a href=$PHP_SELF?query=".urlencode($query)."&m=$m&from=$k>$k-";
    if ($k+$pages>$all) echo $all; else echo ($k-1+$pages);
    echo "</a>";
  }
  echo "</td></tr>\n";
}

// ****************************> MAIN CODE <*********************************
if (!isset($from)) $from=1;
if (!isset($query)) $query="";
$query=strtolower(trim(strip_tags($query)));

place_header();

if ($query!="")
{
  $rootdir=$DOCUMENT_ROOT;
  unset($filesearch);
  countdirs($start_search);
  $time=explode(' ', microtime());
  $seconds=($time[1]+$time[0]-$start_time);
  $all=count($filesearch);
  if ($all>0)
  {
    echo "<center>".str_replace("%2", sprintf("%01.3f", $seconds), str_replace("%1", $all, $lang_wasfound))."<br></center>\n";
    echo "<table width=95% cellspacing=0 cellpadding=1>\n";
    $showed=0;
    DisplayNavbar($all);
    for($i=$from;$i < $from+$pages;++$i)
    {
      if ($i >= $all+1) break;
      Render($filesearch[$i-1], $i);
    }
    DisplayNavbar($all);
    echo "</table>\n";
  }
  else
  {
    echo "<center>".str_replace("%1", sprintf("%01.3f", $seconds), $lang_nofiles)."</center>";
  }
}
$time=explode(' ',microtime());
$seconds=($time[1]+$time[0]-$start_time);
echo "<p align=right><small>".str_replace("%1", sprintf("%01.3f", $seconds), $lang_generated)."</small></p>";
place_footer();
?>
