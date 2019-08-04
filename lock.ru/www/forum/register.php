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

// ####################### SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'register');

// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array('timezone', 'user', 'register');

// get special data templates from the datastore
$specialtemplates = array(
	'smiliecache',
	'bbcodecache',
	'banemail',
	'ranks',
);

// pre-cache templates used by all actions
$globaltemplates = array(
	'register',
	'register_rules',
	'register_verify_age',
	'register_coppaform',
	'userfield_textbox',
	'userfield_checkbox_option',
	'userfield_optional_input',
	'userfield_radio',
	'userfield_radio_option',
	'userfield_select',
	'userfield_select_option',
	'userfield_select_multiple',
	'userfield_textarea',
	'modifyoptions_timezone',
	'modifyprofile_birthday',
);

// pre-cache templates used by specific actions
$actiontemplates = array(
	'requestemail' => array(
		'activate_requestemail'
	),
	'none' => array(
		'activateform'
	)
);

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions_user.php');
require_once(DIR . '/includes/functions_misc.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

$vbulletin->input->clean_gpc('r', 'a', TYPE_NOHTML);
$vbulletin->input->clean_gpc('r', 'u', TYPE_NOHTML);

if (empty($_REQUEST['do']) AND $vbulletin->GPC['a'] == '')
{
	$_REQUEST['do'] = 'signup';
}

if ($vbulletin->url == REFERRER)
{
	$vbulletin->url = urlencode($vbulletin->url);
}

($hook = vBulletinHook::fetch_hook('register_start')) ? eval($hook) : false;

// ############################### start checkdate ###############################
if ($_REQUEST['do'] == 'checkdate')
{
	// check their birthdate
	$vbulletin->input->clean_array_gpc('r', array(
		'month'	=> TYPE_UINT,
		'year'	=> TYPE_UINT,
		'day'	=> TYPE_UINT
	));

	$current['year'] = date('Y');
	$current['month'] = date('m');

	if ($vbulletin->GPC['month'] == 0 OR !preg_match('#^\d{4}$#', $vbulletin->GPC['year']) OR $vbulletin->GPC['year'] < 1901 OR $vbulletin->GPC['year'] > $current['year'])
	{
		eval(standard_error(fetch_error('select_valid_month_and_year', $current['year'])));
	}

	($hook = vBulletinHook::fetch_hook('register_checkdate')) ? eval($hook) : false;

	if ($vbulletin->GPC['year'] < ($current['year'] - 13) OR ($vbulletin->GPC['year'] == ($current['year'] - 13) AND $vbulletin->GPC['month'] <= $current['month']))
	{
		// just regular adult registration
		exec_header_redirect('register.php?' . $vbulletin->session->vars['sessionurl'] . 'do=signup&who=adult&url=' . $vbulletin->url . iif($vbulletin->GPC['month'], '&month=' . $vbulletin->GPC['month']) . iif($vbulletin->GPC['year'], '&year=' . $vbulletin->GPC['year']) . iif($vbulletin->GPC['day'], '&day=' . $vbulletin->GPC['day']));
	}
	else
	{
		if ($vbulletin->options['usecoppa'] == 2)
		{
			// turn away as they're under 13
			eval(standard_error(fetch_error('under_thirteen_registration_denied')));
		}
		else
		{
			// use the coppa registration
			exec_header_redirect('register.php?' . $vbulletin->session->vars['sessionurl'] . 'do=signup&who=coppa&url=' . $vbulletin->url . iif($vbulletin->GPC['month'], '&month=' . $vbulletin->GPC['month']) . iif($vbulletin->GPC['year'], '&year=' . $vbulletin->GPC['year']) . iif($vbulletin->GPC['day'], '&day=' . $vbulletin->GPC['day']));
		}
	}

	exit;
}

// ############################### start signup ###############################
if ($_REQUEST['do'] == 'signup')
{
	// Variables reused in templates
	$month = $vbulletin->input->clean_gpc('r', 'month', TYPE_UINT);
	$year = $vbulletin->input->clean_gpc('r', 'year', TYPE_UINT);
	$day = $vbulletin->input->clean_gpc('r', 'day', TYPE_UINT);

	$vbulletin->input->clean_gpc('r', 'who', TYPE_NOHTML);

	if (!$vbulletin->options['allowregistration'])
	{
		eval(standard_error(fetch_error('noregister')));
	}

	if ($vbulletin->userinfo['userid'] AND !$vbulletin->options['allowmultiregs'])
	{
		eval(standard_error(fetch_error('alreadyregistered', $vbulletin->userinfo['username'], $vbulletin->session->vars['sessionurl'])));
	}

	if (!$vbulletin->options['usecoppa'])
	{
		// don't use COPPA - assume adult
		$who = 'adult';
	}
	else
	{
		$who = $vbulletin->GPC['who'];
	}

	if ($who == 'coppa' AND $vbulletin->options['usecoppa'] == 1)
	{
		$show['coppa'] = true;
		$templatename = 'register_rules';
	}
	else if ($who == 'adult')
	{
		$show['coppa'] = false;
		$templatename = 'register_rules';
	}
	else
	{
		$templatename = 'register_verify_age';
	}

	($hook = vBulletinHook::fetch_hook('register_signup')) ? eval($hook) : false;

	$url =& $vbulletin->url;
	eval('print_output("' . fetch_template($templatename) . '");');
}

// ############################### start add member ###############################
if ($_POST['do'] == 'addmember')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'options'            => TYPE_ARRAY_BOOL, // I'm thinking these are all 1/0
		'username'           => TYPE_STR,
		'email'              => TYPE_STR,
		'emailconfirm'       => TYPE_STR,
		'parentemail'        => TYPE_STR,
		'password'           => TYPE_STR,
		'password_md5'       => TYPE_STR,
		'passwordconfirm'    => TYPE_STR,
		'passwordconfirm_md5'=> TYPE_STR,
		'referrername'       => TYPE_NOHTML,
		'imagestamp'         => TYPE_STR,
		'imagehash'          => TYPE_STR,
		'coppauser'          => TYPE_BOOL,
		'day'                => TYPE_UINT,
		'month'              => TYPE_UINT,
		'year'               => TYPE_UINT,
		'timezoneoffset'     => TYPE_NUM,
		'dst'                => TYPE_UINT,
		'userfield'          => TYPE_ARRAY,
		'showbirthday'       => TYPE_UINT,
	));

	if (!$vbulletin->options['allowregistration'])
	{
		eval(standard_error(fetch_error('noregister')));
	}

	// check for multireg
	if ($vbulletin->userinfo['userid'] AND !$vbulletin->options['allowmultiregs'])
	{
		eval(standard_error(fetch_error('alreadyregistered', $vbulletin->userinfo['username'], $vbulletin->session->vars['sessionurl'])));
	}

	// init user datamanager class
	$userdata =& datamanager_init('User', $vbulletin, ERRTYPE_ARRAY);

	// coppa option
	$userdata->set_info('coppauser', $vbulletin->GPC['coppauser']);
	$userdata->set_bitfield('options', 'coppauser', $vbulletin->GPC['coppauser']);
	$userdata->set('parentemail', $vbulletin->GPC['parentemail']);

	// check for missing fields
	if (empty($vbulletin->GPC['username'])
		OR empty($vbulletin->GPC['email'])
		OR empty($vbulletin->GPC['emailconfirm'])
		OR ($vbulletin->GPC['coppauser'] AND empty($vbulletin->GPC['parentemail']))
		OR (empty($vbulletin->GPC['password']) AND empty($vbulletin->GPC['password_md5']))
		OR (empty($vbulletin->GPC['passwordconfirm']) AND empty($vbulletin->GPC['passwordconfirm_md5']))
	)
	{
		$userdata->error('fieldmissing');
	}

	// check for matching passwords
	if ($vbulletin->GPC['password'] != $vbulletin->GPC['passwordconfirm'] OR (strlen($vbulletin->GPC['password_md5']) == 32 AND $vbulletin->GPC['password_md5'] != $vbulletin->GPC['passwordconfirm_md5']))
	{
		$userdata->error('passwordmismatch');
	}
	// set password
	$userdata->set('password', ($vbulletin->GPC['password_md5'] ? $vbulletin->GPC['password_md5'] : $vbulletin->GPC['password']));

	// check for matching email addresses
	if ($vbulletin->GPC['email'] != $vbulletin->GPC['emailconfirm'])
	{
		$userdata->error('emailmismatch');
	}
	// set email
	$userdata->set('email', $vbulletin->GPC['email']);

	$userdata->set('username', $vbulletin->GPC['username']);

	// check referrer
	if ($vbulletin->GPC['referrername'] AND !$vbulletin->userinfo['userid'])
	{
		$userdata->set('referrerid', $vbulletin->GPC['referrername']);
	}

	// Check Reg Image
	if ($vbulletin->options['regimagecheck'] AND ($vbulletin->options['gdversion'] OR $vbulletin->options['magickpath']))
	{
		$imagestamp = trim(str_replace(' ', '', $vbulletin->GPC['imagestamp']));
		$ih = $db->query_first("SELECT imagestamp FROM " . TABLE_PREFIX . "regimage WHERE regimagehash = '" . $db->escape_string($vbulletin->GPC['imagehash']) . "'");
		if (!$imagestamp OR strtoupper($imagestamp) != $ih['imagestamp'])
		{
	  		$userdata->error('register_imagecheck');
	  		$db->query_write("DELETE FROM " . TABLE_PREFIX . "regimage WHERE regimagehash = '" . $db->escape_string($vbulletin->GPC['imagehash']) . "'");

	  		unset($imagestamp);
	  		$vbulletin->GPC['imagehash'] = '';
	  		$vbulletin->GPC['imagestamp'] = '';
		}
	}

	// Set specified options
	if (!empty($vbulletin->GPC['options']))
	{
		foreach ($vbulletin->GPC['options'] AS $optionname => $onoff)
		{
			$userdata->set_bitfield('options', $optionname, $onoff);
		}
	}

	// assign user to usergroup 3 if email needs verification
	if ($vbulletin->options['verifyemail'])
	{
		$newusergroupid = 3;
	}
	else if ($vbulletin->options['moderatenewmembers'] OR $vbulletin->GPC['coppauser'])
	{
		$newusergroupid = 4;
	}
	else
	{
		$newusergroupid = 2;
	}
	// set usergroupid
	$userdata->set('usergroupid', $newusergroupid);

	// set languageid
	$userdata->set('languageid', $vbulletin->userinfo['languageid']);

	// set user title
	$userdata->set_usertitle('', false, $vbulletin->usergroupcache["$newusergroupid"], false, false);

	// set profile fields
	$customfields = $userdata->set_userfields($vbulletin->GPC['userfield'], true, 'register');

	// set birthday
	$userdata->set('showbirthday', $vbulletin->GPC['showbirthday']);
	$userdata->set('birthday', array(
		'day'   => $vbulletin->GPC['day'],
		'month' => $vbulletin->GPC['month'],
		'year'  => $vbulletin->GPC['year']
	));

	// set time options
	$userdata->set_dst($vbulletin->GPC['dst']);
	$userdata->set('timezoneoffset', $vbulletin->GPC['timezoneoffset']);

	// register IP address
	$userdata->set('ipaddress', IPADDRESS);

	($hook = vBulletinHook::fetch_hook('register_addmember_process')) ? eval($hook) : false;

	$userdata->pre_save();

	// check for errors
	if (!empty($userdata->errors))
	{
		$_REQUEST['do'] = 'register';

		$errorlist = '';
		foreach ($userdata->errors AS $index => $error)
		{
			$errorlist .= "<li>$error</li>";
		}

		$username = htmlspecialchars_uni($vbulletin->GPC['username']);
		$email = htmlspecialchars_uni($vbulletin->GPC['email']);
		$emailconfirm = htmlspecialchars_uni($vbulletin->GPC['emailconfirm']);
		$parentemail = htmlspecialchars_uni($vbulletin->GPC['parentemail']);
		$selectdst = array($vbulletin->GPC['dst'] => 'selected="selected"');
		$sbselected = array($vbulletin->GPC['showbirthday'] => 'selected="selected"');
		$show['errors'] = true;
	}
	else
	{
		$show['errors'] = false;
		// Delete the regimage so that no other processes can try to use it.
		if ($vbulletin->options['regimagecheck'] AND ($vbulletin->options['gdversion'] OR $vbulletin->options['magickpath']))
		{
		  	$db->query_write("DELETE FROM " . TABLE_PREFIX . "regimage WHERE regimagehash = '" . $db->escape_string($vbulletin->GPC['imagehash']) . "'");
		}

		// check coppa things
		if ($vbulletin->GPC['coppauser'])
		{
			$username = $vbulletin->GPC['username'];
			$password = $vbulletin->GPC['password'];
			eval(fetch_email_phrases('parentcoppa'));
			vbmail($vbulletin->GPC['parentemail'], $subject, $message, true);
		}

		// save the data
		$vbulletin->userinfo['userid']
			= $userid
			= $userdata->save();

		if ($userid)
		{
			$db->query_write("
				UPDATE " . TABLE_PREFIX . "session
				SET userid = " . intval($userid) . "
				WHERE sessionhash = '" . $db->escape_string($vbulletin->session->vars['dbsessionhash']) . "'");

			// send new user email
			if ($vbulletin->options['newuseremail'] != '')
			{
				$username = $vbulletin->GPC['username'];
				$email = $vbulletin->GPC['email'];
				$birthday = $userdata->fetch_field('birthday');

				eval(fetch_email_phrases('newuser', 0));

				$newemails = explode(' ', $vbulletin->options['newuseremail']);
				foreach ($newemails AS $toemail)
				{
					if (trim($toemail))
					{
						vbmail($toemail, $subject, $message);
					}
				}
			}

			$username = htmlspecialchars_uni($vbulletin->GPC['username']);
			$email = htmlspecialchars_uni($vbulletin->GPC['email']);

			// sort out emails and usergroups
			if ($vbulletin->options['verifyemail'])
			{
				$activateid = build_user_activation_id($userid, 2, 0);

				eval(fetch_email_phrases('activateaccount'));

				vbmail($email, $subject, $message, true);

			}
			else if (!$vbulletin->options['moderatenewmembers'] AND $vbulletin->options['welcomemail'])
			{
				eval(fetch_email_phrases('welcomemail'));
				vbmail($email, $subject, $message);
			}

			($hook = vBulletinHook::fetch_hook('register_addmember_complete')) ? eval($hook) : false;

			$vbulletin->url = urldecode($vbulletin->url);
			if ($vbulletin->GPC['coppauser'])
			{
				$_REQUEST['do'] = 'coppaform';
			}
			else
			{
				if ($vbulletin->options['verifyemail'])
				{
					eval(standard_error(fetch_error('registeremail', $username, $email, $vbulletin->url . $vbulletin->session->vars['sessionurl_q']), '', false));
				}
				else
				{
					$vbulletin->url = str_replace('"', '', $vbulletin->url);
					if (!$vbulletin->url)
					{
						$vbulletin->url = $vbulletin->options['forumhome'] . '.php' . $vbulletin->session->vars['sessionurl_q'];
					}
					else
					{
						$vbulletin->url = iif(strpos($vbulletin->url, 'register.php') !== false, $vbulletin->options['forumhome'] . '.php' . $vbulletin->session->vars['sessionurl_q'], $vbulletin->url);
					}

					if ($vbulletin->options['moderatenewmembers'])
					{
						eval(standard_error(fetch_error('moderateuser', $username, $vbulletin->options['forumhome'], $vbulletin->session->vars['sessionurl_q']), '', false));
					}
					else
					{
						eval(standard_error(fetch_error('registration_complete', $username, $vbulletin->session->vars['sessionurl'], $vbulletin->options['bburl'] . '/' . $vbulletin->options['forumhome'] . '.php'), '', false));
					}
				}
			}
		}
	}
}

// ############################### start register ###############################
if ($_REQUEST['do'] == 'register')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'agree'    => TYPE_BOOL,
		'year'      => TYPE_UINT,
		'month'		=> TYPE_UINT,
		'day'		=> TYPE_UINT,
		'options'	=> TYPE_ARRAY_BOOL,
		'who'		=> TYPE_NOHTML,
	));

	// Variables that are used in templates
	$agree =& $vbulletin->GPC['agree'];
	$year =& $vbulletin->GPC['year'];
	$month =& $vbulletin->GPC['month'];
	$day =& $vbulletin->GPC['day'];

	$url = $vbulletin->url;

	if (!$vbulletin->GPC['agree'])
	{
		eval(standard_error(fetch_error('register_not_agreed', $vbulletin->options['forumhome'], $vbulletin->session->vars['sessionurl_q'])));
	}
	if (!$vbulletin->options['allowregistration'])
	{
		eval(standard_error(fetch_error('noregister')));
	}

	if ($vbulletin->userinfo['userid'] AND !$vbulletin->options['allowmultiregs'])
	{
		eval(standard_error(fetch_error('alreadyregistered', $vbulletin->userinfo['username'], $vbulletin->session->vars['sessionurl'])));
	}

	($hook = vBulletinHook::fetch_hook('register_form_start')) ? eval($hook) : false;

	if ($errorlist)
	{
		$checkedoff['adminemail'] = iif($vbulletin->GPC['options']['adminemail'], 'checked="checked"');
		$checkedoff['showemail'] = iif($vbulletin->GPC['options']['showemail'], 'checked="checked"');
	}
	else
	{
		$checkedoff['adminemail'] = iif(bitwise($vbulletin->bf_misc_regoptions['adminemail'], $vbulletin->options['defaultregoptions']), 'checked="checked"');
		$checkedoff['showemail'] = iif(bitwise($vbulletin->bf_misc_regoptions['receiveemail'], $vbulletin->options['defaultregoptions']), 'checked="checked"');
	}

	if ($vbulletin->options['reqbirthday'])
	{
		$show['birthday'] = true;
		$monthselected[str_pad($vbulletin->GPC['month'], 2, '0', STR_PAD_LEFT)] = 'selected="selected"';
		$dayselected[str_pad($vbulletin->GPC['day'], 2, '0', STR_PAD_LEFT)] = 'selected="selected"';

	    if ($year == 0)
	    {
	        $year = '';
    	}

		// Default Birthday Privacy option to show all
		if (empty($errorlist))
		{
			$sbselected = array(2 => 'selected="selected"');
		}
		eval('$birthdayfields = "' . fetch_template('modifyprofile_birthday') . '";');
	}
	else
	{
		$show['birthday'] = false;

		$birthdayfields = '';
	}

	$htmlonoff = ($vbulletin->options['allowhtml'] ? $vbphrase['on'] : $vbphrase['off']);
	$bbcodeonoff = ($vbulletin->options['allowbbcode'] ? $vbphrase['on'] : $vbphrase['off']);
	$imgcodeonoff = ($vbulletin->options['allowbbimagecode'] ? $vbphrase['on'] : $vbphrase['off']);
	$smiliesonoff = ($vbulletin->options['allowsmilies'] ? $vbphrase['on'] : $vbphrase['off']);

	// image verification
	if ($vbulletin->options['regimagecheck'] AND ($vbulletin->options['gdversion'] OR $vbulletin->options['magickpath']))
	{
		// Transfer a successful image match over when other errors have occurred
		if ($errorlist AND !empty($vbulletin->GPC['imagehash']))
		{
			$imagestamp = htmlspecialchars_uni($vbulletin->GPC['imagestamp']);
			$imagehash = htmlspecialchars_uni($vbulletin->GPC['imagehash']);
		}
		else
		{
			$string = fetch_registration_string(6);

			$imagehash = md5(uniqid(rand(), 1));

			// Gen hash and insert into database;
			/*insert query*/
			$db->query_write("
				INSERT INTO " . TABLE_PREFIX . "regimage
					(regimagehash, imagestamp, dateline)
				VALUES
					('" . $db->escape_string($imagehash) . "', '" . $db->escape_string($string) . "', " . TIMENOW . ")
			");
		}
	}

	// Referrer
	if ($vbulletin->options['usereferrer'] AND !$vbulletin->userinfo['userid'])
	{
		exec_switch_bg();
		if ($errorlist)
		{
			$referrername = $vbulletin->GPC['referrername'];
		}
		else if ($vbulletin->GPC[COOKIE_PREFIX . 'referrerid'])
		{
			if ($referrername = $db->query_first("SELECT username FROM " . TABLE_PREFIX . "user WHERE userid = " . $vbulletin->GPC[COOKIE_PREFIX . 'referrerid']))
			{
				$referrername = $referrername['username'];
			}
		}
		$show['referrer'] = true;
	}
	else
	{
		$show['referrer'] = false;
	}

	// get extra profile fields
	if ($vbulletin->GPC['who'] != 'adult')
	{
		$bgclass1 = 'alt1';
	}

	$customfields_other = '';
	$customfields_profile = '';
	$customfields_option = '';

	$profilefields = $db->query_read("
		SELECT *
		FROM " . TABLE_PREFIX . "profilefield
		WHERE editable > 0 AND required <> 0
		ORDER BY displayorder
	");
	while ($profilefield = $db->fetch_array($profilefields))
	{
		$profilefieldname = "field$profilefield[profilefieldid]";
		$optionalname = $profilefieldname . '_opt';
		$optionalfield = '';
		$optional = '';
		if (!$errorlist)
		{
			unset($vbulletin->userinfo["$profilefieldname"]);
		}
		elseif (isset($vbulletin->GPC['userfield']["$profilefieldname"]))
		{
			$vbulletin->userinfo["$profilefieldname"] = $vbulletin->GPC['userfield']["$profilefieldname"];
		}

		if ($profilefield['required'] == 2)
		{
			// not required to be filled in but still show
			$profile_variable =& $customfields_other;
		}
		else // required to be filled in
		{
			if ($profilefield['form'])
			{
				$profile_variable =& $customfields_option;
			}
			else
			{
				$profile_variable =& $customfields_profile;
			}
		}

		if ($profilefield['type'] == 'input')
		{
			if ($profilefield['data'])
			{
				$vbulletin->userinfo["$profilefieldname"] = $profilefield['data'];
			}
			else
			{
				$vbulletin->userinfo["$profilefieldname"] = htmlspecialchars_uni($vbulletin->userinfo["$profilefieldname"]);
			}
			eval('$profile_variable .= "' . fetch_template('userfield_textbox') . '";');
		}
		else if ($profilefield['type'] == 'textarea')
		{
			if ($profilefield['data'])
			{
				$vbulletin->userinfo["$profilefieldname"] = $profilefield['data'];
			}
			else
			{
				$vbulletin->userinfo["$profilefieldname"] = htmlspecialchars_uni($vbulletin->userinfo["$profilefieldname"]);
			}
			eval('$profile_variable .= "' . fetch_template('userfield_textarea') . '";');
		}
		else if ($profilefield['type'] == 'select')
		{
			$data = unserialize($profilefield['data']);
			$selectbits = '';
			foreach ($data AS $key => $val)
			{
				$key++;
				$selected = '';
				if (isset($vbulletin->userinfo["$profilefieldname"]))
				{
					if (trim($val) == $vbulletin->userinfo["$profilefieldname"])
					{
						$selected = 'selected="selected"';
						$foundselect = 1;
					}
				}
				else if ($profilefield['def'] AND $key == 1)
				{
					$selected = 'selected="selected"';
					$foundselect = 1;
				}

				eval('$selectbits .= "' . fetch_template('userfield_select_option') . '";');
			}

			if ($profilefield['optional'])
			{
				if (!$foundselect AND $vbulletin->userinfo["$profilefieldname"])
				{
					$optional = htmlspecialchars_uni($vbulletin->userinfo["$profilefieldname"]);
				}
				eval('$optionalfield = "' . fetch_template('userfield_optional_input') . '";');
			}
			if (!$foundselect)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$show['noemptyoption'] = iif($profilefield['def'] != 2, true, false);
			eval('$profile_variable .= "' . fetch_template('userfield_select') . '";');
		}
		else if ($profilefield['type'] == 'radio')
		{
			$data = unserialize($profilefield['data']);
			$radiobits = '';
			$foundfield = 0;

			foreach ($data AS $key => $val)
			{
				$key++;
				$checked = '';
				if (!$vbulletin->userinfo["$profilefieldname"] AND $key == 1 AND $profilefield['def'] == 1)
				{
					$checked = 'checked="checked"';
				}
				else if (trim($val) == $vbulletin->userinfo["$profilefieldname"])
				{
					$checked = 'checked="checked"';
					$foundfield = 1;
				}
				eval('$radiobits .= "' . fetch_template('userfield_radio_option') . '";');
			}
			if ($profilefield['optional'])
			{
				if (!$foundfield AND $vbulletin->userinfo["$profilefieldname"])
				{
					$optional = htmlspecialchars_uni($vbulletin->userinfo["$profilefieldname"]);
				}
				eval('$optionalfield = "' . fetch_template('userfield_optional_input') . '";');
			}
			eval('$profile_variable .= "' . fetch_template('userfield_radio') . '";');
		}
		else if ($profilefield['type'] == 'checkbox')
		{
			$data = unserialize($profilefield['data']);
			$radiobits = '';
			$perline = 0;
			foreach ($data AS $key => $val)
			{
				if ($vbulletin->userinfo["$profilefieldname"] & pow(2,$key))
				{
					$checked = 'checked="checked"';
				}
				else
				{
					$checked = '';
				}
				$key++;
				eval('$radiobits .= "' . fetch_template('userfield_checkbox_option') . '";');
				$perline++;
				if ($profilefield['def'] > 0 AND $perline >= $profilefield['def'])
				{
					$radiobits .= '<br />';
					$perline = 0;
				}
			}
			eval('$profile_variable .= "' . fetch_template('userfield_radio') . '";');
		}
		else if ($profilefield['type'] == 'select_multiple')
		{
			$data = unserialize($profilefield['data']);
			$selectbits = '';
			$selected = '';
			foreach ($data AS $key => $val)
			{
				if ($vbulletin->userinfo["$profilefieldname"] & pow(2, $key))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = '';
				}
				$key++;
				eval('$selectbits .= "' . fetch_template('userfield_select_option') . '";');
			}
			eval('$profile_variable .= "' . fetch_template('userfield_select_multiple') . '";');
		}
	}

	if (!$vbulletin->GPC['who'])
	{
		$vbulletin->GPC['who'] = iif($vbulletin->GPC['coppauser'], 'coppa', 'adult');
	}

	$show['coppa'] = $usecoppa = iif($vbulletin->GPC['who'] == 'adult' OR !$vbulletin->options['usecoppa'], false, true);
	$show['customfields_profile'] = iif($customfields_profile OR $show['birthday'], true, false);
	$show['customfields_option'] = iif($customfields_option, true, false);
	$show['customfields_other'] = iif($customfields_other, true, false);
	$show['email'] = iif($vbulletin->options['enableemail'] AND $vbulletin->options['displayemails'], true, false);
	$show['regimagecheck'] = iif($vbulletin->options['regimagecheck'] AND ($vbulletin->options['gdversion'] OR $vbulletin->options['magickpath']), true, false);

	$vbulletin->input->clean_array_gpc('p', array(
		'timezoneoffset' => TYPE_NUM
	));

	// where do we send in timezoneoffset?
	if ($vbulletin->GPC['timezoneoffset'])
	{
		$timezonesel = $vbulletin->GPC['timezoneoffset'];
	}
	else
	{
		$timezonesel = $vbulletin->options['timeoffset'];
	}

	require_once(DIR . '/includes/functions_misc.php');
	$timezoneoptions = '';
	foreach (fetch_timezone() AS $optionvalue => $timezonephrase)
	{
		$optiontitle = $vbphrase["$timezonephrase"];
		$optionselected = iif($optionvalue == $timezonesel, 'selected="selected"', '');
		eval('$timezoneoptions .= "' . fetch_template('option') . '";');
	}
	eval('$timezoneoptions = "' . fetch_template('modifyoptions_timezone') . '";');

	($hook = vBulletinHook::fetch_hook('register_form_complete')) ? eval($hook) : false;

	eval('print_output("' . fetch_template('register') . '");');
}

// ############################### start activate form ###############################
if ($vbulletin->GPC['a'] == 'ver')
{
	// get username and password
	if (!$vbulletin->userinfo['userid'])
	{
		$vbulletin->userinfo['username'] = '';
	}

	if ($permissions['forumpermissions'] & $vbulletin->bf_ugp_forumpermissions['canview'])
	{
		$navbits = construct_navbits(array('' => $vbphrase['activate_your_account']));
		eval('$navbar = "' . fetch_template('navbar') . '";');
	}
	else
	{
		$navbar = '';
	}

	($hook = vBulletinHook::fetch_hook('register_activateform')) ? eval($hook) : false;

	eval('print_output("' . fetch_template('activateform') . '");');
}

// ############################### start activate ###############################
if ($_REQUEST['do'] == 'activate')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'username'		=> TYPE_NOHTML,
		'activateid'	=> TYPE_UINT,

		// These three are cleaned so that they will exist and not be overwritten in the next step

		'u'				=> TYPE_UINT,
		'a'				=> TYPE_NOHTML,
		'i'				=> TYPE_UINT,
	));

	if ($userinfo = $db->query_first("SELECT userid FROM " . TABLE_PREFIX . "user WHERE username='" . $db->escape_string($vbulletin->GPC['username']) . "'"))
	{
		$vbulletin->GPC['u'] = $userinfo['userid'];
		$vbulletin->GPC['a'] = 'act';
		$vbulletin->GPC['i'] = $vbulletin->GPC['activateid'];
	}
	else
	{
		eval(standard_error(fetch_error('badlogin', $vbulletin->options['bburl'], $vbulletin->session->vars['sessionurl'], $strikes)));
	}
}

if ($vbulletin->GPC['a'] == 'act')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'u'		=> TYPE_UINT,
		'i'		=> TYPE_UINT,
	));

	$userinfo = verify_id('user', $vbulletin->GPC['u'], 1, 1);

	($hook = vBulletinHook::fetch_hook('register_activate_start')) ? eval($hook) : false;

	if ($userinfo['usergroupid'] == 3)
	{
		// check valid activation id
		$user = $db->query_first("
			SELECT activationid, usergroupid
			FROM " . TABLE_PREFIX . "useractivation
			WHERE activationid = " . $vbulletin->GPC['i'] . "
				AND userid = $userinfo[userid]
				AND type = 0
		");
		if (!$user OR $vbulletin->GPC['i'] != $user['activationid'])
		{
			// send email again
			eval(standard_error(fetch_error('invalidactivateid', $vbulletin->session->vars['sessionurl'], $vbulletin->options['contactuslink'])));
		}

		// delete activationid
		//$db->query_write("DELETE FROM " . TABLE_PREFIX . "useractivation WHERE userid=$userinfo[userid] AND type=0");

		if ($userinfo['coppauser'] OR ($vbulletin->options['moderatenewmembers'] AND !$userinfo['posts']))
		{
			// put user in moderated group
			$user['usergroupid'] = 4;
		}
		if (empty($user['usergroupid']))
		{
			$user['usergroupid'] = 2; // sanity check
		}

		// ### DO THE UG/TITLE UPDATE ###

		$getusergroupid = iif($userinfo['displaygroupid'] != $userinfo['usergroupid'], $userinfo['displaygroupid'], $user['usergroupid']);

		$user_usergroup =& $vbulletin->usergroupcache["$user[usergroupid]"];
		$display_usergroup =& $vbulletin->usergroupcache["$getusergroupid"];

		// init user data manager
		$userdata =& datamanager_init('User', $vbulletin, ERRTYPE_STANDARD);
		$userdata->set_existing($userinfo);
		$userdata->set('usergroupid', $user['usergroupid']);
		$userdata->set_usertitle(
			$user['customtitle'] ? $user['usertitle'] : '',
			false,
			$display_usergroup,
			($user_usergroup['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canusecustomtitle']) ? true : false,
			($user_usergroup['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['cancontrolpanel']) ? true : false
		);

		require_once(DIR . '/includes/functions_ranks.php');
		if ($user['userid'] == $vbulletin->userinfo['userid'])
		{
			$vbulletin->userinfo['usergroupid'] = $user['usergroupid'];
			$vbulletin->userinfo['displaygroupid'] = $user['usergroupid'];
		}

		($hook = vBulletinHook::fetch_hook('register_activate_process')) ? eval($hook) : false;

		$userdata->save();

		if ($userinfo['coppauser'] OR ($vbulletin->options['moderatenewmembers'] AND !$userinfo['posts']))
		{
			// put user in moderated group
			eval(standard_error(fetch_error('moderateuser', $userinfo['username'], $vbulletin->options['forumhome'], $vbulletin->session->vars['sessionurl_q']), '', false));
		}
		else
		{
			// activate account
			$username = unhtmlspecialchars($userinfo['username']);
			if ($vbulletin->options['welcomemail'] AND !$userinfo['posts'])
			{
				eval(fetch_email_phrases('welcomemail'));
				vbmail($userinfo['email'], $subject, $message);
			}

			eval(standard_error(fetch_error('registration_complete', $userinfo['username'], $vbulletin->session->vars['sessionurl'], $vbulletin->options['bburl'] . '/' . $vbulletin->options['forumhome'] . '.php'), '', false));
		}
	}
	else
	{
		if ($userinfo['usergroupid'] == 4)
		{
			// In Moderation Queue
			eval(standard_error(fetch_error('activate_moderation'), '', false));
		}
		else
		{
			// Already activated
			eval(standard_error(fetch_error('activate_wrongusergroup')));
		}
	}

}

// ############################### start request activation email ###############################
if ($_REQUEST['do'] == 'requestemail')
{
	$email = $vbulletin->input->clean_gpc('r', 'email', TYPE_NOHTML);

	if ($vbulletin->userinfo['userid'] AND $vbulletin->GPC['email'] === '')
	{
		$email = $vbulletin->userinfo['email'];
	}
	else
	{
		$email = $vbulletin->GPC['email'];
	}

	if ($permissions['forumpermissions'] & $vbulletin->bf_ugp_forumpermissions['canview'])
	{
		$navbits = construct_navbits(array(
			'register.php?' . $vbulletin->session->vars['sessionurl'] . 'a=ver' => $vbphrase['activate_your_account'],
			'' => $vbphrase['email_activation_codes']
		));
		eval('$navbar = "' . fetch_template('navbar') . '";');
	}
	else
	{
		$navbar = '';
	}

	($hook = vBulletinHook::fetch_hook('register_requestemail')) ? eval($hook) : false;

	$url =& $vbulletin->url;
	eval('print_output("' . fetch_template('activate_requestemail') . '");');
}

// ############################### process request activation email #############################
if ($_POST['do'] == 'emailcode')
{
	$vbulletin->input->clean_gpc('r', 'email', TYPE_NOHTML);

	$users = $db->query_read("
		SELECT user.userid, user.usergroupid, username, email, activationid, languageid
		FROM " . TABLE_PREFIX . "user AS user
		LEFT JOIN " . TABLE_PREFIX . "useractivation AS useractivation ON(user.userid = useractivation.userid AND type = 0)
		WHERE email = '" . $db->escape_string($vbulletin->GPC['email']) . "'"
	);

	if ($db->num_rows($users))
	{
		while ($user = $db->fetch_array($users))
		{
			if ($user['usergroupid'] == 3)
			{ // only do it if the user is in the correct usergroup
				// make random number
				if (empty($user['activationid']))
				{ //none exists so create one
					$user['activationid'] = build_user_activation_id($user['userid'], 2, 0);
				}
				else
				{
					$user['activationid'] = vbrand(0, 100000000);
					$db->query_write("
						UPDATE " . TABLE_PREFIX . "useractivation SET
							dateline = " . TIMENOW . ",
							activationid = $user[activationid]
						WHERE userid = $user[userid]
							AND type = 0
					");
				}

				$userid = $user['userid'];
				$username = $user['username'];
				$activateid = $user['activationid'];

				($hook = vBulletinHook::fetch_hook('register_emailcode_user')) ? eval($hook) : false;

				eval(fetch_email_phrases('activateaccount', $user['languageid']));

				vbmail($user['email'], $subject, $message, true);
			}
		}

		$vbulletin->url = $vbulletin->options['forumhome'] . '.php' . $vbulletin->session->vars['sessionurl_q'];
		eval(print_standard_redirect('redirect_lostactivatecode', true, true));
	}
	else
	{
		eval(standard_error(fetch_error('invalidemail', $vbulletin->options['contactuslink'])));
	}

}

// ############################### start coppa form ###############################
if ($_REQUEST['do'] == 'coppaform')
{
	if ($vbulletin->userinfo['userid'])
	{
		$vbulletin->userinfo['signature'] = nl2br($vbulletin->userinfo['signature']);

		if ($vbulletin->userinfo['showemail'])
		{
			$vbulletin->userinfo['showemail'] = $vbphrase['no'];
		}
		else
		{
			$vbulletin->userinfo['showemail'] = $vbphrase['yes'];
		}
	}
	else
	{
		$vbulletin->userinfo['username'] = '';
		$vbulletin->userinfo['homepage'] = 'http://';
	}

	($hook = vBulletinHook::fetch_hook('register_coppaform')) ? eval($hook) : false;

	eval('print_output("' . fetch_template('register_coppaform') . '");');
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: register.php,v $ - $Revision: 1.276 $
|| ####################################################################
\*======================================================================*/
?>