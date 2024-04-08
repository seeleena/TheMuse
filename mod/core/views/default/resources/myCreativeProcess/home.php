<?php
include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "My Creative Process";
    $user = elgg_get_logged_in_user_entity();
    $vars['courseCodes'] = getStudentCourses($user->username);
    $vars['assignments'] = getAssignments();
    $content = elgg_view('Core/myCreativeProcess/home', $vars);
    $vars['content'] = $content;
    $body = elgg_view_layout('one_sidebar', $vars);
   echo elgg_view_page($title, $body);

?>