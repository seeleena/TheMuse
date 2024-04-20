<?php
// Get the owner of the page and store it in the variables
$vars['owner'] = elgg_get_page_owner_entity();

// Get the ID of the logged in user
$ownerID = elgg_get_logged_in_user_entity()->guid;

// Store the owner in the session
$_SESSION['owner'] = $vars['owner'];

// Check if the assignment ID is empty
if (empty($assignID)) {
    // If it is, redirect to the home page
    $url = elgg_get_site_url() . "Core/myCreativeProcess/home";
    die('<meta http-equiv="refresh" content="0; url=' . $url . '" />');
}

// Get the details of the creative process and store it in the variables
$vars['cp'] = getCPDetails($assignID);

// Get the activity ID and stage number from the GET parameters and store them in the variables
$vars['activityID'] = $_GET['activityID'];
$vars['stageNum'] = $_GET['stageNum'];

// Get the help me parameter from the GET parameters
$helpMe = $_GET["helpme"];

// If help me is set, get the suggestions
if ($helpMe) {
    // Initialize an array for the suggestions
    $suggestions = array();

    // Prioritize the suggestions by the creative process
    $suggestions = rulePrioritizeByCP($ownerID, $vars['activityID'], $assignID, $vars['stageNum'] );

    // Get the creative process ID
    $cpID = getCP($assignID);

    // Store the creative process ID in the variables
    $vars['cpID'] = $cpID;

    // Prioritize the suggestions by complexity
    $suggestions = rulePrioritizeByComplexity($suggestions, $cpID);

    // Prioritize the suggestions by student criteria
    $suggestions = rulePrioritizeByStudentCriteria($suggestions, $vars['activityID'], $vars['owner']);

    // Store the suggestions in the variables
    $vars['suggestions'] = $suggestions;
}

// Render the main view and store it in the variables
$content = elgg_view('Core/myCreativeProcess/main', $vars);
$vars['content'] = $content;

// Render the layout with one sidebar
$body = elgg_view_layout('one_sidebar', $vars);

// Echo the page view
echo elgg_view_page($title, $body);
?>