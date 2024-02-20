<?php

global $dbCONFIG;
if (!isset($dbCONFIG)) {
	$dbCONFIG = new stdClass;
}

$dbCONFIG->dbusername = 'muse';
$dbCONFIG->dbpassword = '';
$dbCONFIG->dbname = 'workshop1'; //from prod
$dbCONFIG->dbname = 'the_muse_db_v2';
$dbCONFIG->dbhost = 'localhost';
$dbCONFIG->dbport = 3306;

?>
