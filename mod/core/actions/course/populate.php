<?php
// Include the database connection file
include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 

// Get a connection to the database
$mysqli = get_CoreDB_link("mysqli");

// Get the course code and student list from the input
$course = get_input('courseCode');
$students = array();
$students = get_input('studentList');

// Check if the course code is empty
if (empty($course) ) {
    // If it is, return an error
    return elgg_error_response(elgg_echo("No course is selected."));
}

// Check if the student list is empty
if (empty($students)) {
    // If it is, return an error
    return elgg_error_response(elgg_echo("No students are selected."));
}

// Query the database for the CourseRunID of the course
$res = $mysqli->query("SELECT CourseRunID from courserun WHERE Code='$course' AND IsArchived=0");
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    // Store the CourseRunID
    $courseRunID =  $row['CourseRunID'];
}

// Check if the CourseRunID is empty
if (empty($courseRunID)) {
    // If it is, return an error
    return elgg_error_response(elgg_echo("Course is not running."));
}

// Prepare an insert statement to add the student to the course list
$insert_statement = $mysqli->prepare("INSERT INTO courselist(Student_ID, CourseRunID) VALUES (?, ?)");

// Prepare a select statement to check if the student is already enrolled
$select_statement = $mysqli->prepare("SELECT * FROM courselist WHERE Student_ID = ? AND CourseRunID = ?");

// Get the number of students
$count = count($students);

// Initialize an array to store errors
$errors = array();

// Loop through the students
for($i = 0; $i < $count; $i++) {
    // Get the student ID
    $id = $students[$i];

    // Bind the student ID and CourseRunID to the select statement and execute it
    $select_statement->bind_param('si', $id, $courseRunID);
    $select_statement->execute();
    $result = $select_statement->get_result();

    // Check if the student is already enrolled
    if ($result->num_rows > 0) {
        // If they are, return an error and continue to the next student
        elgg_error_response(elgg_echo($id . " already enrolled."));
        continue;
    }

    // Bind the student ID and CourseRunID to the insert statement and execute it
    $insert_statement->bind_param('si', $id, $courseRunID);
    $insert_statement->execute();

    // Return a success message
    elgg_ok_response('', elgg_echo($id . ' has been enrolled'), null);
}

// Close the insert and select statements
$insert_statement->close();
$select_statement->close();
?>