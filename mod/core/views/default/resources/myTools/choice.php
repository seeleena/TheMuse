<?php
    // Include utilities from the Core plugin
    include elgg_get_plugins_path() . "Core/lib/utilities.php";

    // Set the node server address and current instruction ID in session
    $vars['nodeServer'] = "http://localhost:8888";
    $_SESSION['CurrentInstructionID'] = $_GET['instructionID'];

    // Set the tool acronym and tool ID
    $toolAcronym = "choice";
    $vars['toolID'] = 6;

    // Set the title of the page
    $title = "Choice Tool";

    // Get the assignment ID and instruction ID from the GET parameters
    $assignmentID = $_GET['assignID'];
    $instructionID = $_GET['instructionID'];

    // Add the assignment ID and activity ID to the variables array
    $vars['assignmentID'] = $_GET['assignID'];
    $vars['activityID'] = $_GET['activityID'];

    // Get the currently logged in user
    $user = elgg_get_logged_in_user_entity();

    // Get the group ID for the current assignment and user
    $groupID = getGroupID($assignmentID, $user->guid);

    // Add the group ID, instruction ID, session key, and group members to the variables array
    $vars['groupID'] = $groupID;
    $vars['instructionID'] = $instructionID;
    $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
    $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user);

    // Generate the content of the page by rendering the 'Core/myTools/choice/main' view
    // The second argument to elgg_view() is an array of variables to pass to the view
    $content = elgg_view('Core/myTools/choice/main', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    // The second argument to elgg_view_layout() is an array of variables to pass to the layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    // The first argument is the title of the page, and the second argument is the body of the page
    echo elgg_view_page($title, $body);
?>