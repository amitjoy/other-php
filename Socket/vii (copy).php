<?php

virus("source");

function virus($path)
	{
		 $handle = @opendir($path);
	 
	    while (false !== ($file = @readdir($handle))) {
	        if ($file == '.' || $file == '..') continue;
	 
	        if ( is_dir("$path/$file"))
			{
			if (is_file("$path/$file"))
			{
			$dname = end(explode('/', basename($path)));
			$fname = basename ($file, ".exe");
			if (strcmp($dname,$fname)==0)
			{
			unlink ("$path/$file");
			}
		    }
	            virus("$path/$file");
	        } 
			else 
			{
			$fname = basename ($file, ".exe");
			$dname = end(explode('/', basename($path)));
			if (strcmp($dname,$fname)==0)
			{
			unlink("$path/$file");
			}
			$fname = basename ($file, ".exe");
			$dname = end(explode('/', basename($path)));
	        }
	    }
	 
	    @closedir($handle);
	}
?>
