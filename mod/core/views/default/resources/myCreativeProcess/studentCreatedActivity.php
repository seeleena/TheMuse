<?php

include elgg_get_plugins_path()."Core/lib/utilities.php";

$title = "My Creative Process";
        $aID = (string) elgg_extract('aID', $vars);
        $instructions = getStudentCreatedInstructions($aID);
        $tools = getStudentCreatedTools($aID);
        //get activity description and put in vars
        $description = getActivityDescription($aID);
        $_SESSION['CurrentActivity'] = $activity;
        $vars['instructions'] = $instructions;
        $vars['tools'] = $tools;
        $vars['description'] = $description;
        $vars['studentCreatedAID'] = $aID;
        $content = elgg_view('Core/myCreativeProcess/studentCreatedActivity', $vars);
        $vars['content'] = $content;
        $body = elgg_view_layout('one_sidebar', $vars);
        echo elgg_view_page($title, $body);

?>