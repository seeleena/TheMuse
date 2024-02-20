<?php
echo elgg_view('input/hidden', array('name' => 'assignID', 'value' => get_input('assignID')));
echo elgg_view('input/file', array('name' => 'groupSolution'));
echo elgg_view('input/submit');
?>
