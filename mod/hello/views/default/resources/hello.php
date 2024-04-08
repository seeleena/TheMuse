<?php

$user = elgg_get_logged_in_user_entity();

echo $user->name;
/*
echo elgg_view_page('Hello', [
    'title' => 'Hello world! Waiting for my end!',
    'content' => 'My first page!',


])*/;
