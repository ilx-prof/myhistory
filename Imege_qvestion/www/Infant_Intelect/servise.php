<?

function del_in_array(&$mass_leter,$min,$max)
{
	while($min<=$max)
	{
		unset($mass_leter[$min]);
		$min++;
	}
}
function seve_data($data,$wey,$metod = "w+",$perenos = "
")//ñîõğàíÿåò ñòåê äàííûõ
{
	if(($file = fopen($wey,"$metod")) && fwrite($file, serialize($data).$perenos) && fclose ($file))
	{
		return "ôàéë óñïåøíî ñîõğàíåí";
	}
	else
	{
		return false;
	}
}

function load_data($way)//çàãğóæàåò ñòåê äàííûõ
{
	if($Nic_data = file_get_contents ($way) )
	{
		  $Nic_data = unserialize($Nic_data);
	}
	else
	{
		print "Attention the user is not found";
		return false;
	}
return $Nic_data;
}

function load_mass_leter ()
{
	$mass_leter=array();
	for($i=0;$i<=255;$i++)
	{
		$mass_leter[]=$i;
	}
	if (is_file("mass_leter.ini"))
	{
		load_data("mass_leter.ini");
	}
	if (isset ($_POST["Del"]))
	{
		foreach ($_POST["Del"] as $n => $str)
		{
			//print $n."=>".$str."<br>";
			$str = explode ("-",$str);
			del_in_array($mass_leter,$str[0],$str[1]);
		}
	}
	if(isset($_POST["Del_string"]) and !empty ($_POST["Del_string"]))
	{
		$str = explode (',',$_POST["Del_string"]);
		foreach($str as $key => $nym)
		{
			if (in_array($nym,$mass_leter))
			{
				//print $key."=>".$nym."<br>";
				del_in_array($mass_leter,$nym,$nym);
			}
		}
	}
	seve_data($mass_leter,"mass_leter.ini");
	return $mass_leter;
}
Function NOD ($a,$b)//..Ôóíêöèÿ íàèáîëüøåãî îáøåãî äåëèòåëÿ ğåêóğñèÿ ğóëèò
{
    $result = 0;
    $a = Abs($a);
    $b = Abs($b);
    if( $b>$a )
    {
        $result = $recursivegcd($b, $a);
        return $result;
    }
    if( $b==0 )
    {
        $result = $a;
    }
    else
    {
        $result = NOD($b, $a%$b);
    }
    return $result;
}

Function NOC ($a,$b)//..Ôóíêöèÿ íàèìåíüøåãî îáøåãî êğàòíîãî ğåêóğñèÿ ğóëèò
{
    $result = 0;
    $r = 0;
    $r1 = 0;
    $r2 = 0;
    $a = Abs($a);
    $b = Abs($b);
    if( $a==0 | $b==0 )
    {
        $result = 0;
    }
    else
    {
        $r1 = $a;
        $r = $b;
        do
        {
            $r2 = $r1;
            $r1 = $r;
            $r = $r2-$r1*($r2/$r1);
        }
        while( $r!=0 );
        $r2 = $a*$b/$r1;
    }
    $result = $r2;
    return $result;
}

?>