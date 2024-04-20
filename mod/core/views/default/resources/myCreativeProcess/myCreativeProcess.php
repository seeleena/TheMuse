<?php
//unset($_SESSION['CurrentActivity']);
//unset($_SESSION['CurrentInstructionID']);
switch ($myProcessAction) {
    case 'home': //first 
        $title = "My Creative Process";
        $vars = array();
        $vars['courseCodes'] = getCourseCodes();
        $content = elgg_view('Core/myCreativeProcess/home', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'survey': 
        $title = "Survey";
        $vars = array();
        $vars['allHeadings'] = getAllStudentHeadings();
        $vars['allCriteria'] = getAllStudentCriteria();
        $vars['cmcCriteria'] = getCMCCriteria();
        $content = elgg_view('Core/myCreativeProcess/survey', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'feedbackDashboard':
        $title = "Student Feedback Dashboard";
        $vars = array();
        
        $assignmentID = $_SESSION['currentAssignID'];
        $currentUser   = elgg_get_logged_in_user_entity();
        $studentUsername = $currentUser->username; //11111112
        $studentELGGID = $currentUser->guid; //198 
        $vars['creativityFactors'] = getCreativityFactors($assignmentID, $currentUser, $studentELGGID);     
        $_SESSION['creativityFactors'] = $vars['creativityFactors'];
        $content = elgg_view('Core/myCreativeProcess/feedbackDashboard', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'improvementActivities': //last 
        $title = "Creativity Factors Improvement Activities";
        $vars = array();
        $creativityFactorID = sanitise_int($myProcessParam, false);
        $assignmentID = $_SESSION['currentAssignID'];
        $currentUser   = elgg_get_logged_in_user_entity();
        $studentUsername = $currentUser->username; //11111112
        $studentELGGID = $currentUser->guid; //198 
        $activities = getImprovementActivities($creativityFactorID);
        $creativityFactors = $_SESSION['creativityFactors'];
        $factorRating = getFactorRating($creativityFactorID, $creativityFactors);
        $vars['factorRating'] = $factorRating;
        $vars['activities'] = $activities;
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
        break;
    case 'owner': //exclude helpme
        $title = "My Creative Process";
        $vars = array();
        $vars['owner'] = $myProcessParam;
        $_SESSION['owner'] = $vars['owner'];
        $vars['assignID'] = $assignID;
        if (empty($assignID)) {
            $url = getServerURL() . "/Core/myCreativeProcess/home?message=Your course and assignment must be chosen before starting an Activity.";
            die('<meta http-equiv="refresh" content="0; url=' . $url . '" />');
        }
        $vars['activityID'] = $_GET['activityID'];
        $vars['cp'] = getCPDetails($assignID);

        $helpMe = $_GET["helpme"];
        if ($helpMe) {
            $suggestions = array();
            $suggestions = rulePrioritizeByCP($vars['owner'], $vars['activityID'], $assignID, $stageNumber);
            $cpID = getCP($assignID);
            $suggestions = rulePrioritizeByComplexity($suggestions, $cpID);
            $suggestions = rulePrioritizeByStudentCriteria($suggestions, $vars['activityID'], $vars['owner']);
            $vars['suggestions'] = $suggestions;
        }
        
        $content = elgg_view('Core/myCreativeProcess/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'activity': //first
        $title = "My Creative Process";
        $vars = array();
        $activity = array();
        $activity = getActivityDetails($myProcessParam); //2nd param not being used, remove
        $_SESSION['CurrentActivity'] = $activity;
        //error_log($myProcessParam);
        $vars['activity'] = $activity;
        $vars['owner'] = $_SESSION['owner'];
        $content = elgg_view('Core/myCreativeProcess/activity', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'studentCreatedActivity':
        $title = "My Creative Process";
        $vars = array();
        $instructions = array();
        $instructions = getStudentCreatedInstructions($myProcessParam);
        $tools = array();
        $tools = getStudentCreatedTools($myProcessParam);
        //get activity description and put in vars
        $description = getActivityDescription($myProcessParam);
        $_SESSION['CurrentActivity'] = $activity;
        $vars['instructions'] = $instructions;
        $vars['tools'] = $tools;
        $vars['description'] = $description;
        $vars['studentCreatedAID'] = $myProcessParam;
        $content = elgg_view('Core/myCreativeProcess/studentCreatedActivity', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'newUserActivity': //last
        $title = "My Creative Process";
        $vars = array();
        $activity = array();
        $activity = getActivityDetails($myProcessParam, 7);
        //error_log($myProcessParam);
        $vars['activity'] = $activity;
        $content = elgg_view('Core/myCreativeProcess/newUserActivity', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'uploadSolution': //first
        $title = "My Creative Process";
        $vars = array();
        $vars['userID'] = $myProcessParam;
        $vars['assignID'] = $assignID;
        $content = elgg_view('Core/myCreativeProcess/uploadZipSolution', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'helpButton':
        
        break;
    default:
        break;
}



?>
