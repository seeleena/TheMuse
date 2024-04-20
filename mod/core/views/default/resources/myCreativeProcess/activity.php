
<?php
    // Include utilities from the Core plugin
    include elgg_get_plugins_path() . "Core/lib/utilities.php";

    // Set the title of the page
    $title = "My Creative Process";

    // Extract the activity ID from the $vars array
    $activityID = (string) elgg_extract('activityID', $vars);

    // Get the details of the activity with the extracted ID
    $activity = getActivityDetails($activityID);

    // Add the current activity, activity ID, and activity details to the variables array
    $vars['CurrentActivity'] = $activity;
    $vars['activityID'] = $activityID;
    $vars['activity'] = $activity;

    // Generate the content of the page by rendering the 'Core/myCreativeProcess/activity' view
    // The second argument to elgg_view() is an array of variables to pass to the view
    $content = elgg_view('Core/myCreativeProcess/activity', $vars);

    // Add the content to the variables array
    $vars['content'] = $content;

    // Generate the layout of the page by rendering the 'one_sidebar' layout
    // The second argument to elgg_view_layout() is an array of variables to pass to the layout
    $body = elgg_view_layout('one_sidebar', $vars);

    // Output the page by rendering the 'elgg_view_page' view
    // The first argument is the title of the page, and the second argument is the body of the page
    echo elgg_view_page($title, $body);
?>

