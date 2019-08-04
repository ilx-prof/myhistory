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

// identify where we are
define('VB_AREA', 'Forum');

define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));

// #############################################################################
// Start initialisation
require_once(CWD . '/includes/init.php');

$vbulletin->input->clean_array_gpc('r', array(
	'referrerid' => TYPE_UINT,
	'postid'     => TYPE_UINT,
	'threadid'   => TYPE_UINT,
	'forumid'    => TYPE_UINT,
	'pollid'     => TYPE_UINT,
	'a'          => TYPE_STR,
	'mode'       => TYPE_STR,		// Threaded mode // may conflict with other 'mode' variables?
	'nojs'       => TYPE_BOOL
));

// #############################################################################
// turn off popups if they are not available to this browser
if ($vbulletin->options['usepopups'])
{
	if ((is_browser('ie', 5) AND !is_browser('mac')) OR is_browser('mozilla') OR is_browser('firebird') OR is_browser('opera', 7) OR is_browser('webkit') OR is_browser('konqueror', 3.2))
	{
		// use popups
	}
	else
	{
		// don't use popups
		$vbulletin->options['usepopups'] = 0;
	}
}

// #############################################################################
// set a variable used by the spacer templates to detect IE versions less than 6
$show['old_explorer'] = (is_browser('ie') AND !is_browser('ie', 6));

// #############################################################################
// read the list of collapsed menus from the 'vbulletin_collapse' cookie
$vbcollapse = array();
if (!empty($vbulletin->GPC['vbulletin_collapse']))
{
	$val = preg_split('#\n#', $vbulletin->GPC['vbulletin_collapse'], -1, PREG_SPLIT_NO_EMPTY);
	foreach ($val AS $key)
	{
		$vbcollapse["collapseobj_$key"] = 'display:none;';
		$vbcollapse["collapseimg_$key"] = '_collapsed';
		$vbcollapse["collapsecel_$key"] = '_collapsed';
	}
	unset($val);
}

// #############################################################################
// start server too busy
$servertoobusy = false;
if ($vbulletin->options['loadlimit'] > 0 AND PHP_OS == 'Linux' AND @file_exists('/proc/loadavg') AND $filestuff = @file_get_contents('/proc/loadavg'))
{
	$loadavg = explode(' ', $filestuff);
	if (trim($loadavg[0]) > $vbulletin->options['loadlimit'])
	{
		$servertoobusy = true;
	}
}

// #############################################################################
// do headers
exec_headers();

// #############################################################################
// set the referrer cookie if URI contains a referrerid
if ($vbulletin->GPC['referrerid'] AND !$vbulletin->GPC[COOKIE_PREFIX . 'referrerid'] AND !$vbulletin->userinfo['userid'] AND $vbulletin->options['usereferrer'])
{
	if ($referrerid = verify_id('user', $vbulletin->GPC['referrerid'], 0))
	{
		vbsetcookie('referrerid', $referrerid);
	}
}

// #############################################################################
// Get date / time info
// override date/time settings if specified
fetch_options_overrides($vbulletin->userinfo);
fetch_time_data();

// global $vbulletin->userinfo setup -- this has to happen after fetch_options_overrides
if ($vbulletin->userinfo['lastvisit'])
{
	$vbulletin->userinfo['lastvisitdate'] = vbdate($vbulletin->options['dateformat'] . ' ' . $vbulletin->options['timeformat'], $vbulletin->userinfo['lastvisit']);
}
else
{
	$vbulletin->userinfo['lastvisitdate'] = -1;
}

// get some useful info
$templateversion =& $vbulletin->options['templateversion'];

// #############################################################################
// initialize $vbphrase and set language constants
$vbphrase = init_language();

// set a default username
if ($vbulletin->userinfo['username'] == '')
{
	$vbulletin->userinfo['username'] = $vbphrase['unregistered'];
}

// #############################################################################
// CACHE PERMISSIONS AND GRAB $permissions
// get the combined permissions for the current user
// this also creates the $fpermscache containing the user's forum permissions

$permissions = cache_permissions($vbulletin->userinfo);
$vbulletin->userinfo['permissions'] =& $permissions;

// #############################################################################

// figure out the chosen style settings
$codestyleid = 0;

// Init post/thread/forum values
$postinfo = array();
$threadinfo = array();
$foruminfo = array();

// automatically query $postinfo, $threadinfo & $foruminfo if $threadid exists
if ($vbulletin->GPC['postid'] AND $postinfo = verify_id('post', $vbulletin->GPC['postid'], 0, 1))
{
	$postid =& $postinfo['postid'];
	$vbulletin->GPC['threadid'] =& $postinfo['threadid'];

}

// automatically query $threadinfo & $foruminfo if $threadid exists
if ($vbulletin->GPC['threadid'] AND $threadinfo = verify_id('thread', $vbulletin->GPC['threadid'], 0, 1))
{
	$threadid =& $threadinfo['threadid'];
	$vbulletin->GPC['forumid'] = $forumid = $threadinfo['forumid'];
	if ($forumid)
	{
		$foruminfo = fetch_foruminfo($threadinfo['forumid']);
		if (($foruminfo['styleoverride'] == 1 OR $vbulletin->userinfo['styleid'] == 0) AND !defined('BYPASS_STYLE_OVERRIDE'))
		{
			$codestyleid = $foruminfo['styleid'];
		}
	}

	if ($vbulletin->GPC['pollid'])
	{
		$pollinfo = verify_id('poll', $vbulletin->GPC['pollid'], 0, 1);
		$pollid =& $pollinfo['pollid'];
	}
}
// automatically query $foruminfo if $forumid exists
else if ($vbulletin->GPC['forumid'])
{
	$foruminfo = verify_id('forum', $vbulletin->GPC['forumid'], 0, 1);
	$forumid =& $foruminfo['forumid'];

	if (($foruminfo['styleoverride'] == 1 OR $vbulletin->userinfo['styleid'] == 0) AND !defined('BYPASS_STYLE_OVERRIDE'))
	{
		$codestyleid =& $foruminfo['styleid'];
	}
}
// automatically query forum for style info if $pollid exists
else if ($vbulletin->GPC['pollid'] AND THIS_SCRIPT == 'poll')
{
	$pollinfo = verify_id('poll', $vbulletin->GPC['pollid'], 0, 1);
	$pollid =& $pollinfo['pollid'];

	$threadinfo = $db->query_first("
		SELECT thread.*
		FROM " . TABLE_PREFIX . "thread AS thread
		WHERE thread.pollid = " . $vbulletin->GPC['pollid'] . "
			AND open <> 10
	");

	$threadid =& $threadinfo['threadid'];

	$foruminfo = fetch_foruminfo($threadinfo['forumid']);
	$forumid =& $foruminfo['forumid'];

	if (($foruminfo['styleoverride'] == 1 OR $vbulletin->userinfo['styleid'] == 0) AND !defined('BYPASS_STYLE_OVERRIDE'))
	{
		$codestyleid = $foruminfo['styleid'];
	}
}

// #############################################################################
// ######################## START TEMPLATES & STYLES ###########################
// #############################################################################

$userselect = false;

// is style in the forum/thread set?
if ($codestyleid)
{
	// style specified by forum
	$styleid = $codestyleid;
	$vbulletin->userinfo['styleid'] = $styleid;
	$userselect = true;
}
else if ($vbulletin->userinfo['styleid'] > 0 AND ($vbulletin->options['allowchangestyles'] == 1 OR ($vbulletin->userinfo['permissions']['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel'])))
{
	// style specified in user profile
	$styleid = $vbulletin->userinfo['styleid'];
}
else
{
	// no style specified - use default
	$styleid = $vbulletin->options['styleid'];
	$vbulletin->userinfo['styleid'] = $styleid;
}

// #############################################################################
// if user can control panel, allow selection of any style (for testing purposes)
// otherwise only allow styles that are user-selectable
$styleid = intval($styleid);

($hook = vBulletinHook::fetch_hook('style_fetch')) ? eval($hook) : false;

$style = $db->query_first("
	SELECT *
	FROM " . TABLE_PREFIX . "style
	WHERE (styleid = $styleid" . iif(!($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel']) AND !$userselect, ' AND userselect = 1') . ")
		OR styleid = " . $vbulletin->options['styleid'] . "
	ORDER BY styleid " . iif($styleid > $vbulletin->options['styleid'], 'DESC', 'ASC') . "
	LIMIT 1
");
define('STYLEID', $style['styleid']);

// #############################################################################
//prepare default templates/phrases

$_templatedo = iif(empty($_REQUEST['do']), 'none', $_REQUEST['do']);

if (is_array($actionphrases["$_templatedo"]))
{
	$phrasegroups = array_merge($phrasegroups, $actionphrases["$_templatedo"]);
}

if (!is_array($globaltemplates))
{
	$globaltemplates = array();
}

if (is_array($actiontemplates["$_templatedo"]))
{
	$globaltemplates = array_merge($globaltemplates, $actiontemplates["$_templatedo"]);
}

// templates to be included in every single page...
$globaltemplates = array_merge($globaltemplates, array(
	// the really important ones
	'header',
	'footer',
	'headinclude',
	// new private message script
	'pm_popup_script',
	// navbar construction
	'navbar',
	'navbar_link',
	// forumjump and go button
	'forumjump',
	'gobutton',
	'option',
	// multi-page navigation
	'pagenav',
	'pagenav_curpage',
	'pagenav_pagelink',
	'pagenav_pagelinkrel',
	'threadbit_pagelink',
	// misc useful
	'spacer_open',
	'spacer_close',
	'STANDARD_ERROR',
	'STANDARD_REDIRECT'
	//'board_inactive_warning'
));

// if we are in a message editing page then get the editor templates
if (defined('GET_EDIT_TEMPLATES'))
{
	$_get_edit_templates = explode(',', GET_EDIT_TEMPLATES);
	if (GET_EDIT_TEMPLATES === true OR in_array($_REQUEST['do'], $_get_edit_templates))
	{
		$globaltemplates = array_merge($globaltemplates, array(
			// message stuff 3.5
			'editor_toolbar_on',
			'editor_smilie',
			// message area for wysiwyg / non wysiwyg
			'editor_clientscript',
			'editor_toolbar_off',
			// javascript menu builders
			'editor_jsoptions_font',
			'editor_jsoptions_size',
			// smiliebox templates
			'editor_smiliebox',
			'editor_smiliebox_category',
			'editor_smiliebox_row',
			'editor_smiliebox_straggler',
			// needed for thread preview
			'bbcode_code',
			'bbcode_html',
			'bbcode_php',
			'bbcode_quote',
			// misc often used
			'newpost_threadmanage',
			'newpost_disablesmiliesoption',
			'newpost_preview',
			'newpost_quote',
			'posticonbit',
			'posticons',
			'newpost_usernamecode',
			'newpost_errormessage',
			'forumrules'
		));
	}
}

($hook = vBulletinHook::fetch_hook('cache_templates')) ? eval($hook) : false;

// now get all the templates we have specified
cache_templates($globaltemplates, $style['templatelist']);
unset($globaltemplates, $actiontemplates, $_get_edit_templates, $_templatedo);

// #############################################################################
// get style variables
$stylevar = fetch_stylevars($style, $vbulletin->userinfo);

// #############################################################################
// parse PHP include
if (!is_demo_mode())
{
	@ob_start();
	($hook = vBulletinHook::fetch_hook('global_start')) ? eval($hook) : false;
	$phpinclude_output = @ob_get_contents();
	@ob_end_clean();
}

// #############################################################################
// get new private message popup
$shownewpm = false;
if ($vbulletin->userinfo['pmpopup'] == 2 AND $vbulletin->options['checknewpm'] AND $vbulletin->userinfo['userid'] AND !defined('NOPMPOPUP'))
{
	$userdm =& datamanager_init('User', $vbulletin, ERRTYPE_SILENT);
	$userdm->set_existing($vbulletin->userinfo);
	$userdm->set('pmpopup', 1);
	$userdm->save(true, 'pmpopup');	// 'pmpopup' tells db_update to issue a shutdownquery of the same name
	unset($userdm);

	if (THIS_SCRIPT != 'private' AND THIS_SCRIPT != 'login')
	{
		$newpm = $db->query_first("
			SELECT pm.pmid, title, fromusername
			FROM " . TABLE_PREFIX . "pmtext AS pmtext
			LEFT JOIN " . TABLE_PREFIX . "pm AS pm USING(pmtextid)
			WHERE pm.userid = " . $vbulletin->userinfo['userid'] . "
			ORDER BY dateline DESC
			LIMIT 1
		");
		$newpm['username'] = addslashes_js(unhtmlspecialchars($newpm['fromusername'], true), '"');
		$newpm['title'] = addslashes_js(unhtmlspecialchars($newpm['title'], true), '"');
		$shownewpm = true;
	}
}

// #############################################################################
// set up the vars for the private message area of the navbar
$pmbox = array();
$pmbox['lastvisitdate'] = vbdate($vbulletin->options['dateformat'], $vbulletin->userinfo['lastvisit'], 1);
$pmbox['lastvisittime'] = vbdate($vbulletin->options['timeformat'], $vbulletin->userinfo['lastvisit']);
$pmunread_html = iif($vbulletin->userinfo['pmunread'], '<strong>' . $vbulletin->userinfo['pmunread'] . '</strong>', $vbulletin->userinfo['pmunread']);
$vbphrase['unread_x_nav_compiled'] = construct_phrase($vbphrase['unread_x_nav'], $pmunread_html);
$vbphrase['total_x_nav_compiled'] = construct_phrase($vbphrase['total_x_nav'], $vbulletin->userinfo['pmtotal']);

// #############################################################################
// Generate Language Chooser Dropdown

$languagecount = 0;
$languagechooserbits = construct_language_options('--', true);
$show['languagechooser'] = ($languagecount > 1 ? true : false);
unset($languagecount);

// #############################################################################
// Generate Style Chooser Dropdown
if ($vbulletin->options['allowchangestyles'])
{
	$stylecount = 0;
	$quickchooserbits = construct_style_options(-1, '--', true, true);
	$show['quickchooser'] = ($stylecount > 1 ? true : false);
	unset($stylecount);
}
else
{
	$show['quickchooser'] = false;
}

// #############################################################################
// do cron stuff - goes into footer
if ($vbulletin->cron <= TIMENOW)
{
	$cronimage = '<img src="' . $vbulletin->options['bburl'] . '/cron.php?' . $vbulletin->session->vars['sessionurl'] . '&amp;rand=' .  vbrand(1, 1000000) . '" alt="" width="1" height="1" border="0" />';
}
else
{
	$cronimage = '';
}

$show['admincplink'] = iif($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel'], true, false);
// This generates an extra query for non-admins/supermods on many pages so we have chosen to only display it to supermods & admins
// $show['modcplink'] = iif(can_moderate(), true, false);
$show['modcplink'] = iif ($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel'] OR $permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['ismoderator'], true, false);

$show['registerbutton'] = iif(!$show['search_engine'] AND $vbulletin->options['allowregistration'] AND (!$vbulletin->userinfo['userid'] OR $vbulletin->options['allowmultiregs']), true, false);
$show['searchbuttons'] = iif(!$show['search_engine'] AND $permissions['forumpermissions'] & $vbulletin->bf_ugp_forumpermissions['cansearch'] AND $vbulletin->options['enablesearches'], true, false);

if ($vbulletin->userinfo['userid'])
{
	$show['guest'] = false;
	$show['member'] = true;
}
else
{
	$show['guest'] = true;
	$show['member'] = false;
}

$show['detailedtime'] = iif($vbulletin->options['yestoday'] == 2, true, false);

$show['popups'] = iif(!$show['search_engine'] AND $vbulletin->options['usepopups'] AND !$vbulletin->GPC['nojs'], true, false);
if ($show['popups'])
{
	// this isn't what $show is for, but it's a variable that's available in many places
	$show['nojs_link'] = $vbulletin->scriptpath . (strpos($vbulletin->scriptpath, '?') ? '&amp;' : '?') . 'nojs=1';
}
else
{
	$show['nojs_link'] = '';
}

$show['pmstats'] = iif($vbulletin->userinfo['options'] & $vbulletin->bf_misc_useroptions['receivepm'] AND $permissions['pmquota'] > 0, true, false);
$show['pmtracklink'] = iif($permissions['pmpermissions'] & $vbulletin->bf_ugp_pmpermissions['cantrackpm'], true, false);

$show['siglink'] = iif($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canusesignature'], true, false);
$show['avatarlink'] = iif($vbulletin->options['avatarenabled'], true, false);
$show['profilepiclink'] = iif($permissions['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canprofilepic'] AND $vbulletin->options['profilepicenabled'], true, false);
$show['wollink'] = iif($permissions['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonline'], true, false);

$show['spacer'] = true; // used in postbit template
$show['dst_correction'] = iif(($vbulletin->session->vars['loggedin'] == 1 OR $vbulletin->session->created OR THIS_SCRIPT == 'usercp') AND $vbulletin->userinfo['dstauto'] == 1 AND $vbulletin->userinfo['userid'], true, false);
$show['contactus'] = iif($vbulletin->options['contactuslink'] AND ((!$vbulletin->userinfo['userid'] AND $vbulletin->options['contactustype']) OR ($vbulletin->userinfo['userid'])), true, false);

$show['forumdesc'] = ($vbulletin->options['nav_forumdesc'] AND trim($foruminfo['description']) != '' AND in_array(THIS_SCRIPT, array('newthread', 'newreply', 'forumdisplay', 'showthread', 'announcement', 'editpost', 'poll', 'report', 'sendmessage', 'threadrate'))) ? true : false;

// you may define this if you don't want the password in the login box to be zapped onsubmit; good for integration
$show['nopasswordempty'] = defined('DISABLE_PASSWORD_CLEARING') ? 1 : 0; // this nees to be an int for the templates

// parse some global templates
eval('$gobutton = "' . fetch_template('gobutton') . '";');
eval('$spacer_open = "' . fetch_template('spacer_open') . '";');
eval('$spacer_close = "' . fetch_template('spacer_close') . '";');

($hook = vBulletinHook::fetch_hook('parse_templates')) ? eval($hook) : false;

// parse headinclude, header & footer
$admincpdir =& $vbulletin->config['Misc']['admincpdir'];
$modcpdir =& $vbulletin->config['Misc']['modcpdir'];

// page number is used in meta tags (sometimes)
$pagenumber = $vbulletin->input->clean_gpc('r', 'pagenumber', TYPE_UINT);
eval('$headinclude = "' . fetch_template('headinclude') . '";');
eval('$header = "' . fetch_template('header') . '";');
eval('$footer = "' . fetch_template('footer') . '";');

// #############################################################################
// Redirect if this forum has a link
// check if this forum is a link to an outside site
if (trim($foruminfo['link']) != '')
{
	// get permission to view forum
	$_permsgetter_ = 'forumdisplay';
	$forumperms = fetch_permissions($forumid);
	if (!($forumperms & $vbulletin->bf_ugp_forumpermissions['canview']))
	{
		print_no_permission();
	}
	exec_header_redirect($foruminfo['link'], true);
}

// #############################################################################
// Check for pm popup
if ($shownewpm)
{
	if ($vbulletin->userinfo['pmunread'] == 1)
	{
		$pmpopupurl = 'private.php?' . $vbulletin->session->vars['sessionurl_js'] . "do=showpm&pmid=$newpm[pmid]";
	}
	else
	{
		if (!empty($vbulletin->session->vars['sessionurl_js']))
		{
			$pmpopupurl = 'private.php?' . $vbulletin->session->vars['sessionurl_js'];
		}
		else
		{
			$pmpopupurl = 'private.php';
		}
	}
	eval('$footer .= "' . fetch_template('pm_popup_script') . '";');
}

// #############################################################################
// ######################### END TEMPLATES & STYLES ############################
// #############################################################################

// #############################################################################
// phpinfo display for support purposes
if ($_REQUEST['do'] == 'phpinfo')
{
	if ($vbulletin->options['allowphpinfo'] AND !is_demo_mode())
	{
		phpinfo();
		exit;
	}
	else
	{
		eval(standard_error(fetch_error('admin_disabled_php_info')));
	}
}

// #############################################################################
// check to see if server is too busy. this is checked at the end of session.php
if ($servertoobusy AND !($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel']) AND THIS_SCRIPT != 'login')
{
	$vbulletin->options['useforumjump'] = 0;
	eval(standard_error(fetch_error('toobusy')));
}

// #############################################################################
// check that board is active - if not admin, then display error
if (!$vbulletin->options['bbactive'] AND THIS_SCRIPT != 'login')
{
	if (!($permissions['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel']))
	{
		$show['enableforumjump'] = true;
		eval('standard_error("' . str_replace("\'", "'", addslashes($vbulletin->options['bbclosedreason'])) . '");');
		unset($db->shutdownqueries['lastvisit']);
	}
	else
	{
		// show the board disabled warning message so that admins don't leave the board turned off by accident
		eval('$warning = "' . fetch_template('board_inactive_warning') . '";');
		$header = $warning . $header;
		$footer .= $warning;
	}
}

// #############################################################################
// password expiry system
if ($vbulletin->userinfo['userid'] AND $permissions['passwordexpires'])
{
	$passworddaysold = floor((TIMENOW - $vbulletin->userinfo['passworddate']) / 86400);

	if ($passworddaysold >= $permissions['passwordexpires'])
	{
		if ((THIS_SCRIPT != 'login' AND THIS_SCRIPT != 'profile') OR (THIS_SCRIPT == 'profile' AND $_REQUEST['do'] != 'editpassword' AND $_POST['do'] != 'updatepassword'))
		{
			eval(standard_error(fetch_error('passwordexpired',
				$passworddaysold,
				$vbulletin->session->vars['sessionurl']
			)));
		}
		else
		{
			$show['passwordexpired'] = true;
		}
	}
}
else
{
	$passworddaysold = 0;
	$show['passwordexpired'] = false;
}

// #############################################################################
// check permission to view forum
if (!($permissions['forumpermissions'] & $vbulletin->bf_ugp_forumpermissions['canview']))
{
	$allowed_scripts = array(
		'register',
		'login',
		'image',
		'sendmessage',
	);
	if (!in_array(THIS_SCRIPT, $allowed_scripts))
	{
		if (defined('DIE_QUIETLY'))
		{
			exit;
		}
		else
		{
			print_no_permission();
		}
	}
	else
	{
		$_doArray = array('contactus', 'docontactus', 'register', 'signup', 'requestemail', 'emailcode', 'activate', 'login', 'logout', 'lostpw', 'emailpassword', 'addmember', 'coppaform', 'resetpassword', 'regcheck', 'checkdate');
		if (THIS_SCRIPT == 'sendmessage' AND $_REQUEST['do'] == '')
		{
			$_REQUEST['do'] = 'contactus';
		}
		$_aArray = array('act', 'ver', 'pwd');
		if (!in_array($_REQUEST['do'], $_doArray) AND !in_array($vbulletin->GPC['a'], $_aArray))
		{
			if (defined('DIE_QUIETLY'))
			{
				exit;
			}
			else
			{
				print_no_permission();
			}
		}
		unset($_doArray, $_aArray);
	}
}

// #############################################################################
// check for IP ban on user
verify_ip_ban();

// Set up threaded mode
if ($vbulletin->GPC['threadid'] AND $vbulletin->options['allowthreadedmode'])
{
	if ($vbulletin->GPC['mode'] != '' AND THIS_SCRIPT == 'showthread')
	{
		// Look for command to switch types on the query string
		switch ($vbulletin->GPC['mode'])
		{
			case 'threaded':
				$threadedmode = 1;
				$threadedCookieVal = 'threaded';
				break;
			case 'hybrid':
				$threadedmode = 2;
				$threadedCookieVal = 'hybrid';
				break;
			default:
				$threadedmode = 0;
				$threadedCookieVal = 'linear';
				break;
		}
		vbsetcookie('threadedmode', $threadedCookieVal);
		$vbulletin->GPC[COOKIE_PREFIX . 'threadedmode'] = $threadedCookieVal;
		unset($threadedCookieVal);
	}
	// Look for existing cookie, set from previous call to statement above us
	else if ($vbulletin->GPC[COOKIE_PREFIX . 'threadedmode'])
	{
		switch ($vbulletin->GPC[COOKIE_PREFIX . 'threadedmode'])
		{
			case 'threaded':
				$threadedmode = 1;
				break;
			case 'hybrid':
				$threadedmode = 2;
				break;
			default:
				$threadedmode = 0;
				break;
		}
	}
}

if ($db->explain)
{
	$pageendtime = microtime();
	$starttime = explode(' ', $pagestarttime);
	$endtime = explode(' ', $pageendtime);
	$aftertime = $endtime[0] - $starttime[0] + $endtime[1] - $starttime[1];
	echo "End call of global.php:  $aftertime\n";
	echo "\n<hr />\n\n";
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: global.php,v $ - $Revision: 1.325 $
|| ####################################################################
\*======================================================================*/
?>