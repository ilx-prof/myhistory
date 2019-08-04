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

$vbulletin->db->query_write("
	DELETE FROM " . TABLE_PREFIX . "session
	WHERE lastactivity < " . intval(TIMENOW - $vbulletin->options['cookietimeout']) . "
	### Delete stale sessions ###
");

// posthashes are only valid for 5 minutes
$vbulletin->db->query_write("
	DELETE FROM " . TABLE_PREFIX . "posthash
	WHERE dateline < " . (TIMENOW - 300)
);

// expired registration images after 1 hour
$vbulletin->db->query_write("
	DELETE FROM " . TABLE_PREFIX . "regimage
	WHERE dateline < " . (TIMENOW - 3600)
);

// expired cached posts
$vbulletin->db->query_write("
	DELETE FROM " . TABLE_PREFIX . "post_parsed
	WHERE dateline < " . (TIMENOW - ($vbulletin->options['cachemaxage'] * 60 * 60 * 24))
);

// Orphaned Attachments are removed after one hour
$attachdata =& datamanager_init('Attachment', $vbulletin, ERRTYPE_SILENT);
$attachdata->set_condition("attachment.postid = 0 AND attachment.dateline < " . (TIMENOW - 3600));
$attachdata->delete();

// Orphaned pmtext records are removed after one hour.
// When we delete PMs we only delete the pm record, leaving
// the pmtext record alone for this script to clean up
$pmtexts = $vbulletin->db->query_read("
	SELECT pmtext.pmtextid
	FROM " . TABLE_PREFIX . "pmtext AS pmtext
	LEFT JOIN " . TABLE_PREFIX . "pm AS pm USING(pmtextid)
	WHERE pm.pmid IS NULL
");
if ($vbulletin->db->num_rows($pmtexts))
{
	$pmtextids = '0';
	while ($pmtext = $vbulletin->db->fetch_array($pmtexts))
	{
		$pmtextids .= ",$pmtext[pmtextid]";
	}
	$vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "pmtext WHERE pmtextid IN($pmtextids)");
}
$vbulletin->db->free_result($pmtexts);

log_cron_action('Hourly Cleanup #2 Completed', $nextitem);

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: cleanup2.php,v $ - $Revision: 1.23 $
|| ####################################################################
\*======================================================================*/
?>