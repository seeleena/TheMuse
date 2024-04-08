<?php
$studentID = $vars['studentID'];
?>
<style>
    .elgg-head{
        background-color: #f3f3f3;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        padding: 10px;
    }
    .list{
        background-color: #f3f3f3;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        padding: 10px;
        
    }
    
    .elgg-main {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
    }
    .items {
        margin-bottom: 5px;
    }
    
</style>
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
    echo "<ul class='list-upper'>";
    echo "<li><b> $courseCode </b></li>";
    echo "<ul class='list'>";
   
    foreach ($assignments as $key => $val) {
        $assignment = array();
        $assignment = $assignments[$key];
        $assignCourse = $assignment['course'];
        if($assignCourse == $courseCode) {
            $assignID = $assignment['assignID'];
            $assignNum = $assignment['number'];
            $assignDesc = $assignment['description'];
            echo "<li class='items'> <a href='view/$assignID' > Assignment #$assignNum - $assignDesc </a></li>";
        }
    }
    echo "</ul>";
}
echo "</ul>";
?>
</div>
