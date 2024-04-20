<?php
// Declare $dbCONFIG as a global variable
global $dbCONFIG;

// Check if $dbCONFIG is not set
if (!isset($dbCONFIG)) {
    // If it's not, initialize it as a new stdClass object
    $dbCONFIG = new stdClass;
}

// Set the database username
$dbCONFIG->dbusername = 'muse';

// Set the database password
$dbCONFIG->dbpassword = '';

// Set the database name
$dbCONFIG->dbname = 'workshop1'; 

// Set the database host
$dbCONFIG->dbhost = 'localhost';

// Set the database port
$dbCONFIG->dbport = 3306;

?>