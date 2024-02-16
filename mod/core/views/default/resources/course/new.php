<?php
$title = "Add a course";
$vars = array();

$content = elgg_view('Core/course/new', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);

?>
