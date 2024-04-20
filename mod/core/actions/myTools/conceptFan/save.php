<?php
// Include the utilities file from the Core plugin
include elgg_get_plugins_path()."Core/lib/utilities.php";

// Get the raw JSON for the concept fan tree data and all purposes data
$conceptFanRawJSON = get_input('conceptFanTreeData');
$conceptFanTreeData = json_decode($conceptFanRawJSON);
$allPurposesData = json_decode(get_input('allPurposesData'));

// Create a new object to hold the full data for the concept fan tool
$conceptFanToolFullData = new stdClass();
$conceptFanToolFullData->conceptFanTreeData = $conceptFanTreeData;
$conceptFanToolFullData->allPurposesData = $allPurposesData;

// Set the tool ID, stage number, student Elgg ID, group ID, assignment ID, activity ID, instruction ID, purpose ideas count, nodes created count, leaf nodes created count, chat entries count, and time on page
$toolID = 3;
$stageNum = get_input('stageNum');
$StudentELGGID = elgg_get_logged_in_user_guid();
$groupID = get_input('groupID');
$assignmentID = get_input('assignmentID');
$activityID = get_input('activityID');
$instructionID = get_input('instructionID');
$purposeIdeasCount = get_input('purposeIdeasCount');
$nodesCreatedCount = get_input('nodesCreatedCount');
$leafNodesCreatedCount = get_input('leafNodesCreatedCount');
$chatEntriesCount = get_input('chatEntriesCount');
$timeOnPage = get_input('timeOnPage');

// If the group ID, assignment ID, activity ID, or instruction ID is empty, return an error and redirect to the home page
if (empty($groupID) || empty($assignmentID) || empty($activityID) || empty($instructionID)) {
    elgg_error_response('Invalid data provided.');
    header("Location: " . elgg_get_site_url() . "/Core/myCreativeProcess/home");
    exit();
}

// Store the group solution creative process and user CP engagement
storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($conceptFanToolFullData), get_input('chatData'));
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);

// Initialize an array to hold the leaf nodes
$leafNodes = array();

// Create a new recursive iterator to iterate over the concept fan raw JSON
$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($conceptFanRawJSON, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

// Initialize the current node to "blank"
$currentNode = "blank";

// Loop through each item in the JSON iterator
foreach ($jsonIterator as $key => $val) {
    // If the key is "text", set the current node to the value
    if ($key == "text") {
        $currentNode = $val;
    }
        if(is_array($val)) {
            //error_log("$key:\n");
            
            if ($key == "children") {
                $childrenSize = count($val);
                //error_log("CHILDREN LENGTH of " . $currentNode . ": " . $childrenSize);
                if ($childrenSize == 0) {
                    //error_log($currentNode . " is a leaf node.");
                    array_push($leafNodes, $currentNode);
                }
            }
            else {
                //error_log($key . " is not children");
            }
        } 
        else {
            //error_log("$key => $val\n");
        }
    }


    // Initialize an array to hold the changed POs
    $changedPOs = array();
    // Loop through each leaf node
    foreach ($leafNodes as $obj) {
        // Add the leaf node to the allPOs array
        $allPOs[$obj->id] = $obj->text; //The updated list of POs.
    }

    // Update the POs
    phpBrokenUpdatePOs($changedPOs, $groupID, $assignmentID);

    // Save the POs
    savePOs($leafNodes, $groupID, $assignmentID, $instructionID);

    // Store the concept fan metrics
    storeConceptFanMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $purposeIdeasCount, $nodesCreatedCount, $leafNodesCreatedCount, $chatEntriesCount, $timeOnPage);

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
    elgg_ok_response('', elgg_echo('Your Fan of Concepts has been saved.'), null);
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>
