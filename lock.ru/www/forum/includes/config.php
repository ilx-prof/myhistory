<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.5.0 Release Candidate 3                              # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2000-2005 Jelsoft Enterprises Ltd. # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS        # ||
|| #################################################################### ||
\*======================================================================*/

/*-------------------------------------------------------*\
| ****** NOTE REGARDING THE VARIABLES IN THIS FILE ****** |
+---------------------------------------------------------+
| If you get any errors while attempting to connect to    |
| MySQL, you will need to email your webhost because we   |
| cannot tell you the correct values for the variables    |
| in this file.                                           |
\*-------------------------------------------------------*/

	//	****** DATABASE TYPE ******
	//	This is the type of the database server on which your vBulletin database will be located.
	//	Valid options are mysql and mysqli.  Try to use mysqli if you are using PHP 5 and MySQL 4.1+
$config['Database']['dbtype'] = 'mysql';

	//	****** DATABASE NAME ******
	//	This is the name of the database where your vBulletin will be located.
	//	This must be created by your webhost.
$config['Database']['dbname'] = 'vbulletin';

	//	****** TABLE PREFIX ******
	//	Prefix that your vBulletin tables have in the database.
$config['Database']['tableprefix'] = 'vb_';

	//	****** TECHNICAL EMAIL ADDRESS ******
	//	If any database errors occur, they will be emailed to the address specified here.
	//	Leave this blank to not send any emails when there is a database error.
$config['Database']['technicalemail'] = 'dbmaster@domain.com';



	//	****** MASTER DATABASE SERVER NAME ******
	//	This is the hostname or IP address of the database server.
	//	It is in the format HOST:PORT. If no PORT is specified, 3306 is used.
	//	If you are unsure of what to put here, leave it at the default value.
$config['MasterServer']['servername'] = 'localhost';

	//	****** MASTER DATABASE USERNAME & PASSWORD ******
	//	This is the username and password you use to access MySQL.
	//	These must be obtained through your webhost.
$config['MasterServer']['username'] = 'root';
$config['MasterServer']['password'] = '';

	//	****** MASTER DATABASE PERSISTENT CONNECTIONS ******
	//	This option allows you to turn persistent connections to MySQL on or off.
	//	The difference in performance is negligible for all but the largest boards.
	//	If you are unsure what this should be, leave it off. (0 = off; 1 = on)
$config['MasterServer']['usepconnect'] = 0;



	//	****** SLAVE DATABASE CONFIGURATION ******
	//	If you have multiple database backends, this is the information for your slave
	//	server. If you are not 100% sure you need to fill in this information,
	//	do not change any of the values here.
$config['SlaveServer']['servername'] = '';
$config['SlaveServer']['username'] = '';
$config['SlaveServer']['password'] = '';
$config['SlaveServer']['usepconnect'] = 0;



	//	****** PATH TO ADMIN & MODERATOR CONTROL PANELS ******
	//	This setting allows you to change the name of the folders that the admin and
	//	moderator control panels reside in. You may wish to do this for security purposes.
	//	Please note that if you change the name of the directory here, you will still need
	//	to manually change the name of the directory on the server.
$config['Misc']['admincpdir'] = 'admincp';
$config['Misc']['modcpdir'] = 'modcp';

	//	Prefix that all vBulletin cookies will have
	//	Keep this short and only use numbers and letters, i.e. 1-9 and a-Z
$config['Misc']['cookieprefix'] = 'vb';

	//	******** FULL PATH TO FORUMS DIRECTORY ******
	//	On a few systems it may be necessary to input the full path to your forums directory
	//	for vBulletin to function normally. You can ignore this setting unless vBulletin
	//	tells you to fill this in. Do not include a trailing slash!
	//	Example Unix:
	//	  $config['Misc']['forumpath'] = '/home/users/public_html/forums';
	//	Example Win32:
	//	  $config['Misc']['forumpath'] = 'c:\program files\apache group\apache\htdocs\vb3';
$config['Misc']['forumpath'] = '';



	//	****** USERS WITH ADMIN LOG VIEWING PERMISSIONS ******
	//	The users specified here will be allowed to view the admin log in the control panel.
	//	Users must be specified by *ID number* here. To obtain a user's ID number,
	//	view their profile via the control panel. If this is a new installation, leave
	//	the first user created will have a user ID of 1. Seperate each userid with a comma.
$config['SpecialUsers']['canviewadminlog'] = '1';

	//	****** USERS WITH ADMIN LOG PRUNING PERMISSIONS ******
	//	The users specified here will be allowed to remove ("prune") entries from the admin
	//	log. See the above entry for more information on the format.
$config['SpecialUsers']['canpruneadminlog'] = '1';

	//	****** USERS WITH QUERY RUNNING PERMISSIONS ******
	//	The users specified here will be allowed to run queries from the control panel.
	//	See the above entries for more information on the format.
	//	Please note that the ability to run queries is quite powerful. You may wish
	//	to remove all user IDs from this list for security reasons.
$config['SpecialUsers']['canrunqueries'] = '';

	//	****** UNDELETABLE / UNALTERABLE USERS ******
	//	The users specified here will not be deletable or alterable from the control panel by any users.
	//	To specify more than one user, separate userids with commas.
$config['SpecialUsers']['undeletableusers'] = '';

	//	****** SUPER ADMINISTRATORS ******
	//	The users specified below will have permission to access the administrator permissions
	//	page, which controls the permissions of other administrators
$config['SpecialUsers']['superadministrators'] = '1';

	//	****** MySQLI OPTIONS *****
	//	PHP can be instructed to set connection paramaters by reading from the
	//	file named in 'ini_file'. Please use a full path to the file.
	//	Used to set the connection's default character set
	//	Example:
	//	$config['Mysqli']['ini_file'] = 'c:\program files\MySQL\MySQL Server 4.1\my.ini';
$config['Mysqli']['ini_file'] = '';

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: config.php.new,v $ - $Revision: 1.27 $
|| ####################################################################
\*======================================================================*/
?>