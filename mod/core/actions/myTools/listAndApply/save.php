<?php

include elgg_get_plugins_path() . "Core/lib/utilities.php";

$chatData = get_input('chatData');
//error_log("chat raw: " . $chatData);
$allChangedPOsData = get_input('allPOsData');
$allListItemsData = json_decode(get_input('allListItemsData'));

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

$allPossibilities = getPOs($groupID, $assignmentID);
$allPOs = array();
foreach ($allPossibilities as $po) {
    $allPOs[$po->id] = $po->text;
}
$decodedChangedPOs = json_decode($allChangedPOsData);
$changedPOs = array();
foreach ($decodedChangedPOs as $obj) {
    $changedPOs[$obj->id] = $obj->text;
    $allPOs[$obj->id] = $obj->text; //The updated list of POs.
}

$formattedPOs = array();
foreach (array_keys($allPOs) as $unformattedPOID) {
    $formattedPO = new stdClass();
    $formattedPO->id = $unformattedPOID;
    $formattedPO->text = $allPOs[$unformattedPOID];
    $formattedPOs[] = $formattedPO;
}

$laaData = new stdClass();
$laaData->allPOs = $formattedPOs;
$laaData->allListItems = $allListItemsData;

phpBrokenUpdatePOs($changedPOs, $groupID, $assignmentID);
storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($laaData), $chatData);
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
storeListAndApplyMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $listAnswerCount, $POsEditedCount, $chatEntriesCount, $timeOnPage);

$returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your List and Apply Tool has been saved.";
forward($returnURL);
?>
