<?php
// get the form inputs
$title = elgg_get_title_input('title');
$body = get_input('body');
$tags = elgg_string_to_array((string) get_input('tags'));

// create a new my_blog object and put the content in it
$blog = new ElggObject();
$blog->title = $title;
$blog->description = $body;
$blog->tags = $tags;

// the object can and should have a subtype
$blog->setSubtype('my_blog');

// for now, make all my_blog posts public
$blog->access_id = ACCESS_PUBLIC;

// owner is logged in user
$blog->owner_guid = elgg_get_logged_in_user_guid();

// save to database
// if the my_blog was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($blog->save()) {
   return elgg_ok_response('', "Your blog post was saved.", $blog->getURL());
} else {
   return elgg_error_response("The blog post could not be saved.");
}