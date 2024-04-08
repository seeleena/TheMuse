<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";


        $vars['courseCode'] = (string) elgg_extract('code', $vars);
        $courseCode = $vars['courseCode'];
        $vars['assignments'] = getAssignmentsByCourseCode($courseCode); 
        $content = elgg_view('Core/assignments/getByCourse', $vars);
        echo $content; 
?>