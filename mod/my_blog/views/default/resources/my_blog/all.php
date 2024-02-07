<?php
$titlebar = "All Site My_Blogs";
$pagetitle = "List of all my_blogs";

echo elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'my_blog',
    'owner_guid' => elgg_get_logged_in_user_guid()
));

echo elgg_view_page($titlebar, [
    'title' => $pagetitle,
    'content' => $body,
]);