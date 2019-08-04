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

// #############################################################################
/**
* Function to print an array quickly
*
* @param        array  The array to display
* @param        string The name of the array (optional)
*/
function echo_array(&$array, $title = '')
{
	echo '<pre>' . ($title == '' ? '' : "$title ");
	print_r($array);
	echo '</pre>';
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: functions_debug.php,v $ - $Revision: 1.1 $
|| ####################################################################
\*======================================================================*/
?>
