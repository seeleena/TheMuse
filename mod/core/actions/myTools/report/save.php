<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Set the tool data
    $toolID = 8;
    $stageNum = get_input('stageNum');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $chatData = get_input('chatData');
    $url = get_input('url');
    $wordCount = get_input("wordCount");
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input("timeOnPage");

    // If the group ID, assignment ID, activity ID, or instruction ID is empty, return an error and redirect to the home page
    if (empty($groupID) || empty($assignmentID) || empty($activityID) || empty($instructionID)) {
        elgg_error_response('Invalid data provided.');
        header("Location: " . elgg_get_site_url() . "/Core/myCreativeProcess/home");
        exit();
    }

    // Store the report metrics, group solution creative process, and user CP engagement
    storeReportMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $wordCount, $chatEntriesCount, $timeOnPage);
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $url, $chatData);
    storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);

    // Initialize an array to hold the parameters for the return URL
    $params = array(
        'assignID' => $assignmentID,
        'activityID' => $activityID,
        'stageNum' => $stageNum,
    );
    // Build the query string for the return URL
    $queryString = http_build_query($params);

    // Set the return URL
    $returnURL = "Core/myCreativeProcess/owner/" . $assignmentID . "?" . $queryString;

    // Send an OK response and redirect to the return URL
    elgg_ok_response('', elgg_echo('Your Report has been saved.'), null);
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>