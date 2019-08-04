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

define('ATTACH_AS_DB', 0);
define('ATTACH_AS_FILES_OLD', 1);
define('ATTACH_AS_FILES_NEW', 2);

// ###################### Start checkattachpath #######################
// Returns Attachment path
function fetch_attachment_path($userid, $attachmentid = 0, $thumb = false)
{
	global $vbulletin;

	if ($vbulletin->options['attachfile'] == ATTACH_AS_FILES_NEW) // expanded paths
	{
		$path = $vbulletin->options['attachpath'] . '/' . implode('/', preg_split('//', $userid,  -1, PREG_SPLIT_NO_EMPTY));
	}
	else
	{
		$path = $vbulletin->options['attachpath'] . '/' . $userid;
	}

	if ($attachmentid)
	{
		if ($thumb)
		{
			$path .= '/' . $attachmentid . '.thumb';
		}
		else
		{
			$path .= '/' . $attachmentid . '.attach';
		}
	}

	return $path;
}

//  This function should be moved into the Attachment DM once usertools.php is converted
// ###################### Start vbmkdir ###############################
// Recursive creation of file path
function vbmkdir($path, $mode = 0777)
{
	if (is_dir($path))
	{
		if (!(is_writable($path)))
		{
			@chmod($path, $mode);
		}
		return true;
	}
	else
	{
		$oldmask = @umask(0);
		$partialpath = dirname($path);
		if (!vbmkdir($partialpath, $mode))
		{
			return false;
		}
		else
		{
			return @mkdir($path, $mode);
		}
	}
}


//  This function should be moved into the Attachment DM once usertools.php is converted
// ###################### Start checkattachpath #######################
// --> If we are saving attachments as files, this checks for the existence of a user's attachment dir
// Returns path on successful verification of existing path or creation of new path
function verify_attachment_path($userid, $attachmentid = 0, $thumb = false)
{
	global $vbulletin;

	// Allow userid to be 0 since vB2 allowed guests to post attachments
	$userid = intval($userid);

	$path = fetch_attachment_path($userid);
	if (vbmkdir($path))
	{
		if ($attachmentid)
		{
			if ($thumb)
			{
				$path .= '/' . $attachmentid . '.thumb';
			}
			else
			{
				$path .= '/' . $attachmentid . '.attach';
			}
		}
		return $path;
	}
	else
	{
		return false;
	}
}

// ###################### Start downloadFile #######################
// must be called before outputting anything to the browser
function file_download($filestring, $filename, $filetype)
{
	if (!isset($isIE))
	{
		static $isIE;
		$isIE = iif(is_browser('ie') OR is_browser('opera'), true, false);
	}

	if ($isIE)
	{
		$filetype = 'application/octetstream';
	}
	else
	{
		$filetype = 'application/octet-stream';
	}

	header('Content-Type: ' . $filetype);
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Content-Disposition: attachment; filename="' . $filename . '"');
	header('Content-Length: ' . strlen($filestring));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	echo $filestring;
	exit;
}

// ###################### Start getmaxattachsize #######################
function fetch_max_upload_size()
{
	if ($temp = @ini_get('upload_max_filesize'))
	{
		if (preg_match('#^\s*(\d+(?:\.\d+)?)\s*(?:([mkg])b?)?\s*$#i', $temp, $matches))
		{
			switch (strtolower($matches[2]))
			{
				case 'g':
					return $matches[1] * 1073741824;
				case 'm':
					return $matches[1] * 1048576;
				case 'k':
					return $matches[1] * 1024;
				default: // no g, m, k, gb, mb, kb
					return $matches[1] * 1;
			}
		}
		else
		{
			return $temp;
		}
	}
	else
	{
		return 10485760; // approx 10 megabytes :)
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: functions_file.php,v $ - $Revision: 1.55 $
|| ####################################################################
\*======================================================================*/
?>