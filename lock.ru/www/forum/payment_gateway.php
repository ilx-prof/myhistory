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
define('THIS_SCRIPT', 'payment_gateway');
define('SESSION_BYPASS', 1);

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
define('VB_AREA', 'Subscriptions');
define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));
require_once(CWD . '/includes/init.php');

require_once(DIR . '/includes/adminfunctions.php');
require_once(DIR . '/includes/class_paid_subscription.php');

$vbulletin->input->clean_array_gpc('g', array(
	'method'    => TYPE_STR
));

$api = $db->query_first("SELECT * FROM " . TABLE_PREFIX . "paymentapi WHERE classname = '" . $db->escape_string($vbulletin->GPC['method']) . "'");
if (!empty($api))
{
	$subobj = new vB_PaidSubscription($vbulletin);
	if (file_exists(DIR . '/includes/paymentapi/class_' . $vbulletin->GPC['method'] . '.php'))
	{
		require_once(DIR . '/includes/paymentapi/class_' . $vbulletin->GPC['method'] . '.php');
		$api_class = 'vB_PaidSubscriptionMethod_' . $vbulletin->GPC['method'];
		$apiobj = new $api_class($vbulletin);

		if (!empty($api['settings']))
		{ // need to convert this from a serialized array with types to a single value
			$apiobj->settings = $subobj->construct_payment_settings($api['settings']);
		}

		if ($apiobj->verify_payment())
		{
			// its a valid payment now lets check transactionid
			$transaction = $db->query_first("SELECT * FROM " . TABLE_PREFIX . "paymenttransaction WHERE transactionid = '" . $db->escape_string($apiobj->transaction_id) . "'");
			if (empty($transaction))
			{
				/*insert query*/
				$trans['transactionid'] = $apiobj->transaction_id;
				$trans['paymentinfoid'] = $apiobj->paymentinfo['paymentinfoid'];
				$trans['state'] = $apiobj->type;
				$db->query_write(fetch_query_sql($trans, 'paymenttransaction'));
				if ($apiobj->type == 1)
				{
					$subobj->build_user_subscription($apiobj->paymentinfo['subscriptionid'], $apiobj->paymentinfo['subscriptionsubid'], $apiobj->paymentinfo['userid']);
				}
				else if ($apiobj->type == 2)
				{
					$subobj->delete_user_subscription($apiobj->paymentinfo['subscriptionid'], $apiobj->paymentinfo['userid']);
				}
			}
			if ($apiobj->type == 2)
			{
				$subobj->delete_user_subscription($apiobj->paymentinfo['subscriptionid'], $apiobj->paymentinfo['userid']);
			}
		}
		else
		{ // something went horribly wrong, get $apiobj->error

		}
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: payment_gateway.php,v $ - $Revision: 1.7 $
|| ####################################################################
\*======================================================================*/
?>