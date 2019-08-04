<?php
define("TEST_URI",  "/Test");
define("DOC_URI",   "/Docs");
define("TOOLS_URI", "/Tools");

#
# Общеупотребительные функции.
#


# Возвращает заголовок для указанной директории.
# Ищет по файлам index.* или, если в директории только один файл, в нем.
# Возвращает array($fname, $title)
function extractTitle($uri) { 
  $dir=Url2Path($uri);
  $cont = array();
  $d=opendir($dir); if(!$d) return;
  while($i=readdir($d)) if($i[0]!='.') $cont[]=$i;
  closedir($d);
  sort($cont);
  # No one file - no title.
  if(!count($cont)) return;
  foreach($cont as $fname) {
    if(!preg_match("{^index\\.([^.]+|html\.html)\$}i",$fname)) continue;
    $t=extractFileTitle("$uri/$fname");
    if($t) return $t;
  }
  # Index not found, get first.
  return extractFileTitle("$uri/$cont[0]");
}

# Возвращает заголовок в файле $fname или undef.
function extractFileTitle($uri) {
  $fname=Url2Path($uri);
  if(!@is_file($fname)) return;
  $f=join("",file($fname));

  $data = array();
  $data['uri'] = $data['url'] = $uri;

  if(preg_match("|\\\$TITLE\s*=\s*['\"](.*?)['\"]|is",$f,$p)) {
    $data['title'] = preg_replace("|\\.\s+.*|s","",$p[1]);
  } else if (preg_match("|<\s*title\s*>(.*?)<\s*/title\s*>|is",$f,$p)) {
    $data['title'] = preg_replace("|\\.\s+.*|s","",$p[1]);
  } else {
    return;
  }
  
  if(preg_match("|<\s*meta\s+http-equiv\s*=\s*refresh\s*content\s*=\s*['\"][^>\"']+url\s*=\s*([^>\"']+)|is",$f,$p)) {
    if(!strpos($p[1],"<"."?")) $data['url']=$p[1];
  }

  if(preg_match("|<!--\s*order\s*=\s*([^\s-]+)\s*-->|is",$f,$p)) {
    $data['order']=$p[1];
  }

  if(preg_match("|<!--\s*comment\s*=\s*(.*?)-->|is",$f,$p)) {
    $data['comment']=$p[1];
  }
  
  if(substr(@$data['url'],0,1)=="/") $data['url']="http://{$_SERVER['HTTP_HOST']}".$data['url'];

  return $data;
}

function getAllXxx($uri) {
  $dir=Url2Path($uri);
  $arr=array();
  for($d=opendir($dir); $e=readdir($d); ) {
    if($e=="." || $e==".." || $e[0]=="!" || !@is_dir($e)) continue;
    $data = extractTitle("$uri/$e"); if(!$data) continue;
    $arr[]=$data;
  }
  usort($arr, create_function('$a, $b', '{ return strcasecmp(@$a[order]?@$a[order]:"zzzzzz", @$b[order]?@$b[order]:"zzzzzz"); }'));
  return $arr;
}

# Возвращает информацию обо всех скриптах тестирования.
function getAllTests() {
  return getAllXxx(TEST_URI);
}

# Возвращает информацию обо всей документации.
function getAllDocs() {
  return getAllXxx(DOC_URI);
}

# Возвращает информацию обо всей документации.
function getAllTools() {
  return getAllXxx(TOOLS_URI);
}

// Функция преобразует указанный относительный путь в абсолютный.
// Если путь уже является абсолютным (то есть, отсчитывается от корневого 
// каталога системы), то с ним ничего не происходит, в противном случае
// используется имя текущей директории (или заданной в $cur) с необходимыми 
// преобразованиями. Существование файла с полученным полным именем не 
// проверяется. Функция лишена некоторых недостатков встроенной в 
// PHP realpath() и имеет по сравнению с ней несколько большие возможности, 
// работая, правда, чуть медленнее.
function abs_path($name,$cur="")
{ // Очищаем путь от лишних символов и обратных слэшей
  $name=strtr(trim($name),"\\","/");
  // Сначала разбиваем путь по знакам "/"
  $Parts=explode("/",$name);
  $Path=($cur===""?getcwd():$cur); // начальная директория поиска
  foreach($Parts as $i=>$s) if($s!=".") { 
    // Признак корневой директории?
    if(!$i && (strlen($s)>1&&$s[1]==":"||$s=="")) $Path=$s;
    // Ссылка на родительский каталог?
    else if($s=="..") {
      // Если это уже корневой каталог, то куда спускаться?..
      if(strlen($Path)>1 && $Path[1]==":" && strlen($Path)<=3 || $Path=="/" || $Path=="\\") continue;
      // Иначе используем dirname()
      $p=dirname($Path); 
      if($p=="/"||$p=="\\"||$p==".") $Path=""; else $Path=$p;
    }
    // Иначе просто имя очередного каталога
    else if($s!=="") $Path=glue_path($Path,$s);
  }   
  return ($Path!==""?$Path:"/");
}

// Преобразует URL в абсолютный файловый путь.
// То есть, если он начинается со слэша, то рзультат рассматривается относительно 
// директории DOCUMENT_ROOT, а если нет - то относительно dirname($SCRIPT_NAME).
// Конечно, функция не безупречна (например, она не умеет обрабатывать URL, 
// заданные Alias-директивами Apache, но в большинстве случаев это и не нужно. 
function Url2Path($name)
{ $curUrl=dirname($_SERVER["SCRIPT_NAME"]);
  $url=abs_path(trim($name),$curUrl);
  return getenv("DOCUMENT_ROOT").$url;
}

// "Склеивает" полный путь из компонент $dir и $fname, правильно 
// обрабатывая лишние слэши (например, в конце $dir или в начале $fname).
function glue_path($dir,$fname)
{ $dir=strtr(trim($dir),"\\","/");
  $name=strtr(trim($fname),"\\","/");
  if(@($fname[0]=='//')) return $fname;
  if(@($dir[strlen($dir)-1]=='/')) return $dir.$fname;
  return "$dir/$fname";
}


?>