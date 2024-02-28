<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "Assignment Details";
$id = (string) elgg_extract('assignmentParameter', $vars);
$id = var_dump(filter_var($number, FILTER_SANITIZE_NUMBER_INT));
$vars = array();
$details = array();
$details = getAssignmentDetails($id);
$vars['details'] = $details;
$content = elgg_view('Core/assignments/viewDetails', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>