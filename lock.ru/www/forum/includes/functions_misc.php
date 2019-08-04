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

// ###################### Start microtime_diff #######################
// get microtime difference between $starttime and NOW
function fetch_microtime_difference($starttime, $addtime = 0)
{
	$finishtime = microtime();
	$starttime = explode(' ', $starttime);
	$finishtime = explode(' ', $finishtime);
	return $finishtime[0] - $starttime[0] + $finishtime[1] - $starttime[1] + $addtime;
}

// ###################### Start mktimefix #######################
// mktime() workaround for < 1970
function mktimefix($format, $year)
{
	$search = array('%Y', '%y', 'Y', 'y');
	$replace = array($year, substr($year, 2), $year, substr($year, 2));

	return str_replace($search, $replace, $format);
}

// ###################### Start getlanguagesarray #######################
function fetch_language_titles_array($titleprefix = '', $getall = true)
{
	global $vbulletin;

	$out = array();

	$languages = $vbulletin->db->query_read("
		SELECT languageid, title
		FROM " . TABLE_PREFIX . "language
		" . iif($getall != true, ' WHERE userselect = 1')
	);
	while ($language = $vbulletin->db->fetch_array($languages))
	{
		$out["$language[languageid]"] = $titleprefix . $language['title'];
	}

	asort($out);

	return $out;
}

// ###################### Start makefolderjump #######################
function construct_folder_jump($foldertype = 0, $selectedid = false, $exclusions = false, $sentfolders = '')
{
	global $vbphrase, $folderid, $folderselect, $foldernames, $messagecounters, $subscribecounters, $folder;
	global $vbulletin;
	// 0 indicates PMs
	// 1 indicates subscriptions
	// get all folder names (for dropdown)
	// reference with $foldernames[#] .

	$folderjump = '';
	if (!is_array($foldernames))
	{
		$foldernames = array();
	}

	switch($foldertype)
	{
		case 0:
		    // get PM folders total
		    $pmcounts = $vbulletin->db->query_read("
		        SELECT COUNT(*) AS total, folderid
		        FROM " . TABLE_PREFIX . "pm AS pm
		        LEFT JOIN " . TABLE_PREFIX . "pmtext AS pmtext USING(pmtextid)
		        WHERE userid = " . $vbulletin->userinfo['userid'] . "
		        GROUP BY folderid
		    ");
		    $messagecounters = array();
		    while ($pmcount = $vbulletin->db->fetch_array($pmcounts))
		    {
		        $messagecounters["$pmcount[folderid]"] = $pmcount['total'];
    		}

			$folderfield = 'pmfolders';
			$folders = array('0' => $vbphrase['inbox'], '-1' => $vbphrase['sent_items']);
			if (!empty($vbulletin->userinfo["$folderfield"]))
			{
				$folders = $folders + unserialize($vbulletin->userinfo["$folderfield"]);
			}
			$counters =& $messagecounters;
			break;
		case 1:

		    // get Subscription folder totals
		    $foldertotals = $vbulletin->db->query_read("
		        SELECT COUNT(*) AS total, folderid
		        FROM " . TABLE_PREFIX . "subscribethread AS subscribethread
		        LEFT JOIN " . TABLE_PREFIX . "thread AS thread ON(thread.threadid = subscribethread.threadid)
		        WHERE subscribethread.userid = " . $vbulletin->userinfo['userid'] . "
		            AND subscribethread.threadid = thread.threadid
		            AND thread.visible = 1
		        GROUP BY folderid
		    ");
		    $subscribecounters = array();
		    while ($foldertotal = $vbulletin->db->fetch_array($foldertotals))
		    {
		        $subscribecounters["$foldertotal[folderid]"] = intval($foldertotal['total']);
    		}

			$folderfield = 'subfolders';
			$folders = iif($sentfolders, $sentfolders, unserialize($vbulletin->userinfo["$folderfield"]));
			if (!$folders[0])
			{
				$folders[0] = $vbphrase['subscriptions'];
				asort($folders, SORT_STRING);
			}
			$counters =& $subscribecounters;
			break;
		default:
			return;
	}

	if (is_array($folders))
	{
		foreach($folders AS $_folderid => $_foldername)
		{
			if (is_array($exclusions) AND in_array($_folderid, $exclusions))
			{
				continue;
			}
			else
			{
				$foldernames["$_folderid"] = $_foldername;
				$folderjump .= "<option value=\"$_folderid\" " . iif($_folderid == $selectedid, 'selected="selected"') . ">$_foldername" . iif(is_array($counters), ' (' . intval($counters["$_folderid"]) . iif($foldertype == 1, " $vbphrase[threads])", " $vbphrase[messages])")) . "</option>\n";
				if ($_folderid == $selectedid AND $selectedid !== false)
				{
					$folder = $_foldername;
				}
			}
		}
	}

	return $folderjump;

}

// ###################### Start vbmktime #######################
function vbmktime($hours = 0, $minutes = 0, $seconds = 0, $month = 0, $day = 0, $year = 0)
{
	global $vbulletin;

	return mktime($hours, $minutes, $seconds, $month, $day, $year) + $vbulletin->options['hourdiff'];
}

// ###################### Start gmvbdate #####################
function vbgmdate($format, $timestamp, $doyestoday = false, $locale = true)
{
	return vbdate($format, $timestamp, $doyestoday, $locale, false, true);
}

// ###################### Start fetch period group #####################
function fetch_period_group($itemtime)
{
	global $vbphrase, $vbulletin;
	static $periods;

	// create the periods array if it does not exist
	if (empty($periods))
	{
		$daynum = -1;
		$i = 0;

		// make $vbulletin->userinfo's startofweek setting agree with the date() function
		$weekstart = $vbulletin->userinfo['startofweek'] - 1;

		// get the timestamp for the beginning of today, according to vbulletin->userinfo's timezone
		$timestamp = vbmktime(0, 0, 0, vbdate('m', TIMENOW, false, false), vbdate('d', TIMENOW, false, false), vbdate('Y', TIMENOW, false, false));

		// initialize $periods array with stamp for today
		$periods = array('today' => $timestamp);

		// create periods for today, yesterday and all days until we hit the start of the week
		while ($daynum != $weekstart AND $i++ < 7)
		{
			// take away 24 hours
			$timestamp -= 86400;

			// get the number of the current day
			$daynum = vbdate('w', $timestamp, false, false);

			if ($i == 1)
			{
				$periods['yesterday'] = $timestamp;
			}
			else
			{
				$periods[strtolower(vbdate('l', $timestamp, false, false))] = $timestamp;
			}
		}

		// create periods for Last Week, 2 Weeks Ago, 3 Weeks Ago and Last Month
		$periods['last_week'] = $timestamp -= (7 * 86400);
		$periods['2_weeks_ago'] = $timestamp -= (7 * 86400);
		$periods['3_weeks_ago'] = $timestamp -= (7 * 86400);
		$periods['last_month'] = $timestamp -= (28 * 86400);
	}

	foreach ($periods AS $periodname => $periodtime)
	{
		if ($itemtime >= $periodtime)
		{
			return $periodname;
		}
	}

	return 'older';
}

// ###################### Start array2bits #######################
// takes an array and returns the bitwise value
function convert_array_to_bits(&$arry, $_FIELDNAMES, $unset = 0)
{
	$bits = 0;
	foreach($_FIELDNAMES AS $fieldname => $bitvalue)
	{
		if ($arry["$fieldname"] == 1)
		{
			$bits += $bitvalue;
		}
		if ($unset)
		{
			unset($arry["$fieldname"]);
		}
	}
	return $bits;
}

// ###################### Start bitwise #######################
// Returns 1 if the bitwise is successful, 0 other wise
// usage bitwise($perms, UG_CANMOVE);
function bitwise($value, $bitfield)
{
	// Do not change this to return true/false!

	return iif(intval($value) & $bitfield, 1, 0);
}

// ###################### Start echoarray #######################
// recursively prints out an array
function print_array($array, $title = NULL, $htmlisekey = false, $indent = '')
{
	global $vbphrase;
	if ($title === NULL)
	{
		$title = 'My Array';
	}
	if (is_array($array))
	{
		echo iif(empty($indent), "<div class=\"echoarray\">\n") . "$indent<li><b" . iif(empty($indent), ' style="font-size: larger"', '').">" . iif($htmlisekey, htmlspecialchars_uni($title), $title) . "</b><ul>\n";
		foreach ($array AS $key => $val)
		{
			if (is_array($val))
			{
				print_array($val, $key, $htmlisekey, $indent."\t");
			}
			else
			{
				echo "$indent\t<li>" . iif($htmlisekey, htmlspecialchars_uni($key), $key) . " = '<i>" . htmlspecialchars_uni($val) . "</i>'</li>\n";
			}
		}
		echo iif(empty($indent), "</div>\n") . "$indent</ul></li>\n";
	}
}

// ###################### Start getChildForums #######################
function fetch_child_forums($parentid, $return = 'STRING', $glue = ',')
{
	global $vbulletin, $allforumcache;
	static $childlist;

	if (!is_array($allforumcache))
	{
		if ($return == 'ARRAY')
		{
			$childlist = array();
		}
		else
		{
			$childlist = 0;
		}
		foreach(array_keys($vbulletin->forumcache) AS $forumid)
		{
			$f =& $vbulletin->forumcache["$forumid"];
			$allforumcache["$f[parentid]"]["$forumid"] = $forumid;
		}
	}

	if (!is_array($allforumcache["$parentid"]))
	{
		return $childlist;
	}
	else
	{
		foreach($allforumcache["$parentid"] AS $forumid)
		{
			if ($return == 'ARRAY')
			{
				$childlist[] = $forumid;
			}
			else
			{
				$childlist .= "$glue$forumid";
			}
			fetch_child_forums($forumid, $return, $glue);
		}
	}

	return $childlist;
}

// ###################### Start verify autosubscribe #######################
// function to verify that the subscription type is valid
function verify_subscription_choice($choice, &$userinfo, $default = 9999, $doupdate = true)
{
	global $vbulletin;

	// check that the subscription choice is valid
	switch ($choice)
	{
		// the choice is good
		case 0:
		case 1:
		case 2:
		case 3:
			break;

		// check that ICQ number is valid
		case 4:
			if (!preg_match('#^[0-9\-]+$', $userinfo['icq']))
			{
				// icq number is bad
				if ($doupdate)
				{
					global $vbulletin;

					// init user datamanager
					$userdata =& datamanager_init('User', $vbulletin, ERRTYPE_STANDARD);
					$userdata->set_existing($userinfo);
					$userdata->set('icq', '');
					$userdata->set('autosubscribe', 1);
					$userdata->save();
				}
				$userinfo['icq'] = '';
				$userinfo['autosubscribe'] = 1;
				$choice = 1;
			}
			break;

		// all other options
		default:
			$choice = $default;
			break;
	}

	return $choice;
}

// ###################### Start countchar #######################
function fetch_character_count($string, $char)
{
	//counts number of times $char occus in $string

	return substr_count(strtolower($string), strtolower($char));
}

/**
* Replaces legacy variable names in templates with their modern equivalents
*
* @param	string	Template to be processed
* @param	boolean	Handle replacement of vars outside of quotes
*
* @return	string
*/
function replace_template_variables($template, $do_outside_regex = false)
{
	// matches references to specifc arrays in templates and maps them to a better internal format
	// this function name is a slight misnomer; it can be run on phrases with variables in them too!

	// include the $, but escape it in the key
	static $variables = array(
		'\$vboptions' => '$GLOBALS[\'vbulletin\']->options',
		'\$bbuserinfo' => '$GLOBALS[\'vbulletin\']->userinfo',
		'\$session' => '$GLOBALS[\'vbulletin\']->session->vars',
	);

	// regexes to do the replacements; __FINDVAR__ and __REPLACEVAR__ are replaced before execution
	static $basic_find = array(
		'#\{__FINDVAR__\[(\\\\?\'|"|)([\w$[\]]+)\\1\]\}#',
		'#__FINDVAR__\[\$(\w+)\]#',
		'#__FINDVAR__\[(\w+)\]#',
	);
	static $basic_replace = array(
		'" . __REPLACEVAR__[$1$2$1] . "',
		'" . __REPLACEVAR__[$$1] . "',
		'" . __REPLACEVAR__[\'$1\'] . "',
	);

	foreach ($variables AS $findvar => $replacevar)
	{
		if ($do_outside_regex)
		{
			// this is handles replacing of vars outside of quotes
			do
			{
				// not in quotes = variable preceeded by an even number of ", does not count " escaped with an odd amount of \
				// ... this was a toughie!
				$new_template = preg_replace(
					array(
						'#^([^"]*?("(?>(?>(\\\\{2})+?)|\\\\"|[^"])*"([^"]*?))*)' . $findvar . '\[(\\\\?\'|"|)([\w$[\]]+)\\5\]#sU',
						'#^([^"]*?("(?>(?>(\\\\{2})+?)|\\\\"|[^"])*"([^"]*?))*)' . $findvar . '([^[]|$)#sU',
					),
					array(
						'$1' . $replacevar . '[$5$6$5]',
						'$1' . $replacevar . '$5',
					),
					$template
				);
				if ($new_template == $template)
				{
					break;
				}
				$template = $new_template;
			}
			while (true);
		}

		// these regular expressions handle replacement of vars inside quotes
		$this_find = str_replace('__FINDVAR__', $findvar, $basic_find);
		$this_replace = str_replace('__REPLACEVAR__', $replacevar, $basic_replace);

		$template = preg_replace($this_find, $this_replace, $template);
	}

	// straight replacements - for example $scriptpath becomes $GLOBALS['vbulletin']->scriptpath
	static $str_replace = array(
		'$scriptpath' => '" . $GLOBALS[\'vbulletin\']->scriptpath . "',
	);
	$template = str_replace(array_keys($str_replace), $str_replace, $template);
	
	return $template;
}

/**
* Returns a hidden input field containing the serialized $_POST array
*
* @return	string	HTML code containing hidden fields
*/
function construct_post_vars_html()
{
	global $vbulletin;

	$vbulletin->input->clean_gpc('p', 'postvars', TYPE_STR);
	if ($vbulletin->GPC['postvars'] != '')
	{
		return '<input type="hidden" name="postvars" value="' . htmlspecialchars_uni($vbulletin->GPC['postvars']) . '" />' . "\n";
	}
	else if ($vbulletin->superglobal_size['_POST'] > 0)
	{
		return '<input type="hidden" name="postvars" value="' . htmlspecialchars_uni(serialize($_POST)) . '" />' . "\n";
	}
	else
	{
		return '';
	}
}

/**
* Returns a collection of <input type="hidden" /> fields containing the values specified in the serialized array provided
*
* @param	string	Serialized array of name=value pairs
*
* @return	string	HTML hidden fields
*/
function construct_hidden_var_fields($serializedarr)
{
	$temp = unserialize($serializedarr);

	if (!is_array($temp))
	{
		return '';
	}

	$html = '';
	foreach ($temp AS $key => $val)
	{
		if ($key == 'submit' OR $key == 'action' OR $key == 'method')
		{ // reserved in JS
			continue;
		}
		$html .= '<input type="hidden" name="' . htmlspecialchars_uni($key) . '" value="' . htmlspecialchars_uni($val) . '" />' . "\n";
	}
	return $html;
}

/**
* Fetches a specific type of phrase from the database
*
* @param	string	Varname of the phrase to be fetched
* @param	integer	Phrase Type ID of the phrase to be fetched
* @param	string	String to be removed from the beginning of specified phrase varname (varname = 'moo_thing', strreplace = 'moo_' => varname = 'thing')
* @param	boolean	Whether or not to parse any quotes in the fetched text ready for eval()
* @param	boolean	Fetch phrase from all languages (?)
* @param	integer	Desired language ID from which to pull the phrase text
* @param	boolean	If true, converts '{1}' and '{2}' into '%1$s' and '%2$s' etc., in preparation for sprintf() parsing
*
* @return	string
*/
function fetch_phrase($phrasename, $phrasetypeid, $strreplace = '', $doquotes = true, $alllanguages = false, $languageid = -1, $dobracevars = true)
{
	// we need to do some caching in this function I believe
	global $vbulletin;
	static $phrase_cache;

	if (!empty($strreplace))
	{
		if (strpos("$phrasename", $strreplace) !== false)
		{
			$phrasename = substr($phrasename, strlen($strreplace));
		}
	}

	$phrasetypeid = intval($phrasetypeid);

	if (!isset($phrase_cache["{$phrasetypeid}-{$phrasename}"]))
	{
		$getphrases = $vbulletin->db->query_read("
			SELECT text, languageid
			FROM " . TABLE_PREFIX . "phrase
			WHERE phrasetypeid = $phrasetypeid
				AND varname = '" . $vbulletin->db->escape_string($phrasename) . "' "
				. iif(!$alllanguages, "AND languageid IN (-1, 0, " . intval(LANGUAGEID) . ")")
		);
		while ($getphrase = $vbulletin->db->fetch_array($getphrases))
		{
			$phrase_cache["{$phrasetypeid}-{$phrasename}"]["$getphrase[languageid]"] = $getphrase['text'];
		}
		unset($getphrase);
		$vbulletin->db->free_result($getphrases);
	}

	$phrase =& $phrase_cache["{$phrasetypeid}-{$phrasename}"];

	if ($languageid == -1)
	{
		// didn't pass in a languageid as this is the default value so use the browsing user's languageid
		$languageid = LANGUAGEID;
	}
	else if ($languageid == 0)
	{
		// the user is using forum default
		$languageid = $vbulletin->options['languageid'];
	}

	if (isset($phrase["$languageid"]))
	{
		$messagetext = $phrase["$languageid"];
	}
	else if (isset($phrase[0]))
	{
		$messagetext = $phrase[0];
	}
	else if (isset($phrase['-1']))
	{
		$messagetext = $phrase['-1'];
	}
	else
	{
		$messagetext = "Could not find phrase '$phrasename'.";
	}

	if ($dobracevars)
	{
		$messagetext = preg_replace('#\{([0-9])+\}#sU', '%\\1$s', $messagetext);
	}

	if ($doquotes)
	{
		$messagetext = str_replace("\\'", "'", addslashes($messagetext));
		if ($phrasetypeid >= 1000)
		{
			// these phrases have variables in them. Thus, they could have variables like $vboptions that need to be replaced
			$messagetext = replace_template_variables($messagetext, false);
		}
	}

	return $messagetext;
}

/**
* Returns either the complete array of timezones, or the timezone phrase name corresponding to $offset
*
* @param	mixed	If specified, returns the corresponding timezone phrase name. Otherwise, all timezones will be returned
*
* @return	mixed
*/
function fetch_timezone($offset = 'all')
{
	$timezones = array(
		'-12'  => 'timezone_gmt_minus_1200',
		'-11'  => 'timezone_gmt_minus_1100',
		'-10'  => 'timezone_gmt_minus_1000',
		'-9'   => 'timezone_gmt_minus_0900',
		'-8'   => 'timezone_gmt_minus_0800',
		'-7'   => 'timezone_gmt_minus_0700',
		'-6'   => 'timezone_gmt_minus_0600',
		'-5'   => 'timezone_gmt_minus_0500',
		'-4'   => 'timezone_gmt_minus_0400',
		'-3.5' => 'timezone_gmt_minus_0330',
		'-3'   => 'timezone_gmt_minus_0300',
		'-2'   => 'timezone_gmt_minus_0200',
		'-1'   => 'timezone_gmt_minus_0100',
		'0'    => 'timezone_gmt_plus_0000',
		'1'    => 'timezone_gmt_plus_0100',
		'2'    => 'timezone_gmt_plus_0200',
		'3'    => 'timezone_gmt_plus_0300',
		'3.5'  => 'timezone_gmt_plus_0330',
		'4'    => 'timezone_gmt_plus_0400',
		'4.5'  => 'timezone_gmt_plus_0430',
		'5'    => 'timezone_gmt_plus_0500',
		'5.5'  => 'timezone_gmt_plus_0530',
		'6'    => 'timezone_gmt_plus_0600',
		'7'    => 'timezone_gmt_plus_0700',
		'8'    => 'timezone_gmt_plus_0800',
		'9'    => 'timezone_gmt_plus_0900',
		'9.5'  => 'timezone_gmt_plus_0930',
		'10'   => 'timezone_gmt_plus_1000',
		'11'   => 'timezone_gmt_plus_1100',
		'12'   => 'timezone_gmt_plus_1200'
	);

	if ($offset === 'all')
	{
		return $timezones;
	}
	else
	{
		return $timezones["$offset"];
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: functions_misc.php,v $ - $Revision: 1.34 $
|| ####################################################################
\*======================================================================*/
?>