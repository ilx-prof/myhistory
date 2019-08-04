<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
<tr>
    <td class="news_link"><b class=por><!--%NEWS_ELEMENT_NAME%--></b></td>
    <td class="news_date"><b class=date><!--%NEWS_ELEMENT_DATE%--></b></td>
</tr>
<tr>
    <td colspan="2" class="news_cont" style="text-align : justify;"><!--%NEWS_ELEMENT_CONTENT%--></td>
</tr>
<tr>
    <td class="news_user">
        <b class=porr>Автор : </b><a href="<!--%NEWS_ELEMENT_AUTHOR_LINK%-->" target="_blank"><b class=por><!--%NEWS_ELEMENT_AUTHOR%--></b></a>
    </td>
    <td class="news_comm"></td>
</tr>
<tr>
    <td><br></td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
<tr>
    <td colspan="2" align="center"><br><b class=porr>Комментарии (<b class=por><!--%NEWS_ELEMENT_COMMENTS%--></b>)</b><br><br></td>
</tr>

<!--%NEWS_COMMENT_STR_START%-->
<tr>
    <td style="padding : 5px; border-bottom : 1px dashed black;">
        <center class="por">
                <!--%NEWS_COMMENT_NAME%--><br>
                <b class="date">
                   <!--%NEWS_COMMENT_TIME%--><br>
                   <!--%NEWS_COMMENT_DATE%-->
                </b>
        </center>
    </td>
    <td class="comm">
        <!--%NEWS_COMMENT_TEXT%-->
    </td>
</tr>
<!--%NEWS_COMMENT_STR_END%-->

<!--%NEWS_COMMENT_NOREPLY_STR_START%-->
<tr>
    <td colspan="2" align="center">
        <br>
        <b class=porr>
           Для того что бы добавить комментарий вам нужно авторизироваться!<br>
           Если вы не зарегистрированы, то <a href="/forum/register.php" target="_blank">зарегистрируйтесь</a>
        </b>
    </td>
</tr>
<!--%NEWS_COMMENT_NOREPLY_STR_END%-->

<!--%NEWS_COMMENT_REPLY_STR_START%-->
<tr>
    <form method="POST">
    <input type="HIDDEN" name="action" value="add_new_comment">
    <td colspan="2">
        <br>
        <center>
                <b class=porr>Добавление нового комментария</b><br>
                <textarea class="button" style="background : white; width : 100%; height : 55px;" name="content"></textarea><br>
                <input type="SUBMIT" class="button" value="Добавить">
        </center>
    </td>
    </form>
</tr>
<!--%NEWS_COMMENT_REPLY_STR_END%-->

</table><br>