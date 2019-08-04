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

/**
* Class to do data save/delete operations for MODERATORS
*
* Example usage (inserts a new moderator):
*
* $f = new vB_DataManager_Moderator();
* $f->set_info('moderatorid', 12);
* $f->save();
*
* @package	vBulletin
* @version	$Revision: 1.18 $
* @date		$Date: 2005/07/27 13:31:28 $
*/
class vB_DataManager_Moderator extends vB_DataManager
{
	/**
	* Array of recognised and required fields for moderators, and their types
	*
	* @var	array
	*/
	var $validfields = array(
		'moderatorid' => array(TYPE_UINT,       REQ_INCR, VF_METHOD, 'verify_nonzero'),
		'userid'      => array(TYPE_UINT,       REQ_YES,  VF_METHOD),
		'forumid'     => array(TYPE_UINT,       REQ_YES,  VF_METHOD),
		'permissions' => array(TYPE_ARRAY_BOOL, REQ_YES,  VF_METHOD)
	);

	/**
	* Array of field names that are bitfields, together with the name of the variable in the registry with the definitions.
	*
	* @var	array
	*/
	var $bitfields = array('permissions' => 'bf_misc_moderatorpermissions');

	/**
	* The main table this class deals with
	*
	* @var	string
	*/
	var $table = 'moderator';

	/**
	* Condition template for update query
	* This is for use with sprintf(). First key is the where clause, further keys are the field names of the data to be used.
	*
	* @var	array
	*/
	var $condition_construct = array('moderatorid = %1$d', 'moderatorid');

	/**
	* Array to store stuff to save to moderator table
	*
	* @var	array
	*/
	var $moderator = array();

	/**
	* Constructor - checks that the registry object has been passed correctly.
	*
	* @param	vB_Registry	Instance of the vBulletin data registry object - expected to have the database object as one of its $this->db member.
	* @param	integer		One of the ERRTYPE_x constants
	*/
	function vB_DataManager_Moderator(&$registry, $errtype = ERRTYPE_STANDARD)
	{
		parent::vB_DataManager($registry, $errtype);

		($hook = vBulletinHook::fetch_hook('moderatordata_start')) ? eval($hook) : false;
	}

	/**
	* Verifies that the specified user exists
	*
	* @param	integer	User ID
	*
	* @return 	boolean	Returns true if user exists
	*/
	function verify_userid(&$userid)
	{
		if ($userinfo = $this->dbobject->query_first("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid = $userid"))
		{
			$this->info['user'] =& $userinfo;
			return true;
		}
		else
		{
			$this->error('no_users_matched_your_query');
			return false;
		}
	}

	/**
	* Verifies that the specified forum exists
	*
	* @param	integer	ID of the forum
	*
	* @return	boolean	Returns true if forum exists
	*/
	function verify_forumid(&$forumid)
	{
		if (isset($this->registry->forumcache["$forumid"]))
		{
			$this->info['forum'] =& $this->registry->forumcache["$forumid"];
			return true;
		}
		else
		{
			$this->error('invalid_forum_specified');
			return false;
		}
	}

	/**
	* Converts an array of 1/0 options into the permissions bitfield
	*
	* @param	array	Array of 1/0 values keyed with the bitfield names for the moderator permissions bitfield
	*
	* @return	boolean	Returns true on success
	*/
	function verify_permissions(&$permissions)
	{
		require_once(DIR . '/includes/functions_misc.php');
		return $permissions = convert_array_to_bits($permissions, $this->registry->bf_misc_moderatorpermissions);
	}

	/**
	* Overriding version of the set() function to deal with the selecting userid from username
	*
	* @param	string	Name of the field
	* @param	mixed	Value of the field
	*
	* @return	boolean	Returns true on success
	*/
	function set($fieldname, $value)
	{
		switch ($fieldname)
		{
			case 'username':
			case 'modusername':
			{
				if ($value != '' AND $userinfo = $this->dbobject->query_first("SELECT * FROM " . TABLE_PREFIX . "user WHERE username = '" . $this->dbobject->escape_string($value) . "'"))
				{
					$this->do_set('userid', $userinfo['userid']);
					$this->info['user'] =& $userinfo;
					return true;
				}
				else
				{
					$this->error('no_users_matched_your_query');
					return false;
				}
			}
			break;

			default:
			{
				return parent::set($fieldname, $value);
			}
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

		$return_value = true;
		($hook = vBulletinHook::fetch_hook('moderator_presave')) ? eval($hook) : false;

		$this->presave_called = $return_value;
		return $return_value;
	}

	/**
	* Additional data to update after a save call (such as denormalized values in other tables).
	*
	* @param	boolean	Do the query?
	*/
	function post_save_each($doquery = true)
	{
		$moderatorid = $this->fetch_field('moderatorid');

		// update usergroupid / membergroupids
		if (!$this->condition AND !in_array($this->moderator['userid'], explode(',', $this->registry->config['SpecialUsers']['undeletableusers'])) AND can_administer('canadminusers'))
		{
			$update_usergroupid = ($this->info['usergroupid'] > 0);
			$update_membergroup = (!empty($this->info['membergroupids']) AND is_array($this->info['membergroupids']));

			if ($update_usergroupid OR $update_membergroup)
			{
				$userdata =& datamanager_init('User', $this->registry, ERRTYPE_SILENT);
				if (!$this->info['user'] AND $this->moderator['userid'])
				{
					$userdata->set_existing(fetch_userinfo($this->moderator['userid']));
				}
				else
				{
					$userdata->set_existing($this->info['user']);
				}
				$userdata->set_failure_callback(array(&$this, 'update_user_failed_insert'));
				if ($update_usergroupid)
				{
					$userdata->set('usergroupid', $this->info['usergroupid']);
					$userdata->set('displaygroupid', $this->info['usergroupid']);
				}
				if ($update_membergroup)
				{
					$membergroupids = preg_split('#,#', $this->info['user']['membergroupids'], -1, PREG_SPLIT_NO_EMPTY);
					$membergroupids = array_unique(array_merge($membergroupids, $this->info['membergroupids']));
					if ($key = array_search($this->info['user']['usergroupid'], $membergroupids))
					{
						unset($membergroupids["$key"]);
					}
					sort($membergroupids);
					$userdata->set('membergroupids', $membergroupids);
				}
				if ($userdata->errors)
				{
					$this->errors = array_merge($this->errors, $userdata->errors);
					return;
				}
				$userdata->save();
			}
		}

		($hook = vBulletinHook::fetch_hook('moderatordata_postsave')) ? eval($hook) : false;
	}

	/**
	* Deletes a moderator
	*
	* @return	mixed	The number of affected rows
	*/
	function delete($doquery = true)
	{
		if ($moderator = $this->dbobject->query_first("
			SELECT user.userid, usergroupid, username, displaygroupid, moderatorid
			FROM " . TABLE_PREFIX . "moderator AS moderator
			INNER JOIN " . TABLE_PREFIX . "user AS user USING(userid)
			WHERE " . $this->condition
		))
		{
			if ($moderator['usergroupid'] == 7 AND !($moreforums = $this->dbobject->query_first("SELECT userid FROM " . TABLE_PREFIX . "moderator WHERE userid = $moderator[userid] AND moderatorid <> $moderator[moderatorid]")))
			{
				$userdata =& datamanager_init('User', $this->registry, ERRTYPE_SILENT);
				if (!$this->info['user'])
				{
					$userdata->set_existing(fetch_userinfo($this->fetch_field('userid')));
				}
				else
				{
					$userdata->set_existing($this->info['user']);
				}
				$userdata->set_failure_callback(array(&$this, 'update_user_failed_update'));
				$userdata->set('usergroupid', 2);
				$userdata->set('displaygroupid', ($moderator['displaygroupid'] == 7 ? 0 : $moderator['displaygroupid']));
				if ($userdata->errors)
				{
					$this->errors = array_merge($this->errors, $userdata->errors);
					return 0;
				}
				$userdata->save();
			}

			($hook = vBulletinHook::fetch_hook('moderatordata_delete')) ? eval($hook) : false;

			return $this->db_delete(TABLE_PREFIX, 'moderator', $this->condition, $doquery);
		}
		else
		{
			$this->error('user_no_longer_moderator');
		}
	}

	/**
	* Callback function that is hit when inserting a new moderator, and his/her
	* usergroup or member groups fail to be changed.
	*/
	function update_user_failed_insert(&$user)
	{
		$this->condition = 'moderatorid = ' . $this->fetch_field('moderatorid');
		$this->delete();
		$this->condition = '';

		$this->errors = array_merge($this->errors, $user->errors);
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: class_dm_moderator.php,v $ - $Revision: 1.18 $
|| ####################################################################
\*======================================================================*/
?>