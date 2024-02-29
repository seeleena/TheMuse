<?php
// 
include elgg_get_plugins_path()."Core/lib/utilities.php"; 

switch ($assignmentAction) {
    case 'add':
        $title = "Add Assignments to Course";
        $vars = array();
        $content = elgg_view('Core/course/addAssignment', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "get": 
        $vars = array();
        $vars['courseCode'] = $assignmentParameter;
        $vars['assignments'] = getAssignmentsByCourseCode($vars['courseCode']); 
        $content = elgg_view('Core/assignments/getByCourse', $vars);
        echo $content; 
        break;
    case "getQuestionTypes":
        $vars = array();
        $vars['domain'] = $assignmentParameter;
        $vars['questionTypes'] = getQuestionTypesByCourseCode($vars['domain']); 
        $content = elgg_view('Core/assignments/getQuestionTypeByDomain', $vars);
        echo $content; 
        break;
    case "grouping":
        $title = "Assignment Grouping";
        $vars = array();
        $vars['user'] = $assignmentParameter;
        
        $vars['courseCodes'] = getCourseCodes();
 
        $userEntities = array();
        $userEntities = getUserEntities();
        $vars['userEntities'] = $userEntities;

        $content = elgg_view('Core/assignments/grouping', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "viewDetails":
        $title = "Assignment Details";
        $id = $assignmentParameter;
        $id = sanitise_int($id, false);
        $vars = array();
        $details = array();
        $details = getAssignmentDetails($id);
        $vars['details'] = $details;
        $content = elgg_view('Core/assignments/viewDetails', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "viewDetailsBasic":
        $title = "Assignment Details";
        $id = $assignmentParameter;
        $id = sanitise_int($id, false);
        $vars = array();
        $details = array();
        $details = getAssignmentDetails($id);
        $vars['details'] = $details;
        $content = elgg_view('Core/assignments/viewDetails', $vars);
        echo $content;
        break;
    case "viewAll":
        $vars = array();
        $studentID = getStudentID();
        $vars['studentID'] = $studentID; 
        $all = getAll($studentID);
        $vars['courses'] = $all['courses'];
        $vars['assignments'] = $all['assignments'];
        $title = "Assignment Listing";
        $content = elgg_view('Core/student/assignmentListing', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    default:
        break;
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

?>
