<?php

// Include the database configuration file
include 'dbConfig.php';

// Declare a global array to store database connections
global $dbCoreLink;
$dbCoreLink = array();

// Define a function to establish a connection to the CoreDB
function establish_CoreDB_link($dbCorelinkname) {
    // Access the global variables
    global $dbCoreLink;
    global $dbCONFIG;

    // Get the database credentials from the configuration
    $username = $dbCONFIG->dbusername;
    $password = $dbCONFIG->dbpassword;
    $hostname = $dbCONFIG->dbhost; 
    $db_name = $dbCONFIG->dbname;
    $db_port = $dbCONFIG->dbport;

    // Create a new mysqli object and connect to the database
    $link = new mysqli($hostname, $username, $password, $db_name, $db_port);

    // Store the connection in the global array
    $dbCoreLink[$dbCorelinkname] = $link;

    // If there was an error connecting to the database, log the error
    if ($link->connect_errno) {
        error_log("Failed to connect to MySQL: (" . $link->connect_errno . ") " . $link->connect_error);
    }
}

// Define a function to get a connection to the CoreDB
function get_CoreDB_link($dbCorelinkname) {
    // Access the global array
    global $dbCoreLink;

    // If a connection already exists for the given name, return it
    if (isset($dbCoreLink[$dbCorelinkname])) {
        return $dbCoreLink[$dbCorelinkname];
    } else {
        // Otherwise, establish a new connection and return it
        establish_CoreDB_link($dbCorelinkname);
        return get_CoreDB_link($dbCorelinkname);
    }
}

?>