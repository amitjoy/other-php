<?php
// db connection string variables
define('DB_HOST', "localhost"); // database location
define('DB_NAME', "ideone"); // database name
define('DB_USER', "root"); // user name
define('DB_PASS', ""); // password

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die("<div class='msgBox1'>MySQL Error: Oops! UNABLE to CONNECT to the DATABASE!</div>");
mysqli_select_db($conn, DB_NAME) or die("<div class='msgBox1'>MYSQL ERROR: Oops! Database access FAILED!</div>");
mysqli_set_charset($conn, 'utf8') or die("<div class='msgBox1'>UNABLE to SET database connection ENCODING!</div>");
?>