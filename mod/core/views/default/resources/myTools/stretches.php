<?php 

    // Set the title of the page
    $title = "stretches";

    // Generate the content of the page by rendering the 'Core/myTools/stretches/simple' view
    $content = elgg_view('Core/myTools/stretches/simple', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    echo elgg_view_page($title, $body);

?>