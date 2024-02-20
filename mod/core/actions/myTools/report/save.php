<?php
$toolID = 8;
$stageNum = get_input('stageNum');
$StudentELGGID = elgg_get_logged_in_user_guid();
$groupID = get_input('groupID');
$assignmentID = get_input('assignmentID');
$activityID = get_input('activityID');
$instructionID = get_input('instructionID');
$chatData = get_input('chatData');
$url = get_input('url');
$wordCount = get_input("wordCount");
$chatEntriesCount = get_input('chatEntriesCount');
$timeOnPage = get_input("timeOnPage");

storeReportMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $wordCount, $chatEntriesCount, $timeOnPage);
storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $url, $chatData);
storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
$returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your Report Tool has been saved.";
forward($returnURL);
?>
