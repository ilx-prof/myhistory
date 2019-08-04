<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class TEMPLATE {

      var $index;
      var $template_name;

      function exists ( $template ) {

               $this->template_name = $template;
               if ( is_file ( $template ) ) {
                  return TRUE;
               } else {
                  return FALSE;
               }
               
      }

      function load ( ) {
               $this->index = file_get_contents ( $this->template_name );
      }

      function edit ( $what_replace, $to_replace ) {
               $this->index = str_replace ( $what_replace, $to_replace, $this->index );
      }

      function show ( ) {
               print $this->index;
      }
      
}

?>