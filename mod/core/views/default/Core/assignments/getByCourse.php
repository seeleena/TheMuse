<?php
    $assignments = array();
    $assignments = $vars['assignments'];
    
    $jsonAssignments = array();
    foreach($assignments as $number => $assignID) {
        $jsonAssignment = new stdClass();
        $jsonAssignment->number = $number;
        $jsonAssignment->ID = $assignID;
        array_push($jsonAssignments, $jsonAssignment);
    }
    header('Content-Type: application/json');
    //echo json_encode($assignments);
    echo json_encode($jsonAssignments);
?>
