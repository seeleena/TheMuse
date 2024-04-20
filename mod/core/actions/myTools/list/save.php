<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Get the raw JSON for the chat data and all list items data
    $chatData = get_input('chatData');
    $allListItemsData = get_input('allListItemsData');

    // Set the tool data
    $toolID = 10;
    $stageNum = get_input('stageNum');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $listItemsAddedCount = get_input('listItemsAddedCount');
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input('timeOnPage');

    // If the group ID, assignment ID, activity ID, or instruction ID is empty, return an error and redirect to the home page
    if (empty($groupID) || empty($assignmentID) || empty($activityID) || empty($instructionID)) {
        elgg_error_response('Invalid data provided.');
        header("Location: " . elgg_get_site_url() . "/Core/myCreativeProcess/home");
        exit();
    }

    // If the all list items data is empty, return an error
    if (empty($allListItemsData)) {
        return elgg_error_response('No list items provided.');
    }

    // If the activity ID is within a certain range or is a specific value
    if(($activityID >= 29 && $activityID <= 32) || ($activityID == 18)) {
        // Initialize an array to hold the POs
        $pos = array();
        // Decode the list items data
        $decodedListItems = json_decode($allListItemsData);
        // Loop through each decoded list item
        foreach ($decodedListItems as $obj) {
            // Add the list item to the POs array
            $pos[] = $obj->listItem;
        }
        // Save the POs
        savePOs($pos, $groupID, $assignmentID, $instructionID);
    }

    // Store the group solution creative process, user CP engagement, and list metrics
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $allListItemsData, $chatData);
    storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
    storeListMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $listItemsAddedCount, $chatEntriesCount, $timeOnPage);

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
    elgg_ok_response('', elgg_echo('Your List has been saved.'), null);
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>