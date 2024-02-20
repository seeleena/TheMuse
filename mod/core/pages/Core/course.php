<?php
//include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
//include elgg_get_plugins_path()."Core/lib/utilities.php"; 

switch ($courseAction) {
    case 'add':
        $title = "Add A Course";
        $vars = array();
        $content = elgg_view('Core/course/new', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'addRun':
        $title = "Add a Course Run";
        $vars = array();
        $content = elgg_view('Core/course/newCourseRun', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
    case 'populate':
        $title = "Populate Course";
        $vars = array();
        $content = elgg_view('Core/course/populate', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);
        break;
     default:
        break;
}
?>
