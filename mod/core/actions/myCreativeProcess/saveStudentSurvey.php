<?php

include elgg_get_plugins_path() . "Core/lib/utilities.php";

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

    if ($studentRating->Rating == 0) {
        return elgg_error_response(elgg_echo("Survey Incomplete"));
    }

    $csdsRatings[] = $studentRating;
}


//CMC
$cmcCriteria = getCMCCriteria();
$cmcRatings = array();
foreach ($cmcCriteria as $cmcCriterion) {

    $cmcRawRating = get_input('cmc-' . $cmcCriterion->CriteriaID . '-rating');
    $studentRating = new stdClass();
    $studentRating->StudentID = $studentID;
    $studentRating->CriteriaID = $cmcCriterion->CriteriaID;
    $studentRating->Rating = ($cmcRawRating >= 1 && $cmcRawRating <= 5) ? ($cmcRawRating) : (0);

    if ($studentRating->Rating == 0) {
        return elgg_error_response(elgg_echo("Survey Incomplete"));
    }  

    $cmcRatings[] = $studentRating;
}

storeStudentCriteriaRatings("csds", $csdsRatings);
storeStudentCriteriaRatings("cmc", $cmcRatings);

$returnURL = getServerURL() . "/Core/student/landing";
elgg_ok_response('', elgg_echo("Thank you for completing the Survey"), null);
header("Location: $returnURL");
exit(); 
?>
