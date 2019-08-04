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
define('THIS_SCRIPT', 'online');

// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array('wol');

// get special data templates from the datastore
$specialtemplates = array(
	'maxloggedin',
	'wol_spiders',
);

// pre-cache templates used by all actions
$globaltemplates = array(
	'forumdisplay_sortarrow',
	'forumhome_loggedinusers',
	'im_aim',
	'im_icq',
	'im_msn',
	'im_yahoo',
	'WHOSONLINE',
	'whosonlinebit'
);

// pre-cache templates used by specific actions
$actiontemplates = array();

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions_online.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

if (!$vbulletin->options['WOLenable'])
{
	eval(standard_error(fetch_error('whosonlinedisabled')));
}

if (!($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonline']))
{
	print_no_permission();
}

$datecut = TIMENOW - $vbulletin->options['cookietimeout'];
$wol_event = array();
$wol_pm = array();
$wol_calendar = array();
$wol_user = array();
$wol_forum = array();
$wol_link = array();
$wol_thread = array();
$wol_post = array();

// Variables reused in templates
$perpage = $vbulletin->input->clean_gpc('r', 'perpage', TYPE_UINT);
$pagenumber = $vbulletin->input->clean_gpc('r', 'pagenumber', TYPE_UINT);
$sortfield = $vbulletin->input->clean_gpc('r', 'sortfield', TYPE_NOHTML);
$sortorder = $vbulletin->input->clean_gpc('r', 'sortorder', TYPE_NOHTML);

$vbulletin->input->clean_array_gpc('r', array(
	'who'		=> TYPE_STR,
	'ua'		=> TYPE_BOOL,
));

($hook = vBulletinHook::fetch_hook('online_start')) ? eval($hook) : false;

// We can support multi page but we still have to grab every record and just throw away what we don't use.
// set defaults
$perpage = sanitize_perpage($perpage, 200, $vbulletin->options['maxthreads']);

if (!$pagenumber)
{
	$pagenumber = 1;
}

$limitlower = ($pagenumber - 1) * $perpage + 1;
$limitupper = $pagenumber * $perpage;

if ($sortorder != 'desc')
{
	$sortorder = 'asc';
	$oppositesort = 'desc';
}
else
{ // $sortorder = 'desc'
	$sortorder = 'desc';
	$oppositesort = 'asc';
}

switch ($sortfield)
{
	case 'location':
		$sqlsort = 'session.location';
		break;
	case 'time':
		$sqlsort = 'session.lastactivity';
		break;
	case 'host':
		$sqlsort = 'session.host';
		break;
	default:
		$sqlsort = 'user.username';
		$sortfield = 'username';
}

$allonly = $vbphrase['all'];
$membersonly = $vbphrase['members'];
$spidersonly = $vbphrase['spiders'];
$guestsonly = $vbphrase['guests'];
$whoselected = array();
$uaselected = array();

switch ($vbulletin->GPC['who'])
{
	case 'members':
		$showmembers = true;
		$whoselected[1] = 'selected="selected"';
		break;
	case 'guests':
		$showguests = true;
		$whoselected[2] = 'selected="selected"';
		break;
	case 'spiders':
		$showspiders = true;
		$whoselected[3] = 'selected="selected"';
		break;
	default:
		$showmembers = true;
		$showguests = true;
		$showspiders = true;
		$vbulletin->GPC['who'] = '';
		$whoselected[0] = 'selected="selected"';
}

if ($vbulletin->GPC['ua'])
{
	$uaselected[1] = 'selected="selected"';
}
else
{
	$uaselected[0] = 'selected="selected"';
}

$reloadurl = ($perpage != 20 ? "pp=$perpage" : '') .
	($pagenumber != 1 ? "&amp;page=$pagenumber" : '') .
	($sortfield != 'username' ? "&amp;sort=$sortfield" : '') .
	($sortorder == 'desc' ? '&amp;order=desc' : '') .
	($vbulletin->GPC['who'] != '' ? '&amp;who=' . $vbulletin->GPC['who'] : '') .
	($vbulletin->GPC['ua'] ? '&amp;ua=1' : '');

if (!empty($reloadurl))
{
	$reloadurl = 'online.php?' . $vbulletin->session->vars['sessionurl'] . $reloadurl;
}
else
{
	$reloadurl = 'online.php' . $vbulletin->session->vars['sessionurl_q'];
}

$sorturl = 'online.php?' . $vbulletin->session->vars['sessionurl'] .
	($vbulletin->GPC['who'] != '' ? '&amp;who=' . $vbulletin->GPC['who'] : '') . ($vbulletin->GPC['ua'] ? '&amp;ua=1' : '');

eval("\$sortarrow[$sortfield] = \"" . fetch_template('forumdisplay_sortarrow') . '";');

$allusers = $db->query_read("
	SELECT user.username, session.useragent, session.location, session.lastactivity, user.userid, user.options, session.host, session.badlocation, session.incalendar, user.aim, user.icq, user.msn, user.yahoo,
	IF(displaygroupid=0, user.usergroupid, displaygroupid) AS displaygroupid
	FROM " . TABLE_PREFIX . "session AS session
	". iif($vbulletin->options['WOLguests'], " LEFT JOIN " . TABLE_PREFIX . "user AS user USING (userid) ", ", " . TABLE_PREFIX . "user AS user") ."
	WHERE session.lastactivity > $datecut
		". iif(!$vbulletin->options['WOLguests'], " AND session.userid = user.userid", "") ."
	ORDER BY $sqlsort $sortorder
");

$moderators = $db->query_read("SELECT DISTINCT userid FROM " . TABLE_PREFIX . "moderator");
while ($mods = $db->fetch_array($moderators))
{
	$mod["{$mods[userid]}"] = 1;
}

$count = 0;
$userinfo = array();
$guests = array();

// get buddylist
$buddy = array();
if (trim($vbulletin->userinfo['buddylist']))
{
	$buddylist = preg_split('/( )+/', trim($vbulletin->userinfo['buddylist']), -1, PREG_SPLIT_NO_EMPTY);
	foreach ($buddylist AS $buddyuserid)
	{
		$buddy["$buddyuserid"] = 1;
	}
}

// Refresh cache if the XML has changed
if ($vbulletin->options['enablespiders'] AND $lastupdate = @filemtime(DIR . '/includes/xml/spiders_vbulletin.xml') AND $lastupdate != $vbulletin->wol_spiders['lu'])
{
	require_once(DIR . '/includes/class_xml.php');
	$xmlobj = new XMLparser(false, DIR . '/includes/xml/spiders_vbulletin.xml');
	$spiderdata = $xmlobj->parse();
	$spiders = array();

	if (is_array($spiderdata['spider']))
	{
		foreach ($spiderdata['spider'] AS $spiderling)
		{
			$addresses = array();
			$identlower = strtolower($spiderling['ident']);
			$spiders['agents']["$identlower"]['name'] = $spiderling['name'];
			$spiders['agents']["$identlower"]['type'] = $spiderling['type'];
			if (is_array($spiderling['addresses']['address']) AND !empty($spiderling['addresses']['address']))
			{
				if (empty($spiderling['addresses']['address'][0]))
				{
					$addresses[0] = $spiderling['addresses']['address'];
				}
				else
				{
					$addresses = $spiderling['addresses']['address'];
				}


				foreach ($addresses AS $key => $address)
				{
					if (in_array($address['type'], array('range', 'single', 'CIDR')))
					{
						$address['type'] = strtolower($address['type']);

						switch($address['type'])
						{
							case 'single':
								$ip2long = ip2long($address['value']);
								if ($ip2long != -1 AND $ip2long !== false)
								{
									$spiders['agents']["$identlower"]['lookup'][] = array(
										'startip' => $ip2long,
									);
								}
								break;
							case 'range':
								$ips = explode('-', $address['value']);
								$startip = ip2long(trim($ips[0]));
								$endip = ip2long(trim($ips[1]));
								if ($startip != -1 AND $startip !== false AND $endip != -1 AND $endip !== false AND $startip <= $endip)
								{
									$spiders['agents']["$identlower"]['lookup'][] = array(
										'startip' => $startip,
										'endip'   => $endip,
									);
								}
								break;
							case 'cidr':
								$ipsplit = explode('/', $address['value']);

								$startip = ip2long($ipsplit[0]);
								$mask = $ipsplit[1];

								if ($startip != -1 AND $startip !== false AND $mask <= 31 AND $mask >= 0)
								{
									$hostbits = 32 - $mask;
									$hosts = pow(2, $hostbits) - 1; // Number of specified IPs

									$endip = $startip + $hosts;

									$spiders['agents']["$identlower"]['lookup'][] = array(
										'startip' => $startip,
										'endip'   => $endip,
									);
								}
								break;
						}
					}
				}

			}
			$spiders['spiderstring'] .= ($spiders['spiderstring'] ? '|' : '') . preg_quote($spiderling['ident'], '#');
		}

		$spiders['lu'] = $lastupdate;


		// Write out spider cache
		require_once(DIR . '/includes/functions_misc.php');
		build_datastore('wol_spiders', serialize($spiders));
		$vbulletin->wol_spiders =& $spiders;
	}
	unset($spiderdata, $xmlobj);
}

require_once(DIR . '/includes/class_postbit.php');
while ($users = $db->fetch_array($allusers))
{
	if ($users['userid'])
	{ // Reg'd Member
		if (!$showmembers)
		{
			continue;
		}

		$users = array_merge($users, convert_bits_to_array($users['options'] , $vbulletin->bf_misc_useroptions));

		$key = $users['userid'];
		if ($key == $vbulletin->userinfo['userid'])
		{ // in case this is the first view for the user, fake it that show up to themself
			$foundviewer = true;
		}
		if (empty($userinfo["$key"]['lastactivity']) OR ($userinfo["$key"]['lastactivity'] < $users['lastactivity']))
		{
			unset($userinfo["$key"]); // need this to sort by lastactivity
			$userinfo["$key"] = $users;
			$userinfo["$key"]['musername'] = fetch_musername($users);
			$userinfo["$key"]['useragent'] = htmlspecialchars_uni($users['useragent']);
			construct_im_icons($userinfo["$key"]);
			if ($users['invisible'])
			{
				if (($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canseehidden']) OR $key == $vbulletin->userinfo['userid'])
				{
					$userinfo["$key"]['hidden'] = '*';
					$userinfo["$key"]['invisible'] = 0;
				}
			}
			if ($vbulletin->options['WOLresolve'] AND ($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlineip']))
			{
				$userinfo["$key"]['host'] = @gethostbyaddr($users['host']);
			}
			$userinfo["$key"]['buddy'] = $buddy["$key"];
		}
	}
	else
	{ // Guest or Spider..
		$spider = '';

		if ($vbulletin->options['enablespiders'] AND !empty($vbulletin->wol_spiders))
		{
			if (preg_match('#(' . $vbulletin->wol_spiders['spiderstring'] . ')#si', $users['useragent'], $agent))
			{
				$agent = strtolower($agent[1]);

				// Check ip address
				if (!empty($vbulletin->wol_spiders['agents']["$agent"]['lookup']))
				{
					$ourip = ip2long($users['host']);
					foreach ($vbulletin->wol_spiders['agents']["$agent"]['lookup'] AS $key => $ip)
					{
						if ($ip['startip'] AND $ip['endip']) // Range or CIDR
						{
							if ($ourip >= $ip['startip'] AND $ourip <= $ip['endip'])
							{
								$spider = $vbulletin->wol_spiders['agents']["$agent"];
								break;
							}
						}
						else if ($ip['startip'] == $ourip) // Single IP
						{
							$spider = $vbulletin->wol_spiders['agents']["$agent"];
							break;
						}
					}
				}
				else
				{
					$spider = $vbulletin->wol_spiders['agents']["$agent"];
				}
			}
		}

		if ($spider)
		{
			if (!$showspiders)
			{
				continue;
			}
			$guests["$count"] = $users;
			$guests["$count"]['spider'] = $spider['name'];
			$guests["$count"]['spidertype'] = $spider['type'];
		}
		else
		{
			if (!$showguests)
			{
				continue;
			}
			$guests["$count"] = $users;
		}

		$guests["$count"]['username'] = $vbphrase['guest'];
		$guests["$count"]['invisible'] = 0;
		$guests["$count"]['displaygroupid'] = 1;
		$guests["$count"]['musername'] = fetch_musername($guests["$count"]);
		if ($vbulletin->options['WOLresolve'] AND ($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlineip']))
		{
			$guests["$count"]['host'] = @gethostbyaddr($users['host']);
		}
		$guests["$count"]['count'] = $count + 1;
		$guests["$count"]['useragent'] = htmlspecialchars_uni($users['useragent']);
		$count++;

		($hook = vBulletinHook::fetch_hook('online_user')) ? eval($hook) : false;
	}
}

if (!$foundviewer AND $vbulletin->userinfo['userid'] AND ($vbulletin->GPC['who'] == '' OR $vbulletin->GPC['who'] == 'members'))
{ // Viewing user did not show up so fake him
	construct_im_icons($vbulletin->userinfo);
	$userinfo["{$vbulletin->userinfo['userid']}"] = $vbulletin->userinfo;
	$userinfo["{$vbulletin->userinfo['userid']}"]['location'] = '/online.php';
	$userinfo["{$vbulletin->userinfo['userid']}"]['host'] = IPADDRESS;
	$userinfo["{$vbulletin->userinfo['userid']}"]['lastactivity'] = TIMENOW;
	$userinfo["{$vbulletin->userinfo['userid']}"]['joingroupid'] = iif($vbulletin->userinfo['displaygroupid'] == 0, $vbulletin->userinfo['usergroupid'], $vbulletin->userinfo['displaygroupid']);
	$userinfo["{$vbulletin->userinfo['userid']}"]['musername'] = fetch_musername($userinfo["{$vbulletin->userinfo['userid']}"], 'joingroupid');
	$userinfo["{$vbulletin->userinfo['userid']}"]['hidden'] = iif($vbulletin->userinfo['invisible'], '*');
	$userinfo["{$vbulletin->userinfo['userid']}"]['invisible'] = 0;

	if ($vbulletin->options['WOLresolve'] AND ($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlineip']))
	{
		$userinfo["{$vbulletin->userinfo['userid']}"]['host'] = @gethostbyaddr($userinfo["{$vbulletin->userinfo['userid']}"]['host']);
	}
}

$show['ip'] = iif($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlineip'], true, false);
$show['useragent'] = iif($vbulletin->GPC['ua'], true, false);
$show['hidden'] = iif($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canseehidden'], true, false);
$show['badlocation'] = iif($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinebad'], true, false);

if (is_array($userinfo))
{
	foreach ($userinfo AS $key => $val)
	{
		if (!$val['invisible'])
		{
			$userinfo["$key"] = process_online_location($val, 1);
		}
	}
}

if (is_array($guests))
{
	foreach ($guests AS $key => $val)
	{
		$guests["$key"] = process_online_location($val, 1);
	}
}

convert_ids_to_titles();

$onlinecolspan = 4;

$bgclass = 'alt1';

if ($vbulletin->options['enablepms'])
{
	$onlinecolspan++;
}

if ($vbulletin->options['displayemails'] OR $vbulletin->options['enablepms'])
{
	$onlinecolspan++;
	exec_switch_bg();
	$contactclass = $bgclass;
}

if ($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlineip'])
{
	$onlinecolspan++;
	exec_switch_bg();
	$ipclass = $bgclass;
}

if ($vbulletin->options['showimicons'])
{
	$onlinecolspan += 4;
	exec_switch_bg();
	exec_switch_bg();
	exec_switch_bg();
	exec_switch_bg();
}

$numbervisible = 0;
$numberinvisible = 0;
if (is_array($userinfo))
{
	foreach ($userinfo AS $key => $val)
	{
		if (!$val['invisible'])
		{
			$onlinebits .= construct_online_bit($val, 1);
			$numbervisible++;
		}
		else
		{
			$numberinvisible++;
		}
	}
}

$numberguests = 0;
if (is_array($guests))
{
	foreach ($guests AS $key => $val)
	{
		$numberguests++;
		$onlinebits .= construct_online_bit($val, 1);
	}
}

$totalonline = $numbervisible + $numberguests;

// ### MAX LOGGEDIN USERS ################################
if (intval($vbulletin->maxloggedin['maxonline']) <= $totalonline)
{
	$vbulletin->maxloggedin['maxonline'] = $totalonline;
	$vbulletin->maxloggedin['maxonlinedate'] = TIMENOW;
	build_datastore('maxloggedin', serialize($vbulletin->maxloggedin));
}
$recordusers = $vbulletin->maxloggedin['maxonline'];
$recorddate = vbdate($vbulletin->options['dateformat'], $vbulletin->maxloggedin['maxonlinedate'], true);
$recordtime = vbdate($vbulletin->options['timeformat'], $vbulletin->maxloggedin['maxonlinedate']);

$currenttime = vbdate($vbulletin->options['timeformat']);
$metarefresh = '';

if ($vbulletin->options['WOLrefresh'])
{
	if (is_browser('mozilla'))
	{
		$metarefresh = "\n<script type=\"text/javascript\">\n";
		$metarefresh .= "myvar = \"\";\ntimeout = " . ($vbulletin->options['WOLrefresh'] * 10) . ";
function exec_refresh()
{
	timerID = setTimeout(\"exec_refresh();\", 100);
	if (timeout > 0)
	{ timeout -= 1; }
	else { clearTimeout(timerID); window.location=\"online.php?" . $vbulletin->session->vars['sessionurl_js'] . "order=$sortorder&sort=$sortfield&pp=$perpage&page=$pagenumber" . iif($vbulletin->GPC['who'], '&who=' . $vbulletin->GPC['who']) . iif($vbulletin->GPC['ua'], '&ua=1') . "\"; }
}
exec_refresh();";

		$metarefresh .= "\n</script>\n";
	}
	else
	{
		$metarefresh = "<meta http-equiv=\"refresh\" content=\"" . $vbulletin->options['WOLrefresh'] . "; url=online.php?" . $vbulletin->session->vars['sessionurl'] . "order=$sortorder&amp;sort=$sortfield&amp;pp=$perpage&amp;page=$pagenumber" . iif($vbulletin->GPC['who'], '&amp;who=' . $vbulletin->GPC['who']) . iif($vbulletin->GPC['ua'], '&amp;ua=1') . "\" /> ";
	}
}

$frmjmpsel['wol'] = ' selected="selected" class="fjsel"';
construct_forum_jump();

$pagenav = construct_page_nav($pagenumber, $perpage, $totalonline, 'online.php?' . $vbulletin->session->vars['sessionurl'] . "sort=$sortfield&amp;order=$sortorder&amp;pp=$perpage" . iif($vbulletin->GPC['who'], '&amp;who=' . $vbulletin->GPC['who']) . iif($vbulletin->GPC['ua'], '&amp;ua=1'));
$numbervisible += $numberinvisible;

$colspan = 2;
$colspan = iif($show['ip'], $colspan + 1, $colspan);
$colspan = iif($vbulletin->options['showimicons'], $colspan + 1, $colspan);

($hook = vBulletinHook::fetch_hook('online_complete')) ? eval($hook) : false;

$navbits = construct_navbits(array('' => $vbphrase['whos_online']));
eval('$navbar = "' . fetch_template('navbar') . '";');
eval('print_output("' . fetch_template('WHOSONLINE') . '");');

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: online.php,v $ - $Revision: 1.191 $
|| ####################################################################
\*======================================================================*/
?>