<?php

switch ($gradingAction) {
    case "main":
        $title = "Assignment Grading";
        $vars = array();
        $vars['courseCodes'] = getCourseCodes();
        $content = elgg_view('Core/instructor/grading', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "getProjectGroups": 
        $assignmentID = $gradingParameter;
        $assessmentTechniqueSol = $gradingParameter2;
        $assessmentTechniqueProcess = $gradingParameter3;
        $projectGroups = array();
        $projectGroups = getProjectGroups($assignmentID);
        $vars = array();
        $vars['allGroups'] = $projectGroups;
        $vars['assessmentTechniqueSolution'] = $assessmentTechniqueSol;
        $vars['assessmentTechniqueProcess'] = $assessmentTechniqueProcess;
        $vars['assignmentID'] = $assignmentID;
        $content = elgg_view('Core/instructor/projectGroups', $vars);
        echo $content; 
        break;
    case "groupCreativeProcess":
        $groupID = $gradingParameter;
        $assignmentID = $gradingParameter2;
        error_log($groupID);
        error_log($assignmentID);
        $vars = array();
        $vars['groupID'] = $groupID;
        $vars['assignmentID'] = $assignmentID;
        $content = elgg_view('Core/instructor/groupCreativeProcess', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "creativePedagogy":
        $assignmentID = $gradingParameter;
        $vars = array();
        $vars['assignmentID'] = $assignmentID;
        $content = elgg_view('Core/instructor/creativePedagogy', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "productAssessment":
        $vars = array();
        $content = elgg_view('Core/instructor/productAssessment', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "CAT":
        $assignmentID = $gradingParameter;
        $vars = array();
        $vars['assignmentID'] = $assignmentID;
        $content = elgg_view('Core/instructor/CAT', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "CSDS":
        $vars = array();
        $content = elgg_view('Core/instructor/CSDS', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "CRITERIA":
        $assignmentID = $gradingParameter;
        $vars = array();
        $vars['assignmentID'] = $assignmentID;
        $content = elgg_view('Core/instructor/CRITERIA', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "csdsReturn":
        $groupID = $gradingParameter;
        $total = $gradingParameter2;
        $vars = array();
        $vars['groupID'] = $groupID;
        $vars['total'] = $total;
        $content = elgg_view('Core/instructor/csdsReturn', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "setCSDScriteria":
        $assignmentID = $gradingParameter;
        $vars = array();
        $vars['assignmentID'] = $assignmentID;
        $content = elgg_view('Core/instructor/setCSDScriteria', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "selectAssignToPrintCP":
        $vars = array();
        $vars['courseCodes'] = getCourseCodes();
        $content = elgg_view('Core/instructor/selectAssignToPrintCP', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case "printCPs":
        $assignID = $gradingParameter;
        $vars = array();
        $vars['allStudentsIDs'] = getAllStudents();
        $vars['allStudents'] = getAllStudentsFull();
        $vars['currentStudentID'] = $_GET['currentStudentID'];
        $vars['assignID'] = $assignID;
        $content = elgg_view('Core/instructor/printCPs', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    default:
        break;
}
?>
