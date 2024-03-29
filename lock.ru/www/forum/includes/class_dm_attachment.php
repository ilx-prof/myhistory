<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.5.0 Release Candidate 3                              # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2005 Jelsoft Enterprises Ltd. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS        # ||
|| #################################################################### ||
\*======================================================================*/

if (!class_exists('vB_DataManager'))
{
	exit;
}

// Temporary
require_once(DIR . '/includes/functions_file.php');

/**
* Abstract class to do data save/delete operations for ATTACHMENTS.
* You should call the fetch_library() function to instantiate the correct
* object based on how attachments are being stored unless calling the multiple
* datamanager. There is no support for manipulating the FS via the multiple
* datamanager at the present.
*
* @package	vBulletin
* @version	$Revision: 1.61 $
* @date		$Date: 2005/08/02 01:12:12 $
*/
class vB_DataManager_Attachment extends vB_DataManager
{
	/**
	* Array of recognized and required fields for attachment inserts
	*
	* @var	array
	*/
	var $validfields = array(
		'attachmentid'       => array(TYPE_UINT,     REQ_INCR, 'return ($data > 0);'),
		'userid'             => array(TYPE_UINT,     REQ_YES),
		'postid'             => array(TYPE_UINT,     REQ_NO),
		'dateline'           => array(TYPE_UNIXTIME, REQ_AUTO),
		'filename'           => array(TYPE_STR,      REQ_YES, VF_METHOD, 'verify_filename'),
		'filedata'           => array(TYPE_NOTRIM,   REQ_NO, VF_METHOD),
		'filesize'           => array(TYPE_UINT,     REQ_YES),
		'visible'            => array(TYPE_UINT,     REQ_NO),
		'counter'            => array(TYPE_UINT,     REQ_NO),
		'filehash'           => array(TYPE_STR,      REQ_YES, VF_METHOD, 'verify_md5'),
		'posthash'           => array(TYPE_STR,      REQ_NO, VF_METHOD, 'verify_md5_alt'),
		'thumbnail'          => array(TYPE_NOTRIM,   REQ_NO, VF_METHOD),
		'thumbnail_dateline' => array(TYPE_UNIXTIME, REQ_AUTO),
		'thumbnail_filesize' => array(TYPE_UINT,     REQ_NO),
		'extension'          => array(TYPE_STR,      REQ_YES),
	);

	/**
	* The main table this class deals with
	*
	* @var	string
	*/
	var $table = 'attachment';

	/**
	* Storage holder
	*
	* @var  array   Storage Holder
	*/
	var $lists = array();

	/**
	* Switch to control modlog update
	*
	* @var  boolean
	*/
	var $log = true;

	/**
	* Condition template for update query
	* This is for use with sprintf(). First key is the where clause, further keys are the field names of the data to be used.
	*
	* @var	array
	*/
	var $condition_construct = array('attachmentid = %1$d', 'attachmentid');

	/**
	* Constructor - checks that the registry object has been passed correctly.
	*
	* @param	vB_Registry	Instance of the vBulletin data registry object - expected to have the database object as one of its $this->db member.
	* @param	integer		One of the ERRTYPE_x constants
	*/
	function vB_DataManager_Attachment(&$registry, $errtype = ERRTYPE_STANDARD)
	{
		parent::vB_DataManager($registry, $errtype);

		($hook = vBulletinHook::fetch_hook('attachdata_start')) ? eval($hook) : false;
	}

	/**
	* Fetches the appropriate subclassed based on how attachments are being stored.
	*
	* @param	vB_Registry	Instance of the vBulletin data registry object - expected to have the database object as one of its $this->db member.
	* @param	integer		One of the ERRTYPE_x constants
	*
	* @return	vB_DataManager_Attachment	Subclass of vB_DataManager_Attachment
	*/
	function &fetch_library(&$registry, $errtype = ERRTYPE_ARRAY)
	{

		// Library
		$selectclass = ($registry->options['attachfile']) ? 'vB_DataManager_Attachment_Filesystem' : 'vB_DataManager_Attachment_Database';
		return new $selectclass($registry, $errtype);
	}

	/**
	* Verify that posthash is either md5 or empty
	* @param	string the md5
	*
	* @return	boolean
	*/
	function verify_md5_alt(&$md5)
	{
		return (empty($md5) OR (strlen($md5) == 32 AND preg_match('#^[a-f0-9]{32}$#', $md5)));
	}

	/**
	* Set the extension of the filename
	*
	* @param	filename
	*
	* @return	boolean
	*/
	function verify_filename(&$filename)
	{
		$this->set('extension', strtolower(substr(strrchr($filename, '.'), 1)));
		return true;
	}

	/**
	* Set the filesize of the thumbnail
	*
	* @param	integer	Maximum posts per page
	*
	* @return	boolean
	*/
	function verify_thumbnail(&$thumbnail)
	{
		if (strlen($thumbnail) > 0)
		{
			$this->set('thumbnail_filesize', strlen($thumbnail));
		}
		return true;
	}

	/**
	* Set the filehash/filesize of the file
	*
	* @param	integer	Maximum posts per page
	*
	* @return	boolean
	*/
	function verify_filedata(&$filedata)
	{
		if (strlen($filedata) > 0)
		{
			$this->set('filehash', md5($filedata));
			$this->set('filesize', strlen($filedata));
		}

		return true;
	}

	/**
	* Saves the data from the object into the specified database tables
	* Overwrites parent
	*
	* @return	mixed	If this was an INSERT query, the INSERT ID is returned
	*/
	function save($doquery = true, $delayed = false)
	{
		if ($this->has_errors())
		{
			return false;
		}

		if (!$this->pre_save($doquery))
		{
			return false;
		}

		if ($this->condition === null)
		{
			$return = $this->db_insert(TABLE_PREFIX, $this->table, $doquery);
			$this->set('attachmentid', $return);
		}
		else
		{
			$return = $this->db_update(TABLE_PREFIX, $this->table, $this->condition, $doquery, $delayed);
		}

		if ($return AND $this->post_save_each($doquery) AND $this->post_save_once($doquery))
		{
			return $return;
		}
		else
		{
			return false;
		}
	}

	/**
	* Any checks to run immediately before saving. If returning false, the save will not take place.
	*
	* @param	boolean	Do the query?
	*
	* @return	boolean	True on success; false if an error occurred
	*/
	function pre_save($doquery = true)
	{
		if ($this->presave_called !== null)
		{
			return $this->presave_called;
		}

		// Update an existing attachment (on insert) of the same name so that it maintains its current attachmentid
		if ($this->condition === null AND $this->fetch_field('filename') AND !$this->fetch_field('postid'))
		{
			if ($foo = $this->dbobject->query_first("
				SELECT attachmentid
				FROM " . TABLE_PREFIX . "attachment AS attachment
				WHERE filename = '" . $this->dbobject->escape_string($this->fetch_field('filename')) . "'
					AND posthash = '" . $this->dbobject->escape_string($this->fetch_field('posthash')) . "'
					AND userid = " . intval($this->fetch_field('userid')) . "
			"))
			{
				$this->condition = "attachmentid = $foo[attachmentid]";
				$this->existing['attachmentid'] = $foo['attachmentid'];
				$this->set('counter', 0);
				$this->set('postid', 0);
			}
			// this is an edit
			else if ($this->info['postid'] AND $foo = $this->dbobject->query_first("
				SELECT attachmentid
				FROM " . TABLE_PREFIX . "attachment AS attachment
				WHERE filename = '" . $this->dbobject->escape_string($this->fetch_field('filename')) . "'
					AND postid = " . intval($this->info['postid']) . "
			"))
			{
				$this->condition = "attachmentid = $foo[attachmentid]";
				$this->existing['attachmentid'] = $foo['attachmentid'];
				$this->set('counter', 0);
				$this->set('postid', 0);
			}
		}

		$return_value = true;
		($hook = vBulletinHook::fetch_hook('attachdata_presave')) ? eval($hook) : false;

		$this->presave_called = $return_value;
		return $return_value;
	}

	/**
	* Any code to run before deleting. Builds lists and updates mod log
	*
	* @param	Boolean Do the query?
	*/
	function pre_delete($doquery = true)
	{
		@ignore_user_abort(true);

		// init lists
		$this->lists = array(
			'idlist'     => array(),
			'postlist'   => array(),
			'threadlist' => array()
		);

		$replaced = array();

		$ids = $this->registry->db->query_read("
			SELECT
				attachment.attachmentid,
				attachment.userid,
				post.postid,
				post.threadid,
				post.dateline AS post_dateline,
				post.userid AS post_userid,
				thread.forumid
			FROM " . TABLE_PREFIX . "attachment AS attachment
			LEFT JOIN " . TABLE_PREFIX . "post AS post ON (post.postid = attachment.postid)
			LEFT JOIN " . TABLE_PREFIX . "thread AS thread ON (thread.threadid = post.threadid)
			WHERE " . $this->condition
		);
		while ($id = $this->registry->db->fetch_array($ids))
		{
			$this->lists['idlist']["{$id['attachmentid']}"] = $id['userid'];

			if ($id['postid'])
			{
				$this->lists['postlist']["{$id['postid']}"]++;

				if ($this->log)
				{
					if (($this->registry->userinfo['permissions']['genericoptions'] & $this->registry->bf_ugp_genericoptions['showeditedby']) AND $id['post_dateline'] < (TIMENOW - ($this->registry->options['noeditedbytime'] * 60)))
					{
						if (empty($replaced["$id[postid]"]))
						{
							/*insert query*/
							$this->registry->db->query_write("
								REPLACE INTO " . TABLE_PREFIX . "editlog
										(postid, userid, username, dateline)
								VALUES
									($id[postid], " . $this->registry->userinfo['userid'] . ", '" . $this->registry->db->escape_string($this->registry->userinfo['username']) . "', " . TIMENOW . ")"
							);
							$replaced["$id[postid]"] = true;
						}
					}
					if ($this->registry->userinfo['userid'] != $id['post_userid'] AND can_moderate($threadinfo['forumid'], 'caneditposts'))
					{
						$postinfo['forumid'] =& $foruminfo['forumid'];

						$postinfo = array(
							'postid'       =>& $id['postid'],
							'threadid'     =>& $id['threadid'],
							'forumid'      =>& $id['forumid'],
							'attachmentid' =>& $id['attachmentid'],
						);
						require_once(DIR . '/includes/functions_log_error.php');
						log_moderator_action($postinfo, 'attachment_removed');
					}
				}
			}
			if ($id['threadid'])
			{
				$this->lists['threadlist']["{$id['threadid']}"]++;
			}
		}

		if ($this->registry->db->num_rows($ids) == 0)
		{	// nothing to delete
			return false;
		}
		else
		{
			// condition needs to have any attachment. replaced with TABLE_PREFIX . attachment
			// since DELETE doesn't suport table aliasing in some versions of MySQL
			// we needed the attachment. for the query run above at the start of this function
			$this->condition = preg_replace('#(attachment\.)#si', TABLE_PREFIX . '\1', $this->condition);
			return true;
		}
	}

	/**
	* Any code to run after deleting
	*
	* @param	Boolean Do the query?
	*/
	function post_delete($doquery = true)
	{
		// A little cheater function..
		if (!empty($this->lists['idlist']) AND $this->registry->options['attachfile'])
		{
			require_once(DIR . '/includes/functions_file.php');
			// Delete attachments from the FS
			foreach ($this->lists['idlist'] AS $attachmentid => $userid)
			{
				@unlink(fetch_attachment_path($userid, $attachmentid));
				@unlink(fetch_attachment_path($userid, $attachmentid, true));
			}
		}

		// Build MySQL CASE Statement to update post/thread attach counters
		// future: examine using subselect option for MySQL 4.1

		foreach($this->lists['postlist'] AS $postid => $count)
		{
			$postidlist .= ",$postid";
			$postcasesql .= " WHEN postid = $postid THEN $count";
		}

		if ($postcasesql)
		{
			$this->registry->db->query_write("
				UPDATE " . TABLE_PREFIX . "post
				SET attach = attach -
				CASE
					$postcasesql
					ELSE 0
				END
				WHERE postid IN (-1$postidlist)
			");
		}

		foreach($this->lists['threadlist'] AS $threadid => $count)
		{
			$threadidlist .= ",$threadid";
			$threadcasesql .= " WHEN threadid = $threadid THEN $count";
		}

		if ($threadcasesql)
		{
			$this->registry->db->query_write("
				UPDATE " . TABLE_PREFIX . "thread
				SET attach = attach -
				CASE
					$threadcasesql
					ELSE 0
				END
				WHERE threadid IN (-1$threadidlist)
			");
		}

		($hook = vBulletinHook::fetch_hook('attachdata_delete')) ? eval($hook) : false;
	}
}

/**
* Class to do data save/delete operations for ATTACHMENTS in the DATABASE.
*
* @package	vBulletin
* @version	$Revision: 1.61 $
* @date		$Date: 2005/08/02 01:12:12 $
*/

class vB_DataManager_Attachment_Database extends vB_DataManager_Attachment
{
	/**
	* Any checks to run immediately before saving. If returning false, the save will not take place.
	*
	* @param	boolean	Do the query?
	*
	* @return	boolean	True on success; false if an error occurred
	*/

	function pre_save($doquery = true)
	{
		if ($this->presave_called !== null)
		{
			return $this->presave_called;
		}

		if (!empty($this->info['filedata']))
		{
			$this->setr('filedata', $this->info['filedata']);
		}
		if (!empty($this->info['thumbnail']))
		{
			$this->setr('thumbnail', $this->info['thumbnail']);
		}

		return parent::pre_save($doquery);
	}
}


/**
* Class to do data save/delete operations for ATTACHMENTS in the FILE SYSTEM.
*
* @package	vBulletin
* @version	$Revision: 1.61 $
* @date		$Date: 2005/08/02 01:12:12 $
*/
class vB_DataManager_Attachment_Filesystem extends vB_DataManager_Attachment
{
	/**
	* Any checks to run immediately before saving. If returning false, the save will not take place.
	*
	* @param	boolean	Do the query?
	*
	* @return	boolean	True on success; false if an error occurred
	*/
	function pre_save($doquery = true)
	{
		if ($this->presave_called !== null)
		{
			return $this->presave_called;
		}

		// make sure we don't have the binary data set
		// if so move it to an information field
		// benefit of this is that when we "move" files from DB to FS,
		// the filedata/thumbnail fields are not blanked in the database
		// during the update.
		if ($file =& $this->fetch_field('filedata'))
		{
			$this->setr_info('filedata', $file);
			$this->do_unset('filedata');
		}

		if ($thumb =& $this->fetch_field('thumbnail'))
		{
			$this->setr_info('thumbnail', $thumb);
			$this->do_unset('thumbnail');
		}

		if (!empty($this->info['filedata']))
		{
			$this->set('filehash', md5($this->info['filedata']));
			$this->set('filesize', strlen($this->info['filedata']));
		}
		if (!empty($this->info['thumbnail']))
		{
			$this->set('thumbnail_filesize', strlen($this->info['thumbnail']));
		}

		if (!empty($this->info['filedata']) OR !empty($this->info['thumbnail']))
		{
			$path = verify_attachment_path($this->fetch_field('userid'));
			if (!$path)
			{
				$this->error('attachpathfailed');
				return false;
			}

			if (!is_writable($path))
			{
				$this->error('upload_file_system_is_not_writable');
				return false;
			}
		}

		return parent::pre_save($doquery);
	}

	/**
	* Additional data to update after a save call (such as denormalized values in other tables).
	* In batch updates, is executed for each record updated.
	*
	* @param	boolean	Do the query?
	*/
	function post_save_each($doquery = true)
	{

		$attachmentid =& $this->fetch_field('attachmentid');
		$userid =& $this->fetch_field('userid');
		$failed = false;

		// Check for filedata in an information field
		if (!empty($this->info['filedata']))
		{
			$filename = fetch_attachment_path($userid, $attachmentid);
			if ($fp = fopen($filename, 'wb'))
			{
				fwrite($fp, $this->info['filedata']);
				fclose($fp);
				#remove possible existing thumbnail in case no thumbnail is written in the next step.
				@unlink(fetch_attachment_path($userid, $attachmentid, true));
			}
			else
			{
				$failed = true;
			}
		}

		if (!$failed AND !empty($this->info['thumbnail']))
		{
			// write out thumbnail now
			$filename = fetch_attachment_path($userid, $attachmentid, true);
			if ($fp = fopen($filename, 'wb'))
			{
				fwrite($fp, $this->info['thumbnail']);
				fclose($fp);
			}
			else
			{
				$failed = true;
			}
		}

		($hook = vBulletinHook::fetch_hook('attachdata_postsave')) ? eval($hook) : false;

		if ($failed)
		{
			if ($this->condition === null) // Insert, delete attachment
			{
				$this->condition = "attachmentid = $attachmentid";
				$this->log = false;
				$this->delete();
			}

			// $php_errormsg is automatically set if track_vars is enabled
			$this->error('upload_copyfailed', htmlspecialchars_uni($php_errormsg));
			return false;
		}
		else
		{
			return true;
		}
	}
}

/**
* Class to do data update operations for multiple Attachments simultaneously
*
* @package	vBulletin
* @version	$Revision: 1.61 $
* @date		$Date: 2005/08/02 01:12:12 $
*/
class vB_DataManager_Attachment_Multiple extends vB_DataManager_Multiple
{
	/**
	* The name of the class to instantiate for each matching. It is assumed to exist!
	* It should be a subclass of vB_DataManager.
	*
	* @var	string
	*/
	var $class_name = 'vB_DataManager_Attachment';

	/**
	* The name of the primary ID column that is used to uniquely identify records retrieved.
	* This will be used to build the condition in all update queries!
	*
	* @var string
	*/
	var $primary_id = 'attachmentid';

	/**
	* Builds the SQL to run to fetch records. This must be overridden by a child class!
	*
	* @param	string	Condition to use in the fetch query; the entire WHERE clause
	* @param	integer	The number of records to limit the results to; 0 is unlimited
	* @param	integer	The number of records to skip before retrieving matches.
	*
	* @return	string	The query to execute
	*/
	function fetch_query($condition = '', $limit = 0, $offset = 0)
	{
		// would not be wise to select *, i.e. filedata and thumbnail can be quite large
		$query = "
			SELECT attachmentid, userid, filehash, visible, filesize, filename
			FROM " . TABLE_PREFIX . "attachment AS attachment
		";
		if ($condition)
		{
			$query .= " WHERE $condition";
		}

		$limit = intval($limit);
		$offset = intval($offset);
		if ($limit)
		{
			$query .= " LIMIT $offset, $limit";
		}

		return $query;
	}
}
/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: class_dm_attachment.php,v $ - $Revision: 1.61 $
|| ####################################################################
\*======================================================================*/
?>