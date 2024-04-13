<?php
    include elgg_get_plugins_path()."Core/lib/utilities.php";

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
    
    elgg_error_response($StudentELGGID);

    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $allResponsesData, $chatData);
     
    storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
    
     
    $answers = array();
    $decodedData = json_decode($allResponsesData, TRUE);
    error_log("decoded data:\n");
    error_log(print_r($decodedData, true));
    foreach ($decodedData as $groupResponses) {
        error_log("group response:\n");
        error_log(print_r($groupResponses, true));
        foreach ($groupResponses as $obj) {
            $userResponsesArr = $obj['userResponses'];
            $citID = $obj['citID'];
            foreach ($userResponsesArr as $response) {
                switch ($citID) {
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
                    default:
                        break;
                }
            }
        }
    }
    //save $answers to db
    savePOs($answers, $groupID, $assignmentID, $instructionID);
    
    storeCollaborativeInputMetrics($activityID, $assignmentID, $StudentELGGID, $instructionID, $chatEntriesCount, $timeOnPage);
    
    $returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID;
    elgg_ok_response('', elgg_echo('Your Collaborative Input Tool has been saved.'), null);
    header("Location: " . elgg_get_site_url() . $returnURL);
    exit();
?>
