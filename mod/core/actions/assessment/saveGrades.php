<?php
$mysqli = get_CoreDB_link("mysqli");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$assignmentScore = get_input('assignmentScore');
$creativeAssignmentScore = get_input('creativeAssignmentScore');
$creativeProcessScore = get_input('creativeProcessScore');
$elggGroupID = get_input('elggGroupID');
$assignmentID = get_input('assignmentID');

$scores = array();
$scores = get_input('scores');
foreach ($scores as $studentScore) {
    
    for($i = 0; $i < count($studentScore); $i = $i+2) {
        $insert_statement = $mysqli->prepare("INSERT INTO studentscore(StudentELGG_ID, AssignmentID, CreativeProcessScore, CreativeSolutionScore, AssignmentScore) VALUES (?, ?, ?, ?, ?)");
        $studentID = $studentScore['studentID'];
        $creativeProcessScore = $studentScore['score'];
        //error_log("$creativeProcessScore and $creativeAssignmentScore and $assignmentScore\n");
        //$finalScore = $creativeProcessScore + $assignmentScore;
        $insert_statement->bind_param('iiiii', $studentID, $assignmentID, $creativeProcessScore, $creativeAssignmentScore, $assignmentScore);
        $insert_statement->execute() or die($mysqli->error);
    }
}
$insert_statement->close();

echo "All scores have been saved.";
?>
