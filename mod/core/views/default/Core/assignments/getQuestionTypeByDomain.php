<?php
    // Initialize an array to store question types
    $questionTypes = array();
    // Get the question types from the passed variables
    $questionTypes = $vars['questionTypes'];
    // Set the content type of the response to JSON
    header('Content-Type: application/json');
    // Encode the array of question types as a JSON string and echo it
    echo json_encode($questionTypes);
?>