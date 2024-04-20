<?php
    // Include utilities from the Core plugin
    include elgg_get_plugins_path() . "Core/lib/utilities.php";

    // Initialize an array to hold variables
    $vars = array();

    // Get the student ID and add it to the variables array
    $studentID = getStudentID();
    $vars['studentID'] = $studentID;

    // Get all courses and assignments for the student and add them to the variables array
    $all = getAll($studentID);
    $vars['courses'] = $all['courses'];
    $vars['assignments'] = $all['assignments'];

    // Set the title of the page
    $title = "Assignment Listing";

    // Generate the content of the page by rendering the 'Core/student/assignmentListing' view
    // The second argument to elgg_view() is an array of variables to pass to the view
    $content = elgg_view('Core/student/assignmentListing', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    // The second argument to elgg_view_layout() is an array of variables to pass to the layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    // The first argument is the title of the page, and the second argument is the body of the page
    echo elgg_view_page($title, $body);
?>