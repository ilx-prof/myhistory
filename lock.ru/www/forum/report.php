<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.5.0 Release Candidate 3                              # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2000-2005 Jelsoft Enterprises Ltd. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS        # ||
|| #################################################################### ||
\*======================================================================*/

// ####################### SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'report');

// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array('messaging');

// get special data templates from the datastore
$specialtemplates = array();

// pre-cache templates used by all actions
$globaltemplates = array(
	'newpost_usernamecode',
	'reportbadpost'
);

// pre-cache templates used by specific actions
$actiontemplates = array();

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

//check usergroup of user to see if they can use this
if (!$vbulletin->userinfo['userid'])
{
	print_no_permission();
}

if (!$vbulletin->options['enableemail'])
{
	eval(standard_error(fetch_error('emaildisabled')));
}

if (empty($_REQUEST['do']))
{
	$_REQUEST['do'] = 'report';
}

$forumperms = fetch_permissions($threadinfo['forumid']);
if (!($forumperms & $vbulletin->bf_ugp_forumpermissions['canview']) OR !($forumperms & $vbulletin->bf_ugp_forumpermissions['canviewthreads']))
{
	print_no_permission();
}

if (!$threadinfo['threadid'] OR !$postinfo['visible'] OR !$threadinfo['visible'] OR !$postinfo['postid'] OR $threadinfo['isdeleted'] OR $postinfo['isdeleted'])
{
	eval(standard_error(fetch_error('invalidid', $vbphrase['post'], $vbulletin->options['contactuslink'])));
}

// check if there is a forum password and if so, ensure the user has it set
verify_forum_password($foruminfo['forumid'], $foruminfo['password']);

($hook = vBulletinHook::fetch_hook('report_start')) ? eval($hook) : false;

if ($_REQUEST['do'] == 'report')
{
	/*if ($postinfo['userid'] == $vbulletin->userinfo['userid'])
	{
		eval(standard_error(fetch_error('cantreportself')));
	}*/

	// draw nav bar
	$navbits = array();
	$parentlist = array_reverse(explode(',', $foruminfo['parentlist']));
	foreach ($parentlist AS $forumID)
	{
		$forumTitle = $vbulletin->forumcache["$forumID"]['title'];
		$navbits['forumdisplay.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumID"] = $forumTitle;
	}
	$navbits['showthread.php?' . $vbulletin->session->vars['sessionurl'] . "p=$postid"] = $threadinfo['title'];
	$navbits[''] = $vbphrase['report_bad_post'];
	$navbits = construct_navbits($navbits);

	require_once(DIR . '/includes/functions_editor.php');
	$textareacols = fetch_textarea_width();
	eval('$usernamecode = "' . fetch_template('newpost_usernamecode') . '";');

	eval('$navbar = "' . fetch_template('navbar') . '";');

	($hook = vBulletinHook::fetch_hook('report_form_start')) ? eval($hook) : false;

	$url =& $vbulletin->url;
	eval('print_output("' . fetch_template('reportbadpost') . '");');

}

if ($_POST['do'] == 'sendemail')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'reason'	=> TYPE_STR,
	));

	if ($vbulletin->GPC['reason'] == '')
	{
		eval(standard_error(fetch_error('noreason')));
	}

	$moderators = $db->query_read("
		SELECT DISTINCT user.email, user.languageid, user.userid, user.username
		FROM " . TABLE_PREFIX . "moderator AS moderator,
			" . TABLE_PREFIX . "user AS user
		WHERE user.userid = moderator.userid
			AND moderator.forumid IN ($foruminfo[parentlist])
	");

	$mods = array();

	while ($moderator = $db->fetch_array($moderators))
	{
		$mods[] = $moderator;
	}

	$threadinfo['title'] = unhtmlspecialchars($threadinfo['title']);
	$postinfo['title'] = unhtmlspecialchars($postinfo['title']);

	if (empty($mods) OR $foruminfo['options'] & $vbulletin->bf_misc_forumoptions['warnall'])
	{
		// get admins if no mods or if this forum notifies all
		$moderators = $db->query_read("
			SELECT user.email, user.languageid, user.username, user.userid
			FROM " . TABLE_PREFIX . "user AS user
			INNER JOIN " . TABLE_PREFIX . "usergroup AS usergroup USING (usergroupid)
			WHERE usergroup.adminpermissions <> 0
		");

		while ($moderator = $db->fetch_array($moderators))
		{
			$mods[] = $moderator;
		}
	}

	($hook = vBulletinHook::fetch_hook('report_send_process')) ? eval($hook) : false;

	$reason =& $vbulletin->GPC['reason'];
	foreach ($mods AS $index => $moderator)
	{
		if (!empty($moderator['email']))
		{
			$email_langid = ($moderator['languageid'] > 0 ? $moderator['languageid'] : $vbulletin->options['languageid']);

			($hook = vBulletinHook::fetch_hook('report_send_email')) ? eval($hook) : false;

			eval(fetch_email_phrases('reportbadpost', $email_langid));
			vbmail($moderator['email'], $subject, $message, true);
		}
	}

	($hook = vBulletinHook::fetch_hook('report_send_complete')) ? eval($hook) : false;

	eval(print_standard_redirect('redirect_reportthanks'));
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: report.php,v $ - $Revision: 1.67 $
|| ####################################################################
\*======================================================================*/
?>