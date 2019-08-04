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
if (!is_object($vbulletin->db))
{
	exit;
}

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

$attachmentids = '';
$attachcasesql = '';

if ($vbulletin->options['usemailqueue'] == 2)
{
	$vbulletin->db->lock_tables(array('attachmentviews' => 'WRITE'));
}

$attachments = $vbulletin->db->query_read("
	SELECT attachmentid, COUNT(*) AS views
	FROM " . TABLE_PREFIX . "attachmentviews
	GROUP BY attachmentid
");

while ($attachment = $vbulletin->db->fetch_array($attachments))
{
	$attachcasesql .= " WHEN attachmentid = $attachment[attachmentid] THEN $attachment[views]";
	$attachmentids .= ",$attachment[attachmentid]";
}

if (!empty($attachmentids))
{
	$vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "attachmentviews");
}

if ($vbulletin->options['usemailqueue'] == 2)
{
	$vbulletin->db->unlock_tables();
}

if (!empty($attachmentids))
{

	$vbulletin->db->query_write("
		UPDATE " . TABLE_PREFIX . "attachment
		SET counter = counter +
		CASE
			$attachcasesql
			ELSE 0
		END
		WHERE attachmentid IN (-1$attachmentids)
	");
}

log_cron_action('Attachment Views Updated', $nextitem);


/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: attachmentviews.php,v $ - $Revision: 1.25 $
|| ####################################################################
\*======================================================================*/
?>