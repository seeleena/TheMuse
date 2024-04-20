<?php
        // Include utilities from the Core plugin
        include elgg_get_plugins_path() . "Core/lib/utilities.php";

        // Extract the course code from the $vars array
        $vars['courseCode'] = (string) elgg_extract('code', $vars);
        $courseCode = $vars['courseCode'];

        // Get the assignments for the course with the extracted course code
        $vars['assignments'] = getAssignmentsByCourseCode($courseCode);

        // Generate the content of the page by rendering the 'Core/assignments/getByCourse' view
        // The second argument to elgg_view() is an array of variables to pass to the view
        $content = elgg_view('Core/assignments/getByCourse', $vars);

        // Output the content
        echo $content;
?>