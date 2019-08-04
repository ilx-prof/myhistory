<center class="porr">Раздел <!--%ARTICLE_RAZDEL_NAME%--> -> <b class="por"><!--%ARTICLE_ELEMENT_NAME%--></b></center>
<center class="porr">Статья добавлена: <b class="por"><!--%ARTICLE_ELEMENT_DATE%--></b></center>
<center class="porr">Кем добавлена: <b class="por"><!--%ARTICLE_ELEMENT_AUTHOR%--></b></center>

<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">

<tr>
    <td colspan="2" width="100%" class="date2" style="text-align : justify; color : #004040; "><bR><!--%ARTICLE_ELEMENT_CONTENT%--></td>
</tr>

<tr>
    <td colspan="2" align="center"><br><b class=porr>Комментарии (<b class=por><!--%ARTICLE_ELEMENT_COMMENTS%--></b>)</b><br><br></td>
</tr>

<!--%ARTICLE_COMMENT_STR_START%-->
<tr>
    <td style="padding : 5px; border-bottom : 1px dashed black;">
        <center class="por">
                <!--%ARTICLE_COMMENT_NAME%--><br>
                <b class="date">
                   <!--%ARTICLE_COMMENT_TIME%--><br>
                   <!--%ARTICLE_COMMENT_DATE%-->
                </b>
        </center>
    </td>
    <td class="comm">
        <!--%ARTICLE_COMMENT_TEXT%-->
    </td>
</tr>
<!--%ARTICLE_COMMENT_STR_END%-->

<!--%ARTICLE_COMMENT_NOREPLY_STR_START%-->
<tr>
    <td colspan="2" align="center">
        <br>
        <b class=porr>
           Для того что бы добавить комментарий вам нужно авторизироваться!<br>
           Если вы не зарегистрированы, то <a href="/forum/register.php" target="_blank">зарегистрируйтесь</a>
        </b>
    </td>
</tr>
<!--%ARTICLE_COMMENT_NOREPLY_STR_END%-->

<!--%ARTICLE_COMMENT_REPLY_STR_START%-->
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
<!--%ARTICLE_COMMENT_REPLY_STR_END%-->

</table><br>