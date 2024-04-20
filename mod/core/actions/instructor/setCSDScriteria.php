<?php
// Get the assignment ID from the input
$assignID = get_input('assignID');

// Initialize arrays to hold the criteria and headings
$criteriaArray = array();
$headingArray = array();

// Loop through each item in the POST data
foreach ($_POST as $key => $value) {
    // If the key starts with "H", it's a heading
    if (startsWith($key, "H")) {
        // Add the value to the heading array, using the rest of the key as the index
        $headingArray[substr($key, 1)] = $value;
    }
    // If the key starts with "c", it's a criterion
    else if (startsWith($key, "c")) {
        // Add the value to the criteria array, using the rest of the key as the index
        $criteriaArray[substr($key, 1)] = $value;
    }
}

// Save the criteria and heading weights to the database
saveCriteriaWeights($assignID, $criteriaArray);
saveHeadingWeights($assignID, $headingArray);

// Construct the return URL
$returnURL = "/Core/grading/csdsReturn/" . $groupID."/".$total;

// Redirect to the return URL
forward($returnURL);
?>
