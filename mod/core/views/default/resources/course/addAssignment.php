<?php
$title = "Add a Task / Assignment";
$vars = array();

$content = elgg_view('Core/course/addAssignment', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);

?>