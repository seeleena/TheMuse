<?php
include elgg_get_plugins_path()."Core/lib/fileUpload.php";

echo elgg_view('input/hidden', array('name' => 'assignID', 'value' => get_input('assignID')));
echo elgg_view('input/file', array('name' => 'groupSolution'));
echo elgg_view('input/submit');
?>
