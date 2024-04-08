<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

//error_log("<br />concept fan data:<br />" . get_input('conceptFanTreeData'));
//error_log("<br />all purposes data:<br />" . get_input('allPurposesData'));
//error_log("<br />chat data:<br />" . get_input('chatData'));

$conceptFanRawJSON = get_input('conceptFanTreeData');
$conceptFanTreeData = json_decode($conceptFanRawJSON);
$allPurposesData = json_decode(get_input('allPurposesData'));
$conceptFanToolFullData = new stdClass();
$conceptFanToolFullData->conceptFanTreeData = $conceptFanTreeData;
$conceptFanToolFullData->allPurposesData = $allPurposesData;

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

storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($conceptFanToolFullData), get_input('chatData'));
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);

$leafNodes = array();
//store leaves
$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($conceptFanRawJSON, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$currentNode = "blank";
foreach ($jsonIterator as $key => $val) {
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

//$allPossibilities = getPOs($groupID, $assignmentID);
//$allPOs = array();
//foreach ($allPossibilities as $po) {
//    $allPOs[$po->id] = $po->text;
//}
//$decodedChangedPOs = json_decode($allChangedPOsData);
$changedPOs = array();
foreach ($leafNodes as $obj) {
//    $changedPOs[$obj->id] = $obj->text;
    $allPOs[$obj->id] = $obj->text; //The updated list of POs.
}
//$allPOsJSON = json_encode($allPOs);
//foreach ($allPOs as $key => $value) {
//    error_log("key ".$key. " value ". $value);
//}
phpBrokenUpdatePOs($changedPOs, $groupID, $assignmentID);

//error_log("The ids in pos are: groupID:$groupID, assignmentID:$assignmentID, instructionID:$instructionID");
savePOs($leafNodes, $groupID, $assignmentID, $instructionID);

storeConceptFanMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $purposeIdeasCount, $nodesCreatedCount, $leafNodesCreatedCount, $chatEntriesCount, $timeOnPage);

$returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your Concept Fan Tool has been saved.";
forward($returnURL);
?>
