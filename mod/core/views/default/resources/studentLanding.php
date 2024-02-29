<?php

$title = "Student Menu";
$vars = array();

$content = elgg_view('Core/student/landing', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
elgg_extend_view('Core/student/landing', 'Core/myCss/custom');
echo elgg_view_page($title, $body);
?>
