<?php
    // Include utilities from the Core plugin
    include elgg_get_plugins_path() . "Core/lib/utilities.php";

    // Set the node server address and current instruction ID in session
    $vars['nodeServer'] = "http://localhost:8888";
    $_SESSION['CurrentInstructionID'] = $_GET['instructionID'];

    // Set tool details and page title
    $toolAcronym = "cf";
    $vars['toolID'] = 3;
    $title = "Concept Fan Tool";

    // Retrieve assignment ID, activity ID, instruction ID, and stage number from GET parameters
    $assignmentID = $_GET['assignID'];
    $vars['activityID'] = $_GET['activityID'];
    $instructionID = $_GET['instructionID'];
    $vars['stageNum'] = $_GET['stageNum'];

    // Get the currently logged in user and the group ID for the current assignment and user
    $user = elgg_get_logged_in_user_entity();
    $groupID = getGroupID($assignmentID, $user->guid);

    // Add necessary data to the variables array
    $vars['assignmentID'] = $assignmentID;
    $vars['groupID'] = $groupID;
    $vars['instructionID'] = $instructionID;
    $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
    $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user);

    // Generate the content of the page by rendering the 'Core/myTools/conceptFan/main' view
    $content = elgg_view('Core/myTools/conceptFan/main', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;
?>