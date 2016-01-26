<?php

/**
 * SCRIPT TO CREATE APP DATABASE AND NECESSARY TABLE.
 */

//-- simple path defining for root:
define('BASE_PATH', dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR);

//-- simple path defining for config:
define('CONFIG_PATH', BASE_PATH . '..' . DIRECTORY_SEPARATOR . 'config');

//-- db params:
$params = parse_ini_file(CONFIG_PATH . DIRECTORY_SEPARATOR . "env.ini");

//-- create db connection:
$conn = new mysqli($params['DB_HOST'], $params['DB_USERNAME'], $params['DB_PASSWORD']);

//-- Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Database Successfully Connected!";
echo "<br/><br/>";

//- try to set current app database:
$db_selected = mysqli_select_db($conn, $params['DB_DATABASE']);

//-- check if sucessfully connected.
if (!$db_selected) {

    //-- case db not exists, create it:
    if (mysqli_error($conn) == "Unknown database '" . $params['DB_DATABASE'] . "'") {
        
        //-- create:
        $conn->query("Create DATABASE " . $params['DB_DATABASE'] . " DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;");

        //-- now set it for sure:
        mysqli_select_db($conn, $params['DB_DATABASE']);
        echo "Database " . $params['DB_DATABASE'] . " successfully created!";
        echo "<br/>";

        //-- case other error, show it:
    } else {
        die('Cannot use db : ' . mysqli_error($conn));
    }
}

echo "Current database setted to '" . $params['DB_DATABASE'] . "'";
echo "<br/>";

//-- query to create users table:
$queryCreateUsersTable = "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `email` varchar(50) NOT NULL,
    `password` varchar(100) NOT NULL,
    `salt` varchar(30) NOT NULL,
    `first_name` varchar(20) NOT NULL,
    `last_name` varchar(20) NOT NULL,
    `address` varchar(80) NULL DEFAULT NULL,
    `zip_code` varchar(15) NULL DEFAULT NULL,
    `zone` varchar(80) NULL DEFAULT NULL,
    `country` varchar(5) NULL DEFAULT NULL,
    `vat` int(9) NULL DEFAULT NULL,
    `phone` varchar(15) NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email_key` (`email`)
)";

//-- create users table:
if (!$conn->query($queryCreateUsersTable)) {
    die('Table creation failed: (' . $conn->errno . ') ' . $conn->error);
}

//-- DONE!
echo "'users' table ready on " . $params['DB_DATABASE'] . "' database.";
echo "<br/><br/>";
echo "APP ready!!!";
echo "<br/>";
echo "Go to exercise page <a href='/index.php?controller=register&action=index'>HERE</a>";
