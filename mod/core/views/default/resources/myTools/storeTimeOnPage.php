<?php 

    // Include utilities from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Log the start of the script
    error_log("storeTimeOnPage");

    // Retrieve parameters from the GET request
    $toolID        = $_GET['toolID'];
    $studentID     = $_GET['studentID'];
    $groupID       = $_GET['groupID'];
    $activityID    = $_GET['activityID'];
    $instructionID = $_GET['instructionID'];
    $assignmentID  = $_GET['assignmentID'];
    $timeOnPage    = $_GET['timeOnPage'];

    // Log the request details
    error_log("request to store time on page with studentid $studentID, instructionid $instructionID, activity id " . $activityID . " and toolid " . $toolID . " and time " . $timeOnPage);

    // Switch case to handle different tool IDs
    switch ($toolID) {
        case 1:
            storeCollaborativeInputMetrics($activityID, $assignmentID, $studentID, $instructionID, 0, $timeOnPage);
            break;
        case 3:
            storeConceptFanMetrics($activityID, $assignmentID, $studentID, $instructionID, 0, 0, 0, 0, $timeOnPage);
            break;
        case 5:
            storeListAndApplyMetrics($activityID, $assignmentID, $studentID, $instructionID, 0, 0, 0, $timeOnPage);
            break;
        case 6:
            storeChoiceMetrics($activityID, $assignmentID, $studentID, $instructionID, -1, -1, -1, $timeOnPage);
            break;
        case 7:
            storeInAndOutMetrics($activityID, $studentID, $instructionID, $assignmentID, -1, -1, -1, -1, -1, $timeOnPage);
            break;
        case 8: 
            storeReportMetrics($activityID, $studentID, $instructionID, $assignmentID, -1, $timeOnPage);
            break;
        case 9:
            storeRoundRobinMetrics($activityID, $studentID, $instructionID, $assignmentID, -1, -1, $timeOnPage);
            break;
        case 10:
            storeListMetrics($activityID, $assignmentID, $studentID, $instructionID, 0, 0, $timeOnPage);
            break;
        case 12:
            storeRandomWordGeneratorMetrics($activityID, $studentID, $instructionID, $assignmentID, -1, $timeOnPage);
            break;
        default:
            break;
    }

    // Send a success status as a JSON response
    echo json_encode(["status" => "success"]);

?>