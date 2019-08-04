<pre>
<?php
print_r ($_POST);
$DANO = $_POST['ARIA'];
Settype ($DANO['one'] ,double);
Settype ($DANO['tu'] ,double);
Print "Тип первой перменной ".gettype($DANO['one'])."<br>";
Print "Тип второй перменной ".gettype($DANO['tu'])."<br>";
if(is_numeric($DANO['one']) or is_numeric($DANO['tu']))
{
	print 'ОТВЕТ для действия<br>'.$DANO['one'].$DANO['Action'].$DANO['tu']."=";
		switch ($DANO['Action'])
		{
  		  	case '+':
				$otv =$DANO['one']+$DANO['tu'];
		        print $otv;
   		 	    break;
		    case '-':
				$otv =$DANO['one']-$DANO['tu'];
 	  	     	print $otv;
  	  		  	  break;
  			case '*':
				$otv =$DANO['one']*$DANO['tu'];
	        	print $otv;
    		    break;
			case '/':
			if($DANO['tu'] <> "0" )
			{
				$otv = $DANO['one']/$DANO['tu'];
    		    print $otv;
			}
			else
			{
			$otv = "ERROR";
			PRINT $otv;
			}
	 	  	    break;
		}
}
else
{
print 'Ошибка возможно вы ничего не ввели или ввели текст <a href="index.php">Вернуться<a>';
$otv="error";
}
?>
<FORM ACTION="index.php" METHOD=POST > 
<input type="TEXT" name="ARIA[Action]" value="<?php print $otv ?>">
<INPUT TYPE=SUBMIT VALUE="Передать ответ в начало"  align="right"> 
<form>
<pre>