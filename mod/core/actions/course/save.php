<?php
// Include the database connection file
include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 

// Get a connection to the database
$mysqli = get_CoreDB_link("mysqli");

// Check if the connection was successful
if ($mysqli->connect_errno) {
    // If it wasn't, print an error message
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// Get the course code, title, and credits from the input
$courseCode = get_input('code');
$courseTitle = get_input('title');
$courseCredits = get_input('credits');

// Check if the course code or title is empty, or if the course credits is not a positive number
if (empty($courseCode) || empty($courseTitle) || (!is_numeric($courseCredits) || $courseCredits < 0)) {
    // If any of these conditions are true, return an error
    return elgg_error_response(elgg_echo("All fields are required and course credits must be a positive number."));
} else {
    // If all fields are valid, prepare an insert statement to add the course to the database
    $insert_statement = $mysqli->prepare("INSERT INTO course(Code, Title, Credits) VALUES (?, ?, ?)");
    
    // Bind the course code, title, and credits to the insert statement and execute it
    $insert_statement->bind_param('ssi', $courseCode, $courseTitle, $courseCredits);
    $insert_statement->execute();
    
    // Close the insert statement
    $insert_statement->close();
}

// Return a success message
return elgg_ok_response('', elgg_echo($courseCode . ' has been saved'), null);

?>