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

// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// ##################### DEFINE IMPORTANT CONSTANTS #######################
define('CVS_REVISION', '$RCSfile: usertools.php,v $ - $Revision: 1.57 $');

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('cpuser', 'forum', 'timezone', 'user');
$specialtemplates = array();

// ########################## REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/adminfunctions_user.php');

// ######################## CHECK ADMIN PERMISSIONS #######################
if (!can_administer('canadminusers'))
{
	print_cp_no_permission();
}

$vbulletin->input->clean_array_gpc('r', array(
	'avatarid' => TYPE_INT,
	'userid'   => TYPE_INT,
));

if (is_browser('webkit') AND $vbulletin->GPC['avatarid'] AND empty($_POST['do']))
{
	$_POST['do'] = $_REQUEST['do'] = 'updateavatar';
}

// ############################# LOG ACTION ###############################
log_admin_action(!empty($vbulletin->GPC['userid']) ? 'user id = ' . $vbulletin->GPC['userid'] : '');

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

print_cp_header($vbphrase['user_manager']);

// ###################### Start Remove User's Subscriptions #######################
if ($_REQUEST['do'] == 'removesubs')
{

	print_delete_confirmation('user', $vbulletin->GPC['userid'], 'usertools', 'killsubs', 'subscriptions');
}

// ###################### Start Remove User's PMs #######################
if ($_POST['do'] == 'killsubs')
{

	$db->query_write("DELETE FROM " . TABLE_PREFIX . "subscribethread WHERE userid = " . $vbulletin->GPC['userid']);
	$db->query_write("DELETE FROM " . TABLE_PREFIX . "subscribeforum WHERE userid = " . $vbulletin->GPC['userid']);
	$db->query_write("DELETE FROM " . TABLE_PREFIX . "subscribeevent WHERE userid = " . $vbulletin->GPC['userid']);

	define('CP_REDIRECT', "user.php?do=edit&amp;u=" . $vbulletin->GPC['userid']);
	print_stop_message('deleted_subscriptions_successfully');

}

// ###################### Start Remove User's PMs #######################
if ($_REQUEST['do'] == 'removepms')
{

	print_delete_confirmation('user', $vbulletin->GPC['userid'], 'usertools', 'killpms', 'private_messages_belonging_to_the_user');
}

// ###################### Start Remove User's PMs #######################
if ($_POST['do'] == 'killpms')
{

	$result = delete_user_pms($vbulletin->GPC['userid']);

	define('CP_REDIRECT', "user.php?do=edit&amp;u=" . $vbulletin->GPC['userid']);
	print_stop_message('deleted_x_pms_y_pmtexts_and_z_receipts', $result['pms'], $result['pmtexts'], $result['receipts']);
}

// ###################### Start Remove PMs Sent by User #######################
if ($_REQUEST['do'] == 'removesentpms')
{

	print_delete_confirmation('user', $vbulletin->GPC['userid'], 'usertools', 'killsentpms', 'private_messages_sent_by_the_user');
}

// ###################### Start Remove User's PMs #######################
if ($_POST['do'] == 'killsentpms')
{

	$user = $db->query_first("SELECT userid, username FROM " . TABLE_PREFIX . "user WHERE userid = " . $vbulletin->GPC['userid']);

	$pmtextids = '0';
	$pmtexts = $db->query_read("SELECT pmtextid FROM " . TABLE_PREFIX . "pmtext WHERE fromuserid = " . $vbulletin->GPC['userid']);
	while ($pmtext = $db->fetch_array($pmtexts))
	{
		$pmtextids .= ",$pmtext[pmtextid]";
	}
	$db->free_result($pmtexts);

	define('CP_REDIRECT', "user.php?do=edit&amp;u=" . $vbulletin->GPC['userid']);

	if ($pmtextids == '0')
	{
		print_stop_message('no_private_messages_matched_your_query');
	}
	else
	{
		$pmids = '0';
		$pmarray = array();
		$pms = $db->query_read("
			SELECT pm.*, user.username
			FROM " . TABLE_PREFIX . "pm AS pm
			LEFT JOIN " . TABLE_PREFIX . "user AS user USING(userid)
			WHERE pm.pmtextid IN($pmtextids)
		");
		while ($pm = $db->fetch_array($pms))
		{
			$pmids .= ",$pm[pmid]";
			$pmarray["$pm[username]"][] = $pm;
		}
		$db->free_result($pms);

		$users = array();

		foreach($pmarray AS $username => $pms)
		{
			$pmunread = 0;
			foreach($pms AS $pm)
			{
				if ($pm['messageread'] == 0)
				{
					$pmunread ++;
				}
			}
			$pmtotal = sizeof($pms);
			$users["$pm[userid]"] = array('pmtotal' => $pmtotal, 'pmunread' => $pmunread);
		}

		$db->query_write("DELETE FROM " . TABLE_PREFIX . "pm WHERE pmid IN($pmids)");

		if (!empty($users))
		{
			$pmtotalsql = 'CASE userid ';
			$pmunreadsql = 'CASE userid ';
			foreach($users AS $id => $x)
			{
				$pmtotalsql .= "WHEN $id THEN pmtotal - $x[pmtotal] ";
				$pmunreadsql .= "WHEN $id THEN pmunread - $x[pmunread] ";
			}
			$pmtotalsql .= 'ELSE pmtotal END';
			$pmunreadsql .= 'ELSE pmunread END';

			$userids = implode(', ', array_keys($users));

			$db->query_write("
				UPDATE " . TABLE_PREFIX . "user
				SET pmtotal = $pmtotalsql,
				pmunread = $pmunreadsql
				WHERE userid IN($userids)
			");
			$db->query_write("
				UPDATE " . TABLE_PREFIX . "user
				SET pmpopup = IF(pmpopup=2 AND pmunread = 0, 1, pmpopup)
				WHERE userid IN($userids)
			");
		}

		print_stop_message('deleted_private_messages_successfully');
	}
}

// ###################### Start Merge #######################
if ($_REQUEST['do'] == 'merge')
{

	print_form_header('usertools', 'domerge');
	print_table_header($vbphrase['merge_users']);
	print_description_row($vbphrase['merge_allows_you_to_join_two_user_accounts']);
	print_input_row($vbphrase['source_username'], 'sourceuser');
	print_input_row($vbphrase['destination_username'], 'destuser');
	print_submit_row($vbphrase['continue']);

}

// ###################### Start Do Merge #######################
if ($_POST['do'] == 'domerge')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'sourceuser' => TYPE_NOHTML,
		'destuser'   => TYPE_NOHTML
	));

	if ($vbulletin->GPC['sourceuser'] == '' OR !$sourceinfo = $db->query_first("SELECT userid FROM " . TABLE_PREFIX . "user WHERE username = '" . $db->escape_string($vbulletin->GPC['sourceuser']) . "'"))
	{
		print_stop_message('invalid_source_username_specified');
	}
	if ($vbulletin->GPC['destuser'] == '' OR !$destinfo = $db->query_first("SELECT userid FROM " . TABLE_PREFIX . "user WHERE username = '" . $db->escape_string($vbulletin->GPC['destuser']) . "'"))
	{
		print_stop_message('invalid_destination_username_specified');
	}
	if ($vbulletin->GPC['destuser'] == $vbulletin->GPC['sourceuser'])
	{
		print_stop_message('source_and_destination_identical');
	}

	$noalter = explode(',', $vbulletin->config['SpecialUsers']['undeletableusers']);
	if (!empty($noalter[0]) AND (in_array($sourceinfo['userid'], $noalter) OR in_array($destinfo['userid'], $noalter)))
	{
		print_stop_message('user_is_protected_from_alteration_by_undeletableusers_var');
	}

	print_form_header('usertools', 'reallydomerge');
	construct_hidden_code('sourceuserid', $sourceinfo['userid']);
	construct_hidden_code('destuserid', $destinfo['userid']);
	print_table_header($vbphrase['confirm_deletion']);
	print_description_row(construct_phrase($vbphrase['are_you_sure_you_want_to_merge_x_into_y'], $vbulletin->GPC['sourceuser'], $vbulletin->GPC['destuser']));
	print_submit_row($vbphrase['yes'], '', 2, $vbphrase['no']);
}

// ###################### Start Do Merge #######################
if ($_POST['do'] == 'reallydomerge')
{
// Get info on both users

	$vbulletin->input->clean_array_gpc('p', array(
		'sourceuserid' => TYPE_INT,
		'destuserid'   => TYPE_INT
	));

	if (!$sourceinfo = $db->query_first("
		SELECT *
		FROM " . TABLE_PREFIX . "user AS user
		LEFT JOIN " . TABLE_PREFIX . "usertextfield AS usertextfield USING(userid)
		WHERE user.userid = " . $vbulletin->GPC['sourceuserid'] . "
	"))
	{
		print_stop_message('invalid_source_username_specified');
	}

	if (!$destinfo = $db->query_first("
		SELECT *
		FROM " . TABLE_PREFIX . "user AS user
		LEFT JOIN " . TABLE_PREFIX . "usertextfield AS usertextfield USING(userid)
		WHERE user.userid = " . $vbulletin->GPC['destuserid'] . "
	"))
	{
		print_stop_message('invalid_destination_username_specified');
	}

	// Update Subscribed Forums
	$insertsql = '';
	$subforums = $db->query_read("
		SELECT forumid
		FROM " . TABLE_PREFIX . "subscribeforum
		WHERE userid = $destinfo[userid]
	");
	while ($forums = $db->fetch_array($subforums))
	{
		$subscribedforums["$forums[forumid]"] = 1;
	}


	$subforums = $db->query_read("
		SELECT forumid, emailupdate
		FROM " . TABLE_PREFIX . "subscribeforum
		WHERE userid = $sourceinfo[userid]
	");
	while ($forums = $db->fetch_array($subforums))
	{
		if (!isset($subscribedforums[$forums['forumid']]))
		{
			if ($insertsql)
			{
				$insertsql .= ',';
			}
			$insertsql .= "($destinfo[userid], $forums[forumid], $forums[emailupdate])";
		}
	}
	if ($insertsql)
	{
		/*insert sql*/
		$db->query_write("
			INSERT INTO " . TABLE_PREFIX . "subscribeforum
				(userid, forumid, emailupdate)
			VALUES
				$insertsql
		");
	}

	// Update Subscribed Threads
	unset($insertsql);
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "subscribethread
		SET folderid = 0
		WHERE userid = $destinfo[userid]
	");
	$subthreads = $db->query_read("
		SELECT threadid, emailupdate
		FROM " . TABLE_PREFIX . "subscribethread
		WHERE userid = $destinfo[userid]
	");
	while ($threads = $db->fetch_array($subthreads))
	{
		$subscribedthreads[$threads['threadid']] = 1;
		$status[$threads['threadid']] = $threads['emailupdate'];
	}


	$subthreads = $db->query_read("
		SELECT threadid, emailupdate
		FROM " . TABLE_PREFIX . "subscribethread
		WHERE userid = $sourceinfo[userid]
	");
	while ($threads = $db->fetch_array($subthreads))
	{
		if (!isset($subscribedthreads[$threads['threadid']]))
		{
			if ($insertsql)
			{
				$insertsql .= ',';
			}
			$insertsql .= "($destinfo[userid], 0, $threads[threadid], $threads[emailupdate])";
		}
		else
		{
			if ($status[$threads['threadid']] != $threads['emailupdate'])
			{
				$db->query_write("
					UPDATE " . TABLE_PREFIX . "subscribethread
					SET emailupdate = $threads[emailupdate]
					WHERE userid = $destinfo[userid]
						AND threadid = $threads[threadid]
				");
			}
		}
	}
	if ($insertsql)
	{
		/*insert query*/
		$db->query_write("
			INSERT " . TABLE_PREFIX . "subscribethread
				(userid, folderid, threadid, emailupdate)
			VALUES
				$insertsql
		");
	}

	// Update Subscribed Events
	$insertsql = '';
	$events = $db->query_read("
		SELECT eventid, reminder
		FROM " . TABLE_PREFIX . "subscribeevent
		WHERE userid = $sourceinfo[userid]
	");
	while ($event = $db->fetch_array($event))
	{
		if (!empty($insertsql))
		{
			$insertsql .= ',';
		}
		$insertsql .= "($destinfo[userid], $event[eventid], $event[reminder])";
	}
	if (!empty($insertsql))
	{
		$db->query_write("
			INSERT IGNORE INTO " . TABLE_PREFIX . "subscribeevent
				(userid, eventid, reminder)
			VALUES
				$insertsql
		");
	}

	// Merge relevant data in the user table
	// It is ok to have duplicate ids in the buddy/ignore lists
	$userdm =& datamanager_init('User', $vbulletin, ERRTYPE_SILENT);
	$userdm->set_existing($destinfo);

	$userdm->set('posts', "posts + $sourceinfo[posts]", false);
	$userdm->set('reputation', "reputation + $sourceinfo[reputation]", false);
	$userdm->set('lastvisit', "IF(lastvisit < $sourceinfo[lastvisit], $sourceinfo[lastvisit], lastvisit)", false);
	$userdm->set('lastactivity', "IF(lastactivity < $sourceinfo[lastactivity], $sourceinfo[lastactivity], lastactivity)", false);
	$userdm->set('lastpost', "IF(lastpost < $sourceinfo[lastpost], $sourceinfo[lastpost], lastpost)", false);
	$userdm->set('pmtotal', "pmtotal + $sourceinfo[pmtotal]", false);
	$userdm->set('pmunread', "pmunread + $sourceinfo[pmunread]", false);
	$userdm->set('joindate', "IF(joindate > $sourceinfo[joindate], $sourceinfo[joindate], joindate)", false);

	$userdm->set('ignorelist', "CONCAT(ignorelist, '" . $db->escape_string($sourceinfo['ignorelist']) . "')", false);
	$userdm->set('buddylist', "CONCAT(buddylist, '" . $db->escape_string($sourceinfo['buddylist']) . "')", false);

	$userdm->save();
	unset($userdm);

	// Update announcements
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "announcement
		SET userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");

	// Update Attachments
	if ($vbulletin->options['attachfile'])
	{
		$attachments = $db->query_read("
			SELECT attachmentid, userid, filename, filesize, filehash
			FROM " . TABLE_PREFIX . "attachment
			WHERE userid = $sourceinfo[userid]
		");

		require_once(DIR . '/includes/functions_file.php');
		while ($attachment = $db->fetch_array($attachments))
		{
			$sourcefile = fetch_attachment_path($sourceinfo['userid'], $attachment['attachmentid']);
			$sourcethumb = fetch_attachment_path($sourceinfo['userid'], $attachment['attachmentid'], true);

			$attach =& datamanager_init('Attachment', $vbulletin, ERRTYPE_SILENT);
			$attach->set_existing($attachment);
			$attach->set('userid', $destinfo['userid']);
			$attach->set('filedata', @file_get_contents($sourcefile));
			$attach->set('thumbnail', @file_get_contents($sourcethumb));
			$attach->save();
			unset($attach);

			// CHEATER!
			@unlink($sourcefile);
			@unlink($sourcethumb);
		}
	}
	else
	{
		$db->query_write("
			UPDATE " . TABLE_PREFIX . "attachment
			SET userid = $destinfo[userid]
			WHERE userid = $sourceinfo[userid]
		");
	}

	// Update Posts
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "post SET
			userid = $destinfo[userid],
			username = '" . $db->escape_string($destinfo['username']) . "'
		WHERE userid = $sourceinfo[userid]
	");

	// Update Threads
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "thread SET
			postuserid = $destinfo[userid],
			postusername = '" . $db->escape_string($destinfo['username']) . "'
		WHERE postuserid = $sourceinfo[userid]
	");

	// Update Deletion Log
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "deletionlog
		SET userid = $destinfo[userid],
		username = '" . $db->escape_string($destinfo['username']) . "'
		WHERE userid = $sourceinfo[userid]
	");

	// Update Edit Log
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "editlog
		SET userid = $destinfo[userid],
		username = '" . $db->escape_string($destinfo['username']) . "'
		WHERE userid = $sourceinfo[userid]
	");

	// Update Poll Votes
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "pollvote
		SET userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");

	// Update Thread Ratings
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "threadrate SET
			userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");

	// Update User Notes
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "usernote
		SET posterid = $destinfo[userid]
		WHERE posterid = $sourceinfo[userid]
	");
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "usernote
		SET userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");

	// Update Calendar Events
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "event
		SET userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");

	// Update Reputation Details
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "reputation
		SET userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");

	// Update Private Messages
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "pm
		SET userid = $destinfo[userid], folderid = 0
		WHERE userid = $sourceinfo[userid]
	");

	$db->query_write("
		UPDATE " . TABLE_PREFIX . "pmreceipt
		SET userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "pmreceipt
		SET touserid = $destinfo[userid],
		tousername = '" . $db->escape_string($destinfo['username']) . "'
		WHERE touserid = $sourceinfo[userid]
	");

	$db->query_write("
		UPDATE " . TABLE_PREFIX . "pmtext
		SET fromuserid = $destinfo[userid],
		fromusername = '" . $db->escape_string($destinfo['username']) . "'
		WHERE fromuserid = $sourceinfo[userid]
	");

	// Delete requests if the dest user already has them
	$db->query_write("
		DELETE FROM " . TABLE_PREFIX . "usergrouprequest
		WHERE userid = $sourceinfo[userid] AND
			(usergroupid = $destinfo[usergroupid] " . ($destinfo['membergroupids'] != '' ? "OR usergroupid IN (0,$destinfo[membergroupids])" : '') . ")
	");

	// Convert remaining requests to dest user.
	$db->query_write("
		UPDATE " . TABLE_PREFIX . "usergrouprequest
		SET userid = $destinfo[userid]
		WHERE userid = $sourceinfo[userid]
	");

	$olduser = strlen($sourceinfo['username']);
	$newuser = strlen($destinfo['username']);
	$db->query_write("UPDATE " . TABLE_PREFIX . "pmtext
		SET touserarray = REPLACE(touserarray, 'i:$sourceinfo[userid];s:$olduser:\"" . $db->escape_string($sourceinfo['username']) . "\";','i:$destinfo[userid];s:$newuser:\"" . $db->escape_string($destinfo['username']) . "\";')
	");

	// Remove remnants of source user
	$userdm =& datamanager_init('User', $vbulletin, ERRTYPE_SILENT);
	$userdm->set_existing($sourceinfo);
	$userdm->delete();
	unset($userdm);

	print_stop_message('user_accounts_merged', $sourceinfo['username'], $destinfo['username']);

}

// ###################### Start modify Profile Pic ###########
if ($_REQUEST['do'] == 'profilepic')
{

	$userinfo = fetch_userinfo($vbulletin->GPC['userid'], 8); // 8 sets profilepic
	if ($userinfo['profilepicwidth'] AND $userinfo['profilepicheight'])
	{
		$size = " width=\"$userinfo[profilepicwidth]\" height=\"$userinfo[profilepicheight]\" ";
	}

	print_form_header('usertools', 'updateprofilepic', 1);
	construct_hidden_code('userid', $userinfo['userid']);
	print_table_header($vbphrase['change_profile_picture'] . ": <span class=\"normal\">$userinfo[username]</span>");
	if ($userinfo['profilepic'])
	{
		if ($vbulletin->options['usefileavatar'])
		{
			$userinfo['profilepicurl'] = '../' . $vbulletin->options['profilepicurl'] . '/profilepic' . $userinfo['userid'] . '_' . $userinfo['profilepicrevision'] . '.gif';
		}
		else
		{
			$userinfo['profilepicurl'] = '../image.php?' . $vbulletin->session->vars['sessionurl'] . 'u=' . $userinfo['userid'] . "&amp;dateline=$userinfo[profilepicdateline]&amp;type=profile";
		}
		print_description_row("<div align=\"center\"><img src=\"$userinfo[profilepicurl]\" $size alt=\"\" title=\"$userinfo[username]'s Profile Picture\" /></div>");
		print_yes_no_row($vbphrase['use_profile_picture'], 'useprofilepic', 1);
	}
	else
	{
		construct_hidden_code('useprofilepic', 1);
	}

	cache_permissions($userinfo, false);
	if ($userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canprofilepic'] AND ($userinfo['permissions']['profilepicmaxwidth'] > 0 OR $userinfo['permissions']['profilepicmaxheight'] > 0))
	{
		print_yes_no_row($vbphrase['resize_image_to_users_maximum_allowed_size'], 'resize');
	}
	print_input_row($vbphrase['enter_profile_picture_url'], 'profilepicurl', 'http://www.');
	print_upload_row($vbphrase['upload_profile_picture_from_computer'], 'upload');

	print_submit_row($vbphrase['save']);
}

// ###################### Start Update Profile Pic ################
if ($_POST['do'] == 'updateprofilepic')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'userid'        => TYPE_UINT,
		'useprofilepic' => TYPE_BOOL,
		'profilepicurl' => TYPE_STR,
		'resize'        => TYPE_BOOL,
	));

	$userinfo = fetch_userinfo($vbulletin->GPC['userid']);

	if ($vbulletin->GPC['useprofilepic'])
	{
		$vbulletin->input->clean_gpc('f', 'upload', TYPE_FILE);

		require_once(DIR . '/includes/class_upload.php');
		require_once(DIR . '/includes/class_image.php');
		$upload = new vB_Upload_Userpic($vbulletin);

		$upload->data =& datamanager_init('Userpic_Profilepic', $vbulletin, ERRTYPE_CP, 'userpic');
		$upload->image =& vB_Image::fetch_library($vbulletin);
		$upload->userinfo =& $userinfo;

		if ($vbulletin->GPC['resize'])
		{
			cache_permissions($userinfo, false);
			if ($userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canprofilepic'])
			{
				$upload->maxwidth = $userinfo['permissions']['profilepicmaxwidth'];
				$upload->maxheight = $userinfo['permissions']['profilepicmaxheight'];
				#$upload->maxuploadsize = $userinfo['permissions']['profilepicmaxsize'];
				#$upload->allowanimation = ($userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['cananimateprofilepic']) ? true : false;
			}
		}

		if (!$upload->process_upload($vbulletin->GPC['profilepicurl']))
		{
			print_stop_message('there_were_errors_encountered_with_your_upload_x', $upload->fetch_error());
		}
	}
	else
	{
		$userpic =& datamanager_init('Userpic_Profilepic', $vbulletin, ERRTYPE_CP, 'userpic');
		$userpic->condition = "userid = " . $userinfo['userid'];
		$userpic->delete();
	}

	define('CP_REDIRECT', "user.php?do=modify&amp;u=$userinfo[userid]");
	print_stop_message('saved_profile_picture_successfully');
}

// ###################### Start modify Avatar ################
if ($_REQUEST['do'] == 'avatar')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'perpage'   => TYPE_INT,
		'startpage' => TYPE_INT,
	));

	if (!$vbulletin->GPC['userid'])
	{
		print_stop_message('invalid_user_specified');
	}

	$userinfo = fetch_userinfo($vbulletin->GPC['userid']);
	$avatarchecked["{$userinfo['avatarid']}"] = 'checked="checked"';
	$nouseavatarchecked = '';
	if (!$avatarinfo = $db->query_first("SELECT * FROM " . TABLE_PREFIX . "customavatar WHERE userid = " . $vbulletin->GPC['userid']))
	{
		// no custom avatar exists
		if (!$userinfo['avatarid'])
		{
			// must have no avatar selected
			$nouseavatarchecked = 'checked="checked"';
			$avatarchecked[0] = '';
		}
	}
	if ($vbulletin->GPC['startpage'] < 1)
	{
		$vbulletin->GPC['startpage'] = 1;
	}
	if ($vbulletin->GPC['perpage'] < 1)
	{
		$vbulletin->GPC['perpage'] = 25;
	}
	$avatarcount = $db->query_first("SELECT COUNT(*) AS count FROM " . TABLE_PREFIX . "avatar");
	$totalavatars = $avatarcount['count'];
	if (($vbulletin->GPC['startpage'] - 1) * $vbulletin->GPC['perpage'] > $totalavatars)
	{
		if ((($totalavatars / $vbulletin->GPC['perpage']) - intval($totalavatars / $vbulletin->GPC['perpage'])) == 0)
		{
			$vbulletin->GPC['startpage'] = $totalavatars / $vbulletin->GPC['perpage'];
		}
		else
		{
			$vbulletin->GPC['startpage'] = intval($totalavatars / $vbulletin->GPC['perpage']) + 1;
		}
	}
	$limitlower = ($vbulletin->GPC['startpage'] - 1) * $vbulletin->GPC['perpage'] + 1;
	$limitupper = $vbulletin->GPC['startpage'] * $vbulletin->GPC['perpage'];
	if ($limitupper > $totalavatars)
	{
		$limitupper = $totalavatars;
		if ($limitlower > $totalavatars)
		{
			$limitlower = $totalavatars - $vbulletin->GPC['perpage'];
		}
	}
	if ($limitlower <= 0)
	{
		$limitlower = 1;
	}
	$avatars = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "avatar ORDER BY title LIMIT " . ($limitlower-1) . ", " . $vbulletin->GPC['perpage']);
	$avatarcount = 0;
	if ($totalavatars > 0)
	{
		print_form_header('usertools', 'avatar');
		construct_hidden_code('userid', $vbulletin->GPC['userid']);
		print_table_header(
			$vbphrase['avatars_to_show_per_page'] .
			': <input type="text" name="perpage" value="' . $vbulletin->GPC['perpage'] . '" size="5" tabindex="1" />
			<input type="submit" class="button" value="' . $vbphrase['go'] . '" tabindex="1" />
		');
		print_table_footer();
	}

	print_form_header('usertools', 'updateavatar', 1);
	print_table_header($vbphrase['avatars']);

	$output = "<table border=\"0\" cellpadding=\"6\" cellspacing=\"1\" class=\"tborder\" align=\"center\" width=\"100%\">";
	while ($avatar = $db->fetch_array($avatars))
	{
		$avatarid = $avatar['avatarid'];
		$avatar['avatarpath'] = iif(substr($avatar['avatarpath'], 0, 7) != 'http://' AND $avatar['avatarpath']{0} != '/', '../', '') . $avatar['avatarpath'];
		if ($avatarcount == 0)
		{
			$output .= '<tr class="' . fetch_row_bgclass() . '">';
		}
		$output .= "<td valign=\"bottom\" align=\"center\" width=\"20%\"><label for=\"av$avatar[avatarid]\"><input type=\"radio\" name=\"avatarid\" id=\"av$avatar[avatarid]\" value=\"$avatar[avatarid]\" tabindex=\"1\" $avatarchecked[$avatarid] />";
		$output .= "<img src=\"$avatar[avatarpath]\" alt=\"\" /><br />$avatar[title]</label></td>";
		$avatarcount++;
		if ($avatarcount == 5)
		{
			echo '</tr>';
			$avatarcount = 0;
		}
	}
	if ($avatarcount != 0)
	{
		while ($avatarcount != 5)
		{
			$output .= '<td>&nbsp;</td>';
			$avatarcount++;
		}
		echo '</tr>';
	}
	if ((($totalavatars / $vbulletin->GPC['perpage']) - intval($totalavatars / $vbulletin->GPC['perpage'])) == 0)
	{
		$numpages = $totalavatars / $vbulletin->GPC['perpage'];
	}
	else
	{
		$numpages = intval($totalavatars / $vbulletin->GPC['perpage']) + 1;
	}
	if ($vbulletin->GPC['startpage'] == 1)
	{
		$starticon = 0;
		$endicon = $vbulletin->GPC['perpage'] - 1;
	}
	else
	{
		$starticon = ($vbulletin->GPC['startpage'] - 1) * $vbulletin->GPC['perpage'];
		$endicon = ($vbulletin->GPC['perpage'] * $vbulletin->GPC['startpage']) - 1 ;
	}
	if ($numpages > 1)
	{
		for ($x = 1; $x <= $numpages; $x++)
		{
			if ($x == $vbulletin->GPC['startpage'])
			{
				$pagelinks .= " [<b>$x</b>] ";
			}
			else
			{
				$pagelinks .= " <a href=\"usertools.php?startpage=$x&amp;pp=" . $vbulletin->GPC['perpage'] . "&amp;do=avatar&amp;u=" . $vbulletin->GPC['userid'] . "\">$x</a> ";
			}
		}
	}
	if ($vbulletin->GPC['startpage'] != $numpages)
	{
		$nextstart = $vbulletin->GPC['startpage'] + 1;
		$nextpage = " <a href=\"usertools.php?startpage=$nextstart&amp;pp=" . $vbulletin->GPC['perpage'] . "&amp;do=avatar&amp;u=" . $vbulletin->GPC['userid'] . "\">" . $vbphrase['next_page'] . "</a>";
		$eicon = $endicon + 1;
	}
	else
	{
		$eicon = $totalavatars;
	}
	if ($vbulletin->GPC['startpage'] != 1)
	{
		$prevstart = $vbulletin->GPC['startpage'] - 1;
		$prevpage = "<a href=\"usertools.php?startpage=$prevstart&amp;pp=" . $vbulletin->GPC['perpage'] . "&amp;do=avatar&amp;u=" . $vbulletin->GPC['userid'] . "\">" . $vbphrase['prev_page'] . "</a> ";
	}
	$sicon = $starticon + 1;
	if ($totalavatars > 0)
	{
		if ($pagelinks)
		{
			$colspan = 3;
		}
		else
		{
			$colspan = 5;
		}
		$output .= '<tr><td class="thead" align="center" colspan="' . $colspan . '">';
		$output .= construct_phrase($vbphrase['showing_avatars_x_to_y_of_z'], $sicon, $eicon, $totalavatars) . '</td>';
		if ($pagelinks)
		{
			$output .= "<td class=\"thead\" colspan=\"2\" align=\"center\">$vbphrase[page]: <span class=\"normal\">$prevpage $pagelinks $nextpage</span></td>";
		}
		$output .= '</tr>';
	}
	$output .= '</table>';

	if ($totalavatars > 0)
	{
		print_description_row($output);
	}

	if ($nouseavatarchecked)
	{
		print_description_row($vbphrase['user_has_no_avatar']);
	}
	else
	{
		print_yes_row($vbphrase['delete_avatar'], 'avatarid', $vbphrase['yes'], '', -1);
	}
	print_table_break();
	print_table_header($vbphrase['custom_avatar']);

	require_once(DIR . '/includes/functions_user.php');
	$userinfo['avatarurl'] = fetch_avatar_url($userinfo['userid']);

	if (empty($userinfo['avatarurl']) OR $userinfo['avatarid'] != 0)
	{
		$userinfo['avatarurl'] = '<img src="../' . $vbulletin->options['cleargifurl'] . '" alt="" border="0" />';
	}
	else
	{
		$userinfo['avatarurl'] = "<img src=\"../" . $userinfo['avatarurl'][0] . "\" " . $userinfo['avatarurl'][1] . " alt=\"\" border=\"0\" />";
	}

	print_yes_row(
		iif($avatarchecked[0] != '',
			$vbphrase['use_current_avatar'] . ' ' . $userinfo['avatarurl'],
			$vbphrase['add_new_custom_avatar']
		)
	, 'avatarid', $vbphrase['yes'], $avatarchecked[0], 0);

	cache_permissions($userinfo, false);
	if ($userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canuseavatar'] AND ($userinfo['permissions']['avatarmaxwidth'] > 0 OR $userinfo['permissions']['avatarmaxheight'] > 0))
	{
		print_yes_no_row($vbphrase['resize_image_to_users_maximum_allowed_size'], 'resize');
	}
	print_input_row($vbphrase['enter_avatar_url'], 'avatarurl', 'http://www.');
	print_upload_row($vbphrase['upload_avatar_from_computer'], 'upload');
	construct_hidden_code('userid', $vbulletin->GPC['userid']);
	print_submit_row($vbphrase['save']);
}

// ###################### Start Update Avatar ################
if ($_POST['do'] == 'updateavatar')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'userid'    => TYPE_UINT,
		'avatarid'  => TYPE_INT,
		'avatarurl' => TYPE_STR,
		'resize'    => TYPE_BOOL,
	));

	$useavatar = iif($vbulletin->GPC['avatarid'] == -1, 0, 1);

	$userinfo = fetch_userinfo($vbulletin->GPC['userid']);

	if ($useavatar)
	{
		if (!$vbulletin->GPC['avatarid'])
		{
			// custom avatar
			$vbulletin->input->clean_gpc('f', 'upload', TYPE_FILE);

			require_once(DIR . '/includes/class_upload.php');
			require_once(DIR . '/includes/class_image.php');

			$upload = new vB_Upload_Userpic($vbulletin);

			$upload->data =& datamanager_init('Userpic_Avatar', $vbulletin, ERRTYPE_CP, 'userpic');
			$upload->image =& vB_Image::fetch_library($vbulletin);
			$upload->userinfo =& $userinfo;

			if ($vbulletin->GPC['resize'])
			{
				cache_permissions($userinfo, false);
				if ($userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canuseavatar'])
				{
					$upload->maxwidth = $userinfo['permissions']['avatarmaxwidth'];
					$upload->maxheight = $userinfo['permissions']['avatarmaxheight'];
					#$upload->maxuploadsize = $userinfo['permissions']['avatarmaxsize'];
					#$upload->allowanimation = ($userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['cananimateavatar']) ? true : false;
				}
			}

			if (!$upload->process_upload($vbulletin->GPC['avatarurl']))
			{
				print_stop_message('there_were_errors_encountered_with_your_upload_x', $upload->fetch_error());
			}
		}
		else
		{
			// predefined avatar
			$userpic =& datamanager_init('Userpic_Avatar', $vbulletin, ERRTYPE_CP, 'userpic');
			$userpic->condition = "userid = " . $userinfo['userid'];
			$userpic->delete();
		}
	}
	else
	{
		// not using an avatar
		$vbulletin->GPC['avatarid'] = 0;
		$userpic =& datamanager_init('Userpic_Avatar', $vbulletin, ERRTYPE_CP, 'userpic');
		$userpic->condition = "userid = " . $userinfo['userid'];
		$userpic->delete();
	}

	// init user datamanager
	$userdata =& datamanager_init('User', $vbulletin, ERRTYPE_CP);
	$userdata->set_existing($userinfo);
	$userdata->set('avatarid', $vbulletin->GPC['avatarid']);
	$userdata->save();

	define('CP_REDIRECT', "user.php?do=modify&amp;u=" . $vbulletin->GPC['userid']);
	print_stop_message('saved_avatar_successfully');
}

// ############################# start user pm stats #########################
if ($_REQUEST['do'] == 'pmfolderstats')
{

	$user = $db->query_first("
		SELECT user.*, usertextfield.*
		FROM " . TABLE_PREFIX . "user AS user
		INNER JOIN " . TABLE_PREFIX . "usertextfield AS usertextfield USING(userid)
		WHERE user.userid = " . $vbulletin->GPC['userid'] . "
	");

	if (!$user['userid'])
	{
		print_stop_message('invalid_user_specified');
	}

	$foldernames = array('0' => $vbulletin->options['inboxname'], '-1' => $vbulletin->options['sentitemsname']);
	$foldernames = unserialize($user['pmfolders']);
	$foldernames['-1'] = $vbphrase['sent_items'];
	$foldernames['0'] = $vbphrase['inbox'];
	$folders = array();
	$pms = $db->query_read("
		SELECT COUNT(*) AS messages, folderid
		FROM " . TABLE_PREFIX . "pm
		WHERE userid = $user[userid]
		GROUP BY folderid
	");
	if (!$db->num_rows($pms))
	{
		print_stop_message('no_matches_found');
	}
	while ($pm = $db->fetch_array($pms))
	{
		$pmtotal += $pm['messages'];
		$folders[$foldernames[$pm['folderid']]] = $pm['messages'];
	}

	print_form_header('user', 'edit');
	construct_hidden_code('userid', $user['userid']);
	print_table_header(construct_phrase($vbphrase['private_messages_for_x'], $user['username']) . "</b> (userid: $user[userid])<b>");
	print_cells_row(array($vbphrase['folder'], $vbphrase['number_of_messages']), 1);
	foreach($folders AS $foldername => $messages)
	{
		print_cells_row(array($foldername, $messages));
	}
	print_cells_row(array('<b>' . $vbphrase['total'] . '</b>', "<b>$pmtotal</b>"));
	print_description_row('<div align="center">' . construct_link_code($vbphrase['delete_private_messages'], "usertools.php?" . $vbulletin->session->vars['sessionurl'] . "do=removepms&amp;u=" . $vbulletin->GPC['userid']) . '</div>', 0, 2, 'thead');
	print_submit_row($vbphrase['edit_user'], 0);

}

// ############################# start PM stats #########################
if ($_REQUEST['do'] == 'pmstats')
{

	$pms = $db->query_read("
		SELECT COUNT(*) AS total, userid
		FROM " . TABLE_PREFIX . "pm
		GROUP BY userid
		ORDER BY total DESC
	");

	print_form_header('usertools', 'viewpmstats');
	print_table_header($vbphrase['private_message_statistics'], 3);
	print_cells_row(array($vbphrase['number_of_messages'], $vbphrase['number_of_users'], $vbphrase['controls']), 1);

	$groups = array();
	while ($pm = $db->fetch_array($pms))
	{
		$groups[$pm['total']]++;
	}
	foreach ($groups AS $key => $total)
	{
		$cell = array();
		$cell[] = $key . iif($vbulletin->options['pmquota'], '/' . $vbulletin->options['pmquota']);
		$cell[] = $total;
		$cell[] = construct_link_code(construct_phrase($vbphrase['list_users_with_x_messages'], $key), "usertools.php?" . $vbulletin->session->vars['sessionurl'] . "do=pmuserstats&total=$key");
		print_cells_row($cell);
	}
	print_table_footer();

}

// ############################# start PM stats #########################
if ($_REQUEST['do'] == 'pmuserstats')
{

	$vbulletin->input->clean_array_gpc('r', array(
		'total' => TYPE_UINT
	));

	$users = $db->query_read("
		SELECT COUNT( * ) AS total, pm.userid, user.username, user.lastactivity
		FROM " . TABLE_PREFIX . "pm AS pm
		LEFT JOIN " . TABLE_PREFIX . "user AS user ON (pm.userid = user.userid)
		GROUP BY pm.userid
		HAVING total = " . $vbulletin->GPC['total'] . "
		ORDER BY user.username DESC
	");

	if (!$db->num_rows($users))
	{
		print_stop_message('no_users_matched_your_query');
	}

	// a little javascript for the options menus
	?>
	<script type="text/javascript">
	function js_pm_jump(userid,username)
	{
		value = eval("document.cpform.u" + userid + ".options[document.cpform.u" + userid + ".selectedIndex].value");
		var page = '';
		switch (value)
		{
			case 'pmstats': page = "usertools.php?do=pmfolderstats&u=" + userid; break;
			case 'profile': page = "user.php?do=edit&u=" + userid; break;
			case 'pmuser': page = "../private.php?do=newpm&u=" + userid; break;
			case 'delete': page = "usertools.php?do=removepms&u=" + userid; break;
		}
		if (page != '')
		{
			window.location = page + "&s=<?php echo $vbulletin->session->vars['sessionhash']; ?>";
		}
		else
		{
			window.location = "mailto:" + value;
		}
	}
	</script>
	<?php

	print_form_header('usertools', '');
	print_table_header(construct_phrase($vbphrase['users_with_x_private_messages_stored'], $vbulletin->GPC['pms']), 3);
	print_cells_row(array($vbphrase['username'], $vbphrase['last_activity'], $vbphrase['options']), 1);
	while($user = $db->fetch_array($users))
	{
		$cell = array();
		$cell[] = "<a href=\"../member.php?" . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;u=$user[userid]\" target=\"_blank\">$user[username]</a>";
		$cell[] = vbdate($vbulletin->options['dateformat'] . ', ' . $vbulletin->options['timeformat'], $user['lastactivity']);
		$cell[] = "
		<select name=\"u$user[userid]\" onchange=\"js_pm_jump($user[userid], '$user[username]');\" tabindex=\"1\" class=\"bginput\">
			<option value=\"pmstats\">" . $vbphrase['view_private_message_statistics'] . "</option>
			<option value=\"profile\">" . $vbphrase['edit_user'] . "</option>
			<option value=\"$user[email]\">" . $vbphrase['send_email_to_user'] . "</option>
			<option value=\"pmuser\">" . $vbphrase['send_private_message_to_user'] . "</option>
			<option value=\"delete\">" . construct_phrase($vbphrase['delete_all_users_private_messages']) . "</option>
		</select><input type=\"button\" class=\"button\" value=\"$vbphrase[go]\" onclick=\"js_pm_jump($user[userid], '$user[username]');\" tabindex=\"1\" />\n\t";
		print_cells_row($cell);
	}
	print_table_footer();

}

// ############################# start do ips #########################
if ($_REQUEST['do'] == 'doips')
{
	if (function_exists('set_time_limit') AND get_cfg_var('safe_mode')==0)
	{
		@set_time_limit(0);
	}

	$vbulletin->input->clean_array_gpc('r', array(
		'depth'     => TYPE_INT,
		'username'  => TYPE_STR,
		'ipaddress' => TYPE_NOHTML,
	));

	if (empty($vbulletin->GPC['depth']))
	{
		$vbulletin->GPC['depth'] = 1;
	}

	if ($vbulletin->GPC['username'])
	{
		$getuserid = $db->query_first("
			SELECT userid
			FROM " . TABLE_PREFIX . "user
			WHERE username = '" . $db->escape_string(htmlspecialchars_uni($vbulletin->GPC['username'])) . "'
		");
		$userid = intval($getuserid['userid']);
		if (!$userid)
		{
			print_stop_message('invalid_user_specified');
		}
		$userinfo = fetch_userinfo($userid);
	}
	else if ($vbulletin->GPC['userid'])
	{
		$userid = $vbulletin->GPC['userid'];
		$userinfo = fetch_userinfo($userid);
		if (!$userinfo)
		{
			print_stop_message('invalid_user_specified');
		}
		$vbulletin->GPC['username'] = unhtmlspecialchars($userinfo['username']);
	}
	else
	{
		$userid = 0;
	}

	if ($vbulletin->GPC['ipaddress'] OR $userid)
	{
		if ($vbulletin->GPC['ipaddress'])
		{
			print_form_header('', '');
			print_table_header(construct_phrase($vbphrase['ip_address_search_for_ip_address_x'], $vbulletin->GPC['ipaddress']));
			$hostname = @gethostbyaddr($vbulletin->GPC['ipaddress']);
			if (!$hostname OR $hostname == $vbulletin->GPC['ipaddress'])
			{
				$hostname = $vbphrase['could_not_resolve_hostname'];
			}
			print_description_row("<div style=\"margin-left:20px\"><a href=\"usertools.php?" . $vbulletin->session->vars['sessionurl'] . "do=gethost&amp;ip=" . $vbulletin->GPC['ipaddress'] . "\">" . $vbulletin->GPC['ipaddress'] . "</a> : <b>$hostname</b></div>");

			$results = construct_ip_usage_table($vbulletin->GPC['ipaddress'], 0, $vbulletin->GPC['depth']);
			print_description_row($vbphrase['post_ip_addresses'], false, 2, 'thead');
			print_description_row($results ? $results : $vbphrase['no_matches_found']);

			$results = construct_ip_register_table($vbulletin->GPC['ipaddress'], 0, $vbulletin->GPC['depth']);
			print_description_row($vbphrase['registration_ip_addresses'], false, 2, 'thead');
			print_description_row($results ? $results : $vbphrase['no_matches_found']);

			print_table_footer();
		}

		if ($userid)
		{
			print_form_header('', '');
			print_table_header(construct_phrase($vbphrase['ip_address_search_for_user_x'], htmlspecialchars_uni($vbulletin->GPC['username'])));
			print_label_row($vbphrase['registration_ip_address'], ($userinfo['ipaddress'] ? $userinfo['ipaddress'] : $vbphrase['n_a']));

			$results = construct_user_ip_table($userid, 0, $vbulletin->GPC['depth']);
			print_description_row($vbphrase['post_ip_addresses'], false, 2, 'thead');
			print_description_row($results ? $results : $vbphrase['no_matches_found']);

			print_table_footer();
		}
	}

	print_form_header('usertools', 'doips');
	print_table_header($vbphrase['search_ip_addresses']);
	print_input_row($vbphrase['find_users_by_ip_address'], 'ipaddress', $vbulletin->GPC['ipaddress'], 0);
	print_input_row($vbphrase['find_ip_addresses_for_user'], 'username', $vbulletin->GPC['username']);
	print_select_row($vbphrase['depth_to_search'], 'depth', array(1 => 1, 2 => 2), $vbulletin->GPC['depth']);
	print_submit_row($vbphrase['find']);
}

// ############################# start gethost #########################
if ($_REQUEST['do'] == 'gethost')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'ip' => TYPE_NOHTML,
	));

	print_form_header('', '');
	print_table_header($vbphrase['ip_address']);
	print_label_row($vbphrase['ip_address'], $vbulletin->GPC['ip']);
	$resolvedip = @gethostbyaddr($vbulletin->GPC['ip']);
	if ($resolvedip == $vbulletin->GPC['ip'])
	{
		print_label_row($vbphrase['host_name'], '<i>' . $vbphrase['n_a'] . '</i>');
	}
	else
	{
		print_label_row($vbphrase['host_name'], "<b>$resolvedip</b>");
	}
	print_table_footer();
}

// ############################# start referrers #########################
if ($_REQUEST['do'] == 'referrers')
{

	print_form_header('usertools', 'showreferrers');
	print_table_header($vbphrase['referrals']);
	print_description_row($vbphrase['please_input_referral_dates']);
	print_time_row($vbphrase['start_date'], 'startdate', TIMENOW - 24 * 60 * 60 * 31, 1, 0, 'middle');
	print_time_row($vbphrase['end_date'], 'enddate', TIMENOW, 1, 0, 'middle');
	print_submit_row($vbphrase['find']);

}

// ############################# start show referrers #########################
if ($_POST['do'] == 'showreferrers')
{

	$vbulletin->input->clean_array_gpc('p', array(
		'startdate' => TYPE_ARRAY_INT,
		'enddate'   => TYPE_ARRAY_INT
	));

	require_once(DIR . '/includes/functions_misc.php');
	if ($vbulletin->GPC['startdate']['month'])
	{
		$vbulletin->GPC['startdate'] = vbmktime(intval($vbulletin->GPC['startdate']['hour']), intval($vbulletin->GPC['startdate']['minute']), 0, intval($vbulletin->GPC['startdate']['month']), intval($vbulletin->GPC['startdate']['day']), intval($vbulletin->GPC['startdate']['year']));
		$datequery = " AND users.joindate >= " . $vbulletin->GPC['startdate'];
		$datestart = vbdate($vbulletin->options['dateformat'] . ' ' .  $vbulletin->options['timeformat'], $vbulletin->GPC['startdate']);
	}
	else
	{
		$vbulletin->GPC['startdate'] = 0;
	}

	if ($vbulletin->GPC['enddate']['month'])
	{
		$vbulletin->GPC['enddate'] = vbmktime(intval($vbulletin->GPC['enddate']['hour']), intval($vbulletin->GPC['enddate']['minute']), 0, intval($vbulletin->GPC['enddate']['month']), intval($vbulletin->GPC['enddate']['day']), intval($vbulletin->GPC['enddate']['year']));
		$datequery .= " AND users.joindate <= " . $vbulletin->GPC['enddate'];
		$dateend = vbdate($vbulletin->options['dateformat'] . ' ' . $vbulletin->options['timeformat'], $vbulletin->GPC['enddate']);
	}
	else
	{
		$vbulletin->GPC['enddate'] = 0;
	}

	if ($datestart OR $dateend)
	{
		$refperiod = construct_phrase($vbphrase['x_to_y'], $datestart, $dateend);
	}
	else
	{
		$refperiod = $vbphrase['all_time'];
	}

	$users = $db->query_read("
		SELECT COUNT(*) AS count, user.username, user.userid
		FROM " . TABLE_PREFIX . "user AS users
		INNER JOIN " . TABLE_PREFIX . "user AS user ON(users.referrerid = user.userid)
		WHERE users.referrerid <> 0
			$datequery
		GROUP BY users.referrerid
		ORDER BY count DESC
	");
	if (!$db->num_rows($users))
	{
		define('CP_REDIRECT', 'usertools.php?do=referrers');
		print_stop_message('no_referrals_matched_your_query');
	}
	else
	{
		print_form_header('', '');
		print_table_header($vbphrase['referrals'] . ' - ' .	$refperiod);
		print_cells_row(array($vbphrase['username'], $vbphrase['total']), 1);
		while ($user=$db->fetch_array($users))
		{
			print_cells_row(array("<a href=\"usertools.php?" . $vbulletin->session->vars['sessionurl'] . "do=showreferrals&amp;referrerid=$user[userid]&amp;startdate=" . $vbulletin->GPC['startdate'] . "&amp;enddate=" . $vbulletin->GPC['enddate'] . "\">$user[username]</a>", vb_number_format($user['count'])));
		}
		print_table_footer();
	}
}

// ############################# start show referrals #########################
if ($_REQUEST['do'] == 'showreferrals')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'startdate'  => TYPE_INT,
		'enddate'    => TYPE_INT,
		'referrerid' => TYPE_INT
	));

	if ($vbulletin->GPC['startdate'])
	{
		$datequery = " AND joindate >= " . $vbulletin->GPC['startdate'];
		$datestart = vbdate($vbulletin->options['dateformat'] . ' ' . $vbulletin->options['timeformat'], $vbulletin->GPC['startdate']);
	}
	if ($vbulletin->GPC['enddate'])
	{
		$datequery .= " AND joindate <= " . $vbulletin->GPC['enddate'];
		$dateend = vbdate($vbulletin->options['dateformat'] . ' ' . $vbulletin->options['timeformat'], $vbulletin->GPC['enddate']);
	}

	if ($datestart OR $dateend)
	{
		$refperiod = construct_phrase($vbphrase['x_to_y'], $datestart, $dateend);
	}
	else
	{
		$refperiod = $vbphrase['all_time'];
	}

	$username = $db->query_first("SELECT username FROM " . TABLE_PREFIX . "user WHERE userid = " . $vbulletin->GPC['referrerid']);
	$users = $db->query_read("
		SELECT username, posts, userid, joindate, lastvisit, email
		FROM " . TABLE_PREFIX . "user
		WHERE referrerid = " . $vbulletin->GPC['referrerid'] . "
		$datequery
		ORDER BY joindate DESC
	");

	print_form_header('', '');
	print_table_header(construct_phrase($vbphrase['referrals_for_x'], $username['username']) . ' - ' .	$refperiod, 5);
	print_cells_row(array(
		$vbphrase['username'],
		$vbphrase['post_count'],
		$vbphrase['email'],
		$vbphrase['join_date'],
		$vbphrase['last_visit']
	), 1);

	while($user = $db->fetch_array($users))
	{
		$cell = array();
		$cell[] = "<a href=\"user.php?" . $vbulletin->session->vars['sessionurl'] . "do=edit&amp;u=$user[userid]\">$user[username]</a>";
		$cell[] = vb_number_format($user['posts']);
		$cell[] = "<a href=\"mailto:$user[email]\">$user[email]</a>";
		$cell[] = '<span class="smallfont">' . vbdate($vbulletin->options['dateformat'] . ', ' . $vbulletin->options['timeformat'], $user['joindate']) . '</span>';
		$cell[] = '<span class="smallfont">' . vbdate($vbulletin->options['dateformat'] . ', ' . $vbulletin->options['timeformat'], $user['lastvisit']) . '</span>';
		print_cells_row($cell);
	}
	print_table_footer();
}

print_cp_footer();

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: usertools.php,v $ - $Revision: 1.57 $
|| ####################################################################
\*======================================================================*/
?>