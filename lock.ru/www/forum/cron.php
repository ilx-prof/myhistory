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
ignore_user_abort(1);
@set_time_limit(0);

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('SKIP_SESSIONCREATE', 1);
define('THIS_SCRIPT', 'cron');

// #################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array();

// get special data templates from the datastore
$specialtemplates = array();

// pre-cache templates used by all actions
$globaltemplates = array();

// pre-cache templates used by specific actions
$actiontemplates = array();

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions_cron.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

header('Location: ' . $vbulletin->options['cleargifurl']);

($hook = vBulletinHook::fetch_hook('cron_start')) ? eval($hook) : false;

if (!defined('NOSHUTDOWNFUNC') AND !$vbulletin->options['crontab'])
{
	vB_Shutdown::add('exec_cron');
}
else
{
	$cronid = NULL;
	if ($vbulletin->options['crontab'] AND SAPI_NAME == 'cli')
	{
		$cronid = intval($_SERVER['argv'][1]);
		// if its a negative number or 0 set it to NULL so it just grabs the next task
		if ($cronid < 1)
		{
			$cronid = NULL;
		}
	}

	exec_cron($cronid);
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: cron.php,v $ - $Revision: 1.37 $
|| ####################################################################
\*======================================================================*/
?>