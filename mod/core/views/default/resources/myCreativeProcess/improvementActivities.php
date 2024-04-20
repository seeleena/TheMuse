
<?php
// Include the utilities file
include elgg_get_plugins_path()."Core/lib/utilities.php";

// Set the title of the page
$title = "Creativity Factors Improvement Activities";

// Extract the creativity factor ID from the variables
$creativityFactorID = (string) elgg_extract('CFID', $vars);

// Get the current assignment ID from the session
$assignmentID = $_SESSION['currentAssignID'];

// Get the current user entity
$currentUser = elgg_get_logged_in_user_entity();

// Get the username and ID of the current user
$studentUsername = $currentUser->username; 
$studentELGGID = $currentUser->guid;  

// Get the improvement activities for the creativity factor
$activities = getImprovementActivities($creativityFactorID);

// Get the creativity factors from the session
$creativityFactors = $_SESSION['creativityFactors'];

// Get the rating for the creativity factor
$factorRating = getFactorRating($creativityFactorID, $creativityFactors);

// Add the factor rating and activities to the variables
$vars['factorRating'] = $factorRating;
$vars['activities'] = $activities;

// Get the assignment ID and stage number from the GET parameters
$vars['assignID'] = $_GET['assignID'];
$vars['stageNum'] = $_GET['stageNum'];

// Check if there are no activities
if (empty($activities)) {
    // If there are none, set a communication message
    $communicationMessage = "Try using the chats within tools to help you to communicate better. " . 
        "Also try using the Social Networking Blogs, Pages, Bookmarks, Files and The Wire to communicate more effectively.";
    $vars['communicationMessage'] = $communicationMessage;
}

// Add the assignment ID to the variables
$vars['assignmentID'] = $assignmentID;

// Render the improvement activities view and add it to the variables
$content = elgg_view('Core/myCreativeProcess/improvementActivities', $vars);
$vars['content'] = $content;

// Render the layout with one sidebar and echo the page view
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);        
?>
