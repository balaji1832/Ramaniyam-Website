<?php
// Error Reporting Turn On
ini_set('error_reporting', 0);

// Setting up the time zone
date_default_timezone_set('Asia/Dubai');


// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'ramaniyamnewayat_dbase';

// Database Username
$dbuser = 'root';
// $dbuser = 'ramaniyamnewayat_user';

// Database Password
$dbpass = '';      
// $dbpass = '=AX;D=Mlq5IG';      

// Defining base url
define("BASE_URL", "https://ramaniyamnew.ayatiworks.com");

// Getting Admin url
define("ADMIN_URL", BASE_URL . "admin" . "/");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}