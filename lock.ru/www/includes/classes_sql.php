<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class SQL {

      var $error         = FALSE;      # ���� �� ������ ��� ��������, ������ ��, �������� �������...
      var $server        = array ( );  # ������ ��� �������� � ���� � ������ ��
      var $sql_id        = null;       # ������������� ����������
      var $db_selected   = FALSE;      # ������� �� ��?
      var $error_message = '';         # ��������� ��� ������ [��������� �� mysql_error() ]
      var $queries       = 0;          # ���������� ������� �������� � ���� ������

      
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