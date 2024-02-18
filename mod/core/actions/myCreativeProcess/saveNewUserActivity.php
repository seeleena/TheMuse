<?php
$activityID = get_input('aID');
$assignID= get_input('assignID');
$userID = get_input('userID');
$cpID = get_input('cpID');
$stageNum = get_input('stageNum');
error_log("params from save: activityID:$activityID, assignID:$assignID, userID:$userID, cpID:$cpID, stageNum:$stageNum");

$activityTitle = get_input('activityTitle');
$activityDesc = get_input('activityDesc');
error_log("activityTitle:$activityTitle, activityDesc:$activityDesc");
$aID = addStudentAddedActivity($activityID, $stageNum, $cpID, $activityTitle, $activityDesc);
error_log("aID:$aID");

$instructions = array();
$instructions = get_input('instructions');
foreach ($instructions as $value) {
//    error_log($value);
    addStudentAddedInstruction($aID, $value);
}
$toolNames = array();
$toolNames = get_input('toolNames');
//foreach ($toolNames as $value) {
//    error_log($value);
//}
$toolURLs = array();
$toolURLs = get_input('toolURLs');
//foreach ($toolURLs as $value) {
//    error_log($value);
//}
$tools = array();
$tools = get_input('tools');
//foreach ($tools as $value) {
//    error_log("the tools array: $value");
//}
//$keys = array();
//$keys = array_keys($tools);
for($i = 0; $i < count($toolNames); $i++) {
    if(strcmp($tools[$i], "Select a Tool") == 0) {
        addStudentAddedTool($aID, $toolURLs[$i], $toolNames[$i]);
    }
    else if(strcmp($tools[$i], "Select a Tool") !== 0){
        //$tID = $keys[$i];
        $url = getToolURL($tools[$i]);
        $name = getToolName($tools[$i]);
        addStudentAddedTool($aID, $url, $name);
    }
}

$returnURL = "/Core/myCreativeProcess/owner/".$userID."?assignID=".$assignID;
forward($returnURL);
?>
