<?php

include 'dbConfig.php';
global $dbCoreLink;
$dbCoreLink = array();

function establish_CoreDB_link($dbCorelinkname) {
    global $dbCoreLink;
    global $dbCONFIG;
    $username = $dbCONFIG->dbusername;
    $password = $dbCONFIG->dbpassword;
    $hostname = $dbCONFIG->dbhost; 
    $db_name = $dbCONFIG->dbname;
    $db_port = $dbCONFIG->dbport;

    $link = new mysqli($hostname, $username, $password, $db_name, $db_port);
    $dbCoreLink[$dbCorelinkname] = $link;
    if ($link->connect_errno) {
        error_log("Failed to connect to MySQL: (" . $link->connect_errno . ") " . $link->connect_error);
    }
}

function get_CoreDB_link($dbCorelinkname) {
	global $dbCoreLink;

	if (isset($dbCoreLink[$dbCorelinkname])) {
		return $dbCoreLink[$dbCorelinkname];
	} else {
		establish_CoreDB_link($dbCorelinkname);
		return get_CoreDB_link($dbCorelinkname);
	}
}

?>
