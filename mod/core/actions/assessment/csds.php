<?php

$assignmentID = get_input('assignID');
$groupID = get_input('groupID');

//No longer used:
$total = 0;
$json = "{";
for($i = 1; $i <= 24; $i++) {
    $questionValue = get_input('q'.$i);
    $total = $total + $questionValue;
    if(isset($questionValue)) {
        $json = $json."\"$i\":".$questionValue.",";
    }
}
$json = rtrim($json, ",");
$json = $json."}";
saveCSDSResponses($groupID, $assignmentID, $json, $total);

$returnURL = "/Core/grading/csdsReturn/" . $groupID."/".$total;
forward($returnURL);
//
?>
