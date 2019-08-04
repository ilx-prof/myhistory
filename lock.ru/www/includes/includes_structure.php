<?php

if ( !defined ( "IN_LOCK_TEAM_ENGINE" ) ) {
   print "Access denied!";
   exit ();
}

$structure["html_language"]                              = "%HTML_LANGUAGE%";

$structure["head"]     ["default_charset"]               = "%DEFAULT_CHARSET%";
$structure["head"]     ["title"]                         = "%TITLE%";
$structure["head"]     ["description"]                   = "%DESCRIPTION%";
$structure["head"]     ["keywords"]                      = "%KEYWORDS%";
$structure["head"]     ["author"]                        = "%AUTHOR%";
$structure["head"]     ["robots"]                        = "%ROBOTS%";
$structure["head"]     ["revisit"]                       = "%REVISIT%";
$structure["head"]     ["stylesheet"]                    = "%STYLESHEET%";
$structure["head"]     ["shortcut_icon"]                 = "%SHORTCUT_ICON%";

$structure["request_uri"]                                = "<!--%REQUEST_URI%-->";
$structure["default_status"]                             = "%DEFAULT_STATUS%";

$structure["left_menu"]["razdel"]      ["header"]        = "<!--%LEFT_MENU_NAME%-->";
$structure["left_menu"]["razdel"]      ["str_start"]     = "<!--%LEFT_MENU_RAZDEL_STR_START%>";
$structure["left_menu"]["razdel"]      ["link"]          = "<%LMR_LINK%>";
$structure["left_menu"]["razdel"]      ["title"]         = "<%LMR_TITLE%>";
$structure["left_menu"]["razdel"]      ["name"]          = "<%LMR_NAME%>";
$structure["left_menu"]["razdel"]      ["active_link"]   = "<%LMR_ACTIVE_LINK%>";
$structure["left_menu"]["razdel"]      ["str_end"]       = "<%LEFT_MENU_RAZDEL_STR_END%-->";
$structure["left_menu"]["kategoria"]   ["str_start"]     = "<!--%LEFT_MENU_PODRAZDEL_STR_START%>";
$structure["left_menu"]["kategoria"]   ["link"]          = "<%LMPR_LINK%>";
$structure["left_menu"]["kategoria"]   ["title"]         = "<%LMPR_TITLE%>";
$structure["left_menu"]["kategoria"]   ["name"]          = "<%LMPR_NAME%>";
$structure["left_menu"]["kategoria"]   ["active_link"]   = "<%LMPR_ACTIVE_LINK%>";
$structure["left_menu"]["kategoria"]   ["str_end"]       = "<%LEFT_MENU_PODRAZDEL_STR_END%-->";

$structure["friends_menu"]["razdel"]   ["header"]        = "<!--%FRIENDS_MENU_NAME%-->";
$structure["friends_menu"]["razdel"]   ["str_start"]     = "<!--%FRIENDS_MENU_RAZDEL_STR_START%>";
$structure["friends_menu"]["razdel"]   ["link"]          = "<%FRIENDS_LINK%>";
$structure["friends_menu"]["razdel"]   ["title"]         = "<%FRIENDS_TITLE%>";
$structure["friends_menu"]["razdel"]   ["name"]          = "<%FRIENDS_NAME%>";
$structure["friends_menu"]["razdel"]   ["active_link"]   = "<%FRIENDS_ACTIVE_LINK%>";
$structure["friends_menu"]["razdel"]   ["str_end"]       = "<%FRIENDS_MENU_RAZDEL_STR_END%-->";

$structure["misc_menu"]["header"]                        = "<!--%MISC_MENU_HEADER%-->";
$structure["misc_menu"]["content"]                       = "<!--%MISC_MENU_CONTENT%-->";

$structure["members_menu"]["header"]                     = "<!--%MEMBERS_MENU_HEADER%-->";
$structure["members_menu"]["str_start"]                  = "<!--%MEMBERS_STR_START%-->";
$structure["members_menu"]["full_icq_number"]            = "<!--%FULL_ICQ_NUMBER%-->";
$structure["members_menu"]["first_half_icq_number"]      = "<!--%FIRST_HALF_ICQ_NUMBER%-->";
$structure["members_menu"]["second_half_icq_number"]     = "<!--%SECOND_HALF_ICQ_NUMBER%-->";
$structure["members_menu"]["link"]                       = "<!--%LINK%-->";
$structure["members_menu"]["nick"]                       = "<!--%NICK%-->";
$structure["members_menu"]["description"]                = "<!--%DESCRIPTION%-->";
$structure["members_menu"]["str_end"]                    = "<!--%MEMBERS_STR_END%-->";

$structure["info_header"]                                = "<!--%INFO_MENU_HEADER%-->";
$structure["browser"]                                    = "<!--%BROWSER%-->";
$structure["browser_version"]                            = "<!--%BROWSER_VERSION%-->";
$structure["gzip"]                                       = "<!--%GZIP%-->";
$structure["ip"]                                         = "<!--%IP%-->";

$structure["forums_posts"]["str_start"]                  = "<!--%FORUMS_POSTS_STR_START%-->";
$structure["forums_posts"]["module"]                     = "<!--%FORUMS_POSTS%-->";
$structure["forums_posts"]["name"]                       = "<!--%FORUMS_POSTS_NAME%-->";
$structure["forums_posts"]["thread_link"]                = "<!--%THREAD_LINK%-->";
$structure["forums_posts"]["thread_title"]               = "<!--%THREAD_TITLE%-->";
$structure["forums_posts"]["thread_replys"]              = "<!--%THREAD_REPLYS%-->";
$structure["forums_posts"]["thread_user_link"]           = "<!--%THREAD_USER_LINK%-->";
$structure["forums_posts"]["thread_user_name"]           = "<!--%THREAD_USER_NAME%-->";
$structure["forums_posts"]["thread_views"]               = "<!--%THREAD_VIEWS%-->";
$structure["forums_posts"]["thread_date"]                = "<!--%THREAD_DATE%-->";
$structure["forums_posts"]["thread_new_posts_link"]      = "<!--%THREAD_NEW_POSTS_LINK%-->";
$structure["forums_posts"]["thread_last_user_link"]      = "<!--%THREAD_LAST_USER_LINK%-->";
$structure["forums_posts"]["thread_last_user_name"]      = "<!--%THREAD_LAST_USER_NAME%-->";
$structure["forums_posts"]["str_end"]                    = "<!--%FORUMS_POSTS_STR_END%-->";

$structure["content"]                                    = "<!--%CENTER_CONTENT_HERE%-->";
$structure["content_header"]                             = "<!--%CENTER_CONTENT_HEADER_NAME%-->";
$structure["content_name"]                               = "<!--%CENTER_CONTENT_NAME%-->";

$structure["search_menu"]["header"]                      = "<!--%SEARCH_MENU_HEADER%-->";
$structure["search_menu"]["content"]                     = "<!--%SEARCH_MENU_CONTENT%-->";

$structure["right_menu"]["login"]      ["name"]          = "<!--%MENU_LOGIN_NAME%-->";
$structure["right_menu"]["login"]      ["content"]       = "<!--%MENU_LOGIN_CONTENT_HERE%-->";

$structure["right_menu"]["global_s"]   ["name"]          = "<!--%GLOBAL_SNIFFER_MENU_NAME%-->";
$structure["right_menu"]["global_s"]   ["content"]       = "<!--%GLOBAL_SNIFFER_CONTENT_HERE%-->";

$structure["counter_menu"]["header"]                     = "<!--%COUNTER_MENU_HEADER%-->";
$structure["counter_menu"]["content"]                    = "<!--%COUNTER_MENU_CONTENT%-->";;

$structure["statistics_menu"]["header"]                  = "<!--%STATISTICS_MENU_HEADER%-->";
$structure["statistics_menu"]["content"]                 = "<!--%STATISTICS_MENU_CONTENT%-->";;

$structure["copyright"]                                  = "<!--%COPYRIGHT_HERE%-->";
$structure["generation_time"]                            = "<!--%GENERATED_TIME_HERE%-->";
$structure["queries_used"]                               = "<!--%QUERIES_USED%-->";

$structure["articles"]["all_razdels"]  ["str_start"]     = "<!--%ARTICLE_RAZDEL_STR_START%-->";
$structure["articles"]["all_razdels"]  ["razdel_link"]   = "<!--%ARTICLE_RAZDEL_LINK%-->";
$structure["articles"]["all_razdels"]  ["razdel_name"]   = "<!--%ARTICLE_RAZDEL_NAME%-->";
$structure["articles"]["all_razdels"]  ["str_end"]       = "<!--%ARTICLE_RAZDEL_STR_END%-->";

$structure["articles"]["all_razdels"]  ["empty_start"]   = "<!--%ARTICLE_RAZDEL_EMPTY_STR_START%-->";
$structure["articles"]["all_razdels"]  ["empty_end"]     = "<!--%ARTICLE_RAZDEL_EMPTY_STR_END%-->";

$structure["articles"]["all_razdels"]  ["n_empty_start"] = "<!--%ARTICLE_RAZDEL_NOT_EMPTY_STR_START%-->";
$structure["articles"]["all_razdels"]  ["n_empty_end"]   = "<!--%ARTICLE_RAZDEL_NOT_EMPTY_STR_END%-->";

$structure["articles"]["all_razdels"]  ["element_start"] = "<!--%ARTICLE_ELEMENT_STR_START%-->";
$structure["articles"]["all_razdels"]  ["element_link"]  = "<!--%ARTICLE_ELEMENT_LINK%-->";
$structure["articles"]["all_razdels"]  ["element_name"]  = "<!--%ARTICLE_ELEMENT_NAME%-->";
$structure["articles"]["all_razdels"]  ["element_user"]  = "<!--%ARTICLE_ELEMENT_AUTHOR%-->";
$structure["articles"]["all_razdels"]  ["element_u_l"]   = "<!--%ARTICLE_ELEMENT_AUTHOR_LINK%-->";
$structure["articles"]["all_razdels"]  ["element_comm"]  = "<!--%ARTICLE_ELEMENT_COMMENTS%-->";
$structure["articles"]["all_razdels"]  ["element_cont"]  = "<!--%ARTICLE_ELEMENT_CONTENT%-->";
$structure["articles"]["all_razdels"]  ["element_date"]  = "<!--%ARTICLE_ELEMENT_DATE%-->";
$structure["articles"]["all_razdels"]  ["element_views"] = "<!--%ARTICLE_ELEMENT_VIEWS%-->";
$structure["articles"]["all_razdels"]  ["element_end"]   = "<!--%ARTICLE_ELEMENT_STR_END%-->";

$structure["articles"]["all_razdels"]  ["c_nr_start"]    = "<!--%ARTICLE_COMMENT_NOREPLY_STR_START%-->";
$structure["articles"]["all_razdels"]  ["c_nr_end"]      = "<!--%ARTICLE_COMMENT_NOREPLY_STR_END%-->";

$structure["articles"]["all_razdels"]  ["c_r_start"]     = "<!--%ARTICLE_COMMENT_REPLY_STR_START%-->";
$structure["articles"]["all_razdels"]  ["c_r_end"]       = "<!--%ARTICLE_COMMENT_REPLY_STR_END%-->";

$structure["articles"]["all_razdels"]  ["c_str_start"]   = "<!--%ARTICLE_COMMENT_STR_START%-->";
$structure["articles"]["all_razdels"]  ["c_name"]        = "<!--%ARTICLE_COMMENT_NAME%-->";
$structure["articles"]["all_razdels"]  ["c_date"]        = "<!--%ARTICLE_COMMENT_DATE%-->";
$structure["articles"]["all_razdels"]  ["c_time"]        = "<!--%ARTICLE_COMMENT_TIME%-->";
$structure["articles"]["all_razdels"]  ["c_text"]        = "<!--%ARTICLE_COMMENT_TEXT%-->";
$structure["articles"]["all_razdels"]  ["c_str_end"]     = "<!--%ARTICLE_COMMENT_STR_END%-->";

$structure["news"]["all_razdels"]  ["str_start"]         = "<!--%NEWS_RAZDEL_STR_START%-->";
$structure["news"]["all_razdels"]  ["razdel_link"]       = "<!--%NEWS_RAZDEL_LINK%-->";
$structure["news"]["all_razdels"]  ["razdel_name"]       = "<!--%NEWS_RAZDEL_NAME%-->";
$structure["news"]["all_razdels"]  ["str_end"]           = "<!--%NEWS_RAZDEL_STR_END%-->";

$structure["news"]["all_razdels"]  ["empty_start"]       = "<!--%NEWS_RAZDEL_EMPTY_STR_START%-->";
$structure["news"]["all_razdels"]  ["empty_end"]         = "<!--%NEWS_RAZDEL_EMPTY_STR_END%-->";

$structure["news"]["all_razdels"]  ["n_empty_start"]     = "<!--%NEWS_RAZDEL_NOT_EMPTY_STR_START%-->";
$structure["news"]["all_razdels"]  ["n_empty_end"]       = "<!--%NEWS_RAZDEL_NOT_EMPTY_STR_END%-->";

$structure["news"]["all_razdels"]  ["element_start"]     = "<!--%NEWS_ELEMENT_STR_START%-->";
$structure["news"]["all_razdels"]  ["element_link"]      = "<!--%NEWS_ELEMENT_LINK%-->";
$structure["news"]["all_razdels"]  ["element_name"]      = "<!--%NEWS_ELEMENT_NAME%-->";
$structure["news"]["all_razdels"]  ["element_user"]      = "<!--%NEWS_ELEMENT_AUTHOR%-->";
$structure["news"]["all_razdels"]  ["element_u_l"]       = "<!--%NEWS_ELEMENT_AUTHOR_LINK%-->";
$structure["news"]["all_razdels"]  ["element_comm"]      = "<!--%NEWS_ELEMENT_COMMENTS%-->";
$structure["news"]["all_razdels"]  ["element_cont"]      = "<!--%NEWS_ELEMENT_CONTENT%-->";
$structure["news"]["all_razdels"]  ["element_date"]      = "<!--%NEWS_ELEMENT_DATE%-->";
$structure["news"]["all_razdels"]  ["element_views"]     = "<!--%NEWS_ELEMENT_VIEWS%-->";
$structure["news"]["all_razdels"]  ["element_end"]       = "<!--%NEWS_ELEMENT_STR_END%-->";
$structure["news"]["all_razdels"]  ["pages"]             = "<!--%PAGES%-->";

$structure["news"]["all_razdels"]  ["c_nr_start"]        = "<!--%NEWS_COMMENT_NOREPLY_STR_START%-->";
$structure["news"]["all_razdels"]  ["c_nr_end"]          = "<!--%NEWS_COMMENT_NOREPLY_STR_END%-->";

$structure["news"]["all_razdels"]  ["c_r_start"]         = "<!--%NEWS_COMMENT_REPLY_STR_START%-->";
$structure["news"]["all_razdels"]  ["c_r_end"]           = "<!--%NEWS_COMMENT_REPLY_STR_END%-->";

$structure["news"]["all_razdels"]  ["c_str_start"]       = "<!--%NEWS_COMMENT_STR_START%-->";
$structure["news"]["all_razdels"]  ["c_name"]            = "<!--%NEWS_COMMENT_NAME%-->";
$structure["news"]["all_razdels"]  ["c_date"]            = "<!--%NEWS_COMMENT_DATE%-->";
$structure["news"]["all_razdels"]  ["c_time"]            = "<!--%NEWS_COMMENT_TIME%-->";
$structure["news"]["all_razdels"]  ["c_text"]            = "<!--%NEWS_COMMENT_TEXT%-->";
$structure["news"]["all_razdels"]  ["c_str_end"]         = "<!--%NEWS_COMMENT_STR_END%-->";

$structure["fade_js"]                                    = "<!--%FADE_JS%-->";

?>