<pre>
<?php
print_r ($_POST);
$DANO = $_POST['ARIA'];
Settype ($DANO['one'] ,double);
Settype ($DANO['tu'] ,double);
Print "��� ������ ��������� ".gettype($DANO['one'])."<br>";
Print "��� ������ ��������� ".gettype($DANO['tu'])."<br>";
if(is_numeric($DANO['one']) or is_numeric($DANO['tu']))
{
	print '����� ��� ��������<br>'.$DANO['one'].$DANO['Action'].$DANO['tu']."=";
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
print '������ �������� �� ������ �� ����� ��� ����� ����� <a href="index.php">���������<a>';
$otv="error";
}
?>
<FORM ACTION="index.php" METHOD=POST > 
<input type="TEXT" name="ARIA[Action]" value="<?php print $otv ?>">
<INPUT TYPE=SUBMIT VALUE="�������� ����� � ������"  align="right"> 
<form>
<pre>