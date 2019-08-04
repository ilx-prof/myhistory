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
define('THIS_SCRIPT', 'index');

// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array('holiday');

// get special data templates from the datastore
$specialtemplates = array(
	'userstats',
	'birthdaycache',
	'maxloggedin',
	'iconcache',
	'eventcache',
	'mailqueue'
);

// pre-cache templates used by all actions
$globaltemplates = array(
	'FORUMHOME',
	'forumhome_event',
	'forumhome_forumbit_level1_nopost',
	'forumhome_forumbit_level1_post',
	'forumhome_forumbit_level2_nopost',
	'forumhome_forumbit_level2_post',
	'forumhome_lastpostby',
	'forumhome_loggedinuser',
	'forumhome_moderator',
	'forumhome_pmloggedin',
	'forumhome_subforumbit_nopost',
	'forumhome_subforumbit_post',
	'forumhome_subforumseparator_nopost',
	'forumhome_subforumseparator_post'
);

// pre-cache templates used by specific actions
$actiontemplates = array();

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions_bigthree.php');
require_once(DIR . '/includes/functions_forumlist.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

($hook = vBulletinHook::fetch_hook('forumhome_start')) ? eval($hook) : false;

// get permissions to view forumhome
if (!($permissions['forumpermissions'] & $vbulletin->bf_ugp_forumpermissions['canview']))
{
	print_no_permission();
}

if (empty($foruminfo['forumid']))
{
	// show all forums
	$forumid = -1;
}
else
{
	// draw nav bar
	$navbits = array();
	$parentlist = array_reverse(explode(',', substr($foruminfo['parentlist'], 0, -3)));
	foreach ($parentlist AS $forumID)
	{
		$forumTitle =& $vbulletin->forumcache["$forumID"]['title'];
		$navbits['forumdisplay.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumID"] = $forumTitle;
	}

	// pop the last element off the end of the $nav array so that we can show it without a link
	array_pop($navbits);

	$navbits[''] = $foruminfo['title'];
	$navbits = construct_navbits($navbits);
}

$today = vbdate('Y-m-d', TIMENOW, false, false);

// ### TODAY'S BIRTHDAYS #################################################
if ($vbulletin->options['showbirthdays'])
{
	if (!is_array($vbulletin->birthdaycache) OR ($today != $vbulletin->birthdaycache['day1'] AND $today != $vbulletin->birthdaycache['day2']))
	{
		// Need to update!
		require_once(DIR . '/includes/functions_databuild.php');
		$birthdaystore = build_birthdays();
		DEVDEBUG('Updated Birthdays');
	}
	else
	{
		$birthdaystore = $vbulletin->birthdaycache;
	}

	switch ($today)
	{
		case $birthdaystore['day1']:
			$birthdays = $birthdaystore['users1'];
			break;

		case $birthdaystore['day2']:
			$birthdays = $birthdaystore['users2'];
			break;
	}
	// memory saving
	unset($birthdaystore);

	if ($stylevar['dirmark'])
	{
		$birthdays = str_replace('<!--rlm-->', $stylevar['dirmark'], $birthdays);
	}

	$show['birthdays'] = iif ($birthdays, true, false);
}
else
{
	$show['birthdays'] = false;
}

// ### TODAY'S EVENTS #################################################
if ($vbulletin->options['showevents'])
{
	require_once(DIR . '/includes/functions_calendar.php');

	$future = gmdate('n-j-Y' , TIMENOW + 86400 * $vbulletin->options['showevents']);

	if (!is_array($vbulletin->eventcache) OR $future != $vbulletin->eventcache['date'])
	{
		// Need to update!
		require_once(DIR . '/includes/functions_databuild.php');
		$eventstore = build_events();
		DEVDEBUG('Updated Events');
	}
	else
	{
		$eventstore = $vbulletin->eventcache;
	}

	unset($eventstore['date']);
	$events = array();
	$eventcount = 0;
	foreach ($eventstore AS $eventid => $eventinfo)
	{
		$offset = $eventinfo['utc'] ? $vbulletin->userinfo['timezoneoffset'] : ($vbulletin->userinfo['timezoneoffset'] ? $vbulletin->userinfo['tzoffset'] : $vbulletin->userinfo['timezoneoffset']);
		$eventstore["$eventid"]['dateline_from_user'] = $eventinfo['dateline_from_user'] = $eventinfo['dateline_from'] + $offset * 3600;
		$eventstore["$eventid"]['dateline_to_user'] = $eventinfo['dateline_to_user'] = $eventinfo['dateline_to'] + $offset * 3600;
		$gettime = TIMENOW - $vbulletin->options['hourdiff'];
		$iterations = 0;
		$todaydate = getdate($gettime);

		if ($vbulletin->userinfo['calendarpermissions']["$eventinfo[calendarid]"] & $vbulletin->bf_ugp_calendarpermissions['canviewcalendar'] OR ($eventinfo['holidayid'] AND $vbulletin->options['showholidays']))
		{
			if ($eventinfo['userid'] == $vbulletin->userinfo['userid'] OR $vbulletin->userinfo['calendarpermissions']["$eventinfo[calendarid]"] & $vbulletin->bf_ugp_calendarpermissions['canviewothersevent'] OR ($eventinfo['holidayid'] AND $vbulletin->options['showholidays']))
			{
				if (!$eventinfo['recurring'] AND !$vbulletin->options['showeventtype'] AND !$eventinfo['singleday'] AND cache_event_info($eventinfo, $todaydate['mon'], $todaydate['mday'], $todaydate['year']))
				{
					$events["$eventid"][] = true;
				}
				else
				{
					while ($iterations < $vbulletin->options['showevents'])
					{
						$addcache = false;

						$todaydate = getdate($gettime);
						if ($eventinfo['holidayid'] AND $eventinfo['recurring'] == 6)
						{
							if ($eventinfo['recuroption'] == "$todaydate[mon]|$todaydate[mday]")
							{
								$addcache = true;
							}
						}
						else if (cache_event_info($eventinfo, $todaydate['mon'], $todaydate['mday'], $todaydate['year']))
						{
							$addcache = true;
						}

						if ($addcache)
						{
							if (!$vbulletin->options['showeventtype'])
							{
								$events["$eventid"][] = $gettime;
							}
							else
							{
								$events["$gettime"][] = $eventid;
							}
							$eventcount++;
						}

						$iterations++;
						$gettime += 86400;
					}
				}
			}
		}
	}

	if (!empty($events))
	{
		ksort($events, SORT_NUMERIC);
		foreach($events AS $index => $value)
		{
			$pastevent = 0;
			$pastcount = 0;


			$comma = $eventdates = $daysevents = '';
			if (!$vbulletin->options['showeventtype'])
			{	// Group by Event // $index = $eventid
				$eventinfo = $eventstore["$index"];
				if (empty($eventinfo['recurring']) AND empty($eventinfo['singleday']))
				{	// ranged event -- show it from its real start and real end date
					$eventdates = construct_phrase($vbphrase['event_x_to_y'], vbdate($vbulletin->options['dateformat'], $eventinfo['dateline_from_user'], false, true), vbdate($vbulletin->options['dateformat'], $eventinfo['dateline_to_user'], false, true));
					$day = vbdate('Y-n-j', $eventinfo['dateline_from_user'], false, false);
				}
				else
				{
					unset($day);
					foreach($value AS $key => $dateline)
					{
						if (($dateline - 86400) == $pastevent AND !$eventinfo['holidayid'])
						{
							$pastevent = $dateline;
							$pastcount++;
							continue;
						}
						else
						{
							if ($pastcount)
							{
								$eventdates = construct_phrase($vbphrase['event_x_to_y'], $eventdates, vbdate($vbulletin->options['dateformat'], $pastevent, false, true, false));
							}
							$pastcount = 0;
							$pastevent = $dateline;
						}
						if (!$day)
						{
							$day = vbdate('Y-n-j', $dateline, false, false, false);
						}
						$eventdates .= $comma . vbdate($vbulletin->options['dateformat'], $dateline, false, true, false);
						$comma = ', ';
					}
					if ($pastcount)
					{
						$eventdates = construct_phrase($vbphrase['event_x_to_y'], $eventdates, vbdate($vbulletin->options['dateformat'], $pastevent, false, true, false));
					}
				}

				if ($eventinfo['holidayid'])
				{
					$callink = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;day=$day\">" . $vbphrase['holiday_title_' . $eventinfo['varname']] . "</a>";
				}
				else
				{
					$callink = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;day=$day&amp;e=$eventinfo[eventid]&amp;c=$eventinfo[calendarid]\">$eventinfo[title]</a>";
				}
			}
			else
			{	// Group by Date
				$eventdate = vbdate($vbulletin->options['dateformat'], $index, false, true, false);

				$day = vbdate('Y-n-j', $index, false, true, false);
				foreach($value AS $key => $eventid)
				{
					$eventinfo = $eventstore["$eventid"];
					if ($eventinfo['holidayid'])
					{
						$daysevents .= $comma . '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;day=$day\">" . $vbphrase['holiday_title_' . $eventinfo['varname']] . "</a>";
					}
					else
					{
						$daysevents .= $comma . '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;day=$day&amp;e=$eventinfo[eventid]&amp;c=$eventinfo[calendarid]\">$eventinfo[title]</a>";
					}
					$comma = ', ';
				}
			}

			($hook = vBulletinHook::fetch_hook('forumhome_event')) ? eval($hook) : false;
			eval('$upcomingevents .= "' . fetch_template('forumhome_event') . '";');
		}
		// memory saving
		unset($events, $eventstore);
	}
	$show['upcomingevents'] = iif ($upcomingevents, true, false);
	$show['todaysevents'] = iif ($vbulletin->options['showevents'] == 1, true, false);
}
else
{
	$show['upcomingevents'] = false;
}

// ### LOGGED IN USERS #################################################
$activeusers = '';
if ($vbulletin->options['displayloggedin'] AND !$show['search_engine'])
{
	$datecut = TIMENOW - $vbulletin->options['cookietimeout'];
	$numbervisible = 0;
	$numberregistered = 0;
	$numberguest = 0;

	$forumusers = $db->query_read("
		SELECT
			user.username, (user.options & " . $vbulletin->bf_misc_useroptions['invisible'] . ") AS invisible, user.usergroupid,
			session.userid, session.inforum, session.lastactivity,
			IF(displaygroupid=0, user.usergroupid, displaygroupid) AS displaygroupid
		FROM " . TABLE_PREFIX . "session AS session
		LEFT JOIN " . TABLE_PREFIX . "user AS user ON(user.userid = session.userid)
		WHERE session.lastactivity > $datecut
		" . iif($vbulletin->options['displayloggedin'] == 1, "ORDER BY username ASC") . "
	");

	if ($vbulletin->userinfo['userid'])
	{
		// fakes the user being online for an initial page view of index.php
		$vbulletin->userinfo['joingroupid'] = iif($vbulletin->userinfo['displaygroupid'], $vbulletin->userinfo['displaygroupid'], $vbulletin->userinfo['usergroupid']);
		$userinfos = array
		(
			$vbulletin->userinfo['userid'] => array
			(
				'userid' => $vbulletin->userinfo['userid'],
				'username' => $vbulletin->userinfo['username'],
				'invisible' => $vbulletin->userinfo['invisible'],
				'inforum' => 0,
				'lastactivity' => TIMENOW,
				'usergroupid' => $vbulletin->userinfo['usergroupid'],
				'displaygroupid' => $vbulletin->userinfo['displaygroupid'],
			)
		);
	}
	else
	{
		$userinfos = array();
	}
	$inforum = array();

	while ($loggedin = $db->fetch_array($forumusers))
	{
		$userid = $loggedin['userid'];
		if (!$userid)
		{	// Guest
			$numberguest++;
			$inforum["$loggedin[inforum]"]++;
		}
		else if (empty($userinfos["$userid"]) OR ($userinfos["$userid"]['lastactivity'] < $loggedin['lastactivity']))
		{
			$userinfos["$userid"] = $loggedin;
		}
	}

	if (!$vbulletin->userinfo['userid'] AND $numberguest == 0)
	{
		$numberguest++;
	}

	foreach ($userinfos AS $userid => $loggedin)
	{
		$numberregistered++;
		if ($userid != $vbulletin->userinfo['userid'])
		{
			$inforum["$loggedin[inforum]"]++;
		}
		$loggedin['musername'] = fetch_musername($loggedin);

		($hook = vBulletinHook::fetch_hook('forumhome_loggedinuser')) ? eval($hook) : false;

		if (fetch_online_status($loggedin))
		{
			$numbervisible++;
			eval('$activeusers .= ", ' . fetch_template('forumhome_loggedinuser') . '";');
		}
	}

	// memory saving
	unset($userinfos, $loggedin);

	$activeusers = substr($activeusers, 2); // get rid of initial comma

	$db->free_result($forumusers);

	$totalonline = $numberregistered + $numberguest;
	$numberinvisible = $numberregistered - $numbervisible;

	// ### MAX LOGGEDIN USERS ################################
	if (intval($vbulletin->maxloggedin['maxonline']) <= $totalonline)
	{
		$vbulletin->maxloggedin['maxonline'] = $totalonline;
		$vbulletin->maxloggedin['maxonlinedate'] = TIMENOW;
		build_datastore('maxloggedin', serialize($vbulletin->maxloggedin));
	}

	$recordusers = vb_number_format($vbulletin->maxloggedin['maxonline']);;
	$recorddate = vbdate($vbulletin->options['dateformat'], $vbulletin->maxloggedin['maxonlinedate'], true);
	$recordtime = vbdate($vbulletin->options['timeformat'], $vbulletin->maxloggedin['maxonlinedate']);

	$show['loggedinusers'] = true;
}
else
{
	$show['loggedinusers'] = false;
}

// ### GET FORUMS & MODERATOR iCACHES ########################
cache_ordered_forums(1);
if ($vbulletin->options['showmoderatorcolumn'])
{
	cache_moderators();
}
else
{
	cache_moderators($vbulletin->userinfo['userid']);
}

// define max depth for forums display based on $vbulletin->options[forumhomedepth]
define('MAXFORUMDEPTH', $vbulletin->options['forumhomedepth']);

$forumbits = construct_forum_bit($forumid);

// ### BOARD STATISTICS #################################################

// get total threads & posts from the forumcache
$totalthreads = 0;
$totalposts = 0;
if (is_array($vbulletin->forumcache))
{
	foreach ($vbulletin->forumcache AS $forum)
	{
		$totalthreads += $forum['threadcount'];
		$totalposts += $forum['replycount'];
	}
}
$totalthreads = vb_number_format($totalthreads);
$totalposts = vb_number_format($totalposts);

// get total members and newest member from template
$numbermembers = vb_number_format($vbulletin->userstats['numbermembers']);
$newusername = $vbulletin->userstats['newusername'];
$newuserid = $vbulletin->userstats['newuserid'];
$activemembers = vb_number_format($vbulletin->userstats['activemembers']);
$show['activemembers'] = ($vbulletin->options['activememberdays'] > 0 AND ($vbulletin->options['activememberoptions'] & 2)) ? true : false;

// ### ALL DONE! SPIT OUT THE HTML AND LET'S GET OUTTA HERE... ###
($hook = vBulletinHook::fetch_hook('forumhome_complete')) ? eval($hook) : false;

eval('$navbar = "' . fetch_template('navbar') . '";');
eval('print_output("' . fetch_template('FORUMHOME') . '");');

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: index.php,v $ - $Revision: 1.170 $
|| ####################################################################
\*======================================================================*/
?>