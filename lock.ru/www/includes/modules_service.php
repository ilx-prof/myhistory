<?php

class SERVICE {

      function show_info ( ) {
               global $sql;
               
               $result = "";
               
               if ( isset ( $_POST["action"] ) and ( $_POST["action"] == "add_request" ) and isset ( $_POST["request"] ) and !empty ( $_POST["request"] ) and isset ( $_POST["icq"] ) and !empty ( $_POST["icq"] ) ){
                  $query = "INSERT INTO
                                       `". SQL_TABLE_SERVICE_REQUEST ."`
                            VALUES    (
                                       '',
                                       '". mysql_escape_string ( $_POST["icq"] ) ."',
                                       '". mysql_escape_string ( $_POST["request"] ) ."',
                                       '". date ( "Y-m-d H:i:s", time ( ) ) ."'
                            )
                  ";
                  $sql->query ( $query, "print_error_and_exit" );
                  $result .= "<center class=porr>���� ������ ������� ���������!</center><BR><BR>";

               }

               $result .= "
                          <center class=porr>�������� <b class=por>Lock-Team</b> ������������� ��������� ������ : </center>
                          <table cellspacing=\"0\" cellpadding=\"5\" border=\"0\">
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>�������� �������/���� �� ������������</b></td>
                          </tr>
                          <tr valign=top>
                              <td><b class=por>***</b></td>
                              <td><b class=date>���������� �� PHP</b><br>
                                  <ul>
                                      <li><b class=por>�������</b>
                                      <li><b class=por>�������� ����</b>
                                      <li><b class=por>�������</b>
                                      <li><b class=por>��������� ��������</b>
                                  </ul>
                              </td>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>��������� (������ � ���������) ��������, ��������</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>���� ICQ/E-mail, ���� ��������</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>������� ICQ UIN'��</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>���� ICQ UIN'��</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>��������� Dedicated ��������</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>���������� ����������� �������/�������� ��������</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>������� ������ ������ ��� �����, �����, �����, ������� � �.�. HTTP(S), SOCKS 4(5).<br>������ ����������� �������������� �� �������</b></td>
                          </tr>
                          </table>
                          <center class=porr>���� �� ��� ������ ����������</center>
                          <br>
                          <form method=\"POST\">
                          <input type=\"HIDDEN\" name=\"action\" value=\"add_request\">
                          <input type=\"TEXT\" class=\"button\" name=\"icq\"><b class=por> - ICQ</b> <b class=date>(��� �������� �����)</b><br>
                          <b class=por>������ : </b><br>
                          <textarea name=\"request\" class=\"button\" style=\"background : white; width : 100%; height : 55px;\"></textarea>
                          <center><input type=\"SUBMIT\" class=\"button\" style=\"width : 150px;\" value=\"��������� ������\"></center>
                          </form>
               ";
               
               return $result;

      }
      
      
}

?>