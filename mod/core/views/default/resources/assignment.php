<?php

$title = "Assignment Listing";
$vars = array();

$content = elgg_view('Core/student/assignmentListing', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>
