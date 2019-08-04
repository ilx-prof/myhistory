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

// ########################## REQUIRE BACK-END ############################
require_once(DIR . '/includes/class_paid_subscription.php');

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################
$subobj = new vB_PaidSubscription($vbulletin);
$subobj->cache_user_subscriptions();

if (is_array($subobj->subscriptioncache))
{
	foreach ($subobj->subscriptioncache as $key => $subscription)
	{
		// disable people :)
		$subscribers = $vbulletin->db->query_read("
			SELECT userid
			FROM " . TABLE_PREFIX . "subscriptionlog
			WHERE subscriptionid = $subscription[subscriptionid]
				AND expirydate <= " . TIMENOW . "
				AND status = 1
		");

		while ($subscriber = $vbulletin->db->fetch_array($subscribers))
		{
			$subobj->delete_user_subscription($subscription['subscriptionid'], $subscriber['userid']);
		}
	}

	// time for the reminders
	$subscriptions_reminders = $vbulletin->db->query_read("
		SELECT subscriptionlog.subscriptionid, subscriptionlog.userid, subscriptionlog.expirydate, user.username, user.email, user.languageid
		FROM " . TABLE_PREFIX . "subscriptionlog AS subscriptionlog
		LEFT JOIN " . TABLE_PREFIX . "user AS user ON (user.userid = subscriptionlog.userid)
		WHERE subscriptionlog.expirydate >= " . (TIMENOW + (86400 * 2)) . "
			AND subscriptionlog.expirydate <= " . (TIMENOW + (86400 * 3)) . "
			AND status = 1
	");

	vbmail_start();
	while ($subscriptions_reminder = $vbulletin->db->fetch_array($subscriptions_reminders))
	{
		$subscription_title = $subobj->subscriptioncache["$subscriptions_reminder[subscriptionid]"]['title'];

		$username = unhtmlspecialchars($subscriptions_reminder['username']);
		eval(fetch_email_phrases('paidsubscription_reminder', $subscriptions_reminder['languageid']));
		vbmail($subscriptions_reminder['email'], $subject, $message);
	}
	vbmail_end();
}

log_cron_action('Subscriptions Updated', $nextitem);
/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: subscriptions.php,v $ - $Revision: 1.25 $
|| ####################################################################
\*======================================================================*/
?>