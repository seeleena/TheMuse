<?php
$studentID = $vars['studentID'];
?>

<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>My Assignments</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Welcome to your Assignment List, <?php echo $studentID; ?>.</h2>
    </div>
    <blockquote >
        <p> Below is a list of your assignments. Each link will provide you with a view of the assignment sheet.
            These links are meant for you to view your assignment instructions.
            To begin an assignment, you must select the "My Creative Process" menu above. 
        </p>
    </blockquote>

<div class="elgg-head clearfix">
        <h3 class="elgg-heading-main">Your Assignments:</h3>
</div>
    
<?php
$courses = $vars['courses'];
$assignments = $vars['assignments'];

foreach ($courses as $courseCode => $courseRun) {
    echo "<ul class='list'>";
    echo "<li><b> $courseCode </b></li>";
    echo "<ul class='list'>";
   
    foreach ($assignments as $key => $val) {
        $assignment = array();
        $assignment = $assignments[$key];
        $assignCourse = $assignment['course'];
        if($assignCourse == $courseCode) {
            $assignID = $assignment['assignID'];
            $assignNum = $assignment['number'];
            echo "<li> <a href='viewDetails/$assignID' > Assignment #: $assignNum </a></li>";
        }
    }
    echo "</ul>";
}
echo "</ul>";
?>
</div>
