<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class MISC {

      function mtime ( ) {

               list ( $msec, $sec ) = explode( " ", microtime ( ) );
               return $sec + $msec;

      }

      function echo_r ( $str ) {

               print "<pre class=\"por\">";
               print_r ( $str );
               print "</pre>";

      }

      function browser ( ) {
               static $is;
               if ( !is_array ( $is ) ) {
                  $useragent = strtolower ( getenv ( "HTTP_USER_AGENT" ) );
                  $is = array (
                               "opera" => 0,
                               "ie" => 0,
                               "mozilla" => 0,
                               "firebird" => 0,
                               "firefox" => 0,
                               "camino" => 0,
                               "konqueror" => 0,
                               "safari" => 0,
                               "webkit" => 0,
                               "webtv" => 0,
                               "netscape" => 0,
                               "mac" => 0
                  );

                  // detect opera
                  # Opera/7.11 (Windows NT 5.1; U) [en]
                  # Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.0) Opera 7.02 Bork-edition [en]
                  # Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 4.0) Opera 7.0 [en]
                  # Mozilla/4.0 (compatible; MSIE 5.0; Windows 2000) Opera 6.0 [en]
                  # Mozilla/4.0 (compatible; MSIE 5.0; Mac_PowerPC) Opera 5.0 [en]
                  if ( strpos ( $useragent, "opera" ) !== FALSE ) {
                     preg_match ( "#opera(/| )([0-9\.]+)#", $useragent, $regs );
                     if ( isset ( $regs[2] ) and !empty ( $regs[2] ) ) {
                        $is["opera"] = $regs[2];
                     }
                  }

                  // detect internet explorer
                  # Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Q312461)
                  # Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.0.3705)
                  # Mozilla/4.0 (compatible; MSIE 5.22; Mac_PowerPC)
                  # Mozilla/4.0 (compatible; MSIE 5.0; Mac_PowerPC; e504460WanadooNL)
                  if ( strpos ( $useragent, "msie ") !== FALSE AND !$is["opera"] ) {
                     preg_match ( "#msie ([0-9\.]+)#", $useragent, $regs );
                     if ( isset ( $regs[1] ) and !empty ( $regs[1] ) ) {
                        $is["ie"] = $regs[1];
                     }
                  }

                  // detect macintosh
                  if ( strpos ( $useragent, "mac" ) !== FALSE ) {
                     $is["mac"] = 1;
                  }

                  // detect safari
                  # Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/74 (KHTML, like Gecko) Safari/74
                  # Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/51 (like Gecko) Safari/51
                  if ( strpos ( $useragent, "applewebkit") !== FALSE AND $is["mac"] ) {
                     preg_match ("#applewebkit/(\d+)#", $useragent, $regs );
                     if ( isset ( $regs[1] ) and !empty ( $regs[1] ) ) {
                        $is["webkit"] = $regs[1];
                     }

                     if ( strpos ( $useragent, "safari" ) !== FALSE ) {
                        preg_match ("#safari/([0-9\.]+)#", $useragent, $regs );
                        if ( isset ( $regs[1] ) and !empty ( $regs[1] ) ) {
                           $is["safari"] = $regs[1];
                        }
                     }
                  }

                  // detect konqueror
                  # Mozilla/5.0 (compatible; Konqueror/3.1; Linux; X11; i686)
                  # Mozilla/5.0 (compatible; Konqueror/3.1; Linux 2.4.19-32mdkenterprise; X11; i686; ar, en_US)
                  # Mozilla/5.0 (compatible; Konqueror/2.1.1; X11)
                  if ( strpos ( $useragent, "konqueror") !== FALSE ) {
                     preg_match ("#konqueror/([0-9\.-]+)#", $useragent, $regs );
                     if ( isset ( $regs[1] ) and !empty ( $regs[1] ) ) {
                        $is["konqueror"] = $regs[1];
                     }
                  }

                  // detect mozilla
                  # Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.4b) Gecko/20030504 Mozilla
                  # Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.2a) Gecko/20020910
                  # Mozilla/5.0 (X11; U; Linux 2.4.3-20mdk i586; en-US; rv:0.9.1) Gecko/20010611
                  if ( strpos ( $useragent, "gecko" ) !== FALSE AND !$is["safari"] AND !$is["konqueror"] ) {
                     preg_match ("#gecko/(\d+)#", $useragent, $regs );
                     if ( isset ( $regs[1] ) and !empty ( $regs[1] ) ) {
                        $is["mozilla"] = $regs[1];
                     }

                     // detect firebird / firefox
                     # Mozilla/5.0 (Windows; U; WinNT4.0; en-US; rv:1.3a) Gecko/20021207 Phoenix/0.5
                     # Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6
                     # Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4a) Gecko/20030423 Firebird Browser/0.6
                     # Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.6) Gecko/20040206 Firefox/0.8
                     if ( strpos ( $useragent, "firefox") !== FALSE OR strpos ( $useragent, "firebird" ) !== FALSE OR strpos ( $useragent, "phoenix" ) !== FALSE ) {
                        preg_match ( "#(phoenix|firefox|firebird)( browser)?/([0-9\.]+)#", $useragent, $regs );

                        if ( isset ( $regs[1] ) and $regs[1] == "firefox" ) {
                           if ( isset ( $regs[3] ) and !empty ( $regs[3] ) ) {
                              $is["firefox"] = $regs[3];
                           }
                        }

                        if ( isset ( $regs[1] ) and $regs[1] == "firebird" ) {
                           if ( isset ( $regs[3] ) and !empty ( $regs[3] ) ) {
                              $is["firebird"] = $regs[3];
                           }
                        }
                        
                     }


                     // detect camino
                     # Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-US; rv:1.0.1) Gecko/20021104 Chimera/0.6
                     if ( strpos ( $useragent, "chimera") !== FALSE OR strpos ( $useragent, "camino" ) !== FALSE ) {
                        preg_match ( "#(chimera|camino)/([0-9\.]+)#", $useragent, $regs );
                        if ( isset ( $regs[2] ) and !empty ( $regs[2] ) ) {
                           $is["camino"] = $regs[2];
                        }
                     }
                  }

                  // detect web tv
                  if ( strpos ( $useragent, "webtv" ) !== FALSE ) {
                     preg_match ( "#webtv/([0-9\.]+)#", $useragent, $regs );
                     if ( isset ( $regs[1] ) and !empty ( $regs[1] ) ) {
                        $is["webtv"] = $regs[1];
                     }
                  }

                  // detect pre-gecko netscape
                  if ( preg_match ( "#mozilla/([1-4]{1})\.([0-9]{2}|[1-8]{1})#", $useragent, $regs ) ) {
                     if ( isset ( $regs[1] ) and !empty ( $regs[1] ) and isset ( $regs[2] ) and !empty ( $regs[2] ) ) {
                        $is["netscape"] = $regs[1].$regs[2];
                     }
                  }
               }

               $browser = "Unknown";
               $version = "Unknown";
               
               if ( $is["opera"] !== 0 ) {
                  $browser = "Opera";
                  $version = $is["opera"];
               } elseif ( $is["ie"] !== 0 ) {
                  $browser = "IE";
                  $version = $is["ie"];
               } elseif ( $is["mozilla"] !== 0 ) {
                  if ( $is["firebird"] !== 0 or $is["firefox"] !== 0 or $is["camino"] !== 0 ) {
                     if ( $is["firebird"] == $is["firefox"] ) {
                        $browser = "Mozilla";
                        $version = $is["firefox"];
                     } else {
                        if ( $is["firebird"] !== 0 ) {
                           $browser = "Mozilla FireBird";
                           $version = $is["firebird"];
                        } elseif ( $is["firefox"] !== 0 ) {
                           $browser = "Mozilla FireFox";
                           $version = $is["firefox"];
                        } else {
                           $browser = "Camino";
                           $version = $is["camino"];
                        }
                     }
                  } else {
                     $browser = "Mozilla";
                     $version = $is["mozilla"];
                  }
               } elseif ( $is["konqueror"] !== 0 ) {
                  $browser = "Konqueror";
                  $version = $is["konqueror"];
               } elseif ( $is["webkit"] !== 0 ) {
                  if ( $is["safari"] !== 0 ) {
                     $browser = "Safari";
                     $version = $is["safari"];
                  } else {
                     $browser = "AppleWebKit";
                     $version = $is["webkit"];
                  }
               } elseif ( $is["webtv"] !== 0 ) {
                  $browser = "WebTv";
                  $version = $is["webtv"];
               } elseif ( $is["netscape"] !== 0 ) {
                  $browser = "Netscape Navigator";
                  $version = $is["netscape"];
               } elseif ( $is["mac"] !== 0 ) {
                  $browser = "Mac";
                  $version = $is["mac"];
               }

               $result = array ( "browser" => $browser, "version" => $version );
               return $result;

      }

}

function is_valid_email($email)
{
// checks for a valid email format
return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email);
}


?>