<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Set the views data, chat data, group ID, assignment ID, activity ID, instruction ID, tool ID, stage number, views entered count, chat entries count, time on page, and student Elgg ID
    $viewsData = get_input('viewsData');
    $chatData = get_input('chatData');
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $toolID = 9;
    $stageNum = get_input('stageNum');
    $viewsEnteredCount = get_input('viewsEnteredCount');
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input('timeOnPage');
    $StudentELGGID = elgg_get_logged_in_user_guid();

    // Store the round robin metrics, group solution creative process, and user CP engagement
    storeRoundRobinMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $viewsEnteredCount, $chatEntriesCount, $timeOnPage);
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $viewsData, $chatData);
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
    elgg_ok_response('', elgg_echo('Your Round Robin has been saved.'), null);
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>