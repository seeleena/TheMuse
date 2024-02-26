<?php
$title = "Details Menu";
$vars = array();

$content = elgg_view('Core/assignments/viewDetails', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);

?>