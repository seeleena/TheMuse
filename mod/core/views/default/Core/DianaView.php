<?php
echo elgg_view_form('example');
//echo elgg_echo('hello:user', array($vars['name']));
$greeting = "hello ". ($vars['name']);
echo elgg_view_title($greeting);
echo "directly inside DianaView";
?>
<h1>
    some html. <?php echo time()?>
</h1>