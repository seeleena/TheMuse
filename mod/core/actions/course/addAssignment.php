<?php
include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
$mysqli = get_CoreDB_link("mysqli");

$course = get_input('courseCode');
$res = $mysqli->query("SELECT CourseRunID from courserun WHERE Code='$course' AND IsArchived=0");
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    $courseRunID =  $row['CourseRunID'];
}

$courseNumber = get_input('number');
$description = get_input('description');
$instructions = get_input('instructions');
$weighting = get_input('weight');
$domain = get_input('domain');
$qType = get_input('questionType');
$cp = $_POST['creativePedagogy'];

if (empty($courseRunID)) {
    return elgg_error_response(elgg_echo("Course is not running."));
}

if (empty($courseNumber) || empty($description) || empty($instructions) || empty($weighting) || empty($domain) || empty($qType) || empty($cp)) {
    return elgg_error_response(elgg_echo("All fields are required."));
}

$select_statement = $mysqli->prepare("SELECT * FROM assignment WHERE Number = ? AND CourseRunID = ?");
$select_statement->bind_param('si', $courseNumber, $courseRunID);
$select_statement->execute();
$result = $select_statement->get_result();
if ($result->num_rows > 0) {
    return elgg_error_response(elgg_echo("Error: Course Number " . $courseNumber . " already assigned to Course " . $course));
} else {
    $insert_statement = $mysqli->prepare("INSERT INTO assignment(Number, Description, Instructions, Weight, CourseRunID, Domain, QuestionTypeID, CreativePedagogyID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_statement->bind_param('isssisii', $courseNumber, $description, $instructions, $weighting, $courseRunID, $domain, $qType, $cp);
    $insert_statement->execute();
    $insert_statement->close();
}
$select_statement->close();
return elgg_ok_response('', elgg_echo('Assignment ' . $courseNumber . ' has been added for ' . $course), null);
?>
