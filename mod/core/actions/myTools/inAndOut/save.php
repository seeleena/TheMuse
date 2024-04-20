<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Get the raw JSON for the chat data, all list items data, and all possibilities data
    $chatData = get_input('chatData');
    $allListItemsData = get_input('allListItemsData');
    $allPossibilitiesData = get_input('allPossibilitiesData');

    // Create a new object to hold the full data for the In and Out tool
    $allData = new stdClass();
    $allData->listItemsData = json_decode($allListItemsData);
    $allData->possibilitiesData = json_decode($allPossibilitiesData);

    // Set the tool data
    $toolID = 7;
    $stageNum = get_input('stageNum');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $resetPOsClicksCount = get_input('resetPOsClicksCount');
    $clearOutClicksCount = get_input('clearOutClicksCount');
    $movementsCount = get_input('movementsCount');
    $addedCharacteristicsCount = get_input('addedCharacteristicsCount');
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input('timeOnPage');

    // If the group ID, assignment ID, activity ID, or instruction ID is empty, return an error and redirect to the home page
    if (empty($groupID) || empty($assignmentID) || empty($activityID) || empty($instructionID)) {
        elgg_error_response('Invalid data provided.');
        header("Location: " . elgg_get_site_url() . "/Core/myCreativeProcess/home");
        exit();
    }

    // Store the In and Out metrics, group solution creative process, and user CP engagement
    storeInAndOutMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $resetPOsClicksCount, $clearOutClicksCount, $movementsCount, $addedCharacteristicsCount, $chatEntriesCount, $timeOnPage);
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($allData), $chatData);
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
    elgg_ok_response('', elgg_echo("Your Ins' and Outs' has been saved."), null);
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>

