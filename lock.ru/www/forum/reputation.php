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
define('THIS_SCRIPT', 'reputation');
define('VB_ERROR_LITE', true);

// disable PM Popup if posting reputation
if ($_POST['do'] == 'addreputation')
{
	define('NOPMPOPUP', 1);
}

// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array('reputation');

// get special data templates from the datastore
$specialtemplates = array(
	'smiliecache',
	'bbcodecache'
);

// pre-cache templates used by all actions
$globaltemplates = array(
	'reputation',
	'reputation_adjust',
	'reputation_reasonbits',
	'reputation_yourpost',
	'reputationbit',
	'STANDARD_ERROR_LITE'
);

// pre-cache templates used by specific actions
$actiontemplates = array();

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions_reputation.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

if ($_REQUEST['do'] == 'close')
{
	$show['closewindow'] = true;
	$reputationbit = '';
	eval('print_output("' . fetch_template('reputation') . '");');
}
else
{
	$show['closewindow'] = false;
}

if (!$vbulletin->options['reputationenable'])
{
	eval(standard_error(fetch_error('reputationdisabled')));
}

if (!$postinfo['postid'] OR !$threadinfo['threadid'] OR (!$threadinfo['visible'] AND !can_moderate($threadinfo['forumid'], 'canmoderateposts')) OR (!$postinfo['visible'] AND !can_moderate($threadinfo['forumid'], 'canmoderateposts'))OR $postinfo['isdeleted'] OR $threadinfo['isdeleted'])
{
	eval(standard_error(fetch_error('invalidid', $vbphrase['post'], $vbulletin->options['contactuslink'])));
}

$forumperms = fetch_permissions($threadinfo['forumid']);

if (!($forumperms & $vbulletin->bf_ugp_forumpermissions['canview']) OR !($forumperms & $vbulletin->bf_ugp_forumpermissions['canviewthreads']))
{
	print_no_permission();
}
if (!($forumperms & $vbulletin->bf_ugp_forumpermissions['canviewothers']) AND ($threadinfo['postuserid'] != $vbulletin->userinfo['userid'] OR $vbulletin->userinfo['userid'] == 0))
{
	print_no_permission();
}

if ((!($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canuserep']) AND $vbulletin->userinfo['userid'] != $postinfo['userid']) OR !$vbulletin->userinfo['userid'])
{
	print_no_permission();
}

// check if there is a forum password and if so, ensure the user has it set
verify_forum_password($foruminfo['forumid'], $foruminfo['password']);

$userid = $db->query_first("SELECT userid FROM " . TABLE_PREFIX . "post WHERE postid = $postid");
$userinfo = fetch_userinfo($userid['userid']);
$userid = $userinfo['userid'];

if ($vbulletin->usergroupcache["$userinfo[usergroupid]"]['genericoptions'] & $vbulletin->bf_ugp_genericoptions['isbannedgroup'])
{
	eval(standard_error(fetch_error('reputationbanned')));
}

if (!$userid)
{
	eval(standard_error(fetch_error('invalidid', $vbphrase['user'], $vbulletin->options['contactuslink'])));
}

($hook = vBulletinHook::fetch_hook('reputation_start')) ? eval($hook) : false;

if ($_POST['do'] == 'addreputation')
{  // adjust reputation ratings

	$vbulletin->input->clean_array_gpc('p', array(
		'reputation'	=> TYPE_NOHTML,
		'reason'		=> TYPE_STR
	));

	if ($userid == $vbulletin->userinfo['userid'])
	{
		eval(standard_error(fetch_error('reputationownpost')));
	}

	$score = fetch_reppower($vbulletin->userinfo, $permissions, $vbulletin->GPC['reputation']);

	// Check if the user has already reputation this post
	if ($repeat = $db->query_first("
		SELECT postid
		FROM " . TABLE_PREFIX . "reputation
		WHERE postid = $postid AND
			whoadded = " . $vbulletin->userinfo['userid']
	))
	{
		eval(standard_error(fetch_error('reputationsamepost')));
	}

	($hook = vBulletinHook::fetch_hook('reputation_add_start')) ? eval($hook) : false;

	if (!($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel']))
	{
		if ($vbulletin->options['maxreputationperday'] >= $vbulletin->options['reputationrepeat'])
		{
			$klimit = ($vbulletin->options['maxreputationperday'] + 1);
		}
		else
		{
			$klimit = ($vbulletin->options['reputationrepeat'] + 1);
		}
		$checks = $db->query_read("
			SELECT userid, dateline
			FROM " . TABLE_PREFIX . "reputation
			WHERE whoadded = " . $vbulletin->userinfo['userid'] . "
			ORDER BY dateline DESC
			LIMIT 0, $klimit
		");

		$i = 0;
		while ($check = $db->fetch_array($checks))
		{
			if (($i < $vbulletin->options['reputationrepeat']) AND ($check['userid'] == $userid))
			{
				eval(standard_error(fetch_error('reputationsameuser', $userinfo['username'])));
			}
			if (($i + 1) == $vbulletin->options['maxreputationperday'] AND (($check['dateline'] + 86400) > TIMENOW))
			{
				eval(standard_error(fetch_error('reputationtoomany')));
			}
			$i++;
		}
	}

	$userinfo['reputation'] += $score;

	// Determine this user's reputationlevelid.
	$reputationlevel = $db->query_first("
		SELECT reputationlevelid
		FROM " . TABLE_PREFIX . "reputationlevel
		WHERE $userinfo[reputation] >= minimumreputation
		ORDER BY minimumreputation
		DESC LIMIT 1
	");

	// init user data manager
	$userdata =& datamanager_init('User', $vbulletin, ERRTYPE_STANDARD);
	$userdata->set_existing($userinfo);
	$userdata->set('reputation', $userinfo['reputation']);
	$userdata->set('reputationlevelid', intval($reputationlevel['reputationlevelid']));

	($hook = vBulletinHook::fetch_hook('reputation_add_process')) ? eval($hook) : false;

	$userdata->save();

	/*insert query*/
	$db->query_write("
		INSERT INTO " . TABLE_PREFIX . "reputation (postid, reputation, userid, whoadded, reason, dateline)
		VALUES ($postid, $score, $userid, " . $vbulletin->userinfo['userid'] . ", '" . $db->escape_string(fetch_censored_text($vbulletin->GPC['reason'])) . "','" . TIMENOW . "')
	");

	($hook = vBulletinHook::fetch_hook('reputation_add_complete')) ? eval($hook) : false;

	$vbulletin->url = 'reputation.php?' . $vbulletin->session->vars['sessionurl'] . "do=close&amp;p=$postid";
	eval(print_standard_redirect('redirect_reputationadd'));
	// redirect or close window here
}
else
{
	if ($vbulletin->userinfo['userid'] == $userid)
	{ // is this your own post?

		($hook = vBulletinHook::fetch_hook('reputation_viewown_start')) ? eval($hook) : false;

		if ($postreputations = $db->query_read("
			SELECT reputation, reason
			FROM " . TABLE_PREFIX . "reputation
			WHERE postid = $postid
			ORDER BY dateline DESC
		"))
		{

			require_once(DIR . '/includes/class_bbcode.php');
			$bbcode_parser =& new vB_BbCodeParser($vbulletin, fetch_tag_list());

			while ($postreputation = $db->fetch_array($postreputations))
			{
				$total += $postreputation['reputation'];
				if(strlen($postreputation['reason']) > 0)
				{
					if ($postreputation['reputation'] > 0)
					{
						$posneg = 'pos';
					}
					else if ($postreputation['reputation'] < 0)
					{
						$posneg = 'neg';
					}
					else
					{
						$posneg = 'balance';
					}
					$reason = $bbcode_parser->parse($postreputation['reason']);
					exec_switch_bg();

					($hook = vBulletinHook::fetch_hook('reputation_viewown_bit')) ? eval($hook) : false;

					eval('$reputation_reasonbits .= "' . fetch_template('reputation_reasonbits') . '";');
				}
			}

			if ($total == 0)
			{
				$reputation = $vbphrase['even'];
			}
			else if ($total > 0 AND $total <= 5)
			{
				$reputation = $vbphrase['somewhat_positive'];
			}
			else if ($total > 5 AND $total <= 15)
			{
				$reputation = $vbphrase['positive'];
			}
			else if ($total > 15 AND $total <= 25)
			{
				$reputation = $vbphrase['very_positive'];
			}
			else if ($total > 25)
			{
				$reputation = $vbphrase['extremely_positive'];
			}
			else if ($total < 0 AND $total >= -5)
			{
				$reputation = $vbphrase['somewhat_negative'];
			}
			else if ($total < -5 AND $total >= -15)
			{
				$reputation = $vbphrase['negative'];
			}
			else if ($total < -15 AND $total >= -25)
			{
				$reputation = $vbphrase['very_negative'];
			}
			else if ($total < -25)
			{
				$reputation = $vbphrase['extremely_negative'];
			}
		}
		else
		{
			$reputation = $vbphrase['even'];
		}

		($hook = vBulletinHook::fetch_hook('reputation_viewown_complete')) ? eval($hook) : false;

		eval('$reputationbit = "' . fetch_template('reputation_yourpost') . '";');

	}
	else
	{  // Not Your Post

		if ($repeat = $db->query_first("
			SELECT postid
			FROM " . TABLE_PREFIX . "reputation
			WHERE postid = $postid AND
				whoadded = " . $vbulletin->userinfo['userid']
			))
		{
			eval(standard_error(fetch_error('reputationsamepost')));
		}

		if (!($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel']))
		{
			if ($vbulletin->options['maxreputationperday'] >= $vbulletin->options['reputationrepeat'])
			{
				$klimit = ($vbulletin->options['maxreputationperday'] + 1);
			}
			else
			{
				$klimit = ($vbulletin->options['reputationrepeat'] + 1);
			}
			$checks = $db->query_read("
				SELECT userid, dateline
				FROM " . TABLE_PREFIX . "reputation
				WHERE whoadded = " . $vbulletin->userinfo['userid'] . "
				ORDER BY dateline DESC
				LIMIT 0, $klimit
			");

			$i = 0;
			while ($check = $db->fetch_array($checks))
			{
				if (($i < $vbulletin->options['reputationrepeat']) AND ($check['userid'] == $userid))
				{
					eval(standard_error(fetch_error('reputationsameuser', $userinfo['username'])));
				}
				if (($i + 1) == $vbulletin->options['maxreputationperday'] AND (($check['dateline'] + 86400) > TIMENOW))
				{
					eval(standard_error(fetch_error('reputationtoomany')));
				}
				$i++;
			}
		}

		$show['negativerep'] = iif($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['cannegativerep'], true, false);

		($hook = vBulletinHook::fetch_hook('reputation_form')) ? eval($hook) : false;

		eval('$reputationbit = "' . fetch_template('reputationbit') . '";');
	}
	eval('print_output("' . fetch_template('reputation') . '");');
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: reputation.php,v $ - $Revision: 1.67 $
|| ####################################################################
\*======================================================================*/
?>