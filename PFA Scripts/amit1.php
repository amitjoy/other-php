<?php

	require_once("Android.php");
	$droid = new Android();
 
	/* Some GUI for the user */
	$droid->dialogCreateAlert("Socket Program By","Amit Kumar Mondal");
	$droid->dialogSetNeutralButtonText("I'm Ready to fun!");
	$droid->dialogShow();	
	$result = $droid->dialogGetResponse();
 
	/* Get parameters */
	/* 1- Remote AMI server */
	$server=$droid->dialogGetInput("Please enter IP/Hostname of your Asterisk BOX","");
	/* 2- Remote AMI port */
	$port=$droid->dialogGetInput("Please enter TCP Port","");
	/* 3- Remote user */
	$user=$droid->dialogGetInput("Please enter username","");
	/* 4- Remote pass */
	$pass=$droid->dialogGetPassword("Please enter password","");
 
	$server=$server['result'];
	$port=$port['result'];
	$user=$user['result'];
	$pass=$pass['result'];
 
	echo "Ready to connect to $server:$port with $user/$pass\n";
	/* TCP Connection */
	$astSocket = fsockopen($server, $port, $errno, $errstr, 30);
	if (!$astSocket) 
	{
		$droid->dialogCreateAlert("Socket Program","Sorry, TCP Connection on $server : $port was not possible :r(");
		$droid->dialogSetNeutralButtonText("I will try again :D)");
		$droid->dialogShow();	
		$result = $droid->dialogGetResponse();
		exit(1);
   	}
 
	/* Authentication process ... */
        $droid->dialogCreateSpinnerProgress("Connection Successfull!!!\nNow: Trying to Authenticate","Please wait");
        $droid->dialogShow();
 
	$login	=	"Action: Login\r\n";
	$login	.=	"Username: $user\r\n";
	$login	.=	"Secret: $pass\r\n\r\n";
	echo "Sending:\r\n $login \r\n";
	fwrite($astSocket,$login);
 
	$response=fgets($astSocket);
 
	$response=fgets($astSocket);
 
 
 
	if (strpos($response,"Success") == false)
	{
		$droid->dialogDismiss();
		$droid->dialogCreateAlert("Socket Program","Sorry, AMI Auth Failed $server : $port with $user/$pass \n");
		$droid->dialogSetNeutralButtonText("I will try again :D)");
		$droid->dialogShow();	
		$result = $droid->dialogGetResponse();
		exit(1);
	}
	$droid->dialogDismiss();
	$droid->dialogCreateSpinnerProgress("Auth Sucessfull !!! Ready to play ;)","Fetching some initial info, please wait");
        $droid->dialogShow();
	sleep(10);
	$droid->dialogDismiss();
 
	$eventsArray=array();
	$timetorefresh=time();
	/*		MAIN BIG LOOP				*/	
	while (1)
	{
 
		// Receive ...
		$line = fgets($astSocket);
		//echo ">> $line";
		if (substr($line,0,5) == "Event")
		{
			$parts = explode(":",$line);
			$event=$parts[1];
			$eventsArray["$event"]=$eventsArray["$event"]+1;
 
		}
		$lastupdate=time()-$timetorefresh;
		if ( $lastupdate > 15)
		{
			$values=var_dump($eventsArray);
			$droid->dialogDismiss();
			$droid->dialogCreateSpinnerProgress("Updated info",$values);
        		$droid->dialogShow();	
			$lastupdate=time();
		}
 
	}