<?php
/*
include elgg_get_plugins_path()."Core/lib/utilities.php";
include elgg_get_plugins_path()."Core/lib/dbConnection.php";
function login_init() {
    if(elgg_is_admin_logged_in()) {
        forward("Core/instructorLanding");
    }
    else {
         forward("Core/studentLanding");
    }
}

function core_page_load($event, $object_type, $object) {
    error_log("----------------------------------------------");
    error_log("COREEVENTS> event: " . print_r($event, true));
    error_log("COREEVENTS> type: " . print_r($object_type, true));
    error_log("COREEVENTS> object: " . print_r($object, true));
}

function core_toolbar_init() {
    // add css
    elgg_extend_view('css/elgg', 'coreDefinedToolbar/css');
    // add menu into the header
    elgg_extend_view('page/elements/header', 'coreDefinedToolbar/toolbar');
}

function leave_group_init($event, $object_type, $object) {
    $theGroup = $object['group'];
    $groupID = $theGroup->getGUID();
    $studentID = elgg_get_logged_in_user_guid();
    
    $mysqli = get_CoreDB_link("mysqli");
    $insert_statement = $mysqli->prepare("DELETE FROM grouplist WHERE GroupELGG_ID = ? AND StudentELGG_ID = ?");
    $insert_statement->bind_param('ii', $groupID, $studentID);
    $insert_statement->execute();
    $insert_statement->close();
}

function join_group_init($event, $object_type, $object) {
    $theGroup = $object['group'];
    $groupID = $theGroup->getGUID();
    $owner = $theGroup->getOwnerEntity();
    $ownerID = $owner->getGUID();
    $studentID = elgg_get_logged_in_user_guid();
    $assignmentID = getAssignmentID($groupID, $ownerID);

    $mysqli = get_CoreDB_link("mysqli");
    $insert_statement = $mysqli->prepare("INSERT INTO grouplist(GroupELGG_ID, StudentELGG_ID, AssignmentID) VALUES (?, ?, ?)");
    $insert_statement->bind_param('iii', $groupID, $studentID, $assignmentID);
    $insert_statement->execute();
    $insert_statement->close();
}

function store_group_init($event, $object_type, $object) {
    $groupName = get_input('name');
    $course = get_input("courseCode");
    $assignmentID = get_input("assignments");
    $groupGuid = $object->guid;
    $courseRunID = getCourseRunByCode($course);
    //$assignmentID = getAssignmentIDbyCourseRun($courseRunID, $assignment);
    $userGUID = elgg_get_logged_in_user_guid();
    error_log("in store group in db...".$groupGuid.", ".$userGUID.", ".$assignmentID.", ".$courseRunID);
    
    $mysqli = get_CoreDB_link("mysqli");
    $insert_statement = $mysqli->prepare("INSERT INTO grouplist(GroupELGG_ID, StudentELGG_ID, AssignmentID) VALUES (?, ?, ?)");
    $insert_statement->bind_param('iii', $groupGuid, $userGUID, $assignmentID);
    $insert_statement->execute();
    $insert_statement->close();
}

function set_group_name_hook($hook, $entity_type, $returnvalue, $params) {
    $groupName = get_input("name");
    set_input('name', $groupName);
}

function store_student_init() {
    $isadmin = get_input('admin');
    
    if(!$isadmin) {
        $studentName = get_input('name');
        $studentID = get_input('username');
        $email = get_input('email');
        $user = get_user_by_username($studentID);
        if ($user) {
            $userGuid = $user->getGUID();
        }
        $elgg_id = $userGuid;
        $mysqli = get_CoreDB_link("mysqli");
        $insert_statement = $mysqli->prepare("INSERT INTO student(Student_ID, Name, Email, ELGG_ID) VALUES (?, ?, ?, ?)");
        $insert_statement->bind_param('sssi', $studentID, $studentName, $email, $elgg_id);
        $insert_statement->execute();
        $insert_statement->close();
    }
}

function testing_init() {
   elgg_register_page_handler('Core', 'core_views_handler'); 
   elgg_register_plugin_hook_handler("action", "usersettings/save", "save_instructor_hook");
}

function core_views_handler($page, $identifier) {
//    error_log("COREHANDLER>page is $page");
//    error_log("COREHANDLER>page[0] is $page[0]");
//    error_log("COREHANDLER>identifier is $identifier");
    $plugin_path = elgg_get_plugins_path();
    $base_path = $plugin_path . 'Core/pages/Core';
    switch ($page[0]) {
        case 'debug':
            require "$base_path/debug.php";
            break;
        case 'instructorLanding':
            require "$base_path/instructorLanding.php";
            break;
        case 'grading':
            $gradingAction = $page[1];
            $gradingParameter = $page[2];
            $gradingParameter2 = $page[3];
            $gradingParameter3 = $page[4];
            require "$base_path/grading.php";
            break;
        case 'student':
        case 'studentLanding':
            require "$base_path/studentLanding.php";
            break;
        case 'assignment': 
            $assignmentAction = $page[1];
            $assignmentParameter = $page[2];
            require "$base_path/assignment.php";
            break;
        case 'course': 
            $courseAction = $page[1];
            $courseParam = $page[2];
            require "$base_path/course.php";
            break;
        case 'myCreativeProcess':
            $myProcessAction = $page[1];
            $myProcessParam = $page[2];
            $assignID = getCurrentAssignmentID();
            require "$base_path/myCreativeProcess.php";
            break;
        case 'myTools':
            $myProcessAction = $page[1];
            $myProcessParam = $page[2];
            $myProcessParam2 = $_GET['instructionID'];
            require "$base_path/myTools.php";
            break;
        default:
            echo "No handler created for $identifier $page[0]";
            break;
    }
    return true;
}

function save_instructor_hook($hook, $entity_type, $returnvalue, $params) {
    $mysqli = get_CoreDB_link("mysqli");
    $insert_statement = $mysqli->prepare("INSERT INTO instructor(Instructor_ID, Name) VALUES (?, ?)");

    $role2 = get_input('role');
    if($role = 'Moderator') {
        $insert_statement->bind_param('is', $elgg_id, $user2);
        $user2 = get_input('name');
        $user = get_user_by_username($user2);
        if ($user) {
            $userGuid = $user->getGUID();
        }
        $elgg_id = $userGuid;
        
        $res = $mysqli->query("SELECT Instructor_ID from instructor WHERE Instructor_ID='$userguid'");
        $res->data_seek(0);
        while ($row = $res->fetch_assoc()) {
            $instructorID = $row['Instructor_ID'];
        }
        if(!$instructorID) {
            $insert_statement->execute();
            system_message("Instructor: $user2 has been stored.");
        }
    }
    $insert_statement->close();
    
}

function created_object($event, $object_type, $object) {
    $subType = "unknown";
    switch ($object->getSubtype()) {
		case "page_top":
                        //error_log("created the page!");
                        $subType = "page_top";
			break;
		case "blog":
			//error_log("created the blog!");
                        $subType = "blog";
			break;
		case "bookmarks":
			//error_log("created the bookmark!");
                        $subType = "bookmarks";
			break;
                case "file":
			//error_log("created the file!");
                        $subType = "file";
			break;
                case "thewire":
			//error_log("created the thewire!");
                        $subType = "thewire";
			break;
	}
    $groupID = $_SESSION['groupID'];
    $instructionID = $_SESSION['instructionID'];
    $assignmentID = $_SESSION['assignmentID'];
    $activityID = $_SESSION['activityID'];
};