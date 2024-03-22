<?php
//Note: Include the dbConnection.php in the file that calls this file.

include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 

function getServerURL() {
    return "http://diana.shripat.com/themuse/";
    //return "http://localhost/Muse/";
}

function getApplicationName() {
    return "elggv2"; //part after host name
}

function getElggJSURL() {
    return "http://localhost/elgg_jsv2/";
}

function getFirebaseBaseURL() {
    return "glaring-inferno-212.firebaseIO.com/";
}

function getRandomString($length = 10) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function getAll($studentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $all = array();
    $courses = array();
    $result = $mysqli->query("Select courserun.CourseRunID, courserun.Code from courserun inner join courselist on courserun.CourseRunID = courselist.CourseRunID where courselist.Student_ID = '$studentID'");
    $result->data_seek(0);
    $assignments = array();
    $assignment = array();
    
    while ($row = $result->fetch_assoc()) {
        $courseCode = $row['Code'];
        $courseRun =  $row['CourseRunID'];
        $courses[$courseCode] = $courseRun;
        $result2 = $mysqli->query("SELECT * from assignment WHERE CourseRunID='$courseRun'");
        $result2->data_seek(0);
        
        while ($row2 = $result2->fetch_assoc()) {
            $assignment['course'] = $courseCode;
            $assignment['assignID'] = $row2['Assignment_ID'];
            $assignment['number'] = $row2['Number'];
            $assignments[] = $assignment;
        }
    }
    $all['courses'] = $courses;
    $all['assignments'] = $assignments;
    return $all;
}
function getStudentID() {
    $mysqli = get_CoreDB_link("mysqli");
    $student_GUID = elgg_get_logged_in_user_guid();
    $res = $mysqli->query("SELECT Student_ID from student WHERE ELGG_ID='$student_GUID'");
    $res->data_seek(0);
    if ($row = $res->fetch_assoc()) {
        $studentID =  $row['Student_ID'];
    }
    return $studentID;
}

function getUserEntities() {
    return elgg_get_entities(array(
    'types' => 'user',
    'callback' => 'my_get_entity_callback',
    'limit' => false,
    ));
}

function my_get_entity_callback($one_data_row) {
    $userEntities = array();
    $userGuid = $one_data_row -> guid;
    $currentUser = elgg_get_logged_in_user_guid();
    $userEntity = get_user($userGuid);
    if(!$userEntity -> isAdmin() && $currentUser != $userGuid) {
        $userEntities = elgg_view_entity($userEntity);
    }
    
    return $userEntities;
}

function getCourseCodes () {
    $mysqli = get_CoreDB_link("mysqli");
    $codes = array();
    $res = $mysqli->query("SELECT Code from course");
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $codes[] =  $row['Code'];
    }
    sort($codes);
    return $codes;
}

function getDomain () {
    $mysqli = get_CoreDB_link("mysqli");
    $domain = array();
    $res = $mysqli->query("SELECT DISTINCT domain from questiontype");
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $domain[] =  $row['domain'];
    }
    sort($domain);
    return $domain;
}

function getQuestionTypes () {
    $mysqli = get_CoreDB_link("mysqli");
    $questionTypes = array();
    $res = $mysqli->query("SELECT Name from questiontype");
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $questionTypes[] =  $row['Name'];
    }
    sort($questionTypes);
    return $questionTypes;
}


function getAssignments() {
    $mysqli = get_CoreDB_link("mysqli");
    $assignments = array();
    $res = $mysqli->query("SELECT Instructions FROM assignment");
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $assignments[] = $row['Instructions'];
    }
    sort($assignments);
    return $assignments;
}


function getStudentNameAndID() {
    $mysqli = get_CoreDB_link("mysqli");
    $students = array();
    $res = $mysqli->query("SELECT Student_ID, Name from student");
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $id = $row['Student_ID'];
        $name = $row['Name'];
        $students[$name] = $id;
    }
    return $students;
}

function getStudent($elggID) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStudentStatement = $mysqli->prepare("SELECT Student_ID, Name from student WHERE ELGG_ID = ?");
    $getStudentStatement->bind_param('i', $elggID);
    $getStudentStatement->execute();
    $getStudentStatement->bind_result($stuID, $stuName);
    while ($getStudentStatement->fetch()) {
        $student = new StdClass;
        $student->id = $stuID;
        $student->name = $stuName;
    }
    $getStudentStatement->close();
    return $student;
}

function getCourseRunByCode($courseCode) {
    $mysqli = get_CoreDB_link("mysqli");
    $getCourseRunStatement = $mysqli->prepare("SELECT CourseRunID, Code, Instructor_ID from courserun WHERE Code = ? AND IsArchived = 0");
    $getCourseRunStatement->bind_param('i', $courseCode);
    $getCourseRunStatement->execute();
    $getCourseRunStatement->bind_result($courseRunID, $code, $instructorID);
    while ($getCourseRuntatement->fetch()) {
        $courseRun = new StdClass;
        $courseRun->id = $courseRunID;
        $courseRun->code = $code;
        $courseRun->instructorID = $instructorID;
    }
    $getCourseRunStatement->fetch();
    $getCourseRunStatement->close();
    return $courseRunID;
}

function getCourseRunByID($coureRunID) {
    $mysqli = get_CoreDB_link("mysqli");
    $getCourseRunStatement = $mysqli->prepare("SELECT CourseRunID, Code, Instructor_ID from courserun WHERE CourseRunID = ?");
    $getCourseRunStatement->bind_param('i', $coureRunID);
    $getCourseRunStatement->execute();
    $getCourseRunStatement->bind_result($courseRunID, $code, $instructorID);
    while ($getCourseRuntatement->fetch()) {
        $courseRun = new StdClass;
        $courseRun->id = $courseRunID;
        $courseRun->code = $code;
        $courseRun->instructorID = $instructorID;
    }
    $getCourseRunStatement->fetch();
    $getCourseRunStatement->close();
    return $courseRunID;
}

function getAssignmentIDbyCourseRun($courseRunID, $assignNumber){
    $mysqli = get_CoreDB_link("mysqli");
    $getCourseRunStatement = $mysqli->prepare("SELECT Assignment_ID from assignment WHERE Number = ? AND CourseRunID = ?");
    $getCourseRunStatement->bind_param('ii', $assignNumber, $courseRunID);
    $getCourseRunStatement->execute();
    $getCourseRunStatement->bind_result($assignID);
    $getCourseRunStatement->fetch();
    $getCourseRunStatement->close();
    return $assignID;
}

function getAssignmentID($groupID, $studentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT AssignmentID from grouplist WHERE GroupELGG_ID = ? AND StudentELGG_ID = ?");
    $statement->bind_param('ii', $groupID, $studentID);
    $statement->execute();
    $statement->bind_result($assignID);
    $statement->fetch();
    $statement->close();
    return $assignID;
}

function getAssignmentDetails($assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Number, Description, StartDate, EndDate, Instructions, Weight, Domain, CourseRunID from assignment WHERE Assignment_ID = ?");
    $statement->bind_param('i', $assignmentID);
    $statement->execute();
    $statement->bind_result($number, $description, $startDate, $endDate, $instructions, $weight, $domain, $courseRunID);
    while ($statement->fetch()) {
        $assignmentDetails = new stdClass();
        $assignmentDetails->id = $assignmentID;
        $assignmentDetails->domain = $domain;
        $assignmentDetails->courseRunID = $courseRunID;
        $assignmentDetails->number = $number;
        $assignmentDetails->description = $description;
        $assignmentDetails->startDate = $startDate;
        $assignmentDetails->endDate = $endDate;
        $assignmentDetails->instructions = $instructions;
        $assignmentDetails->weight = $weight;
    }
    $statement->close();    
    return $assignmentDetails;    
}

function getAssignmentsByCourseCode($courseCode) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Number, Description, StartDate, EndDate, Instructions, Weight, Domain, CourseRunID from assignment WHERE CourseRunID = ?");
    $statement->bind_param('i', $courseCode);
    $statement->execute();
    $statement->bind_result($number, $description, $startDate, $endDate, $instructions, $weight, $domain, $courseRunID);
    while ($statement->fetch()) {
        $assignmentDetails = new stdClass();
        $assignmentDetails->id = $assignmentID;
        $assignmentDetails->domain = $domain;
        $assignmentDetails->courseRunID = $courseRunID;
        $assignmentDetails->number = $number;
        $assignmentDetails->description = $description;
        $assignmentDetails->startDate = $startDate;
        $assignmentDetails->endDate = $endDate;
        $assignmentDetails->instructions = $instructions;
        $assignmentDetails->weight = $weight;
    }
    $statement->close();    
    return $assignmentDetails;   
}

function getQuestionTypesByCourseCode($domain) {
    $mysqli = get_CoreDB_link("mysqli");
    $qTypes = array();
    $all = "All";
    $statement = $mysqli->prepare("SELECT QuestionTypeID, Name from questiontype WHERE Domain = ? OR Domain = ? ");
    $statement->bind_param('ss', $domain, $all);
    $statement->execute();
    $statement->bind_result($qtID, $name);
    while($statement->fetch()) {
        array_push($qTypes, array($qtID => $name));
    }
    $statement->close();
    return $qTypes;
}

function getCPs() {
    $mysqli = get_CoreDB_link("mysqli");
    $cps = array();
    $statement1 = $mysqli->prepare("SELECT CP_ID, Name, Complexity from creativepedagogy");
    $statement1->execute();
    $statement1->bind_result($cpID, $cpName, $cpComplexity);
    while($statement1->fetch()) {
        //array_push($cps, array($cpID => $cpName." - [".$cpOverview."]"));
        $cps[$cpID] = $cpName." - [".$cpComplexity."]";
    }
    $statement1->close();
    return $cps;
}

function getToolListing() {
    $mysqli = get_CoreDB_link("mysqli");
    $toolList = array();
    $statement1 = $mysqli->prepare("SELECT Tool_ID, Name, Description, URL from tool");
    $statement1->execute();
    $statement1->bind_result($tID, $toolName, $toolDesc, $toolURL);
    while($statement1->fetch()) {
        $tool = new StdClass;
        $tool->id = $tID;
        $tool->name = $toolName;
        $tool->description = $toolDesc;
        $tool->url = $toolURL;
        array_push($toolList, $tool);
    }
    $statement1->close();
    return $toolList;
}

function getGroupID($assignmentID, $userID) {
    if (!isset($userID))  {
        $userID = elgg_get_logged_in_user_guid();

    }
    $mysqli = get_CoreDB_link("mysqli");
    $getGroupIDStatement = $mysqli->prepare("SELECT GroupELGG_ID from grouplist WHERE AssignmentID = ? AND StudentELGG_ID = ?");
    $getGroupIDStatement->bind_param('ii', $assignmentID, $userID);
    $getGroupIDStatement->execute();
    $getGroupIDStatement->bind_result($groupID);
    $getGroupIDStatement->fetch();
    $getGroupIDStatement->close();
    
    if (!isset($groupID)) die("User is not enrolled in any group for this assignment.");
    return $groupID;
}

function getAssessmentFileName($groupID, $assignmentID) {
    return "\assessment_" . $groupID . "_" . $assignmentID;
}

function phpBrokenUpdatePOs($changedPos, $groupID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    foreach ($changedPos as $id => $text) {
        $statement = $mysqli->prepare("REPLACE INTO possiblesolutions(PO_ID, Group_ID, Assignment_ID, PO ) VALUES (?, ?, ?, ?)");
        $statement->bind_param('iiis', $id, $groupID, $assignmentID, $text);
        $statement->execute();
        error_log($mysqli->error);
        $statement->close();
    }
}

function setUpAssessmentFile($studentELGG_ID, $assignmentID) {
    $groupID = getGroupID($assignmentID, $studentELGG_ID);
    $assessmentFileName = getAssessmentFileName($groupID, $assignmentID);
    $assessmentFilePath = realpath(elgg_get_data_path()) . $assessmentFileName;
    if (!file_exists($assessmentFilePath)) {
        //create file
        //create the assessment folder if it doesn't exist.
        $handle = fopen($assessmentFilePath, 'w') or die('Cannot create file xxx1: ' . $assessmentFilePath);
        fclose($handle);
        $mysqli = get_CoreDB_link("mysqli");
        $statement = $mysqli->prepare("INSERT INTO groupassessment(GroupELGG_ID, Assignment_ID, FileLocation) VALUES (?, ?, ?)");
        $statement->bind_param('iis', $groupID, $assignmentID, $assessmentFileName);
        $statement->execute();
        $statement->close();
    }
}

function updatePOs($changedPos, $groupID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    foreach ($changedPos as $id => $text) {
        $statement = $mysqli->prepare("REPLACE INTO possiblesolutions(PO_ID, Group_ID, Assignment_ID, PO ) VALUES (?, ?, ?, ?)");
        $statement->bind_param('iiis', $id, $groupID, $assignmentID, $text);
        $statement->execute();
        error_log($mysqli->error);
        $statement->close();
    }
}

function savePOs($answersArray, $groupID, $assignmentID, $iID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("DELETE FROM possiblesolutions WHERE Instruction_ID = ? AND Group_ID = ? AND Assignment_ID = ? ");
    $statement->bind_param('iii', $iID, $groupID, $assignmentID);
    $statement->execute();
    foreach ($answersArray as $answer) {
        //error_log("adding " . $answer);
        $statement = $mysqli->prepare("INSERT INTO possiblesolutions(Instruction_ID, Group_ID, Assignment_ID, PO) VALUES (?, ?, ?, ?)");
        $statement->bind_param('iiis', $iID, $groupID, $assignmentID, $answer);
        $statement->execute();
        error_log($mysqli->error);
        $statement->close();
    }
}

function getPOs($groupID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $pos = array();
    $statement = $mysqli->prepare("SELECT PO, PO_ID from possiblesolutions WHERE Group_ID = ? AND Assignment_ID = ? ORDER BY PO_ID");
    $statement->bind_param('ii', $groupID, $assignmentID);
    $statement->execute();
    $statement->bind_result($po_text, $po_id);
    while($statement->fetch()) {
        $po = new stdClass();
        $po->text = $po_text;
        $po->id = $po_id;
        array_push($pos, $po);
    }
    $statement->close();
    return $pos;
}

function getProjectGroups($assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $projectGroups = array();
    $statement = $mysqli->prepare("SELECT GroupELGG_ID, StudentELGG_ID from grouplist WHERE AssignmentID = ? ORDER BY GroupELGG_ID");
    $statement->bind_param('i', $assignmentID);
    $statement->execute();
    $statement->bind_result($groupID, $studentID);
    while($statement->fetch()) {
        $group = new StdClass;
        $group->id = $groupID;
        $group->member = $studentID;
        array_push($projectGroups, $group);
    }
    $statement->close();
    return $projectGroups;
}

function storeFileGuidForGroupSolution($groupID, $assignmentID, $fileGuid) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("REPLACE INTO groupsolution(GroupELGG_ID, AssignmentID, FileGuid) VALUES (?, ?, ?)");
    $statement->bind_param('iii', $groupID, $assignmentID, $fileGuid);
    $statement->execute();
    $statement->close();
}

function getFileGuidForGroupSolution($groupID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT FileGuid from groupsolution WHERE GroupELGG_ID = ? AND AssignmentID = ?");
    $statement->bind_param('ii', $groupID, $assignmentID);
    $statement->execute();
    $statement->bind_result($fileGuid);
    $statement->fetch();
    $statement->close();
    return $fileGuid;
}

function storeGroupSolutionCreativeProcess($groupID, $assignmentID, $activityID, $instructionID, $toolID, $data, $chatData) {
    $mysqli = get_CoreDB_link("mysqli");
    //error_log("about to insert: $groupID, $assignmentID, $activityID, $instructionID, $toolID, $data, $chatData");
    $statement = $mysqli->prepare("REPLACE INTO groupsolutioncreativeprocess(GroupID, AssignmentID, ActivityID, InstructionID, ToolID, Data, ChatData) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->bind_param('iiiiiss', $groupID, $assignmentID, $activityID, $instructionID, $toolID, $data, $chatData);
    $statement->execute();
    $statement->close();
}

function getSpecificListMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    if ($instructionID == 0) {
        $getListMetrics = $mysqli->prepare("SELECT ListItemsAddedCount, ChatEntriesCount, TimeOnPage from listmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ?");
        $getListMetrics->bind_param('iis', $activityID, $assignmentID, $studentID);
        $getListMetrics->execute();
    }
    else {
        $getListMetrics = $mysqli->prepare("SELECT ListItemsAddedCount, ChatEntriesCount, TimeOnPage from listmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $getListMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
        $getListMetrics->execute();
    }
    $getListMetrics->bind_result($listItemsAddedCount, $chatEntriesCount,  $dbTimeOnPage);
    $getListMetrics->fetch();
    $getListMetrics->close();
    $metricsData = new stdClass();
    $metricsData->listItemsAddedCount = $listItemsAddedCount;
    $metricsData->chatEntriesCount = $chatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeListMetrics($activityID, $assignmentID, $studentID, $instructionID, $listItemsAddedCount, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredListAndApplyMetrics = $mysqli->prepare("SELECT ListItemsAddedCount, ChatEntriesCount, TimeOnPage from listmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredListAndApplyMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredListAndApplyMetrics->execute();
    $getStoredListAndApplyMetrics->bind_result($dbListItemsAddedCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredListAndApplyMetrics->fetch();
    $getStoredListAndApplyMetrics->close();


    if (isset($dbListItemsAddedCount) && $dbTimeOnPage > 0) { //if it exists, add the new numbers
        $dbListItemsAddedCount = $dbListItemsAddedCount + $listItemsAddedCount;
        $dbChatEntriesCount = $dbChatEntriesCount + $chatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE listmetrics SET ListItemsAddedCount = ?, ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $updateStatement->bind_param('iiiiisi', $dbListItemsAddedCount, $dbChatEntriesCount, $dbTimeOnPage, $activityID, $assignmentID, $studentID, $instructionID);
        $updateStatement->execute();
        $updateStatement->close();        
    }
    else { //insert a row if it's new
        $insertStatement = $mysqli->prepare("INSERT INTO listmetrics(ActivityID, AssignmentID, StudentID, InstructionID, ListItemsAddedCount, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertStatement->bind_param('iisiiii', $activityID, $assignmentID, $studentID, $instructionID, $listItemsAddedCount, $chatEntriesCount, $timeOnPage);
        $insertStatement->execute();
        $insertStatement->close();        
    }
}

function getCollaborativeInputMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $metricsData = new stdClass();
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredCollaborativeInputMetrics = $mysqli->prepare("SELECT ChatEntriesCount, TimeOnPage from collaborativeinputmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredCollaborativeInputMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredCollaborativeInputMetrics->execute();
    $getStoredCollaborativeInputMetrics->bind_result($dbChatEntriesCount, $dbTimeOnPage);
    $getStoredCollaborativeInputMetrics->fetch();
    $getStoredCollaborativeInputMetrics->close();
    $metricsData->chatEntries = $dbChatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeCollaborativeInputMetrics($activityID, $assignmentID, $studentID, $instructionID, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredCollaborativeInputMetrics = $mysqli->prepare("SELECT ChatEntriesCount, TimeOnPage from collaborativeinputmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredCollaborativeInputMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredCollaborativeInputMetrics->execute();
    $getStoredCollaborativeInputMetrics->bind_result($dbChatEntriesCount, $dbTimeOnPage);
    $getStoredCollaborativeInputMetrics->fetch();
    $getStoredCollaborativeInputMetrics->close();


    if (isset($dbChatEntriesCount) && $dbTimeOnPage > 0) { //if it exists, add the new numbers
        $dbChatEntriesCount = $dbChatEntriesCount + $chatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE collaborativeinputmetrics SET ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $updateStatement->bind_param('iiiisi', $dbChatEntriesCount, $dbTimeOnPage, $activityID, $assignmentID, $studentID, $instructionID);
        $updateStatement->execute();
        $updateStatement->close();        
    }
    else { //insert a row if it's new
        $insertStatement = $mysqli->prepare("INSERT INTO collaborativeinputmetrics(ActivityID, AssignmentID, StudentID, InstructionID, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?)");
        $insertStatement->bind_param('iisiii', $activityID, $assignmentID, $studentID, $instructionID, $chatEntriesCount, $timeOnPage);
        $insertStatement->execute();
        $insertStatement->close();        
    }
}

function getSpecificListAndApplyMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredListAndApplyMetrics = $mysqli->prepare("SELECT ListAnswerCount, POsEditedCount, ChatEntriesCount, TimeOnPage from listandapplymetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredListAndApplyMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredListAndApplyMetrics->execute();
    error_log($mysqli->error);
    $getStoredListAndApplyMetrics->bind_result($dbListAnswerCount, $dbPOsEditedCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredListAndApplyMetrics->fetch();
    $getStoredListAndApplyMetrics->close();
    $metricsData = new stdClass();
    $metricsData->listAnswerCount = $dbListAnswerCount;
    $metricsData->POsEditedCount = $dbPOsEditedCount;
    $metricsData->chatEntries = $dbChatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeListAndApplyMetrics($activityID, $assignmentID, $studentID, $instructionID, $listAnswerCount, $POsEditedCount, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredListAndApplyMetrics = $mysqli->prepare("SELECT ListAnswerCount, POsEditedCount, ChatEntriesCount, TimeOnPage from listandapplymetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredListAndApplyMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredListAndApplyMetrics->execute();
    $getStoredListAndApplyMetrics->bind_result($dbListAnswerCount, $dbPOsEditedCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredListAndApplyMetrics->fetch();
    $getStoredListAndApplyMetrics->close();


    if (isset($dbListAnswerCount) && $dbTimeOnPage > 0) { //if it exists, add the new numbers
        $dbListAnswerCount = $dbListAnswerCount + $listAnswerCount;
        $dbPOsEditedCount = $dbPOsEditedCount + $POsEditedCount;
        $dbChatEntriesCount = $dbChatEntriesCount + $chatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE listandapplymetrics SET ListAnswerCount = ?, POsEditedCount = ?, ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $updateStatement->bind_param('iiiiiisi', $dbListAnswerCount, $dbPOsEditedCount, $dbChatEntriesCount, $dbTimeOnPage, $activityID, $assignmentID, $studentID, $instructionID);
        $updateStatement->execute();
        $updateStatement->close();        
    }
    else { //insert a row if it's new
        $insertStatement = $mysqli->prepare("INSERT INTO listandapplymetrics(ActivityID, AssignmentID, StudentID, InstructionID, ListAnswerCount, POsEditedCount, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStatement->bind_param('iisiiiii', $activityID, $assignmentID, $studentID, $instructionID, $listAnswerCount, $POsEditedCount, $chatEntriesCount, $timeOnPage);
        $insertStatement->execute();
        $insertStatement->close();        
    }
}

function getSpecificConceptFanMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredConceptFanMetrics = $mysqli->prepare("SELECT PurposeIdeasCount, NodesCreatedCount, LeafNodesCreatedCount, ChatEntriesCount, TimeOnPage from conceptfanmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredConceptFanMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredConceptFanMetrics->execute();
    error_log($mysqli->error);
    $getStoredConceptFanMetrics->bind_result($dbPurposeIdeasCount, $dbNodesCreatedCount, $dbLeafNodesCreatedCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredConceptFanMetrics->fetch();
    $getStoredConceptFanMetrics->close(); 
    $metricsData = new stdClass();
    $metricsData->purposeIdeasCount = $dbPurposeIdeasCount;
    $metricsData->nodesCreatedCount = $dbNodesCreatedCount;
    $metricsData->leafNodesCreatedCount = $dbLeafNodesCreatedCount;
    $metricsData->chatEntries = $dbChatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeConceptFanMetrics($activityID, $assignmentID, $studentID, $instructionID, $purposeIdeasCount, $nodesCreatedCount, $leafNodesCreatedCount, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredConceptFanMetrics = $mysqli->prepare("SELECT PurposeIdeasCount, NodesCreatedCount, LeafNodesCreatedCount, ChatEntriesCount, TimeOnPage from conceptfanmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredConceptFanMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredConceptFanMetrics->execute();
    $getStoredConceptFanMetrics->bind_result($dbPurposeIdeasCount, $dbNodesCreatedCount, $dbLeafNodesCreatedCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredConceptFanMetrics->fetch();
    $getStoredConceptFanMetrics->close();


    if (isset($dbPurposeIdeasCount) && $dbTimeOnPage > 0) { //if it exists, add the new numbers
        $dbPurposeIdeasCount = $dbPurposeIdeasCount + $purposeIdeasCount;
        $dbNodesCreatedCount = $dbNodesCreatedCount + $nodesCreatedCount;
        $dbLeafNodesCreatedCount = $dbLeafNodesCreatedCount + $leafNodesCreatedCount;
        $dbChatEntriesCount = $dbChatEntriesCount + $chatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE conceptfanmetrics SET PurposeIdeasCount = ?, NodesCreatedCount = ?, LeafNodesCreatedCount = ?, ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $updateStatement->bind_param('iiiiiiisi', $dbPurposeIdeasCount, $dbNodesCreatedCount, $dbLeafNodesCreatedCount, $dbChatEntriesCount, $dbTimeOnPage, $activityID, $assignmentID, $studentID, $instructionID);
        $updateStatement->execute();
        $updateStatement->close();        
    }
    else { //insert a row if it's new
        $insertStatement = $mysqli->prepare("INSERT INTO conceptfanmetrics(ActivityID, AssignmentID, StudentID, InstructionID, PurposeIdeasCount, NodesCreatedCount, LeafNodesCreatedCount, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStatement->bind_param('iisiiiiii', $activityID, $assignmentID, $studentID, $instructionID, $purposeIdeasCount, $nodesCreatedCount, $leafNodesCreatedCount, $chatEntriesCount, $timeOnPage);
        $insertStatement->execute();
        $insertStatement->close();        
    }
}

function getSpecificChoiceMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    if ($instructionID == 0) {
        $getChoiceMetrics = $mysqli->prepare("SELECT ClearWeakerCount, ResetPOsCount, MovementsCount, ChatEntriesCount, TimeOnPage from choicemetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ?");
        $getChoiceMetrics->bind_param('iis', $activityID, $assignmentID, $studentID);
        $getChoiceMetrics->execute();
    }
    else {
        $getChoiceMetrics = $mysqli->prepare("SELECT ClearWeakerCount, ResetPOsCount, MovementsCount, ChatEntriesCount, TimeOnPage from choicemetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $getChoiceMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
        $getChoiceMetrics->execute();
    }
    $getChoiceMetrics->bind_result($clearWeakerCount, $resetPOsCount, $movementsCount, $chatEntriesCount,  $dbTimeOnPage);
    $getChoiceMetrics->fetch();
    $getChoiceMetrics->close();
    $metricsData = new stdClass();
    $metricsData->clearWeakerCount = $clearWeakerCount;
    $metricsData->resetPOsCount = $resetPOsCount;
    $metricsData->movementsCount = $movementsCount;
    $metricsData->chatEntriesCount = $chatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeChoiceMetrics($activityID, $assignmentID, $studentID, $instructionID, $clearWeakerCount, $resetPOsCount, $movementsCount, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredChoiceMetrics = $mysqli->prepare("SELECT ClearWeakerCount, ResetPOsCount, MovementsCount, ChatEntriesCount, TimeOnPage from choicemetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $getStoredChoiceMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
    $getStoredChoiceMetrics->execute();
    $getStoredChoiceMetrics->bind_result($dbClearWeakerCount, $dbResetPOsCount, $dbMovementsCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredChoiceMetrics->fetch();
    $getStoredChoiceMetrics->close();


    if (isset($dbClearWeakerCount)) { //if it exists, add the new numbers
        $dbClearWeakerCount = ($clearWeakerCount >= 0 ? $dbClearWeakerCount + $clearWeakerCount : $dbClearWeakerCount);
        $dbResetPOsCount = ($resetPOsCount >= 0 ? $dbResetPOsCount + $resetPOsCount : $dbClearWeakerCount);
        $dbMovementsCount = ($movementsCount >= 0 ? $dbMovementsCount + $movementsCount : $dbMovementsCount);
        $dbChatEntriesCount = $dbChatEntriesCount + $chatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE choicemetrics SET ClearWeakerCount = ?, ResetPOsCount = ?, MovementsCount = ?, ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $updateStatement->bind_param('iiiiiiisi', $dbClearWeakerCount, $dbResetPOsCount, $dbMovementsCount, $dbChatEntriesCount, $dbTimeOnPage, $activityID, $assignmentID, $studentID, $instructionID);
        $updateStatement->execute();
        $updateStatement->close();        
    }
    else { //insert a row if it's new
        $insertStatement = $mysqli->prepare("INSERT INTO choicemetrics(ActivityID, AssignmentID, StudentID, InstructionID, ClearWeakerCount, ResetPOsCount, MovementsCount, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStatement->bind_param('iisiiiiii', $activityID, $assignmentID, $studentID, $instructionID, $clearWeakerCount, $resetPOsCount, $movementsCount, $chatEntriesCount, $timeOnPage);
        $insertStatement->execute();
        $insertStatement->close();        
    }
}

function getSpecificReportMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    if ($instructionID == 0) {
        $getReportMetrics = $mysqli->prepare("SELECT WordCount, ChatEntriesCount, TimeOnPage from reportmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ?");
        $getReportMetrics->bind_param('iis', $activityID, $assignmentID, $studentID);
        $getReportMetrics->execute();
    }
    else {
        $getReportMetrics = $mysqli->prepare("SELECT WordCount, ChatEntriesCount, TimeOnPage from reportmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $getReportMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
        $getReportMetrics->execute();
    }
    $getReportMetrics->bind_result($wordCount, $chatEntriesCount,  $dbTimeOnPage);
    $getReportMetrics->fetch();
    $getReportMetrics->close();
    $metricsData = new stdClass();
    $metricsData->wordCount = $wordCount;
    $metricsData->chatEntriesCount = $chatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeReportMetrics($activityID, $studentID, $instructionID, $assignmentID, $wordCount, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredReportMetrics = $mysqli->prepare("SELECT WordCount, ChatEntriesCount, TimeOnPage from reportmetrics WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
    $getStoredReportMetrics->bind_param('iiii', $activityID, $studentID, $instructionID, $assignmentID);
    $getStoredReportMetrics->execute();
    $getStoredReportMetrics->bind_result($dbWordCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredReportMetrics->fetch();
    $getStoredReportMetrics->close();    
    
    if (isset($dbWordCount)) {
        $dbWordCount = ($wordCount >= 0 ? $wordCount : $dbWordCount);
        $dbChatEntriesCount = $dbChatEntriesCount + $chatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE reportmetrics SET WordCount = ?, ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
        $updateStatement->bind_param('iiiiiii', $dbWordCount, $dbChatEntriesCount, $dbTimeOnPage, $activityID, $studentID, $instructionID, $assignmentID);
        $updateStatement->execute();
        $updateStatement->close();           
    }
    else {
        if ($wordCount >= 0) { //if $wordCount < 0, this is a time update. A time update with no wordcount is pointless, so don't store. <-- is this true?
            $insertStatement = $mysqli->prepare("INSERT INTO reportmetrics(ActivityID, StudentID, InstructionID, AssignmentID, WordCount, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insertStatement->bind_param('iiiiiii', $activityID, $studentID, $instructionID, $assignmentID, $wordCount, $chatEntriesCount, $timeOnPage);
            $insertStatement->execute();
            $insertStatement->close();   
        }
    }
}

function storeRandomWordGeneratorMetrics($activityID, $studentID, $instructionID, $assignmentID, $wordsGeneratedCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredReportMetrics = $mysqli->prepare("SELECT WordsGeneratedCount, TimeOnPage from randomwordgeneratormetrics WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
    $getStoredReportMetrics->bind_param('iiii', $activityID, $studentID, $instructionID, $assignmentID);
    $getStoredReportMetrics->execute();
    $getStoredReportMetrics->bind_result($dbWordsGeneratedCount, $dbTimeOnPage);
    $getStoredReportMetrics->fetch();
    $getStoredReportMetrics->close();    
    
    if (isset($dbWordsGeneratedCount)) {
        $dbWordsGeneratedCount = ($wordCount >= 0 ? $wordCount : $dbWordsGeneratedCount);
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE randomwordgeneratormetrics SET WordsGeneratedCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
        $updateStatement->bind_param('iiiiii', $dbWordsGeneratedCount, $dbTimeOnPage, $activityID, $studentID, $instructionID, $assignmentID);
        $updateStatement->execute();
        $updateStatement->close();           
    }
    else {
        if ($wordsGeneratedCount >= 0) { //if $wordsGeneratedCount < 0, this is a time update. A time update with no wordcount is pointless, so don't store. <-- is this true?
            $insertStatement = $mysqli->prepare("INSERT INTO randomwordgeneratormetrics(ActivityID, StudentID, InstructionID, AssignmentID, WordsGeneratedCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStatement->bind_param('iiiiii', $activityID, $studentID, $instructionID, $assignmentID, $wordsGeneratedCount, $timeOnPage);
            $insertStatement->execute();
            $insertStatement->close();   
        }
    }
}

function getSpecificInAndOutMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    if ($instructionID == 0) {
        $getInAndOutMetrics = $mysqli->prepare("SELECT ResetPOsClicksCount, ClearOutClicksCount, MovementsCount, AddedCharacteristicsCount, ChatEntriesCount, TimeOnPage from inandoutmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ?");
        $getInAndOutMetrics->bind_param('iis', $activityID, $assignmentID, $studentID);
        $getInAndOutMetrics->execute();
    }
    else {
        $getInAndOutMetrics = $mysqli->prepare("SELECT ResetPOsClicksCount, ClearOutClicksCount, MovementsCount, AddedCharacteristicsCount, ChatEntriesCount, TimeOnPage from inandoutmetrics  WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $getInAndOutMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
        $getInAndOutMetrics->execute();
    }
    $getInAndOutMetrics->bind_result($resetPOsClicksCount, $clearOutClicksCount, $movementsCount, $addedCharacteristicsCount, $chatEntriesCount,  $dbTimeOnPage);
    $getInAndOutMetrics->fetch();
    $getInAndOutMetrics->close();
    $metricsData = new stdClass();
    $metricsData->resetPOsClicksCount = $resetPOsClicksCount;
    $metricsData->clearOutClicksCount = $clearOutClicksCount;
    $metricsData->movementsCount = $movementsCount;
    $metricsData->addedCharacteristicsCount = $addedCharacteristicsCount;
    $metricsData->chatEntriesCount = $chatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeInAndOutMetrics($activityID, $studentID, $instructionID, $assignmentID, $resetPOsClicksCount, $clearOutClicksCount, $movementsCount, $addedCharacteristicsCount, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredInAndOutMetrics = $mysqli->prepare("SELECT ResetPOsClicksCount, ClearOutClicksCount, MovementsCount, AddedCharacteristicsCount, ChatEntriesCount, TimeOnPage from inandoutmetrics WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
    $getStoredInAndOutMetrics->bind_param('iiii', $activityID, $studentID, $instructionID, $assignmentID);
    $getStoredInAndOutMetrics->execute();
    $getStoredInAndOutMetrics->bind_result($dbResetPOsClicksCount, $dbClearOutClicksCount, $dbMovementsCount, $dbAddedCharacteristicsCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredInAndOutMetrics->fetch();
    $getStoredInAndOutMetrics->close();    
    
    if (isset($dbResetPOsClicksCount)) {
        //$dbResetPOsClicksCount += $resetPOsClicksCount;
        $dbResetPOsClicksCount = ($resetPOsClicksCount >= 0 ? $dbResetPOsClicksCount + $resetPOsClicksCount : $dbResetPOsClicksCount);
        //$dbClearOutClicksCount += $clearOutClicksCount;
        $dbClearOutClicksCount = ($clearOutClicksCount >= 0 ? $dbClearOutClicksCount + $clearOutClicksCount : $dbClearOutClicksCount);
        //$dbMovementsCount += $movementsCount;
        $dbMovementsCount = ($movementsCount >= 0 ? $dbMovementsCount + $movementsCount : $dbMovementsCount);
        //$dbAddedCharacteristicsCount += $addedCharacteristicsCount;
        $dbAddedCharacteristicsCount = ($addedCharacteristicsCount >= 0 ? $dbAddedCharacteristicsCount + $addedCharacteristicsCount : $dbAddedCharacteristicsCount);
        $dbChatEntriesCount = ($chatEntriesCount >= 0) ? $dbChatEntriesCount + $chatEntriesCount : $dbChatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE inandoutmetrics SET ResetPOsClicksCount = ?, ClearOutClicksCount = ?, MovementsCount = ?, AddedCharacteristicsCount = ?, ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
        $updateStatement->bind_param('iiiiiiiiii', $dbResetPOsClicksCount, $dbClearOutClicksCount, $dbMovementsCount, $dbAddedCharacteristicsCount, $dbChatEntriesCount, $dbTimeOnPage, $activityID, $studentID, $instructionID, $assignmentID);
        $updateStatement->execute();
        $updateStatement->close();           
    }
    else {
        if ($resetPOsClicksCount < 0) {
            $resetPOsClicksCount = 0;
            $clearOutClicksCount = 0;
            $movementsCount = 0;
            $addedCharacteristicsCount = 0;
            $chatEntriesCount = 0;
        }
        $insertStatement = $mysqli->prepare("INSERT INTO inandoutmetrics(ActivityID, StudentID, InstructionID, AssignmentID, ResetPOsClicksCount, ClearOutClicksCount, MovementsCount, AddedCharacteristicsCount, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStatement->bind_param('iiiiiiiiii', $activityID, $studentID, $instructionID, $assignmentID, $resetPOsClicksCount, $clearOutClicksCount, $movementsCount, $addedCharacteristicsCount, $chatEntriesCount, $timeOnPage);
        $insertStatement->execute();
        $insertStatement->close();   
    }
}

function getSpecificRoundRobinMetrics($activityID, $assignmentID, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    if ($instructionID == 0) {
        $getRoundRobinMetrics = $mysqli->prepare("SELECT ViewsEnteredCount, ChatEntriesCount, TimeOnPage from roundrobinmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ?");
        $getRoundRobinMetrics->bind_param('iis', $activityID, $assignmentID, $studentID);
        $getRoundRobinMetrics->execute();
    }
    else {
        $getRoundRobinMetrics = $mysqli->prepare("SELECT ViewsEnteredCount, ChatEntriesCount, TimeOnPage from roundrobinmetrics WHERE ActivityID = ? AND AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
        $getRoundRobinMetrics->bind_param('iisi', $activityID, $assignmentID, $studentID, $instructionID);
        $getRoundRobinMetrics->execute();
    }
    $getRoundRobinMetrics->bind_result($viewsEnteredCount, $chatEntriesCount,  $dbTimeOnPage);
    $getRoundRobinMetrics->fetch();
    $getRoundRobinMetrics->close();
    $metricsData = new stdClass();
    $metricsData->viewsEnteredCount = $viewsEnteredCount;
    $metricsData->chatEntriesCount = $chatEntriesCount;
    $metricsData->timeOnPage = gmdate("H:i:s", $dbTimeOnPage);
    return $metricsData;
}

function storeRoundRobinMetrics($activityID, $studentID, $instructionID, $assignmentID, $viewsEnteredCount, $chatEntriesCount, $timeOnPage) {
    $mysqli = get_CoreDB_link("mysqli");
    $getStoredRoundRobinMetrics = $mysqli->prepare("SELECT ViewsEnteredCount, ChatEntriesCount, TimeOnPage from roundrobinmetrics WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
    $getStoredRoundRobinMetrics->bind_param('iiii', $activityID, $studentID, $instructionID, $assignmentID);
    $getStoredRoundRobinMetrics->execute();
    $getStoredRoundRobinMetrics->bind_result($dbViewsEnteredCount, $dbChatEntriesCount, $dbTimeOnPage);
    $getStoredRoundRobinMetrics->fetch();
    $getStoredRoundRobinMetrics->close();    
    
    if (isset($dbViewsEnteredCount)) {
        //if $viewsEnteredCount is -1, assume storeTimeOnPage from window.tabclose, not form submit and don't change count, otherwise add to existing count
        $dbViewsEnteredCount = ($viewsEnteredCount >= 0 ? ($dbViewsEnteredCount + $viewsEnteredCount) : $dbViewsEnteredCount); 
        $dbChatEntriesCount = $dbChatEntriesCount + $chatEntriesCount;
        $dbTimeOnPage += $timeOnPage;
        $updateStatement = $mysqli->prepare("UPDATE roundrobinmetrics SET ViewsEnteredCount = ?, ChatEntriesCount = ?, TimeOnPage = ? WHERE ActivityID = ? AND StudentID = ? AND InstructionID = ? AND AssignmentID = ?");
        $updateStatement->bind_param('iiiiiii', $dbViewsEnteredCount, $dbChatEntriesCount, $dbTimeOnPage, $activityID, $studentID, $instructionID, $assignmentID);
        $updateStatement->execute();
        $updateStatement->close();           
    }
    else {
        $viewsEnteredCount = ($viewsEnteredCount >= 0 ? $viewsEnteredCount : 0);
        $insertStatement = $mysqli->prepare("INSERT INTO roundrobinmetrics(ActivityID, StudentID, InstructionID, AssignmentID, ViewsEnteredCount, ChatEntriesCount, TimeOnPage) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertStatement->bind_param('iiiiiii', $activityID, $studentID, $instructionID, $assignmentID, $viewsEnteredCount, $chatEntriesCount, $timeOnPage);
        $insertStatement->execute();
        $insertStatement->close();   
    }
}

function getUserCPEngagement($assignmentID, $StudentELGGID, $toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT StageNumber, Iteration from usercpengagement WHERE Assignment_ID = ? AND Student_ELGG_ID = ? AND Tool_ID = ?");
    $statement->bind_param('iii', $assignmentID, $StudentELGGID, $toolID);
    $statement->execute();
    $statement->bind_result($stageNum, $iteration);
    $statement->fetch();
    $statement->close(); 
    $cpEngagement = new stdClass();
    $cpEngagement->stageNum = $stageNum;
    $cpEngagement->iteration = $iteration;
    return $cpEngagement;
}

function storeUserCPEngagement($StageNum, $assignmentID, $StudentELGGID, $toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    if (studentHasUsedToolInStage($StageNum, $assignmentID, $StudentELGGID, $toolID)) {
        if (studentHasUsedToolInAdvancedStage($StageNum, $assignmentID, $StudentELGGID, $toolID)) {
            //increment iteration
            $statement = $mysqli->prepare("UPDATE usercpengagement SET Iteration = Iteration + 1 WHERE Assignment_ID = ? AND StageNumber = ? AND Tool_ID = ? AND Student_ELGG_ID = ?");
            $statement->bind_param('iiii', $assignmentID, $StageNum, $toolID, $StudentELGGID);
            $statement->execute();
            $statement->close();
        }
    }
    else {
        $statement = $mysqli->prepare("INSERT INTO usercpengagement(StageNumber, Assignment_ID, Student_ELGG_ID, Tool_ID, Iteration) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param('iiiii', $StageNum, $assignmentID, $StudentELGGID, $toolID, $iteration = 1);
        $statement->execute();
        $statement->close();
    }
}

function studentHasUsedToolInAdvancedStage($StageNum, $assignmentID, $StudentELGGID, $toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT COUNT(*) from usercpengagement WHERE Assignment_ID = ? AND StageNumber > ? AND Tool_ID = ? AND Student_ELGG_ID = ?");
    $statement->bind_param('iiii', $assignmentID, $StageNum, $toolID, $StudentELGGID);
    $statement->execute();
    $statement->bind_result($numberOfRows);
    $statement->fetch();
    $statement->close();
    return $numberOfRows > 0;
}

function studentHasUsedToolInStage($StageNum, $assignmentID, $StudentELGGID, $toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT COUNT(*) from usercpengagement WHERE Assignment_ID = ? AND StageNumber = ? AND Tool_ID = ? AND Student_ELGG_ID = ?");
    $statement->bind_param('iiii', $assignmentID, $StageNum, $toolID, $StudentELGGID);
    $statement->execute();
    $statement->bind_result($numberOfRows);
    $statement->fetch();
    $statement->close();
    return $numberOfRows > 0;
}

function getGroupSolutionCreativeProcessByTool($groupID, $assignmentID, $activityID, $instructionID, $toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Data from groupsolutioncreativeprocess WHERE GroupID = ? AND AssignmentID = ? AND ActivityID = ? AND InstructionID = ? AND ToolID = ?");
    $statement->bind_param('iiiii', $groupID, $assignmentID, $activityID, $instructionID, $toolID);
    $statement->execute();
    $statement->bind_result($data);
    $statement->fetch();
    $statement->close();
    return $data;
}

function getGroupSolutionCreativeProcessChatData($groupID, $assignmentID, $activityID, $instructionID, $toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT ChatData from groupsolutioncreativeprocess WHERE GroupID = ? AND AssignmentID = ? AND ActivityID = ? AND InstructionID = ? AND ToolID = ?");
    $statement->bind_param('iiiii', $groupID, $assignmentID, $activityID, $instructionID, $toolID);
    $statement->execute();
    $statement->bind_result($chatData);
    $statement->fetch();
    $statement->close();
    return $chatData;
}

function getActivityInstructions() {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT I_ID, A_ID from a_instructions ORDER BY A_ID");
    $statement->execute();
    $statement->bind_result($iID, $aID);
    $aInstructions = array();
    $iIDs = array();
    if($statement->fetch()) {
        $prevaID = $aID;
        $iIDs[] = $iID;
    }
    while($statement->fetch()) {
        if($prevaID != $aID) {
            $aInstructions[$prevaID] = $iIDs;
            $prevaID = $aID;
            $iIDs = array();
            $iIDs[] = $iID;
        }
        else {
            $iIDs[] = $iID;
            $prevaID = $aID;
        }
    }
    $statement->close();
    return $aInstructions;
}
function getGroupSolutionCreativeProcess($groupID, $assignmentID) {
    $groupCreativeProcess = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT InstructionID, ToolID, Data, ChatData from groupsolutioncreativeprocess WHERE GroupID = ? AND AssignmentID = ?");
    $statement->bind_param('ii', $groupID, $assignmentID);
    $statement->execute();
    $statement->bind_result($instructionID, $toolID, $data, $chatData);
    while($statement->fetch()) {
        
        $creativeProcessByInstruction = new StdClass;
        $creativeProcessByInstruction->instructionID = $instructionID;
        $creativeProcessByInstruction->data = $data;
        $creativeProcessByInstruction->chatdata = $chatData;
        $creativeProcessByInstruction->toolID = $toolID;
        //array_push($groupCreativeProcess, $creativeProcessByInstruction);
        if(isset($groupCreativeProcess[$instructionID])) {
            array_push($groupCreativeProcess[$instructionID], $creativeProcessByInstruction);
        }
        else {
            $arr = array();
            $arr[] = $creativeProcessByInstruction;
            $groupCreativeProcess[$instructionID] = $arr;
        }
    }
    $statement->close();
    return $groupCreativeProcess;
}

function getInstruction($instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Description from a_instructions WHERE I_ID = ?");
    $statement->bind_param('i', $instructionID);
    $statement->execute();
    $statement->bind_result($desc);
    $statement->fetch();
    $statement->close();
    return $desc;
}

function getToolName($toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Name from tool WHERE Tool_ID = ?");
    $statement->bind_param('i', $toolID);
    $statement->execute();
    $statement->bind_result($name);
    $statement->fetch();
    $statement->close();
    return $name;
}
/*************
 * Creativity Pedagogy
 */
function getActivityDetails($activityID /*, $assignID*/) {
    $activity = array();
    //$questionTypeID = getQuestionTypeID($assignID);

    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Description from activity WHERE A_ID = ?");
    $statement->bind_param('i', $activityID);
    $statement->execute();
    $statement->bind_result($description);
    $statement->fetch();
    $statement->close();
    $activity['activityID'] = $activityID;
    $activity['description'] = $description;

    $statement1 = $mysqli->prepare("SELECT DISTINCT ains.i_id FROM `a_instructions` ains 
                                        INNER JOIN `instructions` ins ON ains.i_id = ins.i_id
                                        WHERE ains.a_id = ?");
    $statement1->bind_param('i', $activityID);
    $statement1->execute();
    $statement1->bind_result($instructionID);
    $statement1->store_result();
    
    $instructions = array();
    $instruction = new stdClass();
    $lines = array();
    $tools = array();
    while ($statement1->fetch()) {
        //GET INSTRUCTION LINES
        $statement3 = $mysqli->prepare("SELECT ins.line_id, ins.description FROM `instructions` ins
                                        WHERE ins.i_id = ?");
        $statement3->bind_param('i', $instructionID);
        $statement3->execute();
        $statement3->bind_result($lineID, $iDesc);
        $statement3->store_result();
        while ($statement3->fetch()) {
            $line = new stdClass();
            $line->id = $lineID;
            $line->desc = $iDesc;
            $lines[] = $line;
        }
        $statement3->close();
        //get tools
        $statement2 = $mysqli->prepare("SELECT t.name, t.description, t.url
                                            FROM  `tool` t
                                            INNER JOIN  `instructiontool` it ON it.Tool_ID = t.Tool_ID
                                            WHERE it.i_id = ?");
        $statement2->bind_param('i', $instructionID);
        $statement2->execute();
        $statement2->bind_result($name, $toolDesc, $url);
        while ($statement2->fetch()) {
            $tool = new stdClass();
            $tool->name = $name;
            $tool->desc = $toolDesc;
            $tool->url = $url;
            $tools[] = $tool;
        }
        $statement2->close();
        /////////////
        $instruction->id = $instructionID;
        $instruction->lines = $lines;
        $instruction->tools = $tools;
        $instructions[] = $instruction;
        $instruction = new stdClass();
        $lines = array();
        $tools = array();
    }
    $activity['instructions'] = $instructions;
    $statement1->close();
    return $activity;
}

function getQuestionTypeID($assignID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement1 = $mysqli->prepare("SELECT QuestionTypeID from assignment WHERE Assignment_ID = ?");
    $statement1->bind_param('i', $assignID);
    $statement1->execute();
    $statement1->bind_result($qtID);
    $statement1->fetch();
    $statement1->close();
    return $qtID;
}

function getCP($assignID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement1 = $mysqli->prepare("SELECT CreativePedagogyID from assignment WHERE Assignment_ID = ?");
    $statement1->bind_param('i', $assignID);
    $statement1->execute();
    $statement1->bind_result($cpID);
    $statement1->fetch();
    $statement1->close();
    return $cpID;
}

function getCPDetails($assignID) {
    $cpID = getCP($assignID);
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Name, Overview from creativepedagogy WHERE CP_ID = ?");
    $statement->bind_param('i', $cpID);
    $statement->execute();
    $statement->bind_result($cpName, $cpOverview);
    $statement->fetch();
    $statement->close();
    
    $details = array();
    $statement1 = $mysqli->prepare("SELECT DISTINCT cp.name, cp.description, sa.stagenumber FROM `cp_stages` cp 
                                    inner join `stageactivity` sa 
                                            on cp.cp_id = sa.cp_id 
                                            and cp.StageNumber = sa.StageNumber
                                    where cp.cp_id = ?");
    $statement1->bind_param('i', $cpID);
    $statement1->execute();
    $statement1->bind_result($cpStageName, $cpStageDesc, $stageNumber);
    $statement1->store_result();    

    $cp = new StdClass();
    $cp->name = $cpName;
    $cp->overview = $cpOverview;
    $stages = array();
    while ($statement1->fetch()) {
        $stage = new StdClass();
        $stage->name = $cpStageName;
        $stage->desc = $cpStageDesc;
        $stage->num = $stageNumber;
        //search for activities per stagenumber
        $statement2 = $mysqli->prepare("SELECT a.a_id, a.description, a.shortdescription FROM `stageactivity` sa 
                                    inner join `activity` a
                                            on sa.A_ID = a.A_ID
                                    where sa.stagenumber = ? AND cp_id = ?");
        $statement2->bind_param('ii', $stageNumber, $cpID);
        $statement2->execute();
        $statement2->bind_result($aID, $activityDesc, $activityShortDesc);
        $statement2->store_result();
        $activities = array(); //GET ACTIVITIES FROM RULE ENGINE, NOT DB
        while ($statement2->fetch()) {
            $activity = new StdClass();
            $activity->desc = $activityDesc;
            $activity->shortDesc = $activityShortDesc;
            $activity->num = $aID;
            $activities[] = $activity;
        }
        $statement2->close();
        $stage->activities = $activities;
        $stages[] = $stage;
    }
    $cp->stages = $stages;
    $statement1->close();
    return $cp;
}
/*** End of Creativity Pedagogy ****/

function saveCSDSResponses($groupID, $assignmentID, $rawResponses, $total) {//not being used anymore
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("INSERT INTO csdsresponses(GroupID, AssignmentID, RawResponses, Total) VALUES (?, ?, ?, ?)");
    $statement->bind_param('iisi', $groupID, $assignmentID, $rawResponses, $total);
    $statement->execute();
    $statement->close();
}

function getCitInstruction($citID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement1 = $mysqli->prepare("SELECT QuestionPrompt from collaborativeinputtoolinstructions WHERE CIT_ID = ?");
    $statement1->bind_param('i', $citID);
    $statement1->execute();
    $statement1->bind_result($questionPrompt);
    $statement1->fetch();
    $statement1->close();
    return $questionPrompt;
}

function saveCriteriaWeights($assignID, $criteriaArray) {
    $mysqli = get_CoreDB_link("mysqli");
    foreach ($criteriaArray as $criteriaID => $weight) {
        $statement = $mysqli->prepare("INSERT INTO csds_assignment_criteria(AssignmentID, CriteriaID, Weight) VALUES (?, ?, ?)");
        $statement->bind_param('iii', $assignID, $criteriaID, $weight);
        $statement->execute();
        error_log("SQL ERROR saveCriteriaWeights: " . $assignID . " err:" . $mysqli->error);
        $statement->close();
    }
}

function saveHeadingWeights($assignID, $headingArray) {
    $mysqli = get_CoreDB_link("mysqli");
    foreach ($headingArray as $headingID => $weight) {
        $statement = $mysqli->prepare("INSERT INTO csds_assignment_headingcriteria(AssignmentID, HeadingID, Weight) VALUES (?, ?, ?)");
        $statement->bind_param('iii', $assignID, $headingID, $weight);
        $statement->execute();
        $statement->close();
    }
}

function getAllCriteria($assignID) {
    $allCriteria = array();
    $mysqli = get_CoreDB_link("mysqli");
    if($statement = $mysqli->prepare("SELECT ah.HeadingID, Weight, Name, Description from
                                    csds_assignment_headingcriteria as ah
                                        inner join
                                            csds_heading as ch
                                        on ah.HeadingID = ch.HeadingID
                                    where ah.AssignmentID = ?")) {//; 
        $statement->bind_param('i', $assignID);
    }
    else {
        error_log("db error ".$mysqli->error);
    }
    $statement->execute();
    $statement->bind_result($headingID, $headWeight, $headName, $headDesc);
    $statement->store_result();
    while ($statement->fetch()) {
        if($statement1 = $mysqli->prepare("select ac.CriteriaID, Weight, Name, Description from 
                                        csds_assignment_criteria as ac 
                                                inner join 
                                                        csds_criteria as c 
                                                on ac.CriteriaID = c.CriteriaID 
                                        where ac.AssignmentID = ? and c.headingid = ?")) {//;
            $statement1->bind_param('ii', $assignID, $headingID);
        }
        else {
            error_log("db error ".$mysqli->error);
        }
        $statement1->execute();
        $statement1->bind_result($criteriaID, $critWeight, $critName, $critDesc);
        $critArray = array();
        while ($statement1->fetch()) {
            $crit = new stdClass();
            $crit->name = $critName;
            $crit->desc = $critDesc;
            $crit->weight = $critWeight;
            $critArray[$criteriaID] = $crit;
        }
        $head = new stdClass();
        $head->name = $headName;
        $head->desc = $headDesc;
        $head->weight = $headWeight;
        $head->critArray = $critArray;
        $allCriteria[$headingID] = $head;
        $statement1->close();
    }
    $statement->close();
    return $allCriteria;
}

// returns true if $needle is a substring of $haystack
function contains($needle, $haystack)
{
    return stripos($haystack, $needle) !== false;
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== FALSE;
}

function storeSocialArtefacts($instructionID, $objURL, $objSubtype, $objOwnerGUID, $groupID, $activityID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("INSERT INTO socialartefacts(InstructionID, ObjURL, ObjSubType, UserELGGID, GroupID, ActivityID, AssignID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->bind_param('issiiii', $instructionID, $objURL, $objSubtype, $objOwnerGUID, $groupID, $activityID, $assignmentID);
    $statement->execute();
    $statement->close();
}

function getSocialArtefacts($iID, $groupID, $assignmentID) {
    error_log($iID);
    $artefacts = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT ObjURL, ObjSubType, UserELGGID from socialartefacts WHERE InstructionID = ? AND GroupID = ? AND AssignID = ?");
    $statement->bind_param('iii', $iID, $groupID, $assignmentID);
    $statement->execute();
    $statement->bind_result($objURL, $objSubtype, $objOwnerGUID);
    while ($statement->fetch()) {
        error_log("The data: $objURL, $objSubtype, $objOwnerGUID");
        $artefact = new stdClass();
        $artefact->url = $objURL;
        $artefact->type = $objSubtype;
        $artefact->user = $objOwnerGUID;
        $artefacts[] = $artefact;
    }
    $statement->close();
    return $artefacts;
}

function addStudentAddedActivity($parentAID, $stageNum, $cpID, $shortDesc, $desc) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("INSERT INTO studentaddedactivities(ParentAID, StageNumber, CP_ID, ShortDescription, Description) VALUES (?, ?, ?, ?, ?)");
    $statement->bind_param('iiiss', $parentAID, $stageNum, $cpID, $shortDesc, $desc);
    $statement->execute();
    $id = $mysqli->insert_id;
    $statement->close();
    return $id;
}

function addStudentAddedInstruction($aid, $desc) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("INSERT INTO studentaddedinstructions(A_ID, Description) VALUES (?, ?)");
    $statement->bind_param('is', $aid, $desc);
    $statement->execute();
    $statement->close();
}

function addStudentAddedTool($aid, $url, $name) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("INSERT INTO studentaddedtools(A_ID, URL, Name) VALUES (?, ?, ?)");
    $statement->bind_param('iss', $aid, $url, $name);
    $statement->execute();
    $statement->close();
}

function getToolURL($toolID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT URL from tool WHERE Tool_ID = ?");
    $statement->bind_param('i', $toolID);
    $statement->execute();
    $statement->bind_result($url);
    $statement->fetch();
    $statement->close();
    return $url;
}

function getStudentCreatedActivities($stageNum, $cpID) {
    $studentCreatedActivities = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT A_ID, ShortDescription, Description from studentaddedactivities WHERE StageNumber = ? AND CP_ID = ?");
    $statement->bind_param('ii', $stageNum, $cpID);
    $statement->execute();
    $statement->bind_result($aid, $shortDesc, $desc);
    while ($statement->fetch()) {
        $studentCreatedActivity = new stdClass();
        $studentCreatedActivity->aid = $aid;
        $studentCreatedActivity->shortDesc = $shortDesc;
        $studentCreatedActivity->desc = $desc;
        $studentCreatedActivities[] = $studentCreatedActivity;
    }
    $statement->close();
    return $studentCreatedActivities;
}

function getStudentCreatedInstructions($aID) {
    $instructions = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Description from studentaddedinstructions WHERE A_ID = ?");
    $statement->bind_param('i', $aID);
    $statement->execute();
    $statement->bind_result($desc);
    while ($statement->fetch()) {
        $instructions[] = $desc;
    }
    $statement->close();
    return $instructions;
}

function getStudentCreatedTools($aID) {
    $tools = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT URL, Name from studentaddedtools WHERE A_ID = ?");
    $statement->bind_param('i', $aID);
    $statement->execute();
    $statement->bind_result($url, $name);
    while ($statement->fetch()) {
        $tool = new stdClass();
        $tool->url = $url;
        $tool->name = $name;
        $tools[] = $tool;
    }
    $statement->close();
    return $tools;
}

function getActivityDescription($aid) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Description from studentaddedactivities WHERE A_ID = ?");
    $statement->bind_param('i', $aid);
    $statement->execute();
    $statement->bind_result($desc);
    $statement->fetch();
    $statement->close();
    return $desc;
}

function getEngagement() {
    return 56;
}
//////////////////////////////////////////////////////////////////////////
function getActivityMappingID($activityID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT MappingID from activitymapping WHERE AID = ?");
    $statement->bind_param('i', $activityID);
    $statement->execute();
    $statement->bind_result($mappingID);
    $statement->fetch();
    $statement->close();
    return $mappingID;
}
function getSuggestedActivities($studentID, $activityID, $assignmentID, $stageNumber) {
    $mappingID = getActivityMappingID($activityID);
    $suggestions = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT activitymapping.AID, activity.ShortDescription from activitymapping inner join activity on activitymapping.AID = activity.A_ID WHERE activitymapping.MappingID = ?");
    $statement->bind_param('i', $mappingID);
    $statement->execute();
    $statement->bind_result($aid, $shortDescription);
    while ($statement->fetch()) {
        if($activityID != $aid) { //problem activity should not be included in the list.
            $activity = new stdClass();
            $activity->aid = $aid;
            $activity->priority = 0;
            $activity->mapping = $mappingID;
            $activity->cpid = 0;
            $activity->shortDescription = $shortDescription;
            $suggestions[] = $activity;
        }
    }
    $statement->close();
    
    return $suggestions;
}

function getcpID($activityID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT CP_ID from stageactivity WHERE A_ID = ?");
    $statement->bind_param('i', $activityID);
    $statement->execute();
    $statement->bind_result($cpid);
    $statement->fetch();
    $statement->close();
    return $cpid;
}
function cmp($a, $b){
    return ($a->priority <= $b->priority);
}
function rulePrioritizeByCP($studentID, $activityID, $assignmentID, $stageNumber) {
    $suggestions = array();
    $suggestions = getSuggestedActivities($studentID, $activityID, $assignmentID, $stageNumber);
    $problemActivityCP = getcpID($activityID);
    foreach ($suggestions as $activity) {
        $activity->cpid = getcpID($activity->aid);
        if($problemActivityCP == $activity->cpid) {
            $activity->priority = 33;
        }
    }
    usort($suggestions, "cmp");
    return $suggestions;
}

function getcpComplexity($cpid) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT ComplexityNumber from creativepedagogy WHERE CP_ID = ?");
    $statement->bind_param('i', $cpid);
    $statement->execute();
    $statement->bind_result($complexity);
    $statement->fetch();
    $statement->close();
    return $complexity;
}

//if the problemActivity CP's complexity is less than the suggested activity then increase priority,
//so the simpler activities are suggested first.
function rulePrioritizeByComplexity($suggestions, $cpID) {
    $problemActivityCpComplexity = getcpComplexity($cpID);
    foreach ($suggestions as $activity) {
        $activity->complexity = getcpComplexity($activity->cpid);
        if($problemActivityCpComplexity < $activity->complexity) {
                $activity->priority = $activity->priority + 33;
        }
    }
    usort($suggestions, "cmp");
    return $suggestions;
}
//need to now set up the studentmodel, read from the db, and if the criteria of the problem activity is the
//same as the criteria that the student rates badly in, then, set complexity to the lowest complexity.
function getCriteriaList($activityID) {
    $criteriaList = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT CriteriaID from activitycriteria WHERE AID = ?");
    $statement->bind_param('i', $activityID);
    $statement->execute();
    $statement->bind_result($criteria);
    while ($statement->fetch()) {
        $criteriaList[] = $criteria;
    }
    $statement->close();
    return $criteriaList;
}

function getStudentCriteriaScore($criteria, $studentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Rating from student_csds_responses WHERE CriteriaID = ? AND StudentID = ?");
    $statement->bind_param('ii', $criteria, $studentID);
    $statement->execute();
    $statement->bind_result($score);
    $statement->fetch();
    $statement->close();
    return $score;
}

//if the score is low, then show the simplest activities first, that is, activities from lowest complexity cp
function rulePrioritizeByStudentCriteria($suggestions, $activityID, $studentID) {//all the criteria are csds
    $problemActivityCriteriaList = getCriteriaList($activityID);
    $scoreTotal = 0;
    foreach ($problemActivityCriteriaList as $criteria) {
        $score = getStudentCriteriaScore($criteria, $studentID);
        error_log("criteria score ". $criteria. " " .$score);
        $scoreTotal += $score;        
    }
    $studentProblemCriteriaScore = $scoreTotal/25;
    if($studentProblemCriteriaScore < 13) {
        //score is low
        foreach($suggestions as $suggestion) {
            if($suggestion->complexity == 1)
                $suggestion->priority = $suggestion->priority + 33;
            elseif ($suggestion->complexity == 2)
                $suggestion->priority = $suggestion->priority + 23;
            elseif ($suggestion->complexity == 3)
                $suggestion->priority = $suggestion->priority + 13;
            elseif ($suggestion->complexity == 4)
                $suggestion->priority = $suggestion->priority + 3;
        }
    }
    else {  //score is high and do nothing
         }
    usort($suggestions, "cmp");
    return $suggestions;
}

function getCreativityFactors($assignmentID, $currentUser, $studentELGGID) {
    $creativityFactors = array();
    $assignmentDetails = getAssignmentDetails($assignmentID);

    $factor = new stdClass();
    $factor->id = 1;
    $factor->name = "Task Understanding";
    $factor->rating = getTaskUnderstandingRating($currentUser, $assignmentDetails);
    $factor->classAverage = getTaskUnderstandingRatingClassAverage($assignmentDetails);
    $creativityFactors[] = $factor;
    
    $factor = new stdClass();
    $factor->id = 2;
    $factor->name = "Explore/Play";
    $factor->rating = getExploreRating($currentUser, $assignmentDetails);
    $factor->classAverage = getExploreRatingClassAverage($assignmentDetails);
    $creativityFactors[] = $factor;
    
    $factor = new stdClass();
    $factor->id = 3;
    $factor->name = "Communication";
    $factor->rating = getCommunicationRating($currentUser, $assignmentDetails);
    $factor->classAverage = getCommunicationRatingClassAverage($assignmentDetails);
    $creativityFactors[] = $factor;
    
    $factor = new stdClass();
    $factor->id = 4;
    $factor->name = "Data Gathering";
    $factor->rating = getDataGatheringRating($assignmentDetails, $currentUser);
    $factor->classAverage = getDataGatheringRatingClassAverage($assignmentDetails);
    $creativityFactors[] = $factor;
    
    $factor = new stdClass();
    $factor->id = 5;
    $factor->name = "Data Analysis";
    $factor->rating = getDataAnalysisRating($assignmentDetails, $currentUser);
    $factor->classAverage = getDataAnalysisRatingClassAverage($assignmentDetails);
    $creativityFactors[] = $factor;
    
    $factor = new stdClass();
    $factor->id = 6;
    $factor->name = "Idea Generation or Divergent Thinking";
    $factor->rating = getIdeaGenerationRating($assignmentDetails, $currentUser);
    $factor->classAverage = getIdeaGenerationRatingClassAverage($assignmentDetails);
    $creativityFactors[] = $factor;
    
    $factor = new stdClass();
    $factor->id = 7;
    $factor->name = "Idea Analysis / Evaluation / Convergent Thinking";
    $factor->rating = getConvergentThinkingRating($currentUser, $assignmentDetails);
    $factor->classAverage = getConvergentThinkingRatingClassAverage($assignmentDetails);
    $creativityFactors[] = $factor;
    
    return $creativityFactors;
}

function getTaskUnderstandingRating($currentUser, $assignmentDetails) {
    $toolID = 1; $instructionID = 1; $activityID = 1;
    $citIDs = array();
    $citIDs[0] = 1; $citIDs[1] = 2; $citIDs[2] = 3;//CIT_ID 1, 2, 3
    
    //Given a student ID, get his Group ID (Student can only be in 1 Group) 
    $groupID = getGroupID($assignmentDetails->id, $currentUser->guid);
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentDetails->id);
    
    $count = getUserResponsesCount($data, $citIDs, $currentUser->guid);
    $studentScore = round(getRating($count, 100, 1.1, 2, 3));
    return $studentScore; 
}

function getTaskUnderstandingRatingClassAverage($assignmentDetails) {
    $rating = 0;
    $studentsInClass = getStudentsForAssignment($assignmentDetails);
    foreach ($studentsInClass as $studentID) {
        $user = get_entity($studentID);
        $rating += getTaskUnderstandingRating($user, $assignmentDetails);
    }
    return round($rating / count($studentsInClass));   
}

function getAllGroupMembers($groupID, $assignmentID) {
    $allGroupMemberIDs = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT StudentELGG_ID from grouplist WHERE GroupELGG_ID = ? AND AssignmentID = ?");
    $statement->bind_param('ii', $groupID, $assignmentID);
    $statement->execute();
    $statement->bind_result($groupMemberID);
    while ($statement->fetch()) {
        $allGroupMemberIDs[] = $groupMemberID;
    }
    $statement->close();
    return $allGroupMemberIDs;
}

function getAllGroups($assignmentID, $activityID, $instructionID, $toolID) {
    $allGroupIDs = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT GroupID from groupsolutioncreativeprocess WHERE AssignmentID = ? AND ActivityID = ? AND InstructionID = ? AND ToolID = ?");
    $statement->bind_param('iiii', $assignmentID, $activityID, $instructionID, $toolID);
    $statement->execute();
    $statement->bind_result($groupID);
    while ($statement->fetch()) {
        $allGroupIDs[] = $groupID;
    }
    $statement->close();
    return $allGroupIDs;
}

function getAllGroups2($assignmentID, $activityID, $toolID) {
    $allGroupIDs = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT GroupID from groupsolutioncreativeprocess WHERE AssignmentID = ? AND ActivityID = ? AND ToolID = ?");
    $statement->bind_param('iii', $assignmentID, $activityID, $toolID);
    $statement->execute();
    $statement->bind_result($groupID);
    while ($statement->fetch()) {
        $allGroupIDs[] = $groupID;
    }
    $statement->close();
    return $allGroupIDs;
}

function IsNullOrEmptyString($string){
    return (!isset($string) || trim($string)==="");
}

function getUserResponsesCount($data, $citIDkeys, $currentUserID) {
    $count = 0;
    $decodedData = json_decode($data, TRUE);
    $allGroupResponses = $decodedData['groupResponses'];
    //error_log("AAB> allGroupResponses:" . print_r($allGroupResponses, true));
    if (isset($allGroupResponses)) {
        foreach ($allGroupResponses as $groupResponse) {
            $citID = $groupResponse['citID'];
            $userResponses = $groupResponse['userResponses'];
            foreach ($userResponses as $userResponse) {
                $userID   = $userResponse['userID'];
                $answer = $userResponse['answer'];
                if($currentUserID == $userID) {
                    switch ($citID) {
                        case $citIDkeys[0]:
                        case $citIDkeys[1]:
                        case $citIDkeys[2]:
                        case $citIDkeys[3]:
                        case $citIDkeys[4]:
                        case $citIDkeys[5]:
                        case $citIDkeys[6]:
                        case $citIDkeys[7]:
                        case $citIDkeys[8]:
                            if (!IsNullOrEmptyString($answer)) {
                                $count++;
                            }
                            break;
                        default:
                            break;
                    }
                }            
            }
        }
    }
    return $count;
}

function getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Data from groupsolutioncreativeprocess WHERE GroupID = ? AND AssignmentID = ? AND ActivityID = ? AND InstructionID = ? AND ToolID = ?");
    $statement->bind_param('iiiii', $groupID, $assignmentID, $activityID, $instructionID, $toolID);
    $statement->execute();
    $statement->bind_result($data);
    $statement->fetch();
    $statement->close();
    return $data;
}

/**
 * getListMetrics
 *
 * Gets list metrics for a given student, assignment, activity within a range of instructionids
 *
 * @param studentID Student's ELGG ID
 * @param assignmentID The assignmentID
 * @param activityIDs An array of activityIDs
 * @param instructionIDs An array of instructionIDs
 * @return listMetric An object containing listItemsAddedCount, chatEntriesCount and timeOnPage
 */
function getListMetrics($studentID, $assignmentID, $activityIDs, $instructionIDs) {
    $activityIDList = implode(', ', $activityIDs);
    $instructionIDList = implode(', ', $instructionIDs); // 3, 4, 5
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT ListItemsAddedCount, ChatEntriesCount, TimeOnPage from listmetrics WHERE AssignmentID = ? AND StudentID = ? AND ActivityID IN ($activityIDList) AND InstructionID IN ($instructionIDList)");
    $statement->bind_param('ii', $assignmentID, $studentID);
    $statement->execute();
    $statement->bind_result($listItemsAddedCount, $chatEntriesCount, $timeOnPage);
    while ($statement->fetch()) {
        $listMetric = new stdClass();
        $listMetric->listItemsAddedCount = $listItemsAddedCount;
        $listMetric->chatEntriesCount = $chatEntriesCount;
        $listMetric->timeOnPage = $timeOnPage;
        $listMetrics[] = $listMetric;
    }
    $statement->close();    
    return $listMetrics;
}

function getTotalListItemsAddedCount($listMetrics) {
    $totalListItemsAddedCount = 0;
    if (isset($listMetrics)) {
        foreach ($listMetrics as $metric) {
            if (isset($metric->listItemsAddedCount)) {
                $totalListItemsAddedCount += $metric->listItemsAddedCount;
            }
        }
    }
    return $totalListItemsAddedCount;
}

function getListAndApplyMetrics($assignmentDetails, $studentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT ListAnswerCount, POsEditedCount, ChatEntriesCount, TimeOnPage from listandapplymetrics WHERE AssignmentID = ? AND StudentID = ?");
    $statement->bind_param('ii', $assignmentDetails->id, $studentID);
    $statement->execute();
    $statement->bind_result($listAnswerCount, $posEditedCount, $chatEntriesCount, $timeOnPage);
    while ($statement->fetch()) {
        $laaMetric = new stdClass();
        $laaMetric->listAnswerCount = $listAnswerCount;
        $laaMetric->posEditedCount = $posEditedCount;
        $laaMetric->chatEntriesCount = $chatEntriesCount;
        $laaMetric->timeOnPage = $timeOnPage;
        $laaMetrics[] = $laaMetric;
    }
    $statement->close();    
    return $laaMetrics;
}

function getReportMetrics($assignmentDetails, $studentID, $instructionID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT WordCount, ChatEntriesCount, TimeOnPage from reportmetrics WHERE AssignmentID = ? AND StudentID = ? AND InstructionID = ?");
    $statement->bind_param('iii', $assignmentDetails->id, $studentID, $instructionID);
    $statement->execute();
    $statement->bind_result($wordCount, $chatEntriesCount, $timeOnPage);
    while ($statement->fetch()) {
        $reportMetric = new stdClass();
        $reportMetric->wordCount = $wordCount;
        $reportMetric->chatEntriesCount = $chatEntriesCount;
        $reportMetric->timeOnPage = $timeOnPage;
        $reportMetrics[] = $reportMetric;
    }
    $statement->close();    
    return $reportMetrics;
}

function getTotalReportWordCount($reportMetrics) {
    $totalWordCount = 0;
    if (is_array($reportMetrics)) {
        foreach ($reportMetrics as $metric) {
            $totalWordCount += $metric->wordCount;
        }
    }
    return $totalWordCount;
}

function getTotalTimeOnPageFromMetric($metrics) {
    $totalTimeOnPage = 0;
    if (is_array($metrics)) {
        foreach ($metrics as $metric) {
            $totalTimeOnPage += $metric->timeOnPage;
        }
    }
    return $totalTimeOnPage;    
}

function getTotalListAnswerCount($laaMetrics) {
    $totalListAnswerCount = 0;
    if (is_array($laaMetrics)) {
        foreach ($laaMetrics as $metric) {
            $totalListAnswerCount += $metric->listAnswerCount;
        }
    }
    return $totalListAnswerCount;
}

function getTotalPOSEditedCountCount($laaMetrics) {
    $totalPOSEditedCount = 0;
    if (is_array($laaMetrics)) {
        foreach ($laaMetrics as $metric) {
            $totalPOSEditedCount += $metric->posEditedCount;
        }
    }
    return $totalPOSEditedCount;
}

function getConceptFanMetrics($assignmentID, $studentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT PurposeIdeasCount, NodesCreatedCount, LeafNodesCreatedCount, ChatEntriesCount, TimeOnPage from conceptfanmetrics WHERE AssignmentID = ? AND StudentID = ?");
    $statement->bind_param('ii', $assignmentID, $studentID);
    $statement->execute();
    $statement->bind_result($purposeIdeasCount, $nodesCreatedCount, $leafNodesCreatedCount, $chatEntriesCount, $timeOnPage);
    $cfMetrics = array();
    while ($statement->fetch()) {
        $cfMetric = new stdClass();
        $cfMetric->purposeIdeasCount = $purposeIdeasCount;
        $cfMetric->nodesCreatedCount = $nodesCreatedCount;
        $cfMetric->leafNodesCreatedCount = $leafNodesCreatedCount;
        $cfMetric->chatEntriesCount = $chatEntriesCount;
        $cfMetric->timeOnPage = $timeOnPage;
        $cfMetrics[] = $cfMetric;
    }
    $statement->close();    
    return $cfMetrics;
}

function getTotalCFNodesCreated($cfMetrics) {
    $totalCFNodesCreated = 0;
    foreach ($cfMetrics as $metric) {
        $totalCFNodesCreated += $metric->nodesCreatedCount;
    }
    return $totalCFNodesCreated;
}

function getTotalCFLeafNodesCreated($cfMetrics) {
    $totalCFLeafNodesCreated = 0;
    foreach ($cfMetrics as $metric) {
        $totalCFLeafNodesCreated += $metric->leafNodesCreatedCount;
    }
    return $totalCFLeafNodesCreated;
}

function getTotalExplorePagesCreatedByUser($startDate, $endDate, $user) {
    $pages = $user->getObjects('page_top', 100, 0); //could use elgg_get_entities_from_metadata
    $totalExplorePages = 0;
    $startDateTimestamp = strtotime($startDate);
    $endDateTimestamp = strtotime($endDate);
    foreach ($pages as $page) {
        if (contains("explore", $page->title) 
                && $startDateTimestamp <= $page->time_created 
                && $endDateTimestamp >= $page->time_created) {
            $totalExplorePages++;
        }
    }
    return $totalExplorePages;
}

function getExploreRating($currentUser, $assignmentDetails) {
    $sectionRatings = array();
    //*List and apply metrics- cols 5, 6 
    $studentID = $currentUser->guid;
    $laaMetrics = getListAndApplyMetrics($assignmentDetails, $studentID);
    $totalPOSEditedCount  = getTotalPOSEditedCountCount($laaMetrics);
    $totalListAnswerCount = getTotalListAnswerCount($laaMetrics);
    $laaPOsEditedRating = getRating($totalPOSEditedCount, 75, 3, 5, 7);
    $laaListAnswersRating = getRating($totalListAnswerCount, 25, 3, 5, 7);
    $laaTotalRating = (($laaPOsEditedRating + $laaListAnswersRating) * 25) / 100;
    $sectionRatings[] = $laaTotalRating;
    //*'Explore' page in SN - for a person, and a given time
    $totalExplorePages = getTotalExplorePagesCreatedByUser($assignmentDetails->startDate, $assignmentDetails->endDate, $currentUser);
    $exploreRating = ($totalExplorePages > 0 ? 25 : 0);
    $sectionRatings[] = $exploreRating;
    //*concept fan - all nodes and leaf nodes
    $cfMetrics = getConceptFanMetrics($assignmentDetails->id, $studentID);
    $totalCFNodesCreated = getTotalCFNodesCreated($cfMetrics);
    $totalCFLeafNodesCreated = getTotalCFLeafNodesCreated($cfMetrics);
    $allCFNodesCreated = $totalCFLeafNodesCreated + $totalCFNodesCreated;
    $cfRating = getRating($allCFNodesCreated, 25, 3, 5, 7);
    $sectionRatings[] = $cfRating;
    //*report tool, instruction id 31
    $instructionID = 31;
    $reportMetrics = getReportMetrics($assignmentDetails, $studentID, $instructionID);
    $totalReportWordCount = getTotalReportWordCount($reportMetrics);
    $reportWordCountRating = getRating($totalReportWordCount, 50, 15, 30, 45);
    $totalReportTimeOnPage = getTotalTimeOnPageFromMetric($reportMetrics);
    $reportTimeOnPageRating = getRating($totalReportTimeOnPage, 50, 60, 120, 180);
    $totalReportRating = (($reportWordCountRating + $reportTimeOnPageRating) * 25) / 100;
    $sectionRatings[] = $totalReportRating;
    return round(getAverageOfNonZeroRatings($sectionRatings, 25));
}

function getAverageOfNonZeroRatings($ratings, $weighting) {
    $countOfNonZeroRatings = 0;
    $totalOfNonZeroRatings = 0;
    if (is_array($ratings)) {
        foreach ($ratings as $rating) {
            if ($rating > 0) {
                $countOfNonZeroRatings++;
                $totalOfNonZeroRatings += $rating;
            }
        }
    }
    return ($countOfNonZeroRatings > 0 ? ($totalOfNonZeroRatings / ($countOfNonZeroRatings * $weighting)) * 100 : 0);
}

function getStudentsForAssignment($assignmentDetails) {
    $studentIDs = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT StudentELGG_ID from grouplist WHERE AssignmentID = ?");
    $statement->bind_param('i', $assignmentDetails->id);
    $statement->execute();
    $statement->bind_result($studentID);
    while ($statement->fetch()) {
        $studentIDs[] = $studentID;
    }
    $statement->close();
    return $studentIDs;    
}

function getExploreRatingClassAverage($assignmentDetails) {
    $rating = 0;
    $studentsInClass = getStudentsForAssignment($assignmentDetails);
    foreach ($studentsInClass as $studentID) {
        $user = get_entity($studentID);
        $rating += getExploreRating($user, $assignmentDetails);
    }
    return round($rating / count($studentsInClass));
}

function getCommunicationRating($currentUser, $assignmentDetails) {
    //chats, SN engagement
    $studentID = $currentUser->guid;
    
    $totalChatEntries = getTotalChatEntries($studentID, $assignmentDetails->id);
    $communicationChatRating = getRating($totalChatEntries, 60, 9, 17, 24);
    
    $totalSocialNetworkingPosts = getTotalSocialNetworkingPosts($currentUser, $assignmentDetails->startDate, $assignmentDetails->endDate);
    $communicationSocialNetworkingRating = getRating($totalSocialNetworkingPosts, 40, 3, 5, 7);
    
    return round($communicationChatRating + $communicationSocialNetworkingRating);
}

function getCommunicationRatingClassAverage($assignmentDetails) {
    $rating = 0;
    $studentsInClass = getStudentsForAssignment($assignmentDetails);
    foreach ($studentsInClass as $studentID) {
        $user = get_entity($studentID);
        $rating += getCommunicationRating($user, $assignmentDetails);
    }
    return round($rating / count($studentsInClass));    
}

function getRating($numberOfEntries, $weighting, $twentyFivePercentMax, $fiftyPercentMax, $seventyFivePercentMax) {
    if ($numberOfEntries >= $seventyFivePercentMax) return 1.00 * $weighting;
    else if ($numberOfEntries >= $fiftyPercentMax) return 0.75 * $weighting;
    else if ($numberOfEntries >= $twentyFivePercentMax) return 0.50 * $weighting;
    else if ($numberOfEntries >= 1) return 0.25 * $weighting;
    else return 0;
}

function getTotalSocialNetworkingPosts($user, $startDate, $endDate) {
    $pages = $user->getObjects('page_top', 100, 0); //could use elgg_get_entities_from_metadata
    $theWire = $user->getObjects('thewire', 100, 0);
    $blogs = $user->getObjects('blog', 100, 0);
    $files = $user->getObjects('file', 100, 0);
    $bookmarks = $user->getObjects('bookmarks', 100, 0);
    //comments anywhere or replies anywhere
    $comments = array();
    
    $allSocialNetworkingPosts = array_merge($pages, $theWire, $blogs, $files, $bookmarks, $comments);
    
    $totalSocialNetworkingPosts = 0;
    $startDateTimestamp = strtotime($startDate);
    $endDateTimestamp = strtotime($endDate);
    foreach ($allSocialNetworkingPosts as $post) {
        $createdDate = gmdate("Y-m-d\TH:i:s\Z", $post->time_created);
        if ($startDateTimestamp <= $post->time_created && $endDateTimestamp >= $post->time_created) {
            $totalSocialNetworkingPosts++;
        }
    }
    return $totalSocialNetworkingPosts;
}

function getDataGatheringRating($assignmentDetails, $currentUser) {
    $sectionRatings = array();
    //CIT_ID 4, 5, 6
    $toolID = 1;  $activityID = 2;
    $citIDs = array();
    $citIDs[0] = 4; $citIDs[1] = 5; $citIDs[2] = 6;

    //Given a student ID, get his Group ID (Student can only be in 1 Group) 
    $groupID = getGroupID($assignmentDetails->id, $currentUser->guid);
    
    $citInstructionID = 3;
    $count = getCount($groupID, $citInstructionID, $toolID, $activityID, $assignmentDetails->id, $data, $citIDs, $currentUser->guid);
    
    $citInstructionID = 4;
    $count = $count + getCount($groupID, $citInstructionID, $toolID, $activityID, $assignmentDetails->id, $data, $citIDs, $currentUser->guid);
    
    $citInstructionID = 5;
    $count = $count + getCount($groupID, $citInstructionID, $toolID, $activityID, $assignmentDetails->id, $data, $citIDs, $currentUser->guid);
    
//    $studentScore = $count/3 * 50;
    $studentScore = getRating($count, 50, 1.1, 2, 3);
    $sectionRatings[] = $studentScore;
    
    //List tool
    $listInstructionIDs = array(2, 3, 4, 5, 20, 36, 37, 38);
    $activityIDs = array($activityID);
    $listMetrics = getListMetrics($currentUser->guid, $assignmentDetails->id, $activityIDs, $listInstructionIDs);
    $totalListItemsAddedCount = getTotalListItemsAddedCount($listMetrics);
    $listMetricsRating = getRating($totalListItemsAddedCount, 50, 3, 5, 7);
    $sectionRatings[] = $listMetricsRating;
    return round(getAverageOfNonZeroRatings($sectionRatings, 50));
}

function getCount($groupID, $instructionID, $toolID, $activityID, $assignmentID, $data, $citIDs, $currentUserGUID) {
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = getUserResponsesCount($data, $citIDs, $currentUserGUID); 
    return $count;
}

function getDataGatheringRatingClassAverage($assignmentDetails) {
    $rating = 0;
    $studentsInClass = getStudentsForAssignment($assignmentDetails);
    foreach ($studentsInClass as $studentID) {
        $user = get_entity($studentID);
        $rating += getDataGatheringRating($assignmentDetails, $user);
    }
    return round($rating / count($studentsInClass));       
    
//    //CIT_ID 4, 5, 6
//    $toolID = 1;  $activityID = 2;
//    $citIDs = array();
//    $citIDs[0] = 4; $citIDs[1] = 5; $citIDs[2] = 6;
//    $sum = 0; $numStudents = 0;
//    $allGroupIDs = array();
//    //R: $instructionID isn't set. I'm going to assume 3, 4, 5
//    //D: I changed the method to not use instructionID, more like duplicated the method with a new name
//    $allGroupIDs = getAllGroups2($assignmentDetails->id, $activityID, $toolID);
//    if (count($allGroupIDs) == 0) return 0;
//    foreach ($allGroupIDs as $groupID) {
//        $groupMemberIDs = array();
//        $groupMemberIDs = getAllGroupMembers($groupID, $assignmentDetails->id);
//        foreach ($groupMemberIDs as $groupMember) {
//            $instructionID = 3;
//            $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentDetails->id);
//            $count = getUserResponsesCount($data, $citIDs, $groupMember);
//
//            $instructionID = 4;
//            $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentDetails->id);
//            $count = $count + getUserResponsesCount($data, $citIDs, $groupMember);
//
//            $instructionID = 5;
//            $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentDetails->id);
//            $count = $count + getUserResponsesCount($data, $citIDs, $groupMember);
//            
//            $sum = $sum + $count;
//            $numStudents = $numStudents + 1;
//        }
//    }
//    $totalNumberOfResponses = $sum;
//    $totalNumberOfQuestions = $numStudents * 3;
//    //numStudents is 0, because getAllGroups returns an empty array, because the instructionID isn't set.
//    $classAverage = round($totalNumberOfResponses / $totalNumberOfQuestions * 100);
//    
//    //list tool average has to be done here
//    return $classAverage;
}

function getDataAnalysisRating($assignmentDetails, $currentUser) {
    //CIT 7, 8, 9
    $toolID = 1; $instructionID = 6; $activityID = 3;
    $citIDs = array();
    $citIDs[0] = 7; $citIDs[1] = 8; $citIDs[2] = 9;
    
    $groupID = getGroupID($assignmentDetails->id, $currentUser->guid);
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentDetails->id);
    
    $count = getUserResponsesCount($data, $citIDs, $currentUser->guid);
    $studentScore = round($count/3 * 100);
    return $studentScore; 
}

function getDataAnalysisRatingClassAverage($assignmentDetails) {
    $rating = 0;
    $studentsInClass = getStudentsForAssignment($assignmentDetails);
    foreach ($studentsInClass as $studentID) {
        $user = get_entity($studentID);
        $rating += getDataAnalysisRating($assignmentDetails, $user);
    }
    return round($rating / count($studentsInClass));   
//    $toolID = 1; $instructionID = 6; $activityID = 3;
//    $citIDs = array();
//    $citIDs[0] = 7; $citIDs[1] = 8; $citIDs[2] = 9;
//    $sum = 0; $numStudents = 0;
//    $allGroupIDs = array();
//    $allGroupIDs = getAllGroups($assignmentDetails->id, $activityID, $instructionID, $toolID);
//    if (count($allGroupIDs) == 0) return 0;
//    foreach ($allGroupIDs as $groupID) {
//        $groupMemberIDs = array();
//        $groupMemberIDs = getAllGroupMembers($groupID, $assignmentDetails->id);
//        $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentDetails->id);
//        foreach ($groupMemberIDs as $groupMember) {
//            $count = getUserResponsesCount($data, $citIDs, $groupMember);
//            $sum = $sum + $count;
//            $numStudents = $numStudents + 1;
//        }
//    }
//    $totalNumberOfResponses = $sum;
//    $totalNumberOfQuestions = $numStudents * 3;
//    $classAverage = round($totalNumberOfResponses / $totalNumberOfQuestions * 100);
//    
//    return $classAverage;
}

function getIdeaGenerationRating($assignmentDetails, $currentUser) {
    $sectionRatings = array();
    //cit 11, 15, 17, 19, 25, 34, 37, 39
    $assignmentID = $assignmentDetails->id;
    $toolID = 1;  
    
    //Given a student ID, get his Group ID (Student can only be in 1 Group) 
    $groupID = getGroupID($assignmentID, $currentUser->guid);
    
    $citIDs = array(10,11,12,13); $instructionID = 7; $activityID = 4;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $citIDs = array(14,15); $instructionID = 9; $activityID = 6;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = $count + getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $citIDs = array(16,17); $instructionID = 10; $activityID = 7;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = $count + getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $citIDs = array(18,19); $instructionID = 11; $activityID = 8;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = $count + getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $citIDs = array(20,21,22,23,24,25); $instructionID = 12; $activityID = 9;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = $count + getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $citIDs = array(26,27,28,29,30,31,32,33,34); $instructionID = 13; $activityID = 10;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = $count + getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $citIDs = array(35,36); $instructionID = 54; $activityID = 18;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = $count + getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $citIDs = array(38,39); $instructionID = 55; $activityID = 18;
    $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
    $count = $count + getUserResponsesCount($data, $citIDs, $currentUser->guid);
    
    $studentScore = getRating($count, 25, 2, 3, 4); //$count/8 * 33.3;
    $sectionRatings[] = $studentScore;
    
    //List tool - InstructionIDs - 25, 39, 40, 41, 42
    $listInstructionIDs = array(25, 39, 40, 41, 42);
    $listActivityIDs = array(18, 29, 30, 31, 32);
    $listMetrics = getListMetrics($currentUser->guid, $assignmentID, $listActivityIDs, $listInstructionIDs);
    $totalListItemsAddedCount = getTotalListItemsAddedCount($listMetrics);
    $listToolRating = getRating($totalListItemsAddedCount, 25, 2, 3, 4);
    $sectionRatings[] = $listToolRating;
    
    //Concept Fan
    $conceptFanMetrics = getConceptFanMetrics($assignmentID, $currentUser->guid);
    $totalConceptFanLeafNodesCreated = getTotalCFLeafNodesCreated($conceptFanMetrics);
    $conceptFanToolRating = getRating($totalConceptFanLeafNodesCreated, 25, 3, 5, 7);
    $sectionRatings[] = $conceptFanToolRating;
    
    //Report tool
    $reportMetrics = getReportMetrics($assignmentDetails, $currentUser->guid, 29);
    $totalReportWordCount = getTotalReportWordCount($reportMetrics);
    $reportWordCountRating = getRating($totalReportWordCount, 50, 15, 30, 45);
    $totalReportTimeOnPage = getTotalTimeOnPageFromMetric($reportMetrics);
    $reportTimeOnPageRating = getRating($totalReportTimeOnPage, 50, 60, 120, 180);
    $totalReportRating = (($reportWordCountRating + $reportTimeOnPageRating) * 25) / 100;
    $sectionRatings[] = $totalReportRating;    

    //In case all 3 calculations return 33 (their max), for a total of 99, return 100.
    return round(getAverageOfNonZeroRatings($sectionRatings, 25));
}

function getClassAverageCounts($citIDs, $instructionID, $activityID, $toolID, $assignmentID) {
    $allGroupIDs = array();
    $allGroupIDs = getAllGroups2($assignmentID, $activityID, $toolID);
    foreach ($allGroupIDs as $groupID) {
        $groupMemberIDs = array();
        $groupMemberIDs = getAllGroupMembers($groupID, $assignmentID);
        foreach ($groupMemberIDs as $groupMember) {
            $data = getToolData($groupID, $instructionID, $toolID, $activityID, $assignmentID);
            $count = $count + getUserResponsesCount($data, $citIDs, $groupMember);
        }
    }
    return $count;
}

function getIdeaGenerationRatingClassAverage($assignmentDetails) {
    $rating = 0;
    $studentsInClass = getStudentsForAssignment($assignmentDetails);
    foreach ($studentsInClass as $studentID) {
        $user = get_entity($studentID);
        $rating += getIdeaGenerationRating($assignmentDetails, $user);
    }
    return round($rating / count($studentsInClass));    
}

function getConvergentThinkingRating($currentUser, $assignmentDetails) {
    $sectionRatings = array();
    //List and apply - POs edited, CHoice, In and Out
    //LAA
    $laaMetrics = getListAndApplyMetrics($assignmentDetails, $currentUser->guid);
    $totalPOsEditedCount = getTotalPOSEditedCountCount($laaMetrics);
    $laaRating = getRating($totalPOsEditedCount, 33.3, 3, 5, 7);
    $sectionRatings[] = $laaRating;
    
    //Choice
    $choiceMetrics = getChoiceMetrics($currentUser->guid, $assignmentDetails->id);
    $totalChoiceActivity = getTotalChoiceActivities($choiceMetrics);
    $choiceRating = getRating($totalChoiceActivity, 33.3, 3, 5, 7);
    $sectionRatings[] = $choiceRating;
    
    //In and Out
    $inAndOutMetrics = getInAndOutMetrics($currentUser->guid, $assignmentDetails->id);
    $totalInAndOutActivity = getTotalInAndOutActivities($inAndOutMetrics);
    $inAndOutRating = getRating($totalInAndOutActivity, 33.3, 3, 5, 7);
    $sectionRatings[] = $inAndOutRating;
    
    return round(getAverageOfNonZeroRatings($sectionRatings, 33.3));
}

function getConvergentThinkingRatingClassAverage($assignmentDetails) {
    $rating = 0;
    $studentsInClass = getStudentsForAssignment($assignmentDetails);
    foreach ($studentsInClass as $studentID) {
        $user = get_entity($studentID);
        $rating += getConvergentThinkingRating($user, $assignmentDetails);
    }
    return round($rating / count($studentsInClass));    
}

function getTotalInAndOutActivities($inAndOutMetrics) {
    $totalInAndOutActivities = 0;
    if (isset($inAndOutMetrics) && count($inAndOutMetrics) > 0) {
        foreach ($inAndOutMetrics as $metric) {
            $totalInAndOutActivities += $metric->resetPOsClicksCount + $metric->clearOutClicksCount + $metric->movementsCount + $metric->addedCharacteristicsCount;
        }
    }
    return $totalInAndOutActivities;        
}

function getInAndOutMetrics($studentID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT ResetPOsClicksCount, ClearOutClicksCount, MovementsCount, AddedCharacteristicsCount, ChatEntriesCount, TimeOnPage from inandoutmetrics WHERE AssignmentID = ? AND StudentID = ?");
    $statement->bind_param('ii', $assignmentID, $studentID);
    $statement->execute();
    $statement->bind_result($resetPOsClicksCount, $clearOutClicksCount, $movementsCount, $addedCharacteristicsCount, $chatEntriesCount, $timeOnPage);
    while ($statement->fetch()) {
        $inAndOutMetric = new stdClass();
        $inAndOutMetric->resetPOsClicksCount = $resetPOsClicksCount;
        $inAndOutMetric->clearOutClicksCount = $clearOutClicksCount;
        $inAndOutMetric->movementsCount = $movementsCount;
        $inAndOutMetric->addedCharacteristicsCount = $addedCharacteristicsCount;
        $inAndOutMetric->chatEntriesCount = $chatEntriesCount;
        $inAndOutMetric->timeOnPage = $timeOnPage;
        $inAndOutMetrics[] = $inAndOutMetric;
    }
    $statement->close();    
    return $inAndOutMetrics;        
}

function getTotalChoiceActivities($choiceMetrics) {
    $totalChoiceActivities = 0;
    if (isset($choiceMetrics) && count($choiceMetrics) > 0) {
        foreach ($choiceMetrics as $metric) {
            $totalChoiceActivities += $metric->clearWeakerCount + $metric->resetPOsCount + $metric->movementsCount;
        }
    }
    return $totalChoiceActivities;    
}

function getChoiceMetrics($studentID, $assignmentID) {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT ClearWeakerCount, ResetPOsCount, MovementsCount, ChatEntriesCount, TimeOnPage from choicemetrics WHERE AssignmentID = ? AND StudentID = ?");
    $statement->bind_param('ii', $assignmentID, $studentID);
    $statement->execute();
    $statement->bind_result($clearWeakerCount, $resetPOsCount, $movementsCount, $chatEntriesCount, $timeOnPage);
    while ($statement->fetch()) {
        $choiceMetric = new stdClass();
        $choiceMetric->clearWeakerCount = $clearWeakerCount;
        $choiceMetric->resetPOsCount = $resetPOsCount;
        $choiceMetric->movementsCount = $movementsCount;
        $choiceMetric->chatEntriesCount = $chatEntriesCount;
        $choiceMetric->timeOnPage = $timeOnPage;
        $choiceMetrics[] = $choiceMetric;
    }
    $statement->close();    
    return $choiceMetrics;    
}

function getAllStudentHeadings() {
    $allHeadings = array();

    $heading = new stdClass();
    $heading->ID = "H1";
    $heading->title = "Problem Definition/Recognition/Re-definition Phase";
    $allHeadings[] = $heading;

    $heading = new stdClass();
    $heading->ID = "H2";
    $heading->title = "Data Gathering Phase";
    $allHeadings[] = $heading;

    $heading = new stdClass();
    $heading->ID = "H3";
    $heading->title = "Idea Generation Phase";
    $allHeadings[] = $heading;

    $heading = new stdClass();
    $heading->ID = "H4";
    $heading->title = "Idea Evaluation Phase";
    $allHeadings[] = $heading;

    $heading = new stdClass();
    $heading->ID = "H5";
    $heading->title = "Idea Selection Phase";
    $allHeadings[] = $heading;

    $heading = new stdClass();
    $heading->ID = "H6";
    $heading->title = "Testing Phase";
    $allHeadings[] = $heading;

    $heading = new stdClass();
    $heading->ID = "H7";
    $heading->title = "Validation (external) and Reflection (internal) Phase";
    $allHeadings[] = $heading;    
    
    return $allHeadings;
}

function getAllStudentCriteria() {
    $allCriteria = array();
    $header1Criteria = array();

    $criteria = new stdClass();
    $criteria->ID = "c1";
    $criteria->desc = "DIAGNOSIS (draws attention to shortcomings in other existing solutions)";
    $criteria->Hid = "H1";
    $criteria->question = "How would you rate your general level of Diagnosis, with respect to, the problem recognition/definition/re-definition phase of creativity? [In terms of the problem recognition/definition/re-definition phase of your creative process, are you generally able to find shortcomings in existing solutions?] ";
    $criteria->mapping = "6";
    $criteria->score = "";
    $header1Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c2";
    $criteria->desc = "PRESCRIPTION (shows how existing solutions could be improved)";
    $criteria->Hid = "H1";
    $criteria->question = "How would you rate your general level of Prescription, with respect to, the problem recognition/definition/re-definition phase of creativity? [In terms of the problem recognition/definition/re-definition phase of your creative process, are you generally able to determine how existing solutions could be improved?] ";
    $criteria->mapping = "4";
    $criteria->score = "";
    $header1Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c3";
    $criteria->desc = "PROGNOSIS (helps the beholder to anticipate likely effects of changes)";
    $criteria->Hid = "H1";
    $criteria->question = "How would you rate your general level of Prognosis, with respect to, the problem recognition/definition/re-definition phase of creativity? [In terms of the problem recognition/definition/re-definition phase of your creative process, are you generally able to anticipate likely effects of changes to your creative product?] ";
    $criteria->mapping = "5";
    $criteria->score = "";
    $header1Criteria[] = $criteria;
    $allCriteria["H1"] = $header1Criteria;
    /////

    $header2Criteria = array();

    $criteria = new stdClass();
    $criteria->ID = "c4";
    $criteria->desc = "APPROPRIATENESS (fits within task constraints)";
    $criteria->Hid = "H2";
    $criteria->question = "How would you rate your general level of Appropriateness, with respect to, the data gathering phase of creativity? [In terms of the data gathering phase of your creative process, are you generally able to find data that fits within task constraints?] ";
    $criteria->mapping = "2";
    $criteria->score = "";
    $header2Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c5";
    $criteria->desc = "CORRECTNESS (accurately reflects conventional knowledge and/or techniques)";
    $criteria->Hid = "H2";
    $criteria->question = "How would you rate your general level of Correctness, with respect to, the data gathering phase of creativity? [In terms of the data gathering phase of your creative process, are you generally able to accurately use conventional knowledge and/or techniques?] ";
    $criteria->mapping = "3";
    $criteria->score = "";
    $header2Criteria[] = $criteria;
    $allCriteria["H2"] = $header2Criteria;
    /////

    $header3Criteria = array();

    $criteria = new stdClass();
    $criteria->ID = "c6";
    $criteria->desc = "REDIRECTION (shows how to extend the known in a new direction)";
    $criteria->Hid = "H3";
    $criteria->question = "How would you rate your general level of Redirection, with respect to, the idea generation phase of creativity? [In terms of the idea generation phase of your creative process, are you generally able to extend your creative idea in a new direction?] ";
    $criteria->mapping = "10";
    $criteria->score = "";
    $header3Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c7";
    $criteria->desc = "REDEFINITION (helps the beholder see new and different ways of using the solution)";
    $criteria->Hid = "H3";
    $criteria->question = "How would you rate your general level of Redefinition, with respect to, the idea generation phase of creativity? [In terms of the idea generation phase of your creative process, are you generally able to see new and different ways of using your creative idea?] ";
    $criteria->mapping = "7";
    $criteria->score = "";
    $header3Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c8";
    $criteria->desc = "VISION (suggests new norms for judging other solutions-existing or new)";
    $criteria->Hid = "H3";
    $criteria->question = "How would you rate your general level of Vision, with respect to, the idea generation phase of creativity? [In terms of the idea generation phase of your creative process, are you generally able to think of new ways or standards to judge your creative idea?] ";
    $criteria->mapping = "16";
    $criteria->score = "";
    $header3Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c9";
    $criteria->desc = "TRANSFERABILITY (offers ideas for solving apparently unrelated problems)";
    $criteria->Hid = "H3";
    $criteria->question = "How would you rate your general level of Transferability, with respect to, the idea generation phase of creativity? [In terms of the idea generation phase of your creative process, are you generally able to reuse creative ideas or apply ideas/solutions to new problems?]";
    $criteria->mapping = "18";
    $criteria->score = "";
    $header3Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c10";
    $criteria->desc = "GENERATION (offers a fundamentally new perspective on possible solutions)";
    $criteria->Hid = "H3";
    $criteria->question = "How would you rate your general level of Generation (idea generation)? [In terms of the idea generation phase of your creative process, are you generally able to think of new and varied ideas/solutions?] ";
    $criteria->mapping = "9";
    $criteria->score = "";
    $header3Criteria[] = $criteria;
    $allCriteria["H3"] = $header3Criteria;
    //////

    $header4Criteria = array();

    $criteria = new stdClass();
    $criteria->ID = "c11";
    $criteria->desc = "CONVINCINGNESS (the beholder sees the solution as skillfully executed, well-finished)";
    $criteria->Hid = "H4";
    $criteria->question = "How would you rate your general level of Convincingness, with respect to, the idea evaluation phase of creativity? [In terms of the idea evaluation phase of your creative process, are you generally able to judge your creative idea in terms of how well it was accomplished/finished?] ";
    $criteria->mapping = "14";
    $criteria->score = "";
    $header4Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c12";
    $criteria->desc = "COMPLETENESS (is well worked out and rounded)";
    $criteria->Hid = "H4";
    $criteria->question = "How would you rate your general level of Completeness, with respect to, the idea evaluation phase of creativity? [In terms of the idea evaluation phase of your creative process, are you generally able to judge your creative idea in terms of its comprehensiveness/totality?] ";
    $criteria->mapping = "12";
    $criteria->score = "";
    $header4Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c13";
    $criteria->desc = "HARMONIOUSNESS (the elements of the solution fit together in a consistent way)";
    $criteria->Hid = "H4";
    $criteria->question = "How would you rate your general level of Harmoniousness, with respect to, the idea evaluation phase of creativity? [In terms of the idea evaluation phase of your creative process, are you generally able to judge your creative idea in terms of how well its elements fit together in a consistent way?] ";
    $criteria->mapping = "15";
    $criteria->score = "";
    $header4Criteria[] = $criteria;
    $allCriteria["H4"] = $header4Criteria;
    /////

    $header5Criteria = array();

    $criteria = new stdClass();
    $criteria->ID = "c14";
    $criteria->desc = "PLEASINGNESS (the beholder finds the solution neat, well done)";
    $criteria->Hid = "H5";
    $criteria->question = "How would you rate your general level of Pleasingness, with respect to, the idea selection phase of creativity? [In terms of the idea selection phase of your creative process, are you generally able to judge your creative idea in terms of how well done it is?] ";
    $criteria->mapping = "11";
    $criteria->score = "";
    $header5Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c15";
    $criteria->desc = "GRACEFULNESS (well-proportioned, nicely formed)";
    $criteria->Hid = "H5";
    $criteria->question = "How would you rate your general level of Gracefulness, with respect to, the idea selection phase of creativity? [In terms of the idea selection phase of your creative process, are you generally able to judge your creative idea in terms of how well-formed it is?] ";
    $criteria->mapping = "13";
    $criteria->score = "";
    $header5Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c16";
    $criteria->desc = "PATHFINDING (opens up a new conceptualization of the issues)";
    $criteria->Hid = "H5";
    $criteria->question = "How would you rate your general level of Pathfinding, with respect to, the idea selection phase of creativity? [In terms of the idea selection phase of your creative process, are you generally able to judge your creative idea in terms of whether it opens up new hypotheses/theories/abstractions?] ";
    $criteria->mapping = "19";
    $criteria->score = "";
    $header5Criteria[] = $criteria;
    $allCriteria["H5"] = $header5Criteria;
    /////

    $header6Criteria = array();

    $criteria = new stdClass();
    $criteria->ID = "c17";
    $criteria->desc = "PERFORMANCE (does what it is supposed to do)";
    $criteria->Hid = "H6";
    $criteria->question = "How would you rate your general level of Performance, with respect to, the testing of your creative product? [In terms of the testing phase of your creative process, do you do what you are supposed to do and ensure that your creative product does as well?] ";
    $criteria->mapping = "1";
    $criteria->score = "";
    $header6Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c18";
    $criteria->desc = "REINITIATION (indicates a radically new approach)";
    $criteria->Hid = "H6";
    $criteria->question = "How would you rate your general level of Re-initiation, with respect to, the testing of your creative product? [In terms of the testing phase of your creative process, are you generally able to find a radically new approach to your creative product?] ";
    $criteria->mapping = "8";
    $criteria->score = "";
    $header6Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c19";
    $criteria->desc = "FOUNDATIONALITY (suggests a novel basis for further work)";
    $criteria->Hid = "H6";
    $criteria->question = "How would you rate your general level of Foundationality, with respect to, the testing of your creative product? [In terms of the testing phase of your creative process, are you generally able to suggest a novel base for further work from your creative product?] ";
    $criteria->mapping = "21";
    $criteria->score = "";
    $header6Criteria[] = $criteria;
    $allCriteria["H6"] = $header6Criteria;
    ///////

    $header7Criteria = array();

    $criteria = new stdClass();
    $criteria->ID = "c20";
    $criteria->desc = "SEMINALITY (draws attention to previously unnoticed problems)";
    $criteria->Hid = "H7";
    $criteria->question = "How would you rate your general level of Seminality, with respect to, the ‘validation by external persons’ phase of creativity? [In terms of the ‘validation by external persons’ phase of your creative process, are you generally able to use your creative product to draw attention to previously unnoticed problems?] ";
    $criteria->mapping = "17";
    $criteria->score = "";
    $header7Criteria[] = $criteria;

    $criteria = new stdClass();
    $criteria->ID = "c21";
    $criteria->desc = "GERMINALITY (suggests new ways of looking at existing problems)";
    $criteria->Hid = "H7";
    $criteria->question = "How would you rate your general level of Germinality, with respect to, the ‘validation by external persons’ phase of creativity? [In terms of the ‘validation by external persons’ phase of your creative process, are you generally able to suggest new ways of looking at your/others’ creative product?] ";
    $criteria->mapping = "20";
    $criteria->score = "";
    $header7Criteria[] = $criteria;
    $allCriteria["H7"] = $header7Criteria;   
    
    return $allCriteria;
}

function getAllStudentCriteriaFromDB() {
    $mysqli = get_CoreDB_link("mysqli");
    $criteria = array();
    $res = $mysqli->query("SELECT CriteriaID from csds_criteria");
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $criteria[] =  $row['CriteriaID'];
    }
    return $criteria;
}

function storeStudentCriteriaRatings($criteriaType, $ratings) {
    $sqlCriteriaBulkInsert = array();
    foreach ($ratings as $studentRating) {
        $sqlCriteriaBulkInsert[] = 
        '(' . 
                mysql_real_escape_string($studentRating->StudentID . ", " . $studentRating->CriteriaID . ", " . $studentRating->Rating) . 
        ')';
    }
    $insertSQL = 'REPLACE INTO student_' . $criteriaType . '_responses (StudentID, CriteriaID, Rating) VALUES ' . implode(',', $sqlCriteriaBulkInsert);   
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare($insertSQL);
    $statement->execute();
    error_log($mysqli->error);
    $statement->close();
}

function getCMCCriteria() {
    $mysqli = get_CoreDB_link("mysqli");
    $criteria = array();
    $res = $mysqli->query("SELECT CriteriaID, Criteria, Description from cmc_criteria");
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $criterion = new stdClass();
        $criterion->CriteriaID = $row['CriteriaID'];
        $criterion->Criteria = $row['Criteria'];
        $criterion->Description = $row['Description'];
        $criteria[] =  $criterion;
    }
    return $criteria;    
}

function getTotalChatEntries($studentID, $assignmentID) {
    $toolList = getToolListing();
    $mysqli = get_CoreDB_link("mysqli");    
    $totalChatEntries = 0;
    foreach ($toolList as $tool) {
        if ($tool->id < 11) { //only first 8 tools
            $metricsTableName = str_replace(' ', '', $tool->name);
            $metricsTableName = str_replace('Tool', '', $metricsTableName);
            $metricsTableName = strtolower($metricsTableName . "metrics");
            $chatQuery = $mysqli->prepare("SELECT ChatEntriesCount from $metricsTableName WHERE StudentID = ? AND AssignmentID = ?");
            $chatQuery->bind_param('ii', $studentID, $assignmentID);
            $chatQuery->execute();
            $chatQuery->bind_result($chatEntriesCount);
            while ($chatQuery->fetch()) {
                if (isset($chatEntriesCount)) {
                    $totalChatEntries += $chatEntriesCount;
                }
            }            
            $chatQuery->close();
        }
    }
    return $totalChatEntries;
}

function getCurrentAssignmentID() {
    $assignIDFromQueryString = $_GET['assignID'];
    if (isset($assignIDFromQueryString) && !empty($assignIDFromQueryString)) {
        $_SESSION['assignmentID'] = $assignIDFromQueryString;
    }
    return $_SESSION['assignmentID'];
}

function logUsage($user = 1000, $activityID = 0, $instructionID = 0, $assignmentID = 0) {
//    $startTime = microtime(true);
    $mysqli = get_CoreDB_link("mysqli");
    $studentID = (empty($user) ? elgg_get_logged_in_user_guid() : $user);
    $dateTime = date('Y-m-d H:i:s');
    $fullURL = current_page_url();
    $core = (contains("Core", $fullURL) ? "Core" : "root");
    $urlParts = getPartsFromURL($fullURL);
    $entity = $urlParts->entity;
    $action = $urlParts->action;
    $helpMe = $urlParts->helpMe;
    $activityID  = (empty($activityID) ? 0 : $activityID);
    $instructionID = (empty($instructionID) ? 0 : $instructionID);
    $assignmentID  = (empty($assignmentID) ? 0 : $assignmentID);
    
    $insertStatement = $mysqli->prepare("INSERT INTO studentusage(StudentID, ActionDateTime, FullURL, Core, Entity, Action, HelpMe, ActivityID, LastInstructionID, AssignmentID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insertStatement->bind_param('isssssiiii', $studentID, $dateTime, $fullURL, $core, $entity, $action, intval($helpMe), $activityID, $instructionID, $assignmentID);
    $insertStatement->execute();
    $insertStatement->close();        
//    error_log("logUsage Time:  " . number_format(( microtime(true) - $startTime), 4) . " Seconds\n");
}

function getPartsFromURL($url) {
    $urlParts = new stdClass();
    $applicationName = getApplicationName();
    $uri_path = parse_url($url, PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $coreIndex = array_search("Core", $uri_segments);
    $entityIndex = array_search($applicationName, $uri_segments) + 1;
    $actionIndex = array_search($applicationName, $uri_segments) + 2;
    if (!empty($coreIndex)) {
      $entityIndex = $coreIndex + 1;
      $actionIndex = $coreIndex + 2;
    }
    $urlParts->entity = $uri_segments[$entityIndex];
    $urlParts->action = ($actionIndex < count($uri_segments) ? $uri_segments[$actionIndex] : "");
    $urlParts->helpMe = $_GET['helpme'] == 1;
    return $urlParts;
}

function getRandomWord() {
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Word from randomnouns ORDER BY rand() limit 1");
    $statement->execute();
    $statement->bind_result($word);
    $statement->fetch();
    $statement->close();    
    return $word;
}

function getImprovementActivities($creativityFactorID) {
    $mysqli = get_CoreDB_link("mysqli");
    $improvementActivities = array();
    $statement = $mysqli->prepare("SELECT CreativityFactorID, ActivityID, a.ShortDescription AS ActivityShortDescription FROM creativityfactorsimprovementactivities cfa INNER JOIN activity a ON ( cfa.ActivityID = a.A_ID ) WHERE CreativityFactorID = ?");
    $statement->bind_param('i', $creativityFactorID);
    $statement->execute();
    $statement->bind_result($creativityFactorID, $activityID, $activityShortDescription);
    while ($statement->fetch()) {
        $activity = new stdClass();
        $activity->creativityFactorID = $creativityFactorID;
        $activity->id = $activityID;
        $activity->shortDescription = $activityShortDescription;
        $improvementActivities[] = $activity;
    }
    $statement->close();    
    return $improvementActivities;    
}

function getFactorRating($creativityFactorID, $creativityFactors) {
    $factor = null;
    foreach ($creativityFactors as $struct) {
        if ($creativityFactorID == $struct->id) {
            $factor = $struct;
            break;
        }
    }
    return $factor;
}

function getCompletedCP($stuID) {
    $usageClicks = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT FullURL, Core, Entity, Action, HelpMe, ActivityID, LastInstructionID, AssignmentID FROM studentusage WHERE StudentID = ?");
    error_log($mysqli->error);
    $statement->bind_param('i', $stuID);
    $statement->execute();
    $statement->bind_result($fullURL, $core, $entity, $action, $helpMe, $activityID, $lastIID, $assignID);
    while ($statement->fetch()) {
        $usageClick = new stdClass();
        $usageClick->fullURL = $fullURL;
        $usageClick->core = $core;
        $usageClick->entity = $entity;
        $usageClick->action = $action;
        $usageClick->helpMe = $helpMe;
        $usageClick->activityID = $activityID;
        $usageClick->lastIID = $lastIID;
        $usageClick->assignID = $assignID;
        $usageClicks[] = $usageClick;
    }
    $statement->close();
    return $usageClicks;
}

function getAllStudentsFull() {
    $allstudents = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Student_ID, Name, Email, ELGG_ID from student");
    error_log($mysqli->error);
    $statement->execute();
    $statement->bind_result($id, $name, $email, $elggID);
    while ($statement->fetch()) {
        $student = new stdClass();
        $student->id = $id;
        $student->name = $name;
        $student->email = $email;
        $student->elggID = $elggID;
        $allstudents[] = $student;
    }
    $statement->close();    
    return $allstudents;
}

function getAllStudents () {
    $allstudentids = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT StudentELGG_ID from workshop_studentids");
    $statement->execute();
    $statement->bind_result($id);
    while ($statement->fetch()) {
       $allstudentids[] = $id;
    }
    $statement->close();    
    return $allstudentids;
}

function getActivityDetailsV2($activityID) {
    $activity = array();
    $mysqli = get_CoreDB_link("mysqli");
    $statement = $mysqli->prepare("SELECT Description, ShortDescription from activity WHERE A_ID = ?");
    $statement->bind_param('i', $activityID);
    $statement->execute();
    $statement->bind_result($description, $shortDesc);
    $statement->fetch();
    $statement->close();
    $activity['shortDesc'] = $shortDesc;
    $activity['description'] = $description;
    
    //TO get the stage of an activity
    $statementA = $mysqli->prepare("SELECT SA_ID from stageactivity WHERE A_ID = ?");
    $statementA->bind_param('i', $activityID);
    $statementA->execute();
    $statementA->bind_result($stage);
    $statementA->fetch();
    $statementA->close();
    $activity['stage'] = $stage;
    
    $statement1 = $mysqli->prepare("SELECT DISTINCT ains.i_id FROM `a_instructions` ains 
                                        INNER JOIN `instructions` ins ON ains.i_id = ins.i_id
                                        WHERE ains.a_id = ?");
    $statement1->bind_param('i', $activityID);
    $statement1->execute();
    $statement1->bind_result($instructionID);
    $statement1->store_result();
    
    $instructions = array();
    $instruction = new stdClass();
    $lines = array();
    $tools = array();
    while ($statement1->fetch()) {
        //GET INSTRUCTION LINES
        $statement3 = $mysqli->prepare("SELECT ins.line_id, ins.description FROM `instructions` ins
                                        WHERE ins.i_id = ?");
        $statement3->bind_param('i', $instructionID);
        $statement3->execute();
        $statement3->bind_result($lineID, $iDesc);
        $statement3->store_result();
        while ($statement3->fetch()) {
            $line = new stdClass();
            $line->id = $lineID;
            $line->desc = $iDesc;
            $lines[] = $line;
        }
        $statement3->close();
        //get tools
        $statement2 = $mysqli->prepare("SELECT t.name, t.description, t.url
                                            FROM  `tool` t
                                            INNER JOIN  `instructiontool` it ON it.Tool_ID = t.Tool_ID
                                            WHERE it.i_id = ?");
        $statement2->bind_param('i', $instructionID);
        $statement2->execute();
        $statement2->bind_result($name, $toolDesc, $url);
        while ($statement2->fetch()) {
            $tool = new stdClass();
            $tool->name = $name;
            $tool->desc = $toolDesc;
            $tool->url = $url;
            $tools[] = $tool;
        }
        $statement2->close();
        /////////////
        $instruction->id = $instructionID;
        $instruction->lines = $lines;
        $instruction->tools = $tools;
        $instructions[] = $instruction;
        $instruction = new stdClass();
        $lines = array();
        $tools = array();
    }
    $activity['instructions'] = $instructions;
    $statement1->close();
    
    return $activity;
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
