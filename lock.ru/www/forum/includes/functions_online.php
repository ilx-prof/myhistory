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

// ###################### Start userlocation #######################
function fetch_user_location_array($userinfo)
{

	global $vbulletin;

	$datecut = TIMENOW - $vbulletin->options['cookietimeout'];

	if  (($userinfo['invisible'] == 0 OR $userinfo['userid'] == $vbulletin->userinfo['userid'] OR $vbulletin->userinfo['permissions']['genericpermissions'] & $vbulletin->bf_ugp_genericpermissions['canseehidden']) AND // Check if user is hidden
		$vbulletin->options['WOLenable'] AND // Is WOL enabled?
		($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonline']) AND // Does viewing user have WOL access?
		 ($userinfo['lastactivity'] > $datecut AND $userinfo['lastvisit'] != $user['lastactivity']) AND // Is user actually online?
		$location = $vbulletin->db->query_first("SELECT location, badlocation FROM " . TABLE_PREFIX . "session WHERE userid = $userinfo[userid] AND lastactivity > $datecut ORDER BY lastactivity DESC LIMIT 1"))
	{

			$userinfo['location'] = $location['location'];
			$userinfo['badlocation'] = $location['badlocation'];
			$userinfo = process_online_location($userinfo);
			convert_ids_to_titles();
			$userinfo = construct_online_bit($userinfo);
	}

	return $userinfo;
}

// ###################### Start showonline #######################
function construct_online_bit($userinfo, $doall = 0)
{

	global $wol_attachment, $wol_user, $wol_thread, $wol_post, $wol_event, $wol_calendar;
	global $vbulletin, $wol_pm, $wol_search;
	global $limitlower, $limitupper, $stylevar, $vbphrase, $ipclass, $show;
	static $count;

	$count++;
	$show['nopermission'] = false;
	$show['lockedout'] = false;
	$show['errormessage'] = false;

	if ($doall == 1 AND ($count > $limitupper OR $count < $limitlower))
	{
		return '';
	}

	if ($userinfo['attachmentid'])
	{
		$postid = $wol_attachment["$userinfo[attachmentid]"];
	}
	else
	{
		$postid = $userinfo['postid'];
	}
	if ($postid)
	{
		$threadid = $wol_post["$postid"];
	}
	else
	{
		$threadid = $userinfo['threadid'];
	}
	$forumid = $userinfo['forumid'];
	$calendarid = $userinfo['calendarid'];
	$eventid = $userinfo['eventid'];
	$searchid = $userinfo['searchid'];
	if ($searchid)
	{
		$searchquery = $wol_search["$searchid"]['query'];
		$searchuser = $wol_search["$searchid"]['searchuser'];
		$searchuserid = $wol_search["$searchid"]['userid'];
	}
	if (!$forumid AND isset($wol_thread["$threadid"]['forumid']))
	{
		$forumid = $wol_thread["$threadid"]['forumid'];
	}
	else if (!$forumid AND isset($wol_thread["$wol_post[$postid]"]['forumid']))
	{
		$forumid = $wol_thread["$wol_post[$postid]"]['forumid'];
	}
	$threadtitle = $wol_thread["$threadid"]['title'];
	$canview = $vbulletin->userinfo['forumpermissions']["$forumid"] & $vbulletin->bf_ugp_forumpermissions['canview'];
	$canviewothers = $vbulletin->userinfo['forumpermissions']["$forumid"] & $vbulletin->bf_ugp_forumpermissions['canviewothers'];
	$canviewthreads = $vbulletin->userinfo['forumpermissions']["$forumid"] & $vbulletin->bf_ugp_forumpermissions['canviewthreads'];
	$postuserid = $wol_thread["$threadid"]['postuserid'];
	$forumtitle = $vbulletin->forumcache["$forumid"]['title'];
	$threadpreview = $wol_thread["$threadid"]['preview'];

	if (!$calendarid AND isset($wol_event["$eventid"]['calendarid']))
	{
		$calendarid = $wol_event["$eventid"]['calendarid'];
	}
	$eventtitle = $wol_event["$eventid"]['title'];
	$eventpostuserid = $wol_event["$eventid"]['postuserid'];
	$calendartitle = $wol_calendar["$calendarid"];
	$canviewcalendar = $vbulletin->userinfo['calendarpermissions']["$calendarid"] & $vbulletin->bf_ugp_calendarpermissions['canviewcalendar'];
	$canviewothersevent = $vbulletin->userinfo['calendarpermissions']["$calendarid"] & $vbulletin->bf_ugp_calendarpermissions['canviewothersevent'];

	if ($wol_thread["$threadid"]['isdeleted'] AND !can_moderate($forumid))
	{
		$threadviewable = 0;
	}
	else
	{
		$threadviewable = 1;
	}

	if ($threadviewable AND $threadtitle AND $canview AND ($canviewothers OR $postuserid == $vbulletin->userinfo['userid']) AND verify_forum_password($forumid, $vbulletin->forumcache["$forumid"]['password'], false))
	{
		$seetitle = 1;
	}
	if ($forumtitle AND ($canview OR $vbulletin->options['showprivateforums']))
	{
		$seeforum = 1;
	}
	if ($eventtitle AND $canviewcalendar AND ($canviewothersevent OR $eventpostuserid == $vbulletin->userinfo['userid']))
	{
		$seeevent = 1;
	}
	if ($calendartitle AND $canviewcalendar)
	{
		$seecalendar = 1;
	}
	if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull'])
	{
		if ($userinfo['pmid'])
		{
			$seeuserid = $wol_pm["$userinfo[pmid]"];
		}
		else if ($userinfo['searchid'])
		{
			$seeuserid = $wol_search["$searchid"]['targetuserid'];
		}
		else
		{
			$seeuserid = $userinfo['targetuserid'];
		}
	}

	switch($userinfo['activity'])
	{
		case 'showthread':
			$userinfo['action'] = $vbphrase['viewing_thread'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'showpost':
			$userinfo['action'] = $vbphrase['viewing_thread'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "p=$postid#postid=$postid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'forumdisplay':
			$userinfo['action'] = $vbphrase['viewing_forum'];
			if ($seeforum)
			{
				if ($vbulletin->forumcache["$forumid"]['link'])
				{
					$userinfo['action'] = $vbphrase['followed_forum_link'];
				}
				$userinfo['where'] = '<a href="forumdisplay.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumid\">$forumtitle</a>";
			}
			break;
		case 'newthread':
			$userinfo['action'] = $vbphrase['creating_thread'];
			if ($seeforum)
			{
				$userinfo['where'] = '<a href="forumdisplay.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumid\">$forumtitle</a>";
			}
			break;
		case 'newreply':
			$userinfo['action'] = $vbphrase['replying_to_thread'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'attachments':
			$userinfo['action'] = $vbphrase['viewing_attachments'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="misc.php?' . $vbulletin->session->vars['sessionurl'] . "do=attachments&amp;u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'manageattachment':
			$userinfo['action'] = $vbphrase['managing_attachments'];
			break;
		case 'attachment':
			$userinfo['action'] = $vbphrase['viewing_attachment'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "p=$postid#postid=$postid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'index':
			$userinfo['action'] = $vbphrase['viewing_index'];
			$userinfo['where'] = '<a href="' . $vbulletin->options['forumhome'] . '.php' . $vbulletin->session->vars['sessionurl_q'] . '">' . $vbulletin->options['bbtitle'] . '</a>';
			break;
		case 'online':
			$userinfo['action'] = $vbphrase['viewing_whos_online'];
			break;
		case 'searchnew':
			$userinfo['action'] = $vbphrase['viewing_new_posts'];
			$userinfo['where'] = '<a href="search.php?' . $vbulletin->session->vars['sessionurl'] . "do=getnew\">$vbphrase[new_posts]</a>";
			break;
		case 'search':
			$userinfo['action'] = $vbphrase['searching_forums'];
			if ($searchid AND $vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull'])
			{
				if ($searchquery)
				{
					$userinfo['where'] = construct_phrase($vbphrase['query_x'], htmlspecialchars_uni($searchquery));
				}
				if ($searchuser AND $wol_search["$searchid"]['targetuserid'])
				{
					if ($searchquery)
					{
						$userinfo['where'] .= '<br />';
					}
					$userinfo['where'] .= construct_phrase($vbphrase['user_x'], '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>");
				}
			}
			break;
		case 'mail':
			$userinfo['action'] = $vbphrase['emailing'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'getinfo':
			$userinfo['action'] = $vbphrase['viewing_user_profile'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'editprofile':
			$userinfo['action'] = $vbphrase['modifying_profile'];
			break;
		case 'editoptions':
			$userinfo['action'] = $vbphrase['modifying_options'];
			break;
		case 'lostpw':
		case 'editpassword':
			$userinfo['action'] = $vbphrase['modifying_password'];
			break;
		case 'editavatar':
			$userinfo['action'] = $vbphrase['modifying_avatar'];
			break;
		case 'editprofilepic':
			$userinfo['action'] = $vbphrase['modifying_profilepic'];
			break;
		case 'editsignature':
			$userinfo['action'] = $vbphrase['modifying_signature'];
			break;
		case 'markread':
			$userinfo['where'] = $vbphrase['marking_forums_read'];
			break;
		case 'whoposted':
			if ($seetitle)
			{
				$userinfo['action'] = $vbphrase['viewing_who_posted'];
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			else
			{
				$userinfo['action'] = $vbphrase['viewing_thread'];
			}
			break;
		case 'showgroups':
			$userinfo['action'] = $vbphrase['viewing_forum_leaders'];
			break;
		case 'login':
			$userinfo['action'] = $vbphrase['logging_in'];
			break;
		case 'archive':
			$userinfo['action'] = $vbphrase['viewing_archives'];
			if ($seetitle)
			{
				$userinfo['where'] = "<a href=\"archive/index.php/t-$threadid.html\" title=\"$threadpreview\">$threadtitle</a>";
			}
			else if ($seeforum)
			{
				$userinfo['where'] = "<a href=\"archive/index.php/f-$forumid.html\">$forumtitle</a>";
			}
			break;
		case 'pm':
			$userinfo['action'] = $vbphrase['private_messaging'];
			if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull'])
			{
				if ($seeuserid)
				{
					$userinfo['where'] = '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>";
				}
				if ($userinfo['values']['do'] == 'newpm' OR $userinfo['values']['do'] == 'insertpm' OR $userinfo['values']['do'] == 'newmessage')
				{
					$userinfo['action'] = $vbphrase['creating_private_message'];
				}
				else if ($userinfo['values']['do'] == 'editfolders' OR $userinfo['action']['do'] == 'updatefolders')
				{
					$userinfo['action'] = $vbphrase['modifying_private_message_folders'];
				}
				else if ($userinfo['values']['do'] == 'trackpm' OR $userinfo['values']['do'] == 'deletepmreceipt')
				{
					$userinfo['action'] = $vbphrase['tracking_private_messages'];
				}
				else if ($userinfo['values']['do'] == 'showpm')
				{
					$userinfo['action'] = $vbphrase['viewing_private_message'];
				}
				else if ($userinfo['values']['do'] == 'downloadpm')
				{
					$userinfo['action'] = $vbphrase['downloading_private_messages'];
				}

			}
			break;
		case 'addbuddy':
		case 'addignore':
		case 'buddyignore':
			$userinfo['action'] = $vbphrase['modifying_buddy_ignore_list'];
			break;
		case 'subfolders':
			$userinfo['action'] = $vbphrase['modifying_subscription_folders'];
			break;
		case 'subscription':
			$userinfo['action'] = $vbphrase['viewing_subscribed_threads'];
			break;
		case 'addsubforum':
			$userinfo['action'] = $vbphrase['subscribing_to_forum'];
			if ($seeforum)
			{
				$userinfo['where'] = '<a href="forumdisplay.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumid\">$forumtitle</a>";
			}
			break;
		case 'addsubthread':
			$userinfo['action'] = $vbphrase['subscribing_to_thread'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'remsubthread':
			$userinfo['action'] = $vbphrase['deleting_subscribed_threads'];
			break;
		case 'remsubforum':
			$userinfo['action'] = $vbphrase['deleting_subscribed_forums'];
			break;
		case 'usercp':
			$userinfo['action'] = $vbphrase['viewing_user_control_panel'];
			break;
		case 'memberlistsearch':
			$userinfo['action'] = $vbphrase['searching_member_list'];
			break;
		case 'memberlist':
			$userinfo['action'] = $vbphrase['viewing_member_list'];
			break;
		case 'inlinemod':
			$userinfo['action'] = '<b><i>' . $vbphrase['moderating'] . '</b></i>';
			if (can_moderate())
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
				switch ($userinfo['values']['do'])
				{
					case 'open':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_opening_threads'] . '</i>';
						break;
					case 'close':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_closing_threads'] . '</i>';
						break;
					case 'stick':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_sticking_threads'] . '</i>';
						break;
					case 'unstick':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_unsticking_threads'] . '</i>';
						break;
					case 'deletethread':
					case 'dodeletethreads':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_deleting_threads'] . '</i>';
						break;
					case 'undeletethread':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_undeleting_threads'] . '</i>';
						break;
					case 'approvethread':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_approving_threads'] . '</i>';
						break;
					case 'unapprovethread':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_unapproving_threads'] . '</i>';
						break;

					case 'movethread':
					case 'domovethreads':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_moving_threads'] . '</i>';
						break;

					case 'mergethread':
					case 'domergethreads':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_merging_threads'] . '</i>';
						break;

					case 'deleteposts':
					case 'dodeleteposts':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_deleting_posts'] . '</i>';
						break;

					case 'undeleteposts':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_undeleting_posts'] . '</i>';
						break;
					case 'approveposts':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_approving_posts'] . '</i>';
						break;
					case 'unapproveposts':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_unapproving_posts'] . '</i>';
						break;

					case 'mergeposts':
					case 'domergeposts':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_merging_posts'] . '</i>';
						break;

					case 'moveposts':
					case 'domoveposts':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_moving_posts'] . '</i>';
						break;

					case 'clearthread':
					case 'clearpost':
						$userinfo['action'] = '<i>' . $vbphrase['inline_mod_clear'] . '</i>';
						break;
				}
			}
			break;
		case 'postings':
			$userinfo['action'] = '<b><i>' . $vbphrase['moderating'] . '</b></i>';
			if (can_moderate($forumid) AND $threadtitle AND $canview AND ($canviewothers OR $postuserid == $vbulletin->userinfo['userid']))
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
				switch ($userinfo['values']['do'])
				{
					case 'editthread':
					case 'updatethread':
						$userinfo['action'] = '<i>' . $vbphrase['modifying_thread'] . '</i>';
						break;
					case 'openclosethread':
						$userinfo['action'] = '<i>' . $vbphrase['open_close_thread'] . '</i>';
						break;
					case 'movethread':
						$userinfo['action'] = '<i>' .$vbphrase['choosing_forum_to_move_thread_to'] . '</i>';
						break;
					case 'domovethread':
						switch($userinfo['values']['method'])
						{
							case 'copy':
								$userinfo['action'] = '<i>' . $vbphrase['copying_thread_to_forum'] . '</i>';
								break;
							case 'move':
								$userinfo['action'] = '<i>' . $vbphrase['moving_thread_to_forum'] . '</i>';
								break;
							case 'movered':
								$userinfo['action'] = '<i>' . $vbphrase['moving_thread_with_redirect_to_forum'] . '</i>';
								break;
						}
						$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a><br />" .
										'<a href="forumdisplay.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumid\">$forumtitle</a>";
						break;
					case 'deletethread':
					case 'dodeletethread':
						$userinfo['action'] = '<i>' . $vbphrase['deleting_thread'] . '</i>';
						break;
					case 'deleteposts':
					case 'dodeleteposts':
						$userinfo['where'] = '<i>' . $vbphrase['deleting_posts'] . '</i>';
						break;
					case 'merge':
					case 'domergethread':
						$userinfo['where'] = '<i>' . $vbphrase['merging_threads'] . '</i>';
						break;
					case 'split':
					case 'dosplitthread':
						$userinfo['where'] = '<i>' . $vbphrase['splitting_thread'] . '</i>';
						break;
					case 'stick':
						$userinfo['where'] = '<i>' . $vbphrase['stick_unstick_thread'] . '</i>';
						break;
					case 'getip':
						$userinfo['where'] = '<i>' . $vbphrase['viewing_ip_address'] . '</i>';
						break;
					case 'removeredirect':
						$userinfo['where'] = '<i>' . $vbphrase['deleting_redirect'] . '</i>';
						break;
				}
			}
			break;
		case 'register':
			$userinfo['action'] = $vbphrase['registering'];
			break;
		case 'requestemail':
			$userinfo['action'] = $vbphrase['request_activation_code'];
			break;
		case 'activate':
			$userinfo['action'] = $vbphrase['activating_registration'];
			break;
		case 'announcement':
			$userinfo['action'] = $vbphrase['viewing_announcement'];
			if ($seeforum)
			{
				$userinfo['where'] = '<a href="announcement.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumid\">$forumtitle</a>";
			}
			break;
		case 'usergroup':
			$userinfo['action'] = $vbphrase['modifying_usergroups'];
			break;
		case 'polls':
			switch ($userinfo['values']['do'])
			{
				case 'showresults':
					$userinfo['action'] = $vbphrase['viewing_poll'];
					break;
				case '':
				case 'newpoll':
				case 'postpoll':
					$userinfo['action'] = $vbphrase['creating_poll'];
					if ($seeforum)
					{
						$userinfo['where'] = '<a href="forumdisplay.php?' . $vbulletin->session->vars['sessionurl'] . "f=$forumid\">$forumtitle</a>";
					}
					break;
				case 'polledit':
				case 'updatepoll':
					$userinfo['action'] = $vbphrase['modifying_poll'];
					break;
				case 'pollvote':
					$userinfo['action'] = $vbphrase['voting'];
					break;
			}
			break;
		case 'showsmilies':
			$userinfo['action'] = $vbphrase['viewing_smilies'];
			break;
		case 'showavatars':
			$userinfo['action'] = $vbphrase['viewing_avatars'];
			break;
		case 'bbcode':
			$userinfo['action'] = $vbphrase['viewing_bb_code'];
			break;
		case 'faq':
			$userinfo['action'] = $vbphrase['viewing_faq'];
			break;
		case 'edit':
			$userinfo['action'] = $vbphrase['modifying_post'];
			if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull'] AND $seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "p=$postid#postid=$postid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'sendto':
			$userinfo['action'] = $vbphrase['sending_thread_to_friend'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="printthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'contactus':
			$userinfo['action'] = $vbphrase['sending_forum_feedback'];
			break;
		case 'aim':
			$userinfo['action'] = $vbphrase['sending_aim_message'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'msn':
			$userinfo['action'] = $vbphrase['sending_msn_message'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'yahoo':
			$userinfo['action'] = $vbphrase['sending_yahoo_message'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'icq':
			$userinfo['action'] = $vbphrase['sending_icq_message'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="member.php?' . $vbulletin->session->vars['sessionurl'] . "u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'report':
			if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull'] AND $seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "p=$postid#postid=$postid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			$userinfo['action'] = $vbphrase['reporting_post'];
			break;
		case 'printthread':
			$userinfo['action'] = $vbphrase['viewing_printable_version'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="printthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'calendarweek':
			$userinfo['action'] = $vbphrase['viewing_calendar'];
			if ($seecalendar)
			{
				if ($userinfo['week'])
				{
					$week = "&amp;week=$userinfo[week]";
				}
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=displayweek&amp;c=$calendarid$week\">$calendartitle</a>";

			}
			break;
		case 'calendarmonth';
			$userinfo['action'] = $vbphrase['viewing_calendar'];
			if ($seecalendar)
			{
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=displaymonth&amp;c=$calendarid&amp;month=$userinfo[month]&amp;year=$userinfo[year]\">$calendartitle</a>";
			}
			break;
		case 'calendaryear';
			$userinfo['action'] = $vbphrase['viewing_calendar'];
			if ($seecalendar)
			{
				if ($userinfo['year'])
				{
					$year = "&amp;year=$userinfo[year]";
				}
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=displayyear&amp;c=$calendarid$year\">$calendartitle</a>";
			}
			break;
		case 'calendarday':
			$userinfo['action'] = $vbphrase['viewing_calendar'];
			if ($seecalendar)
			{
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getday&amp;c=$calendarid&amp;day=$userinfo[day]\">$calendartitle</a>";
			}
			break;
		case 'calendarevent':
			$userinfo['action'] = $vbphrase['viewing_event'];
			if ($seeevent)
			{
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;e=$eventid\">$eventtitle</a>";
			}
			break;
		case 'calendaradd':
		case 'calendaraddrecur':
			$userinfo['action'] = $vbphrase['creating_event'];
			if ($seecalendar)
			{
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "c=$calendarid\">$calendartitle</a>";
			}
			break;
		case 'calendaredit':
			$userinfo['action'] = $vbphrase['modifying_event'];
			if ($seeevent)
			{
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;e=$eventid\">$eventtitle</a>";
			}
			break;
		case 'calreminder':
			$userinfo['action'] = $vbphrase['managing_reminder'];
			if ($seeevent)
			{
				$userinfo['where'] = '<a href="calendar.php?' . $vbulletin->session->vars['sessionurl'] . "do=getinfo&amp;e=$eventid\">$eventtitle</a>";
			}
			break;
		case 'newusernote':
			$userinfo['action'] = $vbphrase['creating_user_note'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="usernote.php?' . $vbulletin->session->vars['sessionurl'] . "do=viewuser&amp;u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'usernote':
			$userinfo['action'] = $vbphrase['viewing_user_note'];
			if ($seeuserid)
			{
				$userinfo['where'] = '<a href="usernote.php?' . $vbulletin->session->vars['sessionurl'] . "do=viewuser&amp;u=$seeuserid\">$wol_user[$seeuserid]</a>";
			}
			break;
		case 'reputation':
			$userinfo['action'] = $vbphrase['giving_reputation'];
			if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull'] AND $seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'joinrequests':
			$userinfo['action'] = $vbphrase['processing_joinrequests'];
			if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull'] AND $vbulletin->usergroupcache["$userinfo[usergroupid]"]['title'])
			{
				$userinfo['where'] = construct_phrase($vbphrase['viewing_x'], $vbulletin->usergroupcache["$userinfo[usergroupid]"]['title']);
			}
			break;
		case 'threadrate':
			$userinfo['action'] = $vbphrase['rating_thread'];
			if ($seetitle)
			{
				$userinfo['where'] = '<a href="showthread.php?' . $vbulletin->session->vars['sessionurl'] . "t=$threadid\" title=\"$threadpreview\">$threadtitle</a>";
			}
			break;
		case 'payments':
			$userinfo['action'] = $vbphrase['viewing_paid_subscriptions'];
			break;
		case 'chat':
			$userinfo['action'] = $vbphrase['chat'];
			break;
		case 'gallery':
			$userinfo['action'] = $vbphrase['viewing_gallery'];
			break;
		case 'spider':
			$userinfo['action'] = $vbphrase['search_engine_spider'];
			break;
		case 'admincp':
			$userinfo['action'] = $vbphrase['admin_control_panel'];
			break;
		case 'admincplogin':
			$userinfo['action'] = $vbphrase['admin_control_panel_login'];
			break;
		case 'modcp':
			$userinfo['action'] = $vbphrase['moderator_control_panel'];
			break;
		case 'modcplogin':
			$userinfo['action'] = $vbphrase['moderator_control_panel_login'];
			break;
		case 'bugs':
			$userinfo['action'] = construct_phrase($vbphrase['viewing_x'], 'Bugs'); // Don't report 'bugs' as needing to be translated please :p
			break;
		default:
			$handled = false;
			($hook = vBulletinHook::fetch_hook('online_location_unknown')) ? eval($hook) : false;

			if ($handled == false)
			{
				if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinebad'])
				{
					require_once(DIR . '/includes/functions_login.php');
					$userinfo['location'] = fetch_replaced_session_url(stripslashes($userinfo['location']));
					$userinfo['where'] = "<a href=\"$userinfo[location]\">$userinfo[location]</a>";
					$userinfo['action'] = '<b>' . $vbphrase['unknown_location'] . '</b>';
				}
				else
				{
					// We were unable to parse the location
					$userinfo['action'] = $vbphrase['viewing_index'];
					$userinfo['where'] = '<a href="' . $vbulletin->options['forumhome'] . '.php' . $vbulletin->session->vars['sessionurl_q'] . '">' . $vbulletin->options['bbtitle'] . "</a>";
				}
			}
	}

	if ($userinfo['badlocation'] == 1)
	{ // User received 'no permissions screen'
		if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinebad'])
		{
			$show['nopermission'] = true;
		}
		else
		{
			$userinfo['action'] = $vbphrase['viewing_index'];
			$userinfo['where'] = '<a href="' . $vbulletin->options['forumhome'] . '.php' . $vbulletin->session->vars['sessionurl_q'] . '">' . $vbulletin->options['bbtitle'] . "</a>";
		}
	}
	else if ($userinfo['badlocation'] == 2)
	{ // Forum is locked
		$show['lockedout'] = true;
	}
	else if ($userinfo['badlocation'] == 3)
	{ // User received error screen
		if ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinebad'])
		{
			$show['errormessage'] = true;
		}
		else
		{
			$userinfo['action'] = $vbphrase['viewing_index'];
			$userinfo['where'] = '<a href="' . $vbulletin->options['forumhome'] . '.php' . $vbulletin->session->vars['sessionurl_q'] . '">' . $vbulletin->options['bbtitle'] . "</a>";
		}
	}
	if (!($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinelocation']))
	{
		unset($userinfo['location']);
	}

	if ($vbulletin->options['yestoday'] == 2)
	{
		$userinfo['time'] = vbdate($vbulletin->options['dateformat'], $userinfo['lastactivity'], 1);
	}
	else
	{
		$userinfo['time'] = vbdate($vbulletin->options['timeformat'], $userinfo['lastactivity']);
	}
	$wol_post['userid'] = $userinfo['userid'];
	$wol_post['username'] = $userinfo['realname'];

	($hook = vBulletinHook::fetch_hook('online_bit_complete')) ? eval($hook) : false;

	if ($doall)
	{
		$show['loggedinuser'] = iif($userinfo['userid'], true, false);
		$show['buddy'] = iif($userinfo['buddy'], true, false);
		if ($userinfo['spider'])
		{
			$show['spider'] = true;
			if (!$userinfo['spidertype'] OR !($spidertype = construct_phrase($vbphrase["x_spider_{$userinfo['spidertype']}"], $userinfo['spider'])))
			{
				$spidertype = construct_phrase($vbphrase['x_spider_searchspider'], $userinfo['spider']);
			}
		}
		else
		{
			$show['spider'] = false;
		}

		$show['reallocation'] = iif($userinfo['location'], true, false);
		$show['subscribed'] = iif($wol_thread["$threadid"]['issubscribed'] AND $seetitle, true, false);
		$show['where'] = iif($userinfo['where'], true, false);

		eval('$onlinebits = "' . fetch_template('whosonlinebit') . '";');
		return $onlinebits;
	}
	else
	{
		return $userinfo;
	}
}

// ###################### Start whereonline #######################
function process_online_location($userinfo, $doall = 0)
{

	global $threadids, $postids, $forumids, $eventids, $userids, $calendarids, $attachmentids, $pmids, $searchids, $vbulletin;
	global $limitlower, $limitupper;

	static $count;

	$count++;

	if ($doall == 1 AND ($count > $limitupper OR $count < $limitlower))
	{
		return $userinfo;
	}

	$loc = str_replace('&amp;', '&', $userinfo['location']);
	$loc = preg_replace('/\?s=[a-z0-9]{32}(&)?/', '?', $loc);
	if ($loc == $userinfo['location'])
	{
		$loc = preg_replace('/\?s=(&)?/', '?', $loc);
	}
	if ($loc == $userinfo['location'])
	{
		$loc = preg_replace('/&s=[a-z0-9]{32}/', '', $loc);
	}
	if ($loc == $userinfo['location'])
	{
		$loc = preg_replace('/&s=/', '', $loc);
	}

	if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
	{
		$filename = strtolower(strtok($loc, '?'));
	}
	else
	{
		$filename = strtok($loc, '?');
	}
	$token = $filename;
	$pos = @strrpos ($filename, '/');
	if (!is_string($pos) OR $pos)
	{
		$filename = substr($filename, $pos + 1);
	}

	DEVDEBUG("\$filename = $filename");

	if (strpos($token, '/' . $vbulletin->config['Misc']['admincpdir'] . '/') !== false)
	{
		if ($filename == '' OR $filename == 'index.php')
		{
			$userinfo['activity'] = 'admincplogin';
		}
		else
		{
			$userinfo['activity'] = 'admincp';
		}
		return $userinfo;
	}
	else if (strpos($token, '/archive/index.php') !== false)
	{
		$filename = 'archive';
		$endbit = substr (strrchr($token, '/') , 1);
		if ($endbit != '' AND $endbit != 'index.php')
		{
			$loc = 'archive?' . str_replace(array('f', 't', 'p', '-'), array('forumid', 'threadid', 'pagenumber', '='), $endbit);
			$filename = strtok($loc, '?');
			$token = $filename;
		}
	}
	else if (strpos($token, '/' . $vbulletin->config['Misc']['modcpdir'] . '/') !== false)
	{
		if ($filename == '' OR $filename == 'index.php')
		{
			$userinfo['activity'] = 'modcplogin';
		}
		else
		{
			$userinfo['activity'] = 'modcp';
		}
		return $userinfo;
	}

	unset($values);
	while ($token !== false)
	{
		$token = strtok('&');
		$parts = explode('=', $token);
		if (!empty($parts[1]))
		{
			$values["$parts[0]"] = $parts[1];
		}
	}

	$vbulletin->input->convert_shortvars($values);

	($hook = vBulletinHook::fetch_hook('online_location_preprocess')) ? eval($hook) : false;

	$userinfo['values'] = $values;

	if (!empty($values['searchid']))
	{
		$userinfo['searchid'] = intval($values['searchid']);
		$searchids .= ',' . $userinfo['searchid'];
	}
	if (!empty($values['threadid']))
	{
		$userinfo['threadid'] = intval($values['threadid']);
		$threadids .= ',' . $userinfo['threadid'];
	}
	if (!empty($values['postid']))
	{
		$userinfo['postid'] = intval($values['postid']);
		$postids .= ',' . $userinfo['postid'];
	}
	if (!empty($values['forumid']))
	{
		$userinfo['forumid'] = intval($values['forumid']);
		$forumids .= ',' . $userinfo['forumid'];
	}
	if (!empty($values['eventid']))
	{
		$userinfo['eventid'] = intval($values['eventid']);
		$eventids .= ',' . $userinfo['eventid'];
	}
	$values['calendarid'] = $userinfo['incalendar'];
	if (!empty($values['calendarid']))
	{
		$userinfo['calendarid'] = intval($values['calendarid']);
		$calendarids .= ',' . $userinfo['calendarid'];
	}
	if (!empty($values['userid']))
	{
		$userinfo['targetuserid'] = intval($values['userid']);
		$userids .= ',' . $userinfo['targetuserid'];
	}
	if (!empty($values['pmid']))
	{
		$userinfo['pmid'] = intval($values['pmid']);
		$pmids .= ',' . $userinfo['pmid'];
	}
	if (!empty($values['attachmentid']))
	{
		$userinfo['attachmentid'] = intval($values['attachmentid']);
		$attachmentids .= ',' . $userinfo['attachmentid'];
	}
	if (!empty($values['usergroupid']))
	{
		$userinfo['usergroupid'] = intval($values['usergroupid']);
	}

// ################################################## Showthread
	switch($filename)
	{
	case 'login.php':
		if (in_array($values['do'], array('lostpw', 'emailpassword', 'resetpassword')))
		{
			$userinfo['activity'] = 'lostpw';
		}
		else
		{
			$userinfo['activity'] = 'login';
		}
		break;
	case 'showpost.php':
		$userinfo['activity'] = 'showpost';
		break;
	case 'showthread.php':
		if (isset($values['goto']) AND $values['goto'] == 'lastpost')
		{
			$userinfo['activity'] = 'forumdisplay';
		}
		else
		{
			$userinfo['activity'] = 'showthread';
		}
		break;

	case 'forumdisplay.php':
		$userinfo['activity'] = 'forumdisplay';
		break;

	case 'attachment.php':
		$userinfo['activity'] = 'attachment';
		break;

	case '/':
	case '':
	case 'cron.php': // this shouldn't occur but just to be sane
	case $vbulletin->options['forumhome'] . '.php':
		$userinfo['activity'] = 'index';
		break;

	case 'online.php':
		$userinfo['activity'] = 'online';
		break;

	case 'search.php':
		if ($values['getnew'] == 'true')
		{
			$userinfo['activity'] = 'searchnew';
		}
		else
		{
			$userinfo['activity'] = 'search';
		}
		break;

	case 'newreply.php':
		$userinfo['activity'] = 'newreply';
		break;

	case 'newattachment.php':
		$userinfo['activity'] = 'manageattachment';
		break;

	case 'newthread.php':
		$userinfo['activity'] = 'newthread';
		break;

	case 'sendmessage.php':
		if ($values['do'] == 'mailmember' OR $values['do'] == 'domailmember')
		{
			$userinfo['activity'] = 'mail';
		}
		else if ($values['do'] == '' OR $values['do'] == 'contactus' OR $values['do'] == 'docontactus')
		{
			$userinfo['activity'] = 'contactus';
		}
		else if ($values['do'] == 'sendtofriend' OR $values['do'] == 'dosendtofriend')
		{
			$userinfo['activity'] = 'sendto';
		}
		else if ($values['do'] == 'im')
		{
			switch($values['type'])
			{
				case 'aim':
					$userinfo['activity'] = 'aim';
					break;
				case 'icq':
					$userinfo['activity'] = 'icq';
					break;
				case 'yahoo':
					$userinfo['activity'] = 'yahoo';
					break;
				case 'msn':
				case '':
					$userinfo['activity'] = 'msn';
					break;
			}
		}
		break;

	case 'profile.php':
		if ($values['do'] == 'editprofile' OR $values['do'] == 'updateprofile')
		{
			$userinfo['activity'] = 'editprofile';
		}
		else if ($values['do'] == 'editoptions' OR $values['do'] = 'updateoptions')
		{
			$userinfo['activity'] = 'editoptions';
		}
		else if ($values['do'] == 'editpassword' OR $values['do'] == 'updatepassword')
		{
			$userinfo['activity'] = 'editpassword';
		}
		else if ($values['do'] == 'editsignature' OR $values['do'] == 'updatesignature')
		{
			$userinfo['activity'] = 'editsignature';
		}
		else if ($values['do'] == 'editavatar' OR $values['do'] == 'updateavatar')
		{
			$userinfo['activity'] = 'editavatar';
		}
		else if ($values['do'] == 'editprofilepic' OR $values['do'] == 'updateprofilepic')
		{
			$userinfo['activity'] = 'editprofilepic';
		}
		else if ($values['do'] == 'markread')
		{
			$userinfo['activity'] = 'markread';
		}
		else if ($values['do'] == 'editusergroups' OR $values['do'] == 'leavegroup' OR $values['do'] == 'joingroup')
		{
			// Need to modify the joingroup action to support detailed information on the group being joined for admins
			$userinfo['activity'] = 'usergroup';
		}
		else if (in_array($values['do'], array('editlist', 'updatelist', 'removelist', 'doremovelist')))
		{
			$userinfo['activity'] = 'buddyignore';
		}
		else if (in_array($values['do'], array('addlist', 'doaddlist')))
		{
			if ($values['userlist'] == 'ignore')
			{
				$userinfo['activity'] = 'addignore';
			}
			else if ($values['userlist'] == 'buddy')
			{
				$userinfo['activity'] = 'addbuddy';
			}
		}
		else if ($values['do'] == 'editattachments' OR $values['do'] == 'deleteattachments')
		{
			$userinfo['activity'] = 'attachments';
		}
		else
		{
			$userinfo['activity'] = 'usercp';
		}
		break;

	case 'member.php':
		$userinfo['activity'] = 'getinfo';
		break;

	case 'showgroups.php':
		$userinfo['activity'] = 'showgroups';
		break;

	case 'editpost.php':
		$userinfo['activity'] = 'edit';
		break;

	case 'private.php':
		$userinfo['activity'] = 'pm';
		$userinfo['pmid'] = $values['pmid'];
		break;

	case 'subscription.php':
		if ($values['do'] == 'viewsubscription' OR $values['do'] == 'dostuff' OR $values['do'] == '')
		{
			$userinfo['activity'] = 'subscription';
		}
		else if ($values['do'] == 'addsubscription')
		{
			if (isset($values['threadid']))
			{
				$userinfo['activity'] = 'addsubthread';
			}
			else
			{
				$userinfo['activity'] = 'addsubforum';
			}
		}
		else if ($values['do'] == 'removesubscription' OR $values['do'] == 'usub')
		{
			if ($values['type'] == 'allthread')
			{
				$userinfo['activity'] = 'remsubthread';
			}
			else
			{
				$userinfo['activity'] = 'remsubforum';
			}
		}
		else if ($values['do'] == 'editfolders' OR $values['do'] == 'doeditfolders')
		{
			$userinfo['activity'] = 'subfolders';
		}
		break;

	case 'payments.php':
		$userinfo['activity'] = 'payments';
		break;

	case 'misc.php':
		if ($values['do'] == 'showsmilies' OR $values['do'] == 'getsmilies')
		{
			$userinfo['activity'] = 'showsmilies';
		}
		else if ($values['do'] == 'showavatars')
		{
			$userinfo['activity'] = 'showavatars';
		}
		else if ($values['do'] == 'bbcode')
		{
			$userinfo['activity'] = 'bbcode';
		}
		else if ($values['do'] == 'whoposted')
		{
			$userinfo['activity'] = 'whoposted';
		}
		else
		{
			$userinfo['activity'] = 'index'; // where are they?
		}
		break;

	case 'poll.php':
		$userinfo['activity'] = 'polls';
		break;

	case 'postings.php':
		$userinfo['activity'] = 'postings';
		break;

	case 'inlinemod.php':
		$userinfo['activity'] = 'inlinemod';
		break;

	case 'memberlist.php':
		if ($values['do'] == 'search' OR $values['do'] == 'getall')
		{
			$userinfo['activity'] = 'memberlistsearch';
		}
		else
		{
			$userinfo['activity'] = 'memberlist';
		}
		break;

	case 'register.php':
		if ($values['do'] == 'requestemail' OR $values['do'] == 'emailcode')
		{
			$userinfo['activity'] = 'requestemail';
		}
		else if ($values['a'] == 'ver' OR $values['do'] == 'activate' OR $values['a'] == 'act')
		{
			$userinfo['activity'] = 'activate';
		}
		else
		{
			$userinfo['activity'] = 'register';
		}
		break;

	case 'usercp.php':
		$userinfo['activity'] = 'usercp';
		break;

	case 'calendar.php':
		if (empty($values['do']) OR $values['do'] == 'displayweek')
		{
			$userinfo['activity'] = 'calendarweek';
			$userinfo['week'] = $values['week'];
		}
		else if ($values['do'] == 'displaymonth')
		{
			$userinfo['month'] = $values['month'];
			$userinfo['year'] = $values['year'];
			$userinfo['activity'] = 'calendarmonth';
		}
		else if ($values['do'] == 'displayyear')
		{
			$userinfo['activity'] = 'calendaryear';
			$userinfo['year'] = $values['year'];
		}
		else if ($values['do'] == 'getday')
		{
			$userinfo['activity'] = 'calendarday';
			$userinfo['day'] = $values['day'];
		}
		else if ($values['do'] == 'getinfo')
		{
			$userinfo['activity'] = 'calendarevent';
		}
		else if ($values['do'] == 'add')
		{
			if ($values['recur'])
			{
				$userinfo['activity'] = 'calendaraddrecur';
			}
			else
			{
				$userinfo['activity'] = 'calendaradd';
			}
		}
		else if ($values['do'] == 'edit')
		{
			$userinfo['activity'] = 'calendaredit';
		}
		else if ($values['do'] == 'viewreminder' OR $values['do'] == 'addreminder' OR $values['do'] == 'dodeletereminder' OR $values['do'] == 'deletereminder')
		{
			$userinfo['activity'] = 'calreminder';
		}
		break;

	case 'moderator.php':
		switch($values['do'])
		{
			case 'useroptions':
			case 'move':
			case 'prune':
				$userinfo['activity'] = 'admincp';
				break;
			case 'modposts':
			case 'modattach':
				$userinfo['activity'] = 'modcp';
		}
		break;

	case 'usernote.php':
		if ($values['do'] == 'newnote')
		{
			$userinfo['activity'] = 'newusernote';
		}
		else
		{
			$userinfo['activity'] = 'usernote';
		}
		break;

	case 'reputation.php':
		$userinfo['activity'] = 'reputation';
		break;

	case 'faq.php':
		$userinfo['activity'] = 'faq';
		break;

	case 'announcement.php':
		$userinfo['activity'] = 'announcement';
		break;

	case 'report.php':
		$userinfo['activity'] = 'report';
		break;

	case 'joinrequests.php':
		$userinfo['activity'] = 'joinrequests';
		break;

	case 'threadrate.php':
		$userinfo['activity'] = 'threadrate';
		break;

	case 'printthread.php':
		$userinfo['activity'] = 'printthread';
		break;

	case 'archive':
		$userinfo['activity'] = 'archive';
		break;

	case 'chat.php':
		$userinfo['activity'] = 'chat';
		break;

	case 'gallery.php':
		$userinfo['activity'] = 'gallery';
		break;

	case '/robots.txt':
		$userinfo['activity'] = 'spider';
		break;

	case 'bugs.php':
		$userinfo['activity'] = 'bugs';
		break;

	default:
		$userinfo['activity'] = 'unknown';
		($hook = vBulletinHook::fetch_hook('online_location_process')) ? eval($hook) : false;
	}

	return $userinfo;
}

// ###################### Start getidsonline #######################
function convert_ids_to_titles()
{

	global $vbulletin, $threadids, $forumids, $eventids, $userids, $calendarids, $postids, $pmids, $attachmentids;
	global $wol_attachment, $wol_user, $wol_thread, $wol_post, $wol_event, $wol_calendar, $wol_pm, $vbulletin;
	global $searchids, $wol_search;

	if ($attachmentids)
	{
		$postidquery = $vbulletin->db->query_read("
			SELECT postid, attachmentid
			FROM " . TABLE_PREFIX . "attachment
			WHERE attachmentid IN (0$attachmentids)
		");
		while ($postidqueryr = $vbulletin->db->fetch_array($postidquery))
		{
			$postids .= ',' . $postidqueryr['postid'];
			$wol_attachment["$postidqueryr[attachmentid]"] = $postidqueryr['postid'];
		}
	}

	if ($postids)
	{
		$postidquery = $vbulletin->db->query_read("
			SELECT threadid, postid
			FROM " . TABLE_PREFIX . "post
			WHERE postid IN (0$postids)
		");
		while ($postidqueryr = $vbulletin->db->fetch_array($postidquery))
		{
			$threadids .= ',' . $postidqueryr['threadid'];
			$wol_post["$postidqueryr[postid]"] = $postidqueryr['threadid'];
		}
	}

	if ($threadids)
	{
		$threadresults = $vbulletin->db->query_read("
			SELECT thread.title, thread.threadid, thread.forumid, thread.postuserid, thread.visible
			" . iif($vbulletin->options['threadpreview'] > 0, ",post.pagetext AS preview") . "
			" . iif($vbulletin->options['threadsubscribed'] AND $vbulletin->userinfo['userid'], ", NOT ISNULL(subscribethread.subscribethreadid) AS issubscribed") . "
			FROM " . TABLE_PREFIX . "thread AS thread
			" . iif($vbulletin->options['threadpreview'] > 0, "LEFT JOIN " . TABLE_PREFIX . "post AS post ON(post.postid = thread.firstpostid)") . "
			" . iif($vbulletin->options['threadsubscribed'] AND $vbulletin->userinfo['userid'], " LEFT JOIN " . TABLE_PREFIX . "subscribethread AS subscribethread ON(subscribethread.threadid = thread.threadid AND subscribethread.userid = " . $vbulletin->userinfo['userid'] . ")") . "
			WHERE thread.threadid IN (0$threadids)
		");
		while ($threadresult = $vbulletin->db->fetch_array($threadresults))
		{
			$wol_thread["$threadresult[threadid]"]['title'] = $threadresult['title'];
			$wol_thread["$threadresult[threadid]"]['forumid'] = $threadresult['forumid'];
			$wol_thread["$threadresult[threadid]"]['postuserid'] = $threadresult['postuserid'];
			$wol_thread["$threadresult[threadid]"]['isdeleted'] = ($threadresult['visible'] == 2) ? true : false;
			$wol_thread["$threadresult[threadid]"]['visible'] = ($threadresult['visible'] == 1) ? true : false;
			$wol_thread["$threadresult[threadid]"]['issubscribed'] = $threadresult['issubscribed'];

			// format thread preview if there is one
			$userperms = fetch_permissions($threadresult['forumid']);
			if (!empty($threadresult['preview']) AND $vbulletin->options['threadpreview'] > 0 AND ($userperms & $vbulletin->bf_ugp_forumpermissions['canviewthreads']))
			{
				// Get Buddy List
				$buddy = array();
				if (trim($vbulletin->userinfo['buddylist']))
				{
					$buddylist = preg_split('/( )+/', trim($vbulletin->userinfo['buddylist']), -1, PREG_SPLIT_NO_EMPTY);
					foreach ($buddylist AS $buddyuserid)
					{
						$buddy["$buddyuserid"] = 1;
					}
				}
				DEVDEBUG('buddies: ' . implode(', ', array_keys($buddy)));
				// Get Ignore Users
				$ignore = array();
				if (trim($vbulletin->userinfo['ignorelist']))
				{
					$ignorelist = preg_split('/( )+/', trim($vbulletin->userinfo['ignorelist']), -1, PREG_SPLIT_NO_EMPTY);
					foreach ($ignorelist AS $ignoreuserid)
					{
						if (!$buddy["$ignoreuserid"])
						{
							$ignore["$ignoreuserid"] = 1;
						}
					}
				}
				DEVDEBUG('ignored users: ' . implode(', ', array_keys($ignore)));

				if (!$ignore["$threadresult[postuserid]"])
				{
					$threadresult['preview'] = strip_quotes($threadresult['preview']);
					$threadresult['preview'] = htmlspecialchars_uni(strip_bbcode(fetch_trimmed_title($threadresult['preview'], $vbulletin->options['threadpreview']), false, true));
					$wol_thread["$threadresult[threadid]"]['preview'] = $threadresult['preview'];
				}
			}
		}
	}

	if ($calendarids)
	{
		$calendarresults = $vbulletin->db->query_read("
			SELECT calendarid, title
			FROM " . TABLE_PREFIX . "calendar
			WHERE calendarid IN (0$calendarids)
		");
		while ($calendarresult = $vbulletin->db->fetch_array($calendarresults))
		{
			$wol_calendar["$calendarresult[calendarid]"] = $calendarresult['title'];
		}
	}

	if ($eventids)
	{
		$eventresults = $vbulletin->db->query_read("
			SELECT eventid, title, userid, calendarid
			FROM " . TABLE_PREFIX . "event
			WHERE eventid IN (0$eventids)
		");
		while ($eventresult = $vbulletin->db->fetch_array($eventresults))
		{
			$wol_event["$eventresult[eventid]"]['title'] = $eventresult['title'];
			$wol_event["$eventresult[eventid]"]['calendarid'] = $eventresult['calendarid'];
			$wol_event["$eventresult[eventid]"]['postuserid'] = $eventresult['userid'];
		}
	}

	if ($pmids AND ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull']))
	{
		$pmresults = $vbulletin->db->query_read("
			SELECT pmtext.fromuserid, pm.pmid
			FROM " . TABLE_PREFIX . "pm AS pm
			LEFT JOIN " . TABLE_PREFIX . "pmtext AS pmtext ON (pm.pmtextid = pmtext.pmtextid)
			WHERE pmid IN (0$pmids)
			");
		while ($pmresult = $vbulletin->db->fetch_array($pmresults))
		{
			$wol_pm["$pmresult[pmid]"] = $pmresult['fromuserid'];

			$userids .= ',' . intval($pmresult['fromuserid']);
		}
	}

	if ($searchids AND ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull']))
	{
		$searchresults = $vbulletin->db->query_read("
			SELECT searchid, search.userid, query, searchuser, user.userid AS targetuserid
			FROM " . TABLE_PREFIX . "search AS search
			LEFT JOIN " . TABLE_PREFIX . "user AS user ON (user.username = search.searchuser)
			WHERE searchid IN (0$searchids)
		");
		while ($searchresult = $vbulletin->db->fetch_array($searchresults))
		{
			if ($searchresult['searchuser'])
			{
				if (!$searchresult['targetuserid']) // usernames are stored straight in search and htmlspecialchars_uni in user so we have to query for any non-matches
				{
					$result = $vbulletin->db->query_first("
						SELECT userid AS targetuserid
						FROM " . TABLE_PREFIX . "user
						WHERE username = '" . $vbulletin->db->escape_string(htmlspecialchars_uni($searchresult['searchuser'])) . "'
					");
				}
				if ($result['targetuserid'])
				{
					$searchresult['targetuserid'] = $result['targetuserid'];
				}
				if ($searchresult['targetuserid'])
				{
					$userids .= ",$searchresult[targetuserid]";
				}
			}
			$wol_search["$searchresult[searchid]"] = $searchresult;
		}
	}

	if ($userids AND ($vbulletin->userinfo['permissions']['wolpermissions'] & $vbulletin->bf_ugp_wolpermissions['canwhosonlinefull']))
	{
		$userresults = $vbulletin->db->query_read("
			SELECT userid, username, IF(displaygroupid=0, user.usergroupid, displaygroupid) AS displaygroupid
			FROM " . TABLE_PREFIX . "user AS user
			WHERE userid IN (0$userids)
		");
		while ($userresult = $vbulletin->db->fetch_array($userresults))
		{
			$wol_user["$userresult[userid]"] = fetch_musername($userresult);
		}
	}
}

// ###################### Start sanitize_perpage #######################
function sanitize_perpage($perpage, $max, $default = 25)
{
	$perpage = intval($perpage);

	if ($perpage == 0)
	{
		return $default;
	}
	else if ($perpage < 1)
	{
		return 1;
	}
	else if ($perpage > $max)
	{
		return $max;
	}
	else
	{
		return $perpage;
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: functions_online.php,v $ - $Revision: 1.215 $
|| ####################################################################
\*======================================================================*/
?>