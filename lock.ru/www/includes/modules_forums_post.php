<?

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

class FORUMS_POSTS {

      var $template;
      var $replace = array ( "forums_posts_string" => array ( ) );
      
      function find_templates ( ) {
               global $structure;
               
               preg_match ( "/". $structure["forums_posts"]["str_start"] ."(.+)". $structure["forums_posts"]["str_end"] ."/s", $this->template->index, $this->replace["forums_posts_string"] );
               
      }

      function show_forums_posts ( ) {
               global $structure, $sql;


               $query = "
                         SELECT
                               `". VBULLETIN_TABLE_PREFIX ."post`.`threadid`,
                               `". VBULLETIN_TABLE_PREFIX ."post`.`dateline`,
                               `". VBULLETIN_TABLE_PREFIX ."post`.`userid`,
                               `". VBULLETIN_TABLE_PREFIX ."post`.`username`,
                               `". VBULLETIN_TABLE_PREFIX ."thread`.`title`,
                               `". VBULLETIN_TABLE_PREFIX ."thread`.`replycount`,
                               `". VBULLETIN_TABLE_PREFIX ."thread`.`postuserid`,
                               `". VBULLETIN_TABLE_PREFIX ."thread`.`postusername`,
                               `". VBULLETIN_TABLE_PREFIX ."thread`.`views`
                         FROM
                               `". VBULLETIN_TABLE_PREFIX ."post`,
                               `". VBULLETIN_TABLE_PREFIX ."thread`
                         WHERE
                               `". VBULLETIN_TABLE_PREFIX ."post`.`threadid` = `". VBULLETIN_TABLE_PREFIX ."thread`.`threadid`
                         ORDER BY `". VBULLETIN_TABLE_PREFIX ."post`.`postid` DESC
                         LIMIT ". INF_FORUMS_POSTS ."
               ";

               $data = $sql->query ( $query, "print_error_and_exit" );

               $result = "";
               if ( $data !== FALSE and mysql_num_rows ( $data ) !== 0 ) {
                  while ( $thread = mysql_fetch_assoc ( $data ) ) :

                        $l = $this->replace["forums_posts_string"][1];
                        $l = str_replace ( $structure["forums_posts"]["thread_link"]           , "/forum/showthread.php?t=". $thread["threadid"], $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_title"]          , $thread["title"], $l);
                        $l = str_replace ( $structure["forums_posts"]["thread_replys"]         , $thread["replycount"], $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_user_link"]      , "/forum/member.php?u=". $thread["postuserid"], $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_user_name"]      , $thread["postusername"], $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_views"]          , $thread["views"], $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_date"]           , date ( "Y-m-d H:i:s", $thread["dateline"] ), $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_new_posts_link"] , "/forum/showthread.php?t=". $thread["threadid"] ."&goto=newpost", $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_last_user_link"] , "/forum/member.php?u=". $thread["userid"], $l );
                        $l = str_replace ( $structure["forums_posts"]["thread_last_user_name"] , $thread["username"], $l );
                        $result .= $l ."\n";

                  endwhile;
               }

               $this->template->index = str_replace ( $this->replace["forums_posts_string"], $result, $this->template->index );

               return $this->template->index;

      }

      function obrabotka ( ) {

               $this->template = new TEMPLATE;
               if ( $this->template->exists ( TEMPLATE_FORUMS_POSTS ) ) {
                  $this->template->load ( );
                  $this->find_templates ( );
                  $a = $this->show_forums_posts ( );
               } else {

               }

               return $a;

      }

}