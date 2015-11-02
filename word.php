<?php
function getWord($str,$pos)
{
	$arr = array();
	$j=0;
	$arr[0]=0;
	for($i=0;$i<strlen($str);$i++)
	{
		if($str[$i] == ' ')
		array_push($arr,$i);
	}
	array_push($arr,strlen($str));
	$start = $arr[$pos-1];
	foreach($arr as $k=>$v)
	{
		if($k == $pos)
		{
			$str1 = substr_amit($str,$start,$v);
		}
	}
	return $str1;
}
function substr_amit($str,$start,$end)
{
	$arr = array();
	$str1 = "";
	for($i = 0;$i< strlen($str);$i++)
	{
		$arr[$i] = $str[$i];
	}
	foreach($arr as $k=>$v)
	{
		if($k == $start)
			$str1.=$v;
		if($k>$start && $k<$end)
			$str1.=$v;
		if($k==$end)
			$str1.=$v;
	}
	return $str1;
}
echo(getWord("I AM AMIT KUMAR MONDAL",2));
?>