<?php

$title = "Student Menu";//Page header
$vars = array();

$content = elgg_view('Core/student/landing', $vars);// Calls the student landing view and stores it into content variable
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);// puts content into a layout and body variable
echo elgg_view_page($title, $body);// displays heading and content of page
?>
