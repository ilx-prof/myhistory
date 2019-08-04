<body bgcolor="#D9F3FF">
<table align="center"  bgcolor="#c0c0c0" >
<form action="index.php" method="post">
<tr>
	<td>
				<input type="Text" name="form" value="(a-b)*(a+b)">
				<input type="Submit" value="Перемножить">
	</td>
<tr>
</form>
<tr>
	<td>
	<pre>
	<?php
	if (isset($_POST['form']))
	{
		$form = $_POST['form'];
		rasbor($form);
	
	}
	
	function recursion($formyla)
	{
		$a=0
		 while (false !== ($element = $formyla[$a++]))
		   {
				if ($element = '(')
				{
					
				}
				else
				{
					print $file ."<br>";
					$folders [$file] = ($dir."/".$file);
					//array_push ($folders, array( "$file" => $dir."/".$file));
					vhod_prosmotr($dir."/".$file,$a,$folders);
				
				}
			}
	}
	
	function scoba($regs)// вернет 2 логический массив состояший оз груп первого порядка
	{
		$r=$a=$o=0;
		foreach ($regs as $key => $val)
		{	
			$a = $val=='(' ? $a+1 : $r = $val==')' ? $a-1: $a;
			$o = $val=='(' ? $a+1 :$o;
			if ($val <> '(' and $val <> ')')
			{
				
			}
				$step1[0] .=
		}
		if ($a==0)
		{
			if($o==0)
			{
				return $regs;
			}
			else
			{
				$regs1=0;
				print "Разность - ".$a."<br> Количество груп по скобкам - ".$o;
			}
		}
		else
		{	
			if ($a>0)
			{				
				print '<br>Несоответствие скобок в выражении пропущена скобка ) в количестве '.$a."шт";
				return false;
			}
			else
			{
				print '<br>Несоответствие скобок в выражении пропущена скобка ( в количестве '.$a."шт";
				return false;
			}
		}
	}
	
	function rasbor($form)
		{
			print $form."<br>";
			preg_match_all("|([(a-z+-^>*)])|is", $form, $regs );//.возврашаеть 1 логический массивом массив - строка
			print_r ($regs[1]);
			scoba($regs[1]);
		}
		
	?></pre>
	</td>
<tr>

</table>
</body>