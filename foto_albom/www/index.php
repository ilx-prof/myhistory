<?php

// EasyPhpAlbum - a single script thumbnail gallery
//
// Copyright (C)	2004-2006  JF Nutbroek
// Web: 		http://www.mywebmymail.com
//
// Version 1.3.7 - September 2006
// Requires PHP 4.1.0 and GDlib 1.6 (or greater)
//
// This program is free software; you can redistribute it and/or modify 
// it under the terms of the GNU General Public License as published by 
// the Free Software Foundation; either version 2 of the License, or 
// (at your option) any later version. 
//
// This program is distributed in the hope that it will be useful, 
// but WITHOUT ANY WARRANTY; without even the implied warranty of 
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
// GNU General Public License for more details. 
//
// You should have received a copy of the GNU General Public License 
// along with this program; if not, write to the Free Software 
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA 
//
// ***********************************************************************************************
// *												 *
// * Quick start:										 *
// *												 *
// * Upload your photos and this index.php script to a directory on your webserver - thats all!! *
// *												 *
// *********************************************************************************************** 
// *												 *
// * Take full advantage of all options (RECOMMENDED!!) and create multiple albums:		 *
// *												 *
// * Enable admin access (see line 90) and save this index.php file.				 *
// * Create a write-enabled directory 'photoalbums' on your webserver and upload this file.	 *
// * Enter the URL in your browser: http://www.yoursite.com/photoalbums/ and press the 'Tab'	 *
// * key on your keyboard to get to the administrator login screen and create your album(s).	 *
// *												 *
// * For MANUAL CONFIGURATION edit the configuration section B in this script (not recommended)  *
// *												 *
// ***********************************************************************************************
//
// ### Multiple Albums - Manual configuration ####################################################
//
// Create subdirectories and copy this index.php script in each subdirectory:
//
// [photoalbums]			- Main directory for your albums or gallery
//	- index.php			- This index.php script, it will be your main album page
//	- [Vacation Holland 2003]	- Subdirectory in [photoalbums] for your first album
//		- index.php		- This index.php script
//		- Amsterdam.jpg		- Photo in this album
//	 - [Vacation Germany 2002]	- Subdirectory in [photoalbums] for your 2nd album
//		- index.php		- This index.php script
//		- Berlin.jpg		- Photo in this album 
//
// If you would like to have a specific order start directory & filenames with 001, 002, 003 etc.
// Example directory name: '001 Vacation Holland', example file name: '001 Amsterdam.jpg'
//
// ### Integration of EasyPhpAlbum on your website ###############################################
//
// In a CMS add a new menu item called 'wrapper'. Point the link to this index.php script
//
// Or as plain HTML: Add an 'iframe' to your page that points to this index.php script. Example:
// 
// <iframe width="100%" height="600" marginwidth="0" marginheight="0" scrolling="no" 
// 	frameborder="0" allowtransparency="true" src="/photoalbums/index.php"></iframe> 
//
// ### Adding a special 'index' icon or photo ####################################################
//
// Add an 'index.jpg', 'index.gif' or 'index.png' to your album which will be used on the main 
// album index page. Usefull if you want a specific icon or photo to represent the album.
//
// ### Multimedia Support - Create music and movie albums ########################################
//
// Enable multimedia support, add a MP3 file to the album and an image with the same name OR add
// an icon with the name mp3.png to the multimedia-icon directory to represent all MP3 files. 
//
// ### Known problems - please check www.mywebmymail.com for more info ###########################
//
// A large photo will not create a thumbnail due to the PHP memory limit (increase limit php.ini)
// If thumbnails are not created, set $gd2=true to $gd2=false (see configuration section B)
// It is NOT possible to rename this script, it will look for other albums index.php files
// Do not use special characters in filenames or directory names (like: ')
//
// ***********************************************************************************************
//
// CONFIGURATION SECTION-A : Only editable in this script, make changes and save before uploading
//
// ### Login - Administrator access

$admin_access=true;			// Change to true for EASY configuration, press 'Tab' key or add ?admin=1 behind your URL, http://www.web.com/photoalbum/index.php?admin=1: true or false
$admins='admin,password';		// Admin(s) with access to this album: 'login-name,password' comma separated - change this to your own login-name and password!!
$admin_ip='';				// Allow admin login from specified IP addresses only, one or multiple IP's comma separated - optional
$enable_admin_keyboardshortcut=true;	// Press 'Tab' key on your keyboard to continue to the admin login screen: true or false

// ### Hosting the album

$max_albums=0;				// Maximum amount of albums 0=unlimited
$max_album_size=0;			// Maximum filesize of album in MB 0=unlimited
$allow_configuration=true;		// Allow modification of the configuration; true or false
$allow_create_album=true;		// Allow creation of new albums; true or false
$comment_size=250;			// Maxmimum amount of characters in visitor comment

// ### Permanent batch image resize

$resizeimages=false;			// Set to true to auto-resize all uploaded photos permanently for smaller filesize - EXIF information is lost - write access required
$resizeto=640;				// Size in px for permanent resize (min. 30 pixels)
//set_time_limit(360);			// Optional: Allow more time for batch resizing (when script times-out - remove the // at the beginning of this line)

// ### Colors for EasyPhpAlbum logo

$logo_line_color='#FE9900';		// Logo line color
$logo_text_color='#0A7FDC';		// Logo text color

// ### Translations for the visitors

$language_page='Page';							// Text for page number - Change this in your own language
$language_homepage='Home';						// Text for homepage button in menu - change this in your own language
$language_albums='Albums';						// Text for amount of albums - change this in your own language
$language_photos='Photos';						// Text for amount of photos - change this in your own language
$language_view='View';							// Text for tooltip image- change this in your own language
$language_view_next='->';						// Text for next image link- change this in your own language
$language_view_previous='<-';						// Text for previous image link- change this in your own language
$language_viewnext='Click to view next image (or use arrow keys)';	// Text for tooltip image in popup window - change this in your own language
$language_viewmm='Play multimedia file';				// Text for tooltip multimedia file - change this in your own language
$language_dir_empty='Directory empty';					// Text for empty directory - change this in your own language
$language_login='Login';						// Text for login - change this in your own language
$language_logout='Logout';						// Text for logout - change this in your own language
$language_user='Username';						// Text for username - change this in your own language
$language_passw='Password';						// Text for password - change this in your own language
$language_slideshow='start slideshow';					// Text for starting slideshow - change this in your own language
$language_stop_slideshow='stop slideshow';				// Text for stopping slideshow - change this in your own language
$language_hitcounter_tooltip='Hit counter';				// Text for tooltip of hit counter - change this in your own language
$language_email_alt='Email this page to a friend';			// Text for tooltip of email button - change this in your own language
$language_email_subject='EasyPhpAlbum';					// Text for email subject line - change this in your own language
$language_email_comment='Please copy this link in your browser:';	// Text for email comment line - change this in your own language
$language_download='right-click to download: ';				// Text for download link - change this in your own language
$language_rating='rating:';						// Text for rating photo - change this in your own language
$language_hits='hits:';							// Text for hits photo - change this in your own language
$language_countcomments='total comments: ';				// Text for thumbnail comments counter - change this in your own language
$language_rating_votes='votes';						// Text for rating photo amount of votes - change this in your own language
$language_rating_tooltip='Rating (5=excellent / 1=poor)';		// Text for rating tooltip - change this in your own language
$language_rating_choose='Choose a rating';				// Text for rating selection - change this in your own language
$language_rating_excellent='5 - Excellent';				// Text for rating selection - change this in your own language
$language_rating_verygood='4 - Very good';				// Text for rating selection - change this in your own language
$language_rating_good='3 - Good';					// Text for rating selection - change this in your own language
$language_rating_fair='2 - Fair';					// Text for rating selection - change this in your own language
$language_rating_poor='1 - Poor';					// Text for rating selection - change this in your own language
$language_add_comment='add comment';					// Text for visitors to add a comment - change this in your own language
$language_add_file='Upload file';					// Text for visitors to add a file - change this in your own language
$language_save_comment='Save comment';					// Text for visitors to save the comment - change this in your own language
$language_upload_comment='Upload file(s)';				// Text for visitors to upload files - change this in your own language
$language_username_comment='Nickname';					// Text for visitors to add nickname to the comment or file upload - change this in your own language
$language_comment_max='Maxmimum amount of characters';			// Text for visitors maximum comment characters - change this in your own language
$language_up='Up';							// Text for menu directory up - change this in your own language
$language_shop_info='No. of copies and type:';				// Text for shop number of copies per photo - change this in your own language
$language_shop_order='Place order';					// Text for shop order button - change this in your own language
$language_shop_cancel='Cancel';						// Text for shop cancel button - change this in your own language
$language_shop_address='Your address:';					// Text for shop address - change this to your own language
$language_shop_email_address='Your email-address:';			// Text for shop address - change this to your own language
$language_shop_ordercomments='Your order and comments:';		// Text for shop address - change this to your own language
$language_shop_confirmation='Order send - we will contact you asap.';	// Text for shop address - change this to your own language
$language_sort_option1='standard album sort';				// Options for visitor album sort - change this to your own language
$language_sort_option2='sort by hitcounter';				// Options for visitor album sort - change this to your own language
$language_sort_option3='sort by comments';				// Options for visitor album sort - change this to your own language
$language_sort_option4='sort by rating';				// Options for visitor album sort - change this to your own language
$language_sort_option5='sort by date';					// Options for visitor album sort - change this to your own language
$language_search='Search';						// Text for search option - change this to your own language
$language_search_keyword='Keyword for search';				// Text for search option keyword - change this to your own language
$language_search_noresults='Search returned no hits';			// Text for search option nothing found - change this to your own language
$language_search_cancel='Back';						// Text for search option cancel - change this to your own language
$language_visitor_upload_message='Upload OK';				// Text for successful upload - change this to your own language and/or add ' submitted for review'

// **************************************************************************************************
// *												    *
// * A 'configuration.php' file created by this script overrides the configuration section B below! *
// *												    *
// **************************************************************************************************
//
// CONFIGURATION SECTION-B : Also editable using the administrator web-interface (recommended)

// ### Login - Restrict access for visitors

$restrict_access=false;				// Ask for valid login and password: true or false
$users='fred,1234,guest,guestpassword';		// User(s) with access to this album: 'name,password' comma separated

// ### Server & navigation

$gd2=true;					// Set to true if your server has GDLib2+ (for better quality thumbnails)
$title='EasyPhpAlbum 1.3.7';			// Page title - leave empty to display directory name
$home_page='http://www.mywebmymail.com';	// Menu link to another page or homepage of your website - leave empty to disable
$show_email_link=false;				// Shows 'email' button: true or false
$show_poweredby_easyphpalbum=true;		// Set to true or false. True is strongly recommended! ;)
$imagemagick=false;				// Use ImageMagick (when installed on server) for resize/rotate of images in admin section
$imagemagick_path='';				// The path to ImageMagick (leave empty if link is available on server) otherwise use for example '/usr/bin/'
$show_bottommenu=true;				// Display bottom album navigation menu: true or false
$show_topmenu=false;				// Display top album navigation menu: true or false
$show_dir_up=false;				// Display menu item 'directory up' - required for sub-sub-dir structure: true or false
$show_statistics=true;				// Show album statistics on main page: true or false
$use_main_config=false;				// Use configuration file from main album index page: true or false
$use_album_config='';				// Use configuration from other album - enter directory or album name or leave empty to disable
$enable_keyboard_arrows=true;			// Use the arrows keys on your keyboard to continue to the next or previous photo: true or false
$ban_ip='';					// IP adresses to ignore for the hitcounter, rating, comment and upload system - add one or multiple IP's comma separated, example: 127.0.0.1,10.0.0.150

// ### Thumbnail layout and creation

$thumb_size=160;			// Size in px for thumbnails (min. 30 pixels)
$border_width=0;			// Add border around photo - width in px (0=no border)
$show_bordershadow=false;		// Display shadow around border: true or false
$show_binder=false;			// Display binder: true or false
$binder_spacing=8;			// Space between binder-rings in px
$clip_corner=15;			// Clip corner of photo - size in % of width (0=no clipping)
$clip_corner_round=true;		// Clip corner of photo - rounded or straight: true or false
$clip_topleft=false;			// Clip top left corner: true or false
$clip_topright=true;			// Clip top right corner: true or false
$clip_bottomleft=true;			// Clip bottom left corner: true or false
$clip_bottomright=true;			// Clip bottom right corner: true or false
$clip_randomly=false;			// Randomly clip 'enabled' corners: true or false
$show_number=false;			// Display photo number in thumbnail: true or false
$create_thumbnail_cache=true;		// Save thumbnails for faster display (recommended) - requires write access to (sub)directory: true or false
$thumbnail_txtfile=false;		// Display textfile from photo with thumbnail: true or false
$thumbnail_opacity=false;		// Use 'fade-out/fade-in' thumbnails: true or false
$opacity_level=50;			// Set opacity between 0 and 100; 0=invisible and 100=normal
$thumbnail_countcomments=false;		// Show amount of comments for photo: true or false
$indeximage_no_thumb=true;		// Do not 'thumbnailize' the albums index.jpg png or gif image: true or false
$thumbnail_borderpng='';		// Add a border to the thumbnail, filelocation of the (transparent) PNG image file, example 'gfx/border.png'
$thumbnail_spacing=0;			// Width in px of thumbnail-cell (0=autosize)
$thumbnail_rotation=false;		// Rotate the thumbnail: true or false
$thumbnail_rotation_degrees=0;		// 0=random, otherwise: 45 or -45
$valign_thumbnail='top';		// Alignment of thumbnail: 'middle', 'top' or 'bottom'
$show_thumb_name_top=false;		// Show name above thumbnail: true or false
$square_thumbnails=false;		// Create thumbnails with the same width & height: true or false
$animated_thumbnails=false;		// Do not 'thumbnailise' GIF images: true or false

// ### Page layout and behaviour

$images_per_page=6;			// Number of photos to display per page
$columns_per_page=3;			// Number of photos next to each other
$popup=false;				// Display photo in popup or on page: true or false
$popup_force_focus=false;		// Set to true to force window on top (only for popup)
$popup_browse=true;			// Browse photos in popup window: true or false
$image_border=false;			// Display border around photo (only when $popup=false): true or false
$slideshow=true;			// Enable slideshow: true or false
$slideshow_delay=6000;			// Time between slides in milliseconds (1 second = 1000 milliseconds). Minimum 1 second.
$page_header=true;			// Show page title and line (false=compact format): true or false
$center_title=false;			// Centers title on page: true or false
$center_album=false;			// Centers all content on page: true or false
$sort_thumbs=false;			// Sort thumbs according to (exif) date, new to old: true or false
$sort_rating=false;			// Sort thumbs according to rating score, high to low: true or false
$sort_hits=false;			// Sort thumbs according to total hits, high to low: true or false
$sort_comments=false;			// Sort thumbs according to total comments, high to low: true or false
$sort_hightolow=true;			// Sort from high/new to low/old (score/rating and date): true or false
$visitor_sort=false;			// Allow visitors to sort the photos in the album: true or false
$visitor_search=false;			// Allow visitors to search the photos by keyword in the album: true or false
$visitor_search_columns=3;		// Search result - amount of photos next to each other
$background_image='';			// The URL for your background image (example: 'http://www.mywebmymail.com/bg.gif'), leave empty for no background
$background_repeat='no-repeat';		// Repeat your background image, valid settings: repeat / repeat-x / repeat-y / no-repeat
$background_position='50% 50%';		// Position your background image based on % of width and % of height of page (50% 50% =centered)
$menu_background_image='';		// The URL for your menu background image (example: 'http://www.mywebmymail.com/bg.gif'), leave empty for no background
$content_width='85%';			// The width of the page content: % or px, example: 85% or 800px
$content_leftmargin='10px';		// The left margin of the page content: % or px, example: 5% or 10px
$page_leftmargin='20px';		// The left margin of the page: % or px, example: 0% or 20px
$header='';				// The URL to an image to use as a page header, leave empty to disable
$footer='';				// The URL to an image to use as a page footer, leave empty to disable
$transparent_page=false;		// Make album background transparent for site integration: true or false
$transparent_menu=false;		// Make album menu background transparent for site integration: true or false
$show_previous_next=false;		// When displaying the photo, show the thumbnails of the previous and next photo: true or false
$show_prev_next_below=false;		// Show previous and next thumbnail below the photo: true or false
$show_prev_next_size=80;		// Size of previous and next thumbnail in px
$show_prev_next_position='middle';	// Alignment of previous and next thumbnail: 'middle', 'top' or 'bottom'
$link_bigimage=false;			// Add a link to the photo to view it fullsize: true or false
$imagefader=false;			// Gradually fade a photo in (and out with slideshow enabled): true or false

// ### Photo information

$show_name=true;						// Display file name: true or false (tip: use filename as short description for photo)
$show_name_top=true;						// Display file name above image: true or false
$show_details=false;						// Display photo dimensions & filesize: true or false
$show_date=false;						// Display date of photo (based on EXIF-date, if not available uses file-date): true or false
$show_date_format='d-M-Y H:i';					// Format for date - see PHP manual function date to change this
$show_exif_comment=false;					// Display EXIF comment from photo (only when $popup=false): true or false
$show_iptc_caption=false;					// Display the IPTC caption from photo  (only when $popup=false): true or false
$show_download=false;						// Show download link for photo in original size: true or false
$image_txtfile=true;						// Display text from a textfile (only when $popup=false). Filename for text file is same as photo (myphoto.jpg >> myphoto.txt): true or false
$visitor_comments=false;					// Allow visitors to enter a comment with the photo: true or false
$visitor_comments_dateformat='d/M/Y H:i';			// Format for date with comment - see PHP manual function date to change this
$visitor_upload=false;						// Allow visitors to upload a file (be carefull!): true or false
$visitor_password=false;					// Require valid password for uploading files: true or false
$visitor_upload_size=2048;					// Maximum upload size for files from visitors in kB (2048 kB = 2 MB)
$visitor_upload_max_files=6;					// Maximum amount of files that can be uploaded by visitor simultaneously: 1 to 6 maximum
$visitor_files='png,gif,jpg,jpeg,swf,zip';			// Allow visitors to upload the specified file(s), comma separated 
$visitor_upload_adminreview=false;				// Uploaded files will first be placed in the albums backup directory for review by the album administrator: true or false
$upload_email='';						// Enter your email address to receive a notification of new uploads by mail, leave empty to disable
$comment_email='';						// Enter your email address to receive a copy of the comment by mail, leave empty to disable
$comment_logip=false;						// Save and display IP address with comment: true or false
$hit_counter=false;						// Enable hit counter - views per photo (not album), requires write access: true or false
$hit_counter_random=true;					// Display segments irregular: true or false
$hit_counter_text=false;					// Use text based hitcounter: true or false
$rating=false;							// Enable rating system - vistors rate the photo/multimediafile from scale 5 (excellent) to 1 (poor) - only when $popup=false, requires write access: true or false
$rating_text=false;						// Use text based rating - vistors rate the photo/multimediafile from scale 5 (excellent) to 1 (poor) - only when $popup=false, requires write access: true or false
$name_bold=true;						// Write photo name in bold: true or false
$name_italic=true;						// Write photo name in italic: true or false
$info_bold=false;						// Write photo information in bold: true or false
$info_italic=false;						// Write photo information in italic: true or false

// ### Photo manipulation for display

$image_resize=true;			// Set to true to resize photo for display, use this to show large photos in a smaller size: true or false
$image_resizeto=480;			// Size in px for resize (min. 30 pixels) or 0 for auto-resize
$image_inflate=false;			// Allow photo to be enlarged: true or false
$copyright='www.mywebmymail.com';	// Add copyright notice to photo (only when $image_resize=true)
$copyright_position='0% 100%';		// Position of copyright notice based on % of width and % of height of original image (50% 50% =centered)
$watermark='';				// Add a watermark to the photo (only when $image_resize=true and GDLib2+), filelocation of the (transparent) PNG image file, example 'gfx/watermark.png'
$watermark_position='100% 100%';	// Position of watermark image based on % of width and % of height of original image (50% 50% =centered)
$watermark_transparancy=100;		// Transparency for watermark, 0 to 100: 0=not visible, 100=visible
$image_greyscale=false;			// Convert color jpg photo to grayscale (only when $image_resize=true) - only for GDLib2+
$image_sepia_depth=80;			// Add 'aged' effect to jpg photo only when $image_greyscale=true (0=disabled) - only for GDLib2+
$image_noise_depth=10;			// Add random noise to jpg photo to make it look older only when $image_greyscale=true (0=disabled) - only for GDLib2+
$apply_thumbnail_borderpng=false;	// If you configured a border image for the thumbnail apply it to the photo as well: true or false

// ### Photo shop system

$shop=false;							// Use shop system: true or false
$shop_email='';							// The email address the order will be emailed to
$shop_choice1='-,1x,2x,3x,4x,5x';				// Ordering information first selection box, comma separated 
$shop_choice2='-,09x13cm,10x15cm,11x17cm,13x18cm,25x30cm';	// Ordering information second selection box, comma separated (leave empty to disable box)
$shop_columns=4;						// All photos will be shown on a single page, this sets the amount of photos next to each other

// ### MultiMedia Files (MP3,Mpeg,AVI etc.)

$play_multimedia=false;				// Enable or Disable multimedia support (to link a photo to a MP3 file, include a MP3 with the same name as the photo): true or false
$embed_player=true;				// Embeds the player underneath the photo: true or false
$link_player=false;				// Creates a link from the image to the multimedia file: true or false
$download_multimedia=false;			// Add a download link to the multimedia file
$movie_formats='mpg,mpeg,avi,mov,swf,wmv';	// File extensions for supported movie files
$sound_formats='mp3,wav,au,wma,ogg';		// File extensions for supported sound files
$mm_watermark='';				// Add a 'multimedia' watermark to the image (only when $image_resize=true and GDLib2+), filelocation of the (transparent) PNG image file, example 'gfx/multimedia_watermark.png'
$mm_watermark_position='100% 100%';		// Position of multimedia watermark image based on % of width and % of height of original image (50% 50% =centered)
$mm_watermark_transparancy=100;			// Transparency for multimedia watermark, 0 to 100: 0=not visible, 100=visible
$mm_dir='';					// Directory for multimedia images (add a mp3.jpg to represent MP3 images, mpeg.png to represent MPEG files etc.), example 'gfx/'
$mm_thumbnail=false;				// Apply thumbnail settings to multimedia image: true or false
$mm_photo=false;				// Apply photo manipulation settings to multimedia image: true or false

// ### Page,Photo & Menu colors

$page_color='#000000';				// Page background color
$text_color='#FFFFFF';				// Text color
$text_hover_color='#FE9900';			// Text hover color
$title_color='#0A7FDC';				// Title color
$border_color='#000000';			// Photo border color
$table_color='#000000';				// Table background color
$item_border_color='#000000';			// Border color table
$line_color='#FE9900';				// Color for lines
$email_color='#FFFF99';				// Color for email button
$menu_line_width='1';				// Menu border line thickness in px (top+bottom)
$menu_bar_width='0';				// Menu bar line thickness in px (left + right)
$menu_bordertop_color='#FE9900';		// Menu border top color
$menu_borderbottom_color='#FE9900';		// Menu border bottom color
$menu_borderleft_color='#FE9900';		// Menu border left color
$menu_borderright_color='#FE9900';		// Menu border right color
$menu_bordertop_hover_color='#FE9900';		// Menu border hover top color
$menu_borderbottom_hover_color='#FE9900';	// Menu border hover bottom color
$menu_borderleft_hover_color='#FE9900';		// Menu border hover left color
$menu_borderright_hover_color='#FE9900';	// Menu border hover right color
$menu_text_color='#0A7FDC';			// Menu text color
$menu_texthover_color='#FE9900';		// Menu text hover color
$menu_background_color='#000000';		// Menu background color
$menu_background_hover_color='#000000';		// Menu background hover color
$hit_counter_linecolor='#999999';		// Hit counter line color
$hit_counter_segmentcolor='#000000';		// Hit counter segment color
$hit_counter_textcolor='#FFFFFF';		// Hit counter text color
$rating_blockcolor='#CCCCCC';			// Rating color - no score
$rating_blockcolor_score='#FF0000';		// Rating color - score

// ### META information for search-engines

$meta_description='EasyPhpAlbum, an online photo, music and movie album with lots of features.';	// Short description for your album
$meta_keywords='easy,album,photo,movie,music,www.mywebmymail.com,easyphpalbum,gallery,thumbnails';	// Search keywords comma separated
$meta_copyright_and_author='JF Nutbroek - www.mywebmymail.com';						// Copyright and author of the website

// End of configuration
//
// ***********************************************************************************************

// Check if a configuration file exists - overrides the configuration in this index.php script
if (file_exists('configuration.php')) {include('configuration.php');}
$album_config=true;
if ($use_main_config) {
	if (file_exists('../configuration.php')) {
		include('../configuration.php');
		$album_config=false;
	}
}
if ($use_album_config!='') {
	if (file_exists("../$use_album_config/configuration.php")) {
		include("../$use_album_config/configuration.php");
		$album_config=false;
	}
}

// Check if a logout was requested
if (isset($_REQUEST['logout'])) {
	session_start();
	session_unset();
	session_destroy();
	if ($_REQUEST['logout']==1) {setcookie('epa','',time()-3600);} else {setcookie('epaadmin','',time()-3600);}
	if ($restrict_access) {require_login();}
}

// Check for administrator login
if ($admin_access && isset($_REQUEST['admin'])) {
	$users_configured=$users;
	$restrict_access_configured=$restrict_access;
	$users=$admins;
	$restrict_access=true;
	$admin_link='admin=1';
	if ($admin_ip!='') {
		$valid_ips=explode(',',$admin_ip);
		if (!in_array($_SERVER['REMOTE_ADDR'],$valid_ips)) {$users='';}
	}
} else {
	$admin_link='';
}

// Check for valid login - cookie and/or session
$logged_in=false;
if ($restrict_access || isset($_REQUEST['requirelogin'])) {
	session_start();
	$valid_users=explode(',',$users);
	foreach ($valid_users as $key => $user)
		$valid_users[$key]=md5($user . date('d'));
	if ($admin_link!='') {$cookiename='epaadmin';} else {$cookiename='epa';}
	// Check if cookie data is available and valid
	if (isset($_COOKIE[$cookiename])) {
		$cookie_data=explode('@',$_COOKIE[$cookiename]);
		if (count($cookie_data)==3) {
			if (in_array($cookie_data[0],$valid_users)) {
				$user_index=array_search($cookie_data[0],$valid_users);
				if ($valid_users[$user_index+1]!=$cookie_data[1])
					require_login();
				else if (md5($_SERVER['HTTP_USER_AGENT'])!=$cookie_data[2])
					require_login();
			} else {
				require_login();
			}
		} else {
			require_login();
		}
	// Check if form data is submitted  and valid
	} else if (isset($_REQUEST['new_user']) && isset($_REQUEST['new_password'])) {
		if (in_array(md5($_REQUEST['new_user'] . date('d')),$valid_users)) {
			$user_index=array_search(md5($_REQUEST['new_user'] . date('d')),$valid_users);
			if ($valid_users[$user_index+1]!=md5($_REQUEST['new_password'] . date('d'))) {
				require_login();
			} else {
				$_SESSION['epa_user']=md5($_REQUEST['new_user'] . date('d'));
				$_SESSION['epa_passw']=md5($_REQUEST['new_password'] . date('d'));
				$_SESSION['epa_agent']=md5($_SERVER['HTTP_USER_AGENT']);
				setcookie($cookiename,$_SESSION['epa_user'] . '@' . $_SESSION['epa_passw'] . '@' . $_SESSION['epa_agent'],time()+3600);
			}
		} else {
			require_login();
		}
	// Check if current session is valid
	} else if (isset($_SESSION['epa_passw']) && isset($_SESSION['epa_user']) && isset($_SESSION['epa_agent'])) {
		if ($_SESSION['epa_agent']!=md5($_SERVER['HTTP_USER_AGENT'])) {require_login();}
		if (in_array($_SESSION['epa_user'],$valid_users)) {
			$user_index=array_search($_SESSION['epa_user'],$valid_users);
			if ($valid_users[$user_index+1]!=$_SESSION['epa_passw']) {require_login();}
		} else {
			require_login();
		}
	// Session data and form data is invalid
	} else {
		require_login();
	}
	if ($visitor_password) {$logged_in=true;}
}
// Check for admin requests
if ($admin_link!='') {
	// Show configuration menu
	if (isset($_REQUEST['configuration'])) {configuration();}
	$supportedformats=explode(',',$movie_formats.','.$sound_formats.',png,gif,jpg,jpeg,txt,zip');
	// Rename image or directory
	if (isset($_REQUEST['renameimagenew']) && isset($_REQUEST['renameimageold'])) {
		$renameimageold=$_REQUEST['renameimageold'];
		if (is_file($renameimageold)) {
			$extension=strtolower(substr($renameimageold,strrpos($renameimageold,'.')+1,strlen($renameimageold)));
			if ($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif'|| in_array($extension,$supportedformats)) {
				$newimagefilename=str_replace('/','',$_REQUEST['renameimagenew']);
				$newimagefilename=str_replace('..','',$newimagefilename);
				@rename($renameimageold,$newimagefilename.'.'.$extension);
				$renameimageoldtxt=substr($renameimageold,0,strrpos($renameimageold,'.')).'.txt';
				if (file_exists($renameimageoldtxt))
					@rename($renameimageoldtxt,$newimagefilename.'.txt');
				else if (file_exists('textfiles/'.$renameimageoldtxt))
					@rename('textfiles/'.$renameimageoldtxt,'textfiles/'.$newimagefilename.'.txt');
			}
		} else if (is_dir($renameimageold)) {
			$albumname=ereg_replace("[^[:space:]a-zA-Z0-9*_.-]","",$_REQUEST['renameimagenew']);
			@rename($renameimageold,$albumname);
		}
	}
	// Delete a file or directory
	if (isset($_REQUEST['imagefilename'])) {
		$imagefilename=str_replace('/','',$_REQUEST['imagefilename']);
		$imagefilename=str_replace('..','',$imagefilename);
		if (isset($_REQUEST['backup'])) {
			if ($_REQUEST['backup']==1)
				$imagefilename='backup/'.$imagefilename;
		}
		if (is_file($imagefilename) || is_file('textfiles/'.$imagefilename)) {
			$extension=strtolower(substr($imagefilename,strrpos($imagefilename,'.')+1,strlen($imagefilename)));
			if ($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif' || in_array($extension,$supportedformats)) {
				if (file_exists($imagefilename)) {@unlink($imagefilename);}
				if (is_dir('thumbnails')) {$subdir='thumbnails/';} else	{$subdir='';}
				if (file_exists($subdir.substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumbindex.' . $extension))
					@unlink($subdir.substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumbindex.' . $extension);
				if (file_exists($subdir.substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumb.' . $extension))
					@unlink($subdir.substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumb.' . $extension);
				// Delete rating and hitcounter files as well
				$imagefilename=substr($imagefilename,0,strrpos($imagefilename,'.')).'.stat';
				if (file_exists($imagefilename))
					@unlink($imagefilename);
				else if (file_exists('hitcounters/'.$imagefilename))
					@unlink('hitcounters/'.$imagefilename);
				$imagefilename=substr($imagefilename,0,strrpos($imagefilename,'.')).'.rate';
				if (file_exists($imagefilename))
					@unlink($imagefilename);
				else if (file_exists('ratings/'.$imagefilename))
					@unlink('ratings/'.$imagefilename);
			} else if ($extension=='txt') {
				if (file_exists($imagefilename))
					@unlink($imagefilename);
				else if (file_exists('textfiles/'.$imagefilename))
					@unlink('textfiles/'.$imagefilename);
			}
		} else if (is_dir($imagefilename)) {
			removedir(str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename.'/hitcounters',false,true,'*');
			removedir(str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename.'/ratings',false,true,'*');
			removedir(str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename.'/textfiles',false,true,'*');
			removedir(str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename.'/thumbnails',false,true,'*');
			removedir(str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename.'/backup',false,true,'*');
			removedir(str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename.'/gfx',false,true,'*');
			removedir(str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename,false,true,'*');
		}
	}
	// Upload file(s)
	if (isset($_FILES['uploadimage1']) || isset($_FILES['uploadimage2']) || isset($_FILES['uploadimage3']) || isset($_FILES['uploadimage4']) || isset($_FILES['uploadimage5']) || isset($_FILES['uploadimage6'])) {
		for($i=1;$i<7;$i++) {
			if (isset($_FILES['uploadimage' . $i])) {
				$imagefilename=str_replace('/','',$_FILES['uploadimage' . $i]['name']);
				$imagefilename=str_replace('..','',$imagefilename);
				$extension=strtolower(substr($imagefilename,strrpos($imagefilename,'.')+1,strlen($imagefilename)));
				if (in_array($extension,$supportedformats)) {
					if ($extension!='txt') {
						if (@move_uploaded_file($_FILES['uploadimage' . $i]['tmp_name'],str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename)) {
							if (filesize($imagefilename)==0)
								@unlink($imagefilename);
							if ($extension=='zip')
								unzipimages($imagefilename,$movie_formats.','.$sound_formats.',png,gif,jpg,jpeg,txt,zip','');
						}
					} else if (is_dir('textfiles')) {
						if (@move_uploaded_file($_FILES['uploadimage' . $i]['tmp_name'],str_replace(chr(92),chr(47),getcwd()).'/textfiles/'.$imagefilename)) {
							if (filesize('textfiles/'.$imagefilename)==0)
								@unlink('textfiles/'.$imagefilename);
						}
					} else {
						if (@move_uploaded_file($_FILES['uploadimage' . $i]['tmp_name'],str_replace(chr(92),chr(47),getcwd()).'/'.$imagefilename)) {
							if (filesize($imagefilename)==0)
								@unlink($imagefilename);
						}
					}
					if ($_FILES['uploadimage' . $i]['error']==UPLOAD_ERR_INI_SIZE)
						$title.=" - (upload failed: filesize too big)";
					if ($_FILES['uploadimage' . $i]['error']==UPLOAD_ERR_PARTIAL)
						$title.=" - (upload failed: upload interrupted)";
				}
			}
		}
	}
	
	// Add/edit text file for photo
	if (isset($_REQUEST['phototextfile']) && isset($_REQUEST['phototext'])) {
		if (is_dir('textfiles')) {
			if ($fp=@fopen('textfiles/'.$_REQUEST['phototextfile'],'w')) {
				fwrite($fp,stripslashes($_REQUEST['phototext']));
				fclose($fp);
			}
		} else {
			if ($fp=@fopen($_REQUEST['phototextfile'],'w')) {
				fwrite($fp,stripslashes($_REQUEST['phototext']));
				fclose($fp);
			}
		}
	}
	// Create text file for photo
	if (isset($_REQUEST['newtxtfile'])) {
		if (is_dir('textfiles')) {
			if (file_exists($_REQUEST['newtxtfile']))
				@touch('textfiles/'.substr($_REQUEST['newtxtfile'],0,strrpos($_REQUEST['newtxtfile'],'.')).'.txt');
		} else {
			if (file_exists($_REQUEST['newtxtfile']))
				@touch(substr($_REQUEST['newtxtfile'],0,strrpos($_REQUEST['newtxtfile'],'.')).'.txt');
		}
	}
	// Backup image(s)
	for($i=1;$i<($images_per_page+1);$i++) {
		if (isset($_REQUEST['backup_'.$i])) {
			if (!is_dir('backup')) {@mkdir('backup');}
			$backupimage=$_REQUEST['backup_'.$i];
			@copy($backupimage,'backup/'.$backupimage);
		}
	}
	// Restore image
	if (isset($_REQUEST['restorefilename'])) {
		@copy('backup/'.$_REQUEST['restorefilename'],$_REQUEST['restorefilename']);
	}
	// Resize image(s)
	if (isset($_REQUEST['resizeimagesto'])) {
		$resizeimagesto=(int) $_REQUEST['resizeimagesto'];
		if ($resizeimagesto>0) {
			for($i=1;$i<($images_per_page+1);$i++) {
				if (isset($_REQUEST['image_'.$i])) {
					$resizeimage=$_REQUEST['image_'.$i];
					if (file_exists($resizeimage))
						resize($resizeimage,$resizeimagesto);	
				}
			}
		}
	}
	// Rotate image(s)
	if (isset($_REQUEST['rotateimages'])) {
		$direction=$_REQUEST['rotateimages'];
		if ($direction=='r' || $direction=='l') {
			for($i=1;$i<($images_per_page+1);$i++) {
				if (isset($_REQUEST['rotate_'.$i])) {
					$rotateimage=$_REQUEST['rotate_'.$i];
					if (file_exists($rotateimage))
						rotate($rotateimage,$direction);	
				}
			}
		}
	}
	// Create new album
	if (isset($_REQUEST['newalbumname'])) {
		$albumname=ereg_replace("[^[:space:]a-zA-Z0-9*_.-]","",$_REQUEST['newalbumname']);
		if(!file_exists($albumname) && $albumname!='') {
			if (@mkdir($albumname)) {
				if ($fp=@fopen($albumname.'/index.php','wb')) {
					fwrite($fp,"<?php\n");
					fwrite($fp,"include('../index.php');\n");
					fwrite($fp,'?>');
					fclose($fp);
				} else {
					@copy('index.php',$albumname.'/index.php');
				}
				if (file_exists('configuration.php')) {@copy('configuration.php',$albumname.'/configuration.php');}
				if (!file_exists($albumname.'/hitcounters')) {@mkdir($albumname.'/hitcounters');}
				if (!file_exists($albumname.'/ratings')) {@mkdir($albumname.'/ratings');}
				if (!file_exists($albumname.'/textfiles')) {@mkdir($albumname.'/textfiles');}
				if (!file_exists($albumname.'/thumbnails')) {@mkdir($albumname.'/thumbnails');}
				if (!file_exists($albumname.'/backup')) {@mkdir($albumname.'/backup');}
			} else {
				$title.=' - failed (please enable write access)';
			}
		} else if (file_exists($albumname) && $albumname!='') {
			if ($fp=@fopen($albumname.'/index.php','wb')) {
				fwrite($fp,"<?php\n");
				fwrite($fp,"include('../index.php');\n");
				fwrite($fp,'?>');
				fclose($fp);
			} else {
				@copy('index.php',$albumname.'/index.php');
			}
			if (file_exists('configuration.php')) {@copy('configuration.php',$albumname.'/configuration.php');}
			if (!file_exists($albumname.'/hitcounters')) {@mkdir($albumname.'/hitcounters');}
			if (!file_exists($albumname.'/ratings')) {@mkdir($albumname.'/ratings');}
			if (!file_exists($albumname.'/textfiles')) {@mkdir($albumname.'/textfiles');}
			if (!file_exists($albumname.'/backup')) {@mkdir($albumname.'/backup');}
			if (!file_exists($albumname.'/thumbnails')) {@mkdir($albumname.'/thumbnails');}
		}
	}
}

// Display EasyPhpAlbum logo
if ($show_poweredby_easyphpalbum && isset($_REQUEST['poweredby'])) {
	if (imagetypes() & IMG_PNG) {
		header("Content-type: image/png");
		imagepng(poweredby_image());
	} else {
		header("Content-type: image/jpeg");
		imagejpeg(poweredby_image(),'',100);
	}
	exit;
}

// Display Email link 
if ($show_email_link && isset($_REQUEST['emaillink'])) {
	header("Content-type: image/png");
	imagepng(emaillink_image());
	exit;
}

// Update & output hit-counter
if ($hit_counter && isset($_REQUEST['statistics']) && isset($_REQUEST['image'])) {
	$image=$_REQUEST['image'];
	$stats_filename=substr($image,0,strrpos($image,'.')).'.stat';
	if (strpos($stats_filename,'/')!=false) {
		if (is_dir(substr($image,0,strrpos($image,'/')) . '/hitcounters'))
			$stats_filename=str_replace('/','/hitcounters/',$stats_filename);
	} else {
		if (is_dir('hitcounters'))
			$stats_filename='hitcounters/'.$stats_filename;
	}
	if (!file_exists($stats_filename) && file_exists($image)) {
		if (touch($stats_filename)) {
			if ($fp=@fopen($stats_filename,'w')) {
				fwrite($fp,'0');
				fclose($fp);
			}
		} else {
			$hit_counter_random=false;
			header("HTTP/1.1 202 Accepted"); 
			header("Content-type: image/png");
			imagepng(hitcounter_image('ERROR'));
		}
	}
	if (is_writable($stats_filename)) {
		if ($fp=@fopen($stats_filename,'r+')) {
			$valid_ips=explode(',',$ban_ip);
			if ($_REQUEST['statistics']==1 && !in_array($_SERVER['REMOTE_ADDR'],$valid_ips)) {
				$stats=explode('@',fread($fp,filesize($stats_filename)));
				if (!in_array($_SERVER['REMOTE_ADDR'],$stats)) {
					array_push($stats,$_SERVER['REMOTE_ADDR']);
					$stats[0]=$stats[0]+1;
					rewind($fp);
					fwrite($fp,implode('@',$stats));
				}
			} else {
				$stats=explode('@',fread($fp,filesize($stats_filename)));
			}
			fclose($fp);
			header("HTTP/1.1 202 Accepted"); 
			header("Content-type: image/png");
			imagepng(hitcounter_image($stats[0]+0));
		}
	} else {
		$hit_counter_random=false;
		header("HTTP/1.1 202 Accepted"); 
		header("Content-type: image/png");
		imagepng(hitcounter_image('ERROR'));
	}
	exit;
}

// Update rating & output rating-scorebar
if ($rating && isset($_REQUEST['rating']) && isset($_REQUEST['rateimage'])) {
	$score=intval($_REQUEST['rating']);
	$image=$_REQUEST['rateimage'];
	$stats_filename=substr($image,0,strrpos($image,'.')).'.rate';
	if (is_dir('ratings'))
		$stats_filename='ratings/'.$stats_filename;
	if (!file_exists($stats_filename) && file_exists($image)) {
		if (touch($stats_filename)) {
			if ($fp=@fopen($stats_filename,'w')) {
				fwrite($fp,'0');
				fclose($fp);
			}
		}
	}
	if (is_writable($stats_filename)) {
		if ($fp=@fopen($stats_filename,'r+')) {
			if ($score>0 && $score<6) {
				$stats=explode('@',fread($fp,filesize($stats_filename)));
				$valid_ips=explode(',',$ban_ip);
				if (!in_array($_SERVER['REMOTE_ADDR'],$stats) && !in_array($_SERVER['REMOTE_ADDR'],$valid_ips)) {
					rewind($fp);
					$stats[0]=$stats[0]+1;
					if (count($stats)>2)
						$score=round(($stats[0]*$stats[1]+$score)/($stats[0]+1),2);
					$number=explode('.',$score);
					$number[1]=(isset($number[1]))?$number[1]:'';
					$decimal=str_pad($number[1],2,'0');
					$score=$number[0].'.'.$decimal;
					$stats[1]=$score;
					array_push($stats,$_SERVER['REMOTE_ADDR']);
					fwrite($fp,implode('@',$stats));
					fclose($fp);
				}
			} else {
				$stats=explode('@',fread($fp,filesize($stats_filename)));
				if (count($stats)>2)
					$score=$stats[1];
				fclose($fp);
				header("HTTP/1.1 202 Accepted"); 
				header("Content-type: image/png");
				imagepng(rating_image(floor($score+0)));
				exit;
			}
		}
	}
}
// Save visitor comment with photo
if ($visitor_comments) {
	if (isset($_REQUEST['newcomment'])) {
		if ($_REQUEST['newcomment']!='') {
			// Make sure visitor stays on the same page
			if (isset($_REQUEST['comment_showimage']))
				$_REQUEST['showimage']=$_REQUEST['comment_showimage'];
			if (isset($_REQUEST['comment_screenwidth']))
				$_REQUEST['screenwidth']=$_REQUEST['comment_screenwidth'];
			// Add comment to textfile
			if (isset($_REQUEST['comment_username'])) {
				$username=substr(trim(stripslashes($_REQUEST['comment_username'])),0,10);
				if ($username=='') {$username='anonymous';}
			} else {
				$username='';
			}
			$valid_ips=explode(',',$ban_ip);
			if (is_dir('textfiles') && !in_array($_SERVER['REMOTE_ADDR'],$valid_ips)) {
				if ($fp=@fopen('textfiles/'.substr($_REQUEST['comment_showimage'],0,strrpos($_REQUEST['comment_showimage'],'.')).'.txt','ab')) {
					if ($comment_logip)
						fwrite($fp,'[ '.date($visitor_comments_dateformat).' - '.$_SERVER['REMOTE_ADDR'].' - by ' . $username . ' ]' . "\n");
					else
						fwrite($fp,'[ '.date($visitor_comments_dateformat).' - by '.$username . ' ]' . "\n");
					fwrite($fp,substr(trim(stripslashes($_REQUEST['newcomment'])),0,$comment_size) . "\n". "\n");
					fclose($fp);
					if ($comment_email!='')
						mail($comment_email,'New comment for photoalbum ' . $title,'photo: ' . $_REQUEST['comment_showimage'] . chr(10) . chr(10) . 'comment: ' . substr(trim(stripslashes($_REQUEST['newcomment'])),0,$comment_size) . chr(10) . chr(10) . 'Link: http://' . $_SERVER['HTTP_HOST'] . $HTTP_SERVER_VARS['SCRIPT_NAME'] . '?showimage=' . rawurlencode($_REQUEST['showimage']) . '&screenwidth=' . $_REQUEST['screenwidth'],'From: ' . $comment_email . "\r\n" . 'Reply-To: ' . $comment_email . "\r\n" . 'X-Mailer: PHP/' . phpversion());
				}
			} else if (!in_array($_SERVER['REMOTE_ADDR'],$valid_ips)) {
				if ($fp=@fopen(substr($_REQUEST['comment_showimage'],0,strrpos($_REQUEST['comment_showimage'],'.')).'.txt','ab')) {
					if ($comment_logip)
						fwrite($fp,'[ '.date($visitor_comments_dateformat).' - '.$_SERVER['REMOTE_ADDR'].' - by ' . $username . ' ]' . "\n");
					else
						fwrite($fp,'[ '.date($visitor_comments_dateformat).' - by '.$username . ' ]' . "\n");
					fwrite($fp,substr(trim(stripslashes($_REQUEST['newcomment'])),0,$comment_size) . "\n". "\n");
					fclose($fp);
					if ($comment_email!='')
						mail($comment_email,'New comment for photoalbum ' . $title,'photo: ' . $_REQUEST['comment_showimage'] . chr(10) . chr(10). 'comment: ' . substr(trim(stripslashes($_REQUEST['newcomment'])),0,$comment_size) . chr(10) . chr(10) . 'Link: http://' . $_SERVER['HTTP_HOST'] . $HTTP_SERVER_VARS['SCRIPT_NAME'] . '?showimage=' . rawurlencode($_REQUEST['showimage']) . '&screenwidth=' . $_REQUEST['screenwidth'],'From: ' . $comment_email . "\r\n" . 'Reply-To: ' . $comment_email . "\r\n" . 'X-Mailer: PHP/' . phpversion());
				}
			}
		}
	}
}

// Upload file(s) from visitor
if ($visitor_upload) {
	$valid_ips=explode(',',$ban_ip);
	if ((isset($_FILES['uploadfile1']) || isset($_FILES['uploadfile2']) || isset($_FILES['uploadfile3']) || isset($_FILES['uploadfile4']) || isset($_FILES['uploadfile5']) || isset($_FILES['uploadfile6'])) && !in_array($_SERVER['REMOTE_ADDR'],$valid_ips)) {
		$accepted_files=explode(',',$visitor_files);
		$uploaded_files='';
		if ($visitor_upload_adminreview) {
			if (!is_dir('backup')) {@mkdir('backup');}
		}
		for($i=1;$i<7;$i++) {
			if (isset($_FILES['uploadfile' . $i])) {
				$imagefilename=str_replace('/','',$_FILES['uploadfile' . $i]['name']);
				$imagefilename=str_replace('..','',$imagefilename);
				$extension=strtolower(substr($imagefilename,strrpos($imagefilename,'.')+1,strlen($imagefilename)));
				if (in_array($extension,$accepted_files)) {
					if (isset($_REQUEST['comment_username'])) {
						$username=substr(ereg_replace("[^a-z,A-Z,0-9,_,-]","_",trim(stripslashes($_REQUEST['comment_username']))),0,10);
						if ($username=='') {$username='anonymous';}
					} else {
						$username='anonymous';
					}
					$imagefilename=substr($imagefilename,0,strrpos($imagefilename,'.')).'_by_'.$username.'.'.$extension;
					if ($visitor_upload_adminreview && $extension!='zip' && file_exists('backup')) {$reviewdir='backup/';} else {$reviewdir='';}
					if (@move_uploaded_file($_FILES['uploadfile' . $i]['tmp_name'],str_replace(chr(92),chr(47),getcwd()).'/'.$reviewdir.$imagefilename)) {
						if (filesize($imagefilename)==0)
							@unlink($imagefilename);
						if (in_array($extension,explode(',','png,gif,jpg,jpeg,swf'))) {
							if (!$check_file = @GetImageSize($imagefilename)) 
								@unlink($imagefilename);
						}
						$uploaded_files.=$imagefilename.chr(10);
						if ($extension=='zip') {unzipimages($imagefilename,$visitor_files,'_by_'.$username);}
						if (file_exists(substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumb.' . $extension))
							@unlink(substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumb.' . $extension);
						if (file_exists('thumbnails/'.substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumb.' . $extension))
							@unlink('thumbnails/'.substr($imagefilename,0,strrpos($imagefilename,'.')) . '_thumb.' . $extension);
					}
					if ($_FILES['uploadfile' . $i]['error']==UPLOAD_ERR_INI_SIZE)
						$title.=" | ERROR Upload failed: filesize too big";
					if ($_FILES['uploadfile' . $i]['error']==UPLOAD_ERR_PARTIAL)
						$title.=" | ERROR Upload failed: upload interrupted";
					if ($_FILES['uploadfile' . $i]['error']==UPLOAD_ERR_FORM_SIZE)
						$title.=" | ERROR Upload failed: filesize too big";
				}
			}
		}
		if ($upload_email!='' && $uploaded_files!='')
			mail($upload_email,'New upload for album ' . $title,'Uploaded file(s): ' .chr(10).chr(10). $uploaded_files .chr(10).chr(10) . 'Uploaded by: ' . $username . ' IP-address: ' . $_SERVER['REMOTE_ADDR'] . chr(10).chr(10) . 'Link: http://' . $_SERVER['HTTP_HOST'] . $HTTP_SERVER_VARS['SCRIPT_NAME'],'From: ' . $upload_email . "\r\n" . 'Reply-To: ' . $upload_email . "\r\n" . 'X-Mailer: PHP/' . phpversion());
		if ($uploaded_files!='') {$title.=" | $language_visitor_upload_message";}
	}
}

// Create and output image in specified size
if (isset($_REQUEST['image'])) {
	$image=$_REQUEST['image'];
	if (file_exists($image)) {
		$size=@GetImageSize($image);
		if ($size[2]==1) {
			if (imagetypes() & IMG_GIF) {
	    			$im=@imagecreatefromgif($image);
			} else {
				header("Content-type: image/png");
				imagepng(invalid_image('No GIF support'));
				exit;
			}
		}
		if ($size[2]==2) {
			if (imagetypes() & IMG_JPG) {
	    			$im=@imagecreatefromjpeg($image);
			} else {
				header("Content-type: image/png");
				imagepng(invalid_image('No JPG support'));
				exit;
			}
		}
		if ($size[2]==3) {
			if (imagetypes() & IMG_PNG) {
				$im=@imagecreatefrompng($image);
			} else {
				header("Content-type: image/jpeg");
				imagejpeg(invalid_image('No PNG support'),'',100);
				exit;
			}
		}
		if ($size[2]!=1 && $size[2]!=2 && $size[2]!=3) {
			$thumb=invalid_image('Invalid Image');
		} else {
			// Do not modify thumbnailindex file
			$is_index=substr($image,0,strrpos($image,'.'));
			if (strpos($is_index,'/')) {$is_index=substr($is_index,strrpos($is_index,'/')+1);}
			if ($is_index=='index' && $indeximage_no_thumb) {
				$thumb_size=$size[0];
				$border_width=0;
				$show_bordershadow=false;
				$show_binder=false;
				$clip_corner=0;
				$show_number=false;
				$thumbnail_borderpng='';
				$thumbnail_rotation=false;
				$square_thumbnails=false;
			}
			// Determine some sizes and settings
			if ($thumb_size<30)
				$thumb_size=30;
			if (isset($_REQUEST['resize'])) {
				if ($image_resizeto==0 && isset($_REQUEST['screenwidth']))
					$image_resizeto=floor($_REQUEST['screenwidth']/1.6);
				if (!$image_inflate) {
					if ($image_resizeto>$size[0] && $image_resizeto>$size[1])
						$image_resizeto=max($size[0],$size[1]);
				}
				$thumb_size=$image_resizeto;
				if (isset($_REQUEST['adminpanel'])) {
					$copyright='';
					$thumb_size=60;
					$mm_watermark='';
					$watermark='';
				}
				$show_number=false;
				$show_binder=false;
				$show_bordershadow=false;
				$clip_corner=0;
				if (!$apply_thumbnail_borderpng) {
					$thumbnail_borderpng='';
					$border_width=0;
				}
				$thumbnail_rotation=false;
			}
			if ($show_binder)
				$border_offset=3;
			else
				$border_offset=2;
			if ($show_bordershadow)
				$shadow_offset=3;
			else
				$shadow_offset=0;
			// Add watermark
			if ($watermark!='') {
				if ($gd2 && file_exists($watermark)) {
					$watermarkim=@imagecreatefrompng($watermark);
						$wpos=explode(' ',str_replace('%','',$watermark_position));
						if (count($wpos)>1)
							@imagecopymerge($im,$watermarkim,min(max(imagesx($im)*($wpos[0]/100)-0.5*imagesx($watermarkim),0),imagesx($im)-imagesx($watermarkim)),min(max(imagesy($im)*($wpos[1]/100)-0.5*imagesy($watermarkim),0),imagesy($im)-imagesy($watermarkim)),0,0,imagesx($watermarkim),imagesy($watermarkim),$watermark_transparancy+0);
						else
							@imagecopymerge($im,$watermarkim,imagesx($im)-imagesx($watermarkim),imagesy($im)-imagesy($watermarkim),0,0,imagesx($watermarkim),imagesy($watermarkim),$watermark_transparancy+0);
						@imagedestroy($watermarkim);
				}
			}
			// Add watermark for multimediafiles
			if ($mm_watermark!='') {
				if ($gd2 && file_exists($mm_watermark)) {
					$mm_file=get_multimedia($image,false);
					if ($mm_file!='') {
						$watermarkim=@imagecreatefrompng($mm_watermark);
						$wpos=explode(' ',str_replace('%','',$mm_watermark_position));
						if (count($wpos)>1)
							@imagecopymerge($im,$watermarkim,min(max(imagesx($im)*($wpos[0]/100)-0.5*imagesx($watermarkim),0),imagesx($im)-imagesx($watermarkim)),min(max(imagesy($im)*($wpos[1]/100)-0.5*imagesy($watermarkim),0),imagesy($im)-imagesy($watermarkim)),0,0,imagesx($watermarkim),imagesy($watermarkim),$mm_watermark_transparancy+0);
						else
							@imagecopymerge($im,$watermarkim,imagesx($im)-imagesx($watermarkim),imagesy($im)-imagesy($watermarkim),0,0,imagesx($watermarkim),imagesy($watermarkim),$mm_watermark_transparancy+0);
						@imagedestroy($watermarkim);
					}
				}
			}
			// Create empty thumbnail
			$x1=$border_width*$border_offset+$thumb_size+$shadow_offset;
			$x2=$border_width*$border_offset+ceil($size[0]/($size[1]/$thumb_size))+$shadow_offset;
			$y1=$border_width*2+ceil($size[1]/($size[0]/$thumb_size))+$shadow_offset;
			$y2=$border_width*2+$thumb_size+$shadow_offset;
			if ($gd2) {
				if ($size[0]>$size[1])
					$thumb=imagecreatetruecolor($x1,$y1);
				else
					$thumb=imagecreatetruecolor($x2,$y2);
			} else {
				if ($size[0]>$size[1])
					$thumb=imagecreate($x1,$y1);
				else
					$thumb=imagecreate($x2,$y2);
			}
			$black=imagecolorallocate($thumb,0,0,0);
			$white=imagecolorallocate($thumb,255,255,255);
			$gray=imagecolorallocate($thumb,192,192,192);
			$middlegray=imagecolorallocate($thumb,158,158,158);
			$darkgray=imagecolorallocate($thumb,128,128,128);
			imagefill($thumb,0,0,imagecolorallocate($thumb,hexdec(substr($table_color,1,2)),hexdec(substr($table_color,3,2)),hexdec(substr($table_color,5,2))));
			if ($show_binder)
				$bind_offset=4;
			else
				$bind_offset=0;
			imagefilledrectangle($thumb,$bind_offset,0,imagesx($thumb)-$shadow_offset,imagesy($thumb)-$shadow_offset,imagecolorallocate($thumb,hexdec(substr($border_color,1,2)),hexdec(substr($border_color,3,2)),hexdec(substr($border_color,5,2))));
			// Add shadow to thumbnail
			if ($show_bordershadow) {
				imagerectangle($thumb,$bind_offset,0,imagesx($thumb)-4,imagesy($thumb)-4,$gray);
				imageline($thumb,$bind_offset,imagesy($thumb)-3,imagesx($thumb),imagesy($thumb)-3,$darkgray);
				imageline($thumb,imagesx($thumb)-3,0,imagesx($thumb)-3,imagesy($thumb),$darkgray);
				imageline($thumb,$bind_offset+2,imagesy($thumb)-2,imagesx($thumb),imagesy($thumb)-2,$middlegray);
				imageline($thumb,imagesx($thumb)-2,2,imagesx($thumb)-2,imagesy($thumb),$middlegray);
				imageline($thumb,$bind_offset+2,imagesy($thumb)-1,imagesx($thumb),imagesy($thumb)-1,$gray);
				imageline($thumb,imagesx($thumb)-1,2,imagesx($thumb)-1,imagesy($thumb),$gray);
			}
			// Clip corner of original image
			if ($clip_corner>0) {
				$clip_corner=floor(imagesx($im)*($clip_corner/100));
				if ($clip_corner_round){
					$clip_degrees=90/$clip_corner;
					// Set centre point for polygon
					$points_tl=array(0,0);
					$points_br=array(imagesx($im),imagesy($im));
					$points_tr=array(imagesx($im),0);
					$points_bl=array(0,imagesy($im));
				}
				$bgcolor=imagecolorallocate($im,hexdec(substr($border_color,1,2)),hexdec(substr($border_color,3,2)),hexdec(substr($border_color,5,2)));
				for ($i=0;$i<$clip_corner;$i++) {
					if ($clip_corner_round){
						$x=$clip_corner*cos(deg2rad($i*$clip_degrees));
						$y=$clip_corner*sin(deg2rad($i*$clip_degrees));
						array_push($points_tl,$clip_corner-$x);
						array_push($points_tl,$clip_corner-$y);
						array_push($points_tr,imagesx($im)-$clip_corner+$x);
						array_push($points_tr,$clip_corner-$y);
						array_push($points_br,imagesx($im)-$clip_corner+$x);
						array_push($points_br,imagesy($im)-$clip_corner+$y);
						array_push($points_bl,$clip_corner-$x);
						array_push($points_bl,imagesy($im)-$clip_corner+$y);
					} else {
						if ($clip_randomly) {$random=1;} else {$random=0;}
						if ($clip_topleft && rand(0,$random)==0) {imageline($im,0,$i,$clip_corner-$i,$i,$bgcolor);}
						if ($clip_bottomright && rand(0,$random)==0) {imageline($im,imagesx($im)-$clip_corner+$i,imagesy($im)-$i-1,imagesx($im)+$clip_corner-$i,imagesy($im)-$i-1,$bgcolor);}
						if ($clip_topright && rand(0,$random)==0) {imageline($im,imagesx($im)-$clip_corner+$i,$i,imagesx($im)+$clip_corner-$i,$i,$bgcolor);}
						if ($clip_bottomleft && rand(0,$random)==0) {imageline($im,0,imagesy($im)-$i-1,$clip_corner-$i,imagesy($im)-$i-1,$bgcolor);}
					}
				}
				if ($clip_corner_round){
					// Add the final points to cope with rounding error
					array_push($points_tl,$clip_corner,0);
					array_push($points_br,imagesx($im)-$clip_corner,imagesy($im));
					array_push($points_tr,imagesx($im)-$clip_corner,0);
					array_push($points_bl,$clip_corner,imagesy($im));
					if ($clip_randomly) {$random=1;} else {$random=0;}
					if ($clip_topleft && rand(0,$random)==0) {imagefilledpolygon($im,$points_tl,count($points_tl)/2,$bgcolor);}
					if ($clip_bottomright && rand(0,$random)==0) {imagefilledpolygon($im,$points_br,count($points_br)/2,$bgcolor);}
					if ($clip_topright && rand(0,$random)==0) {imagefilledpolygon($im,$points_tr,count($points_tr)/2,$bgcolor);}
					if ($clip_bottomleft && rand(0,$random)==0) {imagefilledpolygon($im,$points_bl,count($points_bl)/2,$bgcolor);}
					// Cleanup - remove 1px from outline of image
					imagerectangle($im,0,0,imagesx($im)-1,imagesy($im)-1,$bgcolor);
				}
			}
			// Image created - modify colors (only for jpg & gd2)
			if ($image_greyscale && $size[2]==2 && $gd2) {
				imagetruecolortopalette($im,1,256);
					for ($c=0;$c<256;$c++) {    
						$col=imagecolorsforindex($im,$c);
						$new_col=floor($col['red']*0.2125+$col['green']*0.7154+$col['blue']*0.0721);
						$noise=rand(-$image_noise_depth,$image_noise_depth);
						if ($image_sepia_depth>0) {
							$r=$new_col+$image_sepia_depth+$noise;
							$g=floor($new_col+$image_sepia_depth/1.86+$noise);
							$b=floor($new_col+$image_sepia_depth/-3.48+$noise);
						} else {
							$r=$new_col+$noise;
							$g=$new_col+$noise;
							$b=$new_col+$noise;
						}
					imagecolorset($im,$c,max(0,min(255,$r)),max(0,min(255,$g)),max(0,min(255,$b)));
					}
			}
			// Copy photo to thumbnail
			if ($gd2)
				@imagecopyresampled($thumb,$im,$border_width*($border_offset-1),$border_width,0,0,imagesx($thumb)-($border_offset*$border_width)-$shadow_offset,imagesy($thumb)-2*$border_width-$shadow_offset,imagesx($im),imagesy($im));
			else
				@imagecopyresized($thumb,$im,$border_width*($border_offset-1),$border_width,0,0,imagesx($thumb)-($border_offset*$border_width)-$shadow_offset,imagesy($thumb)-2*$border_width-$shadow_offset,imagesx($im),imagesy($im));
			// Copy thumbnail border image
			if ($thumbnail_borderpng!='') {
				if ($gd2 && file_exists($thumbnail_borderpng)) {
					$borderim=@imagecreatefrompng($thumbnail_borderpng);
					@imagecopyresampled($thumb,$borderim,$bind_offset,0,0,0,imagesx($thumb)-$shadow_offset-$bind_offset,imagesy($thumb)-$shadow_offset,imagesx($borderim),imagesy($borderim));
					@imagedestroy($borderim);
				} else if (file_exists($thumbnail_borderpng)) {
					$borderim=@imagecreatefrompng($thumbnail_borderpng);
					@imagecopyresized($thumb,$borderim,$bind_offset,0,0,0,imagesx($thumb)-$shadow_offset-$bind_offset,imagesy($thumb)-$shadow_offset,imagesx($borderim),imagesy($borderim));
					@imagedestroy($borderim);
				}
			}
			// Add thumbnail number
			if ($show_number && isset($_REQUEST['number']) && isset($_REQUEST['total'])) {
				// Sample some pixels to determine text color
				$colors=array();
				for ($i=5;$i<25;$i++) {
					$indexis=ImageColorAt($thumb,$i,4+ceil($i/5));
					$rgbarray=ImageColorsForIndex($thumb,$indexis);
					array_push($colors,$rgbarray['red'],$rgbarray['green'],$rgbarray['blue']);
				}
				if (array_sum($colors)/count($colors)>180)
					$textcolor=$black;
				else
					$textcolor=$white;
				if ($show_binder)
					$number_offset=$border_width*2;
				else
					$number_offset=$border_width;
				if ($border_width==0)
					$number_offset=1;
				imagestring($thumb,1,$number_offset,2,($_REQUEST['number']+1) . '/' . $_REQUEST['total'],$textcolor);
			}
			// Add a binder
			if ($show_binder) {
				if ($binder_spacing<4)
					$binder_spacing=4;
				$spacing=floor(imagesy($thumb)/$binder_spacing)-2;
				$offset=floor((imagesy($thumb)-($spacing*$binder_spacing))/2);
				for ($i=$offset;$i<=$offset+$spacing*$binder_spacing;$i+=$binder_spacing) {
					imagefilledrectangle($thumb,8,$i-2,10,$i+2,$black);
					imageline($thumb,11,$i-1,11,$i+1,$darkgray);
					imageline($thumb,8,$i-2,10,$i-2,$darkgray);
					imageline($thumb,8,$i+2,10,$i+2,$darkgray);
					imagefilledrectangle($thumb,0,$i-1,8,$i+1,$gray);
					imageline($thumb,0,$i,8,$i,$white);
					imageline($thumb,0,$i-1,0,$i+1,$gray);
					imagesetpixel($thumb,0,$i,$darkgray);
				}
			}
			// Add copyright
			if (isset($_REQUEST['resize']) && $copyright!='') {
				$widthx=imagefontwidth(1)*strlen($copyright);
				if (($widthx+imagefontwidth(1))>imagesx($thumb)) {
					$copyright=substr($copyright,0,floor(imagesx($thumb)/imagefontwidth(1))-1);
					$widthx=imagefontwidth(1)*strlen($copyright);
				}
				$heighty=imagefontheight(1);
				$cpos=explode(' ',str_replace('%','',$copyright_position));
				if (count($cpos)>1) {
					$cposx=min(max(imagesx($thumb)*($cpos[0]/100)-0.5*$widthx,imagefontwidth(1)),imagesx($thumb)-$widthx-imagefontwidth(1));
					$cposy=min(max(imagesy($thumb)*($cpos[1]/100)-0.5*$heighty,$heighty),imagesy($thumb)-$heighty*1.5);
				} else {
					$cposx=imagefontwidth(1);
					$cposy=imagesy($thumb)-10;
				}			
				$colors=array();
				for ($i=$cposx;$i<($cposx+$widthx);$i++) {
					$indexis=ImageColorAt($thumb,$i,$cposy+0.5*$heighty);
					$rgbarray=ImageColorsForIndex($thumb,$indexis);
					array_push($colors,$rgbarray['red'],$rgbarray['green'],$rgbarray['blue']);
				}
				if (array_sum($colors)/count($colors)>180)
					imagestring($thumb,1,$cposx,$cposy,$copyright,$black);
				else
					imagestring($thumb,1,$cposx,$cposy,$copyright,$white);
			}
			// Randomly rotate the thumbnail - coded for compatibility with PHP 4.1.0
			if ($thumbnail_rotation) {
				if ($thumbnail_rotation_degrees==0)
					$thumbnail_rotation_degrees=rand(-1,1)*45;	// 45 degrees provides good result without the need for antialiasing
				if ($thumbnail_rotation_degrees<>0 && imagesx($thumb)<imagesy($thumb)) {$thumbnail_rotation_degrees=$thumbnail_rotation_degrees*-1;} // Tilt portrait thumbnails in other direction
				if ($thumbnail_rotation_degrees<>0) {
					$centerx=imagesx($thumb)/2;
					$centery=imagesy($thumb)/2;
					$maxsizex=ceil(abs(cos(deg2rad($thumbnail_rotation_degrees))*imagesx($thumb))+abs(sin(deg2rad($thumbnail_rotation_degrees))*imagesy($thumb)));
					$maxsizey=ceil(abs(sin(deg2rad($thumbnail_rotation_degrees))*imagesx($thumb))+abs(cos(deg2rad($thumbnail_rotation_degrees))*imagesy($thumb)));
					if ($maxsizex & 1) {$maxsizex+=3;} else	{$maxsizex+=2;}
					if ($maxsizey & 1) {$maxsizey+=3;} else {$maxsizey+=2;}
					if ($gd2) {$newthumb=imagecreatetruecolor($maxsizex,$maxsizey);} else {$newthumb=imagecreate($maxsizex,$maxsizey);}
					imagefill($newthumb,0,0,imagecolorallocate($newthumb,hexdec(substr($table_color,1,2)),hexdec(substr($table_color,3,2)),hexdec(substr($table_color,5,2))));			
					$newcenterx=imagesx($newthumb)/2;
					$newcentery=imagesy($newthumb)/2;
					$thumbnail_rotation_degrees+=180;
					for ($px=0;$px<imagesx($newthumb);$px++) {
						for ($py=0;$py<imagesy($newthumb);$py++) {
							$vectorx=($newcenterx-$px)*cos(deg2rad($thumbnail_rotation_degrees))+($newcentery-$py)*sin(deg2rad($thumbnail_rotation_degrees));
							$vectory=($newcentery-$py)*cos(deg2rad($thumbnail_rotation_degrees))-($newcenterx-$px)*sin(deg2rad($thumbnail_rotation_degrees));
							if (($centerx+$vectorx)>-1 && ($centerx+$vectorx)<($centerx*2+1) && ($centery+$vectory)>-1 && ($centery+$vectory)<($centery*2+1))
								@imagecopy($newthumb,$thumb,$px,$py,$centerx+$vectorx,$centery+$vectory,1,1);
						}
					}
					@imagedestroy($thumb);
					if ($gd2) {$thumb=imagecreatetruecolor(imagesx($newthumb),imagesy($newthumb));} else {$thumb=imagecreate(imagesx($newthumb),imagesy($newthumb));}
					@imagecopy($thumb,$newthumb,0,0,0,0,imagesx($newthumb),imagesy($newthumb));
					@imagedestroy($newthumb);
				}
			}
		}
		if ($square_thumbnails && isset($_REQUEST['number'])) {
			$squaresize=max(imagesx($thumb),imagesy($thumb));
			if ($gd2) {$newthumb=imagecreatetruecolor($squaresize,$squaresize);} else {$newthumb=imagecreate($squaresize,$squaresize);}
			imagefill($newthumb,0,0,imagecolorallocate($newthumb,hexdec(substr($border_color,1,2)),hexdec(substr($border_color,3,2)),hexdec(substr($border_color,5,2))));
			$centerx=floor(($squaresize-imagesx($thumb))/2);
			$centery=floor(($squaresize-imagesy($thumb))/2);
			@imagecopy($newthumb,$thumb,$centerx,$centery,0,0,imagesx($thumb),imagesy($thumb));
			@imagedestroy($thumb);
			if ($gd2) {$thumb=imagecreatetruecolor($squaresize,$squaresize);} else {$thumb=imagecreate($squaresize,$squaresize);}
			@imagecopy($thumb,$newthumb,0,0,0,0,$squaresize,$squaresize);
			@imagedestroy($newthumb);
		}
		if (strpos($image,'/')) {$subdir=substr($image,0,strpos($image,'/')+1);} else {$subdir='';}
		if (is_dir($subdir . 'thumbnails')) {$thumbdir='thumbnails/';} else {$thumbdir='';}
		if (isset($_REQUEST['indexalbum'])) {$indexalbum=(int) $_REQUEST['indexalbum'];} else {$indexalbum=0;}
		if ($indexalbum>0)
			$thumbfilename=$subdir . $thumbdir . substr($image,strlen($subdir),strrpos($image,'.')-strlen($subdir)) . '_thumbindex';
		else
			$thumbfilename=$subdir . $thumbdir . substr($image,0,strrpos($image,'.')) . '_thumb';
		if ($size[2]==1) {
			if ($create_thumbnail_cache && !isset($_REQUEST['resize']))
				@imagegif($thumb,$thumbfilename.'.gif');
			header("Content-type: image/gif");
			imagegif($thumb);
		} else if ($size[2]==2) {
			if ($create_thumbnail_cache && !isset($_REQUEST['resize']))
				@imagejpeg($thumb,$thumbfilename.'.jpg',90);
			header("Content-type: image/jpeg");
			imagejpeg($thumb,'',90);
		} else if ($size[2]==3) {
			if ($create_thumbnail_cache && !isset($_REQUEST['resize']))
				@imagepng($thumb,$thumbfilename.'.png');
			header("Content-type: image/png");
			imagepng($thumb);
		} else {
			header("Content-type: image/png");
			imagepng(invalid_image('Invalid Image'));
		}
	} else {
		header("Content-type: image/png");
		imagepng(invalid_image('File not found'));
	}
	@imagedestroy($im);
	@imagedestroy($thumb);
	exit;
}

// Batch resize all images in directory permanently - checks if image has been resized already
if ($resizeimages) {
	$images=array();
	$images=get_images(getcwd(),false,false);
	if ($images && $resizeto>30) {
		foreach ($images as $image)
			resize($image,$resizeto);
	}
}

// Create new images for multimedia files without their own image
if ($play_multimedia && $mm_dir!='') {create_mm(false);}

// Detect sub directories - if present; current index.php file is home (main index) - otherwise detect directories one level higher
$dir_names=array();
$file_names=array();
$album_show=false;
$total_amount_images=0;
if ($dir=@opendir(getcwd())) {
	while ($file=@readdir($dir)) {
		if (($file!='.') && ($file!='..') && is_dir($file) && file_exists($file.'/index.php') && ($file!='_vti_cnf')) {
			$images=get_images($file,false,true);
			if (count($images)!=0) {
				array_push($dir_names,$file);
				$index_image_exists=count($file_names);
				$subtract_index=0;
				foreach ($images as $firstimage) {
					if (substr($firstimage,0,strrpos($firstimage,'.'))=='index') {
						array_push($file_names,$file . '/' . $firstimage);
						$subtract_index=-1;
						break;
					}
				}
				if ($index_image_exists==count($file_names))
					array_push($file_names,$file . '/' . $images[0]);
				$album_show=true;
				$total_amount_images=$total_amount_images+count($images)+$subtract_index;
			}
		}
	}
	@closedir($dir);
}
sort($dir_names);
sort($file_names);
$total_amount_albums=count($dir_names);
if (count($dir_names)==0) {
	$dir_names=array();
	if ($dir=@opendir('../')) {
		while ($file=@readdir($dir)) {
			if (($file!='.') && ($file!='..') && is_dir('../'.$file) && file_exists('../'.$file.'/index.php') && $file!=substr(getcwd(),-strlen($file)) && ($file!='_vti_cnf')) {
				$images=get_images('../' . $file,false,false);
				if (count($images)!=0)
					array_push($dir_names,'../' . $file);
			}
		}
		@closedir($dir);
	}
	sort($dir_names);
	if ($admin_link!='')
		$file_names=get_images('./',true,true);
	else
		$file_names=get_images('./',true,false);
}

// Add backup images for administrator access
$backup_not_published=0;
if ($admin_link!='' && is_dir('backup')) {
	$backup_files=array();
	$backup_files=get_images('backup',true,false);
	foreach($backup_files as $backup_image) {
		if (!in_array($backup_image,$file_names)) {
			array_push($file_names,$backup_image);
			$backup_not_published+=1;
		}
	}
}

// Add multimedia files for administrator access
if ($admin_link!='') {
	$add_mm_files=get_multimedia('',true);
	foreach($add_mm_files as $newfile) {array_push($file_names,$newfile);}
}

// Page title
if ($title=='') {
	$title=str_replace(chr(92),chr(47),getcwd());
	$title=str_replace('_',' ',$title);
	$title=substr($title,strrpos($title,chr(47))+1);
	if (ereg("([0-9]{3})",substr($title,0,3))) {
		if (substr($title,3,1)==' ' || substr($title,3,1)=='_')
			$title=trim(substr($title,3));
	}
}

// Change display configuration for shop system, order stage 1,2 and 3
if ($shop && isset($_REQUEST['orderphotos'])) {
	$order=0;
	if ($_REQUEST['orderphotos']==1) {
		$images_per_page=9999;
		if (isset($_REQUEST['page'])) {unset($_REQUEST['page']);}
		$columns_per_page=$shop_columns;
		$thumbnail_txtfile=false;
		$thumbnail_countcomments=false;
		$popup=true;
		$order=1;
		if (isset($_REQUEST['old_searchkeyword'])) {
			// Filter results
			$searchresults=array();
			foreach($file_names as $file) {
				if (strpos(strtolower($file),strtolower($_REQUEST['old_searchkeyword']))===false) {} else {array_push($searchresults,$file);}
			}
			$file_names=$searchresults;
			}
	}
	if ($_REQUEST['orderphotos']==2) {$order=2;}
	if ($_REQUEST['orderphotos']==3) {$order=3;}
} else {
	$order=0;
}

// Change display configuration for search results
if ($visitor_search && isset($_REQUEST['searchkeyword'])) {
	if (strlen($_REQUEST['searchkeyword'])>0) {
		$images_per_page=9999;
		if (isset($_REQUEST['page'])) {unset($_REQUEST['page']);}
		$columns_per_page=$visitor_search_columns;
		$thumbnail_txtfile=false;
		$thumbnail_countcomments=false;
		$popup=true;
		// Filter results
		if (is_dir('textfiles')) {$txtdir='textfiles/';} else {$txtdir='';}
		$searchresults=array();
		foreach($file_names as $file) {
			if (strpos(strtolower($file),strtolower($_REQUEST['searchkeyword']))===false) {} else {array_push($searchresults,$file);}
			$txtfilename=substr($file,0,strrpos($file,'.')).'.txt';
			if (file_exists($txtdir.$txtfilename)) {
				if ($fp=@fopen($txtdir.$txtfilename,'r')) {
					$comment=fread($fp,filesize($txtdir.$txtfilename));
					if (strpos(strtolower($comment),strtolower($_REQUEST['searchkeyword']))===false) {} else {array_push($searchresults,$file);}
					fclose($fp);
				}
			}
		}
		$file_names=$searchresults;
	}
}

// Evaluate which thumbnails to show on current page
$max_files=count($file_names);
if (isset($_REQUEST['page'])) {$page=abs((int) $_REQUEST['page']);} else {$page=0;}
if ($images_per_page==0) {$images_per_page=1;}
$albumpage=ceil($page/$images_per_page)+1;
$show_files=$page+$images_per_page;
if ($show_files>$max_files) {$show_files=$max_files;}
if ($page==$show_files) {$page-=$images_per_page;}
if ($max_files==0) {$page=0;}

// Create HTML page
echo "<html><head><title>$title</title>\n";
echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\"><meta http-equiv=\"content-style-type\" content=\"text/css\"><meta http-equiv=\"content-script-type\" content=\"text/javascript\">\n";
echo "<meta name=\"description\" content=\"$meta_description\"><meta name=\"keywords\" content=\"$meta_keywords\"><meta name=\"copyright\" content=\"$meta_copyright_and_author\"><meta name=\"author\" content=\"$meta_copyright_and_author\">\n";
echo "</head><body marginwidth=\"0\" marginheight=\"0\" topmargin=\"0\" leftmargin=\"0\" bgcolor=\"" . trim($page_color,'#') . "\">\n";

// Insert CSS Styles
html_css();

// Javascript
echo "<div id=\"content\"><form name=\"browser\" method=\"POST\" action=\"index.php?$admin_link\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"page\" value=\"$page\"><input type=\"hidden\" name=\"imagefilename\">\n";
echo "<script language=\"JavaScript\">\n";
echo "<!-- EasyPhpAlbum 1.3.7 @ www.mywebmymail.com //-->\n";
if ($slideshow_delay<1000) {$slideshow_delay=1000;}
$fadeinorout='';
$fader='';
if (($thumbnail_opacity || $imagefader) && !$popup) {
	if ($show_previous_next && $imagefader && $thumbnail_opacity) {
		$fadeinorout="onLoad=\"thumbfade();\" style=\"filter: alpha(opacity=0); KHTMLOpacity: 0; -moz-opacity: 0; opacity: 0\" onMouseover=\"fadeinout(this,1)\" onMouseout=\"fadeinout(this,0)\"";
		if (!$thumbnail_opacity) {$opacity_level=100;}
		echo "function thumbfade() {\n";
		echo "	setTimeout(\"setopacity(document.images['next_thumbnail'],$opacity_level);\",3500);\n";
		echo "	setTimeout(\"setopacity(document.images['previous_thumbnail'],$opacity_level);\",3500);\n";
		echo "}\n";
	} else if ($show_previous_next && $thumbnail_opacity) {
		$fadeinorout="onLoad=\"fadeinout(this,0);\" onMouseover=\"fadeinout(this,1)\" onMouseout=\"fadeinout(this,0)\"";
	}
	echo "function fadeinout(object,inorout) {\n";
	echo "	var opacity=(inorout > 0 ? 100 : $opacity_level);\n";
	echo "	if (opacity==100) opacity=99.999;\n";
	echo "	setopacity(object,opacity);\n";
	echo "}\n";
	echo "function setopacity(object,opacity) {\n";
	echo "	if (opacity==100) opacity=99.999;\n";
	echo "	object.style.filter=\"alpha(opacity:\"+opacity+\")\";\n";
	echo "	object.style.KHTMLOpacity=(opacity/100);\n";
	echo "	object.style.MozOpacity=(opacity/100);\n";
	echo "	object.style.opacity=(opacity/100);\n";
	echo "}\n";
	if ($imagefader) {
		echo "function fader() {\n";
		echo "	for(i=0;i<=100;i++)\n";
		echo "		setTimeout(\"setopacity(document.images['mainimage'],\" + i + \");\",i*20);\n";
		if ($slideshow && isset($_REQUEST['slideshow'])) {
			$show_previous_next=false;
			echo "	starttimer();\n";
			echo "	for(i=100;i>=0;i--)\n";
			echo "		setTimeout(\"setopacity(document.images['mainimage'],\" + i + \");\",$slideshow_delay+2000+((100-i)*20));\n";
		}
		echo "}\n";
	}
	if ($thumbnail_opacity && !isset($_REQUEST['showimage'])) {$fadeinorout="onLoad=\"fadeinout(this,0);\" onMouseover=\"fadeinout(this,1)\" onMouseout=\"fadeinout(this,0)\"";}
	if ($imagefader) {$fader="name=\"mainimage\" onLoad=\"fader();\" style=\"filter: alpha(opacity=0); KHTMLOpacity: 0; -moz-opacity: 0; opacity: 0\"";}
}
if ($popup) {echo "var popup=null;\n";}
echo "function showpage(page) {\n"; 
echo "	document.browser.page.value=page;\n";
if ($popup) {echo "if (popup && popup.open) popup.close();\n";}
echo "	document.browser.submit();\n";
echo "}\n";
echo "function viewer(image,name,width,height) {\n";
if ($popup) {
	// Change image width for auto-adjust
	if ($image_resize) {
		if ($image_resizeto==0) {echo "var newsize=Math.floor(screen.width/1.6);\n";} else {echo "var newsize=$image_resizeto;\n";}
		if (!$image_inflate) {
			echo "if (newsize>width && newsize>height)\n";
			echo "	newsize=Math.max(width,height);\n";
		}
		echo "if (width>height) {\n";
			echo "	var popup_width=newsize;\n";
			echo "	var popup_height=(height/(width/popup_width));\n";
		echo "} else {\n";
			echo "	var popup_width=(width/(height/newsize));\n";
			echo "	var popup_height=newsize;\n";
		echo "}\n";
		echo "width=Math.floor(popup_width);\n";
		echo "height=Math.floor(popup_height);\n";
	}
	// Center pop-up window on page
	echo "if (popup && popup.open) popup.close();\n";
	echo "var poswx=(screen.width > width ? (screen.width - width)/2 : 0);\n";
	echo "var poswy=(screen.height > height ? (screen.height - height)/3 : 0);\n";
	echo "if (poswx==0 && poswy==0) {\n";
	echo "	popup=window.open(\"\",\"popup\",\"width=\" + (screen.width-10) + \",height=\" + (screen.height-55) + \",status=no,hotkeys=no,menubar=no,toolbar=no,resizable=no,scrollbars=yes,top=\" + poswy + \",left=\" + poswx + \",dependent=yes,alwaysRaised=yes\");\n";
	echo "} else if (poswx==0) {\n";
	echo "	popup=window.open(\"\",\"popup\",\"width=\" + (screen.width-10) + \",height=\" + (height+1) + \",status=no,hotkeys=no,menubar=no,toolbar=no,resizable=no,scrollbars=yes,top=\" + poswy + \",left=\" + poswx + \",dependent=yes,alwaysRaised=yes\");\n";
	echo "} else if (poswy==0) {\n";
	echo "	popup=window.open(\"\",\"popup\",\"width=\" + (width+1) + \",height=\" + (screen.height-55) + \",status=no,hotkeys=no,menubar=no,toolbar=no,resizable=no,scrollbars=yes,top=\" + poswy + \",left=\" + poswx + \",dependent=yes,alwaysRaised=yes\");\n";
	echo "} else {\n";
	echo "	popup=window.open(\"\",\"popup\",\"width=\" + (width+1) + \",height=\" + (height+1) + \",status=no,hotkeys=no,menubar=no,toolbar=no,resizable=no,scrollbars=no,top=\" + poswy + \",left=\" + poswx + \",dependent=yes,alwaysRaised=yes\");\n";
	echo "}\n";
	// Write html to popup window
	if ($popup_browse) {
		if (!$slideshow) {$html_code='javascript:nextimage(3)';} else {$html_code='javascript:window.close()';} 
		echo "name='" , ereg_replace("[^[:space:]a-zA-Z0-9*_.-]","",$title) . "';\n";
		if (!$slideshow) {$html_alt=$language_viewnext;} else {$html_alt=$language_stop_slideshow;}
	} else {
		$html_code='javascript:window.close()';
		$html_alt='X';
	}
	if ($imagefader) {$popup_style="style='filter: alpha(opacity=0); KHTMLOpacity: 0; -moz-opacity: 0; opacity: 0'";} else {$popup_style='';}
	if ($popup_force_focus)
		echo "popup.document.write(\"<html><head><title>\" + name + \"</title><meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'><body marginwidth='0' bgcolor='" . trim($page_color,'#') . "' marginheight='0' topmargin='0' leftmargin='0' onBlur='window.focus()'>\");\n";
	else
		echo "popup.document.write(\"<html><head><title>\" + name + \"</title><meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'><body marginwidth='0' bgcolor='" . trim($page_color,'#') . "' marginheight='0' topmargin='0' leftmargin='0'>\");\n";
	if ($image_resize)
		echo "popup.document.write(\"<center><table width='100%' height='100%' border='0' cellspacing='0' cellpadding='0'><tr valign='middle' align='center'><td><a href='$html_code'><img src='index.php?resize=1&image=\" + escape(image) + \"&screenwidth=\" + screen.width + \"' width='\" + width + \"' height='\" + height + \"' border='0' $popup_style name='mainimage' alt='$html_alt' onLoad='calibrate();'></a></td></tr></table></center>\");\n";
	else
		echo "popup.document.write(\"<center><table width='100%' height='100%' border='0' cellspacing='0' cellpadding='0'><tr valign='middle' align='center'><td><a href='$html_code'><img src='\" + escape(image) + \"' width='\" + width + \"' height='\" + height + \"' border='0' $popup_style name='mainimage' alt='$html_alt' onLoad='calibrate();'></a></td></tr></table></center>\");\n";
	echo "popup.document.write(\"<script language='JavaScript'>\");\n";
	if ($imagefader) {
		echo "popup.document.write(\"function setopacity(object,opacity) {\");\n";
		echo "popup.document.write(\"	if (opacity==100) opacity=99.999;\");\n";
		echo "popup.document.write(\"	object.style.filter='alpha(opacity:' + opacity + ')';\");\n";
		echo "popup.document.write(\"	object.style.KHTMLOpacity=(opacity/100);\");\n";
		echo "popup.document.write(\"	object.style.MozOpacity=(opacity/100);\");\n";
		echo "popup.document.write(\"	object.style.opacity=(opacity/100);\");\n";
		echo "popup.document.write(\"}\");\n";
		echo "popup.document.write(\"function fader() {\");\n";
		echo "popup.document.write(\"	for(i=0;i<=100;i++)\");\n";
		echo "popup.document.write(\"		setTimeout('setopacity(document.images[0],' + i + ');',i*20);\");\n";
		$slideshow_delay+=2500;
		if ($slideshow && $popup_browse) {
			echo "popup.document.write(\"	for(i=100;i>=0;i--)\");\n";
			echo "popup.document.write(\"		setTimeout('setopacity(document.images[0],' + i + ');',$slideshow_delay+((100-i)*20));\");\n";
			$slideshow_delay+=2500;
			echo "popup.document.write(\"		setTimeout('nextimage(3);',$slideshow_delay);\");\n";
		}
		echo "popup.document.write(\"}\");\n";
	}
	if ($popup_browse) {
		echo "popup.document.write(\"images=new Array(\");\n";
		for ($count=$page;$count<$show_files;$count++) {
			$image_info=@GetImageSize('./' . $file_names[$count]);
			$dimensions=getdimensions($image_info);
			if ($count<$show_files-1) {
				if ($image_resize && !($animated_thumbnails && $image_info[2]==1))
					echo "popup.document.write(\"'index.php?resize=1&image=\" + escape('$file_names[$count]') + \"&screenwidth=\" + screen.width + \"',$dimensions[0],$dimensions[1],\");\n";
				else
					echo "popup.document.write(\"'\" + escape('$file_names[$count]') + \"',$dimensions[0],$dimensions[1],\");\n";
			} else {
				if ($image_resize && !($animated_thumbnails && $image_info[2]==1))
					echo "popup.document.write(\"'index.php?resize=1&image=\" + escape('$file_names[$count]') + \"&screenwidth=\" + screen.width + \"',$dimensions[0],$dimensions[1]\");\n";
				else
					echo "popup.document.write(\"'\" + escape('$file_names[$count]') + \"',$dimensions[0],$dimensions[1]\");\n";
			}
		}
		echo "popup.document.write(\");\");\n";
		echo "popup.document.write(\"var imageindex=0;\");\n";
		echo "popup.document.write(\"var selectedimage='\" + escape(image) + \"';\");\n";
		echo "popup.document.write(\"for (var found=0;found<images.length-1;found+=3) {\");\n";
		echo "popup.document.write(\"	if (images[found].indexOf(selectedimage)>-1)\");\n";
		echo "popup.document.write(\"		imageindex=found;\");\n";
		echo "popup.document.write(\"}\");\n";
		echo "popup.document.write(\"empty=new Image();\");\n";
		echo "popup.document.write(\"function nextimage(direction) {\");\n";
		echo "popup.document.write(\"	imageindex=imageindex+direction;\");\n";
		echo "popup.document.write(\"	if (imageindex>images.length-1)\");\n";
		echo "popup.document.write(\"		imageindex=0;\");\n";
		echo "popup.document.write(\"	if (imageindex<0)\");\n";
		echo "popup.document.write(\"		imageindex=images.length-3;\");\n";
		echo "popup.document.write(\"	document.images[0].src=empty;\");\n";
		echo "popup.document.write(\"	document.images[0].width=1;\");\n";
		echo "popup.document.write(\"	document.images[0].height=1;\");\n";
		if ($imagefader) {echo "popup.document.write(\"	setopacity(document.images[0],0);\");\n";}
		echo "popup.document.write(\"	document.images[0].src=images[imageindex];\");\n";
		if ($slideshow && !$imagefader) {echo "popup.document.write(\"	window.setTimeout('nextimage(3);',$slideshow_delay);\");\n";}
		echo "popup.document.write(\"}\");\n";
		if ($slideshow && !$imagefader) {echo "popup.document.write(\"	window.setTimeout('nextimage(3);',$slideshow_delay);\");\n";}
		if ($enable_keyboard_arrows && !$slideshow) {
			echo "popup.document.write(\"function reload(e) {\");\n";
			echo "popup.document.write(\"	if(e) {\");\n";
			echo "popup.document.write(\"		if(e.type=='keydown' && e.which==37) {nextimage(-3);}\");\n";
			echo "popup.document.write(\"		if(e.type=='keydown' && e.which==39) {nextimage(3);}\");\n";
			echo "popup.document.write(\"	}\");\n";
			echo "popup.document.write(\"	if(window.event) {\");\n";
			echo "popup.document.write(\"		if(event.type=='keydown'&& event.keyCode==37) {nextimage(-3);}\");\n";
			echo "popup.document.write(\"		if(event.type=='keydown'&& event.keyCode==39) {nextimage(3);}\");\n";
			echo "popup.document.write(\"	}\");\n";
			echo "popup.document.write(\"}\");\n";
			echo "popup.document.write(\"document.onkeydown=reload;\");\n";
		}
	}
	echo "popup.document.write(\"function calibrate() {\");\n";
	echo "popup.document.write(\"	var widthx=0;\");\n";
	echo "popup.document.write(\"	var heighty=0;\");\n";
	if ($popup_browse) {
		if ($image_resize) {
			if ($image_resizeto==0) {echo "popup.document.write(\"	var newsize=Math.floor(screen.width/1.6);\");\n";} else {echo "popup.document.write(\"	var newsize=$image_resizeto;\");\n";}
			if (!$image_inflate) {
				echo "popup.document.write(\"	if (newsize>images[imageindex+1] && newsize>images[imageindex+2])\");\n";
				echo "popup.document.write(\"		newsize=Math.max(images[imageindex+1],images[imageindex+2]);\");\n";
			}
			echo "popup.document.write(\"	if (images[imageindex+1]>images[imageindex+2]) {\");\n";
			echo "popup.document.write(\"		var popup_width=newsize;\");\n";
			echo "popup.document.write(\"		var popup_height=(images[imageindex+2]/(images[imageindex+1]/popup_width));\");\n";
			echo "popup.document.write(\"	} else {\");\n";
			echo "popup.document.write(\"		var popup_width=(images[imageindex+1]/(images[imageindex+2]/newsize));\");\n";
			echo "popup.document.write(\"		var popup_height=newsize;\");\n";
			echo "popup.document.write(\"	}\");\n";
			echo "popup.document.write(\"	images[imageindex+1]=popup_width;\");\n";
			echo "popup.document.write(\"	images[imageindex+2]=popup_height;\");\n";
		}
		echo "popup.document.write(\"	document.images[0].width=images[imageindex+1];\");\n";
		echo "popup.document.write(\"	document.images[0].height=images[imageindex+2];\");\n";
	}
	echo "popup.document.write(\"	window.resizeTo(document.images[0].width,document.images[0].height);\");\n";
	echo "popup.document.write(\"	scroll(3000,3000);\");\n";
	echo "popup.document.write(\"	if (window.pageYOffset){\");\n";
	echo "popup.document.write(\"		widthx=window.pageXOffset;\");\n";
	echo "popup.document.write(\"		heighty=window.pageYOffset;\");\n";
	echo "popup.document.write(\"	} else {\");\n";
	echo "popup.document.write(\"		widthx=document.body.scrollLeft;\");\n";
	echo "popup.document.write(\"		heighty=document.body.scrollTop;\");\n";
	echo "popup.document.write(\"	}\");\n";
	echo "popup.document.write(\"	if (widthx!=0 || heighty!=0){\");\n";
	echo "popup.document.write(\"		window.resizeBy(widthx,heighty);\");\n";
	echo "popup.document.write(\"		window.moveTo((screen.width-document.images[0].width)/2,(screen.height-document.images[0].height)/3);\");\n";
	echo "popup.document.write(\"	}\");\n";
	if ($imagefader) {echo "popup.document.write(\"	fader();\");\n";}
	echo "popup.document.write(\"}\");\n";
	echo "popup.document.write(\"</\");\n";
	echo "popup.document.write(\"script>\");\n";
	echo "popup.document.write(\"</body></html>\");\n";
	echo "popup.document.close();\n";
	echo "popup.focus();\n";
	// Update statistics
	if ($hit_counter) {echo "updatestats(image,'');\n";}
} else {
	// Display photo on page
	if ($slideshow && isset($_REQUEST['slideshow']))
		echo "	document.location.href='index.php?slideshow=1&showimage=' + escape(image) + '&screenwidth=' + screen.width;\n";
	else
		echo "	document.location.href='index.php?showimage=' + escape(image) + '&screenwidth=' + screen.width;\n";
}
echo "}\n";
if (isset($_REQUEST['slideshow'])) {
	if (isset($_REQUEST['showimage'])) {
		if (in_array($_REQUEST['showimage'],$file_names)) {
			$forward=array_search($_REQUEST['showimage'],$file_names)+1;
			$count=count($file_names);
			if ($forward==$count) {$next_slide=$file_names[0];} else {$next_slide=$file_names[$forward];}
			if ($imagefader) {$slideshow_delay+=4000;}
			echo "function starttimer() {\n";
			echo "	id=window.setTimeout(\"viewer('$next_slide','',0,0)\",$slideshow_delay);\n";
			echo "}\n";
		}
	}
}
// Update statistics
if ($hit_counter) {
	echo "function updatestats(image,newpage) {\n"; 
	echo "	counter = new Image;\n";
	echo "	counter.src = \"index.php?statistics=1&image=\" + escape(image);\n";
	echo "	if(newpage!='') \n";
	echo "		id=window.setTimeout(\"document.location.href='\" + escape(newpage) + \"';\",500);\n";
	echo "}\n";
}
if ($admin_access && $admin_link=='' && $enable_admin_keyboardshortcut && !isset($_REQUEST['showimage']) && $order==0) {
	echo "function reload(e) {\n";
	echo "	if(e) \n";
	echo "		if(e.type=='keydown' && e.which==9) {document.location.href=\"index.php?admin=1\";}\n";
	echo "	if(window.event) \n";
	echo "		if(event.type=='keydown' && event.keyCode==9) {document.location.href=\"index.php?admin=1\";}\n";
	echo "}\n";
	echo "document.onkeydown=reload;\n";
}
if ($admin_link!='') {
	echo "function deletefile(name,page,backup) {\n";
	echo "	message='Are you sure you want to delete: ';\n";
	echo "	if (backup) message='Are you sure you want to delete from your backup: ';\n";
	echo "	if (confirm(message + name + \" ?\")) {\n";
	echo "	if (backup) document.browser.backup.value=1;\n";
	echo "	document.browser.imagefilename.value=name;\n";
	echo "	document.browser.page.value=page;\n";
	echo "	document.browser.submit(); }\n";
	echo "}\n";
	echo "function restorefile(name,page) {\n";
	echo "	if (confirm(\"Are you sure you want to restore \" + name + \" from your backup?\")) {\n";
	echo "	document.browser.restorefilename.value=name;\n";
	echo "	document.browser.page.value=page;\n";
	echo "	document.browser.submit(); }\n";
	echo "}\n";
	echo "function txtfile(name,page) {\n"; 
	echo "	document.browser.newtxtfile.value=name;\n";
	echo "	document.browser.page.value=page;\n";
	echo "	document.browser.submit();\n";
	echo "}\n";
	echo "function editfile(name,page) {\n"; 
	echo "	document.browser.edittxtfile.value=name;\n";
	echo "	document.browser.page.value=page;\n";
	echo "	document.browser.submit();\n";
	echo "}\n";
	echo "function renamefile(oldname,name,page) {\n"; 
	echo "	var answer=prompt('Please enter a new name:',name);\n";
	echo "	if (answer!=null && answer!='') {\n";
	echo "	document.browser.renameimageold.value=oldname;\n";
	echo "	document.browser.renameimagenew.value=answer;\n";
	echo "	document.browser.page.value=page;\n";
	echo "	document.browser.submit(); }\n";
	echo "}\n";
}
echo "</script>\n";

if ($header!='' && $admin_link=='') {
	$extension=strtolower(substr($header,strrpos($header,'.')+1,strlen($header)));
	if ($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif') {
		echo "<table width=\"100%\" border=\"0\">\n";
		echo "<tr><td><img src=\"$header\" border=\"0\"></td></tr>\n";
		echo "</table>\n";
	}
} else {
	// Add your php header here: include("http://www.yourwebsite.com/header.php");
}

// Gallery header
if ($page_header || $admin_link!='') {echo "<h1>$title</h1><div class=\"line\"> &nbsp;</div>";}

// Insert menu
if ($show_topmenu) {album_menu();}

// Main content for page placed in a table
echo "<div id=\"leftmargin\"><center><table class=\"tablesmaller\">\n";

// No image files in directory or PHP version < 4.1.0
if ($max_files==0 && $admin_link=='') {
	if ($visitor_search && isset($_REQUEST['searchkeyword']))
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\" class=\"tablecell\">$language_search_noresults</td></tr>\n";
	else 
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\" class=\"tablecell\">$language_dir_empty</td></tr>\n";
}

// Show administrator section
if ($admin_link!='') {
	$columns_per_page=9;
	$button_text='Upload/Backup/Resize/Rotate';
	if ($allow_configuration) {$disable='';} else {$disable='disabled=\"true\"';}
	if ($dir=@opendir(getcwd())) {
		$total_albums=0;
		while ($file=@readdir($dir))
			if (($file!='.') && ($file!='..') && is_dir($file) && file_exists($file.'/index.php') && ($file!='_vti_cnf')) {$total_albums+=1;}
		@closedir($dir);
	}
	if ($total_albums==0 && $max_files==0 && !isset($_REQUEST['newinstallation']) && $allow_create_album) {
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\" class=\"tablecell\"><b>EasyPhpAlbum installation menu</b></td></tr>\n";
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\" class=\"tablecell\">For a <u>multiple</u> album installation, please enter the 1st album name below.<br /><br />Otherwise please select and upload some photo's.</td></tr>\n";
		echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\">Album name: <input type=\"text\" name=\"newalbumname\" class=\"input\"></td></tr>\n";
		echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\"><input type=\"submit\" name=\"submitnewalbum\" value=\"Create new album\" class=\"button\"></td></tr>\n";
		$button_text='Upload';
	} else if ($total_albums!=0) {
 		echo "<tr><td nowrap=\"nowrap\" class=\"tablecell2\">&nbsp; </td><td nowrap=\"nowrap\" class=\"tablecell2\"><b>Edit Album</b></td><td nowrap=\"nowrap\" class=\"tablecell\"><b>Images</b></td><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"6\"><b>Action</b><input type=\"hidden\" name=\"renameimagenew\"><input type=\"hidden\" name=\"renameimageold\"></td></tr>\n";
		if ($dir=@opendir(getcwd())) {
			$all_albums=array();
			while ($file=@readdir($dir)){
				if (($file!='.') && ($file!='..') && is_dir($file) && file_exists($file.'/index.php') && ($file!='_vti_cnf')) {array_push($all_albums,$file);}
			}
			@closedir($dir);
			sort($all_albums);
			for ($count=$page;$count<count($all_albums);$count++)
				echo "<tr><td nowrap=\"nowrap\"class=\"tablecell2\">" . ($count+1) . ".</td><td nowrap=\"nowrap\" class=\"tablecell2\"><a href=\"$all_albums[$count]/index.php?admin=1&newinstallation=1\">$all_albums[$count]</a></td><td nowrap=\"nowrap\" class=\"tablecell\">" . count(get_images($all_albums[$count],false,false)) . "</td><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"6\"><a href=\"#link\" onclick=\"deletefile('$all_albums[$count]',$page,false);\">delete</a> / <a href=\"#link\" onclick=\"renamefile('$all_albums[$count]','$all_albums[$count]',$page);\">rename</a></td></tr>\n";
		}
		if ($max_albums>0) {
			if ($max_albums>$total_albums) {
				echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\">Create new album with name: <input type=\"text\" name=\"newalbumname\" class=\"input\"></td></tr>\n";
				$button_text='Create album';
			} else {
				$button_text='Maximum amount of albums reached...';
			}
		} else {
			echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\">Create new album with name: <input type=\"text\" name=\"newalbumname\" class=\"input\"></td></tr>\n";
			$button_text='Create album';
		}
	} else if ($max_files==0) {
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\" class=\"tablecell\">$language_dir_empty</td></tr>\n";
		$button_text='Upload';
		$disable='disabled=\"true\"';
	} else {
 		echo "<tr><td class=\"tablecell2\">&nbsp; </td><td class=\"tablecell2\"><b>Name</b></td><td class=\"tablecell\"><b>Date</b></td><td class=\"tablecell\"><b>Dimensions</b></td><td class=\"tablecell\"><b>Size</b></td><td class=\"tablecell\"><b>Backup</b><input type=\"hidden\" name=\"restorefilename\"><input type=\"hidden\" name=\"backup\"></td><td class=\"tablecell\"><select name=\"resizeimagesto\" class=\"input\"><option selected>Resize</option><option value=\"320\">320px</option><option value=\"480\">480px</option><option value=\"640\">640px</option><option value=\"800\">800px</option>";
		echo "<option value=\"1024\">1024px</option><option value=\"1280\">1280px</option><option value=\"1600\">1600px</option></select></td><td class=\"tablecell\"><select name=\"rotateimages\" class=\"input\"><option selected>Rotate</option><option value=\"r\">90 Right</option><option value=\"l\">90 Left</option></select></td><td class=\"tablecell\"><b>Action</b><input type=\"hidden\" name=\"renameimagenew\"><input type=\"hidden\" name=\"renameimageold\"><input type=\"hidden\" name=\"edittxtfile\"><input type=\"hidden\" name=\"newtxtfile\"></td></tr>\n";
		for ($count=$page;$count<$show_files;$count++) {
			$image_filename=rawurlencode($file_names[$count]);
			$randomid=uniqid(rand(),true);
			$showimage_txt=substr($file_names[$count],0,strrpos($file_names[$count],'.')).'.txt';
			$extension=strtolower(substr($file_names[$count],strrpos($file_names[$count],'.')+1,strlen($file_names[$count])));
			if (file_exists($file_names[$count])) {
				$size=@GetImageSize('./' . $file_names[$count]);
				$file_size=@filesize($file_names[$count]);
				$file_date=getexif($file_names[$count],$show_date_format,'date');
				if ($hit_counter) {$file_date.="<br /><i>" . gettotalhits($file_names[$count]) . ' hits</i>';}
				if (file_exists('backup/'.$file_names[$count]))
					$backup_html="<td class=\"tablecell\" nowrap=\"nowrap\"><a href=\"backup/$file_names[$count]?$randomid\" target=\"_blank\">v</a> / <a href=\"#link\" onclick=\"restorefile('$file_names[$count]',$page);\">r</a> / <a href=\"#link\" onclick=\"deletefile('$file_names[$count]',$page,true);\">d</a></td>";
				else
					$backup_html="<td class=\"tablecell\"><input type=\"checkbox\" name=\"backup_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td>";
				$backup_only="<img src='index.php?resize=1&image=$image_filename&screenwidth=1024&adminpanel=1&admin=1'><br><a href=\"$file_names[$count]?$randomid\" target=\"_blank\">$file_names[$count]</a>";
				if ($extension=='gif' || $extension=='png' || $extension=='jpg' || $extension=='jpeg') {
					if (file_exists($showimage_txt) || file_exists('textfiles/'.$showimage_txt))
						echo "<tr><td class=\"tablecell2\">" . ($count+1) . ".</td><td nowrap=\"nowrap\" class=\"tablecell2\">$backup_only</td><td nowrap=\"nowrap\" class=\"tablecell\">$file_date</td><td nowrap=\"nowrap\" class=\"tablecell\">$size[0] x $size[1]</td><td nowrap=\"nowrap\" class=\"tablecell\">" . floor($file_size/1024) . " Kb</td>$backup_html<td class=\"tablecell\"><input type=\"checkbox\" name=\"image_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td class=\"tablecell\"><input type=\"checkbox\" name=\"rotate_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td nowrap=\"nowrap\" class=\"tablecell\"><a href=\"#link\" onclick=\"deletefile('$file_names[$count]',$page,false);\">delete</a> / <a href=\"#link\" onclick=\"renamefile('$file_names[$count]','". substr($file_names[$count],0,strrpos($file_names[$count],'.')) ."',$page);\">rename</a></td></tr>\n";
					else
						echo "<tr><td class=\"tablecell2\">" . ($count+1) . ".</td><td nowrap=\"nowrap\" class=\"tablecell2\">$backup_only</td><td nowrap=\"nowrap\" class=\"tablecell\">$file_date</td><td nowrap=\"nowrap\" class=\"tablecell\">$size[0] x $size[1]</td><td nowrap=\"nowrap\" class=\"tablecell\">" . floor($file_size/1024) . " Kb</td>$backup_html<td class=\"tablecell\"><input type=\"checkbox\" name=\"image_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td class=\"tablecell\"><input type=\"checkbox\" name=\"rotate_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td nowrap=\"nowrap\" class=\"tablecell\"><a href=\"#link\" onclick=\"deletefile('$file_names[$count]',$page,false);\">delete</a> / <a href=\"#link\" onclick=\"renamefile('$file_names[$count]','". substr($file_names[$count],0,strrpos($file_names[$count],'.')) ."',$page);\">rename</a> / <a href=\"#link\" onclick=\"txtfile('$file_names[$count]',$page);\">add text</a></td></tr>\n";
				} else {
					echo "<tr><td class=\"tablecell2\">" . ($count+1) . ".</td><td nowrap=\"nowrap\" class=\"tablecell2\"><a href=\"$file_names[$count]?$randomid\" target=\"_blank\">$file_names[$count]</a></td><td nowrap=\"nowrap\" class=\"tablecell\">$file_date</td><td nowrap=\"nowrap\" class=\"tablecell\">&nbsp;</td><td nowrap=\"nowrap\" class=\"tablecell\">" . floor($file_size/1024) . " Kb</td><td class=\"tablecell\">&nbsp;</td><td class=\"tablecell\">&nbsp;</td><td class=\"tablecell\">&nbsp;</td><td nowrap=\"nowrap\" class=\"tablecell\"><a href=\"#link\" onclick=\"deletefile('$file_names[$count]',$page,false);\">delete</a> / <a href=\"#link\" onclick=\"renamefile('$file_names[$count]','". substr($file_names[$count],0,strrpos($file_names[$count],'.')) ."',$page);\">rename</a></td></tr>\n";
				}
			} else {
				$size=@GetImageSize('backup/' . $file_names[$count]);
				$file_size=@filesize('backup/'.$file_names[$count]);
				$file_date=getexif('backup/'.$file_names[$count],$show_date_format,'date');
				if ($hit_counter) {$file_date.="<br /><i>" . gettotalhits($file_names[$count]) . ' hits</i>';}
				$backup_html="<td class=\"tablecell\" nowrap=\"nowrap\"><a href=\"backup/$file_names[$count]?$randomid\" target=\"_blank\">v</a> / <a href=\"#link\" onclick=\"restorefile('$file_names[$count]',$page);\">r</a> / <a href=\"#link\" onclick=\"deletefile('$file_names[$count]',$page,true);\">d</a></td>";
				$backup_only="<img src='index.php?resize=1&image=backup/$image_filename&screenwidth=1024&adminpanel=1&admin=1'><br><a href=\"backup/$file_names[$count]?$randomid\" target=\"_blank\">$file_names[$count]</a>";
				if (file_exists($showimage_txt) || file_exists('textfiles/'.$showimage_txt))
					echo "<tr><td class=\"tablecell2\">" . ($count+1) . ".</td><td nowrap=\"nowrap\" class=\"tablecell2\">$backup_only</td><td nowrap=\"nowrap\" class=\"tablecell\">$file_date</td><td nowrap=\"nowrap\" class=\"tablecell\">$size[0] x $size[1]</td><td nowrap=\"nowrap\" class=\"tablecell\">" . floor($file_size/1024) . " Kb</td>$backup_html<td class=\"tablecell\"><input type=\"checkbox\" name=\"image_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td class=\"tablecell\"><input type=\"checkbox\" name=\"rotate_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td nowrap=\"nowrap\" class=\"tablecell\"><b><i>backup (not published)</b></i></td></tr>\n";
				else
					echo "<tr><td class=\"tablecell2\">" . ($count+1) . ".</td><td nowrap=\"nowrap\" class=\"tablecell2\">$backup_only</td><td nowrap=\"nowrap\" class=\"tablecell\">$file_date</td><td nowrap=\"nowrap\" class=\"tablecell\">$size[0] x $size[1]</td><td nowrap=\"nowrap\" class=\"tablecell\">" . floor($file_size/1024) . " Kb</td>$backup_html<td class=\"tablecell\"><input type=\"checkbox\" name=\"image_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td class=\"tablecell\"><input type=\"checkbox\" name=\"rotate_" .  ($count-$page+1)  ."\" value=\"$file_names[$count]\"></td><td nowrap=\"nowrap\" class=\"tablecell\"><b><i>backup (not published)</b></i></td></tr>\n";
			}
			$textarea1='';
			$textarea2='<br />';
			$textarea3='';
			$textarea4="<a href=\"#link\" onclick=\"deletefile('$showimage_txt',$page,false);\">delete</a> / <a href=\"#link\" onclick=\"editfile('$showimage_txt',$page);\">edit</a>";
			if (isset($_REQUEST['edittxtfile'])) {
				if ($_REQUEST['edittxtfile']==$showimage_txt) {
					$textarea1="<input type=\"hidden\" name=\"phototextfile\" value=\"$showimage_txt\"><textarea class=\"input\" name=\"phototext\" cols=\"80\" rows=\"6\">";
					$textarea2='';
					$textarea3='</textarea>';
					$textarea4="<a href=\"#link\" onclick=\"editfile('',$page);\">cancel</a>";
					$button_text='Save text';
				}
			}
			if (file_exists($showimage_txt) && ($extension=='gif' || $extension=='png' || $extension=='jpg' || $extension=='jpeg')) {
				echo "<tr><td nowrap=\"nowrap\" class=\"tablecell2\">&nbsp; </td><td class=\"tablecell2\" colspan=\"7\">$textarea1\n";
				$lines=file($showimage_txt);
				foreach ($lines as $line) {echo htmlentities($line).$textarea2;}
				if (count($lines)==0) {echo "Description for photo";}
				echo "$textarea3</td><td nowrap=\"nowrap\" class=\"tablecell\">$textarea4</td></tr>\n";
			}
			else if (file_exists('textfiles/'.$showimage_txt) && ($extension=='gif' || $extension=='png' || $extension=='jpg' || $extension=='jpeg')) {
				echo "<tr><td nowrap=\"nowrap\" class=\"tablecell2\">&nbsp; </td><td class=\"tablecell2\" colspan=\"7\">$textarea1";
				$lines=file('textfiles/'.$showimage_txt);
				foreach ($lines as $line) {echo htmlentities($line).$textarea2;}
				if (count($lines)==0) {echo "Description for photo";}
				echo "$textarea3</td><td nowrap=\"nowrap\" class=\"tablecell\">$textarea4</td></tr>\n";
			}
		}
	}
	if ($total_albums==0) {
		$file_size=0;
		$file_size_backup=0;
		for ($count=0;$count<count($file_names);$count++) {
			if (file_exists($file_names[$count]))
				$file_size+=@filesize($file_names[$count]);
			else if (file_exists('backup/'.$file_names[$count]))
				$file_size_backup+=@filesize('backup/'.$file_names[$count]);
		}
		if ($backup_not_published>0)
			$backup_text=" | Total images in backup (not published): <b>$backup_not_published</b> (" . floor((($file_size_backup/1024)/1024)*100)/100 . " Mb)";
		else
			$backup_text='';
		if ($max_album_size>0) {
			if ($max_album_size>floor(((($file_size+$file_size_backup)/1024)/1024)*100)/100)
				echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\"><input type=\"file\" name=\"uploadimage1\" class=\"input\"> <input type=\"file\" name=\"uploadimage2\" class=\"input\"><br /><input type=\"file\" name=\"uploadimage3\" class=\"input\"> <input type=\"file\" name=\"uploadimage4\" class=\"input\"><br /><input type=\"file\" name=\"uploadimage5\" class=\"input\"> <input type=\"file\" name=\"uploadimage6\" class=\"input\"></td></tr>\n";
			else
				$button_text='Backup/Resize/Rotate';
		} else {
			echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\"><input type=\"file\" name=\"uploadimage1\" class=\"input\"> <input type=\"file\" name=\"uploadimage2\" class=\"input\"><br /><input type=\"file\" name=\"uploadimage3\" class=\"input\"> <input type=\"file\" name=\"uploadimage4\" class=\"input\"><br /><input type=\"file\" name=\"uploadimage5\" class=\"input\"> <input type=\"file\" name=\"uploadimage6\" class=\"input\"></td></tr>\n";
		}
		if (file_exists('../index.php'))
			$mainmenu="<input type=\"button\" name=\"mainmenu\" value=\"Main menu\" onclick=\"document.location.href='../index.php?admin=1'\" class=\"button\">";
		else
			$mainmenu='';
		echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\"><input type=\"submit\" name=\"upload\" value=\"$button_text\" onclick=\"this.form.upload.value='$button_text'; this.form.upload.value='Processing request please wait...'; this.form.submit(); this.form.upload.disabled='true'; this.form.configuration.disabled='true'; this.form.mainmenu.disabled='true';\" class=\"button\"> <input type=\"button\" name=\"configuration\" value=\"Configuration\" onclick=\"document.location.href='index.php?admin=1&configuration=1'\" class=\"button\" $disable> $mainmenu</td></tr>\n";
		echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\">Total files in album: <b>" . (count($file_names)-$backup_not_published) . "</b> (" . floor((($file_size/1024)/1024)*100)/100 ." Mb) $backup_text</td></tr>\n";
	} else {
		echo "<tr><td nowrap=\"nowrap\" class=\"tablecell\" colspan=\"$columns_per_page\"><input type=\"submit\" name=\"upload\" value=\"$button_text\" onclick=\"this.form.upload.value='$button_text'; this.form.upload.value='Processing request please wait...'; this.form.submit(); this.form.upload.disabled='true'; this.form.configuration.disabled='true';\" class=\"button\"> <input type=\"button\" name=\"configuration\" value=\"Configuration\" onclick=\"document.location.href='index.php?admin=1&configuration=1'\" class=\"button\" $disable></td></tr>\n";
	}
} else if (isset($_REQUEST['showimage']) && isset($_REQUEST['screenwidth']) && file_exists($_REQUEST['showimage'])) {

	// Display single photo on page

	$showimage=$_REQUEST['showimage'];
	$showimageurl=rawurlencode($showimage);
	$screenwidth=$_REQUEST['screenwidth'];
	$border='';
	if ($image_border) {$border="border=\"1\"";} else {{$border="border=\"0\"";}}
	$onload='';
	if ($slideshow && isset($_REQUEST['slideshow']) && !$imagefader) {$onload="onload=\"javascript: starttimer()\"";}
	// Obtain new image width and height when resized
	$size=@GetImageSize('./' . $showimage);
	$dimensions=getdimensions($size);
	$image_width=$dimensions[0];
	$image_height=$dimensions[1];

	if ($show_name) {
		$file_name=substr($showimage,0,strrpos($showimage,'.'));
		if (ereg("([0-9]{3})",substr($file_name,0,3))) {
			if (substr($file_name,3,1)==' ' || substr($file_name,3,1)=='_')
				$file_name=trim(substr($file_name,3));
		}
		if (strpos($file_name,'/')!=false) {$file_name=substr($file_name,0,strpos($file_name,'/'));}
		if ($name_bold) {$contentshowname='<b>';}
		if ($name_italic) {$contentshowname.='<i>';}
		$contentshowname.=str_replace('_',' ',$file_name) . "<br />";
		if ($name_italic) {$contentshowname.='</i>';}
		if ($name_bold) {$contentshowname.='</b>';}
		if ($show_name_top) {echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\" align=\"center\">$contentshowname</td></tr>\n";}
	}
	$thumb_size=$image_resizeto;
	$previous_thumb='';
	$next_thumb='';
	if ($show_previous_next && count($file_names)>2) {
		if (is_dir('thumbnails')) {$thumbdir='thumbnails/';} else {$thumbdir='';}
		if (in_array($showimage,$file_names)) {
			$main_index=array_search($showimage,$file_names);
			if ($show_prev_next_size>-1) {$show_prev_next_width="width=$show_prev_next_size";} else {$show_prev_next_width='';}
			if (($main_index+1)<=count($file_names)) {
				if (($main_index+1)<count($file_names)) {$next_image=$file_names[$main_index+1];}
				if (($main_index+1)>=count($file_names)) {$next_image=$file_names[0];}
				$extension='.'.strtolower(substr($next_image,strrpos($next_image,'.')+1,strlen($next_image)));
				$next_thumb=$thumbdir . substr($next_image,0,strrpos($next_image,'.')) . '_thumb' . $extension;
				if (!file_exists($next_thumb))
					$next_thumb="<a href=\"javascript: viewer('$next_image','',0,0)\"><img $fadeinorout src=\"index.php?image=" . rawurlencode($next_image) . "&number=" . ($main_index+1) . "&total=" . count($file_names) . "\" $show_prev_next_width border=\"0\" name=\"next_thumbnail\"></a>";
				else
					$next_thumb="<a href=\"javascript: viewer('$next_image','',0,0)\"><img $fadeinorout src=\"$next_thumb\" $show_prev_next_width border=\"0\" name=\"next_thumbnail\"></a>";
			}
			if (($main_index-1)>=-1) {
				if (($main_index-1)>=0) {$next_image=$file_names[$main_index-1];}
				if (($main_index-1)<0) {$next_image=$file_names[count($file_names)-1];}
				$extension='.'.strtolower(substr($next_image,strrpos($next_image,'.')+1,strlen($next_image)));
				$previous_thumb=$thumbdir . substr($next_image,0,strrpos($next_image,'.')) . '_thumb' . $extension;
				if (!file_exists($previous_thumb))
					$previous_thumb="<a href=\"javascript: viewer('$next_image','',0,0)\"><img $fadeinorout src=\"index.php?image=" . rawurlencode($next_image) . "&number=" . ($main_index-1) . "&total=" . count($file_names) . "\" $show_prev_next_width border=\"0\" name=\"previous_thumbnail\"></a>";
				else
					$previous_thumb="<a href=\"javascript: viewer('$next_image','',0,0)\"><img $fadeinorout src=\"$previous_thumb\" $show_prev_next_width border=\"0\" name=\"previous_thumbnail\"></a>";
			}
		}
	}
	if ($show_prev_next_below) {
		$prev_next=$previous_thumb . ' ' . $next_thumb . '<br />';
		$previous_thumb='';
		$next_thumb='';
	} else {
		$prev_next='';
	}
	$multimedia_href1='';
	$multimedia_href2='';
	$multimedia_href3='';
	$content='';
	$multimedia_content='';
	$display_photo=true;
	if ($play_multimedia) {
		$mm_file=get_multimedia($showimage,false);
		if ($mm_file!='') {
			if ($link_player) {
				$multimedia_href1="<a href=\"$mm_file\" target=\"_blank\">";	
				$multimedia_href2='</a>';
				$multimedia_href3="alt=\"$language_viewmm\"";
			}
			$mm_height="height=\"42\"";
			if ($image_width>300) {$mm_width="width=\"$image_width\"";} else {$mm_width="width=\"280\"";}
			$extension=strtolower(substr($mm_file,strrpos($mm_file,'.')+1,strlen($mm_file)));
			$movies=explode(',',$movie_formats);
			if (in_array($extension,$movies)) {
				$mm_height='';
				$mm_width='';
				$display_photo=false;
			}
			if ($embed_player && $display_photo) 
				$content.="<object><embed src=\"$mm_file\" autostart=\"false\" loop=\"false\" $mm_height $mm_width controller=\"true\"></embed></object><br /> <br/ >\n";
			if ($embed_player && !$display_photo) 
				$content.="$previous_thumb <object><embed src=\"$mm_file\" autostart=\"false\" loop=\"false\" $mm_height $mm_width controller=\"true\"></embed></object> $next_thumb<br /> <br/ >\n";
			if ($download_multimedia)
				$multimedia_content="<a href=\"" . $mm_file . "\">$language_download $mm_file</a><br />";
			if (!$mm_photo) {$image_resize=false;}
		}
	}
	$image_width="width=$image_width";
	$image_height="height=$image_height";
	if (!$image_resize) {
		$image_width='';
		$image_height='';
	}
	if ($link_bigimage && $multimedia_href1=='') {
		$multimedia_href1="<a href=\"$showimageurl\" target=\"_blank\">";	
		$multimedia_href2='</a>';
	}
	if ($animated_thumbnails && $size[2]==1) {$image_resize=false;}
	if ($image_resize && $display_photo) {
		echo "<tr><td nowrap=\"nowrap\" valign=\"$show_prev_next_position\">$previous_thumb</td><td nowrap=\"nowrap\" class=\"tablecell\">$multimedia_href1<img src='index.php?resize=1&image=$showimageurl&screenwidth=$screenwidth' $image_width $image_height $border $onload $fader $multimedia_href3>$multimedia_href2</td><td nowrap=\"nowrap\" valign=\"$show_prev_next_position\">$next_thumb</td></tr>\n";
	} else if ($display_photo) {
		echo "<tr><td nowrap=\"nowrap\" valign=\"$show_prev_next_position\">$previous_thumb</td><td nowrap=\"nowrap\" class=\"tablecell\">$multimedia_href1<img src=\"$showimageurl\" $image_width $image_height $border $onload $fader $multimedia_href3>$multimedia_href2</td><td nowrap=\"nowrap\" valign=\"$show_prev_next_position\">$next_thumb</td></tr>\n";
	}
	if ($show_name && !$show_name_top) {$content.=$contentshowname;}
	if ($prev_next!='') {$content.=$prev_next;}
	if ($info_bold) {$content.='<b>';}
	if ($info_italic) {$content.='<i>';}
	if ($show_download && !isset($_REQUEST['slideshow'])) {$content.="<a href=\"" . $showimage . "\">$language_download $showimage</a><br />";}
	$content.=$multimedia_content;
	if ($show_iptc_caption) {
		$caption=iptc($showimage);
		if ($caption!='') {$content.=$caption . "<br />";}
	}
	if ($show_exif_comment) {
		$exif_comment=getexif($showimage,$show_date_format,'comment');
		if ($exif_comment!='') {$content.=$exif_comment . "<br />";}
	}
	if ($show_details) {
		$file_size=@filesize($showimage);
		$content.=$size[0] . "x" . $size[1] . " / " . floor($file_size/1024) . " Kb<br />";
	}
	if ($show_date) {$content.=getexif($showimage,$show_date_format,'date') . "<br />";}
	// Update statistics
	if ($hit_counter) {
		echo "<script language=\"JavaScript\">\n";
		echo "	updatestats('$showimage','');\n";
		echo "</script>\n";
	}
	if ($rating && !isset($_REQUEST['slideshow'])) {
		$randomid=uniqid(rand(),true);
		if (!$rating_text)
			$content.="$language_rating <img src=\"index.php?rating=0&rateimage=$showimageurl&id=$randomid\" width=\"38\" height=\"6\" border=\"0\" alt=\"$language_rating_tooltip\"> (" . gettotalvotes($showimage,true) . " $language_rating_votes)";
		else 
			$content.="$language_rating " . round(gettotalvotes($showimage,false)/(gettotalvotes($showimage,true)+0.001),2) . " (" . gettotalvotes($showimage,true) . " $language_rating_votes)";
		$content.="<br />&nbsp; <br /><select name=\"rate\" class=\"input\" onChange=\"window.location.replace('index.php?showimage=$showimageurl&screenwidth='+screen.width+'&rateimage=$showimageurl&rating='+this.form.rate.options[this.form.rate.options.selectedIndex].value)\"><option selected>$language_rating_choose</option><option value=\"5\">$language_rating_excellent</option><option value=\"4\">$language_rating_verygood</option><option value=\"3\">$language_rating_good</option><option value=\"2\">$language_rating_fair</option><option value=\"1\">$language_rating_poor</option></select>";
	}
	if ($info_bold) {$content.='</b>';}
	if ($info_italic) {$content.='</i>';}
	if ($show_exif_comment || $show_iptc_caption) {$nowrap="";} else {$nowrap="nowrap=\"nowrap\"";}
	if ($content!='') {echo "<tr><td colspan=\"$columns_per_page\" $nowrap class=\"tablecell\">$content</td></tr>\n";}
	// Display textfile
	if ($image_txtfile) {
		$showimage_txt=substr($showimage,0,strrpos($showimage,'.')).'.txt';
		if (file_exists($showimage_txt)) {
			echo "<tr><td colspan=\"$columns_per_page\" class=\"tablecell\">\n";
			$lines=file($showimage_txt);
			foreach ($lines as $line) {echo htmlentities($line)."<br />";}
			echo "</td></tr>\n";
		} else if (file_exists('textfiles/'.$showimage_txt)) {
			echo "<tr><td colspan=\"$columns_per_page\" class=\"tablecell\">\n";
			$lines=file('textfiles/'.$showimage_txt);
			foreach ($lines as $line) {echo htmlentities($line)."<br />";}
			echo "</td></tr>\n";
		}
	}
} else if ($order>1) {
	if ($order==2) {
		// Order has been placed - details required
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><b>$language_shop_address</b></td></tr>\n";
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><textarea class=\"input\" name=\"address\" cols=\"60\" rows=\"4\"></textarea></td></tr>\n";
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><b>$language_shop_email_address</b></td></tr>\n";
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><input type=\"text\" name=\"email_address\" class=\"input\" size=\"60\"></td></tr>\n";
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><b>$language_shop_ordercomments</b></td></tr><tr><td>\n";
		echo "<textarea class=\"input\" name=\"finalorder\" cols=\"60\" rows=\"12\">";
		$choices1=explode(',',$shop_choice1);
		$choices2=explode(',',$shop_choice2);
		for ($count=0;$count<$max_files;$count++) {
			$orderline='';
			if (isset($_REQUEST['shop_q_' . $count])) {
				if($_REQUEST['shop_q_' . $count]!=$choices1[0])
					$orderline=$_REQUEST['shop_q_' . $count] . ' ';
			}
			if (isset($_REQUEST['shop_t_' . $count])) {
				if($_REQUEST['shop_t_' . $count]!=$choices2[0])
					$orderline.=$_REQUEST['shop_t_' . $count];
			}
			if ($orderline!='') {echo $orderline . ' : ' . $file_names[$count] . chr(10);}
		}
		echo "</textarea></td></tr>";
		echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><input type=\"hidden\" name=\"orderphotos\" value=\"0\"><input type=\"button\" name=\"confirmorder\" onclick=\"document.browser.orderphotos.value=3; document.browser.submit();\" class=\"button\" value=\"$language_shop_order\"> <input type=\"button\" name=\"cancel\" onclick=\"document.location.href='index.php';\" class=\"button\" value=\"$language_shop_cancel\"></td></tr>\n";
	} else if ($order==3) {
		// Order has been confirmed - show confirmation
		if (isset($_REQUEST['address']) && isset($_REQUEST['email_address']) && isset($_REQUEST['finalorder'])) {
			$message=$_REQUEST['address'] . chr(10) . chr(10) . $_REQUEST['email_address'] . chr(10) . chr(10) . $_REQUEST['finalorder'];
			echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><b>$language_shop_confirmation</b></td></tr>\n";
			echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\">&nbsp;</td></tr>\n";
			echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><textarea class=\"input\" name=\"message\" cols=\"60\" rows=\"20\" readonly>$message</textarea></td></tr>\n";
			echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\">&nbsp;</td></tr>\n";
			echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><input type=\"button\" name=\"cancel\" onclick=\"document.location.href='index.php';\" class=\"button\" value=\"OK\"></td></tr>\n";
			// Send email with the order
			mail($shop_email,'New order!!','Order from photoalbum: ' . $title . chr(10) . chr(10) . $message,'From: ' . $_REQUEST['email_address'] . "\r\n" . 'Reply-To: ' . $_REQUEST['email_address'] . "\r\n" . 'X-Mailer: PHP/' . phpversion());
		}
	}
} else {

	// Display thumbnail images

	$colcount=0;
	for ($count=$page;$count<$show_files;$count++) {
		$file_name=substr($file_names[$count],0,strrpos($file_names[$count],'.'));
		$link='';
		if (ereg("([0-9]{3})",substr($file_name,0,3))) {
			if (substr($file_name,3,1)==' ' || substr($file_name,3,1)=='_')
				$file_name=trim(substr($file_name,3));
		}
		if (strpos($file_name,'/')!=false) {
			$link=substr($file_names[$count],0,strpos($file_names[$count],'/')).'/index.php';
			$file_name=substr($file_name,0,strpos($file_name,'/'));
		}
		$size=@GetImageSize('./' . $file_names[$count]);
		$dimensions=getdimensions($size);
		$popup_width=$dimensions[0];
		$popup_height=$dimensions[1];
		$image_filename=rawurlencode($file_names[$count]);
		$extension='.'.strtolower(substr($file_names[$count],strrpos($file_names[$count],'.')+1,strlen($file_names[$count])));
		if ($size[2]==1) {$extension='.gif';}
		if ($size[2]==2) {$extension='.jpg';}
		if ($size[2]==3) {$extension='.png';}
		if (strpos($file_names[$count],'/')) {$subdir=substr($file_names[$count],0,strpos($file_names[$count],'/')+1);} else {$subdir='';}
		if (is_dir($subdir . 'thumbnails')) {$thumbdir='thumbnails/';} else {$thumbdir='';}
		if ($total_amount_albums>0) {
			$thumb_filename=$subdir . $thumbdir . substr($file_names[$count],strlen($subdir),strrpos($file_names[$count],'.')-strlen($subdir)) . '_thumbindex' . $extension;
			if ($hit_counter) {$counter_code="href=\"javascript:updatestats('$file_names[$count]','$link')\"";} else {$counter_code="href=\"$link\"";}
		} else {
			$thumb_filename=$subdir . $thumbdir . substr($file_names[$count],0,strrpos($file_names[$count],'.')) . '_thumb' . $extension;
			$counter_code="href=\"$link\"";
		}
		$alt=str_replace('_',' ',$file_name);
		// Check for valid thumbnail file or create a new thumbnail
		if (file_exists($thumb_filename)) {
			if (@filemtime($thumb_filename)>@filemtime('index.php') || !$create_thumbnail_cache) {$valid_thumb=true;} else {$valid_thumb=false;}
			if (file_exists('configuration.php'))
				if (@filemtime($thumb_filename)>@filemtime('configuration.php') || !$create_thumbnail_cache) {$valid_thumb=true;} else {$valid_thumb=false;}
		} else {
			$valid_thumb=false;
		}
		// Check for animated GIF's
		if ($animated_thumbnails && $size[2]==1) {
			$valid_thumb=true;
			if (!file_exists($thumb_filename))
				$thumb_filename=$subdir . $thumbdir . $file_names[$count];
		}
		// Check if thumbnail file belongs to multimedia icon
		if ($play_multimedia && $mm_dir!='' && !$mm_thumbnail) {
			if (file_exists($mm_dir)) {
				$all_mm_files=get_multimedia('',true);
				foreach ($all_mm_files as $key => $filename) {$all_mm_files[$key]=strtolower(substr($filename,0,strrpos($filename,'.')));}
				if (in_array(strtolower(substr($file_names[$count],0,strrpos($file_names[$count],'.'))),$all_mm_files)) {$valid_thumb=true;}
			}
		}
		$is_index=substr($file_names[$count],0,strrpos($file_names[$count],'.'));
		if (strpos($is_index,'/')) {$is_index=substr($is_index,strrpos($is_index,'/')+1);}
		$multimedia_href1='';
		$multimedia_href2='';
		$multimedia_content='';
		$content='';
		if ($show_name && $show_thumb_name_top) {
			if ($name_bold) {$content.='<b>';}
			if ($name_italic) {$content.='<i>';}
			$content.=str_replace('_',' ',$file_name) . "<br />";
			if ($name_bold) {$content.='</b>';}
			if ($name_italic) {$content.='</i>';}
		}
		if ($play_multimedia) {
			$mm_file=get_multimedia($file_names[$count],false);
			if ($mm_file!='') {
				$multimedia_href1="<a href=\"$mm_file\" target=\"_blank\">";	
				$multimedia_href2='</a>';
				if ($download_multimedia) {
					$extension=strtolower(substr($mm_file,strrpos($mm_file,'.')+1,strlen($mm_file)));
					$multimedia_content="<a href=\"" . $mm_file . "\">$language_download $mm_file</a><br />";
				}
			}
		}
		if ($valid_thumb) {
			if (strpos($file_names[$count],'/')===false && $size[0]) {
				$onclick='';
				if ($hit_counter) {$onclick="onclick=\"updatestats('$file_names[$count]','')\"";}
				if ($multimedia_href1=='')
					$content.="<a href=\"#link\" onclick=\"viewer('$file_names[$count]','$file_name',$popup_width,$popup_height); return false;\"><img $fadeinorout src=\"" . $thumb_filename . "\" alt=\"$language_view $alt\" border=\"0\" vspace=\"3\"></a><br />";
				else if ($popup)
					$content.="$multimedia_href1<img $fadeinorout src=\"" . $thumb_filename . "\" alt=\"$language_viewmm $alt\" border=\"0\"  vspace=\"3\" $onclick>$multimedia_href2<br />";
				else
					$content.="<a href=\"#link\" onclick=\"viewer('$file_names[$count]','$file_name',$popup_width,$popup_height); return false;\"><img $fadeinorout src=\"" . $thumb_filename . "\" alt=\"$language_view $alt\" border=\"0\" vspace=\"3\"></a><br />";
			} else if ($size[0]) {
				$content.="<a $counter_code><img $fadeinorout src=\"" . $thumb_filename . "\" alt=\"$language_view $alt\" border=\"0\" vspace=\"3\"></a><br />";
			} else {
				$content.="<img $fadeinorout src=\"" . rawurlencode($thumb_filename) . "\" vspace=\"3\"><br />";
			}
		} else {
			if (strpos($file_names[$count],'/')===false && $size[0]) {
				$onclick='';
				if ($hit_counter) {$onclick="onclick=\"updatestats('$file_names[$count]','')\"";}
				if ($multimedia_href1=='')
					$content.="<a href=\"#link\" onclick=\"viewer('$file_names[$count]','$file_name',$popup_width,$popup_height); return false;\"><img $fadeinorout src=\"index.php?image=$image_filename&number=$count&total=$max_files&indexalbum=$total_amount_albums\" alt=\"$language_view $alt\" border=\"0\" vspace=\"3\"></a><br />";
				else if ($popup)
					$content.="$multimedia_href1<img $fadeinorout src=\"index.php?image=$image_filename&number=$count&total=$max_files&indexalbum=$total_amount_albums\" alt=\"$language_viewmm $alt\" border=\"0\" $onclick vspace=\"3\">$multimedia_href2<br />";
				else
					$content.="<a href=\"#link\" onclick=\"viewer('$file_names[$count]','$file_name',$popup_width,$popup_height); return false;\"><img $fadeinorout src=\"index.php?image=$image_filename&number=$count&total=$max_files&indexalbum=$total_amount_albums\" alt=\"$language_view $alt\" border=\"0\" vspace=\"3\"></a><br />";
			} else if ($size[0]) {
				$content.="<a $counter_code><img $fadeinorout src=\"index.php?image=$image_filename&number=$count&total=$max_files&indexalbum=$total_amount_albums\" alt=\"$language_view $alt\" border=\"0\" vspace=\"3\"></a><br />";
			} else {
				$content.="<img $fadeinorout src=\"index.php?image=$image_filename&number=$count&total=$max_files&indexalbum=$total_amount_albums\" border=\"0\" vspace=\"3\"><br />";
			}
		}
		if ($show_name && !$show_thumb_name_top) {
			if ($name_bold) {$content.='<b>';}
			if ($name_italic) {$content.='<i>';}
			$content.=str_replace('_',' ',$file_name) . "<br />";
			if ($name_bold) {$content.='</b>';}
			if ($name_italic) {$content.='</i>';}
		}
		if ($info_bold) {$content.='<b>';}
		if ($info_italic) {$content.='<i>';}
		if ($show_download) {$content.="<a href=\"" . $file_names[$count] . "\">$language_download $file_names[$count]</a><br />";}
		$content.=$multimedia_content;
		if ($show_details) {
			$file_size=@filesize($file_names[$count]);
			$content.=$size[0] . "x" . $size[1] . " / " . floor($file_size/1024) . " Kb<br />";
		}
		if ($show_date) {$content.=getexif($file_names[$count],$show_date_format,'date') . "<br />";}
		$randomid=uniqid(rand(),true);
		if ($hit_counter && !$hit_counter_text)
			$content.="<img $fadeinorout src=\"index.php?statistics=0&image=$image_filename&id=$randomid\" width=\"55\" height=\"12\" border=\"0\" vspace=\"5\" alt=\"$language_hitcounter_tooltip\"><br />";
		else if ($hit_counter && $hit_counter_text)
			$content.="$language_hits " . gettotalhits($file_names[$count]) . "<br />";
		if ($rating && strpos($file_names[$count],'/')===false && !$popup && !$rating_text)
			$content.="$language_rating <img $fadeinorout src=\"index.php?rating=0&rateimage=$image_filename&id=$randomid\" width=\"38\" height=\"6\" border=\"0\" alt=\"$language_rating_tooltip\"> (" . gettotalvotes($file_names[$count],true) . " $language_rating_votes)<br />";
		else if ($rating && strpos($file_names[$count],'/')===false && !$popup && $rating_text)
			$content.="$language_rating " . round(gettotalvotes($file_names[$count],false)/(gettotalvotes($file_names[$count],true)+0.001),2) . " (" . gettotalvotes($file_names[$count],true) . " $language_rating_votes)<br />";
		if ($thumbnail_countcomments) {
			$totalcomments=gettotalcomments($file_names[$count]);
			if ($totalcomments>0) {$content.=$language_countcomments . $totalcomments ."<br />";}
		}
		if ($info_bold) {$content.='</b>';}
		if ($info_italic) {$content.='</i>';}
		// Display textfile
		if ($thumbnail_txtfile) {
			$nowrap="nowrap=\"nowrap\"";
			$showimage_txt=substr($file_names[$count],0,strrpos($file_names[$count],'.')).'.txt';
			if (file_exists($showimage_txt)) {
				$lines=file($showimage_txt);
				foreach ($lines as $line) {$content.=htmlentities($line)."<br />";}
				$nowrap='';
			} else {
				if (strpos($showimage_txt,'/')!=false) {
					if (is_dir(substr($showimage_txt,0,strrpos($showimage_txt,'/')) . '/textfiles'))
						$showimage_txt=str_replace('/','/textfiles/',$showimage_txt);
					} else {
						if (is_dir('textfiles')) {$showimage_txt='textfiles/'.$showimage_txt;}
					}
				if (file_exists($showimage_txt)) {
					$lines=file($showimage_txt);
					foreach ($lines as $line) {$content.=htmlentities($line)."<br />";}
					$nowrap='';
				}
			}
		} else {
			$nowrap="nowrap=\"nowrap\"";
		}
		// Add shop selection boxes
		if ($shop && $order==1) {
			$content.=$language_shop_info . "<br />";
			if ($shop_choice1!='') {
				$choices=explode(',',$shop_choice1);
				$content.="<select name=\"shop_q_$count\" class=\"input\">";
				foreach ($choices as $key => $choice) {$content.="<option value=\"$choice\">$choice</option>";}
				$content.="</select>";
			}
			if ($shop_choice2!='') {
				$choices=explode(',',$shop_choice2);
				$content.="<select name=\"shop_t_$count\" class=\"input\">";
				foreach ($choices as $key => $choice) {$content.="<option value=\"$choice\">$choice</option>";}
				$content.="</select>";
			}
			$content.="<br />";
		}
		if ($thumbnail_spacing!='') {$col_width="width=\"$thumbnail_spacing" . "px\"";} else {$col_width='';}
		if ($columns_per_page==1) {
			echo "<tr><td $nowrap class=\"tablecell\" $col_width>$content</td></tr>\n";
		} else {
			$colcount+=1;
			if ($colcount==1) {
				echo "<tr><td $nowrap class=\"tablecell\" $col_width>$content</td>\n";
			} else if ($colcount<$columns_per_page) {
				echo "<td $nowrap class=\"tablecell\" $col_width>$content</td>\n";
			} else {
				echo "<td $nowrap class=\"tablecell\" $col_width>$content</td></tr>\n";
				$colcount=0;
			}
		}
		if ($colcount<$columns_per_page && $colcount!=0 && $count==$show_files-1) {
			for ($emptycol=$colcount;$emptycol<$columns_per_page;$emptycol++) {echo "<td> &nbsp;</td>";}
			echo "</tr>\n";
		}
	}
}

echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"> &nbsp;</td></tr>\n";
if ($shop && $order==1)
	echo "<tr><td colspan=\"$columns_per_page\" nowrap=\"nowrap\"><center><input type=\"hidden\" name=\"orderphotos\" value=\"0\"><input type=\"button\" onclick=\"document.browser.orderphotos.value=2; document.browser.submit();\" name=\"orderbutton\" value=\"$language_shop_order\" class=\"button\"> <input type=\"button\" name=\"cancel\" onclick=\"document.location.href='index.php';\" class=\"button\" value=\"$language_shop_cancel\"></center></td></tr>\n";

// Page numbers - back & forward browsing etc.
if ((count($file_names)/$images_per_page)>29) {$nowrap='';} else {$nowrap="nowrap=\"nowrap\"";}
echo "<tr><td $nowrap colspan=\"$columns_per_page\">";
if ((count($file_names)>$images_per_page || isset($_REQUEST['showimage']))  && $order==0) {
	if ($albumpage==1)
		echo "$language_page <a href=\"javascript:showpage(0)\"><u>1</u></a>";
	else
		echo "$language_page <a href=\"javascript:showpage(0)\">1</a>";
}
if ($order==0) {
	for ($i=$images_per_page;$i<count($file_names);$i+=$images_per_page) {
		$p=ceil($i/$images_per_page)+1;
		if ($albumpage==$p)
			echo " | <a href=\"javascript:showpage($i)\"><u>$p</u></a>";
		else
			echo " | <a href=\"javascript:showpage($i)\">$p</a>";
	}
}
// Back & forward browsing (only when slideshow is not active)
if (!isset($_REQUEST['slideshow'])) {
	if (isset($_REQUEST['showimage'])) {
		if (in_array($_REQUEST['showimage'],$file_names)) {
			$back=array_search($_REQUEST['showimage'],$file_names)-1;
			$forward=$back+2;
			$count=count($file_names);
			if ($count>1) {
				if ($back>=0 && $forward<$count)
					echo " | <a href=\"javascript:viewer('$file_names[$back]','',0,0)\">$language_view_previous</a> <a href=\"javascript:viewer('$file_names[$forward]','',0,0)\">$language_view_next</a>";
				if ($forward>=$count)
					echo " | <a href=\"javascript:viewer('$file_names[$back]','',0,0)\">$language_view_previous</a>";
				if ($back<0)
					echo " | <a href=\"javascript:viewer('$file_names[$forward]','',0,0)\">$language_view_next</a>";
			}
			// Insert code for keyboard navigation
			if ($enable_keyboard_arrows) {
				echo "<script language=\"JavaScript\">\n";
				echo "function reload(e) {\n";
				echo "	if(e) {\n";
				if ($forward>=$count) {$forward=0;}
				if ($back<0) {$back=$count-1;}
				echo "		if(e.type=='keydown' && (e.which==37)) {viewer('$file_names[$back]','',0,0);}\n";
				echo "		if(e.type=='keydown' && e.which==39) {viewer('$file_names[$forward]','',0,0);}\n";
				echo "	}\n";
				echo "	if(window.event) {\n";
				echo "		if(event.type=='keydown' && (event.keyCode==37)) {viewer('$file_names[$back]','',0,0);}\n";
				echo "		if(event.type=='keydown' && event.keyCode==39) {viewer('$file_names[$forward]','',0,0);}\n";
				echo "	}\n";
				echo "}\n";
				echo "document.onkeydown=reload;\n";
				echo "</script>\n";
			}
		} 
	}
}
if ($slideshow && isset($_REQUEST['showimage']) && isset($_REQUEST['screenwidth']) && count($file_names)>1) {
	$showimage=rawurlencode($_REQUEST['showimage']);
	$screenwidth=(int) $_REQUEST['screenwidth'];
	$mm_slideshow=false;
	// Check if thumbnail file belongs to multimedia file
	if ($play_multimedia) {
		$all_mm_files=get_multimedia('',true);
		foreach ($all_mm_files as $key => $filename) {$all_mm_files[$key]=strtolower(substr($filename,0,strrpos($filename,'.')));}
		if (in_array(strtolower(substr($_REQUEST['showimage'],0,strrpos($_REQUEST['showimage'],'.'))),$all_mm_files)) {$mm_slideshow=true;}
	}
	if (!$mm_slideshow) {
		if (isset($_REQUEST['slideshow']))
			echo " | <a href=\"index.php?showimage=$showimage&screenwidth=$screenwidth\">$language_stop_slideshow</a>";
		else
			echo " | <a href=\"index.php?slideshow=1&showimage=$showimage&screenwidth=$screenwidth\">$language_slideshow</a>";
	}
}
if ($visitor_comments && isset($_REQUEST['showimage']) && !isset($_REQUEST['slideshow']))
	echo " | <a href=\"#link\" onclick=\"expandCollapse('comments');\">$language_add_comment</a>";
if ($visitor_search && !isset($_REQUEST['showimage']) && $admin_link=='' && $order==0) {
	if (count($file_names)>$images_per_page) {$separator=' | ';} else {$separator='';}
	if (isset($_REQUEST['searchkeyword']) && $images_per_page==9999) {echo "$separator<a href=\"index.php\">$language_search_cancel</a> | ";}
	echo "$separator<a href=\"#link\" onclick=\"expandCollapse('search');\">$language_search</a> ";
	if ($images_per_page==9999 && $shop) {echo " | ";}
}
if ($visitor_upload && !isset($_REQUEST['showimage']) && $admin_link=='' && !$shop && $images_per_page!=9999) {
	$file_size=0;
	if ($max_album_size>0) {
		if ($dir=@opendir('./')) {
			while ($file=@readdir($dir)) {
				if (($file!='.') && ($file!='..') && !is_dir($file))
					$file_size+=@filesize($file);
			} 
		}
		@closedir($dir);
	}
	if ($visitor_password && !$logged_in) {$action="javascript:document.location.href='index.php?requirelogin=1'";} else {$action="expandCollapse('upload')";}
	if (count($file_names)>$images_per_page && $max_album_size>=floor((($file_size/1024)/1024)*100)/100) {
		echo " | <a href=\"#link\" onclick=\"$action;\">$language_add_file</a>";
	} else if ($max_album_size>=floor((($file_size/1024)/1024)*100)/100) {
		echo "<a href=\"#link\" onclick=\"$action;\">$language_add_file</a> ";
	}
}
if ($show_email_link && !isset($_REQUEST['slideshow']) && $admin_link=='' && $order==0 && $images_per_page!=9999) {
	$url="http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
	if (!empty($_SERVER["QUERY_STRING"])) {$url.="?" . rawurldecode($_SERVER['QUERY_STRING']);}
	echo " | <a href=\"mailto:?subject=" . rawurlencode($language_email_subject) . "&body=%0D" . rawurlencode($language_email_comment) . "%0D%20%0D" . rawurlencode($url) . "%0D%20%0DPowered%20by%20EasyPhpAlbum\"><img $fadeinorout src=\"index.php?emaillink=1\" border=\"0\" vspace=\"0\" hspace=\"0\" alt=\"$language_email_alt\"></a>";
}
if ($shop && $order==0 && !isset($_REQUEST['showimage'])) {
	if (count($file_names)>$images_per_page) {$separator=' | ';} else {$separator='';}
	echo "$separator<input type=\"hidden\" name=\"orderphotos\" value=\"0\"><a href=\"#link\" onclick=\"document.browser.orderphotos.value=1; document.browser.submit();\">$language_shop_order</a>";
}
if ($visitor_sort && !isset($_REQUEST['showimage']) && $admin_link=='' && $order==0 && $images_per_page!=9999) {
	if (isset($_REQUEST['sort'])) {
		if ($_REQUEST['sort']=='name') {$sort_1='selected';} else {$sort_1='';}
		if ($_REQUEST['sort']=='hitcounter') {$sort_2='selected';} else {$sort_2='';}
		if ($_REQUEST['sort']=='comments') {$sort_3='selected';} else {$sort_3='';}
		if ($_REQUEST['sort']=='rating') {$sort_4='selected';} else {$sort_4='';}
		if ($_REQUEST['sort']=='date') {$sort_5='selected';} else {$sort_5='';}
	} else {
		$sort_1='selected';
		$sort_2='';
		$sort_3='';
		$sort_4='';
		$sort_5='';
	}
	if (count($file_names)>$images_per_page) {$separator=' | ';} else {$separator='';}
	$sort_selection=$separator."<select name=\"sort\" class=\"input\" onchange=\"showpage(0);\"><option value=\"name\" $sort_1>$language_sort_option1</option>";
	if ($hit_counter) {$sort_selection.="<option value=\"hitcounter\"  $sort_2>$language_sort_option2</option>";}
	if ($visitor_comments) {$sort_selection.="<option value=\"comments\" $sort_3>$language_sort_option3</option>";}
	if ($rating) {$sort_selection.="<option value=\"rating\" $sort_4>$language_sort_option4</option>";}
	echo "$sort_selection<option value=\"date\" $sort_5>$language_sort_option5</option></select>";
}
echo "</td></tr>\n";
echo "</table></div>\n";

// Visitor comments
if ($visitor_comments && isset($_REQUEST['showimage'])) {
	echo "<div id=\"comments\" style=\"display: none\"><center><input type=\"hidden\" name=\"comment_screenwidth\"><input type=\"hidden\" name=\"comment_showimage\" value=\"" . $_REQUEST['showimage'] ."\"><table class=\"tablesmaller\"><tr><td class=\"tablecell\">$language_username_comment: <input type=\"text\" name=\"comment_username\" class=\"input\" maxlength=\"10\" size=\"10\"></td></tr><tr><td class=\"tablecell\"><textarea class=\"input\" name=\"newcomment\" cols=\"80\" rows=\"6\"></textarea></td></tr>\n";
	echo "<tr><td class=\"tablecell\"><input type=\"button\" value=\"$language_save_comment\" class=\"button\" onclick=\"savecomments();\"></td></tr></table></center></div>\n";
	echo "<script language=\"JavaScript\">\n";
	echo "function savecomments() {\n";
	echo "if (document.browser.newcomment.value!='') {\n";
	echo "	if (document.browser.newcomment.value.length>$comment_size) {\n";
	echo "		alert('$language_comment_max : $comment_size');\n";
	echo "	} else {\n";
	echo "		if (confirm('$language_save_comment ?')) {\n";
	echo "		document.browser.comment_screenwidth.value=screen.width;\n";
	echo "		document.browser.submit();}\n";
	echo "	}\n";
	echo "} else {\n";
	echo "expandCollapse('comments');\n";
	echo "}\n";
	echo "}\n";
	echo "</script>\n";
}

// Visitor upload
if ($visitor_upload && !isset($_REQUEST['showimage'])) {
	if (!$visitor_password || ($visitor_password && $logged_in)) {
		echo "<div id=\"upload\" style=\"display: none\"><center><table class=\"tablesmaller\"><tr><td class=\"tablecell\">$language_username_comment: <input type=\"text\" name=\"comment_username\" class=\"input\" maxlength=\"10\" size=\"10\"></td></tr><tr><td class=\"tablecell\"></td></tr>\n";
		echo "<tr><td class=\"tablecell\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"" . ($visitor_upload_size*1024) . "\">";
		for($i=1;$i<($visitor_upload_max_files+1);$i++) {echo "<input type=\"file\" name=\"uploadfile$i\" class=\"input\"><br />";}
		echo "</td></tr>\n";
		echo "<tr><td class=\"tablecell\"><input type=\"submit\" name=\"submit_upload\" value=\"$language_upload_comment\" onclick=\"this.form.submit_upload.value='$language_upload_comment'; this.form.submit(); this.form.submit_upload.disabled='true';\" class=\"button\"></td></tr></table></center></div>\n";
		echo "<script language=\"JavaScript\">\n";
		if (isset($_REQUEST['requirelogin'])) {echo "expandCollapse('upload');\n";}
		echo "</script>\n";
	}
}

// Visitor search
if ($visitor_search && !isset($_REQUEST['showimage'])) {
	echo "<div id=\"search\" style=\"display: none\"><center><table class=\"tablesmaller\"><tr><td class=\"tablecell\" nowrap=\"nowrap\">$language_search_keyword:</td><tr><td class=\"tablecell\"> <input type=\"text\" name=\"searchkeyword\" class=\"input\" maxlength=\"60\" size=\"20\"></td></tr>\n";
	echo "<tr><td class=\"tablecell\"><input type=\"submit\" name=\"submit_search\" value=\"$language_search\" class=\"button\"></td></tr></table></center></div>\n";
	if (isset($_REQUEST['searchkeyword'])) {echo "<input type=\"hidden\" name=\"old_searchkeyword\" value=\"" . $_REQUEST['searchkeyword'] ."\">";}
}

// Add javascript fot hide/show div-section
if ($visitor_upload || $visitor_search || $visitor_comments) {
	echo "<script language=\"JavaScript\">\n";
	echo "function expandCollapse(divsection) {\n";
	echo "	var element = document.getElementById(divsection);\n";
	echo "	element.style.display = (element.style.display == \"none\") ? \"block\" : \"none\";\n";
	echo "}\n";
	echo "</script>\n";
}

echo "</center><div class=\"line\">&nbsp; </div>";

// Insert menu
if ($show_bottommenu) {album_menu();}

if ($show_poweredby_easyphpalbum)
	echo "<p align=\"right\"><a href=\"http://www.mywebmymail.com\"><img src=\"index.php?poweredby=1&$admin_link\" border=\"0\" vspace=\"10\" hspace=\"10\" alt=\"v1.3.7\"></a></p>\n";

if ($footer!='' && $admin_link=='') {
	$extension=strtolower(substr($footer,strrpos($footer,'.')+1,strlen($footer)));
	if ($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif') {
		echo "<p align=\"right\"> &nbsp;</p>";
		echo "<table width=\"100%\" border=\"0\">\n";
		echo "<tr><td><img src=\"$footer\" border=\"0\"></td></tr>\n";
		echo "</table>\n";
	}
} else {
	echo "<p align=\"right\"> &nbsp;</p>";
	echo "<table width=\"100%\" border=\"0\">\n";
	// Add you own php footer here (in the table instead of &nbsp;)
	echo "<tr><td> &nbsp;</td></tr>\n";
	echo "<tr><td> &nbsp;</td></tr>\n";
	echo "</table>\n";
}

// End of HTML page
echo "</div></form></body></html>\n";




// Functions

// Create error image
function invalid_image($message) {
	$im=imagecreate(80,75);
	$black=imagecolorallocate($im,0,0,0);
	$yellow=imagecolorallocate($im,255,255,0);
	imagefilledrectangle($im,0,0,80,75,imagecolorallocate($im,255,0,0));
	imagerectangle($im,0,0,79,74,$black);
	imageline($im,0,20,80,20,$black);
	imagefilledrectangle($im,1,1,78,19,$yellow);
	imagefilledrectangle($im,27,35,52,60,$yellow);
	imagerectangle($im,26,34,53,61,$black);
	imageline($im,27,35,52,60,$black);
	imageline($im,52,35,27,60,$black);
	imagestring($im,1,5,5,$message,$black);
	return $im;
}

// Create powered by image
function poweredby_image() {
	global $logo_line_color,$logo_text_color;
	$im=imagecreate(64,20);
	$blue=imagecolorallocate($im,hexdec(substr($logo_text_color,1,2)),hexdec(substr($logo_text_color,3,2)),hexdec(substr($logo_text_color,5,2)));
	$orange=imagecolorallocate($im,hexdec(substr($logo_line_color,1,2)),hexdec(substr($logo_line_color,3,2)),hexdec(substr($logo_line_color,5,2)));
	$white=imagecolorresolve($im,255,255,255);
	imagecolortransparent($im,$white);
	imageline($im,0,0,64,0,$orange);
	imageline($im,0,19,64,19,$orange);
	imagefilledrectangle($im,0,1,64,18,$white);
	imagestring($im,1,2,2,' Powered by',$blue);
	imagestring($im,1,2,10,'EasyPhpAlbum',$blue);
	return $im;
}

// Create emaillink image
function emaillink_image() {
	global $email_color;
	$im=imagecreate(20,10);
	$black=imagecolorallocate($im,0,0,0);
	imagefilledrectangle($im,0,0,20,10,$black);
	imagefilledrectangle($im,1,1,18,8,imagecolorallocate($im,hexdec(substr($email_color,1,2)),hexdec(substr($email_color,3,2)),hexdec(substr($email_color,5,2))));
	imageline($im,1,1,9,5,$black);
	imageline($im,11,5,19,1,$black);
	imageline($im,9,5,11,5,$black);
	imageline($im,1,9,6,4,$black);
	imageline($im,13,4,18,9,$black);
	return $im;
}

// Create hitcounter image
function hitcounter_image($hits) {
	global $hit_counter_linecolor,$hit_counter_textcolor,$hit_counter_segmentcolor,$hit_counter_random;
	if (strlen($hits)>5) {$hits=substr($hits,-5);}
	$hits=str_repeat('0',5-strlen($hits)).$hits;
	$im=imagecreate(55,12);
	$col_text=imagecolorallocate($im,hexdec(substr($hit_counter_textcolor,1,2)),hexdec(substr($hit_counter_textcolor,3,2)),hexdec(substr($hit_counter_textcolor,5,2)));
	$col_line=imagecolorallocate($im,hexdec(substr($hit_counter_linecolor,1,2)),hexdec(substr($hit_counter_linecolor,3,2)),hexdec(substr($hit_counter_linecolor,5,2)));
	imagefilledrectangle($im,0,0,55,12,$col_line);
	imagefilledrectangle($im,1,1,53,10,imagecolorallocate($im,hexdec(substr($hit_counter_segmentcolor,1,2)),hexdec(substr($hit_counter_segmentcolor,3,2)),hexdec(substr($hit_counter_segmentcolor,5,2))));
	for ($i=0;$i<=strlen($hits);$i++) {
		if ($hit_counter_random) {$y_pos=mt_rand(1,3);} else {$y_pos=2;}
		$x_pos=3+$i*11;
		imagestring($im,1,$x_pos,$y_pos,substr($hits,$i,1),$col_text);
		imageline($im,$x_pos+7,0,$x_pos+7,12,$col_line);
	}
	return $im;
}

// Create rating image
function rating_image($score) {
	global $table_color,$rating_blockcolor,$rating_blockcolor_score;
	$im=imagecreate(38,6);
	$col_block=imagecolorallocate($im,hexdec(substr($rating_blockcolor,1,2)),hexdec(substr($rating_blockcolor,3,2)),hexdec(substr($rating_blockcolor,5,2)));
	$col_block_score=imagecolorallocate($im,hexdec(substr($rating_blockcolor_score,1,2)),hexdec(substr($rating_blockcolor_score,3,2)),hexdec(substr($rating_blockcolor_score,5,2)));
	imagefill($im,0,0,imagecolorallocate($im,hexdec(substr($table_color,1,2)),hexdec(substr($table_color,3,2)),hexdec(substr($table_color,5,2))));
	$x_pos=0;
	for ($i=0;$i<5;$i++) {
		if ($i<$score)
			imagefilledrectangle($im,$x_pos,0,$x_pos+5,6,$col_block_score);
		else
			imagefilledrectangle($im,$x_pos,0,$x_pos+5,6,$col_block);
		$x_pos+=8;
	}
	return $im;
}

// Footer & Bottom menu
function album_menu() {
	global $total_amount_albums,$show_statistics,$language_albums,$language_photos,$total_amount_images,$language_homepage,$home_page,$max_files,$language_search_cancel;
	global $show_dir_up,$language_up,$album_show,$order,$dir_names,$admin_link,$restrict_access,$language_logout,$visitor_password,$logged_in,$visitor_search;
	echo "<div id=\"bottommenu\"><ul>";
	if ($admin_link=='') {
		if ($total_amount_albums!=0 && $show_statistics)
			echo "<div id=\"bottomstats\">$language_albums: $total_amount_albums | $language_photos: $total_amount_images</div>";
		if ($home_page!='' && $order==0) {echo "<li><a href=\"$home_page\" target=\"_top\">$language_homepage</a></li>";}
		if ($show_dir_up) {echo "<li><a href=\"../index.php\">$language_up</a></li>\n";}
		if (!$album_show && $order==0) {
			for ($count=0;$count<count($dir_names);$count++) {
				$dir_name=$dir_names[$count];
				if (strpos($dir_names[$count],'/')!=false) {$dir_name=substr($dir_names[$count],3);}
				if (ereg("([0-9]{3})",substr($dir_name,0,3))) {
					if (substr($dir_name,3,1)==' ' || substr($dir_name,3,1)=='_')
						$dir_name=trim(substr($dir_name,3));
				}
				$dir_name=str_replace('_',' ',$dir_name);
				echo "<li><a href=\"../" . rawurlencode(substr($dir_names[$count],3)) . "/index.php?$admin_link\">$dir_name</a></li>\n";
			}
		}
	}
	if ($restrict_access) {
		if ($admin_link!='')
			echo "<li><a href=\"index.php?logout=2\">$language_logout</a></li>\n";
		else
			echo "<li><a href=\"index.php?logout=1\">$language_logout</a></li>\n";
	} else if ($visitor_password && $logged_in) {
		echo "<li><a href=\"index.php?logout=1\">$language_logout</a></li>\n";
	}
	echo "</ul></div>\n";
}

// Determine dimensions for resized image
function getdimensions($size) {
	global $image_resize,$image_resizeto,$image_inflate;
	$width=80;
	$height=75;
	if ($image_resize && $size[0]) {
		if ($image_resizeto==0 && isset($_REQUEST['screenwidth']))
			$newsize=floor($_REQUEST['screenwidth']/1.6);
		else if ($image_resizeto!=0)
			$newsize=$image_resizeto;
		else
			$newsize=max($size[0],$size[1]);
		if (!$image_inflate) {
			if ($newsize>$size[0] && $newsize>$size[1])
				$newsize=max($size[0],$size[1]);
		}
		if ($size[0]>$size[1]) {
			$width=$newsize;
			$height=ceil($size[1]/($size[0]/$width));
		} else {
			$width=ceil($size[0]/($size[1]/$newsize));
			$height=$newsize;
		}
	} else if ($size[0]) {
		$width=$size[0];
		$height=$size[1];
	}
	return array($width,$height);
}

// Read total amount of votes or score from file
function gettotalvotes($image,$votes) {
	$totalvotes=0;
	$totalscore=0;
	$stats_filename=substr($image,0,strrpos($image,'.')) . '.rate';
	if (is_dir('ratings')) {$stats_filename='ratings/'.$stats_filename;}
	if (is_readable($stats_filename)) {
		if ($fp=@fopen($stats_filename,'r')) {
			$stats=explode('@',fread($fp,filesize($stats_filename)));
			$totalvotes=$stats[0];
			if (count($stats)>2) {$totalscore=floor($stats[0]*$stats[1]);}
			fclose($fp);
		}
	}
	if ($votes)
		return $totalvotes;
	else
		return $totalscore;
}

// Read total amount of hits file
function gettotalhits($image) {
	$totalhits=0;
	$stats_filename=substr($image,0,strrpos($image,'.')).'.stat';
	if (strpos($stats_filename,'/')!=false) {
		if (is_dir(substr($image,0,strrpos($image,'/')) . '/hitcounters'))
			$stats_filename=str_replace('/','/hitcounters/',$stats_filename);
	} else {
		if (is_dir('hitcounters'))
			$stats_filename='hitcounters/'.$stats_filename;
	}
	if (is_readable($stats_filename)) {
		if ($fp=@fopen($stats_filename,'r')) {
			$stats=explode('@',fread($fp,filesize($stats_filename)));
			$totalhits=$stats[0]+0;
			fclose($fp);
		}
	}
	return $totalhits;
}

// Count total comments for text file
function gettotalcomments($filename) {
	$comments=0;
	$showimage_txt=substr($filename,0,strrpos($filename,'.')).'.txt';
	if (is_dir('textfiles')) {$showimage_txt='textfiles/'.$showimage_txt;}
	if (file_exists($showimage_txt)) {
		$fp=@fopen($showimage_txt,"r");
		$comments=preg_match_all('/(\[ )([0-9]{2})(\/)/',fread($fp,filesize($showimage_txt)),$comments_infile);
		fclose($fp);
	}
	return $comments;
}

// Read all GIF,JPG,PNG files in directory
function get_images($location,$sort,$index) {
	global $restrict_access,$sort_thumbs,$sort_rating,$sort_hits,$sort_comments,$sort_hightolow,$visitor_sort,$visitor_search;
	if ($visitor_sort) {
		if (isset($_REQUEST['sort'])) {
			if ($_REQUEST['sort']!='name') {
				$sort_hits=false;
				$sort_comments=false;
				$sort_rating=false;
				$sort_thumbs=false;
				if ($_REQUEST['sort']=='hitcounter') {$sort_hits=true;}
				if ($_REQUEST['sort']=='comments') {$sort_comments=true;}
				if ($_REQUEST['sort']=='rating') {$sort_rating=true;}
				if ($_REQUEST['sort']=='date') {$sort_thumbs=true;}
			}
		}
	}
	$file_names=array();
	if ($dir=@opendir($location)) {
		while ($file=@readdir($dir)) {
			if (($file!='.') && ($file!='..') && !is_dir($file)) {
				$extension=strtolower(substr($file,strrpos($file,'.')+1,strlen($file)));
				if ($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif') {
					if ($sort_hits && $sort) {
						$hits=gettotalhits($file);
						$totalhits=str_repeat('0',max(10-strlen($hits),0)).$hits.'!';
					} else {
						$totalhits='';
					}
					if ($sort_comments && $sort) {
						$comments=gettotalcomments($file);
						$totalcomments=str_repeat('0',max(10-strlen($comments),0)).$comments.'*';
					} else {
						$totalcomments='';
					}
					if ($sort_rating && $sort) {
						$score=gettotalvotes($file,false);
						$rating=str_repeat('0',max(10-strlen($score),0)).$score.'#';
					} else {
						$rating='';
					}
					if ($sort_thumbs && $sort)
						$date=getexif($file,'YmdHi','date').'@';
					else
						$date='';
					if (!strpos($file,'_thumb')) {
						if ($index)
							array_push($file_names,$totalhits.$totalcomments.$rating.$date.$file);
						else if (substr($file,0,strrpos($file,'.'))!='index')
							array_push($file_names,$totalhits.$totalcomments.$rating.$date.$file);
					}
				}
			}
		}
		@closedir($dir);
	}
	sort($file_names);
	if ($sort_thumbs || $sort_rating || $sort_hits || $sort_comments) {
		if ($sort) {
			if ($sort_hightolow)
				rsort($file_names);
			foreach ($file_names as $key => $filename) {
				if ($sort_hits)
					$file_names[$key]=substr($filename,strpos($filename,'!')+1);
				if ($sort_comments)
					$file_names[$key]=substr($filename,strpos($filename,'*')+1);
				if ($sort_rating)
					$file_names[$key]=substr($filename,strpos($filename,'#')+1);
				if ($sort_thumbs)
					$file_names[$key]=substr($filename,strpos($filename,'@')+1);
			}
		}
	}
	return($file_names);
}

// Retrieve multimedia file from directory
function get_multimedia($image_filename,$return_array) {
	global $sound_formats,$movie_formats;
	$file_names=array();
	$multimedia_filename=strtolower(substr($image_filename,0,strrpos($image_filename,'.')));
	$found='';
	$supportedformats=explode(',',$movie_formats.','.$sound_formats);
	if ($dir=@opendir(getcwd())) {
		while ($file=@readdir($dir)) {
			if (($file!='.') && ($file!='..') && !is_dir($file)) {
				$extension=strtolower(substr($file,strrpos($file,'.')+1,strlen($file)));
				if (in_array($extension,$supportedformats)) {
					$filename=strtolower(substr($file,0,strrpos($file,'.')));
					if ($filename==$multimedia_filename) {$found=$file;}
					array_push($file_names,$file);
				}
			} 
		}
		@closedir($dir);
	}
	if ($return_array)
		return($file_names);
	else
		return($found);
}

// Create multimedia images
function create_mm($recreate_cache) {
	global $mm_dir;
	if (file_exists($mm_dir)) {
		$all_mm_images=get_images($mm_dir,false,false);
		if (!$recreate_cache) {$all_images=get_images(getcwd(),false,false);} else {$all_images=array();}
		$all_mm_files=get_multimedia('',true);
		$mm_images_with_extension=$all_mm_images;
		$mm_with_extension=$all_mm_files;
		foreach ($all_mm_images as $key => $filename) {$all_mm_images[$key]=strtolower(substr($filename,0,strrpos($filename,'.')));}
		foreach ($all_mm_files as $key => $filename) {$all_mm_files[$key]=strtolower(substr($filename,0,strrpos($filename,'.')));}
		foreach ($all_images as $key => $filename) {$all_images[$key]=strtolower(substr($filename,0,strrpos($filename,'.')));}
		if (is_dir('thumbnails')) {$mm_thumbdir='thumbnails/';} else {$mm_thumbdir='';}
		foreach ($all_mm_files as $key => $mm_file) {	
			if (!in_array($mm_file,$all_images)) {
				if (in_array(strtolower(substr($mm_with_extension[$key],strrpos($mm_with_extension[$key],'.')+1,strlen($mm_with_extension[$key]))),$all_mm_images)) {
					$mm_index=array_search(strtolower(substr($mm_with_extension[$key],strrpos($mm_with_extension[$key],'.')+1,strlen($mm_with_extension[$key]))),$all_mm_images);
					@copy($mm_dir . $mm_images_with_extension[$mm_index],$mm_file.'.'.strtolower(substr($mm_images_with_extension[$mm_index],strrpos($mm_images_with_extension[$mm_index],'.')+1,strlen($mm_images_with_extension[$mm_index]))));
					@copy($mm_dir . $mm_images_with_extension[$mm_index],$mm_thumbdir.$mm_file.'_thumb.'.strtolower(substr($mm_images_with_extension[$mm_index],strrpos($mm_images_with_extension[$mm_index],'.')+1,strlen($mm_images_with_extension[$mm_index]))));
				}
			} else {
				if (in_array(strtolower(substr($mm_with_extension[$key],strrpos($mm_with_extension[$key],'.')+1,strlen($mm_with_extension[$key]))),$all_mm_images)) {
					$mm_index=array_search(strtolower(substr($mm_with_extension[$key],strrpos($mm_with_extension[$key],'.')+1,strlen($mm_with_extension[$key]))),$all_mm_images);
					if (@filemtime($mm_dir . $mm_images_with_extension[$mm_index])>@filemtime($mm_file.'.'.strtolower(substr($mm_images_with_extension[$mm_index],strrpos($mm_images_with_extension[$mm_index],'.')+1,strlen($mm_images_with_extension[$mm_index]))))) {
						@copy($mm_dir . $mm_images_with_extension[$mm_index],$mm_file.'.'.strtolower(substr($mm_images_with_extension[$mm_index],strrpos($mm_images_with_extension[$mm_index],'.')+1,strlen($mm_images_with_extension[$mm_index]))));
						@copy($mm_dir . $mm_images_with_extension[$mm_index],$mm_thumbdir.$mm_file.'_thumb.'.strtolower(substr($mm_images_with_extension[$mm_index],strrpos($mm_images_with_extension[$mm_index],'.')+1,strlen($mm_images_with_extension[$mm_index]))));
					}
				}
			}
		}
	}
}

// Delete files and directory - recursive function to delete subdirectories
function removedir($dirname,$recursive,$delete_dir,$file_type) {
	clearstatcache();
	if (file_exists($dirname)) {
		if (is_dir($dirname)) {
			if ($dir=@opendir($dirname)) {
				while ($file=@readdir($dir)) {
					if (($file!='.') && ($file!='..')) {
						$path=$dirname.'/'.$file;
						if ($recursive && is_dir($path)) {
							removedir($path,true,true,'*');
						} else {
							if ($file_type=='*')
								@unlink($path);
							else if (strtolower(substr($path,strrpos($path,'.')+1,strlen($path)))==$file_type)
								@unlink($path);
						}
					}
				}
				@closedir($dir);
				if ($delete_dir)
					@rmdir($dirname);
			}
		}
	}
}

// Unzip uploaded archive
function unzipimages($file,$fileformats,$nickname) {
	global $visitor_upload_adminreview;
	if (file_exists($file)) {
		if (!file_exists('tmp')) {@mkdir('tmp');}	
		@copy($file,'tmp/' . $file);
		@unlink($file);
		chdir('tmp');
		@shell_exec('unzip ' . $file);
		chdir('../');
		$supportedformats=explode(',',$fileformats);
		if ($visitor_upload_adminreview) {
			if (!is_dir('backup')) {@mkdir('backup');}
			if (file_exists('backup')) {$reviewdir='backup/';} else {$reviewdir='';}
		}
		if ($dir=@opendir('tmp')) {
			while ($fileinzip=@readdir($dir)) {
				if (($fileinzip!='.') && ($fileinzip!='..')) {
					$extension=strtolower(substr($fileinzip,strrpos($fileinzip,'.')+1,strlen($fileinzip)));
					$imagefilename=substr($fileinzip,0,strrpos($fileinzip,'.')).$nickname.'.'.$extension;
					if (in_array($extension,$supportedformats) && $extension!='zip') {@copy('tmp/'.$fileinzip,'./'.$reviewdir.$imagefilename);}
				} 
			}
			@closedir($dir);
		}
		removedir(str_replace(chr(92),chr(47),getcwd()).'/tmp',true,true,'*');
	}
}

// Retrieve EXIF info from jpg
function getexif($image,$format,$info) {
	$date='';
	$comment='';
	if (file_exists($image) && extension_loaded('exif')) {
		$extension=strtolower(substr($image,strrpos($image,'.')+1,strlen($image)));
		if ($extension=='jpg' || $extension=='jpeg') {
			$exif=@exif_read_data($image,0,true);
			foreach($exif as $key=>$section) {
				foreach($section as $name=>$val) {
					if ($name=='DateTimeOriginal') {$date=$val;}
					if ($name=='DateTime') {$date=$val;}
					if ($name=='UserComment') {$comment.=$val . ' ';}
				}
			}
		}
		if ($date!='' && $date!="0000:00:00 00:00:00") {
			$date=preg_replace("/(\d{4}):(\d{2}):(\d{2}) (\d{2}):(\d{2}):(\d{2})/",'\1-\2-\3 \4:\5:\6',$date);
			$date=strtotime($date);
			if ($date===-1) {$date=@filemtime($image);}
		} else {
			$date=@filemtime($image);	
		}
	} else if (file_exists($image)) {
		$date=@filemtime($image);
	}
	if ($format!='unix') {$date=date($format,$date);}
	if ($info=='date')
		return($date);
	else
		return(trim($comment));
}

// Retrieve IPTC caption from jpg
function iptc($image) {
	$caption='';
	$size=@getimagesize($image,$info);
	if (isset($info["APP13"])) {
		$iptc=@iptcparse($info["APP13"]);
		if (is_array($iptc)) {
			foreach($iptc as $key=>$section) {
				foreach($section as $name=>$val) {
					if ($key=='2#120') {$caption.=$val . ' ';}
				}
			}
		}
	}
	return $caption;
}

// Resize image
function resize($image,$resizeto) {
	global $gd2,$imagemagick,$imagemagick_path;
	$size=@GetImageSize($image);
	if (max($size[0],$size[1])!=$resizeto) {
		$date=getexif($image,'unix','date');
		if ($size[0]>$size[1]) {
			$width=$resizeto;
			$height=ceil($size[1]/($size[0]/$width));
		} else {
			$width=ceil($size[0]/($size[1]/$resizeto));
			$height=$resizeto;
		}
		if ($imagemagick) {
			@exec($imagemagick_path . 'convert -resize '.$width.'x'.$height.' '.getcwd().'/'.$image.' '.getcwd().'/'.$image);
		} else {
			if ($size[2]==1) {$im=@imagecreatefromgif($image);}
			if ($size[2]==2) {$im=@imagecreatefromjpeg($image);}
			if ($size[2]==3) {$im=@imagecreatefrompng($image);}
			if ($size[2]==1 || $size[2]==2 || $size[2]==3) {
				if ($gd2) {
					if ($size[0]>$size[1])
						$thumb=imagecreatetruecolor($width,ceil($size[1]/($size[0]/$width)));
					else
						$thumb=imagecreatetruecolor(ceil($size[0]/($size[1]/$height)),$height);
				} else {
					if ($size[0]>$size[1])
						$thumb=imagecreate($width,ceil($size[1]/($size[0]/$width)));
					else
						$thumb=imagecreate(ceil($size[0]/($size[1]/$height)),$height);
				}
				if ($gd2)
					imagecopyresampled($thumb,$im,0,0,0,0,imagesx($thumb),imagesy($thumb),imagesx($im),imagesy($im));
				else
					imagecopyresized($thumb,$im,0,0,0,0,imagesx($thumb),imagesy($thumb),imagesx($im),imagesy($im));
				if ($size[2]==1)
					@imagegif($thumb,$image) or die('Resizing failed. Please enable write access to the files in this directory (chmod 0777 directory/ -R)');
				if ($size[2]==2)
					@imagejpeg($thumb,$image,90) or die('Resizing failed. Please enable write access to the files in this directory (chmod 0777 directory/ -R)');
				if ($size[2]==3)
					@imagepng($thumb,$image) or die('Resizing failed. Please enable write access to the files in this directory (chmod 0777 directory/ -R)');
				@imagedestroy($im);
				@imagedestroy($thumb);
			}
		}
		// Attempt to set file-date to the orignal EXIF-date, so EXIF-date info does not get lost
		@touch($image,$date);
	}
}

// Rotate image 90 degrees - slow in PHP but good quality and works in 4.1.0
function rotate($image,$direction) {
	global $gd2,$title,$imagemagick,$imagemagick_path;
	$date=getexif($image,'unix','date');
	$size=@GetImageSize($image);
	if ($imagemagick) {
		if ($size[0]>=$size[1]) {$pointer='>';} else {$pointer='<';}
		if ($direction=='r')
			@exec($imagemagick_path . "convert -rotate '90$pointer' ".getcwd().'/'.$image.' '.getcwd().'/'.$image);
		else
			@exec($imagemagick_path . "convert -rotate '-90$pointer' ".getcwd().'/'.$image.' '.getcwd().'/'.$image);
	} else {
		if ($size[2]==1) {
			if (imagetypes() & IMG_GIF) {
				$im=@imagecreatefromgif($image);
			} else {
				$title.=' - rotate failed no GIF support';
				return;
			}
		}
		if ($size[2]==2) {
			if (imagetypes() & IMG_JPG) {
				$im=@imagecreatefromjpeg($image);
			} else {
				$title.=' - rotate failed no JPG support';
				return;
			}
		}
		if ($size[2]==3) {
			if (imagetypes() & IMG_PNG) {
				$im=@imagecreatefrompng($image);
			} else {
				$title.=' - rotate failed no PNG support';
				return;
			}
		}
		if ($size[2]==1 || $size[2]==2 || $size[2]==3) {
			if ($gd2)
				$newimage=imagecreatetruecolor($size[1],$size[0]);
			else
				$newimage=imagecreate($size[1],$size[0]);
			if ($direction=='r') {
				for ($px=0;$px<$size[0];$px++) {
					for ($py=0;$py<$size[1];$py++)
						imagecopy($newimage,$im,$size[1]-$py-1,$px,$px,$py,1,1);
				}
			} else {
				for ($px=0;$px<$size[0];$px++) {
					for ($py=0;$py<$size[1];$py++)
						imagecopy($newimage,$im,$py,$size[0]-$px-1,$px,$py,1,1);
				}
			}
			if ($size[2]==1)
				@imagegif($newimage,$image) or die('Rotate failed. Please enable write access to the files in this directory (chmod 0777 directory/ -R)');
			if ($size[2]==2)
				@imagejpeg($newimage,$image,90) or die('Rotate failed. Please enable write access to the files in this directory (chmod 0777 directory/ -R)');
			if ($size[2]==3)
				@imagepng($newimage,$image) or die('Rotate failed. Please enable write access to the files in this directory (chmod 0777 directory/ -R)');
			@imagedestroy($im);
			@imagedestroy($newimage);
		}
	}
	// Attempt to set file-date to the EXIF-file date, so EXIF date info does not get lost
	@touch($image,$date);
}

// Login form
function require_login() {
	global $admin_access,$enable_admin_keyboardshortcut,$home_page,$language_homepage,$language_login,$language_user,$language_passw,$admin_access,$admin_link,$visitor_password;
	echo "<html><head><title>$language_login</title>\n";
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\"><meta http-equiv=\"content-style-type\" content=\"text/css\"><meta http-equiv=\"content-script-type\" content=\"text/javascript\">\n";
	echo "</head><body marginwidth=\"0\" marginheight=\"0\" topmargin=\"0\" leftmargin=\"0\">\n";
	html_css();
	if ($visitor_password && isset($_REQUEST['requirelogin'])) {$action='&requirelogin=1';} else {$action='';}
	echo "<div id=\"content\"><form name=\"browser\" method=\"POST\" action=\"index.php?$admin_link$action\" enctype=\"multipart/form-data\">\n";
	if ($admin_link!='') {$language_login='Administrator '.$language_login;}
	echo "<h1>$language_login</h1><div class=\"line\"> &nbsp;</div><div id=\"leftmargin\"><center>";
	if ($admin_access && $admin_link=='' && $enable_admin_keyboardshortcut && !isset($_REQUEST['showimage'])) {
		echo "<script language=\"JavaScript\">\n";
		echo "<!-- EasyPhpAlbum @ www.mywebmymail.com //-->\n";
		echo "function reload(e) {\n";
		echo "	if(e) \n";
		echo "		if(e.type=='keydown' && e.which==9 && document.browser.new_user.value=='') {document.location.href=\"index.php?admin=1\";}\n";
		echo "	if(window.event) \n";
		echo "		if(event.type=='keydown' && event.keyCode==9 && document.browser.new_user.value=='') {document.location.href=\"index.php?admin=1\";}\n";
		echo "}\n";
		echo "document.onkeydown=reload;\n";
		echo "</script>\n";
	}
	echo "<table class=\"tablesmaller\">\n";
	echo "<tr><td colspan=\"2\" nowrap=\"nowrap\"> &nbsp;</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">$language_user:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"new_user\" class=\"input\" focus></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">$language_passw:</td><td nowrap=\"nowrap\"><input type=\"password\" name=\"new_password\" class=\"input\"></td></tr>\n";
	echo "<tr><td colspan=\"2\" nowrap=\"nowrap\"> &nbsp;</td></tr>\n";
	echo "<tr><td colspan=\"2\" nowrap=\"nowrap\"><input type=\"submit\" name=\"Submit\" class=\"button\" value=\"" . strtolower($language_login) . "\"></td></tr>\n";
	echo "<tr><td colspan=\"2\" nowrap=\"nowrap\"> &nbsp;</td></tr>\n";
	echo "</table></center></div><div class=\"line\"> &nbsp;</div>";
	if ($home_page!='') {echo "<div id=\"bottommenu\"><ul><li><a href=\"$home_page\">$language_homepage</a></li></ul></div>";}
	if ($admin_link!='') {echo "<div id=\"bottommenu\"><ul><li><a href=\"index.php?logout=2\">Exit</a></li></ul></div>";}
	echo "</div></form></body></html>\n";
	exit;
}

// Administrator section & form validation - really compact ;)
function configuration() {
	global $page_color,$text_color,$text_hover_color,$title_color,$border_color,$table_color,$item_border_color,$line_color,$email_color,$menu_line_width,$menu_bar_width,$menu_bordertop_color,$menu_borderbottom_color,$menu_borderleft_color,$menu_borderright_color,$menu_bordertop_hover_color,$menu_borderbottom_hover_color,$menu_borderleft_hover_color,$menu_borderright_hover_color,$menu_text_color,$menu_texthover_color,$menu_background_color,$menu_background_hover_color,$hit_counter_linecolor,$hit_counter_segmentcolor,$hit_counter_textcolor,$rating_blockcolor,$rating_blockcolor_score;
	global $images_per_page,$columns_per_page,$popup,$image_border,$slideshow,$slideshow_delay,$page_header,$menu_line_width,$menu_bar_width,$language_homepage,$center_title,$center_album,$background_image,$background_position,$background_repeat,$visitor_comments,$meta_copyright_and_author,$meta_keywords,$meta_description,$use_main_config,$popup_browse,$use_album_config,$album_config,$thumbnail_rotation_degrees,$thumbnail_rotation,$mm_watermark,$mm_watermark_position,$mm_watermark_transparancy,$transparent_page,$sort_comments,$show_prev_next_below,$show_name_top,$show_thumb_name_top,$link_bigimage;
	global $title,$show_email_link,$show_poweredby_easyphpalbum,$thumb_size,$border_width,$show_bordershadow,$binder_spacing,$clip_corner,$clip_corner_round,$sort_thumbs,$sort_rating,$watermark,$watermark_position,$watermark_transparancy,$content_width,$content_leftmargin,$page_leftmargin,$indeximage_no_thumb,$show_statistics,$thumbnail_countcomments,$comment_email,$show_iptc_caption,$apply_thumbnail_borderpng,$play_multimedia,$download_multimedia,$enable_keyboard_arrows,$mm_thumbnail,$clip_randomly,$transparent_menu,$show_previous_next,$visitor_upload_size,$square_thumbnails,$visitor_search_columns;
	global $show_binder,$show_number,$show_name,$show_details,$show_date,$show_exif_comment,$show_download,$image_txtfile,$hit_counter,$hit_counter_random,$rating,$show_date_format,$config_version,$copyright_position,$menu_background_image,$show_bottommenu,$rating_text,$hit_counter_text,$info_bold,$info_italic,$name_bold,$name_italic,$shop,$shop_email,$shop_choice1,$shop_choice2,$shop_columns,$thumbnail_spacing,$embed_player,$link_player,$visitor_upload,$sound_formats,$mm_photo,$clip_bottomleft,$clip_bottomright,$valign_thumbnail,$show_prev_next_size,$show_prev_next_position,$visitor_search;
	global $image_resize,$image_resizeto,$image_inflate,$image_greyscale,$image_sepia_depth,$image_noise_depth,$copyright,$restrict_access,$restrict_access_configured,$users,$users_configured,$gd2,$home_page,$create_thumbnail_cache,$sort_hits,$sort_hightolow,$imagemagick,$thumbnail_txtfile,$show_dir_up,$thumbnail_opacity,$opacity_level,$imagemagick_path,$ban_ip,$footer,$header,$comment_logip,$thumbnail_borderpng,$movie_formats,$mm_dir,$visitor_files,$upload_email,$visitor_sort,$clip_topleft,$clip_topright,$visitor_comments_dateformat,$visitor_upload_max_files,$show_topmenu,$visitor_password;
	global $animated_thumbnails,$imagefader,$visitor_upload_adminreview;
	if ($_REQUEST['configuration']==2) {
		if ($fp=@fopen('configuration.php','wb')) {
			fwrite($fp,"<?php\n");
			fwrite($fp,"// Configuration file for EasyPhpAlbum version 1.3.7\n");
			if (isset($_REQUEST['config_version'])) {fwrite($fp,'$config_version='. intval($_REQUEST['config_version']+1) .";\n");} else {fwrite($fp,'$config_version=1'.";\n");}
			if (isset($_REQUEST['page_color'])) {fwrite($fp,'$page_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['page_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['page_color'])))."';\n");}
			if (isset($_REQUEST['text_color'])) {fwrite($fp,'$text_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['text_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['text_color'])))."';\n");}
			if (isset($_REQUEST['text_hover_color'])) {fwrite($fp,'$text_hover_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['text_hover_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['text_hover_color'])))."';\n");}
			if (isset($_REQUEST['title_color'])) {fwrite($fp,'$title_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['title_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['title_color'])))."';\n");}
			if (isset($_REQUEST['border_color'])) {fwrite($fp,'$border_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['border_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['border_color'])))."';\n");}
			if (isset($_REQUEST['table_color'])) {fwrite($fp,'$table_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['table_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['table_color'])))."';\n");}
			if (isset($_REQUEST['item_border_color'])) {fwrite($fp,'$item_border_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['item_border_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['item_border_color'])))."';\n");}
			if (isset($_REQUEST['line_color'])) {fwrite($fp,'$line_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['line_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['line_color'])))."';\n");}
			if (isset($_REQUEST['email_color'])) {fwrite($fp,'$email_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['email_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['email_color'])))."';\n");}
			if (isset($_REQUEST['menu_bordertop_color'])) {fwrite($fp,'$menu_bordertop_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_bordertop_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_bordertop_color'])))."';\n");}
			if (isset($_REQUEST['menu_borderbottom_color'])) {fwrite($fp,'$menu_borderbottom_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderbottom_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderbottom_color'])))."';\n");}
			if (isset($_REQUEST['menu_borderleft_color'])) {fwrite($fp,'$menu_borderleft_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderleft_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderleft_color'])))."';\n");}
			if (isset($_REQUEST['menu_borderright_color'])) {fwrite($fp,'$menu_borderright_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderright_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderright_color'])))."';\n");}
			if (isset($_REQUEST['menu_bordertop_hover_color'])) {fwrite($fp,'$menu_bordertop_hover_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_bordertop_hover_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_bordertop_hover_color'])))."';\n");}
			if (isset($_REQUEST['menu_borderbottom_hover_color'])) {fwrite($fp,'$menu_borderbottom_hover_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderbottom_hover_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderbottom_hover_color'])))."';\n");}
			if (isset($_REQUEST['menu_borderleft_hover_color'])) {fwrite($fp,'$menu_borderleft_hover_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderleft_hover_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderleft_hover_color'])))."';\n");}
			if (isset($_REQUEST['menu_borderright_hover_color'])) {fwrite($fp,'$menu_borderright_hover_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderright_hover_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_borderright_hover_color'])))."';\n");}
			if (isset($_REQUEST['menu_text_color'])) {fwrite($fp,'$menu_text_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_text_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_text_color'])))."';\n");}
			if (isset($_REQUEST['menu_texthover_color'])) {fwrite($fp,'$menu_texthover_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_texthover_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_texthover_color'])))."';\n");}
			if (isset($_REQUEST['menu_background_color'])) {fwrite($fp,'$menu_background_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_background_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_background_color'])))."';\n");}
			if (isset($_REQUEST['menu_background_hover_color'])) {fwrite($fp,'$menu_background_hover_color=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_background_hover_color']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['menu_background_hover_color'])))."';\n");}
			if (isset($_REQUEST['hit_counter_linecolor'])) {fwrite($fp,'$hit_counter_linecolor=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['hit_counter_linecolor']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['hit_counter_linecolor'])))."';\n");}
			if (isset($_REQUEST['hit_counter_segmentcolor'])) {fwrite($fp,'$hit_counter_segmentcolor=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['hit_counter_segmentcolor']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['hit_counter_segmentcolor'])))."';\n");}
			if (isset($_REQUEST['hit_counter_textcolor'])) {fwrite($fp,'$hit_counter_textcolor=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['hit_counter_textcolor']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['hit_counter_textcolor'])))."';\n");}
			if (isset($_REQUEST['rating_blockcolor'])) {fwrite($fp,'$rating_blockcolor=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['rating_blockcolor']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['rating_blockcolor'])))."';\n");}
			if (isset($_REQUEST['rating_blockcolor_score'])) {fwrite($fp,'$rating_blockcolor_score=\'#'.ereg_replace("[^a-fA-F0-9]","",$_REQUEST['rating_blockcolor_score']).str_repeat('0',6-strlen(ereg_replace("[^a-fA-F0-9]","",$_REQUEST['rating_blockcolor_score'])))."';\n");}
			if (isset($_REQUEST['images_per_page'])) {fwrite($fp,'$images_per_page='. intval($_REQUEST['images_per_page']) .";\n");}
			if (isset($_REQUEST['columns_per_page'])) {fwrite($fp,'$columns_per_page='. intval($_REQUEST['columns_per_page']) .";\n");}
			if (isset($_REQUEST['visitor_search_columns'])) {fwrite($fp,'$visitor_search_columns='. intval($_REQUEST['visitor_search_columns']) .";\n");}
			if (isset($_REQUEST['slideshow_delay'])) {fwrite($fp,'$slideshow_delay='. intval($_REQUEST['slideshow_delay']) .";\n");}
			if (isset($_REQUEST['menu_line_width'])) {fwrite($fp,'$menu_line_width='. intval($_REQUEST['menu_line_width']) .";\n");}
			if (isset($_REQUEST['menu_bar_width'])) {fwrite($fp,'$menu_bar_width='. intval($_REQUEST['menu_bar_width']) .";\n");}
			if (isset($_REQUEST['visitor_upload_max_files'])) {fwrite($fp,'$visitor_upload_max_files='. min(max(1,intval($_REQUEST['visitor_upload_max_files'])),6) .";\n");}
			if (isset($_REQUEST['popup'])) {fwrite($fp,'$popup=true'. ";\n");} else {fwrite($fp,'$popup=false'. ";\n");}
			if (isset($_REQUEST['link_bigimage'])) {fwrite($fp,'$link_bigimage=true'. ";\n");} else {fwrite($fp,'$link_bigimage=false'. ";\n");}
			if (isset($_REQUEST['enable_keyboard_arrows'])) {fwrite($fp,'$enable_keyboard_arrows=true'. ";\n");} else {fwrite($fp,'$enable_keyboard_arrows=false'. ";\n");}
			if (isset($_REQUEST['popup_browse'])) {fwrite($fp,'$popup_browse=true'. ";\n");} else {fwrite($fp,'$popup_browse=false'. ";\n");}
			if (isset($_REQUEST['image_border'])) {fwrite($fp,'$image_border=true'. ";\n");} else {fwrite($fp,'$image_border=false'. ";\n");}
			if (isset($_REQUEST['slideshow'])) {fwrite($fp,'$slideshow=true'. ";\n");} else {fwrite($fp,'$slideshow=false'. ";\n");}
			if (isset($_REQUEST['center_title'])) {fwrite($fp,'$center_title=true'. ";\n");} else {fwrite($fp,'$center_title=false'. ";\n");}
			if (isset($_REQUEST['center_album'])) {fwrite($fp,'$center_album=true'. ";\n");} else {fwrite($fp,'$center_album=false'. ";\n");}
			if (isset($_REQUEST['transparent_page'])) {fwrite($fp,'$transparent_page=true'. ";\n");} else {fwrite($fp,'$transparent_page=false'. ";\n");}
			if (isset($_REQUEST['transparent_menu'])) {fwrite($fp,'$transparent_menu=true'. ";\n");} else {fwrite($fp,'$transparent_menu=false'. ";\n");}
			if (isset($_REQUEST['page_header'])) {fwrite($fp,'$page_header=true'. ";\n");} else {fwrite($fp,'$page_header=false'. ";\n");}
			if (isset($_REQUEST['show_email_link'])) {fwrite($fp,'$show_email_link=true'. ";\n");} else {fwrite($fp,'$show_email_link=false'. ";\n");}
			if (isset($_REQUEST['show_name_top'])) {fwrite($fp,'$show_name_top=true'. ";\n");} else {fwrite($fp,'$show_name_top=false'. ";\n");}
			if (isset($_REQUEST['show_bottommenu'])) {fwrite($fp,'$show_bottommenu=true'. ";\n");} else {fwrite($fp,'$show_bottommenu=false'. ";\n");}
			if (isset($_REQUEST['show_topmenu'])) {fwrite($fp,'$show_topmenu=true'. ";\n");} else {fwrite($fp,'$show_topmenu=false'. ";\n");}
			if (isset($_REQUEST['show_statistics'])) {fwrite($fp,'$show_statistics=true'. ";\n");} else {fwrite($fp,'$show_statistics=false'. ";\n");}
			if (isset($_REQUEST['animated_thumbnails'])) {fwrite($fp,'$animated_thumbnails=true'. ";\n");} else {fwrite($fp,'$animated_thumbnails=false'. ";\n");}
			if (isset($_REQUEST['show_thumb_name_top'])) {fwrite($fp,'$show_thumb_name_top=true'. ";\n");} else {fwrite($fp,'$show_thumb_name_top=false'. ";\n");}
			if (isset($_REQUEST['use_main_config'])) {fwrite($fp,'$use_main_config=true'. ";\n");} else {fwrite($fp,'$use_main_config=false'. ";\n");}
			if (isset($_REQUEST['use_album_config'])) {fwrite($fp,'$use_album_config=\''. $_REQUEST['use_album_config'] ."';\n");}
			if (isset($_REQUEST['show_poweredby_easyphpalbum'])) {fwrite($fp,'$show_poweredby_easyphpalbum=true'. ";\n");} else {fwrite($fp,'$show_poweredby_easyphpalbum=false'. ";\n");}
			if (isset($_REQUEST['show_previous_next'])) {fwrite($fp,'$show_previous_next=true'. ";\n");} else {fwrite($fp,'$show_previous_next=false'. ";\n");}
			if (isset($_REQUEST['show_prev_next_below'])) {fwrite($fp,'$show_prev_next_below=true'. ";\n");} else {fwrite($fp,'$show_prev_next_below=false'. ";\n");}
			
if (isset($_REQUEST['title'])) {fwrite($fp,'$title=\''.htmlentities($_REQUEST['title'])."';\n");}
			
			if (isset($_REQUEST['meta_description'])) {fwrite($fp,'$meta_description=\''.ereg_replace("[^[:space:]a-zA-Z0-9*_.-]","",$_REQUEST['meta_description'])."';\n");}
			if (isset($_REQUEST['meta_keywords'])) {fwrite($fp,'$meta_keywords=\''.ereg_replace("[^[:space:]a-zA-Z0-9*_.,-]","",$_REQUEST['meta_keywords'])."';\n");}
			if (isset($_REQUEST['meta_copyright_and_author'])) {fwrite($fp,'$meta_copyright_and_author=\''.ereg_replace("[^[:space:]a-zA-Z0-9*_.-]","",$_REQUEST['meta_copyright_and_author'])."';\n");}
			if (isset($_REQUEST['thumb_size'])) {fwrite($fp,'$thumb_size='. intval($_REQUEST['thumb_size']) .";\n");}
			if (isset($_REQUEST['border_width'])) {fwrite($fp,'$border_width='. intval($_REQUEST['border_width']) .";\n");}
			if (isset($_REQUEST['show_prev_next_size'])) {fwrite($fp,'$show_prev_next_size='. intval($_REQUEST['show_prev_next_size']) .";\n");}
			if (isset($_REQUEST['show_bordershadow'])) {fwrite($fp,'$show_bordershadow=true'. ";\n");} else {fwrite($fp,'$show_bordershadow=false'. ";\n");}
			if (isset($_REQUEST['binder_spacing'])) {fwrite($fp,'$binder_spacing='. intval($_REQUEST['binder_spacing']) .";\n");}
			if (isset($_REQUEST['visitor_upload_size'])) {fwrite($fp,'$visitor_upload_size='. intval($_REQUEST['visitor_upload_size']) .";\n");}
			if (isset($_REQUEST['clip_corner'])) {fwrite($fp,'$clip_corner='. intval($_REQUEST['clip_corner']) .";\n");}
			if (isset($_REQUEST['clip_corner_round'])) {fwrite($fp,'$clip_corner_round=true'. ";\n");} else {fwrite($fp,'$clip_corner_round=false'. ";\n");}
			if (isset($_REQUEST['clip_topleft'])) {fwrite($fp,'$clip_topleft=true'. ";\n");} else {fwrite($fp,'$clip_topleft=false'. ";\n");}
			if (isset($_REQUEST['clip_topright'])) {fwrite($fp,'$clip_topright=true'. ";\n");} else {fwrite($fp,'$clip_topright=false'. ";\n");}
			if (isset($_REQUEST['clip_bottomleft'])) {fwrite($fp,'$clip_bottomleft=true'. ";\n");} else {fwrite($fp,'$clip_bottomleft=false'. ";\n");}
			if (isset($_REQUEST['clip_bottomright'])) {fwrite($fp,'$clip_bottomright=true'. ";\n");} else {fwrite($fp,'$clip_bottomright=false'. ";\n");}
			if (isset($_REQUEST['clip_randomly'])) {fwrite($fp,'$clip_randomly=true'. ";\n");} else {fwrite($fp,'$clip_randomly=false'. ";\n");}
			if (isset($_REQUEST['square_thumbnails'])) {fwrite($fp,'$square_thumbnails=true'. ";\n");} else {fwrite($fp,'$square_thumbnails=false'. ";\n");}
			if (isset($_REQUEST['imagefader'])) {fwrite($fp,'$imagefader=true'. ";\n");} else {fwrite($fp,'$imagefader=false'. ";\n");}
			if (isset($_REQUEST['show_binder'])) {fwrite($fp,'$show_binder=true'. ";\n");} else {fwrite($fp,'$show_binder=false'. ";\n");}
			if (isset($_REQUEST['show_number'])) {fwrite($fp,'$show_number=true'. ";\n");} else {fwrite($fp,'$show_number=false'. ";\n");}
			if (isset($_REQUEST['sort_thumbs'])) {fwrite($fp,'$sort_thumbs=true'. ";\n");} else {fwrite($fp,'$sort_thumbs=false'. ";\n");}
			if (isset($_REQUEST['sort_comments'])) {fwrite($fp,'$sort_comments=true'. ";\n");} else {fwrite($fp,'$sort_comments=false'. ";\n");}
			if (isset($_REQUEST['visitor_sort'])) {fwrite($fp,'$visitor_sort=true'. ";\n");} else {fwrite($fp,'$visitor_sort=false'. ";\n");}
			if (isset($_REQUEST['visitor_search'])) {fwrite($fp,'$visitor_search=true'. ";\n");} else {fwrite($fp,'$visitor_search=false'. ";\n");}
			if (isset($_REQUEST['visitor_upload_adminreview'])) {fwrite($fp,'$visitor_upload_adminreview=true'. ";\n");} else {fwrite($fp,'$visitor_upload_adminreview=false'. ";\n");}
			if (isset($_REQUEST['sort_rating'])) {fwrite($fp,'$sort_rating=true'. ";\n");} else {fwrite($fp,'$sort_rating=false'. ";\n");}
			if (isset($_REQUEST['thumbnail_countcomments'])) {fwrite($fp,'$thumbnail_countcomments=true'. ";\n");} else {fwrite($fp,'$thumbnail_countcomments=false'. ";\n");}
			if (isset($_REQUEST['sort_hits'])) {fwrite($fp,'$sort_hits=true,'. ";\n");} else {fwrite($fp,'$sort_hits=false'. ";\n");}
			if (isset($_REQUEST['sort_hightolow'])) {fwrite($fp,'$sort_hightolow=true'. ";\n");} else {fwrite($fp,'$sort_hightolow=false'. ";\n");}
			if (isset($_REQUEST['show_name'])) {fwrite($fp,'$show_name=true'. ";\n");} else {fwrite($fp,'$show_name=false'. ";\n");}
			if (isset($_REQUEST['name_bold'])) {fwrite($fp,'$name_bold=true'. ";\n");} else {fwrite($fp,'$name_bold=false'. ";\n");}
			if (isset($_REQUEST['name_italic'])) {fwrite($fp,'$name_italic=true'. ";\n");} else {fwrite($fp,'$name_italic=false'. ";\n");}
			if (isset($_REQUEST['info_bold'])) {fwrite($fp,'$info_bold=true'. ";\n");} else {fwrite($fp,'$info_bold=false'. ";\n");}
			if (isset($_REQUEST['info_italic'])) {fwrite($fp,'$info_italic=true'. ";\n");} else {fwrite($fp,'$info_italic=false'. ";\n");}
			if (isset($_REQUEST['show_dir_up'])) {fwrite($fp,'$show_dir_up=true'. ";\n");} else {fwrite($fp,'$show_dir_up=false'. ";\n");}
			if (isset($_REQUEST['show_details'])) {fwrite($fp,'$show_details=true'. ";\n");} else {fwrite($fp,'$show_details=false'. ";\n");}
			if (isset($_REQUEST['show_date_format'])) {
				if ($_REQUEST['show_date_format']=='d-m-Y H:i') {fwrite($fp,'$show_date_format=\''.$_REQUEST['show_date_format']."';\n");}
				if ($_REQUEST['show_date_format']=='m-d-Y H:i') {fwrite($fp,'$show_date_format=\''.$_REQUEST['show_date_format']."';\n");}
				if ($_REQUEST['show_date_format']=='d-m-Y') {fwrite($fp,'$show_date_format=\''.$_REQUEST['show_date_format']."';\n");}
				if ($_REQUEST['show_date_format']=='m-d-Y') {fwrite($fp,'$show_date_format=\''.$_REQUEST['show_date_format']."';\n");}
				if ($_REQUEST['show_date_format']=='no') {fwrite($fp,'$show_date=false'. ";\n");} else {fwrite($fp,'$show_date=true'. ";\n");}
			}
			if (isset($_REQUEST['visitor_comments_dateformat'])) {
				if ($_REQUEST['visitor_comments_dateformat']=='d/m/Y H:i') {fwrite($fp,'$visitor_comments_dateformat=\''.$_REQUEST['visitor_comments_dateformat']."';\n");}
				if ($_REQUEST['visitor_comments_dateformat']=='m/d/Y H:i') {fwrite($fp,'$visitor_comments_dateformat=\''.$_REQUEST['visitor_comments_dateformat']."';\n");}
				if ($_REQUEST['visitor_comments_dateformat']=='d/m/Y') {fwrite($fp,'$visitor_comments_dateformat=\''.$_REQUEST['visitor_comments_dateformat']."';\n");}
				if ($_REQUEST['visitor_comments_dateformat']=='m/d/Y') {fwrite($fp,'$visitor_comments_dateformat=\''.$_REQUEST['visitor_comments_dateformat']."';\n");}
			}
			if (isset($_REQUEST['valign_thumbnail'])) {
				if ($_REQUEST['valign_thumbnail']=='top') {fwrite($fp,'$valign_thumbnail=\''.$_REQUEST['valign_thumbnail']."';\n");}
				if ($_REQUEST['valign_thumbnail']=='middle') {fwrite($fp,'$valign_thumbnail=\''.$_REQUEST['valign_thumbnail']."';\n");}
				if ($_REQUEST['valign_thumbnail']=='bottom') {fwrite($fp,'$valign_thumbnail=\''.$_REQUEST['valign_thumbnail']."';\n");}
			}
			if (isset($_REQUEST['show_prev_next_position'])) {
				if ($_REQUEST['show_prev_next_position']=='top') {fwrite($fp,'$show_prev_next_position=\''.$_REQUEST['show_prev_next_position']."';\n");}
				if ($_REQUEST['show_prev_next_position']=='middle') {fwrite($fp,'$show_prev_next_position=\''.$_REQUEST['show_prev_next_position']."';\n");}
				if ($_REQUEST['show_prev_next_position']=='bottom') {fwrite($fp,'$show_prev_next_position=\''.$_REQUEST['show_prev_next_position']."';\n");}
			}
			if (isset($_REQUEST['background_repeat'])) {
				if ($_REQUEST['background_repeat']=='no-repeat') {fwrite($fp,'$background_repeat=\''.$_REQUEST['background_repeat']."';\n");}
				if ($_REQUEST['background_repeat']=='repeat-x') {fwrite($fp,'$background_repeat=\''.$_REQUEST['background_repeat']."';\n");}
				if ($_REQUEST['background_repeat']=='repeat-y') {fwrite($fp,'$background_repeat=\''.$_REQUEST['background_repeat']."';\n");}
				if ($_REQUEST['background_repeat']=='repeat') {fwrite($fp,'$background_repeat=\''.$_REQUEST['background_repeat']."';\n");}
			}
			if (isset($_REQUEST['background_image'])) {fwrite($fp,'$background_image=\''.$_REQUEST['background_image']."';\n");}
			if (isset($_REQUEST['header'])) {fwrite($fp,'$header=\''.$_REQUEST['header']."';\n");}
			if (isset($_REQUEST['footer'])) {fwrite($fp,'$footer=\''.$_REQUEST['footer']."';\n");}
			if (isset($_REQUEST['watermark'])) {fwrite($fp,'$watermark=\''.$_REQUEST['watermark']."';\n");}
			if (isset($_REQUEST['mm_watermark'])) {fwrite($fp,'$mm_watermark=\''.$_REQUEST['mm_watermark']."';\n");}
			if (isset($_REQUEST['mm_dir'])) {fwrite($fp,'$mm_dir=\''.$_REQUEST['mm_dir']."';\n");}
			if (isset($_REQUEST['thumbnail_borderpng'])) {fwrite($fp,'$thumbnail_borderpng=\''.$_REQUEST['thumbnail_borderpng']."';\n");}
			if (isset($_REQUEST['menu_background_image'])) {fwrite($fp,'$menu_background_image=\''.$_REQUEST['menu_background_image']."';\n");}
			if (isset($_REQUEST['copyright_position'])) {fwrite($fp,'$copyright_position=\''.$_REQUEST['copyright_position']."';\n");}
			if (isset($_REQUEST['background_position'])) {fwrite($fp,'$background_position=\''.$_REQUEST['background_position']."';\n");}
			if (isset($_REQUEST['watermark_position'])) {fwrite($fp,'$watermark_position=\''.$_REQUEST['watermark_position']."';\n");}
			if (isset($_REQUEST['mm_watermark_position'])) {fwrite($fp,'$mm_watermark_position=\''.$_REQUEST['mm_watermark_position']."';\n");}
			if (isset($_REQUEST['content_width'])) {fwrite($fp,'$content_width=\''.$_REQUEST['content_width']."';\n");}
			if (isset($_REQUEST['content_leftmargin'])) {fwrite($fp,'$content_leftmargin=\''.$_REQUEST['content_leftmargin']."';\n");}
			if (isset($_REQUEST['page_leftmargin'])) {fwrite($fp,'$page_leftmargin=\''.$_REQUEST['page_leftmargin']."';\n");}
			if (isset($_REQUEST['watermark_transparancy'])) {fwrite($fp,'$watermark_transparancy=\''.intval($_REQUEST['watermark_transparancy'])."';\n");}
			if (isset($_REQUEST['mm_watermark_transparancy'])) {fwrite($fp,'$mm_watermark_transparancy=\''.intval($_REQUEST['mm_watermark_transparancy'])."';\n");}
			if (isset($_REQUEST['show_exif_comment'])) {fwrite($fp,'$show_exif_comment=true'. ";\n");} else {fwrite($fp,'$show_exif_comment=false'. ";\n");}
			if (isset($_REQUEST['show_iptc_caption'])) {fwrite($fp,'$show_iptc_caption=true'. ";\n");} else {fwrite($fp,'$show_iptc_caption=false'. ";\n");}
			if (isset($_REQUEST['comment_logip'])) {fwrite($fp,'$comment_logip=true'. ";\n");} else {fwrite($fp,'$comment_logip=false'. ";\n");}
			if (isset($_REQUEST['show_download'])) {fwrite($fp,'$show_download=true'. ";\n");} else {fwrite($fp,'$show_download=false'. ";\n");}
			if (isset($_REQUEST['image_txtfile'])) {fwrite($fp,'$image_txtfile=true'. ";\n");} else {fwrite($fp,'$image_txtfile=false'. ";\n");}
			if (isset($_REQUEST['thumbnail_txtfile'])) {fwrite($fp,'$thumbnail_txtfile=true'. ";\n");} else {fwrite($fp,'$thumbnail_txtfile=false'. ";\n");}
			if (isset($_REQUEST['indeximage_no_thumb'])) {fwrite($fp,'$indeximage_no_thumb=true'. ";\n");} else {fwrite($fp,'$indeximage_no_thumb=false'. ";\n");}
			if (isset($_REQUEST['apply_thumbnail_borderpng'])) {fwrite($fp,'$apply_thumbnail_borderpng=true'. ";\n");} else {fwrite($fp,'$apply_thumbnail_borderpng=false'. ";\n");}
			if (isset($_REQUEST['hit_counter'])) {fwrite($fp,'$hit_counter=true'. ";\n");} else {fwrite($fp,'$hit_counter=false'. ";\n");}
			if (isset($_REQUEST['hit_counter_random'])) {fwrite($fp,'$hit_counter_random=true'. ";\n");} else {fwrite($fp,'$hit_counter_random=false'. ";\n");}
			if (isset($_REQUEST['hit_counter_text'])) {fwrite($fp,'$hit_counter_text=true'. ";\n");} else {fwrite($fp,'$hit_counter_text=false'. ";\n");}
			if (isset($_REQUEST['rating'])) {fwrite($fp,'$rating=true'. ";\n");} else {fwrite($fp,'$rating=false'. ";\n");}
			if (isset($_REQUEST['rating_text'])) {fwrite($fp,'$rating_text=true'. ";\n");} else {fwrite($fp,'$rating_text=false'. ";\n");}
			if (isset($_REQUEST['ban_ip'])) {fwrite($fp,'$ban_ip=\''.$_REQUEST['ban_ip']."';\n");}
			if (isset($_REQUEST['shop'])) {fwrite($fp,'$shop=true'. ";\n");} else {fwrite($fp,'$shop=false'. ";\n");}
			if (isset($_REQUEST['shop_email'])) {fwrite($fp,'$shop_email=\''. $_REQUEST['shop_email'] ."';\n");}
			if (isset($_REQUEST['movie_formats'])) {fwrite($fp,'$movie_formats=\''. $_REQUEST['movie_formats'] ."';\n");}
			if (isset($_REQUEST['sound_formats'])) {fwrite($fp,'$sound_formats=\''. $_REQUEST['sound_formats'] ."';\n");}
			if (isset($_REQUEST['shop_choice1'])) {fwrite($fp,'$shop_choice1=\''. $_REQUEST['shop_choice1'] ."';\n");}
			if (isset($_REQUEST['shop_choice2'])) {fwrite($fp,'$shop_choice2=\''. $_REQUEST['shop_choice2'] ."';\n");}
			if (isset($_REQUEST['shop_columns'])) {fwrite($fp,'$shop_columns='. intval($_REQUEST['shop_columns']) .";\n");}	
			if (isset($_REQUEST['visitor_comments'])) {fwrite($fp,'$visitor_comments=true'. ";\n");} else {fwrite($fp,'$visitor_comments=false'. ";\n");}
			if (isset($_REQUEST['visitor_upload'])) {fwrite($fp,'$visitor_upload=true'. ";\n");} else {fwrite($fp,'$visitor_upload=false'. ";\n");}
			if (isset($_REQUEST['visitor_files'])) {fwrite($fp,'$visitor_files=\''.$_REQUEST['visitor_files']."';\n");}
			if (isset($_REQUEST['thumbnail_rotation'])) {fwrite($fp,'$thumbnail_rotation=true'. ";\n");} else {fwrite($fp,'$thumbnail_rotation=false'. ";\n");}
			if (isset($_REQUEST['thumbnail_rotation_degrees'])) {fwrite($fp,'$thumbnail_rotation_degrees=\''. $_REQUEST['thumbnail_rotation_degrees'] ."';\n");}
			if (isset($_REQUEST['comment_email'])) {fwrite($fp,'$comment_email=\''. $_REQUEST['comment_email'] ."';\n");}
			if (isset($_REQUEST['upload_email'])) {fwrite($fp,'$upload_email=\''. $_REQUEST['upload_email'] ."';\n");}
			if (isset($_REQUEST['image_resize'])) {fwrite($fp,'$image_resize=true'. ";\n");} else {fwrite($fp,'$image_resize=false'. ";\n");}
			if (isset($_REQUEST['image_inflate'])) {fwrite($fp,'$image_inflate=true'. ";\n");} else {fwrite($fp,'$image_inflate=false'. ";\n");}
			if (isset($_REQUEST['play_multimedia'])) {fwrite($fp,'$play_multimedia=true'. ";\n");} else {fwrite($fp,'$play_multimedia=false'. ";\n");}
			if (isset($_REQUEST['mm_thumbnail'])) {fwrite($fp,'$mm_thumbnail=true'. ";\n");} else {fwrite($fp,'$mm_thumbnail=false'. ";\n");}
			if (isset($_REQUEST['mm_photo'])) {fwrite($fp,'$mm_photo=true'. ";\n");} else {fwrite($fp,'$mm_photo=false'. ";\n");}
			if (isset($_REQUEST['download_multimedia'])) {fwrite($fp,'$download_multimedia=true'. ";\n");} else {fwrite($fp,'$download_multimedia=false'. ";\n");}
			if (isset($_REQUEST['embed_player'])) {fwrite($fp,'$embed_player=true'. ";\n");} else {fwrite($fp,'$embed_player=false'. ";\n");}
			if (isset($_REQUEST['link_player'])) {fwrite($fp,'$link_player=true'. ";\n");} else {fwrite($fp,'$link_player=false'. ";\n");}
			if (isset($_REQUEST['image_resizeto'])) {fwrite($fp,'$image_resizeto='. intval($_REQUEST['image_resizeto']) .";\n");}
			if (isset($_REQUEST['image_greyscale'])) {fwrite($fp,'$image_greyscale=true'. ";\n");} else {fwrite($fp,'$image_greyscale=false'. ";\n");}
			if (isset($_REQUEST['image_noise_depth'])) {fwrite($fp,'$image_noise_depth='. intval($_REQUEST['image_noise_depth']) .";\n");}
			if (isset($_REQUEST['image_sepia_depth'])) {fwrite($fp,'$image_sepia_depth='. intval($_REQUEST['image_sepia_depth']) .";\n");}
			if (isset($_REQUEST['thumbnail_opacity'])) {fwrite($fp,'$thumbnail_opacity=true'. ";\n");} else {fwrite($fp,'$thumbnail_opacity=false'. ";\n");}
			if (isset($_REQUEST['opacity_level'])) {fwrite($fp,'$opacity_level='. intval($_REQUEST['opacity_level']) .";\n");}
			if (isset($_REQUEST['thumbnail_spacing'])) {fwrite($fp,'$thumbnail_spacing='. intval($_REQUEST['thumbnail_spacing']) .";\n");}
			if (isset($_REQUEST['copyright'])) {fwrite($fp,'$copyright=\''.ereg_replace("[^[:space:]a-zA-Z0-9*_.-]","",$_REQUEST['copyright'])."';\n");}
			if (isset($_REQUEST['restrict_access_configured'])) {fwrite($fp,'$restrict_access=true'. ";\n");} else {fwrite($fp,'$restrict_access=false'. ";\n");}
			if (isset($_REQUEST['visitor_password'])) {fwrite($fp,'$visitor_password=true'. ";\n");} else {fwrite($fp,'$visitor_password=false'. ";\n");}
			if (isset($_REQUEST['users_configured'])) {fwrite($fp,'$users=\''.ereg_replace("[^[:space:]a-zA-Z0-9*_.,-]","",$_REQUEST['users_configured'])."';\n");}
			if (isset($_REQUEST['imagemagick_path'])) {fwrite($fp,'$imagemagick_path=\''.$_REQUEST['imagemagick_path']."';\n");}
			if (isset($_REQUEST['home_page'])) {fwrite($fp,'$home_page=\''.$_REQUEST['home_page']."';\n");}
			if (isset($_REQUEST['language_homepage'])) {fwrite($fp,'$language_homepage=\''.htmlentities($_REQUEST['language_homepage'])."';\n");}
			if (isset($_REQUEST['gd2'])) {fwrite($fp,'$gd2=true'. ";\n");} else {fwrite($fp,'$gd2=false'. ";\n");}
			if (isset($_REQUEST['create_thumbnail_cache'])) {fwrite($fp,'$create_thumbnail_cache=true'. ";\n");} else {fwrite($fp,'$create_thumbnail_cache=false'. ";\n");}
			if (isset($_REQUEST['imagemagick'])) {fwrite($fp,'$imagemagick=true'. ";\n");} else {fwrite($fp,'$imagemagick=false'. ";\n");}
			fwrite($fp,'?>');
			fclose($fp);
			if (is_readable('configuration.php')) {
				include('configuration.php');
				$users_configured=$users;
			}
			$ok=" - saved (version: $config_version)";
			// Upload album art
			if (isset($_FILES['upload_albumart'])) {
				$imagefilename=str_replace('/','',$_FILES['upload_albumart']['name']);
				$imagefilename=str_replace('..','',$imagefilename);
				$extension=strtolower(substr($imagefilename,strrpos($imagefilename,'.')+1,strlen($imagefilename)));
				if ($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif') {
					if (!file_exists('./gfx')) {@mkdir('./gfx');}
					if (@move_uploaded_file($_FILES['upload_albumart']['tmp_name'],str_replace(chr(92),chr(47),getcwd()).'/gfx/'.$imagefilename)) {
						if (filesize('./gfx/'.$imagefilename)==0) {@unlink('./gfx/'.$imagefilename);}
					}
					if ($_FILES['upload_albumart']['error']==UPLOAD_ERR_INI_SIZE) {$ok.=" - (upload failed: filesize too big)";}
					if ($_FILES['upload_albumart']['error']==UPLOAD_ERR_PARTIAL) {$ok.=" - (upload failed: upload interrupted)";}
				}
			}
		} else {
			$ok=' - failed (please enable write access)';
		}
	} else {
		$ok='';
	}
	if (!isset($config_version)) {$config_version=0;}
	if (!$album_config) {
		if (file_exists('configuration.php')) {include('configuration.php');}
	}
	if (isset($_REQUEST['mm_refresh'])) {create_mm(true);}
	if (isset($_REQUEST['reset_hitcounters'])) {
		if (file_exists('hitcounters')) {removedir('hitcounters',false,false,'stat');} else {removedir('./',false,false,'stat');}
	}
	if (isset($_REQUEST['reset_ratings'])) {
		if (file_exists('ratings')) {removedir('ratings',false,false,'rate');} else {removedir('./',false,false,'rate');}
	}
	if (isset($_REQUEST['reset_textfiles'])) {
		if (file_exists('textfiles')) {removedir('textfiles',false,false,'txt');} else {removedir('./',false,false,'txt');}
	}
	echo "<html><head><title>Configuration</title>\n";
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\"><meta http-equiv=\"content-style-type\" content=\"text/css\"><meta http-equiv=\"content-script-type\" content=\"text/javascript\">\n";
	echo "</head><body marginwidth=\"0\" marginheight=\"0\" topmargin=\"0\" leftmargin=\"0\">\n";
	html_css();
	echo "<div id=\"content\"><form name=\"browser\" method=\"POST\" action=\"index.php?admin=1&configuration=2\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"config_version\" value=\"$config_version\">\n";
	echo "<h1>Configuration $ok</h1><div class=\"line\"> &nbsp;</div><div id=\"leftmargin\"><center>";
	echo "<table class=\"tablesmaller\">\n";
	if ($popup) {$popup_checked='checked=\"checked\"';} else {$popup_checked='';}
	if ($popup_browse) {$popup_browse_checked='checked=\"checked\"';} else {$popup_browse_checked='';}
	if ($enable_keyboard_arrows) {$enable_keyboard_arrows_checked='checked=\"checked\"';} else {$enable_keyboard_arrows_checked='';}
	if ($image_border) {$image_border_checked='checked=\"checked\"';} else {$image_border_checked='';}
	if ($slideshow) {$slideshow_checked='checked=\"checked\"';} else {$slideshow_checked='';}
	if ($center_title) {$center_title_checked='checked=\"checked\"';} else {$center_title_checked='';}
	if ($center_album) {$center_album_checked='checked=\"checked\"';} else {$center_album_checked='';}
	if ($page_header) {$page_header_checked='checked=\"checked\"';} else {$page_header_checked='';}
	if ($transparent_page) {$transparent_page_checked='checked=\"checked\"';} else {$transparent_page_checked='';}
	if ($transparent_menu) {$transparent_menu_checked='checked=\"checked\"';} else {$transparent_menu_checked='';}
	if ($show_email_link) {$show_email_link_checked='checked=\"checked\"';} else {$show_email_link_checked='';}
	if ($show_dir_up) {$show_dir_up_checked='checked=\"checked\"';} else {$show_dir_up_checked='';}
	if ($show_thumb_name_top) {$show_thumb_name_top_checked='checked=\"checked\"';} else {$show_thumb_name_top_checked='';}
	if ($show_name_top) {$show_name_top_checked='checked=\"checked\"';} else {$show_name_top_checked='';}
	if ($show_statistics) {$show_statistics_checked='checked=\"checked\"';} else {$show_statistics_checked='';}
	if ($use_main_config) {$use_main_config_checked='checked=\"checked\"';} else {$use_main_config_checked='';}
	if ($show_poweredby_easyphpalbum) {$show_poweredby_easyphpalbum_checked='checked=\"checked\"';} else {$show_poweredby_easyphpalbum_checked='';}
	if ($show_bordershadow) {$show_bordershadow_checked='checked=\"checked\"';} else {$show_bordershadow_checked='';}
	if ($clip_corner_round) {$clip_corner_round_checked='checked=\"checked\"';} else {$clip_corner_round_checked='';}
	if ($clip_topleft) {$clip_topleft_checked='checked=\"checked\"';} else {$clip_topleft_checked='';}
	if ($clip_bottomleft) {$clip_bottomleft_checked='checked=\"checked\"';} else {$clip_bottomleft_checked='';}
	if ($clip_topright) {$clip_topright_checked='checked=\"checked\"';} else {$clip_topright_checked='';}
	if ($clip_bottomright) {$clip_bottomright_checked='checked=\"checked\"';} else {$clip_bottomright_checked='';}
	if ($clip_randomly) {$clip_randomly_checked='checked=\"checked\"';} else {$clip_randomly_checked='';}
	if ($square_thumbnails) {$square_thumbnails_checked='checked=\"checked\"';} else {$square_thumbnails_checked='';}
	if ($imagefader) {$imagefader_checked='checked=\"checked\"';} else {$imagefader_checked='';}
	if ($show_binder) {$show_binder_checked='checked=\"checked\"';} else {$show_binder_checked='';}
	if ($show_number) {$show_number_checked='checked=\"checked\"';} else {$show_number_checked='';}
	if ($sort_thumbs) {$sort_thumbs_checked='checked=\"checked\"';} else {$sort_thumbs_checked='';}
	if ($link_bigimage) {$link_bigimage_checked='checked=\"checked\"';} else {$link_bigimage_checked='';}
	if ($show_previous_next) {$show_previous_next_checked='checked=\"checked\"';} else {$show_previous_next_checked='';}
	if ($show_prev_next_below) {$show_prev_next_below_checked='checked=\"checked\"';} else {$show_prev_next_below_checked='';}
	if ($sort_comments) {$sort_comments_checked='checked=\"checked\"';} else {$sort_comments_checked='';}
	if ($visitor_sort) {$visitor_sort_checked='checked=\"checked\"';} else {$visitor_sort_checked='';}
	if ($visitor_upload_adminreview) {$visitor_upload_adminreview_checked='checked=\"checked\"';} else {$visitor_upload_adminreview_checked='';}
	if ($animated_thumbnails) {$animated_thumbnails_checked='checked=\"checked\"';} else {$animated_thumbnails_checked='';}
	if ($sort_rating) {$sort_rating_checked='checked=\"checked\"';} else {$sort_rating_checked='';}
	if ($thumbnail_countcomments) {$thumbnail_countcomments_checked='checked=\"checked\"';} else {$thumbnail_countcomments_checked='';}
	if ($visitor_comments) {$visitor_comments_checked='checked=\"checked\"';} else {$visitor_comments_checked='';}
	if ($visitor_search) {$visitor_search_checked='checked=\"checked\"';} else {$visitor_search_checked='';}
	if ($visitor_password) {$visitor_password_checked='checked=\"checked\"';} else {$visitor_password_checked='';}
	if ($thumbnail_rotation) {$thumbnail_rotation_checked='checked=\"checked\"';} else {$thumbnail_rotation_checked='';}
	if ($sort_hits) {$sort_hits_checked='checked=\"checked\"';} else {$sort_hits_checked='';}
	if ($sort_hightolow) {$sort_hightolow_checked='checked=\"checked\"';} else {$sort_hightolow_checked='';}
	if ($show_name) {$show_name_checked='checked=\"checked\"';} else {$show_name_checked='';}
	if ($name_bold) {$name_bold_checked='checked=\"checked\"';} else {$name_bold_checked='';}
	if ($name_italic) {$name_italic_checked='checked=\"checked\"';} else {$name_italic_checked='';}
	if ($info_bold) {$info_bold_checked='checked=\"checked\"';} else {$info_bold_checked='';}
	if ($info_italic) {$info_italic_checked='checked=\"checked\"';} else {$info_italic_checked='';}
	if ($show_details) {$show_details_checked='checked=\"checked\"';} else {$show_details_checked='';}
	if ($show_date) {
		$show_date_no='';
		if ($show_date_format=='d-m-Y H:i') {$show_date_1='selected';} else {$show_date_1='';}
		if ($show_date_format=='m-d-Y H:i') {$show_date_2='selected';} else {$show_date_2='';}
		if ($show_date_format=='d-m-Y') {$show_date_3='selected';} else {$show_date_3='';}
		if ($show_date_format=='m-d-Y') {$show_date_4='selected';} else {$show_date_4='';}
	} else {
		$show_date_no='selected';
		$show_date_1='';
		$show_date_2='';
		$show_date_3='';
		$show_date_4='';
	}
	$show_date_no='';
	if ($visitor_comments_dateformat=='d/m/Y H:i') {$visitor_comments_dateformat_1='selected';} else {$visitor_comments_dateformat_1='';}
	if ($visitor_comments_dateformat=='m/d/Y H:i') {$visitor_comments_dateformat_2='selected';} else {$visitor_comments_dateformat_2='';}
	if ($visitor_comments_dateformat=='d/m/Y') {$visitor_comments_dateformat_3='selected';} else {$visitor_comments_dateformat_3='';}
	if ($visitor_comments_dateformat=='m/d/Y') {$visitor_comments_dateformat_4='selected';} else {$visitor_comments_dateformat_4='';}
	if ($valign_thumbnail=='top') {$valign_thumbnail_1='selected';} else {$valign_thumbnail_1='';}
	if ($valign_thumbnail=='middle') {$valign_thumbnail_2='selected';} else {$valign_thumbnail_2='';}
	if ($valign_thumbnail=='bottom') {$valign_thumbnail_3='selected';} else {$valign_thumbnail_3='';}
	if ($show_prev_next_position=='top') {$show_prev_next_position_1='selected';} else {$show_prev_next_position_1='';}
	if ($show_prev_next_position=='middle') {$show_prev_next_position_2='selected';} else {$show_prev_next_position_2='';}
	if ($show_prev_next_position=='bottom') {$show_prev_next_position_3='selected';} else {$show_prev_next_position_3='';}
	if ($background_repeat) {
		$show_date_no='';
		if ($background_repeat=='no-repeat') {$background_repeat_norepeat='selected';} else {$background_repeat_norepeat='';}
		if ($background_repeat=='repeat-x') {$background_repeat_x='selected';} else {$background_repeat_x='';}
		if ($background_repeat=='repeat-y') {$background_repeat_y='selected';} else {$background_repeat_y='';}
		if ($background_repeat=='repeat') {$background_repeat_repeat='selected';} else {$background_repeat_repeat='';}
	} else {
		$background_repeat_norepeat='selected';
		$background_repeat_x='';
		$background_repeat_y='';
		$background_repeat_repeat='';
	}
	if ($show_exif_comment) {$show_exif_comment_checked='checked=\"checked\"';} else {$show_exif_comment_checked='';}
	if ($show_iptc_caption) {$show_iptc_caption_checked='checked=\"checked\"';} else {$show_iptc_caption_checked='';}
	if ($comment_logip) {$comment_logip_checked='checked=\"checked\"';} else {$comment_logip_checked='';}
	if ($show_download) {$show_download_checked='checked=\"checked\"';} else {$show_download_checked='';}
	if ($show_bottommenu) {$show_bottommenu_checked='checked=\"checked\"';} else {$show_bottommenu_checked='';}
	if ($show_topmenu) {$show_topmenu_checked='checked=\"checked\"';} else {$show_topmenu_checked='';}
	if ($image_txtfile) {$image_txtfile_checked='checked=\"checked\"';} else {$image_txtfile_checked='';}
	if ($thumbnail_txtfile) {$thumbnail_txtfile_checked='checked=\"checked\"';} else {$thumbnail_txtfile_checked='';}
	if ($indeximage_no_thumb) {$indeximage_no_thumb_checked='checked=\"checked\"';} else {$indeximage_no_thumb_checked='';}
	if ($apply_thumbnail_borderpng) {$apply_thumbnail_borderpng_checked='checked=\"checked\"';} else {$apply_thumbnail_borderpng_checked='';}
	if ($hit_counter) {$hit_counter_checked='checked=\"checked\"';} else {$hit_counter_checked='';}
	if ($hit_counter_random) {$hit_counter_random_checked='checked=\"checked\"';} else {$hit_counter_random_checked='';}
	if ($hit_counter_text) {$hit_counter_text_checked='checked=\"checked\"';} else {$hit_counter_text_checked='';}
	if ($rating) {$rating_checked='checked=\"checked\"';} else {$rating_checked='';}
	if ($rating_text) {$rating_text_checked='checked=\"checked\"';} else {$rating_text_checked='';}
	if ($shop) {$shop_checked='checked=\"checked\"';} else {$shop_checked='';}
	if ($visitor_upload) {$visitor_upload_checked='checked=\"checked\"';} else {$visitor_upload_checked='';}
	if ($image_resize) {$image_resize_checked='checked=\"checked\"';} else {$image_resize_checked='';}
	if ($play_multimedia) {$play_multimedia_checked='checked=\"checked\"';} else {$play_multimedia_checked='';}
	if ($download_multimedia) {$download_multimedia_checked='checked=\"checked\"';} else {$download_multimedia_checked='';}
	if ($embed_player) {$embed_player_checked='checked=\"checked\"';} else {$embed_player_checked='';}
	if ($mm_thumbnail) {$mm_thumbnail_checked='checked=\"checked\"';} else {$mm_thumbnail_checked='';}
	if ($mm_photo) {$mm_photo_checked='checked=\"checked\"';} else {$mm_photo_checked='';}
	if ($link_player) {$link_player_checked='checked=\"checked\"';} else {$link_player_checked='';}
	if ($image_inflate) {$image_inflate_checked='checked=\"checked\"';} else {$image_inflate_checked='';}
	if ($image_greyscale) {$image_greyscale_checked='checked=\"checked\"';} else {$image_greyscale_checked='';}
	if ($thumbnail_opacity) {$thumbnail_opacity_checked='checked=\"checked\"';} else {$thumbnail_opacity_checked='';}
	if ($_REQUEST['configuration']!=1)
		if ($restrict_access) {$restrict_access_checked='checked=\"checked\"';} else {$restrict_access_checked='';}
	else
		if ($restrict_access_configured)  {$restrict_access_checked='checked=\"checked\"';} else {$restrict_access_checked='';}
	if ($gd2) {$gd2_checked='checked=\"checked\"';} else {$gd2_checked='';}
	if ($create_thumbnail_cache) {$create_thumbnail_cache_checked='checked=\"checked\"';} else {$create_thumbnail_cache_checked='';}
	if ($imagemagick) {$imagemagick_checked='checked=\"checked\"';} else {$imagemagick_checked='';}
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\"><input type=\"submit\" name=\"configsavet\" value=\"Save\" onclick=\"this.form.configsavet.value='Please wait'; this.form.submit(); this.form.configsavet.disabled='true'; this.form.viewt.disabled='true'; this.form.cancelt.disabled='true';\" class=\"button\"> <input type=\"button\" name=\"cancelt\" value=\"Back\" onclick=\"document.location.href='index.php?admin=1'\" class=\"button\"> <input type=\"button\" name=\"viewt\" value=\"View\" onclick=\"window.open('index.php')\" class=\"button\"></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Use another configuration file (overrides all settings below!):</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Use configuration from main gallery page:</td><td nowrap=\"nowrap\" colspan=\"4\"><input type=\"checkbox\" name=\"use_main_config\" class=\"input\" value=\"true\" $use_main_config_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Use configuration from album:</td><td colspan=\"4\" nowrap=\"nowrap\"><input type=\"text\" name=\"use_album_config\" class=\"input\" value=\"$use_album_config\" size=\"40\"> enter the album (directory) name</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Upload Album Art (borders, watermarks, etc.) to directory: gfx/</b></td></tr>\n";
	$gfx_images='&nbsp;';
	if (is_dir('gfx')) {
		$album_art=get_images('./gfx',false,false);
		if (count($album_art)!=0) {
			$gfx_images="<select name=\"background_repeat\" class=\"input\"><option>Album Art:</option>";
			foreach ($album_art as $art) {$gfx_images.="<option>gfx/$art</option>";}
			$gfx_images.="</select>";
		}
	}
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Upload image (jpg,png or gif):</td><td nowrap=\"nowrap\" colspan=\"2\"><input type=\"file\" name=\"upload_albumart\" class=\"input\"></td><td nowrap=\"nowrap\" colspan=\"2\">$gfx_images</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>EasyPhpAlbum layout:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Album title:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"title\" class=\"input\" value=\"$title\" size=\"40\"> (leave empty to display directory name)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Images per page:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"images_per_page\" class=\"input\" value=\"$images_per_page\" maxlength=\"4\" size=\"4\"></td><td nowrap=\"nowrap\">Images next to each other:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"columns_per_page\" class=\"input\" value=\"$columns_per_page\" maxlength=\"2\" size=\"2\"></td><td nowrap=\"nowrap\">Use popup window:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"popup\" class=\"input\" value=\"true\" $popup_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show title:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"page_header\" class=\"input\" value=\"true\" $page_header_checked></td><td nowrap=\"nowrap\">Show EasyPhpAlbum logo:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_poweredby_easyphpalbum\" class=\"input\" value=\"true\" $show_poweredby_easyphpalbum_checked></td><td nowrap=\"nowrap\">Show email link:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_email_link\" class=\"input\" value=\"true\" $show_email_link_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Slideshow:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"slideshow\" class=\"input\" value=\"true\" $slideshow_checked></td><td nowrap=\"nowrap\">Slideshow delay (sec*1000):</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"slideshow_delay\" class=\"input\" value=\"$slideshow_delay\" maxlength=\"4\" size=\"4\"></td><td nowrap=\"nowrap\">Border around image:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"image_border\" class=\"input\" value=\"true\" $image_border_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show bottom menu:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_bottommenu\" class=\"input\" value=\"true\" $show_bottommenu_checked></td><td nowrap=\"nowrap\">Show 'dir up' link:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_dir_up\" class=\"input\" value=\"true\" $show_dir_up_checked></td><td nowrap=\"nowrap\">Show album statistics:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_statistics\" class=\"input\" value=\"true\" $show_statistics_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Enable popup browsing:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"popup_browse\" class=\"input\" value=\"true\" $popup_browse_checked></td><td nowrap=\"nowrap\">Enable arrowkeys:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"enable_keyboard_arrows\" class=\"input\" value=\"true\" $enable_keyboard_arrows_checked></td><td nowrap=\"nowrap\">Enable visitor sort:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"visitor_sort\" class=\"input\" value=\"true\" $visitor_sort_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show top menu:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_topmenu\" class=\"input\" value=\"true\" $show_topmenu_checked></td><td nowrap=\"nowrap\">Enable visitor search:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"visitor_search\" class=\"input\" value=\"true\" $visitor_search_checked></td><td nowrap=\"nowrap\">Search result group images by:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"visitor_search_columns\" class=\"input\" value=\"$visitor_search_columns\" maxlength=\"2\" size=\"2\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Enable fader:</td><td nowrap=\"nowrap\" colspan=\"5\"><input type=\"checkbox\" name=\"imagefader\" class=\"input\" value=\"true\" $imagefader_checked></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Thumbnail layout:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Thumbnail size px:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"thumb_size\" class=\"input\" value=\"$thumb_size\" maxlength=\"3\" size=\"3\"></td><td nowrap=\"nowrap\">Thumbnail border width px:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"border_width\" class=\"input\" value=\"$border_width\" maxlength=\"3\" size=\"3\"></td><td nowrap=\"nowrap\">Thumbnail shadow:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_bordershadow\" class=\"input\" value=\"true\" $show_bordershadow_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show binder:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_binder\" class=\"input\" value=\"true\" $show_binder_checked></td><td nowrap=\"nowrap\">Binder spacing px:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"binder_spacing\" class=\"input\" value=\"$binder_spacing\" maxlength=\"2\" size=\"2\"></td><td nowrap=\"nowrap\">Show thumbnail number:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_number\" class=\"input\" value=\"true\" $show_number_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show photo textfile:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"thumbnail_txtfile\" class=\"input\" value=\"true\" $thumbnail_txtfile_checked></td><td nowrap=\"nowrap\">Ignore 'index' image:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"indeximage_no_thumb\" class=\"input\" value=\"true\" $indeximage_no_thumb_checked></td><td nowrap=\"nowrap\">Thumbnail spacing px:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"thumbnail_spacing\" class=\"input\" value=\"$thumbnail_spacing\" maxlength=\"3\" size=\"3\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Sort thumbs by (exif) date:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"sort_thumbs\" class=\"input\" value=\"true\" $sort_thumbs_checked></td><td nowrap=\"nowrap\">Sort thumbs by rating score:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"sort_rating\" class=\"input\" value=\"true\" $sort_rating_checked></td><td nowrap=\"nowrap\">Sort thumbs by hits:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"sort_hits\" class=\"input\" value=\"true\" $sort_hits_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Sort by comments:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"sort_comments\" class=\"input\" value=\"true\" $sort_comments_checked></td><td nowrap=\"nowrap\">Sort high/new to low/old:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"sort_hightolow\" class=\"input\" value=\"true\" $sort_hightolow_checked></td><td nowrap=\"nowrap\">Thumbnail alignment</td><td nowrap=\"nowrap\"><select name=\"valign_thumbnail\" class=\"input\"><option value=\"top\" $valign_thumbnail_1>top</option><option value=\"middle\" $valign_thumbnail_2>middle</option><option value=\"bottom\" $valign_thumbnail_3>bottom</option></select></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Clip topleft corner:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"clip_topleft\" class=\"input\" value=\"true\" $clip_topleft_checked></td><td nowrap=\"nowrap\">Clip topright corner:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"clip_topright\" class=\"input\" value=\"true\" $clip_topright_checked></td><td nowrap=\"nowrap\">Clip bottomleft corner:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"clip_bottomleft\" class=\"input\" value=\"true\" $clip_bottomleft_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Clip bottomright corner:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"clip_bottomright\" class=\"input\" value=\"true\" $clip_bottomright_checked></td><td nowrap=\"nowrap\">Clip thumbnail corner %:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"clip_corner\" class=\"input\" value=\"$clip_corner\" maxlength=\"2\" size=\"2\"></td><td nowrap=\"nowrap\">Clip corners rounded:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"clip_corner_round\" class=\"input\" value=\"true\" $clip_corner_round_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Clip corners randomly:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"clip_randomly\" class=\"input\" value=\"true\" $clip_randomly_checked></td><td nowrap=\"nowrap\">Show name above thumb:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_thumb_name_top\" class=\"input\" value=\"true\" $show_thumb_name_top_checked></td><td nowrap=\"nowrap\">Square thumbnails:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"square_thumbnails\" class=\"input\" value=\"true\" $square_thumbnails_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Thumbnail opacity:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"thumbnail_opacity\" class=\"input\" value=\"true\" $thumbnail_opacity_checked></td><td nowrap=\"nowrap\">Opacity level (0-100):</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"opacity_level\" class=\"input\" value=\"$opacity_level\" maxlength=\"3\" size=\"3\"></td><td nowrap=\"nowrap\">Count comments:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"thumbnail_countcomments\" class=\"input\" value=\"true\" $thumbnail_countcomments_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Border image:</td><td colspan=\"2\" nowrap=\"nowrap\"><input type=\"text\" name=\"thumbnail_borderpng\" class=\"input\" value=\"$thumbnail_borderpng\" size=\"40\"></td><td nowrap=\"nowrap\" colspan=\"3\">(path of PNG image, example: gfx/border-leaves.png)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Rotate thumbnail:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"thumbnail_rotation\" class=\"input\" value=\"true\" $thumbnail_rotation_checked></td><td nowrap=\"nowrap\">Degrees:</td><td colspan=\"3\" nowrap=\"nowrap\"><input type=\"text\" name=\"thumbnail_rotation_degrees\" class=\"input\" value=\"$thumbnail_rotation_degrees\" size=\"4\"> (0=random, -45 or 45 degrees)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">GIF's are animated:</td><td nowrap=\"nowrap\" colspan=\"5\"><input type=\"checkbox\" name=\"animated_thumbnails\" class=\"input\" value=\"true\" $animated_thumbnails_checked></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Menu layout:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Line width horizontal px:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_line_width\" class=\"input\" value=\"$menu_line_width\" maxlength=\"1\" size=\"1\"></td><td nowrap=\"nowrap\" colspan=\"2\">Line width vertical px:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_bar_width\" class=\"input\" value=\"$menu_bar_width\" maxlength=\"1\" size=\"1\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Add new menu item with name:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"language_homepage\" class=\"input\" value=\"$language_homepage\" size=\"10\"> and with URL:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"home_page\" class=\"input\" value=\"$home_page\" size=\"40\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Menu background image URL (leave empty to disable):</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"menu_background_image\" class=\"input\" value=\"$menu_background_image\" size=\"40\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Transparent background:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"checkbox\" name=\"transparent_menu\" class=\"input\" value=\"true\" $transparent_menu_checked></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Page layout:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Background image URL (leave empty to disable):</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"background_image\" class=\"input\" value=\"$background_image\" size=\"40\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Background image position:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"background_position\" class=\"input\" value=\"$background_position\" maxlength=\"10\" size=\"11\"> (based on %width and %height of page)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Repeat background:</td><td nowrap=\"nowrap\" colspan=\"3\"><select name=\"background_repeat\" class=\"input\"><option value=\"no-repeat\" $background_repeat_norepeat>No</option><option value=\"repeat-x\" $background_repeat_x>Repeat-x</option><option value=\"repeat-y\" $background_repeat_y>Repeat-y</option><option value=\"repeat\" $background_repeat_repeat>Repeat</option></select></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Center title on page:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"checkbox\" name=\"center_title\" class=\"input\" value=\"true\" $center_title_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Center album on page:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"checkbox\" name=\"center_album\" class=\"input\" value=\"true\" $center_album_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Show previous/next thumbnail:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"checkbox\" name=\"show_previous_next\" class=\"input\" value=\"true\" $show_previous_next_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Show previous/next thumbnail below photo:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"checkbox\" name=\"show_prev_next_below\" class=\"input\" value=\"true\" $show_prev_next_below_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Previous/next thumbnail width in px:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"show_prev_next_size\" class=\"input\" value=\"$show_prev_next_size\" maxlength=\"4\" size=\"6\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Previous/next thumbnail alignment:</td><td nowrap=\"nowrap\" colspan=\"3\"><select name=\"show_prev_next_position\" class=\"input\"><option value=\"top\" $show_prev_next_position_1>top</option><option value=\"middle\" $show_prev_next_position_2>middle</option><option value=\"bottom\" $show_prev_next_position_3>bottom</option></select></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Transparent background:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"checkbox\" name=\"transparent_page\" class=\"input\" value=\"true\" $transparent_page_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Page left margin:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"page_leftmargin\" class=\"input\" value=\"$page_leftmargin\" maxlength=\"6\" size=\"10\"> (% or px, example: 0% or 20px)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Content width:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"content_width\" class=\"input\" value=\"$content_width\" maxlength=\"6\" size=\"10\"> (% or px, example: 85% or 800px)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Content left margin:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"content_leftmargin\" class=\"input\" value=\"$content_leftmargin\" maxlength=\"6\" size=\"10\"> (% or px, example: 5% or 10px)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Header image URL (leave empty to disable):</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"header\" class=\"input\" value=\"$header\" size=\"40\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"3\">Footer image URL (leave empty to disable):</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"footer\" class=\"input\" value=\"$footer\" size=\"40\"></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Photo information:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show name:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_name\" class=\"input\" value=\"true\" $show_name_checked></td><td nowrap=\"nowrap\">Show dimensions & size:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_details\" class=\"input\" value=\"true\" $show_details_checked></td><td nowrap=\"nowrap\">Show EXIF/file date:</td><td nowrap=\"nowrap\"><select name=\"show_date_format\" class=\"input\"><option value=\"no\" $show_date_no>No</option><option value=\"d-m-Y H:i\" $show_date_1>d-m-Y H:i</option><option value=\"m-d-Y H:i\" $show_date_2>m-d-Y H:i</option><option value=\"d-m-Y\" $show_date_3>d-m-Y</option><option value=\"m-d-Y\" $show_date_4>m-d-Y</option></select></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show EXIF comment:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_exif_comment\" class=\"input\" value=\"true\" $show_exif_comment_checked></td><td nowrap=\"nowrap\">Show download link:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_download\" class=\"input\" value=\"true\" $show_download_checked></td><td nowrap=\"nowrap\">Show photo textfile:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"image_txtfile\" class=\"input\" value=\"true\" $image_txtfile_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Enable hitcounter:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"hit_counter\" class=\"input\" value=\"true\" $hit_counter_checked></td><td nowrap=\"nowrap\">Hitcounter random display:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"hit_counter_random\" class=\"input\" value=\"true\" $hit_counter_random_checked></td><td nowrap=\"nowrap\">Enable rating system:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"rating\" class=\"input\" value=\"true\" $rating_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Text based hitcounter:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"hit_counter_text\" class=\"input\" value=\"true\" $hit_counter_text_checked></td><td nowrap=\"nowrap\">Text based rating:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"rating_text\" class=\"input\" value=\"true\" $rating_text_checked></td><td nowrap=\"nowrap\">Info in italic:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"info_italic\" class=\"input\" value=\"true\" $info_italic_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Filename in bold:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"name_bold\" class=\"input\" value=\"true\" $name_bold_checked></td><td nowrap=\"nowrap\">Filename in italic:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"name_italic\" class=\"input\" value=\"true\" $name_italic_checked></td><td nowrap=\"nowrap\">Info in bold:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"info_bold\" class=\"input\" value=\"true\" $info_bold_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Allow visitor comments:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"visitor_comments\" class=\"input\" value=\"true\" $visitor_comments_checked></td><td nowrap=\"nowrap\">Email comment to:</td><td colspan=\"3\" nowrap=\"nowrap\"><input type=\"text\" name=\"comment_email\" class=\"input\" value=\"$comment_email\" size=\"30\"> (leave empty to disable)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Save IP with comment:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"comment_logip\" class=\"input\" value=\"true\" $comment_logip_checked></td><td nowrap=\"nowrap\">Comment time format:</td><td nowrap=\"nowrap\" colspan=\"3\"><select name=\"visitor_comments_dateformat\" class=\"input\"><option value=\"d/m/Y H:i\" $visitor_comments_dateformat_1>d/m/Y H:i</option><option value=\"m/d/Y H:i\" $visitor_comments_dateformat_2>m/d/Y H:i</option><option value=\"d/m/Y\" $visitor_comments_dateformat_3>d/m/Y</option><option value=\"m/d/Y\" $visitor_comments_dateformat_4>m/d/Y</option></select></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Show IPTC caption:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_iptc_caption\" class=\"input\" value=\"true\" $show_iptc_caption_checked></td><td nowrap=\"nowrap\">Show name above photo:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"show_name_top\" class=\"input\" value=\"true\" $show_name_top_checked></td><td nowrap=\"nowrap\">Add link to fullsize image:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"link_bigimage\" class=\"input\" value=\"true\" $link_bigimage_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Reset all hitcounters <b>!</b>:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"reset_hitcounters\" class=\"input\" value=\"true\"></td><td nowrap=\"nowrap\">Reset all ratings <b>!</b>:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"reset_ratings\" class=\"input\" value=\"true\"></td><td nowrap=\"nowrap\">Delete all comments/textfiles <b>!</b>:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"reset_textfiles\" class=\"input\" value=\"true\"></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Photo manipulation (on-the-fly, the original photos are not modified):</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Resize photo:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"image_resize\" class=\"input\" value=\"true\" $image_resize_checked></td><td nowrap=\"nowrap\">Resize to (0=autoresize) px:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"image_resizeto\" class=\"input\" value=\"$image_resizeto\" maxlength=\"4\" size=\"4\"></td><td nowrap=\"nowrap\">Allow enlarge image:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"image_inflate\" class=\"input\" value=\"true\" $image_inflate_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Convert to greyscale:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"image_greyscale\" class=\"input\" value=\"true\" $image_greyscale_checked></td><td nowrap=\"nowrap\">Greyscale sephia (0=disable):</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"image_sepia_depth\" class=\"input\" value=\"$image_sepia_depth\" maxlength=\"3\" size=\"3\"></td><td nowrap=\"nowrap\">Greyscale noise (0=disable):</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"image_noise_depth\" class=\"input\" value=\"$image_noise_depth\" maxlength=\"3\" size=\"3\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Copyright notice:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"copyright\" class=\"input\" value=\"$copyright\" size=\"40\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Copyright position:</td><td nowrap=\"nowrap\" colspan=\"5\"><input type=\"text\" name=\"copyright_position\" class=\"input\" value=\"$copyright_position\" maxlength=\"10\" size=\"11\"> (based on %width and %height of the photo, 50% 50% = centered)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Watermark image:</td><td colspan=\"2\" nowrap=\"nowrap\"><input type=\"text\" name=\"watermark\" class=\"input\" value=\"$watermark\" size=\"40\"></td><td nowrap=\"nowrap\" colspan=\"3\">(path of PNG image, example: gfx/watermark.png)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Watermark image position:</td><td nowrap=\"nowrap\" colspan=\"5\" ><input type=\"text\" name=\"watermark_position\" class=\"input\" value=\"$watermark_position\" maxlength=\"10\" size=\"11\"> (based on %width and %height of the photo, 100% 100% = bottom right)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Watermark transparancy:</td><td nowrap=\"nowrap\" colspan=\"5\"><input type=\"text\" name=\"watermark_transparancy\" class=\"input\" value=\"$watermark_transparancy\" maxlength=\"4\" size=\"4\"> (0-100: 0=invisible)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Use border image:</td><td nowrap=\"nowrap\" colspan=\"5\"><input type=\"checkbox\" name=\"apply_thumbnail_borderpng\" class=\"input\" value=\"true\" $apply_thumbnail_borderpng_checked> (applies thumbnail border image to photo)</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Shop system:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Enable shop system:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"shop\" class=\"input\" value=\"true\" $shop_checked></td><td nowrap=\"nowrap\">Images per page:</td><td nowrap=\"nowrap\" colspan=\"3\"><input type=\"text\" name=\"shop_columns\" class=\"input\" value=\"$shop_columns\" size=\"3\" maxlength=\"3\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Shop choice 1:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"shop_choice1\" class=\"input\" value=\"$shop_choice1\" size=\"40\"> (comma separated, leave empty to disable)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Shop choice 2:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"shop_choice2\" class=\"input\" value=\"$shop_choice2\" size=\"40\"> (comma separated, leave empty to disable)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Shop email:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"shop_email\" class=\"input\" value=\"$shop_email\" size=\"40\"> (address for order confirmation)</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Multimedia files (MP3, MPEG, AVI, etc.):</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Enable multimedia:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"play_multimedia\" class=\"input\" value=\"true\" $play_multimedia_checked></td><td nowrap=\"nowrap\" colspan=\"4\"> (include an image and multimediafile with the same name)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Embed player:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"embed_player\" class=\"input\" value=\"true\" $embed_player_checked></td><td nowrap=\"nowrap\">Link to player:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"link_player\" class=\"input\" value=\"true\" $link_player_checked></td><td nowrap=\"nowrap\">Add download link:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"download_multimedia\" class=\"input\" value=\"true\" $download_multimedia_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Movie formats:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"movie_formats\" class=\"input\" value=\"$movie_formats\" size=\"40\"> (extensions of supported formats)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Sound formats:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"sound_formats\" class=\"input\" value=\"$sound_formats\" size=\"40\"> (extensions of supported formats)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Watermark image:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"mm_watermark\" class=\"input\" value=\"$mm_watermark\" size=\"40\"> (PNG image, example: gfx/multimedia_watermark.png)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Watermark image position:</td><td nowrap=\"nowrap\" colspan=\"5\" ><input type=\"text\" name=\"mm_watermark_position\" class=\"input\" value=\"$mm_watermark_position\" maxlength=\"10\" size=\"11\"> (based on %width and %height of the image, 100% 100% = bottom right)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Watermark transparancy:</td><td nowrap=\"nowrap\" colspan=\"5\"><input type=\"text\" name=\"mm_watermark_transparancy\" class=\"input\" value=\"$mm_watermark_transparancy\" maxlength=\"4\" size=\"4\"> (0-100: 0=invisible)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Icon directory:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"mm_dir\" class=\"input\" value=\"$mm_dir\" size=\"20\"> example: gfx/ (add mp3.jpg for MP3 files or avi.png for AVI files etc.)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Apply thumbnail settings:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"mm_thumbnail\" class=\"input\" value=\"true\" $mm_thumbnail_checked></td><td nowrap=\"nowrap\" colspan=\"4\"> (applies thumbnail configuration to icon)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Refresh icon thumbnails:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"mm_refresh\" class=\"input\" value=\"true\"></td><td nowrap=\"nowrap\" colspan=\"4\"> (recreates all multimedia thumbnails)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Apply photo settings:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"mm_photo\" class=\"input\" value=\"true\" $mm_photo_checked></td><td nowrap=\"nowrap\" colspan=\"4\"> (applies photo manipulation to icon)</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Album colors:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Page color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"page_color\" class=\"input\" value=\"".ltrim($page_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Text color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"text_color\" class=\"input\" value=\"".ltrim($text_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Text hover color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"text_hover_color\" class=\"input\" value=\"".ltrim($text_hover_color,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Title color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"title_color\" class=\"input\" value=\"".ltrim($title_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Photo border color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"border_color\" class=\"input\" value=\"".ltrim($border_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Table color (=background):</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"table_color\" class=\"input\" value=\"".ltrim($table_color,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Table border color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"item_border_color\" class=\"input\" value=\"".ltrim($item_border_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Header & footer line color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"line_color\" class=\"input\" value=\"".ltrim($line_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Email link color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"email_color\" class=\"input\" value=\"".ltrim($email_color,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Hit counter linecolor:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"hit_counter_linecolor\" class=\"input\" value=\"".ltrim($hit_counter_linecolor,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Hit counter color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"hit_counter_segmentcolor\" class=\"input\" value=\"".ltrim($hit_counter_segmentcolor,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Hit counter textcolor:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"hit_counter_textcolor\" class=\"input\" value=\"".ltrim($hit_counter_textcolor,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Rating color inactive:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"rating_blockcolor\" class=\"input\" value=\"".ltrim($rating_blockcolor,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Rating color score:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"rating_blockcolor_score\" class=\"input\" value=\"".ltrim($rating_blockcolor_score,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">&nbsp; </td><td nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Menu colors:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Bordertop color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_bordertop_color\" class=\"input\" value=\"".ltrim($menu_bordertop_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Borderbottom color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_borderbottom_color\" class=\"input\" value=\"".ltrim($menu_borderbottom_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Borderleft color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_borderleft_color\" class=\"input\" value=\"".ltrim($menu_borderleft_color,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Borderright color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_borderright_color\" class=\"input\" value=\"".ltrim($menu_borderright_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Bordertop hover color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_bordertop_hover_color\" class=\"input\" value=\"".ltrim($menu_bordertop_hover_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Borderbottom hover color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_borderbottom_hover_color\" class=\"input\" value=\"".ltrim($menu_borderbottom_hover_color,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Borderleft hover color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_borderleft_hover_color\" class=\"input\" value=\"".ltrim($menu_borderleft_hover_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Borderright hover color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_borderright_hover_color\" class=\"input\" value=\"".ltrim($menu_borderright_hover_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Text color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_text_color\" class=\"input\" value=\"".ltrim($menu_text_color,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Text hover color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_texthover_color\" class=\"input\" value=\"".ltrim($menu_texthover_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Background color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_background_color\" class=\"input\" value=\"".ltrim($menu_background_color,'#')."\" maxlength=\"6\" size=\"7\"></td><td nowrap=\"nowrap\">Background hover color:</td><td nowrap=\"nowrap\"><input type=\"text\" name=\"menu_background_hover_color\" class=\"input\" value=\"".ltrim($menu_background_hover_color,'#')."\" maxlength=\"6\" size=\"7\"></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Color chart:</b></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell\"><center><table class=\"tablesmaller\">\n";
	echo "<tr><td bgcolor=ffffff>ffffff</td><td bgcolor=ffffcc>ffffcc</td><td bgcolor=ffff99>ffff99</td><td bgcolor=ffff66>ffff66</td><td bgcolor=ffff33>ffff33</td><td bgcolor=ffff00>ffff00</td><td bgcolor=ffccff>ffccff</td><td bgcolor=ffcccc>ffcccc</td><td bgcolor=ffcc99>ffcc99</td><td bgcolor=ffcc66>ffcc66</td><td bgcolor=ffcc33>ffcc33</td><td bgcolor=ffcc00>ffcc00</td></tr>\n";
	echo "<tr><td bgcolor=ff99ff>ff99ff</td><td bgcolor=ff99cc>ff99cc</td><td bgcolor=ff9999>ff9999</td><td bgcolor=ff9966>ff9966</td><td bgcolor=ff9933>ff9933</td><td bgcolor=ff9900>ff9900</td><td bgcolor=ff66ff>ff66ff</td><td bgcolor=ff66cc>ff66cc</td><td bgcolor=ff6699>ff6699</td><td bgcolor=ff6666>ff6666</td><td bgcolor=ff6633>ff6633</td><td bgcolor=ff6600>ff6600</td></tr>\n";
	echo "<tr><td bgcolor=ff33ff>ff33ff</td><td bgcolor=ff33cc>ff33cc</td><td bgcolor=ff3399>ff3399</td><td bgcolor=ff3366>ff3366</td><td bgcolor=ff3333>ff3333</td><td bgcolor=ff3300>ff3300</td><td bgcolor=ff00ff>ff00ff</td><td bgcolor=ff00cc>ff00cc</td><td bgcolor=ff0099>ff0099</td><td bgcolor=ff0066>ff0066</td><td bgcolor=ff0033>ff0033</td><td bgcolor=ff0000>ff0000</td></tr>\n";
	echo "<tr><td bgcolor=ccffff>ccffff</td><td bgcolor=ccffcc>ccffcc</td><td bgcolor=ccff99>ccff99</td><td bgcolor=ccff66>ccff66</td><td bgcolor=ccff33>ccff33</td><td bgcolor=ccff00>ccff00</td><td bgcolor=ccccff>ccccff</td><td bgcolor=cccccc>cccccc</td><td bgcolor=cccc99>cccc99</td><td bgcolor=cccc66>cccc66</td><td bgcolor=cccc33>cccc33</td><td bgcolor=cccc00>cccc00</td></tr>\n";
	echo "<tr><td bgcolor=cc99ff>cc99ff</td><td bgcolor=cc99cc>cc99cc</td><td bgcolor=cc9999>cc9999</td><td bgcolor=cc9966>cc9966</td><td bgcolor=cc9933>cc9933</td><td bgcolor=cc9900>cc9900</td><td bgcolor=cc66ff>cc66ff</td><td bgcolor=cc66cc>cc66cc</td><td bgcolor=cc6699>cc6699</td><td bgcolor=cc6666>cc6666</td><td bgcolor=cc6633>cc6633</td><td bgcolor=cc6600>cc6600</td></tr>\n";
	echo "<tr><td bgcolor=cc33ff>cc33ff</td><td bgcolor=cc33cc>cc33cc</td><td bgcolor=cc3399>cc3399</td><td bgcolor=cc3366>cc3366</td><td bgcolor=cc3333>cc3333</td><td bgcolor=cc3300>cc3300</td><td bgcolor=cc00ff>cc00ff</td><td bgcolor=cc00cc>cc00cc</td><td bgcolor=cc0099>cc0099</td><td bgcolor=cc0066>cc0066</td><td bgcolor=cc0033>cc0033</td><td bgcolor=cc0000>cc0000</td></tr>\n";
	echo "<tr><td bgcolor=99ffff>99ffff</td><td bgcolor=99ffcc>99ffcc</td><td bgcolor=99ff99>99ff99</td><td bgcolor=99ff66>99ff66</td><td bgcolor=99ff33>99ff33</td><td bgcolor=99ff00>99ff00</td><td bgcolor=99ccff>99ccff</td><td bgcolor=99cccc>99cccc</td><td bgcolor=99cc99>99cc99</td><td bgcolor=99cc66>99cc66</td><td bgcolor=99cc33>99cc33</td><td bgcolor=99cc00>99cc00</td></tr>\n";
	echo "<tr><td bgcolor=9999ff>9999ff</td><td bgcolor=9999cc>9999cc</td><td bgcolor=999999>999999</td><td bgcolor=999966>999966</td><td bgcolor=999933>999933</td><td bgcolor=999900>999900</td><td bgcolor=9966ff>9966ff</td><td bgcolor=9966cc>9966cc</td><td bgcolor=996699>996699</td><td bgcolor=996666>996666</td><td bgcolor=996633>996633</td><td bgcolor=996600>996600</td></tr>\n";
	echo "<tr><td bgcolor=9933ff>9933ff</td><td bgcolor=9933cc>9933cc</td><td bgcolor=993399>993399</td><td bgcolor=993366>993366</td><td bgcolor=993333>993333</td><td bgcolor=993300>993300</td><td bgcolor=9900ff>9900ff</td><td bgcolor=9900cc>9900cc</td><td bgcolor=990099>990099</td><td bgcolor=990066>990066</td><td bgcolor=990033>990033</td><td bgcolor=990000>990000</td></tr>\n";
	echo "<tr><td bgcolor=66ffff>66ffff</td><td bgcolor=66ffcc>66ffcc</td><td bgcolor=66ff99>66ff99</td><td bgcolor=66ff66>66ff66</td><td bgcolor=66ff33>66ff33</td><td bgcolor=66ff00>66ff00</td><td bgcolor=66ccff>66ccff</td><td bgcolor=66cccc>66cccc</td><td bgcolor=66cc99>66cc99</td><td bgcolor=66cc66>66cc66</td><td bgcolor=66cc33>66cc33</td><td bgcolor=66cc00>66cc00</td></tr>\n";
	echo "<tr><td bgcolor=6699ff>6699ff</td><td bgcolor=6699cc>6699cc</td><td bgcolor=669999>669999</td><td bgcolor=669966>669966</td><td bgcolor=669933>669933</td><td bgcolor=669900>669900</td><td bgcolor=6666ff>6666ff</td><td bgcolor=6666cc>6666cc</td><td bgcolor=666699>666699</td><td bgcolor=666666>666666</td><td bgcolor=666633>666633</td><td bgcolor=666600>666600</td></tr>\n";
	echo "<tr><td bgcolor=6633ff>6633ff</td><td bgcolor=6633cc>6633cc</td><td bgcolor=663399>663399</td><td bgcolor=663366>663366</td><td bgcolor=663333>663333</td><td bgcolor=663300>663300</td><td bgcolor=6600ff>6600ff</td><td bgcolor=6600cc>6600cc</td><td bgcolor=660099>660099</td><td bgcolor=660066>660066</td><td bgcolor=660033>660033</td><td bgcolor=660000>660000</td></tr>\n";
	echo "<tr><td bgcolor=33ffff>33ffff</td><td bgcolor=33ffcc>33ffcc</td><td bgcolor=33ff99>33ff99</td><td bgcolor=33ff66>33ff66</td><td bgcolor=33ff33>33ff33</td><td bgcolor=33ff00>33ff00</td><td bgcolor=33ccff>33ccff</td><td bgcolor=33cccc>33cccc</td><td bgcolor=33cc99>33cc99</td><td bgcolor=33cc66>33cc66</td><td bgcolor=33cc33>33cc33</td><td bgcolor=33cc00>33cc00</td></tr>\n";
	echo "<tr><td bgcolor=3399ff>3399ff</td><td bgcolor=3399cc>3399cc</td><td bgcolor=339999>339999</td><td bgcolor=339966>339966</td><td bgcolor=339933>339933</td><td bgcolor=339900>339900</td><td bgcolor=3366ff>3366ff</td><td bgcolor=3366cc>3366cc</td><td bgcolor=336699>336699</td><td bgcolor=336666>336666</td><td bgcolor=336633>336633</td><td bgcolor=336600>336600</td></tr>\n";
	echo "<tr><td bgcolor=3333ff>3333ff</td><td bgcolor=3333cc>3333cc</td><td bgcolor=333399>333399</td><td bgcolor=333366>333366</td><td bgcolor=333333>333333</td><td bgcolor=333300>333300</td><td bgcolor=3300ff>3300ff</td><td bgcolor=3300cc>3300cc</td><td bgcolor=330099>330099</td><td bgcolor=330066>330066</td><td bgcolor=330033>330033</td><td bgcolor=330000>330000</td></tr>\n";
	echo "<tr><td bgcolor=00ffff>00ffff</td><td bgcolor=00ffcc>00ffcc</td><td bgcolor=00ff99>00ff99</td><td bgcolor=00ff66>00ff66</td><td bgcolor=00ff33>00ff33</td><td bgcolor=00ff00>00ff00</td><td bgcolor=00ccff>00ccff</td><td bgcolor=00cccc>00cccc</td><td bgcolor=00cc99>00cc99</td><td bgcolor=00cc66>00cc66</td><td bgcolor=00cc33>00cc33</td><td bgcolor=00cc00>00cc00</td></tr>\n";
	echo "<tr><td bgcolor=0099ff>0099ff</td><td bgcolor=0099cc>0099cc</td><td bgcolor=009999>009999</td><td bgcolor=009966>009966</td><td bgcolor=009933>009933</td><td bgcolor=009900>009900</td><td bgcolor=0066ff>0066ff</td><td bgcolor=0066cc>0066cc</td><td bgcolor=006699>006699</td><td bgcolor=006666>006666</td><td bgcolor=006633>006633</td><td bgcolor=006600>006600</td></tr>\n";
	echo "<tr><td bgcolor=0033ff>0033ff</td><td bgcolor=0033cc>0033cc</td><td bgcolor=003399>003399</td><td bgcolor=003366>003366</td><td bgcolor=003333>003333</td><td bgcolor=003300>003300</td><td bgcolor=0000ff>0000ff</td><td bgcolor=0000cc>0000cc</td><td bgcolor=000099>000099</td><td bgcolor=000066>000066</td><td bgcolor=000033>000033</td><td bgcolor=000000>000000</td></tr>\n";
	echo "</table></center></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Visitor Login*:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Enable visitor album login:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"checkbox\" name=\"restrict_access_configured\" class=\"input\" value=\"true\" $restrict_access_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Valid users/passwords:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"users_configured\" class=\"input\" value=\"$users_configured\" size=\"40\"> name,password,name,password,...</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">*) To prevent display of a protected photo in the gallery index, add an 'index.jpg' photo or 'index.png' icon to the album.</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Visitor File Upload:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Enable visitor file upload:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"checkbox\" name=\"visitor_upload\" class=\"input\" value=\"true\" $visitor_upload_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Require upload login:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"checkbox\" name=\"visitor_password\" class=\"input\" value=\"true\" $visitor_password_checked> (uses the same users/passwords as visitor login)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Review before posting:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"checkbox\" name=\"visitor_upload_adminreview\" class=\"input\" value=\"true\" $visitor_upload_adminreview_checked> (uploads to the albums backup directory, click 'restore' to post photo)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Maximum filesize in kB:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"visitor_upload_size\" class=\"input\" value=\"$visitor_upload_size\" size=\"6\" maxlength=\"4\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Maximum files per upload:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"visitor_upload_max_files\" class=\"input\" value=\"$visitor_upload_max_files\" size=\"2\" maxlength=\"1\"> (1 minimum - 6 maximum)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Valid files:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"visitor_files\" class=\"input\" value=\"$visitor_files\" size=\"40\"> (file-extensions comma separated)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Email address:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"upload_email\" class=\"input\" value=\"$upload_email\" size=\"40\"> (notification address for new uploads)</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Server configuration:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Server has GD2+:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"gd2\" class=\"input\" value=\"true\" $gd2_checked></td><td nowrap=\"nowrap\">Create thumbnail cache:</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"create_thumbnail_cache\" class=\"input\" value=\"true\" $create_thumbnail_cache_checked></td><td nowrap=\"nowrap\">Use ImageMagick (resize/rotate):</td><td nowrap=\"nowrap\"><input type=\"checkbox\" name=\"imagemagick\" class=\"input\" value=\"true\" $imagemagick_checked></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Path to ImageMagick:</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"imagemagick_path\" class=\"input\" value=\"$imagemagick_path\" size=\"40\"> (optional, example: /usr/bin/)</td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\">Ban IP's (comma separated):</td><td colspan=\"5\" nowrap=\"nowrap\"><input type=\"text\" name=\"ban_ip\" class=\"input\" value=\"$ban_ip\" size=\"40\"> (ban from hitcounter, rating, comment and upload)</td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\" class=\"tablecell2\"><b>Meta information for Search Engines:</b></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Album description:</td><td colspan=\"4\" nowrap=\"nowrap\"><input type=\"text\" name=\"meta_description\" class=\"input\" value=\"$meta_description\" size=\"80\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Keywords (comma separated):</td><td colspan=\"4\" nowrap=\"nowrap\"><input type=\"text\" name=\"meta_keywords\" class=\"input\" value=\"$meta_keywords\" size=\"80\"></td></tr>\n";
	echo "<tr><td nowrap=\"nowrap\" colspan=\"2\">Author and copyright:</td><td colspan=\"4\" nowrap=\"nowrap\"><input type=\"text\" name=\"meta_copyright_and_author\" class=\"input\" value=\"$meta_copyright_and_author\" size=\"80\"></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\">&nbsp; </td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\"><input type=\"submit\" name=\"configsaveb\" value=\"Save\" onclick=\"this.form.configsaveb.value='Please wait'; this.form.submit(); this.form.configsaveb.disabled='true'; this.form.viewb.disabled='true'; this.form.cancelb.disabled='true';\" class=\"button\"> <input type=\"button\" name=\"cancelb\" value=\"Back\" onclick=\"document.location.href='index.php?admin=1'\" class=\"button\"> <input type=\"button\" name=\"viewb\" value=\"View\" onclick=\"window.open('index.php')\" class=\"button\"></td></tr>\n";
	echo "<tr><td colspan=\"6\" nowrap=\"nowrap\"> &nbsp;</td></tr>\n";
	echo "</table></center></div><div class=\"line\"> &nbsp;</div>";
	echo "</div></form></body></html>\n";
	exit;
}

// CSS code
function html_css() {
	global $text_hover_color,$border_color,$valign_thumbnail;
	global $menu_borderleft_color,$menu_borderright_color,$menu_borderleft_hover_color,$menu_borderright_hover_color;
	global $image_border,$page_header,$admin_link,$background_repeat,$background_position,$menu_background_image;
	if ($admin_link!='') {
		$page_color='#E5E5E5';
		$title_color='#0A7FDC';
		$text_color='#000000';
		$table_color='#D2D2D2';
		$item_border_color='#000000';
		$line_color='#000000';
		$center_title=false;
		$center_album=false;
		$menu_background_hover_color='#D2D2D2';
		$menu_background_color='#E5E5E5';
		$menu_text_color='#000000';
		$menu_texthover_color='#000000';
		$menu_line_width=1;
		$menu_bar_width=0;
		$menu_bordertop_color='#000000';
		$menu_borderbottom_color='#000000';
		$menu_borderleft_color='#000000';
		$menu_borderright_color='#000000';
		$menu_bordertop_hover_color='#000000';
		$menu_borderbottom_hover_color='#000000';
		$menu_background_image='';
		$background_image='';
		$content_width='85%';
		$content_leftmargin='10px';
		$page_leftmargin='20px';
		$transparent_page=false;
		$transparent_menu=false;
	} else {
		global $page_color,$title_color,$text_color,$menu_text_color,$table_color,$item_border_color,$line_color,$center_title,$menu_background_hover_color,$menu_line_width,$menu_bar_width,$menu_bordertop_color,$menu_borderbottom_color,$transparent_menu;
		global $menu_background_color,$menu_texthover_color,$menu_bordertop_hover_color,$menu_borderbottom_hover_color,$center_album,$background_image,$menu_background_image,$content_width,$content_leftmargin,$page_leftmargin,$transparent_page;
	}
	echo "<style type=\"text/css\">\n";
	echo "body {\n";
	if ($transparent_page)
		echo "	background-color: transparent;\n";
	else
		echo "	background-color : $page_color;\n";
	echo "	font-size : 76%;\n";
	if ($background_image!='' && $admin_link=='') {
		echo "	background-image: url('$background_image');\n"; 
		echo "	background-repeat: $background_repeat;\n";
		echo "	background-position: $background_position;\n";
	}
	if ($center_album) {echo "	text-align : center;\n";}
	echo "}\n";
	echo "h1 {\n";
	echo "	background-color : transparent;\n";
	echo "	color : $title_color;\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	padding : 0px 0px 0px 20px;\n";
	echo "	margin : 0;\n";
	echo "	margin-bottom : 10px;\n";
	echo "	font-size : 190%;\n";
	if ($center_title) {echo "	text-align : center;\n";} else {echo "	text-align : left;\n";}
	echo "}\n";
	echo "a:link {\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	background-color : transparent;\n";
	echo "	color : $text_color;\n";
	echo "	text-decoration : none;\n";
	echo "}\n";
	echo "a:visited {\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	background-color : transparent;\n";
	echo "	color : $text_color;\n";
	echo "	text-decoration : none;\n";
	echo "}\n";
	echo "a:hover {\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	background-color : transparent;\n";
	echo "	color : $text_hover_color;\n";
	echo "	text-decoration : underline;\n";
	echo "}\n";
	echo ".tablesmaller {\n";
	echo "	margin : 1%;\n";
	echo "	width : 10%;\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	background-color : transparent;\n";
	echo "	color : $text_color;\n";
	echo "	font-size : 1em;\n";
	echo "	padding : 1em;\n";
	echo "}\n";
	echo ".tablecell {\n";
	if (($background_image!='' || $transparent_page) && $admin_link=='') {
		echo "	background-color : transparent;\n";
	} else {
		echo "	border : 0.01em solid $item_border_color;\n";
		echo "	background-color : $table_color;\n";
	}
	echo "	padding : 0.5em;\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	font-size : 1em;\n";
	echo "	text-align : center;\n";
	echo "	vertical-align : $valign_thumbnail;\n";
	echo "}\n";
	echo ".tablecell2 {\n";
	echo "	border : 0.01em solid $item_border_color;\n";
	echo "	background-color : $table_color;\n";
	echo "	padding : 0.5em;\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	font-size : 1em;\n";
	echo "	text-align : left;\n";
	echo "	vertical-align : middle;\n";
	echo "}\n";
	echo ".line {\n";
	echo "	border-top : 0.01em solid $line_color;\n";
	echo "	border-bottom : none;\n";
	echo "	text-align : right;\n";
	echo "	margin : 0 0 0 2%;\n";
	echo "}\n";
	echo ".input {\n";
	echo "	border: 1px solid $line_color;\n";
	echo "	background-color: $menu_background_color;\n";
	echo "	font-family: Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	font-size : 1em;\n";
	echo "	color: $menu_text_color;\n";
	echo "}\n";
	echo ".button {\n";
	echo "	font-family: Arial, Helvetica, sans-serif;\n";
	echo "	background-color: $menu_background_hover_color;\n";
	echo "	color: $menu_text_color;\n";
	echo "	border:1px solid $line_color;\n";
	echo "	padding: 0.1em 0.35em 0.1em 0.35em;\n";
	echo "}\n";
	echo "#leftmargin {\n";
	if (!$center_album) {echo "	margin-left : $page_leftmargin;\n";}
	echo "	text-align : center;\n";
	echo "}\n";
	echo "#content {\n";
	if ($center_album) {
		echo "	margin-left : auto;\n";
		echo "	margin-right : auto;\n";
		echo "	position : relative;\n";
	} else {
		echo "	position : absolute;\n";
		echo "	left : $content_leftmargin;\n";
	}
	if ($page_header || $admin_link!='') {echo "	top : 20px;\n";} else {echo "	top : 0px;\n";}
	echo "	width : $content_width;\n";
	echo "	height : 100%;\n";
	echo "	background-color : transparent;\n";
	echo "}\n";
	echo "#bottommenu ul {\n";
	echo "	float : left;\n";
	echo "	padding : 0px 0px 0px 5px;\n";
	echo "	margin : 0;\n";
	echo "	font-family : Tahoma, Arial, Helvetica, sans-serif;\n";
	echo "	font-size : 0.9em;\n";
	echo "	color : $menu_text_color;\n";
	echo "}\n";
	echo "#bottommenu ul li {\n";
	echo "	display : inline;\n";
	echo "}\n";
	echo "#bottommenu ul li a {\n";
	echo "	float : left;\n";
	echo "	white-space : nowrap;\n";
	echo "	border-top : $menu_line_width".'px'." solid $menu_bordertop_color;\n";
	echo "	border-bottom : $menu_line_width".'px'." solid $menu_borderbottom_color;\n";
	echo "	border-left : $menu_bar_width".'px'." solid $menu_borderleft_color;\n";
	echo "	border-right : $menu_bar_width".'px'." solid $menu_borderright_color;\n";
	echo "	padding : 5px 10px 5px 10px;\n";
	echo "	margin-left : 10px;\n";
	echo "	margin-bottom : 10px;\n";
	if ($transparent_menu)
		echo "	background-color: transparent;\n";
	else
		echo "	background-color : $menu_background_color;\n";
	echo "	text-decoration : none;\n";
	echo "	color : $menu_text_color;\n";
	if ($menu_background_image!='' && $admin_link=='') {
		echo "	background-image: url('$menu_background_image');\n"; 
		echo "	background-repeat: repeat;\n";
		echo "	background-position: 0% 0%;\n";
	}
	echo "}\n";
	echo "#bottommenu ul li a:hover {\n";
	if ($transparent_menu)
		echo "	background-color: transparent;\n";
	else
		echo "	background-color : $menu_background_hover_color;\n";
	echo "	color : $menu_texthover_color;\n";
	echo "	border-top : $menu_line_width".'px'." solid $menu_bordertop_hover_color;\n";
	echo "	border-bottom : $menu_line_width".'px'." solid $menu_borderbottom_hover_color;\n";
	echo "	border-left : $menu_bar_width".'px'." solid $menu_borderleft_hover_color;\n";
	echo "	border-right : $menu_bar_width".'px'." solid $menu_borderright_hover_color;\n";
	echo "}\n";
	echo "#bottomstats {\n";
	echo "	float : left;\n";
	echo "	white-space : nowrap;\n";
	echo "	border-top : 1px solid $menu_bordertop_color;\n";
	echo "	border-bottom : 1px solid $menu_borderbottom_color;\n";
	echo "	border-left : 1px solid $menu_borderleft_color;\n";
	echo "	border-right : 1px solid $menu_borderright_color;\n";
	echo "	padding : 5px 10px 5px 10px;\n";
	echo "	margin-left : 10px;\n";
	echo "	margin-bottom : 10px;\n";
	if ($transparent_menu)
		echo "	background-color: transparent;\n";
	else
		echo "	background-color : $menu_background_color;\n";
	echo "	text-decoration : none;\n";
	echo "	color : $menu_text_color;\n";
	echo "}\n";
	echo "</style>\n";
	return;
}

?>