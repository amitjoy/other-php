<?php
function explode_amit($str,$delim)
{
	$cnt = strlen($str);
	$count = 0;
	$arr = array();
	$arr2 = array();
	for($i = 0;$i < $cnt; $i++)
	{
		if($str[$i]==$delim)
		{
			$count++;
			array_push($arr,$i);
		}
	}
	array_push($arr,strlen($str)+1);
	$start = 0;
	$str1 = "";
	$final = array();
	foreach($arr as $v)
	{
		$str1 = substr_amit($str,$start,$v-1);
		$start = $v+1;
		array_push($final,$str1);
	}
	return $final;
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
$str = "I am Amit Kumar Mondal and I am a PHP Freak";
$arr = explode_amit($str," ");
print_r($arr);
?>