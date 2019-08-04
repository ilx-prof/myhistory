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
define('CVS_REVISION', '$RCSfile: stats.php,v $ - $Revision: 1.54 $');

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('stats');
$specialtemplates = array('userstats', 'maxloggedin');

// ########################## REQUIRE BACK-END ############################
require_once('./global.php');

// ############################# LOG ACTION ###############################
log_admin_action();

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

print_cp_header($vbphrase['statistics']);

if (empty($_REQUEST['do']) OR $_REQUEST['do'] == 'index' OR $_REQUEST['do'] == 'top')
{
	print_form_header('stats', 'index');
	print_table_header($vbphrase['statistics']);
	print_label_row(construct_link_code($vbphrase['top_statistics'], 'stats.php?do=top'), '');
	print_label_row(construct_link_code($vbphrase['registration_statistics'], 'stats.php?do=reg'), '');
	print_label_row(construct_link_code($vbphrase['user_activity_statistics'], 'stats.php?do=activity'), '');
	print_label_row(construct_link_code($vbphrase['new_thread_statistics'], 'stats.php?do=thread'), '');
	print_label_row(construct_link_code($vbphrase['new_post_statistics'], 'stats.php?do=post'), '');
	print_table_footer();
}

// Find most popular things below
if ($_REQUEST['do'] == 'top')
{
	// max logged in users
	$recorddate = vbdate($vbulletin->options['dateformat'], $vbulletin->maxloggedin['maxonlinedate'], 1);
	$recordtime = vbdate($vbulletin->options['timeformat'], $vbulletin->maxloggedin['maxonlinedate']);

	// Most Posts
	$maxposts = $db->query_first("SELECT userid, username, posts FROM " . TABLE_PREFIX . "user ORDER BY posts DESC");

	// Largest Thread
	$maxthread = $db->query_first("SELECT * FROM " . TABLE_PREFIX . "thread ORDER BY replycount DESC");

	// Most Popular Thread
	$mostpopular = $db->query_first("SELECT * FROM " . TABLE_PREFIX . "thread ORDER BY views DESC");

	// Most Popular Forum
	$popularforum = $db->query_first("SELECT * FROM " . TABLE_PREFIX . "forum ORDER BY replycount DESC");

	print_form_header('');
	print_table_header($vbphrase['top']);

	print_label_row($vbphrase['newest_member'], construct_link_code($vbulletin->userstats['newusername'], "user.php?do=edit&u=" . $vbulletin->userstats['newuserid']));
	print_label_row($vbphrase['record_online_users'], "{$vbulletin->maxloggedin[maxonline]} ($recorddate $recordtime)");

	print_label_row($vbphrase['top_poster'], construct_link_code("$maxposts[username] - $maxposts[posts]", "user.php?do=edit&u=$maxposts[userid]"));
	print_label_row($vbphrase['most_replied_thread'], construct_link_code($maxthread['title'], "../showthread.php?t=$maxthread[threadid]", true));
	print_label_row($vbphrase['most_viewed_thread'], construct_link_code($mostpopular['title'], "../showthread.php?t=$mostpopular[threadid]", true));
	print_label_row($vbphrase['most_popular_forum'], construct_link_code($popularforum['title'], "../forumdisplay.php?f=$popularforum[forumid]", true));
	print_table_footer();

}

$vbulletin->input->clean_array_gpc('r', array(
	'start'     => TYPE_ARRAY_INT,
	'end'       => TYPE_ARRAY_INT,
	'scope'     => TYPE_STR,
	'sort'      => TYPE_STR,
	'nullvalue' => TYPE_BOOL,
));

// Default View Values
if (empty($vbulletin->GPC['start']))
{
	$vbulletin->GPC['start'] = TIMENOW - 3600 * 24 * 30;
}

if (empty($vbulletin->GPC['end']))
{
	$vbulletin->GPC['end'] = TIMENOW;
}

switch ($vbulletin->GPC['sort'])
{
	case 'date_asc':
		$orderby = 'dateline ASC';
		break;
	case 'date_desc':
		$orderby = 'dateline DESC';
		break;
	case 'total_asc':
		$orderby = 'total ASC';
		break;
	case 'total_desc':
		$orderby = 'total DESC';
		break;
	default:
		$orderby = 'dateline DESC';
}

switch ($_REQUEST['do'])
{

	case 'reg':
		$type = 'nuser';
		print_statistic_code($vbphrase['registration_statistics'], 'reg', $vbulletin->GPC['start'], $vbulletin->GPC['end'], $vbulletin->GPC['nullvalue'], $vbulletin->GPC['scope'], $vbulletin->GPC['sort']);
		break;
	case 'thread':
		$type = 'nthread';
		print_statistic_code($vbphrase['new_thread_statistics'], 'thread', $vbulletin->GPC['start'], $vbulletin->GPC['end'], $vbulletin->GPC['nullvalue'], $vbulletin->GPC['scope'], $vbulletin->GPC['sort']);
		break;
	case 'post':
		$type = 'npost';
		print_statistic_code($vbphrase['new_post_statistics'], 'post', $vbulletin->GPC['start'], $vbulletin->GPC['end'], $vbulletin->GPC['nullvalue'], $vbulletin->GPC['scope'], $vbulletin->GPC['sort']);
		break;
	case 'activity':
		$type = 'ausers';
		print_statistic_code($vbphrase['user_activity_statistics'], 'activity', $vbulletin->GPC['start'], $vbulletin->GPC['end'], $vbulletin->GPC['nullvalue'], $vbulletin->GPC['scope'], $vbulletin->GPC['sort']);
		break;
}

if (!empty($vbulletin->GPC['scope']))
{ // we have a submitted form
	$start_time = mktime(0, 0, 0, $vbulletin->GPC['start']['month'], $vbulletin->GPC['start']['day'], $vbulletin->GPC['start']['year']);
	$end_time = mktime(0, 0, 0, $vbulletin->GPC['end']['month'], $vbulletin->GPC['end']['day'], $vbulletin->GPC['end']['year']);
	if ($start_time >= $end_time)
	{
		print_stop_message('start_date_after_end');
	}

	if ($type == 'activity')
	{
		$vbulletin->GPC['scope'] = 'daily';
	}

	switch ($vbulletin->GPC['scope'])
	{
		case 'weekly':
			$sqlformat = '%U %Y';
			$phpformat = '# (! Y)';
			break;
		case 'monthly':
			$sqlformat = '%m %Y';
			$phpformat = '! Y';
			break;
		default:
			$sqlformat = '%w %U %m %Y';
			$phpformat = '! d, Y';
			break;
	}

	$statistics = $db->query_read("
		SELECT SUM($type) AS total,
		DATE_FORMAT(from_unixtime(dateline), '$sqlformat') AS formatted_date,
		MAX(dateline) AS dateline
		FROM " . TABLE_PREFIX . "stats
		WHERE dateline >= $start_time
			AND dateline <= $end_time
		GROUP BY formatted_date
		" . (empty($vbulletin->GPC['nullvalue']) ? " HAVING total > 0 " : "") . "
		ORDER BY $orderby
	");

	while ($stats = $db->fetch_array($statistics))
	{ // we will now have each days total of the type picked and we can sort through it
		$month = strtolower(date('F', $stats['dateline']));
		$dates[] = str_replace(' ', '&nbsp;', str_replace('#', $vbphrase['week'] . '&nbsp;' . strftime('%U', $stats['dateline']), str_replace('!', $vbphrase["$month"], date($phpformat, $stats['dateline']))));
		$results[] = $stats['total'];
	}

	if (!sizeof($results))
	{
		//print_array($results);
		print_stop_message('no_matches_found');
	}

	// we'll need a poll image
	$style = $db->query_first("
		SELECT stylevars FROM " . TABLE_PREFIX . "style
		WHERE styleid = " . $vbulletin->options['styleid'] . "
		LIMIT 1
	");
	$stylevars = unserialize($style['stylevars']);
	unset($style);

	print_form_header('');
	print_table_header($vbphrase['results'], 3);
	print_cells_row(array($vbphrase['date'], '&nbsp;', $vbphrase['total']), 1);
	$maxvalue = max($results);
	foreach ($results as $key => $value)
	{
		$i++;
		$bar = ($i % 6) + 1;
		if ($maxvalue == 0)
		{
			$percentage = 100;
		}
		else
		{
			$percentage = ceil(($value/$maxvalue) * 100);
		}
		print_statistic_result($dates["$key"], $bar, $value, $percentage);
	}
	print_table_footer(3);
}

function print_statistic_result($date, $bar, $value, $width)
{
	global $stylevars, $vbulletin;
	$bgclass = fetch_row_bgclass();

	if (preg_match('#^(https?://|/)#i', $stylevars['imgdir_poll']))
	{
		$imgpath = $stylevars['imgdir_poll'];
	}
	else
	{
		$imgpath = '../' . $stylevars['imgdir_poll'];
	}

	if ($vbulletin->userinfo['lang_options'] & $vbulletin->bf_misc_languageoptions['direction'])
	{
		// ltr
		$l_img = 'l';
		$r_img = 'r';
	}
	else
	{
		// rtl
		$l_img = 'r';
		$r_img = 'l';
	}

	echo '<tr><td width="0" class="' . $bgclass . '">' . $date . "</td>\n";
	echo '<td width="100%" class="' . $bgclass . '" nowrap="nowrap"><img src="' . $imgpath . '/bar' . "$bar-$l_img" . '.gif" height="10" /><img src="' . $imgpath . '/bar' . $bar . '.gif" width="' . $width . '%" height="10" /><img src="' . $imgpath . "/bar$bar-$r_img.gif\" height=\"10\" /></td>\n";
	echo '<td width="0%" class="' . $bgclass . '" nowrap="nowrap">' . $value . "</td></tr>\n";
}

function print_statistic_code($title, $name, $start, $end, $nullvalue = true, $scope = 'daily', $sort = 'date_desc')
{

	global $vbphrase;

	print_form_header('stats', $name);
	print_table_header($title);

	print_time_row($vbphrase['start_date'], 'start', $start, false);
	print_time_row($vbphrase['end_date'], 'end', $end, false);

	if ($name != 'activity')
	{
		print_select_row($vbphrase['scope'], 'scope', array('daily' => $vbphrase['daily'], 'weekly' => $vbphrase['weekly'], 'monthly' => $vbphrase['monthly']), $scope);
	}
	else
	{
		construct_hidden_code('scope', 'daily');
	}
	print_select_row($vbphrase['order_by'], 'sort', array(
		'date_asc'   => $vbphrase['date_ascending'],
		'date_desc'  => $vbphrase['date_descending'],
		'total_asc'  => $vbphrase['total_ascending'],
		'total_desc' => $vbphrase['total_descending'],
	), $sort);
	print_yes_no_row($vbphrase['include_empty_results'], 'nullvalue', $nullvalue);
	print_submit_row($vbphrase['go']);
}

print_cp_footer();

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: stats.php,v $ - $Revision: 1.54 $
|| ####################################################################
\*======================================================================*/
?>