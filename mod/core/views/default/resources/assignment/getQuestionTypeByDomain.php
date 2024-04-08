<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

        $vars['domain'] = (string) elgg_extract('domain', $vars, '');
        $vars['questionTypes'] = getQuestionTypesByCourseCode($vars['domain']); 
        $content = elgg_view('Core/assignments/getQuestionTypeByDomain', $vars);
        echo $content; 
?>