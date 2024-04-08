<?php
include elgg_get_plugins_path()."Core/lib/utilities.php";

$chatData = get_input('chatData');
$allListItemsData = get_input('allListItemsData');
$allPossibilitiesData = get_input('allPossibilitiesData');
$allData = new stdClass();
$allData->listItemsData = json_decode($allListItemsData);
$allData->possibilitiesData = json_decode($allPossibilitiesData);

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

storeInAndOutMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $resetPOsClicksCount, $clearOutClicksCount, $movementsCount, $addedCharacteristicsCount, $chatEntriesCount, $timeOnPage);
storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($allData), $chatData);
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);

$returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your In and Out Tool has been saved.";
forward($returnURL);
?>
