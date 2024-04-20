<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path() . "Core/lib/utilities.php";

    // Get the raw JSON for the chat data and all changed POs data
    $chatData = get_input('chatData');
    $allChangedPOsData = get_input('allPOsData');

    // Decode the list items data
    $allListItemsData = json_decode(get_input('allListItemsData'));

    // Set the tool data
    $toolID = 5;
    $stageNum = get_input('stageNum');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $listAnswerCount = get_input('listAnswerCount');
    $POsEditedCount = get_input('POsEditedCount');
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input('timeOnPage');

    // If the group ID, assignment ID, activity ID, or instruction ID is empty, return an error and redirect to the home page
    if (empty($groupID) || empty($assignmentID) || empty($activityID) || empty($instructionID)) {
        elgg_error_response('Invalid data provided.');
        header("Location: " . elgg_get_site_url() . "/Core/myCreativeProcess/home");
        exit();
    }

    // If the list answer count and POs edited count are both empty, return an error
    if (empty($listAnswerCount) && empty($POsEditedCount)) {
        return elgg_error_response('No answers provided.');
    }

    // Get all POs for the group and assignment
    $allPossibilities = getPOs($groupID, $assignmentID);

    // Initialize an array to hold all POs
    $allPOs = array();

    // Loop through each possibility
    foreach ($allPossibilities as $po) {
        // Add the possibility to the all POs array
        $allPOs[$po->id] = $po->text;
    }

    // Decode the changed POs data
    $decodedChangedPOs = json_decode($allChangedPOsData);

    // Initialize an array to hold the changed POs
    $changedPOs = array();

    // Loop through each decoded changed PO
    foreach ($decodedChangedPOs as $obj) {
        // Add the changed PO to the changed POs array and update the all POs array
        $changedPOs[$obj->id] = $obj->text;
        $allPOs[$obj->id] = $obj->text; //The updated list of POs.
    }

    // Initialize an array to hold the formatted POs
    $formattedPOs = array();

    // Loop through each key in the all POs array
    foreach (array_keys($allPOs) as $unformattedPOID) {
        // Create a new object to hold the formatted PO
        $formattedPO = new stdClass();
        $formattedPO->id = $unformattedPOID;
    }

    // Create a new object to hold the LA data
    $laaData = new stdClass();
    // Add the formatted POs and all list items data to the LA data object
    $laaData->allPOs = $formattedPOs;
    $laaData->allListItems = $allListItemsData;

    // Update the POs with the changed POs
    phpBrokenUpdatePOs($changedPOs, $groupID, $assignmentID);
    // Store the group solution creative process, user CP engagement, and list and apply metrics
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($laaData), $chatData);
    storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
    storeListAndApplyMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $listAnswerCount, $POsEditedCount, $chatEntriesCount, $timeOnPage);

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
    elgg_ok_response('', elgg_echo('Your Applied List has been saved.'), null);
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>
