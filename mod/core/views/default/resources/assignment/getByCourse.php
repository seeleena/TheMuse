<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";


$coursecode = (string) elgg_extract('courseCode', $vars);
$title = "Assignments for ".$coursecode;
$vars = array();
$assignments = array();
$assignments = getAssignmentsByCourseCode($coursecode);
$vars['assignments'] = $assignments;    
$vars['course'] = getCourseRunByID($coursecode);
$content = elgg_view('Core/assignments/getByCourse', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>