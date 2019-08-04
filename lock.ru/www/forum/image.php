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
define('LOCATION_BYPASS', 1);
define('NOCOOKIES', 1);
define('THIS_SCRIPT', 'image');
define('VB_AREA', 'Forum');

if ((!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) OR !empty($_SERVER['HTTP_IF_NONE_MATCH'])) AND $_GET['type'] != 'regcheck')
{
	// Don't check modify date as URLs contain unique items to nullify caching
	$sapi_name = php_sapi_name();
	if ($sapi_name == 'cgi' OR $sapi_name == 'cgi-fcgi')
	{
		header('Status: 304 Not Modified');
	}
	else
	{
		header('HTTP/1.1 304 Not Modified');
	}
	exit;
}

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
if ($_REQUEST['type'] == 'profile') // do not modify this $_REQUEST
{
	require_once('./global.php');
}
else
{
	define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));
	require_once(CWD . '/includes/init.php');
}

$vbulletin->input->clean_gpc('r', 'type', TYPE_STR);

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

if ($vbulletin->GPC['type'] == 'regcheck')
{
	require_once(DIR . '/includes/class_image.php');

	$vbulletin->input->clean_array_gpc('r', array(
		'imagehash' => TYPE_STR,
		'i'         => TYPE_STR,
	));

	if ($vbulletin->GPC['imagehash'] == 'test')
	{
		require_once(DIR . '/includes/functions_user.php');
		$imageinfo = array(
			'imagestamp' => fetch_registration_string(6),
		);
	}
	else  if ((!$vbulletin->options['gdversion'] AND $vbulletin->options['regimagetype'] == 'GD') OR $vbulletin->GPC['imagehash'] == '' OR !($imageinfo = $db->query_first("SELECT imagestamp FROM " . TABLE_PREFIX . "regimage WHERE regimagehash = '" . $db->escape_string($vbulletin->GPC['imagehash']) . "'")))
	{
		header('Content-type: image/gif');
		readfile(DIR . '/' . $vbulletin->options['cleargifurl']);
		exit;
	}

	if ($vbulletin->GPC['i'] == 'gd')
	{
		$image = new vB_Image_GD($vbulletin);
	}
	else if ($vbulletin->GPC['i'] == 'im')
	{
		$image = new vB_Image_Magick($vbulletin);
	}
	else
	{
		$image =& vB_Image::fetch_library($vbulletin, 'regimage');
	}
	$image->print_image_from_string($imageinfo['imagestamp']);
}
else
{
	$vbulletin->input->clean_array_gpc('r', array(
		'userid'   => TYPE_UINT,
		'dateline' => TYPE_UINT,
	));

	if ($vbulletin->GPC['type'] == 'profile')
	{
		$table = 'customprofilepic';
		// No permissions to see profile pics
		if (!$vbulletin->options['profilepicenabled'] OR (!($vbulletin->userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canseeprofilepic']) AND $vbulletin->userinfo['userid'] != $vbulletin->input['userid']))
		{
			header('Content-type: image/gif');
			readfile(DIR . '/' . $vbulletin->options['cleargifurl']);
			exit;
		}
	}
	else
	{
		$table = 'customavatar';
	}

	if ($imageinfo = $db->query_first("
			SELECT filedata, dateline, filename
			FROM " . TABLE_PREFIX . "$table
			WHERE userid = " . $vbulletin->GPC['userid'] . " AND visible = 1
		"))
	{
		header('Cache-control: max-age=31536000');
		header('Expires: ' . gmdate('D, d M Y H:i:s', (TIMENOW + 31536000)) . ' GMT');
		header('Content-disposition: inline; filename=' . $imageinfo['filename']);
		header('Content-transfer-encoding: binary');
		header('Content-Length: ' . strlen($imageinfo['filedata']));
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $imageinfo['dateline']) . ' GMT');
		header('ETag: "' . $imageinfo['dateline'] . '-' . $vbulletin->GPC['userid'] . '"');
		$extension = trim(substr(strrchr(strtolower($imageinfo['filename']), '.'), 1));
		if ($extension == 'jpg' OR $extension == 'jpeg')
		{
			header('Content-type: image/jpeg');
		}
		else if ($extension == 'png')
		{
			header('Content-type: image/png');
		}
		else
		{
			header('Content-type: image/gif');
		}
		echo $imageinfo['filedata'];
	}
	else
	{
		header('Content-type: image/gif');
		readfile(DIR . '/' . $vbulletin->options['cleargifurl']);
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: image.php,v $ - $Revision: 1.88 $
|| ####################################################################
\*======================================================================*/
?>