<?php

    include elgg_get_plugins_path()."Core/lib/utilities.php";

    //$viewsData = json_decode(get_input('viewsData'));
    //$chatData = json_decode(get_input('chatData'));

    $viewsData = get_input('viewsData');
    $chatData = get_input('chatData');
    $groupID = get_input('groupID');
    $assignmentID = get_input('assignmentID');
    $activityID = get_input('activityID');
    $instructionID = get_input('instructionID');
    $toolID = 9;
    $stageNum = get_input('stageNum');
    $viewsEnteredCount = get_input('viewsEnteredCount');
    $chatEntriesCount = get_input('chatEntriesCount');
    $timeOnPage = get_input('timeOnPage');
    $StudentELGGID = elgg_get_logged_in_user_guid();
    
    storeRoundRobinMetrics($activityID, $StudentELGGID, $instructionID, $assignmentID, $viewsEnteredCount, $chatEntriesCount, $timeOnPage);
    storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $viewsData, $chatData);
    storeUserCPEngagement($stageNum, $assignmentID, $StudentELGGID, $toolID);
    //error_log("after here");
   
    //$assessmentData = new stdClass();
    //$assessmentData->tool = "Round Robin";
    //$assessmentData->activityID = get_input('activityID');;
    /*
    $assessmentData->datas = array();
    
    $chatDataObject = new stdClass();
    $chatDataObject->title = "Chat";
    $chatDataObject->data = $chatData;
    array_push($assessmentData->datas, $chatDataObject);
    
    $viewsDataObject = new stdClass();
    $viewsDataObject->title = "Views";
    $viewsDataObject->data = $viewsData;
    array_push($assessmentData->datas, $viewsDataObject);
    
    
    $assessmentFileName = getAssessmentFileName($groupID, $assignmentID);*/
    /*$assessmentFilePath = realpath(elgg_get_data_path()) . $assessmentFileName;
    $handle = fopen($assessmentFilePath, 'a') or die('Cannot append to assessment file: ' . $assessmentFilePath);
    fwrite($handle, json_encode($assessmentData));
    fclose($handle);
    */
    /*
    include elgg_get_plugins_path()."Core/lib/creativeProcessFileUpload.php"; 

    $fileGuid = uploadFile($assessmentFileName, $assessmentData);
    storeFileGuidForGroupSolution($groupID, $assignmentID, $fileGuid, 1);
    */
    $returnURL = "/Core/myCreativeProcess/activity/" . $activityID . "?assignID=" . $assignmentID . "&message=" . "Your Round Robin Tool has been saved.";
    forward($returnURL);
?>
