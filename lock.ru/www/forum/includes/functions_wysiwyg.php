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

/*
$fontoptions = makeJavascriptArray('vbcode_font_options');
$sizeoptions = makeJavascriptArray('vbcode_size_options');
$coloroptions = makeJavascriptArray('vbcode_color_options');
*/

// ###################### Start WYSIWYG_getparsedhtml #######################
function parse_wysiwyg_html($html, $ishtml = 0, $forumid = 0, $allowsmilie = 1)
{
	global $vbulletin;

	if ($ishtml)
	{
		// parse HTML into vbcode
		// I DON'T THINK THIS IS EVER USED NOW - KIER
		$html = convert_wysiwyg_html_to_bbcode($html);
	}
	else
	{
		$html = unhtmlspecialchars($html, 0);
	}

	// parse the message back into WYSIWYG-friendly HTML
	require_once(DIR . '/includes/class_bbcode_alt.php');
	$wysiwyg_parser =& new vB_BbCodeParser_Wysiwyg($vbulletin, fetch_tag_list());
	return $wysiwyg_parser->parse($html, $forumid, $allowsmilie);
}

// ###################### Start safeUrl #######################
function sanitize_url($type, $url)
{
	static $find, $replace;
	if (!is_array($find))
	{
		$find = array('<', '>');
		$replace = array('&lt;', '&gt;');
	}

	return str_replace('\\"', '"', $type) . '="' . str_replace($find, $replace, str_replace('\\"', '"', $url)) . '"';
}

// ###################### Start getsmilietext #######################
function fetch_smilie_text($smilieid)
{
	global $vbulletin;
	static $smilies;

	// build the smilies array if we haven't already
	if (!is_array($smilies))
	{
		$smilies = array();
		// attempt to get smilies from the datastore smiliecache
		if (is_array($vbulletin->smiliecache))
		{
			foreach($vbulletin->smiliecache AS $smilie)
			{
				$smilies["$smilie[smilieid]"] = $smilie['smilietext'];
			}
		}
		// query smilies from the database
		else
		{
			$getsmilies = $vbulletin->db->query_read("SELECT smilieid, smilietext FROM " . TABLE_PREFIX . "smilie");
			while ($smilie = $vbulletin->db->fetch_array($getsmilies))
			{
				$smilies["$smilie[smilieid]"] = $smilie['smilietext'];
			}
			$vbulletin->db->free_result($getsmilies);
		}
	}

	// return the smilietext for this smilie
	return $smilies["$smilieid"];
}

// ###################### Start WYSIWYG_html2vbcode #######################
function convert_wysiwyg_html_to_bbcode($text, $allowhtml = false)
{
	global $vbulletin;

	// debug code
	$vbulletin->input->clean_gpc('r', 'showhtml', TYPE_BOOL);
	if ($vbulletin->debug AND $vbulletin->GPC['showhtml'])
	{
		$otext = $text;
	}

	// deal with some wierdness that can be caused with URL tags in the WYSIWYG editor
	$text = preg_replace(array(
			'#<a href="([^"]*)\[([^"]+)"(.*)>(.*)\[\\2</a>#siU', // check for the WYSIWYG editor being lame with URL tags followed by bbcode tags
			'#(<[^<>]+ (src|href))=(\'|"|)??(.*)(\\3)#esiU'  // make < and > safe in inside URL/IMG tags so they don't get stripped by strip_tags
		), array(
			'<a href="\1"\3>\4</a>[\2',                     // check for the browser (you know who you are!) being lame with URL tags followed by bbcode tags
			"sanitize_url('\\1', '\\4')"                     // make < and > safe in inside URL/IMG tags so they don't get stripped by strip_tags
		), $text
	);

	($hook = vBulletinHook::fetch_hook('wysiwyg_parse_start')) ? eval($hook) : false;

	// attempt to remove bad html and keep only that which we intend to parse
	if (!$allowhtml)
	{
		$text = strip_tags($text, '<b><strong><i><em><u><a><div><span><p><blockquote><ol><ul><li><font><img><br><h1><h2><h3><h4><h5><h6>');
	}

	// convert 4 spaces to tabs in code/php/html tags; no longer used
	/*if (preg_match_all('#\[(code|php|html)\](.*)\[/\\1\]#siU', $text, $regs))
	{
		foreach($regs[2] AS $key => $val)
		{
			$orig = $val;
			// convert '&nbsp; ' to '&nbsp;&nbsp;'
			$val = str_replace('&nbsp; ', '&nbsp;&nbsp;', $val);
			// convert 4 x &nbsp; to \t
			$val = preg_replace('#(&nbsp;){4}#siU', "\t", $val);
			// replace text in original text
			$text = str_replace($orig, $val, $text);
		}
	}*/

	// replace &nbsp; with a regular space
	$text = str_replace('&nbsp;', ' ', $text);

	// deal with newline characters
	if (is_browser('mozilla'))
	{
		$text = preg_replace('#(?<!<br>|<br />|\r)(\r\n|\n|\r)#', ' ', $text);
	}

	$text = preg_replace('#(\r\n|\n|\r)#', '', $text);

	// regex find / replace #1
	$pregfind = array
	(
		#'#^(<div>\s*)+#si',                                  // multiple <DIV>s at string start
		#'#(\s*</div>)+$#si',                                 // multiple </DIV>s at string end
		'#<(h[0-9]+)[^>]*>(.*)</\\1>#siU',                    // headings
		'#<img[^>]+smilieid="(\d+)".*>#esiU',                 // smilies
		'#<img[^>]+src=(\'|")(.*)(\\1).*>#siU',               // img tag
		//'#<a[^>]+href=(\'|")mailto:(.*)(\\1).*>(.*)</a>#siU', // email tag
		//'#<a[^>]+href=(\'|")(.*)(\\1).*>(.*)</a>#siU',        // url tag
		//'#\s*<(p|div) align=(\'|"|)(.*)\\2>(.*)</\\1>#siU', // <p align=...> to double newline
		//'#<p.*>(.*)</p>#siU',                               // convert <p> to double newline
		'#<br.*>#siU',                                        // <br> to newline
		'#<a name=[^>]*>(.*)</a>#siU',                         // kill named anchors
		'#\[(html|php)\]((?>[^\[]+?|(?R)|.))*\[/\\1\]#siUe',				// strip html from php tags
		//'#\[url=(\'|"|&quot;|)<A href="(.*)/??">\\2/??</A>\\1\](.*)\[/url\]#siU',	// strip linked URLs from manually entered [url] tags
		'#\[url=(\'|"|&quot;|)<A href="(.*)/??">\\2/??</A>#siU'						// strip linked URLs from manually entered [url] tags (generic)
	);
	$pregreplace = array
	(
		#'<DIV>',                                             // multiple <DIV>s at string start
		#'</DIV>',                                            // multiple </DIV>s at string end
		"[B]\\2[/B]\n\n",                                     // headings
		"fetch_smilie_text(\\1)",                             // smilies
		'[IMG]\2[/IMG]',                                      // img tag
		//'[EMAIL="\2"]\4[/EMAIL]',                             // email tag
		//'[URL="\2"]\4[/URL]',                                 // url tag
		//"[\\3]\\4[/\\3]",                                   // <p align=...> to double newline
		//"\\1\n\n",                                          // <p> to double newline
		"\n",                                                 // <br> to newline
		'\1',                                                  // kill named anchors
		"strip_tags_callback('\\0')",								// strip html from php tags
		//'[URL=$1$2$1]$3[/URL]',							// strip linked URLs from manually entered [url] tags
		'[URL=$1$2'											//`strip linked URLs from manually entered [url] tags (generic)
	);
	$text = preg_replace($pregfind, $pregreplace, $text);

	// recursive code parsers
	$text = parse_wysiwyg_recurse('b', $text, 'parse_wysiwyg_code_replacement', 'b');
	$text = parse_wysiwyg_recurse('strong', $text, 'parse_wysiwyg_code_replacement', 'b');
	$text = parse_wysiwyg_recurse('i', $text, 'parse_wysiwyg_code_replacement', 'i');
	$text = parse_wysiwyg_recurse('em', $text, 'parse_wysiwyg_code_replacement', 'i');
	$text = parse_wysiwyg_recurse('u', $text, 'parse_wysiwyg_code_replacement', 'u');
	$text = parse_wysiwyg_recurse('a', $text, 'parse_wysiwyg_anchor');
	$text = parse_wysiwyg_recurse('font', $text, 'parse_wysiwyg_font');
	$text = parse_wysiwyg_recurse('blockquote', $text, 'parse_wysiwyg_code_replacement', 'indent');
	$text = parse_wysiwyg_recurse('ol', $text, 'parse_wysiwyg_list');
	$text = parse_wysiwyg_recurse('ul', $text, 'parse_wysiwyg_list');
	$text = parse_wysiwyg_recurse('div', $text, 'parse_wysiwyg_div');
	$text = parse_wysiwyg_recurse('span', $text, 'parse_wysiwyg_span');
	$text = parse_wysiwyg_recurse('p', $text, 'parse_wysiwyg_paragraph');

	// regex find / replace #2
	$pregfind = array(
		'#<li>(.*)((?=<li>)|</li>)#iU',    // fix some list issues
		'#<p></p>#i',                      // kill empty <p> tags
		'#<p.*>#iU',                       // kill any extra <p> tags
		//'#(\[/quote\])(\s?\r?\n){0,1}#si', // kill extra whitespace after a [/quote] tag
	);
	$pregreplace = array(
		"\\1\n",                           // fix some list issues
		'',                                // kill empty <p> tags
		"\n",                              // kill any extra <p> tags
		//'\1',                            // kill extra whitespace after a [/quote] tag
	);
	$text = preg_replace($pregfind, $pregreplace, $text);

	// simple tag removals; mainly using PCRE for case insensitivity and /?
	$text = preg_replace('#</?(A|LI|FONT)>#siU', '', $text);

	// basic string replacements #2; don't replace &quot; because browsers don't auto-encode quotes
	$strfind = array
	(
		'&lt;',       // un-htmlspecialchars <
		'&gt;',       // un-htmlspecialchars >
		'&amp;',      // un-htmlspecialchars &
	);
	$strreplace = array
	(
		'<',          // un-htmlspecialchars <
		'>',          // un-htmlspecialchars >
		'&',          // un-htmlspecialchars &
	);

	if (is_array($vbulletin->smiliecache))
	{
		global $vbulletin;

		foreach ($vbulletin->smiliecache AS $smilie)
		{
			// [IMG]images/smilies/frown.gif[/IMG]
			$strfind[] = '[IMG]' . $smilie['smiliepath'] . '[/IMG]';
			$strreplace[] = $smilie['smilietext'];

			// [IMG]http://domain.com/forum/images/smilies/frown.gif[/IMG]
			$strfind[] = '[IMG]' . create_full_url($smilie['smiliepath']) . '[/IMG]';
			$strreplace[] = $smilie['smilietext'];
		}
	}

	$text = str_replace($strfind, $strreplace, $text);
	$text = preg_replace("#(?<!\r|\n|^)\[(/list|list|\*)\]#", "\n[\\1]", $text);

	// strip redundant alignment tag ([left] or [right])
	// commentted out because bad HTML can do bad things to this (nested alignments)
	/*global $stylevar;
	$redundanttag = iif($stylevar['textdirection'] == 'ltr', 'left', 'right');
	$text = preg_replace('#\[' . $redundanttag . '\](.*)(\r\n|\n|\r)??\[/' . $redundanttag . '\]#siU', '\\1', $text);*/

	($hook = vBulletinHook::fetch_hook('wysiwyg_parse_complete')) ? eval($hook) : false;

	// debug code
	$vbulletin->input->clean_gpc('r', 'showhtml', TYPE_BOOL);
	if ($vbulletin->debug AND $vbulletin->GPC['showhtml'])
	{
		$GLOBALS['header'] .= "<table class=\"tborder\" cellpadding=\"4\" cellspacing=\"1\" width=\"100%\">
		<tr><td class=\"thead\">WYSIWYG HTML</td></tr>
		<tr><td class=\"alt1\">" . nl2br(htmlspecialchars($otext)) . "</td></tr>
		<tr><td class=\"thead\">Parsed BBcode</td></tr>
		<tr><td class=\"alt1\">" . nl2br(htmlspecialchars($text)) . "</td></tr>\n</table>";
	}

	// return parsed text
	return trim($text);
}

// ###################### Start parse_style_attribute #######################
function parse_style_attribute($tagoptions, &$prependtags, &$appendtags)
{
	$searchlist = array(
		array('tag' => 'left', 'option' => false, 'regex' => '#text-align:\s*(left);?#i'),
		array('tag' => 'center', 'option' => false, 'regex' => '#text-align:\s*(center);?#i'),
		array('tag' => 'right', 'option' => false, 'regex' => '#text-align:\s*(right);?#i'),
		array('tag' => 'color', 'option' => true, 'regex' => '#(?<![a-z0-9-])color:\s*([^;]+);?#i', 'match' => 1),
		array('tag' => 'font', 'option' => true, 'regex' => '#font-family:\s*([^;]+);?#i', 'match' => 1),
		array('tag' => 'b', 'option' => false, 'regex' => '#font-weight:\s*(bold);?#i'),
		array('tag' => 'i', 'option' => false, 'regex' => '#font-style:\s*(italic);?#i'),
		array('tag' => 'u', 'option' => false, 'regex' => '#text-decoration:\s*(underline);?#i')
	);

	$style = parse_wysiwyg_tag_attribute('style=', $tagoptions);
	$style = preg_replace(
		'#(?<![a-z0-9-])color:\s*rgb\((\d+),\s*(\d+),\s*(\d+)\)(;?)#ie',
		'sprintf("color: #%02X%02X%02X$4", $1, $2, $3)',
		$style
	);
	foreach ($searchlist AS $searchtag)
	{
		if (preg_match($searchtag['regex'], $style, $matches))
		{
			$prependtags .= '[' . strtoupper($searchtag['tag']) . iif($searchtag['option'] == true, '=' . $matches["$searchtag[match]"]) . ']';
			$appendtags = '[/' . strtoupper($searchtag['tag']) . "]$appendtags";
		}
	}
}

// ###################### Start parse_wysiwyg_anchor #######################
function parse_wysiwyg_anchor($aoptions, $text)
{
	$href = parse_wysiwyg_tag_attribute('href=', $aoptions);

	if (substr($href, 0, 7) == 'mailto:')
	{
		$tag = 'email';
		$href = substr($href, 7);
	}
	else
	{
		$tag = 'url';
	}
	$tag = strtoupper($tag);

	return "[$tag=\"$href\"]" . parse_wysiwyg_recurse('a', $text, 'parse_wysiwyg_anchor') . "[/$tag]";
}

// ###################### Start WYSIWYG_paraparser #######################
function parse_wysiwyg_paragraph($poptions, $text)
{
	$style = parse_wysiwyg_tag_attribute('style=', $poptions);
	$align = parse_wysiwyg_tag_attribute('align=', $poptions);

	// only allow left/center/right alignments
	switch ($align)
	{
		case 'left':
		case 'center':
		case 'right':
			break;
		default:
			$align = '';
	}

	$align = strtoupper($align);

	$prepend = '';
	$append = '';

	parse_style_attribute($poptions, $prepend, $append);
	if ($align)
	{
		$prepend .= "[$align]";
		$append .= "[/$align]";
	}
	$append .= "\n";

	return $prepend . parse_wysiwyg_recurse('p', $text, 'parse_wysiwyg_paragraph') . $append;
}

// ###################### Start parse_wysiwyg_span #######################
function parse_wysiwyg_span($spanoptions, $text)
{

	$prependtags = '';
	$appendtags = '';
	parse_style_attribute($spanoptions, $prependtags, $appendtags);

	return $prependtags . parse_wysiwyg_recurse('span', $text, 'parse_wysiwyg_span') . $appendtags;
}

// ###################### Start WYSIWYG_divparser #######################
function parse_wysiwyg_div($divoptions, $text)
{
	$prepend = '';
	$append = '';

	parse_style_attribute($divoptions, $prepend, $append);
	$align = parse_wysiwyg_tag_attribute('align=', $divoptions);

	// only allow left/center/right alignments
	switch ($align)
	{
		case 'left':
		case 'center':
		case 'right':
			break;
		default:
			$align = '';
	}

	$align = strtoupper($align);

	if ($align)
	{
		$prepend .= "[$align]";
		$append .= "[/$align]";
	}
	$append .= "\n";

	return $prepend . parse_wysiwyg_recurse('div', $text, 'parse_wysiwyg_div') . $append;
}

// ###################### Start WYSIWYG_listelementparser #######################
function parse_wysiwyg_list_element($listoptions, $text)
{
	return '[*]' . rtrim($text);
}

// ###################### Start WYSIWYG_listparser #######################
function parse_wysiwyg_list($listoptions, $text, $tagname)
{
	$longtype = parse_wysiwyg_tag_attribute('style=', $listoptions);
	$listtype = trim(preg_replace('#"?LIST-STYLE-TYPE:\s*([a-z0-9_-]+);?"?#si', '\\1', $longtype));
	if (empty($listtype) AND $tagname == 'ol')
	{
		$listtype = 'decimal';
	}

	$text = preg_replace('#<li>((.(?!</li))*)(?=</?ol|</?ul|<li|\[list|\[/list)#siU', '<li>\\1</li>', $text);
	$text = parse_wysiwyg_recurse('li', $text, 'parse_wysiwyg_list_element');

	$validtypes = array(
		'upper-alpha' => 'A',
		'lower-alpha' => 'a',
		'upper-roman' => 'I',
		'lower-roman' => 'i',
		'decimal' => '1'
	);
	if (!isset($validtypes["$listtype"]))
	{
		$opentag = '[LIST]'; // default to bulleted
	}
	else
	{
		$opentag = '[LIST=' . $validtypes[$listtype] . ']';
	}
	return $opentag . parse_wysiwyg_recurse($tagname, $text, 'parse_wysiwyg_list') . '[/LIST]';
}

// ###################### Start WYSIWYG_fontparser #######################
function parse_wysiwyg_font($fontoptions, $text)
{
	$tags = array(
		'font' => 'face=',
		'size' => 'size=',
		'color' => 'color='
	);
	$prependtags = '';
	$appendtags = '';

	$fontoptionlen = strlen($fontoptions);

	foreach ($tags AS $vbcode => $locate)
	{
		$optionvalue = parse_wysiwyg_tag_attribute($locate, $fontoptions);
		if ($optionvalue)
		{
			$vbcode = strtoupper($vbcode);
			$prependtags .= "[$vbcode=$optionvalue]";
			$appendtags = "[/$vbcode]$appendtags";
		}
	}

	parse_style_attribute($fontoptions, $prependtags, $appendtags);

	return $prependtags . parse_wysiwyg_recurse('font', $text, 'parse_wysiwyg_font') . $appendtags;
}

// ###################### Start WYSIWYG_bbcodereplace #######################
function parse_wysiwyg_code_replacement($options, $text, $tagname, $parseto)
{
	$useoptions = array(); // array of (key) tag name; (val) option to read. If tag name isn't found, no option is used

	if (trim($text) == '')
	{
		return '';
	}

	$parseto = strtoupper($parseto);

	if (empty($useoptions["$tagname"]))
	{
		$text = parse_wysiwyg_recurse($tagname, $text, 'parse_wysiwyg_code_replacement', $parseto);
		return "[$parseto]{$text}[/$parseto]";
	}
	else
	{
		$optionvalue = parse_wysiwyg_tag_attribute($useoptions["$tagname"], $options);
		if ($optionvalue)
		{
			return "[$parseto=$optionvalue]{$text}[/$parseto]";
		}
		else
		{
			return "[$parseto]{$text}[/$parseto]";
		}
	}
}

// ###################### Start WYSIWYG_recursiveparser #######################
function parse_wysiwyg_recurse($tagname, $text, $functionhandle, $extraargs = '')
{
	$tagname = strtolower($tagname);
	$open_tag = "<$tagname";
	$open_tag_len = strlen($open_tag);
	$close_tag = "</$tagname>";
	$close_tag_len = strlen($close_tag);

	$beginsearchpos = 0;
	do {
		$textlower = strtolower($text);
		$tagbegin = @strpos($textlower, $open_tag, $beginsearchpos);
		if ($tagbegin === false)
		{
			break;
		}

		$strlen = strlen($text);

		// we've found the beginning of the tag, now extract the options
		$inquote = '';
		$found = false;
		$tagnameend = false;
		for ($optionend = $tagbegin; $optionend <= $strlen; $optionend++)
		{
			$char = $text{$optionend};
			if (($char == '"' OR $char == "'") AND $inquote == '')
			{
				$inquote = $char; // wasn't in a quote, but now we are
			}
			else if (($char == '"' OR $char == "'") AND $inquote == $char)
			{
				$inquote = ''; // left the type of quote we were in
			}
			else if ($char == '>' AND !$inquote)
			{
				$found = true;
				break; // this is what we want
			}
			else if (($char == '=' OR $char == ' ') AND !$tagnameend)
			{
				$tagnameend = $optionend;
			}
		}
		if (!$found)
		{
			break;
		}
		if (!$tagnameend)
		{
			$tagnameend = $optionend;
		}
		$offset = $optionend - ($tagbegin + $open_tag_len);
		$tagoptions = substr($text, $tagbegin + $open_tag_len, $offset);
		$acttagname = substr($textlower, $tagbegin + 1, $tagnameend - $tagbegin - 1);
		if ($acttagname != $tagname)
		{
			$beginsearchpos = $optionend;
			continue;
		}

		// now find the "end"
		$tagend = strpos($textlower, $close_tag, $optionend);
		if ($tagend === false)
		{
			break;
		}

		// if there are nested tags, this </$tagname> won't match our open tag, so we need to bump it back
		$nestedopenpos = strpos($textlower, $open_tag, $optionend);
		while ($nestedopenpos !== false AND $tagend !== false)
		{
			if ($nestedopenpos > $tagend)
			{ // the tag it found isn't actually nested -- it's past the </$tagname>
				break;
			}
			$tagend = strpos($textlower, $close_tag, $tagend + $close_tag_len);
			$nestedopenpos = strpos($textlower, $open_tag, $nestedopenpos + $open_tag_len);
		}
		if ($tagend === false)
		{
			$beginsearchpos = $optionend;
			continue;
		}

		$localbegin = $optionend + 1;
		$localtext = $functionhandle($tagoptions, substr($text, $localbegin, $tagend - $localbegin), $tagname, $extraargs);

		$text = substr_replace($text, $localtext, $tagbegin, $tagend + $close_tag_len - $tagbegin);

		// this adjusts for $localtext having more/less characters than the amount of text it's replacing
		$beginsearchpos = $tagbegin + strlen($localtext);
	} while ($tagbegin !== false);

	return $text;
}

// ###################### Start WYSIWYG_readoption #######################
function parse_wysiwyg_tag_attribute($option, $text)
{
	if (($position = strpos($text, $option)) !== false)
	{
		$delimiter = $position + strlen($option);
		if ($text{$delimiter} == '"')
		{ // read to another "
			$delimchar = '"';
		}
		else if ($text{$delimiter} == '\'')
		{
			$delimchar = '\'';
		}
		else
		{ // read to a space
			$delimchar = ' ';
		}
		$delimloc = strpos($text, $delimchar, $delimiter + 1);
		if ($delimloc === false)
		{
			$delimloc = strlen($text);
		}
		else if ($delimchar == '"' OR $delimchar == '\'')
		{
			// don't include the delimiters
			$delimiter++;
		}
		return trim(substr($text, $delimiter, $delimloc - $delimiter));
	}
	else
	{
		return '';
	}
}

// ###################### Start strip_tags_callback #######################
function strip_tags_callback($text)
{
	$text = str_replace('\\"', '"', $text);
	return strip_tags($text, '<p>');
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: functions_wysiwyg.php,v $ - $Revision: 1.128 $
|| ####################################################################
\*======================================================================*/
?>