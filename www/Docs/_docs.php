<?include "../_lib.php"?>

<ul>
<?$Docs=getAllDocs()?>
<?if(sizeof($Docs)) {?>
	<?foreach($Docs as $e) {?>
		<li><a href=<?=$e['url']?>><?=$e['title']?></a>
	<?}?>
<?} else {?>
	<li><i>документация не установлена.</i>
<?}?>
</ul>
