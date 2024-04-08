<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "Assignment Grouping";
$vars = array();
$vars['user'] = elgg_get_logged_in_user_entity();

$vars['courseCodes'] = getCourseCodes();
$vars['assignments'] = getAssignments();

$userEntities = array();
$userEntities = getUserEntities();
$vars['userEntities'] = $userEntities;

$content = elgg_view('Core/assignments/grouping', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>