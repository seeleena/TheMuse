<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Set the tool data
    $toolID = 12;
    $stageNum = get_input('stageNum');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $chatData = get_input('chatData');
    $wordsGeneratedCount = get_input("wordsGeneratedCount");
    $timeOnPage = get_input("timeOnPage");
    //replace word with url when firepod is ready to use 
    $word = get_input('word');
    $url = get_input('url');

    // Store the random word generator metrics
    storeRandomWordGeneratorMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $wordsGeneratedCount, $timeOnPage);

    // Store the group solution creative process and user CP engagement
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $word, $chatData);
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
    elgg_ok_response('', elgg_echo('Your Randonw Word has been saved.'), null);
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>