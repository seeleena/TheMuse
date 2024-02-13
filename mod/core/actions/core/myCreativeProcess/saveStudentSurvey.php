<?php
$studentID = get_input('studentID');
//CSDS
$csdsCriteria = getAllStudentCriteriaFromDB();
$csdsRatings = array();
foreach ($csdsCriteria as $criteriaID) {
    $rawRating = get_input('csds-' . $criteriaID . '-rating');
    $studentRating = new stdClass();
    $studentRating->StudentID = $studentID;
    $studentRating->CriteriaID = $criteriaID;
    $studentRating->Rating = ($rawRating >= 1 && $rawRating <= 5) ? ($rawRating) : (0);
    $csdsRatings[] = $studentRating;
}
storeStudentCriteriaRatings("csds", $csdsRatings);

//CMC
$cmcCriteria = getCMCCriteria();
$cmcRatings = array();
foreach ($cmcCriteria as $cmcCriterion) {
    $cmcRawRating = get_input('cmc-' . $cmcCriterion->CriteriaID . '-rating');
    $studentRating = new stdClass();
    $studentRating->StudentID = $studentID;
    $studentRating->CriteriaID = $cmcCriterion->CriteriaID;
    $studentRating->Rating = ($cmcRawRating >= 1 && $cmcRawRating <= 5) ? ($cmcRawRating) : (0);
    $cmcRatings[] = $studentRating;
}
storeStudentCriteriaRatings("cmc", $cmcRatings);

//
//$instructions = array();
////$instructions = get_input('instructions');
////foreach ($instructions as $value) {
//////    error_log($value);
////    addStudentAddedInstruction($aID, $value);
////}
//$toolNames = array();
//$toolNames = get_input('toolNames');
////foreach ($toolNames as $value) {
////    error_log($value);
////}
//$toolURLs = array();
//$toolURLs = get_input('toolURLs');
////foreach ($toolURLs as $value) {
////    error_log($value);
////}
//$tools = array();
//$tools = get_input('tools');
////foreach ($tools as $value) {
////    error_log("the tools array: $value");
////}
////$keys = array();
////$keys = array_keys($tools);
//for($i = 0; $i < count($toolNames); $i++) {
//    if(strcmp($tools[$i], "Select a Tool") == 0) {
//        addStudentAddedTool($aID, $toolURLs[$i], $toolNames[$i]);
//    }
//    else if(strcmp($tools[$i], "Select a Tool") !== 0){
//        //$tID = $keys[$i];
//        $url = getToolURL($tools[$i]);
//        $name = getToolName($tools[$i]);
//        addStudentAddedTool($aID, $url, $name);
//    }
//}

$returnURL = "/Core/student/landing";
forward($returnURL);
?>
