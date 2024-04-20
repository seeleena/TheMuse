<?php
        // Include utilities from the Core plugin
        include elgg_get_plugins_path() . "Core/lib/utilities.php";

        // Extract the domain from the $vars array
        $vars['domain'] = (string) elgg_extract('domain', $vars, '');

        // Get the question types for the course with the extracted domain
        $vars['questionTypes'] = getQuestionTypesByCourseCode($vars['domain']);

        // Generate the content of the page by rendering the 'Core/assignments/getQuestionTypeByDomain' view
        // The second argument to elgg_view() is an array of variables to pass to the view
        $content = elgg_view('Core/assignments/getQuestionTypeByDomain', $vars);

        // Output the content
        echo $content;
?>