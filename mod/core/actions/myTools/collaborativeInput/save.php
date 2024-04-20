<?php
    // Include the utilities file from the Core plugin
    include elgg_get_plugins_path()."Core/lib/utilities.php";

    // Set the tool data
    $toolID = 1;
    $stageNum = get_input('stageNum');
    $chatData = get_input('chatData');
    $allResponsesData = get_input('allResponsesData');
    $groupID = get_input('groupID');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input('timeOnPage');    

    // If the group ID, assignment ID, activity ID, or instruction ID is empty, return an error and redirect to the home page
    if (empty($groupID) || empty($assignmentID) || empty($activityID) || empty($instructionID)) {
        elgg_error_response('Invalid data provided.');
        header("Location: " . elgg_get_site_url() . "/Core/myCreativeProcess/home");
        exit();
    }

    // If all responses data is empty, return an error
    if (empty($allResponsesData)) {
        return elgg_error_response('No responses provided.');
    }

    // Store the group solution creative process and user CP engagement
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $allResponsesData, $chatData);
    storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);

    // Initialize an array to hold the answers
    $answers = array();

    // Decode the all responses data
    $decodedData = json_decode($allResponsesData, TRUE);

    // Loop through each group response
    foreach ($decodedData as $groupResponses) {
        // Loop through each object in the group response
        foreach ($groupResponses as $obj) {
            // Get the user responses array and the citID from the object
            $userResponsesArr = $obj['userResponses'];
            $citID = $obj['citID'];

            // Loop through each user response
            foreach ($userResponsesArr as $response) {
                // Switch on the citID
                switch ($citID) {
                    // If the citID is one of the following values, get the answer from the response and add it to the answers array
                    case 11:
                    case 15:
                    case 17:
                    case 19:
                    case 25:
                    case 34:
                    case 37:
                    case 39:
                        $answer = $response['answer'];
                        $answers[] = $answer;
                        break;
                    // If the citID is not one of the above values, do nothing
                    default:
                        break;
                }
            }
        }
    }

    // Save the answers to the database
    savePOs($answers, $groupID, $assignmentID, $instructionID);

    // Store the collaborative input metrics
    storeCollaborativeInputMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $chatEntriesCount, $timeOnPage);

    // Build the query string for the return URL
    $params = array(
        'assignID' => $assignmentID,
        'activityID' => $activityID,
        'stageNum' => $stageNum,
    );
    $queryString = http_build_query($params);

    // Construct the return URL
    $returnURL = "Core/myCreativeProcess/owner/" . $assignmentID . "?" . $queryString;

    // Return a success message
    elgg_ok_response('', elgg_echo('Your Collaborative Input has been saved.'), null);

    // Redirect to the return URL
    header("Location: " . elgg_get_site_url() . $returnURL);

    // Terminate the current script
    exit();
?>