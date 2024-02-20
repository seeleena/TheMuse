<?php
$vars = array();
/* DOES NOT WORK YET, have to set manually.
$host = gethostname();
error_log('hostname is ' . $host);
if (strpos($host, 'SHRIPAT') !== false) {
    
    $vars['nodeServer'] = "http://localhost:8888";
}
else {
    $vars['nodeServer'] = "http://themusenode.diana.shripat.com";
}
 * */
$vars['nodeServer'] = "http://localhost:8888";
$_SESSION['CurrentInstructionID'] = $_GET['instructionID'];
switch ($myProcessAction) { 
    case 'groupStorage':
        $title = "Group Storage";
        $content = elgg_view('Core/myTools/groupStorage/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'roundRobin':
        $toolAcronym = "rr";
        $title = "Round Robin Discussion";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['toolID'] = 9;
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user);
        //error_log(print_r($vars['groupMembers'], true));
        $content = elgg_view('Core/myTools/roundRobin/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'collaborativeInput':
        $toolAcronym = "ci";
        $vars['toolID'] = 1;
        $title = "Collaborative Input Tool";
        $instructionID = sanitise_int($myProcessParam2, false);//$_GET['instructionID'];
        $collaborativeInputToolInstructions = getCollaborativeInputToolInstructions($instructionID);
        $vars['instructions'] = $collaborativeInputToolInstructions;
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user);        
        $content = elgg_view('Core/myTools/collaborativeInput/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'listAndApply':
        $toolAcronym = "laa";
        $vars['toolID'] = 5;
        $title = "List and Apply Tool";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, "LAA"); //all LAA's within a group and assignment share the same key
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 
        $content = elgg_view('Core/myTools/listAndApply/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        //forward('Core/myTools/underConstruction');
        echo elgg_view_page($title, $body);
        break;
    case 'conceptFan':
        $toolAcronym = "cf";
        $vars['toolID'] = 3;
        $title = "Concept Fan Tool";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 
        $content = elgg_view('Core/myTools/conceptFan/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'choice':
        $vars['toolID'] = 6;
        $toolAcronym = "choice";
        $title = "Choice Tool";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 
        $content = elgg_view('Core/myTools/choice/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
//        forward('Core/myTools/underConstruction');
        echo elgg_view_page($title, $body);
        break;
    case 'list':
        $toolAcronym = "list";
        $vars['toolID'] = 10;
        $title = "List Tool";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 
        $content = elgg_view('Core/myTools/list/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'inAndOut':
        $toolAcronym = "inAndOut";
        $vars['toolID'] = 7;
        $title = "In and Out Tool";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 
        $content = elgg_view('Core/myTools/inAndOut/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
//        forward('Core/myTools/underConstruction');
        echo elgg_view_page($title, $body);
        break;
    case 'randomWordGenerator':
        $toolAcronym = "rwg";
        $vars['toolID'] = 12;
        $title = "Random Word Generator";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 
        $vars['randomWord'] = getRandomWord();
        $content = elgg_view('Core/myTools/randomWordGenerator/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
//        forward('Core/myTools/underConstruction');
        echo elgg_view_page($title, $body);
        break;
    case 'owner':
        $title = "Tool Listing";
        $content = elgg_view('Core/myTools/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'completed':
        $content = elgg_view('Core/myTools/completed', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'underConstruction':
        $content = elgg_view('Core/myTools/underConstruction', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'stretches':
        $content = elgg_view('Core/myTools/stretches/simple', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'report':
        $toolAcronym = "report";
        $title = "Report Tool";
        $assignmentID = sanitise_int($myProcessParam, false);
        $vars['assignmentID'] = $assignmentID;
        $user = elgg_get_logged_in_user_entity();
        $groupID = getGroupID($assignmentID, $user->guid);
        $activityID = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $vars['toolID'] = 8;
        $vars['groupID'] = $groupID;
        $vars['activityID'] = $activityID;
        $vars['instructionID'] = $instructionID;
        $vars['sessionKey'] = getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID);
        $vars['groupMembers'] = getGroupMembers($groupID, $assignmentID, $user); 
        $vars['reportURL'] = getReportURL($groupID, $activityID, $instructionID, $assignmentID);
        $content = elgg_view('Core/myTools/report/main', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;    
    case 'storeTimeOnPage':
        error_log("storeTimeOnPage");
        $toolID        = $_GET['toolID'];
        $studentID     = $_GET['studentID'];
        $groupID       = $_GET['groupID'];
        $activityID    = $_GET['activityID'];
        $instructionID = $_GET['instructionID'];
        $assignmentID  = $_GET['assignmentID'];
        $timeOnPage    = $_GET['timeOnPage'];
        error_log("request to store time on page with studentid $studentID, instructionid $instructionID, activity id " . $activityID . " and toolid " . $toolID . " and time " . $timeOnPage);

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
        echo "SUCCESS";
        break;
    default:
        forward('Core/myTools/underConstruction');
        break;
}

function getReportURL($groupID, $activityID, $instructionID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $getReportURLStatement = $mysqli->prepare("SELECT URL from report WHERE groupid = ? AND activityid = ? AND instructionid = ? AND assignmentid = ?");
    $getReportURLStatement->bind_param('iiii', $groupID, $activityID, $instructionID, $assignmentID);
    $getReportURLStatement->execute();
    $getReportURLStatement->bind_result($reportURL);
    $getReportURLStatement->fetch();
    $getReportURLStatement->close();
    //create one if it doesn't exist.
    if (empty($reportURL)) {
        $reportURL = getFirebaseBaseURL() . getRandomString();
        $updateReportURLStatement = $mysqli->prepare("INSERT INTO report(groupid, activityid, instructionid, assignmentid, URL) VALUES (?, ?, ?, ?, ?)");
        $updateReportURLStatement->bind_param('iiiis', $groupID, $activityID, $instructionID, $assignmentID, $reportURL);
        $updateReportURLStatement->execute();
        error_log($mysqli->error);
        $updateReportURLStatement->close();
    }
    return $reportURL;    
}

function getCollaborativeInputToolInstructions($instructionID) {
    $instructions = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement1 = $mysqli->prepare("SELECT CIT_ID, QuestionPrompt, SpecificHint, GroupAnswerHeading from collaborativeinputtoolinstructions WHERE I_ID = ?");
    $statement1->bind_param('i', $instructionID);
    $statement1->execute();
    $statement1->bind_result($citID, $questionPrompt, $specificHint, $groupAnswerHeading);
    while($statement1->fetch()) {
        $instruction = new stdClass();
        $instruction->citID = $citID;
        $instruction->questionPrompt = $questionPrompt;
        $instruction->specificHint = $specificHint;
        $instruction->groupAnswerHeading = $groupAnswerHeading;
        $instructions[] = $instruction;
    }
    $statement1->close();
    return $instructions;
}

/*function getSessionKey($toolAcronym, $groupID, $assignmentID) {
    return $toolAcronym . "_session_" . $groupID . "_" . $assignmentID;
}*/

function getSessionKey($toolAcronym, $groupID, $assignmentID, $instructionID) {
    return $toolAcronym . "_session_" . $groupID . "_" . $assignmentID . "_" . $instructionID;
}

function getGroupMembers($groupID, $assignmentID, $user) {
    if (!isset($assignmentID)) {
        die("Invalid Assignment.");
    }
    if (!isset($user))  {
        $user = elgg_get_logged_in_user_entity();
    }
    if (!isset($groupID)) {
        $groupID = getGroupID($assignmentID, $user);
    }
    $groupMembers = get_group_members($groupID);

    return $groupMembers;
}
?>
