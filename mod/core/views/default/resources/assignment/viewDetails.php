<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "Assignment Details";
$id = (string) elgg_extract('assignID', $vars);
$vars = array();
$details = array();
$details = getAssignmentDetails($id);
$vars['details'] = $details;
//$vars['course']= getCourseRunByID($details->courseRunID);
$content = elgg_view('Core/assignments/viewDetails', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>