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

// ###################### Start displaysettinggroup #######################
// display settings group(s)
function print_setting_group($dogroup, $advanced = 0)
{
	global $settingscache, $grouptitlecache, $vbulletin, $vbphrase, $bgcounter, $settingphrase, $stylevar, $gdinfo;

	if (!is_array($settingscache["$dogroup"]))
	{
		return;
	}

	print_table_header(
		$settingphrase["settinggroup_$grouptitlecache[$dogroup]"]
		 . iif($vbulletin->debug,
		 	'<span class="normal">' .
			construct_link_code($vbphrase['edit'], "options.php?" . $vbulletin->session->vars['sessionurl'] . "do=editgroup&amp;grouptitle=$dogroup") .
			construct_link_code($vbphrase['delete'], "options.php?" . $vbulletin->session->vars['sessionurl'] . "do=removegroup&amp;grouptitle=$dogroup") .
			construct_link_code($vbphrase['add_setting'], "options.php?" . $vbulletin->session->vars['sessionurl'] . "do=addsetting&amp;grouptitle=$dogroup") .
			'</span>'
		)
	);

	$bgcounter = 1;

	foreach ($settingscache["$dogroup"] AS $settingid => $setting)
	{

		if (($advanced OR !$setting['advanced']) AND !empty($setting['varname']))
		{
			print_description_row(
				iif($vbulletin->debug, '<div class="smallfont" style="float:' . $stylevar['right'] . '">' . construct_link_code($vbphrase['edit'], "options.php?" . $vbulletin->session->vars['sessionurl'] . "do=editsetting&varname=$setting[varname]") . construct_link_code($vbphrase['delete'], "options.php?" . $vbulletin->session->vars['sessionurl'] . "do=removesetting&varname=$setting[varname]") . '</div>') .
				'<div>' . $settingphrase["setting_$setting[varname]_title"] . "<a name=\"$setting[varname]\"></a></div>",
				0, 2, "optiontitle\" title=\"\$vbulletin->options['" . $setting['varname'] . "']"
			);

			// make sure all rows use the alt1 class
			$bgcounter--;

			$description = "<div class=\"smallfont\" title=\"\$vbulletin->options['$setting[varname]']\">" . $settingphrase["setting_$setting[varname]_desc"] . '</div>';
			$name = "setting[$setting[varname]]";
			$right = "<span class=\"smallfont\">$vbphrase[error]</span>";

			switch ($setting['optioncode'])
			{
				// input type="text"
				case '':
				{
					print_input_row($description, $name, $setting['value'], 1, 40);
				}
				break;

				// input type="radio"
				case 'yesno':
				{
					print_yes_no_row($description, $name, $setting['value']);
				}
				break;

				// textarea
				case 'textarea':
				{
					print_textarea_row($description, $name, $setting['value'], 8, 40);
				}
				break;

				case 'magickfonts':
				{
					if (!empty($vbulletin->options['magickpath']))
					{
						require_once(DIR . '/includes/class_image.php');
						$image = new vB_Image_Magick($vbulletin);

						$fonts = $image->fetch_fonts();

						if (!empty($fonts))
						{
							print_select_row($description, $name, $fonts, $setting['value'], 1, 6);
						}
						else
						{
							$error = $image->fetch_error();
							print_label_row($description, "<span class=\"smallfont\"><b>$vbphrase[imagemagick_error]</b><br />" . htmlspecialchars_uni($error) . "</span>");
						}
					}
					else
					{
						print_label_row($description, $vbphrase['specify_magick_path_above']);
					}
				}
				break;

				case 'holidays':
				{
					require_once(DIR . '/includes/functions_calendar.php');
					$endtable = 0;
					foreach ($_CALENDARHOLIDAYS AS $holiday => $value)
					{

						$holidaytext .= iif(!$endtable, "<tr>\n");
						$checked = ($setting['value'] & $value) ? 'checked="checked"' : '';
						$holidaytext .= "<td><label for=\"hol$value\"><input id =\"hol$value\" type=\"checkbox\" name=\"{$name}[]\" value=\"$value\" $checked /><span class=\"smallfont\">$vbphrase[$holiday]</span></label></td>\n";
						$holidaytext .= iif($endtable, "</tr>\n");
						$endtable = iif($endtable, 0, 1);
					}
					print_label_row($description, '<table cellspacing="2" cellpadding="0" border="0">' . $holidaytext . '</tr></table>');
					break;
				}

				// cp folder options
				case 'cpstylefolder':
				{
					if ($folders = fetch_cpcss_options() AND !empty($folders))
					{
						print_select_row($description, $name, $folders, $setting['value'], 1, 6);
					}
					else
					{
						print_input_row($description, $name, $setting['value'], 1, 40);
					}
				}
				break;

				// just a label
				default:
				{
					eval("\$right = \"$setting[optioncode]\";");
					print_label_row($description, $right, '', 'top', $name);
				}
				break;
			}

			//print_description_row("<h2 align=\"center\">" . ($setting['datatype'] ? $setting['datatype'] : 'free') . "</h2>");
		}
	}
}

// #############################################################################
function validate_setting_value(&$value, $datatype)
{
	switch ($datatype)
	{
		case 'number':
			$value += 0;
			break;
		case 'boolean':
			$value = $value ? 1 : 0;
			break;
		default:
			$value = trim($value);
	}

	return $value;
}

// ###################### Start xml_importsettings #######################
// import XML settings - call this function like this:
//		$path = './path/to/install/vbulletin-settings.xml';
//		xml_import_settings();
function xml_import_settings($xml = false)
{
	global $vbulletin, $vbphrase;

	print_dots_start('<b>' . $vbphrase['importing_settings'] . "</b>, $vbphrase[please_wait]", ':', 'dspan');

	require_once(DIR . '/includes/class_xml.php');

	$xmlobj = new XMLparser($xml, $GLOBALS['path']);
	if ($xmlobj->error_no == 1)
	{
			print_dots_stop();
			print_stop_message('no_xml_and_no_path');
	}
	else if ($xmlobj->error_no == 2)
	{
			print_dots_stop();
			print_stop_message('please_ensure_x_file_is_located_at_y', 'vbulletin-settings.xml', $GLOBALS['path']);
	}

	if(!$arr = $xmlobj->parse())
	{
		print_dots_stop();
		print_stop_message('xml_error_x_at_line_y', $xmlobj->error_string(), $xmlobj->error_line());
	}

	if (!$arr['settinggroup'])
	{
		print_dots_stop();
		print_stop_message('invalid_file_specified');
	}

	$product = (empty($arr['product']) ? 'vbulletin' : $arr['product']);

	// delete old volatile settings and settings that might conflict with new ones...
	$vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "settinggroup WHERE volatile = 1 AND (product = '" . $vbulletin->db->escape_string($product) . "'" . iif($product == 'vbulletin', " OR product = ''") . ')');
	$vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "setting WHERE volatile = 1 AND (product = '" . $vbulletin->db->escape_string($product) . "'" . iif($product == 'vbulletin', " OR product = ''") . ')');

	// run through imported array
	if (!is_array($arr['settinggroup'][0]))
	{
		$arr['settinggroup'] = array($arr['settinggroup']);
	}
	foreach($arr['settinggroup'] AS $group)
	{
		// need check to make sure group product== xml product before inserting new settinggroup
		if (empty($group['product']) OR $group['product'] == $product)
		{
			// insert setting group
			/*insert query*/
			$vbulletin->db->query_write("
				INSERT IGNORE INTO " . TABLE_PREFIX . "settinggroup
				(grouptitle, displayorder, volatile, product)
				VALUES
				('" . $vbulletin->db->escape_string($group['name']) . "', " . intval($group['displayorder']) . ", 1, '" . $vbulletin->db->escape_string($product) . "')
			");
		}

		// build insert query for this group's settings
		$qBits = array();
		if (!is_array($group['setting'][0]))
		{
			$group['setting'] = array($group['setting']);
		}
		foreach($group['setting'] AS $setting)
		{
			if (isset($vbulletin->options["$setting[varname]"]))
			{
				$newvalue = $vbulletin->options["$setting[varname]"];
			}
			else
			{
				$newvalue = $setting['defaultvalue'];
			}
			$qBits[] = "(
				'" . $vbulletin->db->escape_string($setting['varname']) . "',
				'" . $vbulletin->db->escape_string($group['name']) . "',
				'" . $vbulletin->db->escape_string(trim($newvalue)) . "',
				'" . $vbulletin->db->escape_string(trim($setting['defaultvalue'])) . "',
				'" . $vbulletin->db->escape_string(trim($setting['datatype'])) . "',
				'" . $vbulletin->db->escape_string($setting['optioncode']) . "',
				" . intval($setting['displayorder']) . ",
				" . intval($setting['advanced']) . ",
				1,
				'" . $vbulletin->db->escape_string($product) . "'\n\t)";
		}
		// run settings insert query
		/*insert query*/
		$vbulletin->db->query_write("
			INSERT INTO " . TABLE_PREFIX . "setting
			(varname, grouptitle, value, defaultvalue, datatype, optioncode, displayorder, advanced, volatile, product)
			VALUES
			" . implode(",\n\t", $qBits));
	}

	// rebuild the $vbulletin->options array
	build_options();

	// stop the 'dots' counter feedback
	print_dots_stop();

}


// ###################### Start getstylesarray #######################
function fetch_style_title_options_array($titleprefix = '', $displaytop = false)
{
	require_once(DIR . '/includes/adminfunctions_template.php');
	global $stylecache;

	cache_styles();
	$out = array();

	foreach($stylecache AS $style)
	{
		$out["$style[styleid]"] = $titleprefix . construct_depth_mark($style['depth'], '--', iif($displaytop, '--', '')) . " $style[title]";
	}

	return $out;
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: adminfunctions_options.php,v $ - $Revision: 1.65 $
|| ####################################################################
\*======================================================================*/
?>