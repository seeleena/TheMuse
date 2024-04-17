<?php 

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "My Creative Process";
$activityID = (string) elgg_extract('activityID', $vars);
$activity = getActivityDetails($activityID); 
$vars['CurrentActivity'] = $activity;
$vars['activityID'] = $activityID;
$vars['activity'] = $activity;
$content = elgg_view('Core/myCreativeProcess/activity', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>