<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$vars = array();
$studentID = getStudentID();
$vars['studentID'] = $studentID;
$all = getAll($studentID);
$title = "Feedback Dashboard";
$vars['courses'] = $all['courses'];
$vars['feedback'] = $all['feedback'];
$content = elgg_view('Core/myCreativeProcess/feedbackDashboard', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>
