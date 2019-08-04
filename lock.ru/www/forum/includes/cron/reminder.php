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

// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);
if (!is_object($vbulletin->db))
{
	exit;
}

// ########################## REQUIRE BACK-END ############################
require_once(DIR . '/includes/functions_calendar.php');

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

$beginday = TIMENOW - 86400;
$endday = TIMENOW + 345600; # 4 Days

$eventlist = array();
$eventcache = array();
$userinfo = array();

$events = $vbulletin->db->query_read("
	SELECT event.eventid, event.title, recurring, recuroption, dateline_from, dateline_to, IF (dateline_to = 0, 1, 0) AS singleday,
		dateline_from AS dateline_from_user, dateline_to AS dateline_to_user, utc, recurring, recuroption, event.calendarid,
		subscribeevent.userid, subscribeevent.lastreminder, subscribeevent.subscribeeventid, subscribeevent.reminder,
		user.email, user.languageid, user.usergroupid, user.username, user.timezoneoffset, IF(user.options & 128, 1, 0) AS dstonoff,
		calendar.title AS calendar_title
	FROM " . TABLE_PREFIX . "event AS event
	INNER JOIN " . TABLE_PREFIX . "subscribeevent AS subscribeevent ON (subscribeevent.eventid = event.eventid)
	INNER JOIN " . TABLE_PREFIX . "user AS user ON (user.userid = subscribeevent.userid)
	LEFT JOIN " . TABLE_PREFIX . "calendar AS calendar ON (event.calendarid = calendar.calendarid)
	WHERE ((dateline_to >= $beginday AND dateline_from < $endday) OR (dateline_to = 0 AND dateline_from >= $beginday AND dateline_from <= $endday ))
		AND event.visible = 1
");

$updateids = '';
while ($event = $vbulletin->db->fetch_array($events))
{
	if ($vbulletin->usergroupcache["$event[usergroupid]"]['genericoptions'] & $vbulletin->bf_ugp_genericoptions['isbannedgroup'])
	{
		continue;
	}

	$event['tzoffset'] = $event['timezoneoffset'];
	if ($event['dstonoff'])
	{
		// DST is on, add an hour
		$event['tzoffset']++;

		if (substr($event['tzoffset'], 0, 1) != '-')
		{
			// recorrect so that it has + sign, if necessary
			$event['tzoffset'] = '+' . $event['tzoffset'];
		}
	}	
	if ($event['tzoffset'] > 0 AND strpos($event['tzoffset'], '+') === false)
	{
		$event['tzoffset'] = '+' . $event['tzoffset'];
	}

	$offset = $event['utc'] ? $event['timezoneoffset'] : ($event['timezoneoffset'] ? $event['tzoffset'] : $event['timezoneoffset']);
	$event['dateline_from_user'] = $event['dateline_from'] + $offset * 3600;
	$event['dateline_to_user'] = $event['dateline_to'] + $offset * 3600;

	#### DEBUG INFO
	#	echo "<br>$event[title]<br>";
	#	echo "-GM Start: " . gmdate('Y-m-d h:i:s a', $event['dateline_from']);
	#	echo "<br />User Start: " . gmdate('Y-m-d h:i:s a', $event['dateline_from_user']);
	#### /DEBUG INFO

	if (empty($userinfo["$event[userid]"]))
	{
		$userinfo["$event[userid]"] = array(
			'username'   => $event['username'],
			'email'      => $event['email'],
			'languageid' => $event['languageid']
		);
	}

	# Set invalid reminder times to one hour
	if (empty($reminders["$event[reminder]"]))
	{
		$event['reminder'] = 3600;
	}

	# Add 15 mins to reminder time to start emails going out 15 mins before actual reminder time.
	# This gives a 15 min window around the desired event reminder time assuming reminder emails are sent every 30 mins.
	$event['reminder'] += 900;

	$update = false;
	if (!$event['recurring'])
	{
		if ($event['singleday'])
		{
			$time_until_event = $event['dateline_from'] - TIMENOW - $offset * 3600;
			// Single day events are not adjusted for user's timezone
		}
		else
		{
			$time_until_event = $event['dateline_from'] - TIMENOW;
		}

		if ($time_until_event <= $event['reminder'] AND $time_until_event >= 0 AND !$event['lastreminder'])
		{
			# Between 0 and X hours until event starts
			#we've never sent a reminder for this event so send one now

			$update = true;
		}
	}
	else
	{ // Recurring Event

		$dateline_from = $event['dateline_from'];

		# Advance start date up to the first occurence after now.
		while ($dateline_from <= TIMENOW)
		{
			$dateline_from += 86400;
		}

		$time_until_event = $dateline_from - TIMENOW ;

		#### DEBUG INFO
		#	echo "<br>";
		#	echo "Now: " . gmdate('Y-m-d h:i:s a', TIMENOW);
		#	echo "<br />Next: " . gmdate('Y-m-d h:i:s a', $dateline_from);
		#### /DEBUG INFO


		if ($time_until_event <= $event['reminder'] AND $time_until_event >= 0)
		{
			# Between 0 and x hours until event starts
			$temp = explode('-', gmdate('n-j-Y', $dateline_from));
			if (cache_event_info($event, $temp[0], $temp[1], $temp[2], true, false))
			{
				if ($event['lastreminder'] <= (TIMENOW - 82800))
				{
					#we've never sent a reminder for this event or we sent one more than 23 hours ago

					$update = true;
				}
			}
		}
	}

	#### DEBUG INFO
	#	echo "<br />Time until next event: " . ($time_until_event / 60 / 60) . " hours";
	#	echo "<hr>";
	#### /DEBUG INFO

	if ($update)
	{
		$updateids .= ",$event[subscribeeventid]";
		$eventlist["$event[userid]"]["$event[eventid]"] = ceil($time_until_event / 60 / 60);
		if (empty($eventcache["$event[eventid]"]))
		{
			$eventcache["$event[eventid]"] = array(
				'title'      => $event['title'],
				'calendarid' => $event['calendarid'],
				'calendar'   => $event['calendar_title'],
				'eventid'    => $event['eventid'],
			);
		}
	}
}

if (!empty($updateids))
{
	$vbulletin->db->query_write("
		UPDATE " . TABLE_PREFIX . "subscribeevent
		SET lastreminder = " . (TIMENOW) . "
		WHERE subscribeeventid IN (-1$updateids)
	");
}

vbmail_start();

$usernames = '';
$reminderbits = '';
foreach ($eventlist AS $userid => $event)
{
	$usernames .= iif($usernames, ', ');
	$usernames .= $userinfo["$userid"]['username'];
	$reminderbits = '';

	foreach($event AS $eventid => $hour)
	{
		$eventinfo =& $eventcache["$eventid"];
		eval(fetch_email_phrases('reminderbit', $userinfo["$userid"]['languageid']));
		$reminderbits .= $message;
	}

	$username = unhtmlspecialchars($userinfo["$userid"]['username']);
	eval(fetch_email_phrases('reminder', $userinfo["$userid"]['languageid']));
	vbmail($userinfo["$userid"]['email'], $subject, $message, true);

	#### DEBUG INFO
	#	echo "<pre>"; echo $subject; echo "</pre>"; echo "<pre>"; echo $message; echo "</pre><br />";
	#### /DEBUG INFO
}

vbmail_end();

if (!empty($usernames))
{
	log_cron_action('Reminder Email sent to: ' . $usernames, $nextitem);
}


/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: reminder.php,v $ - $Revision: 1.5 $
|| ####################################################################
\*======================================================================*/
?>