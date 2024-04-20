<?php 

        // Include utilities from the Core plugin
        include elgg_get_plugins_path()."Core/lib/utilities.php";

        // Set the node server address and current instruction ID in session
        $vars['nodeServer'] = "http://localhost:8888";
        $_SESSION['CurrentInstructionID'] = $_GET['instructionID'];

        // Set the tool acronym and tool ID
        $toolAcronym = "inAndOut";
        $vars['toolID'] = 7;

        // Set the title of the page
        $title = "In and Out Tool";

        // Get the activity ID, instruction ID, and assignment ID from the GET parameters
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $assignmentID = $_GET['assignID'];

        // Add the assignment ID to the variables array
        $vars['assignmentID'] = $assignmentID;

        // Get the currently logged in user
        $user = elgg_get_logged_in_user_entity();

        // Add the instruction ID to the variables array
        $vars['instructionID'] = $instructionID;

        // Get the group ID for the current assignment and user
        $groupID = getGroupID($assignmentID, $user->guid);

        // Add the group ID, session key, and group members to the variables array
        $vars['groupID'] = $groupID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 

        // Generate the content of the page by rendering the 'Core/myTools/inAndOut/main' view
        $content = elgg_view('Core/myTools/inAndOut/main', $vars);

        // Add the content to the variables array
        $vars['content'] = $content;

        // Generate the layout of the page by rendering the 'one_sidebar' layout
        $body = elgg_view_layout('one_sidebar', $vars);

        // Output the page by rendering the 'elgg_view_page' view
        echo elgg_view_page($title, $body);

?>