<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "Student Feedback";
$vars['creativityFactors'] = $creativityFactors;
$content = elgg_view('Core/myCreativeProcess/feedbackDashboard', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>
