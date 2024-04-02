<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$assignID = (string) elgg_extract('assignID', $vars);
$title = "Upload Zipped Solution";
$vars = array();
$vars['assignID'] = $assignID;
$content = elgg_view('Core/myCreativeProcess/uploadZipSolution', $vars);
$vars['content'] = $content;
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);
?>
