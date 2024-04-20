<?php
    // Set the title of the page
    $title = "Add A Course";

    // Initialize an array to hold variables
    $vars = array();

    // Generate the content of the page by rendering the 'Core/course/new' view
    // The second argument to elgg_view() is an array of variables to pass to the view
    $content = elgg_view('Core/course/new', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    // The second argument to elgg_view_layout() is an array of variables to pass to the layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    // The first argument is the title of the page, and the second argument is the body of the page
    echo elgg_view_page($title, $body);
?>