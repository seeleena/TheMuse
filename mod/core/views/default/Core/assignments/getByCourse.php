<?php
    // Initialize an array to store assignments
    $assignments = array();
    // Get the assignments from the passed variables
    $assignments = $vars['assignments'];
    
    // Initialize an array to store the assignments in JSON format
    $jsonAssignments = array();
    // Loop through each assignment
    foreach($assignments as $number => $assignID) {
        // Create a new stdClass object to store the assignment data
        $jsonAssignment = new stdClass();
        // Set the number and ID of the assignment
        $jsonAssignment->number = $number;
        $jsonAssignment->ID = $assignID;
        // Add the assignment to the array of JSON assignments
        array_push($jsonAssignments, $jsonAssignment);
    }
    // Set the content type of the response to JSON
    header('Content-Type: application/json');
    // Encode the array of JSON assignments as a JSON string and echo it
    echo json_encode($jsonAssignments);
?>