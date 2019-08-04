<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright � 2002 - 2006 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
require_once "../maincore.php";
require_once BASEDIR."subheader.php";
require_once ADMIN."navigation.php";
include LOCALE.LOCALESET."admin/settings.php";

if (!checkrights("S3") || !defined("iAUTH") || $aid != iAUTH) fallback("../index.php");

if (isset($_POST['prune'])) require_once "forums_prune.php";

if (isset($_POST['savesettings'])) {
	$result = dbquery("UPDATE ".$db_prefix."settings SET
		numofthreads='".(isNum($_POST['numofthreads']) ? $_POST['numofthreads'] : "5")."',
		attachments='".(isNum($_POST['attachments']) ? $_POST['attachments'] : "0")."',
		attachmax='".(isNum($_POST['attachmax']) ? $_POST['attachmax'] : "150000")."',
		attachtypes='".$_POST['attachtypes']."',
		thread_notify='".(isNum($_POST['thread_notify']) ? $_POST['thread_notify'] : "0")."'
	");
	redirect(FUSION_SELF.$aidlink);
}

$settings2 = dbarray(dbquery("SELECT * FROM ".$db_prefix."settings"));

opentable($locale['400']);
require_once ADMIN."settings_links.php";
echo "<form name='settingsform' method='post' action='".FUSION_SELF.$aidlink."'>
<table align='center' cellpadding='0' cellspacing='0' width='500'>
<tr>
<td width='50%' class='tbl'>".$locale['505']."<br>
<span class='small2'>".$locale['506']."</span>
</td>
<td width='50%' class='tbl'>
<select name='numofthreads' class='textbox'>
<option".($settings2['numofthreads'] == 5 ? " selected" : "").">5</option>
<option".($settings2['numofthreads'] == 10 ? " selected" : "").">10</option>
<option".($settings2['numofthreads'] == 15 ? " selected" : "").">15</option>
<option".($settings2['numofthreads'] == 20 ? " selected" : "").">20</option>
</select>
</td>
</tr>
<tr>
<td width='50%' class='tbl'>".$locale['507']."</td>
<td width='50%' class='tbl'><select name='attachments' class='textbox'>
<option value='1'".($settings2['attachments'] == "1" ? " selected" : "").">".$locale['508']."</option>
<option value='0'".($settings2['attachments'] == "0" ? " selected" : "").">".$locale['509']."</option>
</select></td>
</tr>
<tr>
<td width='50%' class='tbl'>".$locale['510']."<br>
<span class='small2'>".$locale['511']."</span></td>
<td width='50%' class='tbl'><input type='text' name='attachmax' value='".$settings2['attachmax']."' maxlength='150' class='textbox' style='width:100px;'></td>
</tr>
<tr>
<td width='50%' class='tbl'>".$locale['512']."<br>
<span class='small2'>".$locale['513']."</span></td>
<td width='50%' class='tbl'><input type='text' name='attachtypes' value='".$settings2['attachtypes']."' maxlength='150' class='textbox' style='width:200px;'></td>
</tr>
<tr>
<td width='50%' class='tbl'>".$locale['519']."</td>
<td width='50%' class='tbl'><select name='thread_notify' class='textbox'>
<option value='1'".($settings2['thread_notify'] == "1" ? " selected" : "").">".$locale['508']."</option>
<option value='0'".($settings2['thread_notify'] == "0" ? " selected" : "").">".$locale['509']."</option>
</select></td>
</tr>
<tr>
<td width='50%' class='tbl'>".$locale['514']."<br>
<span class='small2'><font color='red'>".$locale['515']."</font> ".$locale['516']."</span></td>
<td width='50%' class='tbl'>
<input type='submit' name='prune' value='".$locale['517']."' class='button'>
<select name='prune_days' class='textbox' style='width:50px;'>
<option>10</option>
<option>20</option>
<option>30</option>
<option>60</option>
<option>90</option>
<option>120</option>
<option selected>180</option>
</select>
".$locale['518']." 
</td>
</tr>
<tr><td align='center' colspan='2' class='tbl'><br>
<input type='submit' name='savesettings' value='".$locale['750']."' class='button'></td>
</tr>
</table>
</form>\n";
closetable();

echo "</td>\n";
require_once BASEDIR."footer.php";
?>