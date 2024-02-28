<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$vars = array();
$studentID = getStudentID();
$vars['studentID'] = $studentID; 
$all = getAll($studentID);
$vars['courses'] = $all['courses'];
$vars['assignments'] = $all['assignments'];
$title = "Assignment Listing";
$content = elgg_view('Core/student/assignmentListing', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>