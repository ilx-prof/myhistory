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

error_reporting(E_ALL & ~E_NOTICE);

// #################### Fetch User's Rank ################
function &fetch_rank(&$userinfo)
{
	global $vbulletin;

	if (!is_array($vbulletin->ranks))
	{
		// grab ranks since we didn't include 'ranks' in $specialtemplates
		$vbulletin->ranks =& build_ranks();
	}

	$doneusergroup = array();
	$userrank = '';

	foreach ($vbulletin->ranks AS $rank)
	{
		$displaygroupid = empty($userinfo['displaygroupid']) ? $userinfo['usergroupid'] : $userinfo['displaygroupid'];
		if ($userinfo['posts'] >= $rank['m'] AND empty($doneusergroup["$rank[u]"])
		AND
		(($rank['u'] > 0 AND is_member_of($userinfo, $rank['u']) AND (empty($rank['d']) OR $rank['u'] == $displaygroupid))
		OR
		($rank['u'] == 0 AND (empty($rank['d']) OR empty($userrank)))))
		{
			if (!empty($userrank) AND $rank['s'])
			{
				$userrank .= '<br />';
			}
			$doneusergroup["$rank[u]"] = true;
			for ($x = $rank['l']; $x--; $x > 0)
			{
				if (empty($rank['t']))
				{
					$userrank .= "<img src=\"$rank[i]\" alt=\"\" border=\"\" />";
				}
				else
				{
					$userrank .= $rank['i'];
				}
			}
		}
	}

	return $userrank;
}

// #################### Begin Build Ranks PHP Code function ################
function &build_ranks()
{
	global $vbulletin;

	$ranks = $vbulletin->db->query_read("
		SELECT ranklevel AS l, minposts AS m, rankimg AS i, type AS t, stack AS s, display AS d, ranks.usergroupid AS u
		FROM " . TABLE_PREFIX . "ranks AS ranks
		LEFT JOIN " . TABLE_PREFIX . "usergroup AS usergroup USING (usergroupid)
		ORDER BY ranks.usergroupid DESC, minposts DESC
	");

	$rankarray = array();
	while ($rank = $vbulletin->db->fetch_array($ranks))
	{
		$rankarray[] = $rank;
	}

	build_datastore('ranks', serialize($rankarray));

	return $rankarray;
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: functions_ranks.php,v $ - $Revision: 1.6 $
|| ####################################################################
\*======================================================================*/
?>