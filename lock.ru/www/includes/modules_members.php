<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class MEMBERS {

      var $replace = array (
                            "members_string" => array ( )
                           );
      var $template;
      var $data = array ( );

      function find_templates ( ) {
               global $structure;

               preg_match ( "/". $structure["members_menu"]["str_start"] ."(.+)". $structure["members_menu"]["str_end"] ."/s", $this->template->index, $this->replace["members_string"] );

      }
      
      function show_member ( ) {
               global $security, $structure, $template, $sql;
               $result = "";

               $query = "SELECT * FROM `". SQL_TABLE_MEMBERS ."` WHERE `id` = ". $_GET["input"]["element_id"] ."";
               $member = mysql_fetch_assoc ( $sql->query ( $query, "print_error_and_exit" ) );
               if ( empty ( $member["nick"] ) ) {
                  $security->error_pages ( 404 );
                  
                  $this->data["title"] = "[ Team ].:. Неправильная ссылка";
                  $this->data["keyws"] = "[ Team ].:. Неправильная ссылка";
                  
               } else {

                  $this->data["title"] = "[ Team ].:. ". $member["nick"];
                  $this->data["keyws"] = "[ Team ].:. ". $member["nick"];

                  $icq1 = substr ( $member["icq"], 0, bcdiv ( strlen ( $member["icq"] ), 2 ) );
                  $icq2 = substr ( $member["icq"], bcdiv ( strlen ( $member["icq"] ), 2 ), 5 );
                  $this->template->index = str_replace ( $structure["members_menu"]["full_icq_number"], $member["icq"], $this->template->index );
                  $this->template->index = str_replace ( $structure["members_menu"]["nick"], $member["nick"], $this->template->index );
                  $this->template->index = str_replace ( $structure["members_menu"]["description"], $member["description"], $this->template->index );
                  $this->template->index = str_replace ( $structure["members_menu"]["first_half_icq_number"], $icq1, $this->template->index );
                  $this->template->index = str_replace ( $structure["members_menu"]["second_half_icq_number"], $icq2, $this->template->index );

                  $this->template->index = str_replace ( $this->replace["members_string"][0], $this->replace["members_string"][1], $this->template->index );
                  $template->edit ( $structure["content"], $this->template->index );
               
               }

      }

      function obrabotka ( ) {

               $this->template = new TEMPLATE;
               if ( $this->template->exists ( TEMPLATE_MEMBERS ) ) {
                  $this->template->load ( TEMPLATE_MEMBERS );
                  $this->find_templates ( );
                  $this->show_member ( );
               }

      }

}

?>