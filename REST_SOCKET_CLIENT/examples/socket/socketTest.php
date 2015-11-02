<?php
require_once "../../main.php";
$server = '127.0.0.1';
$port = 80;
$ip = gethostbyname($server);
$conn = new SOCKET_CLIENT($server, $port, '\final\\');		
$conn->establish();

$data = $conn->read();
$conn->send_data("AMIT");

$conn->close();
