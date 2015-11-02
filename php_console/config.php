<?php

 
	$config = Array();
	$config['auth'] = Array();
	
	// Random string used for authenticating users. Type anything in here (recommended: 30+ characters for extra security). 
	$config['salt'] = 'amitkumarmondali-am-itschneiderelectric'; // <-- Change me.
	// $config['salt'] = '' . $_SERVER['REMOTE_ADDR']; // Lock sessions to IP address.
	
	// User list (all have the same privileges).
	$config['auth']['admin'] = 'password';
	// $config['auth']['username2'] = 'password2';
	// $config['auth']['username3'] = 'password3';
	
	// How long should it take for a session to expire from inactivity?
	$config['session_expire'] = 60*60; // 1 hour
	
	// Skip authentication. It's recommended that you only use this if you're using some other form of authentication (eg. HTTP basic authentication) already.
	$config['skip_log_in'] = false;
	
	// Hostname (user@hostname ~ $)
	//$config['hostname'] = exec('/bin/uname -n'); // Use system network node hostname.
	$config['hostname'] = 'I-AM-IT';
	
	// Application title.
	$config['title'] = 'PHP<span> Console by I-AM-IT</span>'; // Optional: <span> is orange.
	
	// Welcome text; displayed before anything else.
	$config['welcome'] = 'Welcome to PHP Console By I-AM-IT. Today is ' . date('D, j M Y') . '. Use "logout" to log out.';
	
	$config['welcome'] = '<br/>'.
' _____             __  __      _____ _______ <br/>'.
'|_   _|      /\   |  \/  |    |_   _|__   __|<br/>'.
'  | |______ /  \  | \  / |______| |    | | <br/>'.  
'  | |______/ /\ \ | |\/| |______| |    | | <br/>'.  
' _| |_    / ____ \| |  | |     _| |_   | |  <br/>'. 
'|_____|  /_/    \_\_|  |_|    |_____|  |_| <br/><br/>'.
'Welcome to PHP Console By I-AM-IT. Today is ' . date('D, j M Y') . '. Use "logout" to log out.<br/><br/>'.
'Contact me : admin@amitinside.com<br/>'; 
	
	
	// Directory for temporary file. Usually /tmp works just fine.
	$config['temp'] = '/tmp';
	
	// Set of directories where executable programs are located.
	$config['paths'] = Array(
		'/sbin',
		'/bin',
		'/usr/local/bin',
		'/usr/bin',
		'/usr/local/games',
		'/usr/games'
	);
	
	// Command alises.
	$config['aliases'] = Array(
		'ls' => 'ls --color=always',
		'grep' => 'grep --color=always'
	);
	
	// Initial and home path. (`cd' returns to here.)
	//$config['home'] = getcwd(); // Current path.
	 $config['home'] = '/home'; // Specified path.
	
