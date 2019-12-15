<?php

/* For more secure:
 * Collecting connection data into array and converting it to constants, uppercase.
*/

/* For LOCAL CON */
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
//    die("Database connection failed.");
//}

////////////////////

    /* For more secure:
     * Collecting connection data into array and converting it to constants, uppercase.
    */

    /* For GLOBAL CON */
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);

    /* Actual connection HERE */
    $connection = new mysqli($server, $username, $password, $db);
    foreach ($db as $key => $value) {
        define(strtoupper($key), $value);
    }
    if (!$connection) {
        die("Database connection failed.");
    }
}

?>