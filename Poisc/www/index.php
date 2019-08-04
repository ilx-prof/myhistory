<body bgcolor="#E1E1E1">
<?php
copy("index.php","index.bac");
?>
<table border="1" bordercolor="#B5B5B5" >
<tr><td><br>
<form action="avil.php"	method="post">
<input type="text" name="skoko[directoria]" value="ilx">&nbsp;&nbsp;создать новую директорию<br><br>
<input type="text" name="skoko[skoko]" value="12">&nbsp;&nbsp;количество файлов<br><br>
<input width=12 type="text" name="skoko[ogran]" value="3" >&nbsp;&nbsp;Ограничение на время
<input type="Submit" value="Создать файлы">
</form>
</td></tr>
</table><br>
<table border="1" bordercolor="#B5B5B5" >
<tr><td><br>
<form action="sistem.php" method="post">
<input type="text" name="skoko" value="help">&nbsp;&nbsp;Comand line Windows&nbsp;&nbsp;
<input type="Submit" value="Выполнить">
</form>
</tr></td>
</table><br>
<table border="1" bordercolor="#B5B5B5" >
<tr><td><br>
<form action="serh.php" method="post">
<input type="text" name="skoko[neme]" value=".php">&nbsp;&nbsp;имя файла&nbsp;&nbsp;<br><br>
<input type="text" name="skoko[dir]" value="ilx">&nbsp;&nbsp;где искать&nbsp;&nbsp;
<input type="Submit" value="Поиск">
</form>
</tr></td>
</table>

<a href="Status.php"><br>Статус</a>
<a href="dellog.php"><br>Удалить log.txt</a>
<a href="erlog.php"><br>Очистить лог</a>
<a href="creatdel.php"><br>Удалить файлы</a>
<a href="log.txt"><br>Посмотреть log.txt </a>
<a href="dire.php"><br>Обзор содержимого папки</a>
</body>