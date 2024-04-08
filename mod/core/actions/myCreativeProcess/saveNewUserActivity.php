<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$activityID = get_input('aID');
$assignID= get_input('assignID');
$userID = get_input('userID');
$cpID = get_input('cpID');
$stageNum = get_input('stageNum');

if (empty($activityID) || empty($assignID) || empty($userID) || empty($cpID) || empty($stageNum)) {
    $url = getServerURL() . "Core/myCreativeProcess/home";
    elgg_error_response(elgg_echo("Session Error."));
    return die('<meta http-equiv="refresh" content="0; url=' . $url . '" />');
} 

$activityTitle = get_input('activityTitle');
$activityDesc = get_input('activityDesc');
if (empty($activityTitle) || empty($activityDesc)) {
    return elgg_error_response(elgg_echo("All fields are required."));
}

$instructions = get_input('instructions');
if (empty($instructions)) {
    return elgg_error_response(elgg_echo("Please add at least one instruction."));
}



$toolNames = get_input('toolNames');

$toolURLs = get_input('toolURLs');

$tools = get_input('tools');

if (empty($toolNames) && empty($tools)) {
    return elgg_error_response(elgg_echo("Please add a new tool or an existing tool."));
}

if (!empty($toolNames) && empty($toolURLs)) {
    return elgg_error_response(elgg_echo("Please add a URL for each tool."));
}



$aID = addStudentAddedActivity($activityID, $stageNum, $cpID, $activityTitle, $activityDesc);
if (empty($aID)) {
    return elgg_error_response(elgg_echo("Error Adding activity."));
} else {
    elgg_ok_response('', elgg_echo("Activity Added Successfully."), null);
}

foreach ($instructions as $value) {
    addStudentAddedInstruction($aID, $value);
}
elgg_ok_response('', elgg_echo("Instructions Added Successfully."), null);

for($i = 0; $i < count($toolNames); $i++) {
    if(strcmp($tools[$i], "Select a Tool") == 0) {
        addStudentAddedTool($aID, $toolURLs[$i], $toolNames[$i]);
    }
    else if(strcmp($tools[$i], "Select a Tool") !== 0){
        $url = getToolURL($tools[$i]);
        $name = getToolName($tools[$i]);
        addStudentAddedTool($aID, $url, $name);
    }
}
elgg_ok_response('', elgg_echo("Tools Added Successfully."), null);

$returnURL = "/Core/myCreativeProcess/owner/".$userID."?assignID=".$assignID;
header("Location: " . $returnURL);
?>
