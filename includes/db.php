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

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

/* Actual connection HERE */
$connection = new mysqli($server, $username, $password, $db);
foreach($db as $key => $value){
    define(strtoupper($key), $value);
}
if(!$connection) {
    die("Database connection failed.");
}

?>