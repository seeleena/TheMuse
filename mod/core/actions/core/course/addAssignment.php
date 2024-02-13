<?php
//include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
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

$insert_statement = $mysqli->prepare("INSERT INTO assignment(Number, Description, Instructions, Weight, CourseRunID, Domain, QuestionTypeID, CreativePedagogyID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$insert_statement->bind_param('isssisii', $courseNumber, $description, $instructions, $weighting, $courseRunID, $domain, $qType, $cp);
$insert_statement->execute();
$insert_statement->close();
?>
