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

error_reporting(E_ALL & ~E_NOTICE);

// ###################### Start doipaddress #######################
function construct_ip_usage_table($ipaddress, $prevuserid, $depth = 1)
{
	global $vbulletin, $vbphrase;

	$depth--;

	if (VB_AREA == 'AdminCP')
	{
		$userscript = 'usertools.php';
	}
	else
	{
		$userscript = 'user.php';
	}

	$users = $vbulletin->db->query_read("
		SELECT DISTINCT user.userid, user.username, post.ipaddress
		FROM " . TABLE_PREFIX . "post AS post,
		" . TABLE_PREFIX . "user AS user
		WHERE user.userid = post.userid AND
			post.ipaddress LIKE '" . $vbulletin->db->escape_string_like($ipaddress) . "%' AND
			post.ipaddress <> '' AND
			user.userid <> $prevuserid
		ORDER BY user.username
	");
	$retdata = '';
	while ($user = $vbulletin->db->fetch_array($users))
	{
		$retdata .= '<li>' .
			"<a href=\"user.php?" . $vbulletin->session->vars['sessionurl'] . "do=" . iif(VB_AREA == 'ModCP', 'viewuser', 'edit') . "&amp;u=$user[userid]\"><b>$user[username]</b></a> &nbsp;
			<a href=\"$userscript?" . $vbulletin->session->vars['sessionurl'] . "do=gethost&amp;ip=$user[ipaddress]\" title=\"" . $vbphrase['resolve_address'] . "\">$user[ipaddress]</a> &nbsp; " .
			construct_link_code($vbphrase['find_posts_by_user'], "../search.php?" . $vbulletin->session->vars['sessionurl'] . "do=finduser&amp;u=$user[userid]") .
			construct_link_code($vbphrase['view_other_ip_addresses_for_this_user'], "$userscript?" . $vbulletin->session->vars['sessionurl'] . "do=doips&amp;u=$user[userid]") .
			"</li>\n";

		if ($depth > 0)
		{
			$retdata .= construct_user_ip_table($user['userid'], $user['ipaddress'], $depth);
		}
	}

	if (empty($retdata))
	{
		return '';
	}
	else
	{
		return '<ul>' . $retdata . '</ul>';
	}
}

// ###################### Start construct_ip_register_table #######################
function construct_ip_register_table($ipaddress, $prevuserid, $depth = 1)
{
	global $vbulletin, $vbphrase;

	$depth--;

	if (VB_AREA == 'AdminCP')
	{
		$userscript = 'usertools.php';
	}
	else
	{
		$userscript = 'user.php';
	}

	$users = $vbulletin->db->query_read("
		SELECT  userid, username, ipaddress
		FROM " . TABLE_PREFIX . "user AS user
		WHERE ipaddress LIKE '" . $vbulletin->db->escape_string_like($ipaddress) . "%' AND
			ipaddress <> '' AND
			userid <> $prevuserid
		ORDER BY username
	");
	$retdata = '';
	while ($user = $vbulletin->db->fetch_array($users))
	{
		$retdata .= '<li>' .
			"<a href=\"user.php?" . $vbulletin->session->vars['sessionurl'] . "do=" . iif(VB_AREA == 'ModCP', 'viewuser', 'edit') . "&amp;u=$user[userid]\"><b>$user[username]</b></a> &nbsp;
			<a href=\"$userscript?" . $vbulletin->session->vars['sessionurl'] . "do=gethost&amp;ip=$user[ipaddress]\" title=\"" . $vbphrase['resolve_address'] . "\">$user[ipaddress]</a> &nbsp; " .
			construct_link_code($vbphrase['find_posts_by_user'], "../search.php?" . $vbulletin->session->vars['sessionurl'] . "do=finduser&amp;u=$user[userid]") .
			construct_link_code($vbphrase['view_other_ip_addresses_for_this_user'], "$userscript?" . $vbulletin->session->vars['sessionurl'] . "do=doips&amp;u=$user[userid]") .
			"</li>\n";

		if ($depth > 0)
		{
			$retdata .= construct_user_ip_table($user['userid'], $user['ipaddress'], $depth);
		}
	}

	if (empty($retdata))
	{
		return '';
	}
	else
	{
		return '<ul>' . $retdata . '</ul>';
	}
}

// ###################### Start douseridip #######################
function construct_user_ip_table($userid, $previpaddress, $depth = 2)
{
	global $vbulletin, $vbphrase;

	if (VB_AREA == 'AdminCP')
	{
		$userscript = 'usertools.php';
	}
	else
	{
		$userscript = 'user.php';
	}

	$depth--;

	$ips = $vbulletin->db->query_read("
		SELECT DISTINCT ipaddress
		FROM " . TABLE_PREFIX . "post
		WHERE userid = $userid AND
		ipaddress <> '" . $vbulletin->db->escape_string($previpaddress) . "' AND
		ipaddress <> ''
		ORDER BY ipaddress
	");
	$retdata = '';
	while ($ip = $vbulletin->db->fetch_array($ips))
	{
		$retdata .= '<li>' .
			"<a href=\"$userscript?" . $vbulletin->session->vars['sessionurl'] . "do=gethost&amp;ip=$ip[ipaddress]\" title=\"" . $vbphrase['resolve_address'] . "\">$ip[ipaddress]</a> &nbsp; " .
			construct_link_code($vbphrase['find_more_users_with_this_ip_address'], "$userscript?" . $vbulletin->session->vars['sessionurl'] . "do=doips&amp;ipaddress=$ip[ipaddress]") .
			"</li>\n";

		if ($depth > 0)
		{
			$retdata .= construct_ip_usage_table($ip['ipaddress'], $userid, $depth);
		}
	}

	if (empty($retdata))
	{
		return '';
	}
	else
	{
		return '<ul>' . $retdata . '</ul>';
	}
}

// ###################### Start makestylecode #######################
function construct_style_chooser($title, $name, $selvalue = -1, $extra = '')
{
	// returns a combo box containing a list of titles in the $tablename table.
	// allows specification of selected value in $selvalue
	global $vbulletin, $bgcounter;
	global $vbphrase;
	$tablename = 'style';

	//echo '<tr class="' . fetch_row_bgclass() . "\">\n<td><p>$title</p></td>\n<td><p><select name=\"$name\" size=\"1\" tabindex=\"1\" class=\"bginput\"" . iif($GLOBALS['debug'], " title=\"name=&quot;$name&quot;\"") . ">\n";
	$tableid = $tablename . "id";

	$result = $vbulletin->db->query_read("
		SELECT title, $tableid
		FROM " . TABLE_PREFIX . "$tablename
		WHERE userselect = 1
		ORDER BY title
	");

	$select = "<select name=\"$name\" size=\"1\" tabindex=\"1\" class=\"bginput\"" . iif($GLOBALS['debug'], " title=\"name=&quot;$name&quot;\"") . ">\n";
	$select .= "<option value=\"0\"" . iif($selvalue == 0, "selected=\"selected\"") . ">$vbphrase[use_forum_default]</option>\n";

	while ($currow = $vbulletin->db->fetch_array($result))
	{

		if ($selvalue == $currow["$tableid"])
		{
			$select .= "<option value=\"$currow[$tableid]\" selected=\"selected\">$currow[title]</option>\n";
		}
		else
		{
			$select .= "<option value=\"$currow[$tableid]\">$currow[title]</option>\n";
		}
	} // while

	if (!empty($extra))
	{
		if ($selvalue == -1)
		{
			$select .= "<option value=\"-1\" selected=\"selected\">$extra</option>\n";
		}
		else
		{
			$select .= "<option value=\"-1\">$extra</option>\n";
		}
	}

	$select .= "</select>\n";

	print_label_row($title, $select, '', 'top', $name);

	return 1;
}

// ###################### Start finduserhtml #######################
function print_user_search_rows($email = false)
{
	global $vbulletin, $vbphrase, $stylevar;

	print_label_row($vbphrase['username'], "
		<input type=\"text\" class=\"bginput\" name=\"user[username]\" tabindex=\"1\" size=\"35\"
		/><input type=\"image\" src=\"../" . $vbulletin->options['cleargifurl'] . "\" width=\"1\" height=\"1\"
		/><input type=\"submit\" class=\"button\" value=\"$vbphrase[exact_match]\" tabindex=\"1\" name=\"user[exact]\" />
	", '', 'top', 'user[username]');

	if ($email)
	{
		global $iusergroupcache;
		$userarray = array('usergroupid' => 0, 'membergroupids' => '');
		$iusergroupcache = array();
		$usergroups = $vbulletin->db->query_read("SELECT usergroupid, title, (forumpermissions & " . $vbulletin->bf_ugp_forumpermissions['canview'] . ") AS CANVIEW FROM " . TABLE_PREFIX . "usergroup ORDER BY title");
		while ($usergroup = $vbulletin->db->fetch_array($usergroups))
		{
			if ($usergroup['CANVIEW'])
			{
				$userarray['membergroupids'] .= "$usergroup[usergroupid],";
			}
			$iusergroupcache["$usergroup[usergroupid]"] = $usergroup['title'];
		}
		unset($usergroup);
		$vbulletin->db->free_result($usergroups);

		print_checkbox_row($vbphrase['all_usergroups'], 'usergroup_all', 0, -1, $vbphrase['all_usergroups'], 'check_all_usergroups(this.form, this.checked);');
		print_membergroup_row($vbphrase['primary_usergroup'], 'user[usergroupid]', 2, $userarray);
		print_yes_no_row($vbphrase['include_users_that_have_declined_email'], 'user[adminemail]', 0);
	}
	else
	{
		print_chooser_row($vbphrase['primary_usergroup'], 'user[usergroupid]', 'usergroup', -1, '-- ' . $vbphrase['all_usergroups'] . ' --');
		print_membergroup_row($vbphrase['additional_usergroups'], 'user[membergroup]', 2);
	}

	print_description_row('<div align="' . $stylevar['right'] .'"><input type="submit" class="button" value=" ' . iif($email, $vbphrase['submit'], $vbphrase['find']) . ' " tabindex="1" /></div>');
	print_input_row($vbphrase['email'], 'user[email]');
	print_input_row($vbphrase['parent_email_address'], 'user[parentemail]');
	print_yes_no_other_row($vbphrase['coppa_user'], 'user[coppauser]', $vbphrase['either'], -1);
	print_input_row($vbphrase['home_page'], 'user[homepage]');
	print_input_row($vbphrase['icq_uin'], 'user[icq]');
	print_input_row($vbphrase['aim_screen_name'], 'user[aim]');
	print_input_row($vbphrase['yahoo_id'], 'user[yahoo]');
	print_input_row($vbphrase['msn_id'], 'user[msn]');
	print_input_row($vbphrase['signature'], 'user[signature]');
	print_input_row($vbphrase['user_title'], 'user[usertitle]');
	print_input_row($vbphrase['join_date_is_after'] . '<dfn>(yyyy-mm-dd)</dfn>', 'user[joindateafter]');
	print_input_row($vbphrase['join_date_is_before'] . '<dfn>(yyyy-mm-dd)</dfn>', 'user[joindatebefore]');
	print_input_row($vbphrase['last_activity_is_after'] . '<dfn>(yyyy-mm-dd hh:mm:ss)</dfn>', 'user[lastactivityafter]');
	print_input_row($vbphrase['last_activity_is_before'] . '<dfn>(yyyy-mm-dd hh:mm:ss)</dfn>', 'user[lastactivitybefore]');
	print_input_row($vbphrase['last_post_is_after'] . '<dfn>(yyyy-mm-dd hh:mm:ss)</dfn>', 'user[lastpostafter]');
	print_input_row($vbphrase['last_post_is_before'] . '<dfn>(yyyy-mm-dd hh:mm:ss)</dfn>', 'user[lastpostbefore]');
	print_input_row($vbphrase['birthday_is_after'] . '<dfn>(yyyy-mm-dd)</dfn>', 'user[birthdayafter]');
	print_input_row($vbphrase['birthday_is_before'] . '<dfn>(yyyy-mm-dd)</dfn>', 'user[birthdaybefore]');
	print_input_row($vbphrase['posts_are_greater_than'], 'user[postslower]', '', 1, 7);
	print_input_row($vbphrase['posts_are_less_than'], 'user[postsupper]', '', 1, 7);
	print_input_row($vbphrase['reputation_is_greater_than'], 'user[reputationlower]', '', 1, 7);
	print_input_row($vbphrase['reputation_is_less_than'], 'user[reputationupper]', '', 1, 7);
	print_input_row($vbphrase['registration_ip_address'], 'user[ipaddress]');
	print_description_row('<div align="' . $stylevar['right'] .'"><input type="submit" class="button" value=" ' . iif($email, $vbphrase['submit'], $vbphrase['find']) . ' " tabindex="1" /></div>');

	print_table_header($vbphrase['user_profile_fields']);
	$profilefields = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "profilefield");
	while ($profilefield = $vbulletin->db->fetch_array($profilefields))
	{
		$profilefield['def'] = 0;
		print_profilefield_row('profile', $profilefield);
	}
	print_description_row('<div align="' . $stylevar['right'] .'"><input type="submit" class="button" value=" ' . iif($email, $vbphrase['submit'], $vbphrase['find']) . ' " tabindex="1" /></div>');
}

// ###################### Start findusersql #######################
function fetch_user_search_sql(&$user, &$profile, $prefix = 'user')
{

	global $vbulletin;

	if (!empty($prefix))
	{
		$prefix .= '.';
	}

	$user['username'] = trim($user['username']);
	$condition = '1=1';
	$condition .= iif($user['username'] AND !$user['exact'], " AND {$prefix}username LIKE '%" . $vbulletin->db->escape_string_like(htmlspecialchars_uni($user['username'])) . "%'");
	$condition .= iif($user['exact'], " AND {$prefix}username = '" . $vbulletin->db->escape_string(htmlspecialchars_uni($user['username'])) . "'");
	if (is_array($user['usergroupid']))
	{ // for emails
		$u_condition = array();
		foreach ($user['usergroupid'] AS $id)
		{
			$u_condition[] = "{$prefix}usergroupid = " . intval($id);
		}
		$condition .= ' AND (' . implode(' OR ', $u_condition) . ')';
		unset($u_condition);
	}
	else
	{
		$condition .= iif($user['usergroupid'] != -1 AND $user['usergroupid'], " AND {$prefix}usergroupid = " . intval($user['usergroupid']));
	}

	if (is_array($user['membergroup']))
	{
		foreach ($user['membergroup'] AS $id)
		{
			$condition .= " AND FIND_IN_SET('" . intval($id) . "', {$prefix}membergroupids)";
		}
	}
	$condition .= iif($user['email'], " AND {$prefix}email LIKE '%" . $vbulletin->db->escape_string_like($user['email']) . "%'");
	$condition .= iif($user['parentemail'], " AND {$prefix}parentemail LIKE '%" . $vbulletin->db->escape_string_like($user['parentemail']) . "%'");
	$condition .= iif($user['coppauser'] == 1, " AND ({$prefix}options & " . $vbulletin->bf_misc_useroptions['coppauser'] . ") = " . $vbulletin->bf_misc_useroptions['coppauser']);
	$condition .= iif(isset($user['coppauser']) AND $user['coppauser'] == 0, " AND ({$prefix}options & " . $vbulletin->bf_misc_useroptions['coppauser'] . ') = 0');
	$condition .= iif($user['homepage'], " AND {$prefix}homepage LIKE '%" . $vbulletin->db->escape_string_like($user['homepage']) . "%'");
	$condition .= iif($user['icq'], " AND {$prefix}icq LIKE '%" . $vbulletin->db->escape_string_like($user['icq']) . "%'");
	$condition .= iif($user['aim'], " AND REPLACE({$prefix}aim, ' ', '') LIKE '%" . $vbulletin->db->escape_string_like(str_replace(' ', '', $user['aim'])) . "%'");
	$condition .= iif($user['yahoo'], " AND {$prefix}yahoo LIKE '%" . $vbulletin->db->escape_string_like($user['yahoo']) . "%'");
	$condition .= iif($user['msn'], " AND {$prefix}msn LIKE '%" . $vbulletin->db->escape_string_like($user['msn']) . "%'");
	$condition .= iif($user['signature'], " AND usertextfield.signature LIKE '%" . $vbulletin->db->escape_string_like($user['signature']) . "%'");
	$condition .= iif($user['usertitle'], " AND {$prefix}usertitle LIKE '%" . $vbulletin->db->escape_string_like($user['usertitle']) . "%'");
	$condition .= iif($user['joindateafter'], " AND {$prefix}joindate > UNIX_TIMESTAMP('" . $vbulletin->db->escape_string($user['joindateafter']) . "')");
	$condition .= iif($user['joindatebefore'], " AND {$prefix}joindate < UNIX_TIMESTAMP('" . $vbulletin->db->escape_string($user['joindatebefore']) . "')");
	$condition .= iif($user['birthdayafter'], " AND {$prefix}birthday_search > '" . $vbulletin->db->escape_string($user['birthdayafter']) . "'");
	$condition .= iif($user['birthdaybefore'], " AND {$prefix}birthday_search < '" . $vbulletin->db->escape_string($user['birthdaybefore']) . "'");

	if ($user['lastactivityafter'])
	{
		if (strval($user['lastactivityafter']) == strval(intval($user['lastactivityafter'])))
		{
			$condition .= " AND {$prefix}lastactivity > " . intval($user['lastactivityafter']) ;
		}
		else
		{
			$condition .= " AND {$prefix}lastactivity > UNIX_TIMESTAMP('" . $vbulletin->db->escape_string($user['lastactivityafter']) . "')";
		}
	}
	$condition .= iif($user['lastactivitybefore'], " AND {$prefix}lastactivity < UNIX_TIMESTAMP('" . $vbulletin->db->escape_string($user['lastactivitybefore']) . "')");

	$condition .= iif($user['lastpostafter'], " AND {$prefix}lastpost > UNIX_TIMESTAMP('" . $vbulletin->db->escape_string($user['lastpostafter']) . "')");
	$condition .= iif($user['lastpostbefore'], " AND {$prefix}lastpost < UNIX_TIMESTAMP('" . $vbulletin->db->escape_string($user['lastpostbefore']) . "')");
	$condition .= iif($user['postslower'], " AND {$prefix}posts > " . intval($user['postslower']));
	$condition .= iif($user['postsupper'], " AND {$prefix}posts < " . intval($user['postsupper']));
	$condition .= iif($user['reputationupper'], " AND {$prefix}reputation < " . intval($user['reputationupper']));
	$condition .= iif($user['reputationlower'], " AND {$prefix}reputation > " . intval($user['reputationlower']));
	$condition .= iif($user['ipaddress'], " AND {$prefix}ipaddress LIKE '%" . $vbulletin->db->escape_string_like($user['ipaddress']) . "%'");

	$profilefields = $vbulletin->db->query_read("
		SELECT profilefieldid, type, data, optional
		FROM " . TABLE_PREFIX . "profilefield
	");
	while ($profilefield = $vbulletin->db->fetch_array($profilefields))
	{
		$condition .= fetch_profilefield_sql_condition($profilefield, $profile);
	}

	return $condition;
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: adminfunctions_user.php,v $ - $Revision: 1.71 $
|| ####################################################################
\*======================================================================*/
?>