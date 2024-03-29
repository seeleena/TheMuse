<?php
include elgg_get_plugins_path()."Core/lib/utilities.php";
$title = "My Creative Process";
$activityID = (string) elgg_extract('A_ID', $vars);
$arr=array();
$vars = array();
$activity = array();
$activity = getActivityDetails($activityID); 
$vars['CurrentActivity'] = $activity;
$vars['activity'] = $activity;
$vars['owner'] = elgg_get_page_owner_entity();
$content = elgg_view('Core/myCreativeProcess/activity', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>
