<?php
$title = "Course Assignments";
$vars = array();

$content = elgg_view('Core/assignments/getByCourse', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);

?>
