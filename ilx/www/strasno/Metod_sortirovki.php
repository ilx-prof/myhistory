<pre>
<?

////////////////////////Подготовка////////////////////////////////
function getmicrotime()
{
    list($usec, $sec) = explode(" ",microtime()); 
   	return ((float)$usec + (float)$sec); 
}
function testSPEED($arr,$name,$name_functions)
{
Global $n,$tests;
$tmp=$arr;
$time_start = getmicrotime();
$name_functions ($arr,$n);
$SPEED=getmicrotime()-$time_start;
$tests[$name]="$SPEED";
}
function go($mas,$arr)
{
	foreach ($mas as $name => $name_functions)
	{
		testSPEED($arr,$name,$name_functions);
	}
}
$i=0;
$n=10000;
while ($i++<$n)
{
	$arr[] = chr (rand(0,255));
}
$n=count($arr);
$tests=array();
/////////////////////////////////////////////////////////
$mas["Сортировка методом PHP (встроеная)"]="sort";
$mas["Сортировка методом Неймона"]="sort_nemo_love";
$mas["Сортировка методом бинарных деревьев"]="sort_binary_wol";
//$mas["Сортировка методом выбора (естественный алгоритм)"]="sort_Bibor";
//$mas["Сортировка методом простых вставок"]="sort_prost_add";
//$mas["Сортировка пузырьовым методом (ленивого пользователя)"]="sort_lenivai_user";
//$mas["Сортировка методом Шела"]="sort_Sell";
go($mas,$arr);
asort ($tests);
print_r ($tests);
?>
<br>
<?
print_r ($arr);

//..Сортировка методом выбора (естественный алгоритм)
FUNCTION sort_Bibor (&$arr,$n)
{
    $i=$j=$k=$m=0;
    for($i=1; $i<=$n; $i++)
    {
        $m = $arr[$i-1];
        $k = $i;
        for($j=$i; $j<=$n; $j++)
        {
            if( $m>$arr[$j-1] )
            {
                $m = $arr[$j-1];
                $k = $j;
            }
        }
        $arr[$k-1] = $arr[$i-1];
        $arr[$i-1] = $m;
    }
}
//..Сортировка методом бинатрых вставок ..нероботет в цикле   while( $b!=$c ) ошибка
/*FUNCTION sort_binary_add (&$arr,$n)
{
    $b=$c=$e=$j=$k=$tmp=0;
    $i = 2;
    do
    {
        $b = 1;
        $e = $i-1;
        $c = ($b+$e)/2;
        while( $b!=$c )
        {
            if( $arr[$c-1]>$arr[$i-1] )
            {
                $e = $c;
            }
            else
            {
                $b = $c;
            }
           print ($c = ($b+$e)/2)."<br>";
        }
        if( $arr[$b-1]<$arr[$i-1] )
        {
            if( $arr[$i-1]>$arr[$e-1] )
            {
                $b = $e+1;
            }
            else
            {
                $b = $e;
            }
        }
        $k = $i;
        $tmp = $arr[$i-1];
        while( $k>$b )
        {
            $arr[$k-1] = $arr[$k-1-1];
            $k = $k-1;
        }
        $arr[$b-1] = $tmp;
        $i = $i+1;
		print "бу $i  ";
    }
    while( $i<=$n );
}
*/
//..Сортировка методом простых вставок
FUNCTION sort_prost_add (&$arr,$n)
{
    $j = $k = $tmp = 0;
    $n = $n-1;
    $i = 1;
    do
    {
        $j = 0;
        do
        {
            if( $arr[$i]<=$arr[$j] )
            {
                $k = $i;
                $tmp = $arr[$i];
                do
                {
                    $arr[$k] = $arr[$k-1];
                    $k = $k-1;
                }
                while( $k>$j );
                $arr[$j] = $tmp;
                $j = $i;
            }
            else
            {
                $j = $j+1;
            }
        }
        while( $j<$i );
        $i = $i+1;
    }
    while( $i<=$n );
}

//..Сотртировка массива методом самого ленивого пользователя (пузырьковый)
FUNCTION sort_lenivai_user (&$arr,$n)
{
    $i = $j = $tmp = 0;
    for($i=0; $i<=$n-1; $i++)
    {
        for($j=0; $j<=$n-2-$i; $j++)
        {
            if( $arr[$j]>$arr[$j+1] )
            {
                $tmp = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $tmp;
            }
        }
    }
}

//..сортировка массива по методу бинарных деревьев имени Уильяма Флойда
FUNCTION sort_binary_wol (&$arr,$n)
{
	$j=$k=$t=$tmp=0;
    if( $n==1 )
    {
        return;
    }
    $i = 2;
    do
	{
        $t = $i;
        while($t!=1)
        {
            $k = $t/2;
            if( $arr[$k-1]>=$arr[$t-1] )
            {
                $t = 1;
            }
            else
            {
                $tmp = $arr[$k-1];
                $arr[$k-1] = $arr[$t-1];
                $arr[$t-1] = $tmp;
                $t = $k;
            }
        }
        $i = $i+1;
    }
    while($i<=$n);
    $i = $n-1;
    do
    {
        $tmp = $arr[$i];
        $arr[$i] = $arr[0];
        $arr[0] = $tmp;
        $t = 1;
        while($t!=0)
        {
            $k = 2*$t;
            if( $k>$i )
            {
                $t = 0;
            }
            else
            {
                if( $k<$i )
                {
                    if( $arr[$k]>$arr[$k-1] )
                    {
                        $k = $k+1;
                    }
                }
                if( $arr[$t-1]>=$arr[$k-1] )
                {
                   $t = 0;
                }
                else
                {
                    $tmp = $arr[$k-1];
                    $arr[$k-1] = $arr[$t-1];
                    $arr[$t-1] = $tmp;
                    $t = $k;
                }
            }
        }
        $i = $i-1;
    }
    while($i>=1);
}
//..сортировка  по методу Шела (тормозной =()
function sort_Sell (&$arr,$n)
{
    $c=$e=$g=$i=$j=$tmp=0;
    $n = $n-1;
    $g = ($n+1)/2;
    do
    {
        $i = $g;
        do
        {
            $j = $i-$g;
            $c = true;
            do
            {
                if( $arr[$j]<=$arr[$j+$g] )
                {
                    $c = false;
                }
                else
                {
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j+$g];
                    $arr[$j+$g] = $tmp;
                }
                $j = $j-1;
            }
            while( $j>=0 & $c );
            $i = $i+1;
        }
        while( $i<=$n );
        $g = $g/2;
    }
    while( $g>0 );
}
//..аЛГОРИТМ СортировкИ массива по возрастанию (метод фон Неймана, слияний)
FUNCTION sort_nemo_love (&$arr,$n)
{
	$c=$i=$i1=$i2=$n1=$n2=$j=$k=$tmp=0;
    $barr=ARRAY();
    $mergelen = 1;
    $c = true;
    while( $mergelen<$n )
    {
        if( $c )
        {
            $i = 0;
            while( $i+$mergelen<=$n )
            {
                $i1 = $i+1;
                $i2 = $i+$mergelen+1;
                $n1 = $i+$mergelen;
                $n2 = $i+2*$mergelen;
                if( $n2>$n )
                {
                    $n2 = $n;
                }
                while( $i1<=$n1 | $i2<=$n2 )
                {
                    if( $i1>$n1 )
                    {
                        while( $i2<=$n2 )
                        {
                            $i = $i+1;
                            $barr[$i-1] = $arr[$i2-1];
                            $i2 = $i2+1;
                        }
                    }
                    else
                    {
                        if( $i2>$n2 )
                        {
                            while( $i1<=$n1 )
                            {
                                $i = $i+1;
                                $barr[$i-1] = $arr[$i1-1];
                                $i1 = $i1+1;
                            }
                        }
                        else
                        {
                            if( $arr[$i1-1]>$arr[$i2-1] )
                            {
                                $i = $i+1;
                                $barr[$i-1] = $arr[$i2-1];
                                $i2 = $i2+1;
                            }
                            else
                            {
                                $i = $i+1;
                                $barr[$i-1] = $arr[$i1-1];
                                $i1 = $i1+1;
                            }
                        }
                    }
                }
            }
            $i = $i+1;
            while( $i<=$n )
            {
                $barr[$i-1] = $arr[$i-1];
                $i = $i+1;
            }
        }
        else
        {
            $i = 0;
            while( $i+$mergelen<=$n )
            {
                $i1 = $i+1;
                $i2 = $i+$mergelen+1;
                $n1 = $i+$mergelen;
                $n2 = $i+2*$mergelen;
                if( $n2>$n )
                {
                    $n2 = $n;
                }
                while( $i1<=$n1 | $i2<=$n2 )
                {
                    if( $i1>$n1 )
                    {
                        while( $i2<=$n2 )
                        {
                            $i = $i+1;
                            $arr[$i-1] = $barr[$i2-1];
                            $i2 = $i2+1;
                        }
                    }
                    else
                    {
                        if( $i2>$n2 )
                        {
                            while( $i1<=$n1 )
                            {
                                $i = $i+1;
                                $arr[$i-1] = $barr[$i1-1];
                                $i1 = $i1+1;
                            }
                        }
                        else
                        {
                            if( $barr[$i1-1]>$barr[$i2-1] )
                            {
                                $i = $i+1;
                                $arr[$i-1] = $barr[$i2-1];
                                $i2 = $i2+1;
                            }
                            else
                            {
                                $i = $i+1;
                                $arr[$i-1] = $barr[$i1-1];
                                $i1 = $i1+1;
                            }
                        }
                    }
                }
            }
            $i = $i+1;
            while( $i<=$n )
            {
                $arr[$i-1] = $barr[$i-1];
                $i = $i+1;
            }
        }
        $mergelen = 2*$mergelen;
        $c = !$c;
    }
    if( !$c )
    {
        $i = 1;
        do
        {
            $arr[$i-1] = $barr[$i-1];
            $i = $i+1;
        }
        while( $i<=$n );
    }
}
?></pre>