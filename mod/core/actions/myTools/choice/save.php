<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Get the chat data and all possibilities data from the input
    $chatData = get_input('chatData');
    $allPossibilitiesData = json_decode(get_input('allPossibilitiesData'));

    // Set the tool data
    $toolID = 6;
    $stageNum = get_input('stageNum');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $clearWeakerCount = get_input('clearWeakerCount');
    $resetPOsCount = get_input('resetPOsCount');
    $movementsCount = get_input('movementsCount');
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input('timeOnPage');

    // If the group ID, assignment ID, activity ID, or instruction ID is empty, return an error and redirect to the home page
    if (empty($groupID) || empty($assignmentID) || empty($activityID) || empty($instructionID)) {
        elgg_error_response('Invalid data provided.');
        header("Location: " . elgg_get_site_url() . "/Core/myCreativeProcess/home");
        exit();
    }

    // Store the choice metrics, group solution creative process, and user CP engagement
    storeChoiceMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $clearWeakerCount, $resetPOsCount, $movementsCount, $chatEntriesCount, $timeOnPage);
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($allPossibilitiesData), $chatData);
    storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);

    // Build the query string for the return URL
    $params = array(
        'assignID' => $assignmentID,
        'activityID' => $activityID,
        'stageNum' => $stageNum,
    );
    $queryString = http_build_query($params);

    // Construct the return URL
    $returnURL = "Core/myCreativeProcess/owner/" . $assignmentID . "?" . $queryString;

    // Return a success message
    elgg_ok_response('', elgg_echo('Your Choice has been saved.'), null);

    // Redirect to the return URL
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>
