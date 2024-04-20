<?php
// Return an error if no instructions were added
if (empty($instructions)) {
    return elgg_error_response(elgg_echo("Please add at least one instruction."));
}

// Get the tool names, URLs, and IDs from the input
$toolNames = get_input('toolNames');
$toolURLs = get_input('toolURLs');
$tools = get_input('tools');

// Return an error if no new or existing tools were added
if (empty($toolNames) && empty($tools)) {
    return elgg_error_response(elgg_echo("Please add a new tool or an existing tool."));
}

// Return an error if a new tool was added but no URL was provided
if (!empty($toolNames) && empty($toolURLs)) {
    return elgg_error_response(elgg_echo("Please add a URL for each tool."));
}

// Add the student-added activity and get its ID
$aID = addStudentAddedActivity($activityID, $stageNum, $cpID, $activityTitle, $activityDesc);

// If the activity ID is empty, return an error
if (empty($aID)) {
    return elgg_error_response(elgg_echo("Error Adding activity."));
} else {
    // If the activity was added successfully, return a success message
    elgg_ok_response('', elgg_echo("Activity Added Successfully."), null);
}

// Add each instruction to the activity
foreach ($instructions as $value) {
    addStudentAddedInstruction($aID, $value);
}
// Return a success message for adding instructions
elgg_ok_response('', elgg_echo("Instructions Added Successfully."), null);

// Loop through each tool
for($i = 0; $i < count($toolNames); $i++) {
    // If the tool is a new tool, add it with the provided name and URL
    if(strcmp($tools[$i], "Select a Tool") == 0) {
        addStudentAddedTool($aID, $toolURLs[$i], $toolNames[$i]);
    }
    // If the tool is an existing tool, get its name and URL and add it
    else if(strcmp($tools[$i], "Select a Tool") !== 0){
        $url = getToolURL($tools[$i]);
        $name = getToolName($tools[$i]);
        addStudentAddedTool($aID, $url, $name);
    }
}
// Return a success message for adding tools
elgg_ok_response('', elgg_echo("Tools Added Successfully."), null);

// Construct the return URL
$returnURL = "/Core/myCreativeProcess/owner/".$userID."?assignID=".$assignID;

// Redirect to the return URL
header("Location: " . $returnURL);
?>