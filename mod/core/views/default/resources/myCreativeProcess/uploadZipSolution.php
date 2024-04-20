<?php

    // Include utilities from the Core plugin
    include elgg_get_plugins_path() . "Core/lib/utilities.php";

    // Set the title of the page
    $title = "My Creative Process";

    // Initialize an array to hold variables
    $vars = array();

    // Extract the assignment ID from the $vars array
    $assignID = (string) elgg_extract('assignID', $vars);

    // Get the currently logged in user
    $user = elgg_get_logged_in_user_entity();

    // Add the user ID and assignment ID to the variables array
    $vars['userID'] = $user->guid;
    $vars['assignID'] = $assignID;

    // Generate the content of the page by rendering the 'Core/myCreativeProcess/uploadZipSolution' view
    // The second argument to elgg_view() is an array of variables to pass to the view
    $content = elgg_view('Core/myCreativeProcess/uploadZipSolution', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    // The second argument to elgg_view_layout() is an array of variables to pass to the layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    // The first argument is the title of the page, and the second argument is the body of the page
    echo elgg_view_page($title, $body);
?>

