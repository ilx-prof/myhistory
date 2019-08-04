<script>
	function id_write_text(id,text)
	{
 		 document.getElementById(id).innerHTML +=text;
	}

</script>
<body>
<table align="center" bgcolor="#C0C0C0" cellspacing="0" cellpadding="0" border="1">
<tr>
	<td id="one"></td>
	<td id="ty"></td>
</tr>
<tr>
	<td id="fre"></td>
	<td id="for"></td>
</tr>
</table>
<a href="#" onclick="id_write_text('one','one'); return false;">one</a><br>
<a href="#" onclick="id_write_text('ty', 'ty' ); return false;">ty</a><br>
<a href="#" onclick="id_write_text('fre','fre'); return false;">fre</a><br>
<a href="#" onclick="id_write_text('for','for'); return false;">for</a><br>
</body>