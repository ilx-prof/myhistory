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

define('SALT_LENGTH', 3);

/**
* Class to do data save/delete operations for USERS
*
* Available info fields:
* $this->info['coppauser'] - User is COPPA
* $this->info['override_usergroupid'] - Prevent overwriting of usergroupid (for email validation)
*
* @package	vBulletin
* @version	$Revision: 1.94 $
* @date		$Date: 2005/08/30 22:22:37 $
*/
class vB_DataManager_User extends vB_DataManager
{
	/**
	* Array of recognised and required fields for users, and their types
	*
	* @var	array
	*/
	var $validfields = array(
		'userid'             => array(TYPE_UINT,       REQ_INCR, VF_METHOD, 'verify_nonzero'),
		'username'           => array(TYPE_STR,        REQ_YES, VF_METHOD),

		'email'              => array(TYPE_STR,        REQ_YES, VF_METHOD, 'verify_useremail'),
		'parentemail'        => array(TYPE_STR,        REQ_NO, VF_METHOD),
		'emailstamp'         => array(TYPE_UNIXTIME,   REQ_NO),

		'password'           => array(TYPE_STR,        REQ_YES, VF_METHOD),
		'passworddate'       => array(TYPE_STR,        REQ_AUTO),
		'salt'               => array(TYPE_STR,        REQ_AUTO, VF_METHOD),

		'usergroupid'        => array(TYPE_UINT,       REQ_YES, VF_METHOD),
		'membergroupids'     => array(TYPE_NOCLEAN,    REQ_NO, VF_METHOD, 'verify_commalist'),
		'displaygroupid'     => array(TYPE_UINT,       REQ_NO, VF_METHOD),

		'styleid'            => array(TYPE_UINT,       REQ_NO),
		'languageid'         => array(TYPE_UINT,       REQ_NO),

		'options'            => array(TYPE_UINT,       REQ_YES),
		'showvbcode'         => array(TYPE_INT,        REQ_NO, 'if (!in_array($data, array(0, 1, 2))) { $data = 1; } return true;'),
		'showbirthday'       => array(TYPE_INT,        REQ_NO, 'if (!in_array($data, array(0, 1, 2))) { $data = 2; } return true;'),
		'threadedmode'       => array(TYPE_INT,        REQ_NO, VF_METHOD),
		'maxposts'           => array(TYPE_INT,        REQ_NO, VF_METHOD),
		'ipaddress'          => array(TYPE_STR,        REQ_NO, VF_METHOD),
		'referrerid'         => array(TYPE_NOHTML,     REQ_NO, VF_METHOD),
		'posts'              => array(TYPE_UINT,       REQ_NO),
		'daysprune'          => array(TYPE_INT,        REQ_NO),
		'startofweek'        => array(TYPE_INT,        REQ_NO),
		'timezoneoffset'     => array(TYPE_STR,        REQ_NO),
		'autosubscribe'      => array(TYPE_INT,        REQ_NO, VF_METHOD),

		'homepage'           => array(TYPE_STR,        REQ_NO, VF_METHOD),
		'icq'                => array(TYPE_NOHTML,     REQ_NO),
		'aim'                => array(TYPE_NOHTML,     REQ_NO),
		'yahoo'              => array(TYPE_NOHTML,     REQ_NO),
		'msn'                => array(TYPE_STR,        REQ_NO, VF_METHOD),

		'usertitle'          => array(TYPE_STR,        REQ_NO),
		'customtitle'        => array(TYPE_UINT,       REQ_NO, 'if (!in_array($data, array(0, 1, 2))) { $data = 0; } return true;'),

		'joindate'           => array(TYPE_UNIXTIME,   REQ_AUTO),
		'lastvisit'          => array(TYPE_UNIXTIME,   REQ_NO),
		'lastactivity'       => array(TYPE_UNIXTIME,   REQ_NO),
		'lastpost'           => array(TYPE_UNIXTIME,   REQ_NO),

		'birthday'           => array(TYPE_NOCLEAN,    REQ_NO, VF_METHOD),
		'birthday_search'    => array(TYPE_STR,        REQ_AUTO),

		'reputation'         => array(TYPE_INT,        REQ_NO, VF_METHOD),
		'reputationlevelid'  => array(TYPE_UINT,       REQ_AUTO),

		'avatarid'           => array(TYPE_UINT,       REQ_NO),
		'avatarrevision'     => array(TYPE_UINT,       REQ_NO),
		'profilepicrevision' => array(TYPE_UINT,       REQ_NO),

		'pmpopup'            => array(TYPE_INT,        REQ_NO),
		'pmtotal'            => array(TYPE_UINT,       REQ_NO),
		'pmunread'           => array(TYPE_UINT,       REQ_NO),

		// usertextfield fields
		'subfolders'         => array(TYPE_NOCLEAN,    REQ_NO, VF_METHOD, 'verify_serialized'),
		'pmfolders'          => array(TYPE_NOCLEAN,    REQ_NO, VF_METHOD, 'verify_serialized'),
		'searchprefs'        => array(TYPE_NOCLEAN,    REQ_NO, VF_METHOD, 'verify_serialized'),
		'buddylist'          => array(TYPE_NOCLEAN,    REQ_NO, VF_METHOD, 'verify_spacelist'),
		'ignorelist'         => array(TYPE_NOCLEAN,    REQ_NO, VF_METHOD, 'verify_spacelist'),
		'signature'          => array(TYPE_STR,        REQ_NO, VF_METHOD),
		'rank'               => array(TYPE_STR,        REQ_NO),
	);

	/**
	* Array of field names that are bitfields, together with the name of the variable in the registry with the definitions.
	*
	* @var	array
	*/
	var $bitfields = array('options' => 'bf_misc_useroptions');

	/**
	* The main table this class deals with
	*
	* @var	string
	*/
	var $table = 'user';

	/**
	* Arrays to store stuff to save to user-related tables
	*
	* @var	array
	* @var	array
	* @var	array
	*/
	var $user = array();
	var $userfield = array();
	var $usertextfield = array();

	/**
	* Condition for update query
	*
	* @var	array
	*/
	var $condition_construct = array('userid = %1$d', 'userid');

	/**
	* Whether or not we have inserted an administrator record
	*
	* @var	boolean
	*/
	var $insertedadmin = false;

	/**
	* Whether or not to skip some checks from the admin cp
	*
	* @var	boolean
	*/
	var $adminoverride = false;

	/**
	* Constructor - checks that the registry object has been passed correctly.
	*
	* @param	vB_Registry	Instance of the vBulletin data registry object - expected to have the database object as one of its $this->db member.
	* @param	integer		One of the ERRTYPE_x constants
	*/
	function vB_DataManager_User(&$registry, $errtype = ERRTYPE_STANDARD)
	{
		parent::vB_DataManager($registry, $errtype);

		($hook = vBulletinHook::fetch_hook('userdata_start')) ? eval($hook) : false;
	}

	// #############################################################################
	// data verification functions

	/**
	* Verifies that the user's homepage is valid
	*
	* @param	string	URL
	*
	* @return	boolean
	*/
	function verify_homepage(&$homepage)
	{
		return (empty($homepage)) ? true : $this->verify_link($homepage);
	}

	/**
	* Verifies that $threadedmode is a valid value, and sets the appropriate options to support it.
	*
	* @param	integer	Threaded mode: 0 = linear, oldest first; 1 = threaded; 2 = hybrid; 3 = linear, newest first
	*
	* @return	boolean
	*/
	function verify_threadedmode(&$threadedmode)
	{
		// ensure that provided value is valid
		if (!in_array($threadedmode, array(0, 1, 2, 3)))
		{
			$threadedmode = 0;
		}

		// fix linear, newest first
		if ($threadedmode == 3)
		{
			$this->set_bitfield('options', 'postorder', 1);
			$threadedmode = 0;
		}
		// fix linear, oldest first
		else if ($threadedmode == 0)
		{
			$this->set_bitfield('options', 'postorder', 0);
		}

		// set threadedmode to linear / oldest first if threadedmode is disabled
		if ($threadedmode > 0 AND !$this->registry->options['allowthreadedmode'])
		{
			$this->set_bitfield('options', 'postorder', 0);
			$threadedmode = 0;
		}

		return true;
	}

	/**
	* Verifies that an autosubscribe choice is valid and workable
	*
	* @param	integer	Autosubscribe choice: (-1: no subscribe; 0: subscribe, no email; 1: instant email; 2: daily email; 3: weekly email; 4: instant icq notification (dodgy))
	*
	* @return	boolean
	*/
	function verify_autosubscribe(&$autosubscribe)
	{
		// check that the subscription choice is valid
		switch ($autosubscribe)
		{
			// the choice is good
			case -1:
			case 0:
			case 1:
			case 2:
			case 3:
				break;

			// check that ICQ number is valid
			case 4:
				if (!preg_match('#^[0-9\-]+$', $this->fetch_field('icq')))
				{
					// icq number is bad
					$this->set('icq', '');
					$autosubscribe = 1;
				}
				break;

			// all other options
			default:
				$autosubscribe = -1;
				break;
		}

		return true;
	}

	/**
	* Verifies the value of user.maxposts, setting the forum default number if the value is invalid
	*
	* @param	integer	Maximum posts per page
	*
	* @return	boolean
	*/
	function verify_maxposts(&$maxposts)
	{
		if (!in_array($maxposts, explode(',', $this->registry->options['usermaxposts'])))
		{
			$maxposts = -1;
		}

		return true;
	}

	/**
	* Verifies a valid reputation value, and sets the appropriate reputation level
	*
	* @param	integer	Reputation value
	*
	* @return	boolean
	*/
	function verify_reputation(&$reputation)
	{
		$reputationlevel = $this->dbobject->query_first("
			SELECT reputationlevelid
			FROM " . TABLE_PREFIX . "reputationlevel
			WHERE $reputation >= minimumreputation
			ORDER BY minimumreputation DESC
			LIMIT 1
		");

		$this->set('reputationlevelid', intval($reputationlevel['reputationlevelid']));

		return true;
	}

	/**
	* Verifies that the provided username is valid, and attempts to correct it if it is not valid
	*
	* @param	string	Username
	*
	* @return	boolean	Returns true if the username is valid, or has been corrected to be valid
	*/
	function verify_username(&$username)
	{
		// fix extra whitespace and invisible ascii stuff
		$username = trim(preg_replace('#\s+#si', ' ', strip_blank_ascii($username, ' ')));

		$length = vbstrlen($username);
		if ($length == 0)
		{ // check for empty string
			$this->error('fieldmissing_username');
			return false;
		}
		else if ($length < $this->registry->options['minuserlength'] AND !$this->adminoverride)
		{
			// name too short
			$this->error('usernametooshort', $this->registry->options['minuserlength']);
			return false;
		}
		else if ($length > $this->registry->options['maxuserlength'] AND !$this->adminoverride)
		{
			// name too long
			$this->error('usernametoolong', $this->registry->options['maxuserlength']);
			return false;
		}
		else if (preg_match('/(?<!&#[0-9]{3}|&#[0-9]{4}|&#[0-9]{5});/', $username))
		{
			// name contains semicolons
			$this->error('username_contains_semi_colons');
			return false;
		}
		else if ($username != fetch_censored_text($username) AND !$this->adminoverride)
		{
			// name contains censored words
			$this->error('censorfield');
			return false;
		}
		else if (htmlspecialchars_uni($username) != $this->existing['username'] AND $this->dbobject->query_first("
			SELECT userid, username FROM " . TABLE_PREFIX . "user
			WHERE userid != " . intval($this->existing['userid']) . "
			AND
			(
				username = '" . $this->dbobject->escape_string(htmlspecialchars_uni($username)) . "'
				OR
				username = '" . $this->dbobject->escape_string(htmlspecialchars_uni(preg_replace('/&#([0-9]+);/esiU', "convert_int_to_utf8('\\1')", $username))) . "'
			)
		"))
		{
			// name is already in use
			$this->error('usernametaken', $username, $this->registry->session->vars['sessionurl']);
			return false;
		}
		else if (htmlspecialchars_uni($username) != $this->existing['username'] AND !empty($this->registry->options['illegalusernames']) AND !$this->adminoverride)
		{
			// check for illegal username
			$usernames = preg_split('/\s+/', $this->registry->options['illegalusernames'], -1, PREG_SPLIT_NO_EMPTY);
			foreach ($usernames AS $val)
			{
				if (strpos(strtolower($username), strtolower($val)) !== false)
				{
					// wierd error to show, but hey...
					$this->error('usernametaken', $username, $this->registry->session->vars['sessionurl']);
					return false;
				}
			}
		}

		// if we got here, everything is okay
		$username = htmlspecialchars_uni($username);
		return true;
	}

	/**
	* Verifies that the provided birthday is valid
	*
	* @param	mixed	Birthday - can be yyyy-mm-dd, mm-dd-yyyy or an array containing day/month/year and converts it into a valid yyyy-mm-dd
	*
	* @return	boolean
	*/
	function verify_birthday(&$birthday)
	{	
		if (!$this->adminoverride AND $this->registry->options['reqbirthday'])
		{	// required birthday. If current birthday is acceptable, don't go any further (bypass form manipulation)
			$bday = explode('-', $this->existing['birthday']);
			if ($bday[2] > 1901 AND $bday[2] < date('Y') AND @checkdate($bday[0], $bday[1], $bday[2]))
			{
				$this->set('birthday_search', $bday[2] . '-' . $bday[0] . '-' . $bday[1]);
				$birthday = "$bday[0]-$bday[1]-$bday[2]";
				return true;
			}
		}
		
		if (!is_array($birthday))
		{
			// check for yyyy-mm-dd string
			if (preg_match('#^(\d{4})-(\d{1,2})-(\d{1,2})$#', $birthday, $match))
			{
				$birthday = array('day' => $match[3], 'month' => $match[2], 'year' => $match[1]);
			}
			// check for mm-dd-yyyy string
			else if (preg_match('#^(\d{1,2})-(\d{1,2})-(\d{4})$#', $birthday, $match))
			{
				$birthday = array('day' => $match[2], 'month' => $match[1], 'year' => $match[3]);
			}
		}

		// check that all neccessary array keys are set
		if (!isset($birthday['day']) OR !isset($birthday['month']) OR !isset($birthday['year']))
		{
			$this->error('birthdayfield');
			return false;
		}

		// force all array keys to integer
		$birthday = $this->registry->input->clean_array($birthday, array(
			'day' =>   TYPE_INT,
			'month' => TYPE_INT,
			'year' =>  TYPE_INT
		));

		if (
			($birthday['day'] <= 0 AND $birthday['month'] > 0) OR
			($birthday['day'] > 0 AND $birthday['month'] <= 0) OR
			(!$this->adminoverride AND $this->registry->options['reqbirthday'] AND ($birthday['day'] <= 0 OR $birthday['month'] <= 0 OR $birthday['year'] <= 0))
		)
		{
			$this->error('birthdayfield');
			return false;
		}

		if ($birthday['day'] <= 0 AND $birthday['month'] <= 0)
		{
			$this->set('birthday_search', '');
			$birthday = '';

			return true;
		}
		else if (
			($birthday['year'] <= 0 OR (
				$birthday['year'] > 1901 AND $birthday['year'] < date('Y')
			)) AND
			checkdate($birthday['month'], $birthday['day'], ($birthday['year'] == 0 ? 1996 : $birthday['year']))
		)
		{
			$birthday['day']   = str_pad($birthday['day'],   2, '0', STR_PAD_LEFT);
			$birthday['month'] = str_pad($birthday['month'], 2, '0', STR_PAD_LEFT);
			$birthday['year']  = str_pad($birthday['year'],  4, '0', STR_PAD_LEFT);

			$this->set('birthday_search', $birthday['year'] . '-' . $birthday['month'] . '-' . $birthday['day']);

			$birthday = "$birthday[month]-$birthday[day]-$birthday[year]";

			return true;
		}
		else
		{
			$this->error('birthdayfield');
			return false;
		}
	}

	/**
	* Verifies that everything is hunky dory with the user's email field
	*
	* @param	string	Email address
	*
	* @return	boolean
	*/
	function verify_useremail(&$email)
	{
		// check for empty string
		if ($email == '')
		{
			$this->error('fieldmissing_email');
			return false;
		}

		// check valid email address
		if (!$this->verify_email($email))
		{
			$this->error('bademail');
			return false;
		}

		$email_changed = (!isset($this->existing['email']) OR $email != $this->existing['email']);

		// check banned email addresses
		require_once(DIR . '/includes/functions_user.php');
		if (is_banned_email($email) AND !$this->adminoverride)
		{
			if ($email_changed OR !$this->registry->options['allowkeepbannedemail'])
			{
				// throw error if this is a new registration, or if updating users are not allowed to keep banned addresses
				$this->error('banemail', $this->registry->options['webmasteremail']);
				return false;
			}
		}

		// check unique address
		if ($this->registry->options['requireuniqueemail'] AND $email_changed)
		{
			if ($this->dbobject->query_first("
				SELECT userid, username, email
				FROM " . TABLE_PREFIX . "user
				WHERE email = '" . $this->dbobject->escape_string($email) . "'
					" . ($this->condition !== null ? 'AND userid <> ' . intval($this->existing['userid']) : '') . "
			"))
			{
				$this->error('emailtaken', $this->registry->session->vars['sessionurl']);
				return false;
			}
		}

		return true;
	}

	/**
	* Verifies that the provided parent email address is valid
	*
	* @param	string	Email address
	*
	* @return	boolean
	*/
	function verify_parentemail(&$parentemail)
	{
		if ($parentemail == '')
		{
			if ($this->info['coppauser'])
			{
				$this->error('fieldmissing_parentemail');
			}
			else
			{
				return true;
			}
		}
		else if ($this->verify_email($parentemail))
		{
			if ($this->info['coppauser'])
			{
				eval(fetch_email_phrases('parentcoppa'));
				vbmail($parentemail, $subject, $message, true);
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* Verifies that the usergroup provided is valid
	*
	* @param	integer	Usergroup ID
	*
	* @return	boolean
	*/
	function verify_usergroupid(&$usergroupid)
	{
		// if usergroupids is set because of email validation, don't allow it to be re-written
		if (isset($this->info['override_usergroupid']) AND $usergroupid != $this->user['usergroupid'])
		{
			$this->error("::Usergroup ID is already set to {$this->user[usergroupid]} and can not be changed due to email validation regulations::");
			return false;
		}

		if ($usergroupid < 1)
		{
			$usergroupid = 2;
		}

		return true;
	}

	/**
	* Verifies that the provided displaygroup ID is valid
	*
	* @param	integer	Display group ID
	*
	* @return	boolean
	*/
	function verify_displaygroupid(&$displaygroupid)
	{
		if ($displaygroupid == $this->fetch_field('usergroupid') OR in_array($displaygroupid, explode(',', $this->fetch_field('membergroupids'))))
		{
			return true;
		}
		else
		{
			$displaygroupid = 0;
			return true;
		}
	}

	/**
	* Verifies a specified referrer
	*
	* @param	mixed	Referrer - either a user ID or a user name
	*
	* @return	boolean
	*/
	function verify_referrerid(&$referrerid)
	{
		if (!$this->registry->options['usereferrer'] OR $referrerid == '')
		{
			$referrerid = 0;
			return true;
		}
		else if ($user = $this->dbobject->query_first("SELECT userid, username FROM " . TABLE_PREFIX . "user WHERE username = '" . $this->dbobject->escape_string($referrerid) . "'"))
		{
			$referrerid = $user['userid'];
		}
		else if (is_numeric($referrerid) AND $user = $this->dbobject->query_first("SELECT userid, username FROM " . TABLE_PREFIX . "user WHERE userid = " . intval($referrerid)))
		{
			$referrerid = $user['userid'];
		}
		else
		{
			$this->error('invalid_referrer_specified');
			return false;
		}

		if ($referrerid > 0 AND $referrerid == $this->existing['userid'])
		{
			$this->error('invalid_referrer_specified');
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	* Verifies an MSN handle
	*
	* @param	string	MSN handle (email address)
	*
	* @return	boolean
	*/
	function verify_msn(&$msn)
	{
		if ($msn == '' OR $this->verify_email($msn))
		{
			$msn = htmlspecialchars_uni($msn);
			return true;
		}
		else
		{
			$this->error('badmsn');
			return false;
		}
	}

	// #############################################################################
	// password related

	/**
	* Converts a PLAIN TEXT (or valid md5 hash) password into a hashed password
	*
	* @param	string	The plain text password to be converted
	*
	* @return	boolean
	*/
	function verify_password(&$password)
	{
		if (!($salt = $this->fetch_field('salt')))
		{
			$this->user['salt'] = $salt = $this->fetch_user_salt();
		}

		// generate the password
		$password = $this->hash_password($password, $salt);

		$this->set('passworddate', 'FROM_UNIXTIME(' . TIMENOW . ')', false);

		return true;
	}

	/**
	* Verifies that the user salt is valid
	*
	* @param	string	The salt string
	*
	* @return	boolean
	*/
	function verify_salt(&$salt)
	{
		$this->error('::You may not set salt manually.::');
		return false;
	}

	/**
	* Takes a plain text or singly-md5'd password and returns the hashed version for storage in the database
	*
	* @param	string	Plain text or singly-md5'd password
	*
	* @return	string	Hashed password
	*/
	function hash_password($password, $salt)
	{
		// if the password is not already an md5, md5 it now
		if ($password == '')
		{
		}
		else if (!$this->verify_md5($password))
		{
			$password = md5($password);
		}

		// hash the md5'd password with the salt
		return md5($password . $salt);
	}

	/**
	* Generates a new user salt string
	*
	* @param	integer	(Optional) the length of the salt string to generate
	*
	* @return	string
	*/
	function fetch_user_salt($length = SALT_LENGTH)
	{
		$salt = '';

		for ($i = 0; $i < $length; $i++)
		{
			$salt .= chr(rand(32, 126));
		}

		return $salt;
	}

	/**
	* Checks to see if a password is in the user's password history
	*
	* @param	integer	User ID
	* @param	integer	History time ($permissions['passwordhistory'])
	*
	* @return	boolean	Returns true if password is in the history
	*/
	function check_password_history($password, $historylength)
	{
		// delete old password history
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "passwordhistory
			WHERE userid = " . $this->existing['userid'] . "
			AND passworddate <= FROM_UNIXTIME(" . (TIMENOW - $historylength * 86400) . ")
		");

		// check to see if the password is invalid due to previous use
		if ($historylength AND $historycheck = $this->dbobject->query_first("
			SELECT UNIX_TIMESTAMP(passworddate) AS passworddate
			FROM " . TABLE_PREFIX . "passwordhistory
			WHERE userid = " . $this->existing['userid'] . "
			AND password = '" . $this->dbobject->escape_string($password) . "'"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// #############################################################################
	// signature related

	/**
	* Verifies that the given string is a valid signature
	*
	* @param	string	The signature string
	*
	* @return	boolean
	*/
	function verify_signature(&$signature)
	{
		if (vbstrlen(strip_bbcode($signature, false, false, false)) > $this->registry->options['sigmax'])
		{
			$signature = substr($signature, 0, $this->registry->options['sigmax']);
		}
		return true;
	}

	// #############################################################################
	// user title

	/**
	* Sets the values for user[usertitle] and user[customtitle]
	*
	* @param	string	Custom user title text
	* @param	boolean	Whether or not to reset a custom title to the default user title
	* @param	array	Array containing all information for the user's primary usergroup
	* @param	boolean	Whether or not a user can use custom user titles ($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canusecustomtitle'])
	* @param	boolean	Whether or not the user is an administrator ($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel'])
	*/
	function set_usertitle($customtext, $reset, $usergroup, $canusecustomtitle, $isadmin)
	{
		$customtitle = $this->existing['customtitle'];
		$usertitle = $this->existing['usertitle'];

		if ($canusecustomtitle)
		{
			// user is allowed to set a custom title
			if ($reset OR ($customtitle == 0 AND $customtext === ''))
			{
				// reset custom title or we don't have one but are allowed to
				if (empty($usergroup['usertitle']))
				{
					$gettitle = $this->dbobject->query_first("
						SELECT title
						FROM " . TABLE_PREFIX . "usertitle
						WHERE minposts <= " . intval($this->existing['posts']) . "
						ORDER BY minposts DESC
						LIMIT 1
					");
					$usertitle = $gettitle['title'];
				}
				else
				{
					$usertitle = $usergroup['usertitle'];
				}
				$customtitle = 0;
			}
			else if ($customtext)
			{
				// set custom text
				$usertitle = fetch_censored_text($customtext);
				if (!can_moderate() OR (can_moderate() AND !$this->registry->options['ctCensorMod']))
				{
					$usertitle = $this->censor_custom_title($usertitle);
				}
				$customtitle = $isadmin ?
					1: // administrator - don't run htmlspecialchars
					2; // regular user - run htmlspecialchars
				if ($customtitle == 2)
				{
					$usertitle = fetch_word_wrapped_string($usertitle, 25);
				}
			}
		}
		else if ($customtitle != 1)
		{
			if (empty($usergroup['usertitle']))
			{
				$gettitle = $this->dbobject->query_first("
					SELECT title
					FROM " . TABLE_PREFIX . "usertitle
					WHERE minposts <= " . intval($this->existing['posts']) . "
					ORDER BY minposts DESC
					LIMIT 1
				");
				$usertitle = $gettitle['title'];
			}
			else
			{
				$usertitle = $usergroup['usertitle'];
			}
			$customtitle = 0;
		}

		$this->set('usertitle', $usertitle);
		$this->set('customtitle', $customtitle);
	}

	/**
	* Checks a string for words banned in custom user titles and replaces them with the censor character
	*
	* @param	string	Custom user title
	*
	* @return	string	The censored string
	*/
	function censor_custom_title($usertitle)
	{
		static $ctcensorwords;

		if (empty($ctcensorwords))
		{
			$ctcensorwords = preg_split('#\s+#', preg_quote($this->registry->options['ctCensorWords'], '#'), -1, PREG_SPLIT_NO_EMPTY);
		}

		foreach ($ctcensorwords AS $censorword)
		{
			if (substr($censorword, 0, 2) == '\\{')
			{
				$censorword = substr($censorword, 2, -2);
				$usertitle = preg_replace('#(?<=[^A-Za-z]|^)' . $censorword . '(?=[^A-Za-z]|$)#si', str_repeat($this->registry->options['censorchar'], vbstrlen($censorword)), $usertitle);
			}
			else
			{
				$usertitle = preg_replace("#$censorword#si", str_repeat($this->registry->options['censorchar'], vbstrlen($censorword)), $usertitle);
			}
		}

		return $usertitle;
	}

	// #############################################################################
	// user profile fields

	/**
	* Validates and sets custom user profile fields
	*
	* @param	array	Array of values for profile fields. Example: array('field1' => 'One', 'field2' => array(0 => 'a', 1 => 'b'), 'field2_opt' => 'c')
	* @param	bool	Whether or not to verify the data actually matches any specified regexes or required fields
	* @param	string	What type of editable value to apply (admin, register, normal)
	*
	* @return	string	Textual description of set profile fields (for email phrase)
	*/
	function set_userfields(&$values, $verify = true, $all_fields = 'normal')
	{
		if (!is_array($values))
		{
			$this->error('::$values for profile fields is not an array::');
			return false;
		}

		$customfields = '';

		$field_ids = array();
		foreach (array_keys($values) AS $key)
		{
			if (preg_match('#^field(\d+)\w*$#', $key, $match))
			{
				$field_ids["$match[1]"] = $match[1];
			}
		}
		if (empty($field_ids))
		{
			return false;
		}

		switch($all_fields)
		{
			case 'admin':
				$all_fields_sql = '';
				break;

			case 'register':
				$all_fields_sql = 'AND editable IN (1, 2)';
				break;

			case 'normal':
			default:
				$all_fields_sql = 'AND editable = 1';
				break;
		}

		// check extra profile fields
		$profilefields = $this->dbobject->query_read("
			SELECT profilefieldid, required, title, size, maxlength, type, data, optional, regex
			FROM " . TABLE_PREFIX . "profilefield
			WHERE profilefieldid IN(" . implode(', ', $field_ids) . ")
				$all_fields_sql
		");
		while ($profilefield = $this->dbobject->fetch_array($profilefields))
		{
			$varname = 'field' . $profilefield['profilefieldid'];
			$value =& $values["$varname"];

			$optionalvar = 'field' . $profilefield['profilefieldid'] . '_opt';
			$value_opt =& $values["$optionalvar"];

			// text box / text area
			if ($profilefield['type'] == 'input' OR $profilefield['type'] == 'textarea')
			{
				$value = substr(fetch_censored_text($value), 0, $profilefield['maxlength']);
				$customfields .= "$profilefield[title] : $value\n";
			}
			// radio / select
			else if ($profilefield['type'] == 'radio' OR $profilefield['type'] == 'select')
			{
				if ($profilefield['optional'] AND $value_opt != '')
				{
					$value = substr(fetch_censored_text($value_opt), 0, $profilefield['maxlength']);
				}
				else
				{
					$data = unserialize($profilefield['data']);
					$value -= 1;
					if (isset($data["$value"]))
					{
						$value = unhtmlspecialchars(trim($data["$value"]));
					}
					else
					{
						$value = false;
					}
				}
				$customfields .= "$profilefield[title] : $value\n";
			}
			// checkboxes or select multiple
			else if ($profilefield['type'] == 'checkbox' OR $profilefield['type'] == 'select_multiple')
			{
				if (is_array($value))
				{
					if (($profilefield['size'] == 0) OR (sizeof($value) <= $profilefield['size']))
					{
						$data = unserialize($profilefield['data']);

						$bitfield = 0;
						$cfield = '';
						foreach($value AS $key => $val)
						{
							$val--;
							$bitfield += pow(2, $val);
							$cfield .= (!empty($cfield) ? ', ' : '') . $data["$val"];
						}
						$value = $bitfield;
					}
					else
					{
						$this->error('checkboxsize', $profilefield['size'], $profilefield['title']);
						$value = false;
					}
				}
				else
				{
					$value = false;
				}
				$customfields .= "$profilefield[title] : $cfield\n";
			}

			// check for regex compliance
			if ($profilefield['regex'] AND $verify)
			{
				if (!preg_match('#' . str_replace('#', '\#', $profilefield['regex']) . '#siU', $value))
				{
					if ($value != '')
					{
						$this->error('regexincorrect', $profilefield['title']);
						$value = false;
					}

				}
			}

			// check for empty required fields
			if ($profilefield['required'] == 1 AND $value === false AND $verify)
			{
				$this->error('required_field_x_missing_or_invalid', $profilefield['title']);
			}

			$this->setfields["$varname"] = true;
			$this->userfield["$varname"] = htmlspecialchars_uni($value);
		}
		$this->dbobject->free_result($profilefields);

		return $customfields;
	}

	// #############################################################################
	// daylight savings

	/**
	* Sets DST options
	*
	* @param	integer	DST choice: (2: automatic; 1: auto-off, dst on; 0: auto-off, dst off)
	*/
	function set_dst(&$dst)
	{
		switch ($dst)
		{
			case 2:
				$dstauto = 1;
				$dstonoff = $this->existing['dstonoff'];
				break;
			case 1:
				$dstauto = 0;
				$dstonoff = 1;
				break;
			default:
				$dstauto = 0;
				$dstonoff = 0;
				break;
		}

		$this->set_bitfield('options', 'dstauto', $dstauto);
		$this->set_bitfield('options', 'dstonoff', $dstonoff);
	}

	// #############################################################################
	// fill in missing fields from registration default options

	/**
	* Sets registration defaults
	*/
	function set_registration_defaults()
	{
		// on/off fields
		foreach (array(
			'invisible'      => 'invisiblemode',
			'receivepm'      => 'enablepm',
			'emailonpm'      => 'emailonpm',
			'showreputation' => 'showreputation',
			'showvcard'      => 'vcard',
			'showsignatures' => 'signature',
			'showavatars'    => 'avatar',
			'showimages'     => 'image'
		) AS $optionname => $bitfield)
		{
			if (!isset($this->user['options']["$optionname"]))
			{
				$this->set_bitfield('options', $optionname, ($this->registry->bf_misc_regoptions["$bitfield"] & $this->registry->options['defaultregoptions'] ? 1 : 0));
			}
		}

		// time fields
		foreach (array('joindate', 'lastvisit', 'lastactivity') AS $datefield)
		{
			if (!isset($this->user["$datefield"]))
			{
				$this->set($datefield, TIMENOW);
			}
		}

		// auto subscription
		if (!isset($this->user['autosubscribe']))
		{
			if ($this->registry->bf_misc_regoptions['subscribe_none'] & $this->registry->options['defaultregoptions'])
			{
				$autosubscribe = -1;
			}
			else if ($this->registry->bf_misc_regoptions['subscribe_nonotify'] & $this->registry->options['defaultregoptions'])
			{
				$autosubscribe = 0;
			}
			else if ($this->registry->bf_misc_regoptions['subscribe_instant'] & $this->registry->options['defaultregoptions'])
			{
				$autosubscribe = 1;
			}
			else if ($this->registry->bf_misc_regoptions['subscribe_daily'] & $this->registry->options['defaultregoptions'])
			{
				$autosubscribe = 2;
			}
			else
			{
				$autosubscribe = 3;
			}
			$this->set('autosubscribe', $autosubscribe);
		}

		// show vbcode
		if (!isset($this->user['showvbcode']))
		{
			if ($this->registry->bf_misc_regoptions['vbcode_none'] & $this->registry->options['defaultregoptions'])
			{
				$showvbcode = 0;
			}
			else if ($this->registry->bf_misc_regoptions['vbcode_standard'] & $this->registry->options['defaultregoptions'])
			{
				$showvbcode = 1;
			}
			else
			{
				$showvbcode = 2;
			}
			$this->set('showvbcode', $showvbcode);
		}

		// post order / thread display mode
		if (!isset($this->user['threadedmode']))
		{
			if ($this->registry->bf_misc_regoptions['thread_linear_oldest'] & $this->registry->options['defaultregoptions'])
			{
				$threadedmode = 0;
			}
			else if ($this->registry->bf_misc_regoptions['thread_linear_newest'] & $this->registry->options['defaultregoptions'])
			{
				$threadedmode = 0;
			}
			else if ($this->registry->bf_misc_regoptions['thread_threaded'] & $this->registry->options['defaultregoptions'])
			{
				$threadedmode = 1;
			}
			else if ($this->registry->bf_misc_regoptions['thread_hybrid'] & $this->registry->options['defaultregoptions'])
			{
				$threadedmode = 2;
			}
			else
			{
				$threadedmode = 0;
			}
			$this->set('threadedmode', $threadedmode);
		}

		// usergroupid
		if (!isset($this->user['usergroupid']))
		{
			if ($this->registry->options['verifyemail'])
			{
				$usergroupid = 3;
			}
			else if ($this->registry->options['moderatenewmembers'] OR $this->info['coppauser'])
			{
				$usergroupid = 4;
			}
			else
			{
				$usergroupid = 2;
			}
			$this->set('usergroupid', $usergroupid);
		}

		// reputation
		if (!isset($this->user['reputation']))
		{
			$this->set('reputation', $this->registry->options['reputationdefault']);
		}

		// pm popup
		if (!isset($this->user['pmpopup']))
		{
			$this->set('pmpopup', ($this->registry->bf_misc_regoptions['pmpopup'] & $this->registry->options['defaultregoptions'] ? 1 : 0));
		}

		// max posts per page
		if (!isset($this->user['maxposts']))
		{
			$this->set('maxposts', 1);
		}

		// days prune
		if (!isset($this->user['daysprune']))
		{
			$this->set('daysprune', 0);
		}

		// start of week
		if (!isset($this->user['startofweek']))
		{
			$this->set('startofweek', -1);
		}
	}

	// #############################################################################
	// data saving

	/**
	* Takes valid data and sets it as part of the data to be saved
	*
	* @param	string	The name of the field to which the supplied data should be applied
	* @param	mixed	The data itself
	*/
	function do_set($fieldname, &$value)
	{
		$this->setfields["$fieldname"] = true;

		$tables = array();

		switch ($fieldname)
		{
			case 'userid':
			{
				$tables = array('user', 'userfield', 'usertextfield');
			}
			break;

			case 'subfolders':
			case 'pmfolders':
			case 'searchprefs':
			case 'buddylist':
			case 'ignorelist':
			case 'signature':
			case 'rank':
			{
				$tables = array('usertextfield');
			}
			break;

			default:
			{
				$tables = array('user');
			}
		}

		($hook = vBulletinHook::fetch_hook('userdata_doset')) ? eval($hook) : false;

		foreach ($tables AS $table)
		{
			$this->{$table}["$fieldname"] =& $value;
			$this->lasttable = $table;
		}
	}

	/**
	* Saves the data from the object into the specified database tables
	*
	* @param	boolean	Do the query?
	* @param	mixed	Whether to run the query now; see db_update() for more info
	*
	* @return	integer	Returns the user id of the affected data
	*/
	function save($doquery = true, $delayed = false)
	{
		if ($this->has_errors())
		{
			return false;
		}

		if (!$this->pre_save($doquery))
		{
			return 0;
		}

		// UPDATE EXISTING USER
		if ($this->condition)
		{
			// update query
			$return = $this->db_update(TABLE_PREFIX, 'user', $this->condition, $doquery, $delayed);
			if ($return)
			{
				$this->db_update(TABLE_PREFIX, 'userfield',     $this->condition, $doquery, $delayed);
				$this->db_update(TABLE_PREFIX, 'usertextfield', $this->condition, $doquery, $delayed);
			}
		}
		// INSERT NEW USER
		else
		{
			// fill in any registration defaults
			$this->set_registration_defaults();

			// insert query
			if ($return = $this->db_insert(TABLE_PREFIX, 'user', $doquery))
			{
				$this->set('userid', $return);
				$this->db_insert(TABLE_PREFIX, 'userfield',     $doquery);
				$this->db_insert(TABLE_PREFIX, 'usertextfield', $doquery);
			}
		}

		if ($return)
		{
			$this->post_save_each($doquery);
			$this->post_save_once($doquery);
		}

		return $return;
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

		// USERGROUP CHECKS
		$usergroups_changed = $this->usergroups_changed();

		if ($usergroups_changed)
		{
			// VALIDATE USERGROUPID / MEMBERGROUPIDS
			$usergroupid = $this->fetch_field('usergroupid');
			$membergroupids = $this->fetch_field('membergroupids');

			if (strpos(",$membergroupids,", ",$usergroupid,") !== false)
			{
				// usergroupid/membergroups conflict
				$this->error('usergroup_equals_secondary');
				return false;
			}

			// if changing usergroups, validate the displaygroup
			$displaygroupid = $this->fetch_field('displaygroupid');
			$this->verify_displaygroupid($displaygroupid); // this will edit the value if necessary
			$this->do_set('displaygroupid', $displaygroupid);
		}

		if ($this->condition)
		{
			$wasadmin = $this->is_admin($this->existing['usergroupid'], $this->existing['membergroupids'], 'was');
			$isadmin = $this->is_admin($this->fetch_field('usergroupid'), $this->fetch_field('membergroupids'), 'is');

			// if usergroups changed, check we are not de-admining the last admin
			if ($usergroups_changed AND $wasadmin AND !$isadmin AND $this->count_other_admins($this->existing['userid']) == 0)
			{
				$this->error('cant_de_admin_last_admin');
				return false;
			}
		}

		// Attempt to detect if we need a new rank or usertitle
		if ($this->rawfields['posts'])
		{	// posts = posts + 1 / posts - 1 was specified so we need existing posts to determine how many posts we will have
			 if ($this->existing['posts'] != null)
			 {
				$posts = $this->existing['posts'] + preg_replace('#posts\s*([+-])\s*(\d+)#s', '\1\2', $this->fetch_field('posts'));
			}
		}
		else if ($this->fetch_field('posts'))
		{
			$posts = $this->fetch_field('posts');
		}

		if (($this->setfields['membergroupids'] OR $this->setfields['posts'] OR $this->setfields['usergroupid'] OR $this->setfields['displaygroupid']) AND !$this->setfields['rank'] AND isset($posts) AND $userid = $this->fetch_field('userid'))
		{	// item affecting user's rank is changing and a new rank hasn't been given to us
			$userinfo = array(
				'userid' => $userid, // we need an userid for is_member_of's cache routine
				'posts' => $posts
			);
			if (($userinfo['usergroupid'] =& $this->fetch_field('usergroupid')) !== null AND
				($userinfo['displaygroupid'] =& $this->fetch_field('displaygroupid')) !== null AND
				($userinfo['membergroupids'] =& $this->fetch_field('membergroupids')) !== null
			)
			{
				require_once(DIR . '/includes/functions_ranks.php');
				$userrank =& fetch_rank($userinfo);

				if ($userrank != $this->existing['rank'])
				{
					$this->setr('rank', $userrank);
				}
			}
		}

		$return_value = true;
		($hook = vBulletinHook::fetch_hook('userdata_presave')) ? eval($hook) : false;

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
		$userid = $this->fetch_field('userid');

		if (!$userid OR !$doquery)
		{
			return;
		}

		$usergroups_changed = $this->usergroups_changed();
		$wasadmin = $this->is_admin($this->existing['usergroupid'], $this->existing['membergroupids'], 'was');
		$isadmin = $this->is_admin($this->fetch_field('usergroupid'), $this->fetch_field('membergroupids'), 'is');

		if (!$this->condition)
		{
			// save user count and new user id to template
			require_once(DIR . '/includes/functions_databuild.php');
			build_user_statistics();
		}
		else
		{
			// update denormalized username field in various tables
			$this->update_username($userid);

			// if usergroup membership has changed...
			if ($usergroups_changed)
			{
				// update subscriptions
				$this->update_subscriptions($userid, $doquery);

				// update ban status
				$this->update_ban_status($userid, $doquery);
			}
		}

		// admin stuff
		$this->set_admin($userid, $usergroups_changed, $isadmin, $wasadmin);

		// update birthday datastore
		$this->update_birthday_datastore($userid, $doquery);

		// update password history
		$this->update_password_history($userid, $doquery);

		// reset style cookie
		$this->update_style_cookie($userid, $doquery);

		// reset threadedmode cookie
		$this->update_threadedmode_cookie($userid, $doquery);

		($hook = vBulletinHook::fetch_hook('userdata_postsave')) ? eval($hook) : false;
	}

	/**
	* Deletes a user
	*
	* @return	mixed	The number of affected rows
	*/
	function delete($doquery = true)
	{
		if (!$this->existing['userid'])
		{
			return false;
		}

		if (!$this->pre_delete($doquery))
		{
			return false;
		}

		$return = $this->db_delete(TABLE_PREFIX, 'user', $this->condition, $doquery);
		if ($return)
		{
			$this->db_delete(TABLE_PREFIX, 'userfield', $this->condition, $doquery);
			$this->db_delete(TABLE_PREFIX, 'usertextfield', $this->condition, $doquery);

			$this->post_delete($doquery);
		}

		return $return;
	}

	/**
	* Any code to run after deleting
	*
	* @param	Boolean Do the query?
	*/
	function post_delete($doquery = true)
	{
		$this->dbobject->query_write("
			UPDATE " . TABLE_PREFIX . "post SET
				username = '" . $this->dbobject->escape_string($this->existing['username']) . "',
				userid = 0
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			UPDATE " . TABLE_PREFIX . "usernote SET
				username = '" . $this->dbobject->escape_string($this->existing['username']) . "',
				posterid = 0
			WHERE posterid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "usernote
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "access
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "event
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "customavatar
			WHERE userid = " . $this->existing['userid'] . "
		");

		@unlink($this->registry->options['avatarpath'] . '/avatar' . $this->existing['userid'] . '_' . $this->existing['avatarrevision'] . '.gif');

		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "customprofilepic
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "moderator
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "subscribeforum
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "subscribethread
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "subscribeevent
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "subscriptionlog
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "session
			WHERE userid = " . $this->existing['userid'] . "
		");
		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "userban
			WHERE userid = " . $this->existing['userid'] . "
		");

		$this->dbobject->query_write("
			DELETE FROM " . TABLE_PREFIX . "usergrouprequest
			WHERE userid = " . $this->existing['userid'] . "
		");

		$admindm =& datamanager_init('Admin', $this->registry, ERRTYPE_SILENT);
		$admindm->set_existing($this->existing);
		$admindm->delete();
		unset($admindm);

		require_once(DIR . '/includes/adminfunctions.php');
		delete_user_pms($this->existing['userid'], false);

		require_once(DIR . '/includes/functions_databuild.php');
		build_user_statistics();

		($hook = vBulletinHook::fetch_hook('userdata_delete')) ? eval($hook) : false;
	}

	// #############################################################################
	// functions that are executed as part of the user save routine

	/**
	* Updates all denormalized tables that contain a 'username' field (or field that holds a username)
	*
	* @param	integer	User ID
	* @param	string	The user name. Helpful if you want to call this function from outside the DM.
	*/
	function update_username($userid, $username = null)
	{
		if ($username != null AND $username != '')
		{
			$doupdate = true;
		}
		else if (isset($this->user['username']) AND $this->user['username'] != $this->existing['username'])
		{
			$doupdate = true;
			$username = $this->user['username'];
		}
		else
		{
			$doupdate = false;
		}

		if ($doupdate)
		{
			// pm receipt 'tousername'
			$this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "pmreceipt SET
					tousername = '" . $this->dbobject->escape_string($username) . "'
				WHERE touserid = $userid
			");

			// pm text 'fromusername'
			$this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "pmtext SET
					fromusername = '" . $this->dbobject->escape_string($username) . "'
				WHERE fromuserid = $userid
			");

			// these updates work only when the old username is known,
			// so don't bother forcing them to update if the names aren't different
			if ($this->existing['username'] != $username)
			{
				// pm text 'touserarray'
				$this->dbobject->query_write("
					UPDATE " . TABLE_PREFIX . "pmtext SET
						touserarray = REPLACE(touserarray,
							'i:$userid;s:" . strlen($this->existing['username']) . ":\"" . $this->dbobject->escape_string($this->existing['username']) . "\";',
							'i:$userid;s:" . strlen($username) . ":\"" . $this->dbobject->escape_string($username) . "\";'
						)
					WHERE touserarray LIKE '%i:$userid;s:" . strlen($this->existing['username']) . ":\"" . $this->dbobject->escape_string_like($this->existing['username']) . "\";%'
				");

				// forum 'lastposter'
				$this->dbobject->query_write("
					UPDATE " . TABLE_PREFIX . "forum SET
						lastposter = '" . $this->dbobject->escape_string($username) . "'
					WHERE lastposter = '" . $this->dbobject->escape_string($this->existing['username']) . "'
				");

				// thread 'lastposter'
				$this->dbobject->query_write("
					UPDATE " . TABLE_PREFIX . "thread SET
						lastposter = '" . $this->dbobject->escape_string($username) . "'
					WHERE lastposter = '" . $this->dbobject->escape_string($this->existing['username']) . "'
				");
			}

			// thread 'postusername'
			$this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "thread SET
					postusername = '" . $this->dbobject->escape_string($username) . "'
				WHERE postuserid = $userid
			");

			// post 'username'
			$this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "post SET
					username = '" . $this->dbobject->escape_string($username) . "'
				WHERE userid = $userid
			");

	        // usernote 'username'
	        $this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "usernote
				SET username = '" . $this->dbobject->escape_string($username) . "'
				WHERE posterid = $userid
			");

			// deletionlog 'username'
			$this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "deletionlog
				SET username = '" . $this->dbobject->escape_string($username) . "'
				WHERE userid = $userid
			");

			// editlog 'username'
			$this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "editlog
				SET username = '" . $this->dbobject->escape_string($username) . "'
				WHERE userid = $userid
			");

			//  Rebuild newest user information
			require_once(DIR . '/includes/functions_databuild.php');
			build_user_statistics();

			($hook = vBulletinHook::fetch_hook('userdata_update_username')) ? eval($hook) : false;
		}
	}

	/**
	* Updates user subscribed threads/forums to reflect new permissions
	*
	* @param	integer	User ID
	*/
	function update_subscriptions($userid)
	{
		unset($this->existing['forumpermissions']);
		$this->existing['permissions'] = cache_permissions($this->existing);

		$old_canview = array();
		$old_canviewthreads = array();
		foreach ($this->existing['forumpermissions'] AS $forumid => $perms)
		{
			if ($perms & $this->registry->bf_ugp_forumpermissions['canview'])
			{
				$old_canview[] = $forumid;
			}
			if ($perms & $this->registry->bf_ugp_forumpermissions['canviewthreads'])
			{
				$old_canviewthreads[] = $forumid;
			}
		}

		$user_perms = array(
			'userid' => $this->fetch_field('userid'),
			'usergroupid' => $this->fetch_field('usergroupid'),
			'membergroupids' => $this->fetch_field('membergroupids')
		);

		cache_permissions($user_perms);
		$remove_subs = array();
		$remove_forums = array();
		foreach ($old_canview AS $forumid)
		{
			if (!($user_perms['forumpermissions']["$forumid"] & $this->registry->bf_ugp_forumpermissions['canview']))
			{
				$remove_forums[] = $forumid;
			}
		}
		foreach($old_canviewthreads AS $forumid)
		{
			if (!($user_perms['forumpermissions']["$forumid"] & $this->registry->bf_ugp_forumpermissions['canviewthreads']))
			{
				$remove_subs[] = $forumid;
			}
		}

		// This block of code appears to serve no purpose? $new_canview is not used any where
		foreach ($user_perms['forumpermissions'] AS $forumid => $perms)
		{
			if ($perms & $this->registry->bf_ugp_forumpermissions['canview'])
			{
				$new_canview[] = $forumid;
			}
		}

		if (!empty($remove_forums))
		{
			$forum_list = implode(',', $remove_forums);
			$this->dbobject->query_write("
				DELETE FROM " . TABLE_PREFIX . "subscribeforum
				WHERE userid = $userid
					AND forumid IN ($forum_list)
			");
		}

		$remove_subs = array_unique(array_merge($remove_subs, $remove_forums));

		if (!empty($remove_subs))
		{
			$forum_list = implode(',', $remove_subs);
			$threads = $this->dbobject->query_read("
				SELECT subscribethread.threadid
				FROM " . TABLE_PREFIX . "subscribethread AS subscribethread
				INNER JOIN " . TABLE_PREFIX . "thread AS thread ON (thread.threadid = subscribethread.threadid)
				WHERE subscribethread.userid = $userid
					AND thread.forumid IN ($forum_list)
			");
			$remove_thread = array();
			while ($thread = $this->dbobject->fetch_array($threads))
			{
				$remove_thread[] = $thread['threadid'];
			}
			$this->dbobject->free_result($threads);
			if (!empty($remove_thread))
			{
				$this->dbobject->query_write("
					DELETE FROM " . TABLE_PREFIX . "subscribethread
					WHERE userid = $userid
						AND threadid IN (" . implode(',', $remove_thread) . ")
				");
			}
		}
	}

	/**
	* Rebuilds the birthday datastore if the user's birthday has changed
	*
	* @param	integer	User ID
	*/
	function update_birthday_datastore($userid)
	{
		if ($this->registry->options['showbirthdays'] AND isset($this->user['birthday']) AND ($this->user['birthday'] != $this->existing['birthday'] OR $this->user['showbirthday'] != $this->existing['showbirthday']))
		{
			require_once(DIR . '/includes/functions_databuild.php');
			build_birthdays($this->user['birthday']);
		}
	}

	/**
	* Inserts a record into the password history table if the user's password has changed
	*
	* @param	integer	User ID
	*/
	function update_password_history($userid)
	{
		if (isset($this->user['password']) AND $this->user['password'] != $this->existing['password'])
		{
			/*insert query*/
			$this->dbobject->query_write("
				INSERT INTO " . TABLE_PREFIX . "passwordhistory (userid, password, passworddate)
				VALUES ($userid, '" . $this->dbobject->escape_string($this->user['password']) . "', FROM_UNIXTIME(" . TIMENOW . "))
			");
		}
	}

	/**
	* Resets the session styleid and styleid cookie to the user's profile choice
	*
	* @param	integer	User ID
	*/
	function update_style_cookie($userid)
	{
		if (isset($this->user['styleid']) AND $this->registry->options['allowchangestyles'])
		{
			$this->dbobject->query_write("
				UPDATE " . TABLE_PREFIX . "session SET
					styleid = " . $this->user['styleid'] . "
				WHERE sessionhash = '" . $this->dbobject->escape_string($this->registry->session->vars['dbsessionhash']) . "'
			");
			if (!@headers_sent())
			{
				vbsetcookie('styleid', '', 1);
			}
		}
	}

	/**
	* Resets the threadedmode cookie to the user's profile choice
	*
	* @param	integer	User ID
	*/
	function update_threadedmode_cookie($userid)
	{
		if (isset($this->user['threadedmode']))
		{
			if (!@headers_sent())
			{
				vbsetcookie('threadedmode', '', 1);
			}
		}
	}

	/**
	* Checks to see if a user's usergroup memberships have changed
	*
	* @return	boolean	Returns true if memberships have changed
	*/
	function usergroups_changed()
	{
		if (isset($this->user['usergroupid']) AND $this->user['usergroupid'] != $this->existing['usergroupid'])
		{
			return true;
		}
		else if (isset($this->user['membergroupids']) AND $this->user['membergroupids'] != $this->existing['membergroupids'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* Checks usergroupid and membergroupids to see if the user has admin privileges
	*
	* @param	integer	Usergroupid
	* @param	string	Membergroupids (comma separated)
	*
	* @return	boolean	Returns true if user has admin privileges
	*/
	function is_admin($usergroupid, $membergroupids, $x)
	{
		if ($this->registry->usergroupcache["$usergroupid"]['adminpermissions'] & $this->registry->bf_ugp_adminpermissions['cancontrolpanel'])
		{
			return true;
		}
		else if ($this->registry->usergroupcache["$usergroupid"]['genericoptions'] & $this->registry->bf_ugp_genericoptions['allowmembergroups'])
		{
			if ($membergroupids != '')
			{
				foreach (explode(',', $membergroupids) AS $membergroupid)
				{
					if ($this->registry->usergroupcache["$membergroupid"]['adminpermissions'] & $this->registry->bf_ugp_adminpermissions['cancontrolpanel'])
					{
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	* Counts the number of administrators OTHER THAN the user specified
	*
	* @param	integer	User ID of user to be checked
	*
	* @return	integer	The number of administrators excluding the current user
	*/
	function count_other_admins($userid)
	{
		$admingroups = array();
		$groupsql = '';
		foreach ($this->registry->usergroupcache AS $usergroupid => $usergroup)
		{
			if ($usergroup['adminpermissions'] & $this->registry->bf_ugp_adminpermissions['cancontrolpanel'])
			{
				$admingroups[] = $usergroupid;
				if ($usergroup['genericoptions'] & $this->registry->bf_ugp_genericoptions['allowmembergroups'])
				{
					$groupsql .= "
					OR FIND_IN_SET('$usergroupid', membergroupids)";
				}
			}
		}

		$countadmin = $this->dbobject->query_first("
			SELECT COUNT(*) AS users
			FROM " . TABLE_PREFIX . "user
			WHERE userid <> " . intval($userid) . "
			AND
			(
				usergroupid IN(" . implode(',', $admingroups) . ")" .
				$groupsql . "
			)
		");

		return $countadmin['users'];
	}

	/**
	* Inserts or deletes a record from the administrator table if necessary
	*
	* @param	integer	User ID of this user
	* @param	boolean	Whether or not the usergroups of this user have changed
	* @param	boolean	Whether or not the user is now an admin
	* @param	boolean	Whether or not the user was an admin before this update
	*/
	function set_admin($userid, $usergroups_changed, $isadmin, $wasadmin = false)
	{
		if ($isadmin AND !$wasadmin)
		{
			// insert admin record
			$admindm =& datamanager_init('Admin', $this->registry, ERRTYPE_SILENT);
			$admindm->set('userid', $userid);
			$admindm->save();
			unset($admindm);

			$this->insertedadmin = true;
		}
		else if ($usergroups_changed AND $wasadmin AND !$isadmin)
		{
			// delete admin record
			$info = array('userid' => $userid);

			$admindm =& datamanager_init('Admin', $this->registry, ERRTYPE_SILENT);
			$admindm->set_existing($info);
			$admindm->delete();
			unset($admindm);
		}
		/*else
		{
			echo "<p style=\"color:white\">No change needed for Admin record
			wasadmin: " . ($wasadmin ? 'Y' : 'N') . "<br />
			isadmin: " . ($isadmin ? 'Y' : 'N') . "<br />
			ugchanged: " . ($wasadmin ? 'Y' : 'N') . "<br />
			</p>";
		}*/
	}

	/**
	* Bla bla bla
	*
	* @param	integer	User ID
	*/
	function update_ban_status($userid)
	{
		$userid = intval($userid);
		$usergroupid = $this->fetch_field('usergroupid');

		if ($this->registry->usergroupcache["$usergroupid"]['genericoptions'] & $this->registry->bf_ugp_genericoptions['isbannedgroup'])
		{
			// check to see if there is already a ban record for this user...
			if (!($check = $this->dbobject->query_first("SELECT userid FROM " . TABLE_PREFIX . "userban WHERE userid = $userid")))
			{
				// ... there isn't, so create one
				$ousergroupid = $this->existing['usergroupid'];
				$odisplaygroupid = $this->existing['displaygroupid'];

				// make sure the ban lifting record doesn't loop back to a banned group
				if ($this->registry->usergroupcache["$ousergroupid"]['genericoptions'] & $this->registry->bf_ugp_genericoptions['isbannedgroup'])
				{
					$ousergroupid = 2;
				}
				if ($this->registry->usergroupcache["$odisplaygroupid"]['genericoptions'] & $this->registry->bf_ugp_genericoptions['isbannedgroup'])
				{
					$odisplaygroupid = 0;
				}

				// insert a ban record
				/*insert query*/
				$this->dbobject->query_write("
					INSERT INTO " . TABLE_PREFIX . "userban
						(userid, usergroupid, displaygroupid, customtitle, usertitle, adminid, bandate, liftdate)
					VALUES
						($userid,
						" . $ousergroupid . ",
						" . $odisplaygroupid . ",
						" . $this->fetch_field('customtitle') . ",
						'" . $this->dbobject->escape_string($this->fetch_field('usertitle')) . "',
						" . $this->registry->userinfo['userid'] . ",
						" . TIMENOW . ",
						0)
				");
			}
		}
	}

	/*function error()
	{
		echo "<h1>Error</h1>";
		$args = func_get_args();
		foreach ($args AS $arg)
		{
			echo "<div>$arg</div>";
		}
		die();
	}*/
}

/**
* Class to do data update operations for multiple USERS simultaneously
*
* @package	vBulletin
* @version	$Revision: 1.94 $
* @date		$Date: 2005/08/30 22:22:37 $
*/
class vB_DataManager_User_Multiple extends vB_DataManager_Multiple
{
	/**
	* The name of the class to instantiate for each matching. It is assumed to exist!
	* It should be a subclass of vB_DataManager.
	*
	* @var	string
	*/
	var $class_name = 'vB_DataManager_User';

	/**
	* The name of the primary ID column that is used to uniquely identify records retrieved.
	* This will be used to build the condition in all update queries!
	*
	* @var string
	*/
	var $primary_id = 'userid';

	/**
	* Builds the SQL to run to fetch records. This must be overridden by a child class!
	*
	* @param	string	Condition to use in the fetch query; the entire WHERE clause
	* @param	integer	The number of records to limit the results to; 0 is unlimited
	* @param	integer	The number of records to skip before retrieving matches.
	*
	* @return	string	The query to execute
	*/
	function fetch_query($condition, $limit = 0, $offset = 0)
	{
		$query = "SELECT * FROM " . TABLE_PREFIX . "user AS user";
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

	/**
	* Sets the values for user[usertitle] and user[customtitle]
	*
	* @param	string	Custom user title text
	* @param	boolean	Whether or not to reset a custom title to the default user title
	* @param	array	Array containing all information for the user's primary usergroup
	* @param	boolean	Whether or not a user can use custom user titles ($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canusecustomtitle'])
	* @param	boolean	Whether or not the user is an administrator ($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel'])
	*/
	function set_usertitle($customtext, $reset, $usergroup, $canusecustomtitle, $isadmin)
	{
		if ($this->children)
		{
			$firstid = reset($this->primary_ids);
			$this->children["$firstid"]->set_usertitle($customtext, $reset, $usergroup, $canusecustomtitle, $isadmin);
		}
	}

	/**
	* Validates and sets custom user profile fields
	*
	* @param	array	Array of values for profile fields. Example: array('field1' => 'One', 'field2' => array(0 => 'a', 1 => 'b'), 'field2_opt' => 'c')
	*/
	function set_userfields(&$values)
	{
		if ($this->children)
		{
			$firstid = reset($this->primary_ids);
			$this->children["$firstid"]-> set_userfields($values);
		}
	}

	/**
	* Sets DST options
	*
	* @param	integer	DST choice: (2: automatic; 1: auto-off, dst on; 0: auto-off, dst off)
	*/
	function set_dst(&$dst)
	{
		if ($this->children)
		{
			$firstid = reset($this->primary_ids);
			$this->children["$firstid"]->set_dst($dst);
		}
	}

	/**
	* Pushes the changes made to the "master" child to the rest.
	*/
	function copy_changes()
	{
		if (sizeof($this->children) > 1)
		{
			$firstid = reset($this->primary_ids);
			$master =& $this->children["$firstid"];

			while ($id = next($this->primary_ids))
			{
				$child =& $this->children["$id"];

				$child->user = $master->user;
				$child->userfield = $master->userfield;
				$child->usertextfield = $master->usertextfield;

				$child->info = $master->info;
			}
		}
	}

	/**
	* Executes the necessary query/queries to update the records
	*
	* @param	boolean	Actually perform the query?
	*/
	function execute_query($doquery = true)
	{
		$condition = 'userid IN (' . implode(',', $this->primary_ids) . ')';
		$master =& $this->children[reset($this->primary_ids)];

		foreach (array('user', 'userfield', 'usertextfield') AS $table)
		{
			if (is_array($master->$table) AND !empty($master->$table))
			{
				$sql = $master->fetch_update_sql(TABLE_PREFIX, $table, $condition);

				if ($doquery)
				{
					$this->dbobject->query_write($sql);
				}
				else
				{
					echo "<pre>$sql<hr /></pre>";
				}
			}
		}
	}

}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: class_dm_user.php,v $ - $Revision: 1.94 $
|| ####################################################################
\*======================================================================*/
?>