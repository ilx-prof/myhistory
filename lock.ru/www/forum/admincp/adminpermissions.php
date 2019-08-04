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

// ##################### DEFINE IMPORTANT CONSTANTS #######################
define('CVS_REVISION', '$RCSfile: adminpermissions.php,v $ - $Revision: 1.54 $');

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('cppermission');
$specialtemplates = array();

// ########################## REQUIRE BACK-END ############################
require_once('./global.php');

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

print_cp_header($vbphrase['administrator_permissions_manager']);

if (!in_array($vbulletin->userinfo['userid'], preg_split('#\s*,\s*#s', $vbulletin->config['SpecialUsers']['superadministrators'], -1, PREG_SPLIT_NO_EMPTY)))
{
	print_stop_message('sorry_you_are_not_allowed_to_edit_admin_permissions');
}

// ############################# LOG ACTION ###############################
$vbulletin->input->clean_array_gpc('r', array(
	'userid' 	=> TYPE_INT
));

if ($vbulletin->GPC['userid'])
{
	$user = $db->query_first("
		SELECT user.userid, user.username, administrator.*,
		IF(administrator.userid IS NULL, 0, 1) AS isadministrator
		FROM " . TABLE_PREFIX . "user AS user
		LEFT JOIN " . TABLE_PREFIX . "administrator AS administrator ON(administrator.userid = user.userid)
		WHERE user.userid = " . $vbulletin->GPC['userid']
	);

	if (!$user)
	{
		print_stop_message('no_matches_found');
	}
	else if (!$user['isadministrator'])
	{
		print_stop_message('invalid_user_specified');
	}

	$admindm =& datamanager_init('Admin', $vbulletin, ERRTYPE_CP);
	$admindm->set_existing($user);
}
else
{
	$user = array();
}

$ADMINPERMISSIONS = $vbulletin->bf_ugp_adminpermissions;
unset($ADMINPERMISSIONS['ismoderator'], $ADMINPERMISSIONS['cancontrolpanel']);

$vbulletin->input->clean_array_gpc('p', array(
	'oldpermissions' 	=> TYPE_INT,
	'adminpermissions'	=> TYPE_ARRAY_INT
));

require_once(DIR . '/includes/functions_misc.php');
log_admin_action(iif($user, "user id = $user[userid] ($user[username])" . iif($_POST['do'] == 'update', " (" . $vbulletin->GPC['oldpermissions'] ." &raquo; " . convert_array_to_bits($vbulletin->GPC['adminpermissions'], $ADMINPERMISSIONS) . ")")));

// #############################################################################

$permsphrase = array(
	'canadminsettings'		=> $vbphrase['can_administer_settings'],
	'canadminstyles'		=> $vbphrase['can_administer_styles'],
	'canadminlanguages'		=> $vbphrase['can_administer_languages'],
	'canadminforums'		=> $vbphrase['can_administer_forums'],
	'canadminthreads'		=> $vbphrase['can_administer_threads'],
	'canadmincalendars'		=> $vbphrase['can_administer_calendars'],
	'canadminusers'			=> $vbphrase['can_administer_users'],
	'canadminpermissions'	=> $vbphrase['can_administer_user_permissions'],
	'canadminfaq'			=> $vbphrase['can_administer_faq'],
	'canadminimages'		=> $vbphrase['can_administer_images'],
	'canadminbbcodes'		=> $vbphrase['can_administer_bbcodes'],
	'canadmincron'			=> $vbphrase['can_administer_cron'],
	'canadminmaintain'		=> $vbphrase['can_run_maintenance'],
	'canadminupgrade'		=> $vbphrase['can_run_upgrades'],
	'canadminplugins'		=> $vbphrase['can_administer_plugins'],
);

// #############################################################################

if (empty($_REQUEST['do']))
{
	$_REQUEST['do'] = 'modify';
}

// #############################################################################

if ($_POST['do'] == 'update')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'cssprefs'			=> TYPE_STR
	));

	foreach ($vbulletin->GPC['adminpermissions'] AS $key => $value)
	{
		$admindm->set_bitfield('adminpermissions', $key, $value);
	}

	($hook = vBulletinHook::fetch_hook('admin_permissions_process')) ? eval($hook) : false;

	$admindm->set('cssprefs', $vbulletin->GPC['cssprefs']);
	$admindm->save();

	define('CP_REDIRECT', "adminpermissions.php?" . $vbulletin->session->vars['sessionurl'] . "#user$user[userid]");
	print_stop_message('saved_administrator_permissions_successfully');
}

// #############################################################################

if ($_REQUEST['do'] == 'edit')
{
	print_form_header('adminpermissions', 'update');
	construct_hidden_code('userid', $vbulletin->GPC['userid']);
	construct_hidden_code('oldpermissions', $user['adminpermissions']);
	print_table_header(construct_phrase($vbphrase['x_y_id_z'], $vbphrase['administrator_permissions'], $user['username'], $user['userid']));
	print_label_row("$vbphrase[administrator]: <a href=\"user.php?" . $vbulletin->session->vars['sessionurl'] . "do=edit&amp;u=" . $vbulletin->GPC['userid'] . "\">$user[username]</a>", '<div align="' . $stylevar['right'] .'"><input type="button" class="button" value=" ' . $vbphrase['all_yes'] . ' " onclick="js_check_all_option(this.form, 1);" /> <input type="button" class="button" value=" ' . $vbphrase['all_no'] . ' " onclick="js_check_all_option(this.form, 0);" /></div>', 'thead');

	foreach (convert_bits_to_array($user['adminpermissions'], $ADMINPERMISSIONS) AS $field => $value)
	{
		if ($field == 'canadminupgrade')
		{
			construct_hidden_code("adminpermissions[$field]", $value);
		}
		else
		{
			print_yes_no_row($permsphrase["$field"], "adminpermissions[$field]", $value);
		}
	}

	($hook = vBulletinHook::fetch_hook('admin_permissions_form')) ? eval($hook) : false;

	print_select_row($vbphrase['control_panel_style_choice'], 'cssprefs', array_merge(array('' => "($vbphrase[default])"), fetch_cpcss_options()), $user['cssprefs']);

	print_submit_row();
}

// #############################################################################

if ($_REQUEST['do'] == 'modify')
{
	print_form_header('adminpermissions', 'edit');
	print_table_header($vbphrase['administrator_permissions'], 3);

	$users = $db->query_read("
		SELECT user.username, usergroupid, membergroupids, administrator.*
		FROM " . TABLE_PREFIX . "administrator AS administrator
		INNER JOIN " . TABLE_PREFIX . "user AS user USING(userid)
		ORDER BY user.username
	");
	while ($user = $db->fetch_array($users))
	{
		$perms = fetch_permissions(0, $user['userid'], $user);
		if ($perms['adminpermissions'] & $vbulletin->bf_ugp_adminpermissions['cancontrolpanel'])
		{
			print_cells_row(array(
				"<a href=\"user.php?" . $vbulletin->session->vars['sessionurl'] . "do=edit&amp;u=$user[userid]\" name=\"user$user[userid]\"><b>$user[username]</b></a>",
				'-',
				construct_link_code($vbphrase['view_control_panel_log'], "adminlog.php?" . $vbulletin->session->vars['sessionurl'] . "do=view&script=&u=$user[userid]") .
				construct_link_code($vbphrase['edit_permissions'], "adminpermissions.php?" . $vbulletin->session->vars['sessionurl'] . "do=edit&amp;u=$user[userid]")
			), 0, '', 0);
		}
	}

	print_table_footer();
}

print_cp_footer();

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: adminpermissions.php,v $ - $Revision: 1.54 $
|| ####################################################################
\*======================================================================*/
?>
