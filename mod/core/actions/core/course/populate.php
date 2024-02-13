<?php
//include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
$mysqli = get_CoreDB_link("mysqli");

$course = get_input('courseCode');
$students = array();
$students = get_input('studentList');

$res = $mysqli->query("SELECT CourseRunID from courserun WHERE Code='$course' AND IsArchived=0");
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    $courseRunID =  $row['CourseRunID'];
}

error_log($courseRunID);

$insert_statement = $mysqli->prepare("INSERT INTO courselist(Student_ID, CourseRunID) VALUES (?, ?)");
$count = count($students);

for($i = 0; $i < $count; $i++) {
    $id = $students[$i];
    $insert_statement->bind_param('si', $id, $courseRunID);
    $insert_statement->execute();
}
$insert_statement->close();
?>
