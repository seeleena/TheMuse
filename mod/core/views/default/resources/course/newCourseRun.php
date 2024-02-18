<?php
$title = "Add a Course Run";
$vars = array();
$content = elgg_view('Core/course/newCourseRun', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>