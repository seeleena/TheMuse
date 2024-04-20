<?php 

    // Include utilities from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Set the title of the page
    $title = "Tool Listing";

    // Generate the content of the page by rendering the 'Core/myTools/main' view
    $content = elgg_view('Core/myTools/main', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    echo elgg_view_page($title, $body);

?>