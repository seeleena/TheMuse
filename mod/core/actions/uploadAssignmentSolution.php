<?php
    // Include the file upload and utilities files from the Core plugin
    include elgg_get_plugins_path()."Core/lib/fileUpload.php"; 
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Upload the file and get the file GUID
    $zipFileGuid = uploadFile('groupSolution');
    // Get the assignment ID and group ID
    $assignmentID = get_input('assignID');
    $groupID = getGroupID($assignmentID, $userID);

    // If the assignment ID or group ID is empty, return an error
    if (empty($assignmentID) || empty($groupID)) {
        return elgg_error_response(elgg_echo("You are not a part of an assignment or group."));
    }

    // Store the file GUID for the group solution
    storeFileGuidForGroupSolution($groupID, $assignmentID, $zipFileGuid);

    // Return an OK response
    return elgg_ok_response('', elgg_echo("Your Solution file has been uploaded."), null);
?>