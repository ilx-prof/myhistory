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
                  $result .= "<center class=porr>Ваша заявка успешно оформлена!</center><BR><BR>";

               }

               $result .= "
                          <center class=porr>Комманда <b class=por>Lock-Team</b> предоставляет следующие услуги : </center>
                          <table cellspacing=\"0\" cellpadding=\"5\" border=\"0\">
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Проверка сервера/сети на безопасность</b></td>
                          </tr>
                          <tr valign=top>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Разработка на PHP</b><br>
                                  <ul>
                                      <li><b class=por>Движков</b>
                                      <li><b class=por>Гостевых книг</b>
                                      <li><b class=por>Форумов</b>
                                      <li><b class=por>Отдельных скриптов</b>
                                  </ul>
                              </td>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Настройка (помощь в настройке) скриптов, сервисов</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Флуд ICQ/E-mail, спам рассылка</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Продажа ICQ UIN'ов</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Угон ICQ UIN'ов</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Установка Dedicated серверов</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Разработка уникального дизайна/логотипа компании</b></td>
                          </tr>
                          <tr>
                              <td><b class=por>***</b></td>
                              <td><b class=date>Продажа свежих прокси для брута, флуда, спама, регеров и т.д. HTTP(S), SOCKS 4(5).<br>Прокси проверяются соответственно до продажи</b></td>
                          </tr>
                          </table>
                          <center class=porr>Цена на все услуги договорная</center>
                          <br>
                          <form method=\"POST\">
                          <input type=\"HIDDEN\" name=\"action\" value=\"add_request\">
                          <input type=\"TEXT\" class=\"button\" name=\"icq\"><b class=por> - ICQ</b> <b class=date>(для обратной связи)</b><br>
                          <b class=por>Заявка : </b><br>
                          <textarea name=\"request\" class=\"button\" style=\"background : white; width : 100%; height : 55px;\"></textarea>
                          <center><input type=\"SUBMIT\" class=\"button\" style=\"width : 150px;\" value=\"Отправить заявку\"></center>
                          </form>
               ";
               
               return $result;

      }
      
      
}

?>