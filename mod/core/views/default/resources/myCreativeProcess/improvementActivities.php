<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "Creativity Factors Improvement Activities";
        $creativityFactorID = (string) elgg_extract('CFID', $vars);
        $assignmentID = $_SESSION['currentAssignID'];
        $currentUser   = elgg_get_logged_in_user_entity();
        $studentUsername = $currentUser->username; 
        $studentELGGID = $currentUser->guid;  
        $activities = getImprovementActivities($creativityFactorID);
        $creativityFactors = $_SESSION['creativityFactors'];
        $factorRating = getFactorRating($creativityFactorID, $creativityFactors);
        $vars['factorRating'] = $factorRating;
        $vars['activities'] = $activities;
        $vars['assignID'] = $_GET['assignID'];
        $vars['stageNum'] = $_GET['stageNum'];
        if (empty($activities)) { //Communication will yield no activities. Show a message instead.
            $communicationMessage = "Try using the chats within tools to help you to communicate better. " . 
                "Also try using the Social Networking Blogs, Pages, Bookmarks, Files and The Wire to communicate more effectively.";
            $vars['communicationMessage'] = $communicationMessage;
        }
        $vars['assignmentID'] = $assignmentID;
        $content = elgg_view('Core/myCreativeProcess/improvementActivities', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);        

?>