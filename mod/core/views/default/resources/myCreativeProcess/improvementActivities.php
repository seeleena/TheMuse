<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";// Enables calling of functions from utilities

$title = "Creativity Factors Improvement Activities";
$creativityFactorID = (string) elgg_extract('CFID', $vars);// Enables calling of functions from utilities
$assignmentID = $_SESSION['currentAssignID'];//Stores ID of session user. Another possibility for sessions is _GET
$currentUser   = elgg_get_logged_in_user_entity();// Get user that is logged in

$studentUsername = $currentUser->username; // stores username
$studentELGGID = $currentUser->guid;  // stores user ID
$activities = getImprovementActivities($creativityFactorID);// Stores all the suggested activity details an activities variable 
$creativityFactors = $_SESSION['creativityFactors'];//Stores ID of session 
$factorRating = getFactorRating($creativityFactorID, $creativityFactors);// determines activity rating
//Stores all extracted information in an array
$vars['factorRating'] = $factorRating;
$vars['activities'] = $activities;
$vars['assignID'] = $_GET['assignID'];
$vars['stageNum'] = $_GET['stageNum'];

//if page is not getting any activities, the message below will be displayed. This can occur due to there being no activities, an error with database connectivity,
//an error with functions used on this page or an error with the actvity page. Works at time of submission, these are just possible solutions if future developers encounter issues.
        if (empty($activities)) { //Communication will yield no activities. Show a message instead.
            $communicationMessage = "Try using the chats within tools to help you to communicate better. " . 
                "Also try using the Social Networking Blogs, Pages, Bookmarks, Files and The Wire to communicate more effectively.";
            $vars['communicationMessage'] = $communicationMessage;
        }
$vars['assignmentID'] = $assignmentID;
$content = elgg_view('Core/myCreativeProcess/improvementActivities', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);   // Display page along with all content stored.     

?>
