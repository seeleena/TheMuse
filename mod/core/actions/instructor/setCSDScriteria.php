<?php

$assignID = get_input('assignID');
$criteriaArray = array();
$headingArray = array();

foreach ($_POST as $key => $value) {
    if (startsWith($key, "H")) {
        $headingArray[substr($key, 1)] = $value;
    }
    else if (startsWith($key, "c")) {
        $criteriaArray[substr($key, 1)] = $value;
    }
}

saveCriteriaWeights($assignID, $criteriaArray);
saveHeadingWeights($assignID, $headingArray);

$returnURL = "/Core/grading/csdsReturn/" . $groupID."/".$total;
forward($returnURL);
?>
