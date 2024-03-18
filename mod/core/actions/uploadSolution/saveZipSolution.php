<?php

include elgg_get_plugins_path()."Core/lib/fileUpload.php"; 

//system_message("Your file has been uploaded.");

$zipFileGuid = uploadFile('groupSolution');
$assignmentID = get_input('assignID');
$groupID = getGroupID($assignmentID, $userID);

storeFileGuidForGroupSolution($groupID, $assignmentID, $zipFileGuid);
?>
