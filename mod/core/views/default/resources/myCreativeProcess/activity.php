<?php 

include elgg_get_plugins_path()."Core/lib/utilities.php";// Enables calling of functions from utilities

$title = "My Creative Process";// Page Title declaration
$activityID = (string) elgg_extract('activityID', $vars);// Obtains the ID called for in the elgg-plugin.php url
$activity = getActivityDetails($activityID);// Stores all the details associated with that activity's ID in an activity variable 
//Stores all extracted information in an array
$vars['CurrentActivity'] = $activity;
$vars['activityID'] = $activityID;
$vars['activity'] = $activity;
$content = elgg_view('Core/myCreativeProcess/activity', $vars);// Stores the page view 
$vars['content'] = $content;//Puts view into an array
$body = elgg_view_layout('one_sidebar', $vars);//Stores content with layout
echo elgg_view_page($title, $body);//Displays content stored along with Title
?>
