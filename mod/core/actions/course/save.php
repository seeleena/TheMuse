<?php

//include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
$mysqli = get_CoreDB_link("mysqli");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$courseCode = get_input('code');
$courseTitle = get_input('title');
$courseCredits = get_input('credits');

if (empty($courseCode) || empty($courseTitle) || (!is_numeric($courseCredits) || $courseCredits < 0)) {
	register_error("Please enter Course Code, Title and Credits.");
	forward();
}

$insert_statement = $mysqli->prepare("INSERT INTO course(Code, Title, Credits) VALUES (?, ?, ?)");
$insert_statement->bind_param('ssi', $courseCode, $courseTitle, $courseCredits);
$insert_statement->execute();
$insert_statement->close();

?>
