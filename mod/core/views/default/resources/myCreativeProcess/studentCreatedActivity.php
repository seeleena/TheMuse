
<?php
        // Include utilities from the Core plugin
        include elgg_get_plugins_path() . "Core/lib/utilities.php";

        // Set the title of the page
        $title = "My Creative Process";

        // Extract the activity ID from the $vars array
        $aID = (string) elgg_extract('aID', $vars);

        // Get the instructions and tools for the student-created activity
        $instructions = getStudentCreatedInstructions($aID);
        $tools = getStudentCreatedTools($aID);

        // Get the description of the activity
        $description = getActivityDescription($aID);

        // Store the current activity in the session
        $_SESSION['CurrentActivity'] = $activity;

        // Add the instructions, tools, description, and activity ID to the variables array
        $vars['instructions'] = $instructions;
        $vars['tools'] = $tools;
        $vars['description'] = $description;
        $vars['studentCreatedAID'] = $aID;

        // Generate the content of the page by rendering the 'Core/myCreativeProcess/studentCreatedActivity' view
        // The second argument to elgg_view() is an array of variables to pass to the view
        $content = elgg_view('Core/myCreativeProcess/studentCreatedActivity', $vars);

        // Add the content to the variables array
        $vars['content'] = $content;

        // Generate the layout of the page by rendering the 'one_sidebar' layout
        // The second argument to elgg_view_layout() is an array of variables to pass to the layout
        $body = elgg_view_layout('one_sidebar', $vars);

        // Output the page by rendering the 'elgg_view_page' view
        // The first argument is the title of the page, and the second argument is the body of the page
        echo elgg_view_page($title, $body);

?>