<?php

// set some variables
$host = "127.0.0.1";
$port = 7 | 8;


// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");

// bind socket to port
//$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");


// start listening for connections
$result = socket_listen($socket,3) or die("Could not set up socket listener\n");

// accept incoming connections
// spawn another socket to handle communication
while(TRUE)
{
$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
$msg ="Welcome to Synapse"."\n";
echo $argv[0]."\n";
echo $argv[1]."\n";
echo $argv[2]."\n";

socket_write($spawn, $result);

// read client input
$input = socket_read($spawn,1024,PHP_NORMAL_READ) or die("Could not read input\n");

// clean up input string
$input = trim($input);

// reverse client input and send back
$output = strrev($input);

$output=strtoupper($output);

socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
}
// close sockets
socket_close($spawn);

socket_close($socket);
?> 
