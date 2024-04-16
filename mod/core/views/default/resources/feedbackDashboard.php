<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "Student Feedback";

$vars = array();
$currentUser = elgg_get_logged_in_user_entity();    #gets the logged in user
$studentELGGID = $currentUser->guid;   #gets the id for the student from the logged in user entity
$assignmentID = 1;
$vars['creativityFactors'] = getCreativityFactors($assigmentID, $currentUser, $studentELGGID);   #calls the function to get the creativity factors and puts it in the array
$content = elgg_view('Core/myCreativeProcess/feedbackDashboard', $vars);  #passes the array and gets the appropriate view form, then loads into content variable
$vars['content'] = $content;       # content object is appended to the vars array
$body = elgg_view_layout('one_sidebar', $vars);   #Calls the view layout and passes the vars variable 
echo elgg_view_page($title, $body);
?>
