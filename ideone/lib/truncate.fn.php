<?php
// ------------------------------------------------------------
// TRUNCATE TEXT
// ------------------------------------------------------------
function truncateText($text, $chars) 
{
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text." ...";
	return $text;
}