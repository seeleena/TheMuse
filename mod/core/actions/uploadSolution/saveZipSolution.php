<?php

include elgg_get_plugins_path()."Core/lib/fileUpload.php"; 
include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
$mysqli = get_CoreDB_link("mysqli");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

system_message("Your file has been uploaded.");

$zipFileGuid = uploadFile('groupSolution');
$assignmentID = get_input('assignID');
$groupID = getGroupID($assignmentID, $userID);

storeFileGuidForGroupSolution($groupID, $assignmentID, $zipFileGuid);
?>
