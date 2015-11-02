<?php
function gen_chars($length) 
{
    // available characters
    $chars = '0123456789abcdefghjkmnoprstvwxyz!@#$%^&*()';
    $random  = '';
    
	// Generate code
    for ($i = 0; $i < $length; ++$i)
    {
        $random .= substr($chars, (((int) mt_rand(0,strlen($chars))) - 1),1);
    }
	return $random;
}
?>