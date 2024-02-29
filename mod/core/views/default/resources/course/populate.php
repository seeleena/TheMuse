<?php
$title = "Populate Course";
$vars = array();
$content = elgg_view('Core/course/populate', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);

?>