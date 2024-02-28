<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$vars = array();
$vars['domain'] = $assignmentParameter;
$vars['questionTypes'] = getQuestionTypesByCourseCode($vars['domain']); 
$content = elgg_view('Core/assignments/getQuestionTypeByDomain', $vars);
echo $content; 

?>