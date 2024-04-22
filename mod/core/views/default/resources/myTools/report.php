<?php 

        // Include utilities from the Core plugin
        include elgg_get_plugins_path()."Core/lib/utilities.php";

        // Set the node server address and current instruction ID in session
        $vars['nodeServer'] = "http://localhost:8888";
        $_SESSION['CurrentInstructionID'] = $_GET['instructionID'];

        // Set the tool acronym and tool ID
        $toolAcronym = "report";
        $vars['toolID'] = 8;

        // Set the title of the page
        $title = "Report Tool";

        // Get the assignment ID from the GET parameters and add it to the variables array
        $assignmentID = $_GET['assignID'];
        $vars['assignmentID'] = $assignmentID;

        // Get the currently logged in user
        $user = elgg_get_logged_in_user_entity();

        // Get the group ID for the current assignment and user
        $groupID = getGroupID($assignmentID, $user->guid);

        // Add the group ID to the variables array
        $vars['groupID'] = $groupID;

        // Get the activity ID and instruction ID from the GET parameters and add them to the variables array
        $activityID = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['activityID'] = $activityID;
        $vars['instructionID'] = $instructionID;

        // Get the session key and add it to the variables array
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID); 

        // Get the group members and add them to the variables array
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 

        // Get the report URL and add it to the variables array
        $vars['reportURL'] = getReportURL($groupID, $activityID, $instructionID, $assignmentID);

        // Generate the content of the page by rendering the 'Core/myTools/report/main' view
        $content = elgg_view('Core/myTools/report/main', $vars);

        // Add the content to the variables array
        $vars['content'] = $content;

        // Generate the layout of the page by rendering the 'one_sidebar' layout
        $body = elgg_view_layout('one_sidebar', $vars);

        // Output the page by rendering the 'elgg_view_page' view
        echo elgg_view_page($title, $body);

?>