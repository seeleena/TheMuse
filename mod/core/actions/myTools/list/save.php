<?php
include elgg_get_plugins_path()."Core/lib/utilities.php";

$chatData = get_input('chatData');
//error_log("chat raw: " . $chatData);
//error_log("allListItemsData raw: " . get_input('allListItemsData'));
$allListItemsData = get_input('allListItemsData');

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

if(($activityID >= 29 && $activityID <= 32) || ($activityID == 18)) {
    $pos = array();
    $decodedListItems = json_decode($allListItemsData);
    foreach ($decodedListItems as $obj) {
        $pos[] = $obj->listItem;
    }
    savePOs($pos, $groupID, $assignmentID, $instructionID);
}

//error_log("DEBUG LIST: $groupID / $assignmentID / $activityID / $instructionID / $toolID / $allPossibilitiesData / $chatData");
storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $allListItemsData, $chatData);
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
storeListMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $listItemsAddedCount, $chatEntriesCount, $timeOnPage);

$returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your List Tool has been saved.";
forward($returnURL);
?>
