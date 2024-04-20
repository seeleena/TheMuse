<?php 

    // Include utilities from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Generate the content of the page by rendering the 'Core/myTools/underConstruction' view
    $content = elgg_view('Core/myTools/underConstruction', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    echo elgg_view_page($title, $body);

?>