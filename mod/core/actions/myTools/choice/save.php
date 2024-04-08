<?php
include elgg_get_plugins_path()."Core/lib/utilities.php";

$chatData = get_input('chatData');
$allPossibilitiesData = json_decode(get_input('allPossibilitiesData'));

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

storeChoiceMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $clearWeakerCount, $resetPOsCount, $movementsCount, $chatEntriesCount, $timeOnPage);
storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, json_encode($allPossibilitiesData), $chatData);
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);

$leafNodes = array();

$returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your Choice Tool has been saved.";
forward($returnURL);
?>
