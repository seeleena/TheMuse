<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "Survey";

$vars = array();

$allHeadings = getAllStudentHeadings();
$allCriteria = getAllStudentCriteria();
$cmcCriteria = getCMCCriteria();

$vars['allHeadings'] = $allHeadings;
$vars['allCriteria'] = $allCriteria;
$vars['cmcCriteria'] = $cmcCriteria;

$content = elgg_view('Core/myCreativeProcess/survey', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);

?>