<?php

class WEB_TOOLS {

      var $data = array ( );

      function show_encode_form ( ) {

               $result = "";
               $result .= "
                           <center class=porr>Шифрование текста/файла : </center>
                           <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">
                           <form method=\"POST\" enctype=\"multipart/form-data\">
                           <tr>
                               <td colspan=\"3\">
                                   <b class=por>Source String :</b><br>
                                   <textarea class=\"button\" style=\"width : 100%; background : white; height : 80px;\" name=\"source_string\">". ( isset ( $_POST["source_string"] ) ? htmlspecialchars ( $_POST["source_string"], ENT_QUOTES ) : "" ) ."</textarea><br>
                                   <b class=por>Source <b class=porr>file</b> :</b><br>
                                   <input type=\"HIDDEN\" name=\"MAX_FILE_SIZE\" value=\"2097152\">
                                   <input type=\"FILE\" name=\"file\" style=\"height : 19px;\"><b class=porr> - размер файла не больше 2мб.</b><br><br>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <input type=\"CHECKBOX\" name=\"crc32\" ". ( ( isset ( $_POST["crc32"] ) and $_POST["crc32"] ) ? "checked" : "" ) ."><b class=por> - CRC32 </b><br>
                               </td>
                               <td>
                                   <input type=\"CHECKBOX\" name=\"md5\" ". ( ( isset ( $_POST["md5"] ) and $_POST["md5"] ) ? "checked" : "" ) ."><b class=por> - MD5 </b><br>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <input type=\"CHECKBOX\" name=\"backwords\" ". ( ( isset ( $_POST["backwords"] ) and $_POST["backwords"] ) ? "checked" : "" ) ."><b class=por> - BackWords </b><br>
                               </td>
                               <td>
                                   <input type=\"CHECKBOX\" name=\"md5_file\" ". ( ( isset ( $_POST["md5_file"] ) and $_POST["md5_file"] ) ? "checked" : "" ) ."><b class=por> - MD5 <b class=porr>File</b> </b><br>
                               </td>
                           </tr>
                           <tr>
                               <td><br></td>
                           </tr>
                           <tr>
                               <td>
                                   <input type=\"CHECKBOX\" name=\"enc_dec\" ". ( ( isset ( $_POST["enc_dec"] ) and $_POST["enc_dec"] ) ? "checked" : "" ) ."><b class=porr> - Encode/Decode</b>
                               </td>
                               <td>
                                   <select name=\"encode_decode\" class=\"button\">
                                           <option value=\"url\" ". ( ( isset ( $_POST["encode_decode"] ) and $_POST["encode_decode"] == "url" ) ? "selected" : "" ) .">URL</option>
                                           <option value=\"utf7\" ". ( ( isset ( $_POST["encode_decode"] ) and $_POST["encode_decode"] == "utf7" ) ? "selected" : "" ) .">UTF-7</option>
                                           <option value=\"utf8\" ". ( ( isset ( $_POST["encode_decode"] ) and $_POST["encode_decode"] == "utf8" ) ? "selected" : "" ) .">UTF-8</option>
                                           <option value=\"base64\" ". ( ( isset ( $_POST["encode_decode"] ) and $_POST["encode_decode"] == "base64" ) ? "selected" : "" ) .">Base64</option>
                                           <option value=\"html_entities\" ". ( ( isset ( $_POST["encode_decode"] ) and $_POST["encode_decode"] == "html_entities" ) ? "selected" : "" ) .">HTML Entities</option>
                                           <option value=\"php_highlight\" ". ( ( isset ( $_POST["encode_decode"] ) and $_POST["encode_decode"] == "php_highlight" ) ? "selected" : "" ) .">PHP Highlight</option>
                                   </select>
                               </td>
                               <td>
                                   <b class=porr><input type=\"RADIO\" name=\"type\" value=\"encode\" ". ( ( ( isset ( $_POST["type"] ) and $_POST["type"] == "encode" ) or !isset ( $_POST["type"] ) ) ? "checked" : "" ) ."> - Encode <input type=\"RADIO\" name=\"type\" value=\"decode\" ". ( ( isset ( $_POST["type"] ) and $_POST["type"] == "decode" ) ? "checked" : "" ) ."> - Decode</b>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <input type=\"CHECKBOX\" name=\"systems\" ". ( ( isset ( $_POST["systems"] ) and $_POST["systems"] ) ? "checked" : "" ) ."><b class=porr> - Systems</b>
                               </td>
                               <td>
                                   <select name=\"system\" class=\"button\">
                                           <option value=\"ascii2bin\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "ascii2bin" ) ? "selected" : "" ) .">ASCII to Bin</option>
                                           <option value=\"ascii2oct\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "ascii2oct" ) ? "selected" : "" ) .">ASCII to Oct</option>
                                           <option value=\"ascii2dec\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "ascii2dec" ) ? "selected" : "" ) .">ASCII to Dec</option>
                                           <option value=\"ascii2hex\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "ascii2hex" ) ? "selected" : "" ) .">ASCII to Hex</option>
                                           <option></option>
                                           <option value=\"bin2oct\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "bin2oct" ) ? "selected" : "" ) .">Bin to Oct</option>
                                           <option value=\"bin2dec\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "bin2dec" ) ? "selected" : "" ) .">Bin to Dec</option>
                                           <option value=\"bin2hex\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "bin2hex" ) ? "selected" : "" ) .">Bin to Hex</option>
                                           <option value=\"bin2ascii\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "bin2ascii" ) ? "selected" : "" ) .">Bin to ASCII</option>
                                           <option></option>
                                           <option value=\"oct2bin\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "oct2bin" ) ? "selected" : "" ) .">Oct to Bin</option>
                                           <option value=\"oct2dec\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "oct2dec" ) ? "selected" : "" ) .">Oct to Dec</option>
                                           <option value=\"oct2hex\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "oct2hex" ) ? "selected" : "" ) .">Oct to Hex</option>
                                           <option value=\"oct2ascii\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "oct2ascii" ) ? "selected" : "" ) .">Oct to ASCII</option>
                                           <option></option>
                                           <option value=\"dec2bin\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "dec2bin" ) ? "selected" : "" ) .">Dec to Bin</option>
                                           <option value=\"dec2oct\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "dec2oct" ) ? "selected" : "" ) .">Dec to Oct</option>
                                           <option value=\"dec2hex\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "dec2hex" ) ? "selected" : "" ) .">Dec to Hex</option>
                                           <option value=\"dec2ascii\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "dec2ascii" ) ? "selected" : "" ) .">Dec to ASCII</option>
                                           <option></option>
                                           <option value=\"hex2bin\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "hex2bin" ) ? "selected" : "" ) .">Hex to Bin</option>
                                           <option value=\"hex2oct\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "hex2oct" ) ? "selected" : "" ) .">Hex to Oct</option>
                                           <option value=\"hex2dec\"   ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "hex2dec" ) ? "selected" : "" ) .">Hex to Dec</option>
                                           <option value=\"hex2ascii\" ". ( ( isset ( $_POST["system"] ) and $_POST["system"] == "hex2ascii" ) ? "selected" : "" ) .">Hex to ASCII</option>
                                   </select>
                               </td>
                               <td colspan=\"2\">
                                   <input type=\"TEXT\" class=\"button\" name=\"part\" value=\"". ( ( isset ( $_POST["part"] ) and !empty ( $_POST["part"] ) ) ? htmlspecialchars ( $_POST["part"], ENT_QUOTES ) : " " ) ."\"><b class=porr> - Explode</b>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=\"2\">
                                   <input type=\"CHECKBOX\" name=\"des\" ". ( ( isset ( $_POST["des"] ) and $_POST["des"] ) ? "checked" : "" ) ."><b class=porr> - Des </b>
                               </td>
                               <td>
                                   <input type=\"TEXT\" class=\"button\" name=\"des_salt\" value=\"". ( ( isset ( $_POST["des_salt"] ) and !empty ( $_POST["des_salt"] ) ) ? htmlspecialchars ( $_POST["des_salt"], ENT_QUOTES ) : "" ) ."\"><b class=porr> - Des Salt</b>
                               </td>
                           </tr>
                           <tr>
                               <td align=\"center\" colspan=\"3\">
                                   <br><input type=\"SUBMIT\" class=\"button\" value=\"Шифровать\" style=\"width : 150px;\">
                               </td>
                           </tr>
                           </form>
                           </table>
               ";
               
               return $result;

      }
      
      function encode_string ( ) {

               #####################################
               /* Функции для перекодировки ASCII */
               function Mascii2bin ( $string, $part ) {
                        $result = "";
                        if ( strlen ( $string ) >= 1 )
                           for ( $i = 0; $i < strlen ( $string ); $i++ ) :
                               $b = decbin ( ord ( $string[$i] ) );
                               while ( strlen ( $b ) != 8 )
                                     $b = "0". $b;
                               $result .= $part. $b;
                           endfor;
                        return trim ( $result );
               }

               function Mascii2oct ( $string, $part ) {
                        $result = "";
                        if ( strlen ( $string ) >= 1 )
                           for ( $i = 0; $i <= strlen ( $string ) - 1; $i++ ) :
                               $result .= $part. decoct ( ord ( $string[$i] ) );
                           endfor;
                        return trim ( $result );
               }
               
               function Mascii2dec ( $string, $part ) {
                        $result = "";
                        if ( strlen ( $string ) >= 1 )
                           for ( $i = 0; $i <= strlen ( $string ) - 1; $i++ ) :
                               $result .= $part. ord ( $string[$i] );
                           endfor;
                        return trim ( $result );
               }

               function Mascii2hex ( $string, $part ) {
                        $result = "";
                        if ( strlen ( $string ) >= 1 )
                           for ( $i = 0; $i <= strlen ( $string ) - 1; $i++ ) :
                               $result .= $part. dechex ( ord ( $string[$i] ) );
                           endfor;
                        return strtoupper ( trim ( $result ) );
               }
               #####################################
               
               ######################################
               /* Функции для перекодировки Binary */
               function Mbin2oct ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 2, 8 );
                        endfor;
                        return trim ( $result );
               }

               function Mbin2dec ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 2, 10 );
                        endfor;
                        return trim ( $result );
               }

               function Mbin2hex ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 2, 16 );
                        endfor;
                        return trim ($result );
               }
               
               function Mbin2ascii ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= chr ( bindec ( $src[$i] ) );
                        endfor;
                        return trim ( $result );
               }
               ######################################

               #######################################
               /* Функции для перекодировки Oct (8) */
               function Moct2bin ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 8, 2 );
                        endfor;
                        return trim ( $result );
               }

               function Moct2dec ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 8, 10 );
                        endfor;
                        return trim ( $result );
               }

               function Moct2hex ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 8, 16 );
                        endfor;
                        return trim ( $result );
               }
               
               function Moct2ascii ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= chr ( octdec ( $src[$i] ) );
                        endfor;
                        return trim ( $result );
               }
               #######################################

               ######################################
               /* Функции для кодирования Dec (10) */
               function Mdec2bin ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 10, 2 );
                        endfor;
                        return trim ( $result );
               }

               function Mdec2oct ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 10, 8 );
                        endfor;
                        return trim ( $result );
               }

               function Mdec2hex ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 10, 16 );
                        endfor;
                        return trim ( $result );
               }
               
               function Mdec2ascii ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= chr ( $src[$i] );
                        endfor;
                        return trim ( $result );
               }
               ######################################

               ######################################
               /* Функции для кодирование HEX (16) */
               function Mhex2bin ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 16, 2 );
                        endfor;
                        return trim ( $result );
               }

               function Mhex2oct ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 16, 8 );
                        endfor;
                        return trim ( $result );
               }
               
               function Mhex2dec ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= $part. base_convert ( $src[$i], 16, 10 );
                        endfor;
                        return trim ( $result );
               }
               
               function Mhex2ascii ( $string, $part ) {
                        $src = explode ( $part, $string );
                        $result = "";
                        for ( $i = 0; $i < sizeof ( $src ); $i++ ) :
                            $result .= chr ( hexdec ( $src[$i] ) );
                        endfor;
                        return trim ( $result );
               }
               ######################################
               
               function backwords ( $string ) {
                        return strrev ( $string );
               }
               
               $result = "";

               $result .= ( isset ( $_POST["crc32"] ) and $_POST["crc32"] )         ? "<br><b class=por>CRC32 : </b><br><input class=\"button\" style=\"width : 100%; background : white;\" value=\"" . sprintf ( "%u", crc32 ( $_POST["source_string"] ) ) . "\" readonly><br>" : "";
               $result .= ( isset ( $_POST["md5"] ) and $_POST["md5"] )             ? "<br><b class=por>MD5 : </b><br><input class=\"button\" style=\"width : 100%; background : white;\" value=\"" . md5 ( $_POST["source_string"] ) . "\" readonly><br>" : "";
               $result .= ( isset ( $_POST["backwords"] ) and $_POST["backwords"] ) ? "<br><b class=por>BackWords : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . backwords ( $_POST["source_string"] ) . "</textarea><br>" : "" ;

               ##################################
               /* Конвертация различных систем */
               if ( isset ( $_POST["enc_dec"] ) and $_POST["enc_dec"] and isset ( $_POST["encode_decode"] ) and !empty ( $_POST["encode_decode"] ) and isset ( $_POST["type"] ) and !empty ( $_POST["type"] ) and ( $_POST["type"] == "encode" or $_POST["type"] == "decode" ) ) {
                  if ( $_POST["type"] == "encode" ) {

                     switch ( $_POST["encode_decode"] ) :
                            case "url" :
                                 $result .= "<br><b class=por>URL Encode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . rawurlencode ( $_POST["source_string"] ) . "</textarea><br>";
                            break;
                            case "utf8" :
                                 $result .= "<br><b class=por>UTF-8 Encode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . utf8_encode ( $_POST["source_string"] ) . "</textarea><br>";
                            break;
                            case "base64" :
                                 $result .= "<br><b class=por>Base64 Encode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . base64_encode ( $_POST["source_string"] ) . "</textarea><br>";
                            break;
                            case "html_entities" :
                                 $result .= "<br><b class=por>HTML Entities Encode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . str_replace ( "&", "&amp;", htmlentities ( $_POST["source_string"] ) ) . "</textarea><br>";
                            break;
                            case "php_highlight" :
                                 function str_rpl ( $buf ) {
                                          return htmlspecialchars ( $buf, ENT_QUOTES );
                                 }
                                 ob_start ("str_rpl");
                                 highlight_string ( $_POST["source_string"] );
                                 $string = ob_get_contents ( );
                                 ob_get_clean ( );
                                 $result .= $string ."<Br>";
                                 $result .= "<br><b class=por>PHP Highlight : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . str_replace ( "&", "&amp;", $string ) . "</textarea><br>";
                            break;
                            default :
                                 $result .= "";
                            break;
                     endswitch;

                  } else {
                  
                     switch ( $_POST["encode_decode"] ) :
                            case "url" :
                                 $result .= "<br><b class=por>URL Decode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . htmlspecialchars ( rawurldecode ( $_POST["source_string"] ), ENT_QUOTES ) . "</textarea><br>";
                            break;
                            case "utf8" :
                                 $result .= "<br><b class=por>UTF-8 Decode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . htmlspecialchars ( utf8_decode ( $_POST["source_string"] ), ENT_QUOTES ) . "</textarea><br>";
                            break;
                            case "base64" :
                                 $result .= "<br><b class=por>Base64 Decode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . htmlspecialchars ( base64_decode ( $_POST["source_string"] ), ENT_QUOTES ) . "</textarea><br>";
                            break;
                            case "html_entities" :
                                 $result .= "<br><b class=por>HTML Entities Decode : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . htmlspecialchars ( html_entity_decode ( $_POST["source_string"] ), ENT_QUOTES ) . "</textarea><br>";
                            break;
                            default :
                                 $result .= "";
                            break;
                     endswitch;
                     
                  }
               }
               ##################################

               ##################################
               /* Конвертация различных систем */
               if ( isset ( $_POST["systems"] ) and $_POST["systems"] and isset ( $_POST["system"] ) and !empty ( $_POST["system"] ) ) {
                  if ( isset ( $_POST["part"] ) and !empty ( $_POST["part"] ) ) {
                     $part = htmlspecialchars ( $_POST["part"], ENT_QUOTES );
                  } else {
                     $part = " ";
                  }

                  switch ( $_POST["system"] ) :
                         case "ascii2bin" :
                              $result .= "<br><b class=por>ASCII to Bin : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mascii2bin ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "ascii2oct" :
                              $result .= "<br><b class=por>ASCII to Oct : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mascii2oct ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "ascii2dec" :
                              $result .= "<br><b class=por>ASCII to Dec : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mascii2dec ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "ascii2hex" :
                              $result .= "<br><b class=por>ASCII to Hex : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mascii2hex ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;

                         case "bin2oct" :
                              $result .= "<br><b class=por>Binary to Oct : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mbin2oct ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "bin2dec" :
                              $result .= "<br><b class=por>Binary to Dec : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mbin2dec ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "bin2hex" :
                              $result .= "<br><b class=por>Binary to Hex : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mbin2hex ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "bin2ascii" :
                              $result .= "<br><b class=por>Binary to ASCII : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mbin2ascii ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         
                         case "oct2bin" :
                              $result .= "<br><b class=por>Oct to Bin : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Moct2bin ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "oct2dec" :
                              $result .= "<br><b class=por>Oct to Dec : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Moct2dec ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "oct2hex" :
                              $result .= "<br><b class=por>Oct to Hex : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Moct2hex ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "oct2ascii" :
                              $result .= "<br><b class=por>Oct to ASCII : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Moct2ascii ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         
                         case "dec2bin" :
                              $result .= "<br><b class=por>Dec to Bin : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mdec2bin ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "dec2oct" :
                              $result .= "<br><b class=por>Dec to Oct : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mdec2oct ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "dec2hex" :
                              $result .= "<br><b class=por>Dec to Hez : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mdec2hex ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "dec2ascii" :
                              $result .= "<br><b class=por>Dec to ASCII : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mdec2ascii ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         
                         case "hex2bin" :
                              $result .= "<br><b class=por>Hex to Bin : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mhex2bin ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "hex2oct" :
                              $result .= "<br><b class=por>Hex to Oct : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mhex2oct ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "hex2dec" :
                              $result .= "<br><b class=por>Hex to Dec : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mhex2dec ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         case "hex2ascii" :
                              $result .= "<br><b class=por>Hex to ASCII : </b><br><textarea class=\"button\" style=\"width : 100%; background : white; height : 45px;\" readonly>" . Mhex2ascii ( $_POST["source_string"], $part ) . "</textarea><br>";
                         break;
                         
                         default :
                              $result .= "";
                         break;
                  endswitch;
               }
               ##################################

               #####################
               /* DES Кодирование */
               if ( isset ( $_POST["des"] ) and $_POST["des"] ) {
                  if ( isset ( $_POST["des_salt"] ) and !empty ( $_POST["des_salt"] ) ) {
                     $salt = $_POST["des_salt"];
                  } else {
                     $salt = "";
                  }
                  $result .= "<br><b class=por>DES : </b><br><input class=\"button\" style=\"width : 100%; background : white;\" value=\"" .  crypt ( $_POST["source_string"], $salt ) . "\" readonly><br>";
               }
               #####################

               ########################
               /* Кодирование файлов */
               if ( isset ( $_FILES["file"] ) and ( $_FILES["file"]["error"] === 0 ) ) {

                  if ( is_uploaded_file ( $_FILES["file"]["tmp_name"] ) and $_FILES["file"]["size"] <= 2097152 ) {
                     $result .= ( isset ( $_POST["md5_file"] ) and $_POST["md5_file"] ) ? "<br><b class=por>MD5 <b class=porr>File</b> : </b><br><input class=\"button\" style=\"width : 100%; background : white;\" value=\"" . md5_file ( $_FILES["file"]["tmp_name"] ) . "\" readonly><br>" : "";
                     if ( unlink ( $_FILES["file"]["tmp_name"] ) ) {

                     } else {
                        $result .= "<center class=porr>Файл не удален!</center>";
                     }
                  } else {
                     $result .= "<center class=porr>Файл не может быть загружен!</center>";
                  }
               }
               ########################

               return $result;

      }
      
      function show_password_generator_form ( ) {

               $result = "";
               $result .= "<center class=porr>Генератор паролей : </center>
                           <b class=date>Выбирите составляющие пароля!</b>
                           <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" align=\"center\">
                           <form method=\"POST\">
                           <input type=\"HIDDEN\" name=\"action\" value=\"generate\">
                           <tr>
                               <td width=\"50\" align=\"right\"><input type=\"CHECKBOX\" name=\"allnum\" ". ( ( isset ( $_POST["allnum"] ) and $_POST["allnum"] ) ? "checked" : "" ) ."></td>
                               <td width=\"150\"><b class=por>Цыфры (0-9)</b></td>
                               <td width=\"50\" align=\"right\"><input type=\"CHECKBOX\" name=\"allspec\" ". ( ( isset ( $_POST["allspec"] ) and $_POST["allspec"] ) ? "checked" : "" ) ."></td>
                               <td width=\"150\"><b class=por>Спецсимволы (./?+ и др.)</b></td>
                           </tr>
                           <tr>
                               <td width=\"50\" align=\"right\"><input type=\"CHECKBOX\" name=\"alllatinmin\" ". ( ( isset ( $_POST["alllatinmin"] ) and $_POST["alllatinmin"] ) ? "checked" : "" ) ."></td>
                               <td width=\"150\"><b class=por>Латиница (a-z)</b></td>
                               <td width=\"50\" align=\"right\"><input type=\"CHECKBOX\" name=\"allkirilmin\" ". ( ( isset ( $_POST["allkirilmin"] ) and $_POST["allkirilmin"] ) ? "checked" : "" ) ."></td>
                               <td width=\"150\"><b class=por>Кирилица (а-я)</b></td>
                           </tr>
                           <tr>
                               <td width=\"50\" align=\"right\"><input type=\"CHECKBOX\" name=\"alllatinmax\" ". ( ( isset ( $_POST["alllatinmax"] ) and $_POST["alllatinmax"] ) ? "checked" : "" ) ."></td>
                               <td width=\"150\"><b class=por>Латиница (A-Z)</b></td>
                               <td width=\"50\" align=\"right\"><input type=\"CHECKBOX\" name=\"allkirilmax\" ". ( ( isset ( $_POST["allkirilmax"] ) and $_POST["allkirilmax"] ) ? "checked" : "" ) ."></td>
                               <td width=\"150\"><b class=por>Кирилица (А-Я)</b></td>
                           </tr>
                           <tr>
                               <td colspan=\"2\" align=\"center\" style=\"padding-left : 24px;\"><input type=\"TEXT\" class=\"button\" name=\"my_string\" value=\"". ( ( isset ( $_POST["my_string"] ) and !empty ( $_POST["my_string"] ) ) ? htmlspecialchars ( $_POST["my_string"], ENT_QUOTES ) : "" ) ."\"><b class=porr> Своя строка</b></td>
                               <td width=\"50\" align=\"right\"><input type=\"CHECKBOX\" name=\"with_selected\" ". ( ( isset ( $_POST["with_selected"] ) and $_POST["with_selected"] ) ? "checked" : "" ) ."></td>
                               <td width=\"150\"><b class=porr>+ к выбранным</b></td>
                           </tr>
                           <tr>
                               <td colspa=\"4\"><br></td>
                           </tr>
                           <tr>
                               <td width=\"50\" align=\"right\" style=\"padding-right : 3px;\"><input type=\"TEXT\" class=\"button\" name=\"password_length\" style=\"width : 24px;\" value=\"". ( ( isset ( $_POST["password_length"] ) and !empty ( $_POST["password_length"] ) and $_POST["password_length"] <= 999 and $_POST["password_length"] >= 1 ) ? htmlspecialchars ( $_POST["password_length"], ENT_QUOTES ) : 24 ) ."\" maxlength=\"3\"></td>
                               <td><b class=por>Длинна пароля</b></td>
                               <td width=\"50\" align=\"right\" style=\"padding-right : 3px;\"><input type=\"TEXT\" class=\"button\" name=\"password_count\" style=\"width : 18px;\" value=\"". ( ( isset ( $_POST["password_count"] ) and !empty ( $_POST["password_count"] ) and $_POST["password_count"] <= 99 and $_POST["password_count"] >= 1 ) ? htmlspecialchars ( $_POST["password_count"], ENT_QUOTES ) : 1 ) ."\" maxlength=\"2\"></td>
                               <td><b class=por>Количество паролей</b></td>
                           </tr>
                           <tr>
                               <td colspan=\"4\" align=\"center\"><br><input type=\"SUBMIT\" class=\"button\" style=\"width : 150px;\" value=\"Генерировать\"></td>
                           </tr>
                           </form>
                           </table>
                           <br>
               ";

               return $result;
               
      }
      
      function password_generator ( ) {

               $result = "";
               $str = "";
               $str .= ( isset ( $_POST["allnum"] ) and $_POST["allnum"] ) ? "0123456789" : "";
               $str .= ( isset ( $_POST["allspec"] ) and $_POST["allspec"] ) ? '~`!@#$%^&*()_-+={}[]\:;№\"/.,\'' : "";
               $str .= ( isset ( $_POST["alllatinmin"] ) and $_POST["alllatinmin"] ) ? "abcdefghijklmnopqrstuvwxyz" : "";
               $str .= ( isset ( $_POST["alllatinmax"] ) and $_POST["alllatinmax"] ) ? "ABCDEFGHIJKLMNOPQRSTUVWXYZ" : "";
               $str .= ( isset ( $_POST["allkirilmin"] ) and $_POST["allkirilmin"] ) ? "абвгдеёжзийклмнопрстуфхцчшщьыъэюя" : "";
               $str .= ( isset ( $_POST["allkirilmax"] ) and $_POST["allkirilmax"] ) ? "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯ" : "";
               $str .= ( isset ( $_POST["with_selected"] ) and $_POST["with_selected"] ) ? $_POST["my_string"] : "";
               $str = ( isset ( $_POST["my_string"] ) and !empty ( $_POST["my_string"] ) and ( ( isset ( $_POST["with_selected"] ) and !$_POST["with_selected"] ) or !isset ( $_POST["with_selected"] ) ) ) ? $_POST["my_string"] : $str;
               $strlen = strlen ( $str );
               
               if ( $strlen == 0 ) {
                  $result .= "<center class=porr>Слишком мало символов для генерации пароля</center>\n";
               } else {
                  $result .= "<center class=porr>Сгенерированные пароли : </center>";
                  $length = ( isset ( $_POST["password_length"] ) and ( $_POST["password_length"] <= 999 ) and ( $_POST["password_length"] >= 1 ) ) ? $_POST["password_length"] : 24;
                  $count = ( isset ( $_POST["password_count"] ) and ( $_POST["password_count"] <= 99 ) and ( $_POST["password_count"] >= 1 ) ) ? $_POST["password_count"] : 1;

                  if ( $length <= 50 ) {
                     $result .= "<pre><center class=date>";
                  } else {
                     $result .= "<textarea class=\"button\" style=\"width : 100%; height : ". ( ( $count - 2 ) * 10 ) ."px; background : white;\">";
                  }
                  for ( $i = 1; $i <= $count; $i++ ) :
                      $pass = "";
                      for ( $j = 1; $j <= $length; $j++ ) :
                          $pass .= $str[mt_rand ( 0, $strlen-1 )];
                      endfor;
                      if ( $length > 50 ) {
                         $result .= str_replace ( " ", "&nbsp;", htmlspecialchars ( $pass, ENT_QUOTES ) ) ."\n\n";
                      } else {
                         $result .= htmlspecialchars ( $pass, ENT_QUOTES ) ."\n";
                      }
                  endfor;
                  if ( $length <= 50 ) {
                     $result .= "</center></pre>";
                  } else {
                     $result .= "</textarea>";
                  }
               }
               
               return $result;

      }
      
      function show_razdels ( ) {

               $result = "
                          <center class=porr>К вашему вниманию предстваляем раздел : <b class=por>Web-Tool's</b></center>
                          <br>
                          <a href=\"/". $_GET["input"]["razdel_url"] ."/crypt.html\">Шифрование</a><br>
                          <a href=\"/". $_GET["input"]["razdel_url"] ."/password_generator.html\">Генерирование паролей</a><br>
               ";
               
               return $result;

      }
      
      function obrabotka ( ) {
               global $security, $template, $structure;

               $result = "";
               $this->data["title"] = "[ Web-Tools ].:. ";
               $this->data["keyws"] = "[ Web-Tools ].:. ";

               $kategoria = isset ( $_GET["input"]["kategoria_url"] ) ? $_GET["input"]["kategoria_url"] : "";

               switch ( $kategoria ) :
               
                      case "crypt" :
                           if ( isset ( $_POST["source_string"] ) ) {
                              $result .= $this->show_encode_form ( );
                              $result .= $this->encode_string ( );
                           } else {
                              $result .= $this->show_encode_form ( );
                           }
                           
                           $this->data["title"] .= " Шифрование текста/файла ( MD5, Base64 Encode, Base64 Decode, CRC32, MD5 File, Des + Des Salt, UTF-8 Encode, UTF-8 Decode, BackWords, URL Encode, URL Decode, HTML Entities Encode, Html Entities Decode )";
                           $this->data["keyws"] .= " Шифрование текста/файла ( MD5, Base64 Encode, Base64 Decode, CRC32, MD5 File, Des + Des Salt, UTF-8 Encode, UTF-8 Decode, BackWords, URL Encode, URL Decode, HTML Entities Encode, Html Entities Decode )";
                           
                      break;
                      
                      case "password_generator" :
                           if ( isset ( $_POST["action"] ) and $_POST["action"] == "generate" and isset ( $_POST["password_length"] ) and isset ( $_POST["password_count"] ) and !empty ( $_POST["password_length"] ) and !empty ( $_POST["password_count"] ) ) {
                              $result .= $this->show_password_generator_form ( );
                              $result .= $this->password_generator ( );
                           } else {
                              $result .= $this->show_password_generator_form ( );
                           }

                           $this->data["title"] .= " Генерирование паролей ( Цыфры, Кирилица, Латиница, Специальные символы, Своя строка )";
                           $this->data["keyws"] .= " Генерирование паролей ( Цыфры, Кирилица, Латиница, Специальные символы, Своя строка )";
                           
                      break;
                      
                      default :

                           $result .= $this->show_razdels ( );

                      break;
                      
               endswitch;

               $template->edit ( $structure["content"], $result );
                  
      }

}

?>