<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$toolID = 12;
$stageNum = get_input('stageNum');
$StudentELGGID = elgg_get_logged_in_user_guid();
$groupID = get_input('groupID');
$assignmentID = get_input('assignmentID');
$activityID = get_input('activityID');
$instructionID = get_input('instructionID');
$chatData = get_input('chatData');
$url = get_input('url');
$wordsGeneratedCount = get_input("wordsGeneratedCount");
$timeOnPage = get_input("timeOnPage");

storeRandomWordGeneratorMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $wordsGeneratedCount, $timeOnPage);

storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $url, $chatData);
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
$returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your Report Tool has been saved.";
forward($returnURL);
?>
