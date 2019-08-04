<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//%HTML_LANGUAGE%">
<html>
<head>
      <meta HTTP-EQUIV="Content-Type" Content="text-html; charset=%DEFAULT_CHARSET%">
      <title>%TITLE%</title>
      <meta name="Description" content="%DESCRIPTION%">
      <meta name="KeyWords" content="%KEYWORDS%">
      <meta name="Author" content="%AUTHOR%">
      <meta name="robots" content="%ROBOTS%">
      <meta name="revisit" content="%REVISIT%">
      <link rel="stylesheet" type="text/css" href="%STYLESHEET%">
      <link rel="shortcut icon" href="%SHORTCUT_ICON%">
      <!--http://lock-team.com.org.biz.int.pro.arpa.aero.coop.museum.name.info.edu.gov.mil.net.ru/-->
</head>

<script language="Javascript" type="text/javascript">
//<!--%REQUEST_URI%-->
defaultStatus = "%DEFAULT_STATUS%";

function imgFade ( object, destOp, rate, delta ) {
         imgFadeObjects = new Object ( );
         imgFadeTimers = new Object ( );
         if ( !document.all ) return
         if ( object != "[object]" ) {
            setTimeout ( "imgFade("+object+","+destOp+","+rate+","+delta+")",0 );
            return;
         }

         clearTimeout ( imgFadeTimers[object.sourceIndex] );

         diff = destOp - object.filters.alpha.opacity;
         direction = 1;
         if  ( object.filters.alpha.opacity > destOp ) {
            direction = -1;
    }
    delta = Math.min ( direction * diff, delta );
    object.filters.alpha.opacity += direction * delta;

    if ( object.filters.alpha.opacity != destOp ) {
        imgFadeObjects[object.sourceIndex] = object;
        imgFadeTimers[object.sourceIndex] = setTimeout ( "imgFade(imgFadeObjects["+object.sourceIndex+"],"+destOp+","+rate+","+delta+")",rate );
    }
}

function mousein ( cart ) {
         cart.style.backgroundColor = "#EAEAEA";
}

function mouseout ( cart ) {
         cart.style.backgroundColor = "#FCFCFC";
}

</script>

<body bottommargin="0" leftmargin="0" topmargin="0" rightmargin="0" marginheight="0" marginwidth="0" background="/style/templates/lock-team/images/bg.gif">
<a name="top"></a>

<table cellspacing="0" cellpadding="0" class="maintb" align="center" bgcolor="#ffffff" width="900">
<tr>
    <td>
        <table cellspacing="0" cellpadding="0" width="100%" border="0" background="/style/templates/lock-team/images/2.jpg">
        <tr>
            <td align="right" style="padding-top : 25px;"><img src="/style/templates/lock-team/images/lock.gif" border="0"></td>
            <td align="center" style="padding-left : 21px;"><a href="/" target="_parent" title="Lock-Team"><img src="/style/templates/lock-team/images/666_1.jpg" border="0" alt=".:.[ This Is Lock-Team Home Page ].:."></a></td>
            <td align="left" style="padding-top : 25px;"><img src="/style/templates/lock-team/images/team.gif" border="0"></td>
        </tr>
        </table>
        <table cellspacing="9" cellpadding="0" width="100%" border="0" height="100%">
        <tr>
            <td valign="top" width="150">
                <table cellspacing="1" cellPadding="0" width="150" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%LEFT_MENU_NAME%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" width=150>
                        <TABLE cellSpacing="2" cellPadding="0" width="150" border="0">
                        <TR>
                            <TD width=150>
                                <TABLE cellSpacing="0" cellPadding="0" width="100%" border="0">
                                <!--%LEFT_MENU_RAZDEL_STR_START%>
                                <tr onmouseover="mousein(this);" onmouseout="mouseout(this);">
                                    <td style="padding-left : 5px;">
                                        <img src="/style/templates/lock-team/images/menu2.gif" width="12" height="8" border="0">
                                        <a href="<%LMR_LINK%>" title="<%LMR_TITLE%>" <%LMR_ACTIVE_LINK%> ><%LMR_NAME%></a>
                                    </td>
                                </tr>
                                <%LEFT_MENU_RAZDEL_STR_END%-->
                                <!--%LEFT_MENU_PODRAZDEL_STR_START%>
                                <tr onmouseover="mousein(this);" onmouseout="mouseout(this);">
                                    <td style="padding-left : 15px;">
                                        <img src="/style/templates/lock-team/images/menu3.gif" width="12" height="8" border="0">
                                        <a href="<%LMPR_LINK%>" title="<%LMPR_TITLE%>" <%LMPR_ACTIVE_LINK%> ><%LMPR_NAME%></a><br>
                                    </td>
                                </tr>
                                <%LEFT_MENU_PODRAZDEL_STR_END%-->
                                </table>
                            </TD>
                        </TR>
                        </TABLE>
                    </TD>
                </TR>
                </TABLE>
                
                <br>
                
                <table cellspacing="1" cellPadding="0" width="150" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%FRIENDS_MENU_NAME%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" width=150>
                        <TABLE cellSpacing="2" cellPadding="0" width="150" border="0">
                        <TR>
                            <TD width=150>
                                <TABLE cellSpacing="0" cellPadding="0" width="100%" border="0">
                                <!--%FRIENDS_MENU_RAZDEL_STR_START%>
                                <tr onmouseover="mousein(this);" onmouseout="mouseout(this);">
                                    <td style="padding-left : 5px;">
                                        <img src="/style/templates/lock-team/images/menu2.gif" width="12" height="8" border="0">
                                        <a href="<%FRIENDS_LINK%>" title="<%FRIENDS_TITLE%>" target="_blank"><%FRIENDS_NAME%></a><br>
                                    </td>
                                </tr>
                                <%FRIENDS_MENU_RAZDEL_STR_END%-->
                                </table>
                            </TD>
                        </TR>
                        </TABLE>
                    </TD>
                </TR>
                </TABLE>
                
                <br>

                <table cellspacing="1" cellPadding="0" width="150" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%MISC_MENU_HEADER%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" width=150>
                        <TABLE cellSpacing="2" cellPadding="2" width="150" border="0">
                        <TR>
                            <TD width=150>
                                <!--%MISC_MENU_CONTENT%-->
                            </TD>
                        </TR>
                        </TABLE>
                    </TD>
                </TR>
                </TABLE>
                
                <br>
                
                <table bgcolor="#999999" border="0" cellpadding="0" cellspacing="1" width="150">
                <tr>
                    <td background="/style/templates/lock-team/images/001.gif" bgcolor="#fcfcfc" height="16" colspan="2"><center><b class=label><!--%MEMBERS_MENU_HEADER%--></b></center></td>
                </tr>
                <tr>
                    <TD bgColor="#fcfcfc" width=150>
                        <TABLE cellSpacing="2" cellPadding="0" width="150" border="0">
                        <TR>
                            <TD width=150>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <!--%MEMBERS_STR_START%-->
                                <tr onmouseover="mousein(this);" onmouseout="mouseout(this);">
                                    <td style="padding-left : 5px;" align="center" valign="middle" width="16"><IMG src="http://web.icq.com/whitepages/online?icq=<!--%FULL_ICQ_NUMBER%-->&img=5" border="0" width="16" height="16"></td>
                                    <td align="center"><b class="por"><!--%FULL_ICQ_NUMBER%--></b></td>
                                    <Td align="center"><a href="<!--%LINK%-->"><b class=porr><!--%NICK%--></a></td>
                                </tr>
                                <!--%MEMBERS_STR_END%-->
                                </table>
                            </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                </table>

                <br>

                <table bgcolor="#999999" border="0" cellpadding="0" cellspacing="1" width="150">
                <tr>
                    <td background="/style/templates/lock-team/images/001.gif" bgcolor="#fcfcfc" height="16" colspan="2"><center><b class=label><!--%INFO_MENU_HEADER%--></b></center></td>
                </tr>
                <tr>
                    <TD bgColor="#fcfcfc" width=150>
                        <TABLE cellSpacing="2" cellPadding="0" width="150" border="0">
                        <TR>
                            <TD width=150>
                                <TABLE cellSpacing="0" cellPadding="3" border="0" width="100%">
                                <tr>
                                    <td><center class=porr>U-A</center></td>
                                    <td class=por align="center"><!--%BROWSER%--></td>
                                </tr>
                                <tr>
                                    <td><center class=porr>U-A-V</center></td>
                                    <td><center class=por><!--%BROWSER_VERSION%--></center></td>
                                </tr>
                                <tr>
                                    <td><center class=porr>GZIP</center></td>
                                    <td><center class=por><!--%GZIP%--></center></td>
                                </tr>
                                <tr>
                                    <td><center class=porr>IP</center></td>
                                    <td><center class=por><!--%IP%--></center></td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                </table>
            </td>

            <td width="100%" valign="top">
                <TABLE cellSpacing="1" cellPadding="2" width="100%" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%CENTER_CONTENT_HEADER_NAME%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" style="padding : 10px;" >
                        <center class="date">\x77\x77\x77<b class=date>\x2E</b>\x6C\x6F\x63\x6B<b class=date>\x2D</b>\x74\x65\x61\x6D<b class=date>\x2E</b>\x63\x6F\x6D</center>
                        <center class="date">.:.[ <!--%CENTER_CONTENT_NAME%--> ].:.</center>
                        <br><!--%CENTER_CONTENT_HERE%--><br>
                        <center class="date">.:.[ /<!--%CENTER_CONTENT_NAME%--> ].:.</center>
                        <center class="date">\x77\x77\x77<b class=date>\x2E</b>\x6C\x6F\x63\x6B<b class=date>\x2D</b>\x74\x65\x61\x6D<b class=date>\x2E</b>\x63\x6F\x6D</center>
                    </TD>
                </TR>
                </TABLE>
                
                <br>
                <TABLE cellSpacing="1" cellPadding="2" width="100%" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%FORUMS_POSTS_NAME%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" style="padding : 5px;">
                        <!--%FORUMS_POSTS%-->
                    </TD>
                </TR>
                </TABLE>
            </td>

            <td valign="top" align="right">

                <table cellspacing="1" cellPadding="0" width="150" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%SEARCH_MENU_HEADER%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" width=150>

                        <!--%SEARCH_MENU_CONTENT%-->

                    </TD>
                </TR>
                </TABLE>

                <br>

                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td>
                        <table cellspacing="1" cellPadding="2" width="150" bgColor="#999999" border="0">
                        <TR>
                            <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%MENU_LOGIN_NAME%--></b></CENTER></TD>
                        </TR>
                        <TR>
                            <TD bgColor="#fcfcfc">
                                <TABLE cellSpacing="2" cellPadding="0" width="100%" border="0">
                                <TR>
                                    <TD>
                                        <!--%MENU_LOGIN_CONTENT_HERE%-->
                                    </TD>
                                </TR>
                                </TABLE>
                            </TD>
                        </TR>
                        </TABLE>
                    </td>
                </tr>
                </table>
                
                <br>
                
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td>
                        <table cellspacing="1" cellPadding="0" width="150" bgColor="#999999" border="0">
                        <TR>
                            <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%GLOBAL_SNIFFER_MENU_NAME%--></b></CENTER></TD>
                        </TR>
                        <TR>
                            <TD bgColor="#fcfcfc">
                                <TABLE cellSpacing="2" cellPadding="2" width="100%" border="0">
                                <TR>
                                    <TD>
                                        <center><b class=date>Last sites in sniffer-logs : </b></center>
                                        <!--%GLOBAL_SNIFFER_CONTENT_HERE%-->
                                    </TD>
                                </TR>
                                </TABLE>
                            </TD>
                        </TR>
                        <tr>
                            <td bgColor="#fcfcfc" align="center">
                                <a href="/sniffer.html">On-Line Сниффер - <b class=porr>Log</b></a><br>
                                <a href="/sniffer_info.html">On-Line Сниффер - <b class=porr>Info</b></a><bR>
                            </td>
                        </tr>
                        </TABLE>
                    </td>
                </tr>
                </table>
                
                <br>

                <table cellspacing="1" cellPadding="0" width="150" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%COUNTER_MENU_HEADER%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" width=150>
                        <TABLE cellSpacing="2" cellPadding="2" width="150" border="0">
                        <TR>
                            <TD width=150>
                                <!--%COUNTER_MENU_CONTENT%-->
                            </TD>
                        </TR>
                        </TABLE>
                    </TD>
                </TR>
                </TABLE>

                <br>

                <table cellspacing="1" cellPadding="0" width="150" bgColor="#999999" border="0">
                <TR>
                    <TD background="/style/templates/lock-team/images/001.gif" bgColor="#fcfcfc" height="16"><CENTER><b class=label><!--%STATISTICS_MENU_HEADER%--></b></CENTER></TD>
                </TR>
                <TR>
                    <TD bgColor="#fcfcfc" width=150 align="center">
                        <TABLE cellSpacing="2" cellPadding="2" width="150" border="0" align="center">
                        <TR>
                            <TD width=150 align="center">
                                <!--%STATISTICS_MENU_CONTENT%-->
                            </TD>
                        </TR>
                        </TABLE>
                    </TD>
                </TR>
                </TABLE>
                
                <center><a href="/files/defaced.html" target="_blank"><b class=porr>Дефейсная страница</b></a></center>
            </td>
        </tr>
        </table>

        <TABLE cellSpacing="0" cellPadding="2" background="/style/templates/lock-team/images/2.jpg" width="100%" height="139" border="0">
        <tr>
            <td vAlign="top" align="center" colspan="3" height="100%"><Br><a href="#top">Вверх</a><br><b style="FONT-SIZE : 8pt;"><!--%COPYRIGHT_HERE%--></b></td>
        </tr>
        <tr>
            <td align="left" style="padding-bottom : 38px; padding-left : 6px;"><b class=porr>Generation time : <b class="por"> <!--%GENERATED_TIME_HERE%--> сек.</b></b></td>
            <td align="center" style="padding-bottom : 38px;" valign="bottom"></td>
            <td align="right" style="padding-bottom : 38px; padding-right : 6px;"><b class=porr>Queries to MySQL used : <b class="por"> <!--%QUERIES_USED%--> </b></b></td>
        </tr>
        </TABLE>
    </TD>
</TR>
</TABLE>

</BODY>
</HTML>
