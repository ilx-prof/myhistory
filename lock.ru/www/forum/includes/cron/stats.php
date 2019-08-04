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
if (!is_object($vbulletin->db))
{
	exit;
}

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

// all these stats are for that day
$timestamp = TIMENOW - 3600 * 23;
// note: we only subtract 23 hours from the current time to account for Spring DST. Bug id 2673.

$month = date('n', $timestamp);
$day = date('j', $timestamp);
$year = date('Y', $timestamp);

$timestamp = mktime(0, 0, 0, $month, $day, $year);
// new users
$newusers = $vbulletin->db->query_first("SELECT COUNT(userid) AS total FROM " . TABLE_PREFIX . "user WHERE joindate >= " . $timestamp);
$newusers['total'] = intval($newusers['total']);

// new threads
$newthreads = $vbulletin->db->query_first("SELECT COUNT(threadid) AS total FROM " . TABLE_PREFIX . "thread WHERE dateline >= " . $timestamp);
$newthreads['total'] = intval($newthreads['total']);

// new posts
$newposts = $vbulletin->db->query_first("SELECT COUNT(threadid) AS total FROM " . TABLE_PREFIX . "post WHERE dateline >= " . $timestamp);
$newposts['total'] = intval($newposts['total']);

// active users
$activeusers = $vbulletin->db->query_first("SELECT COUNT(userid) AS total FROM " . TABLE_PREFIX . "user WHERE lastactivity >= " . $timestamp);
$activeusers['total'] = intval($activeusers['total']);

// also rebuild user stats
require_once(DIR . '/includes/functions_databuild.php');
build_user_statistics();

/*insert query*/
$vbulletin->db->query_write("
	INSERT IGNORE INTO " . TABLE_PREFIX . "stats
		(dateline, nuser, nthread, npost, ausers)
	VALUES
		($timestamp, $newusers[total], $newthreads[total], $newposts[total], $activeusers[total])
");

log_cron_action('Statistics Saved', $nextitem);

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: stats.php,v $ - $Revision: 1.18 $
|| ####################################################################
\*======================================================================*/
?>