<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class SQL {

      var $error         = FALSE;      # Есть ли ошибка при коннекте, выборе БД, отправке запроса...
      var $server        = array ( );  # Данные для коннекта к Базе и выбоки БД
      var $sql_id        = null;       # Идентификатор соединения
      var $db_selected   = FALSE;      # Выбрана ли БД?
      var $error_message = '';         # Сообщение при ошибке [сообщение из mysql_error() ]
      var $queries       = 0;          # Количество удачных запросов к базе данных

      
      function connect ( $type ) {
               $this->error = FALSE;
               $this->sql_id = mysql_connect ( $this->server["host"], $this->server["user"], $this->server["pass"] );
               if ( mysql_error ( ) ) $this->error ( mysql_error ( ), $type );
      }

      function select_db ( $type ) {
               $this->error = FALSE;
               mysql_select_db ( $this->server["database"], $this->sql_id );
               if ( mysql_error ( ) ) $this->error ( mysql_error ( ), $type );
               else $this->db_selected = TRUE;
      }

      function query ( $query, $type ) {
               $this->error = FALSE;
               $result = mysql_query ( $query, $this->sql_id );
               if ( mysql_error ( ) ) $this->error ( mysql_error ( ), $type );
               else $this->queries++;
               return $result;
      }

      function escape ( $string ) {
               return mysql_escape_string ( $string );
      }

      function error ( $error, $type ) {
               switch ( $type ) :

                      case "print_error" :
                           print $error;
                      break;

                      case "print_error_and_exit" :
                           print $error;
                           //exit;
                      break;

                      case "return_error" :
                           $this->error = TRUE;
                           $this->error_message = $error;
                      break;

                      case "exit" :
                           exit;
                      break;

                      default :
                      
                      break;
                      
               endswitch;
      }

      function close ( ) {
               mysql_close ( $this->sql_id );
      }
      
}

?>