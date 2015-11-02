<?php
// --------------------------------------------------------
// HASHING FUNCTION
// --------------------------------------------------------
function hashThis($value_to_hash)
{
	$salty_salt = 'h!u@n#z$o%n^i&a*n';
	$hash_result = sha1(sha1($value_to_hash.$salty_salt));
	return $hash_result;
}