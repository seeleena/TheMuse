<?php
// Include the database connection file
include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 

// Get a connection to the database
$mysqli = get_CoreDB_link("mysqli");

// Get the course code from the input
$course = get_input('courseCode');

// Query the database for the CourseRunID of the course
$res = $mysqli->query("SELECT CourseRunID from courserun WHERE Code='$course' AND IsArchived=0");
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    // Store the CourseRunID
    $courseRunID =  $row['CourseRunID'];
}

// Get the rest of the input data
$courseNumber = get_input('number');
$description = get_input('description');
$instructions = get_input('instructions');
$weighting = get_input('weight');
$domain = get_input('domain');
$qType = get_input('questionType');
$cp = $_POST['creativePedagogy'];

// Check if the CourseRunID is empty
if (empty($courseRunID)) {
    // If it is, return an error
    return elgg_error_response(elgg_echo("Course is not running."));
}

// Check if any of the other input data is empty
if (empty($courseNumber) || empty($description) || empty($instructions) || empty($weighting) || empty($domain) || empty($qType) || empty($cp)) {
    // If any are, return an error
    return elgg_error_response(elgg_echo("All fields are required."));
}

// Prepare a select statement to check if the course number is already assigned
$select_statement = $mysqli->prepare("SELECT * FROM assignment WHERE Number = ? AND CourseRunID = ?");
$select_statement->bind_param('si', $courseNumber, $courseRunID);
$select_statement->execute();
$result = $select_statement->get_result();

// Check if the course number is already assigned
if ($result->num_rows > 0) {
    // If it is, return an error
    return elgg_error_response(elgg_echo("Error: Course Number " . $courseNumber . " already assigned to Course " . $course));
} else {
    // If it's not, prepare an insert statement to add the assignment
    $insert_statement = $mysqli->prepare("INSERT INTO assignment(Number, Description, Instructions, Weight, 
                        CourseRunID, Domain, QuestionTypeID, CreativePedagogyID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_statement->bind_param('isssisii', $courseNumber, $description, $instructions, $weighting, $courseRunID, $domain, $qType, $cp);
    $insert_statement->execute();
    $insert_statement->close();
}

// Close the select statement
$select_statement->close();

// Return a success message
return elgg_ok_response('', elgg_echo('Assignment ' . $courseNumber . ' has been added for ' . $course), null);
?>
