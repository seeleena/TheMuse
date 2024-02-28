<?php
$user = elgg_get_logged_in_user_entity();
?>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Home > Course Operations</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Welcome to the Muse v2, <?php echo $user->username; ?>.</h2>
    </div>
    <blockquote>
    <p>
        Welcome! You can manage your course using the links below.
        The Assignment Grading menu at the top right of the page gives you access to
        all assignments submitted.
    </p>
</blockquote>
<?php

$urls = array(
    "Add a course - add your course to The Muse." => "Core/course/add", 
    "Add a course run - add the current run of your course for the semester." => "Core/course/addRun", 
    "Populate a course - add students to your course." => "Core/course/populate", 
    "Add a Task/Assignment - add assignments and projects to your course." => "Core/assignment/add",
    //for last "View completed CPs (creative processes)." => "Core/grading/selectAssignToPrintCP",
    );
?>
    
<table class="elgg-table">
<?php     
foreach($urls as $urlTitle => $url) {
    $url = elgg_normalize_url($url);
    echo "<tr><td><a href='$url'>$urlTitle</a></td></tr>";
}
?>
</table>
</div>
