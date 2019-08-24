<?php

/*
$db['db_host'] = "localhost";
$db['db_host'] = "localhost";
$db['db_host'] = "localhost";
$db['db_host'] = "localhost";
*/

/* For more secure:
 * Collecting connection data into array and converting it to constants, uppercase.
*/
$db = [
    "db_host" => 'localhost',
    "db_user" => 'root',
    "db_pass" => '',
    "db_name" => 'cms'
];

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

/* Actual connection HERE */
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$connection) {
    die("Database connection failed.");
}



?>