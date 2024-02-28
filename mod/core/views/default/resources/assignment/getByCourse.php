<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$vars = array();
$vars['courseCode'] = $assignmentParameter;
$vars['assignments'] = getAssignmentsByCourseCode($vars['courseCode']); 
$content = elgg_view('Core/assignments/getByCourse', $vars);
echo $content; 
?>