<?php
// Set the student rating's StudentID, CriteriaID, and Rating
$studentRating->StudentID = $studentID;
$studentRating->CriteriaID = $criteriaID;
$studentRating->Rating = ($rawRating >= 1 && $rawRating <= 5) ? ($rawRating) : (0);

// If the rating is 0, return an error message
if ($studentRating->Rating == 0) {
    return elgg_error_response(elgg_echo("Survey Incomplete"));
}

// Add the student rating to the csdsRatings array
$csdsRatings[] = $studentRating;

// Get the CMC criteria
$cmcCriteria = getCMCCriteria();
$cmcRatings = array();

// Loop through each CMC criterion
foreach ($cmcCriteria as $cmcCriterion) {
    // Get the raw rating for the criterion
    $cmcRawRating = get_input('cmc-' . $cmcCriterion->CriteriaID . '-rating');
    $studentRating = new stdClass();
    $studentRating->StudentID = $studentID;
    $studentRating->CriteriaID = $cmcCriterion->CriteriaID;
    $studentRating->Rating = ($cmcRawRating >= 1 && $cmcRawRating <= 5) ? ($cmcRawRating) : (0);

    // If the rating is 0, return an error message
    if ($studentRating->Rating == 0) {
        return elgg_error_response(elgg_echo("Survey Incomplete"));
    }  

    // Add the student rating to the cmcRatings array
    $cmcRatings[] = $studentRating;
}

// Store the student criteria ratings for csds and cmc
storeStudentCriteriaRatings("csds", $csdsRatings);
storeStudentCriteriaRatings("cmc", $cmcRatings);

// Construct the return URL
$returnURL = getServerURL() . "/Core/student/landing";

// Return a success message
elgg_ok_response('', elgg_echo("Thank you for completing the Survey"), null);

// Redirect to the return URL
header("Location: $returnURL");
exit(); 
?>