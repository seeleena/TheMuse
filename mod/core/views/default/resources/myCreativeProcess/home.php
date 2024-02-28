<?php
include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "My Creative Process";
    $vars = array();
    $vars['courseCodes'] = getCourseCodes();
    $vars['assignments'] = getAssignments();
    $content = elgg_view('Core/myCreativeProcess/home', $vars);
    $vars['content'] = $content;
    $body = elgg_view_layout('one_sidebar', $vars);
   echo elgg_view_page($title, $body);
   echo $title;
?>