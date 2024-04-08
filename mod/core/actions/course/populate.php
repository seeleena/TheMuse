<?php
include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
$mysqli = get_CoreDB_link("mysqli");

$course = get_input('courseCode');
$students = array();
$students = get_input('studentList');

if (empty($course) ) {
    return elgg_error_response(elgg_echo("No course is seleceted."));
}

if (empty($students)) {
    return elgg_error_response(elgg_echo("No students are selected."));
}

$res = $mysqli->query("SELECT CourseRunID from courserun WHERE Code='$course' AND IsArchived=0");
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    $courseRunID =  $row['CourseRunID'];
}

if (empty($courseRunID)) {
    return elgg_error_response(elgg_echo("Course is not running."));
}

$insert_statement = $mysqli->prepare("INSERT INTO courselist(Student_ID, CourseRunID) VALUES (?, ?)");
$select_statement = $mysqli->prepare("SELECT * FROM courselist WHERE Student_ID = ? AND CourseRunID = ?");
$count = count($students);

$errors = array();

for($i = 0; $i < $count; $i++) {
    $id = $students[$i];
    $select_statement->bind_param('si', $id, $courseRunID);
    $select_statement->execute();
    $result = $select_statement->get_result();
    if ($result->num_rows > 0) {
        elgg_error_response(elgg_echo($id . " already enrolled."));
        continue;
    }
    $insert_statement->bind_param('si', $id, $courseRunID);
    $insert_statement->execute();
    elgg_ok_response('', elgg_echo($id . ' has been enrolled'), null);
}
$insert_statement->close();
$select_statement->close();
?>

