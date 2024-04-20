
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Creativity Process</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Creative Pedagogy</h2>
    </div>
    
    
<?php

$assignmentID = $vars['assignmentID'];
$cpID = get_input('cpID');
$cpDetails = getCPDetails($assignmentID,$cpID);
$cpName = $cpDetails->name;
$cpOverview = $cpDetails->overview;
echo "<div class='elgg-head clearfix'><h2 class='elgg-heading-main'>$cpName</h2></div>";
echo "<blockquote><p>$cpName: $cpOverview</p></blockquote>";
$stages = $cpDetails['stages'];
$i = 0;
foreach ($stages as $stageNum => $stageDetails) {
    $i++;
    foreach ($stageDetails as $value) {
        $name = $value[0];
        echo "<div class='elgg-head clearfix'><h3 class='elgg-heading-main'>Stage $i: $name</h3></div>";
        $description = $value[1];
        echo "<p>$description</p>";
        echo "<h4 class='myheader'>List of Activities for Stage $i</h4>";
        $activities = array();
        $activities = $value[2];
        $j = 0;
        foreach ($activities as $id => $desc) {
            $j++;
            echo "<h4 class='myheader'><u>Activity $j</u></h4><p>$desc</p>";
            $activityDetails = array();
            $activityDetails = getActivityDetails($id, $assignmentID);
            $instructions = array();
            $instructions = $activityDetails['instructions'];
            echo "<h4 class='myheader instructionsMargin'>List of Instructions</h4>";
            $k = 0;
            foreach ($instructions as $instruction) {
                $k++;
                $instructionID = $instruction[0];
                $instructionDesc = $instruction[1];
                $tools = array();
                $tools = $instruction[2];
                echo "<div class='background instructionsMargin'><p><b>Instruction $k:</b> $instructionDesc</p></div>";
                echo "<h4 class='myheader toolsMargin'>List of Tools</h4>";
                echo "<ul class='greyNumberedList toolsMargin'>";
                foreach ($tools as $tool) {
                    $toolName = $tool[0];
                    $toolDesc = $tool[1];
                    //$toolURL = $tool[2];
                    echo "<li>$toolName - $toolDesc</li>";
                    //echo $toolName." ".$toolDesc;
                }
                echo "</ul><br/>";
                /*$hint = $instruction[3];//not working.
                echo "</br><div class='elgg-head clearfix'>'<h3 class='elgg-heading-main'>Hints</h3></div>";
                echo "<p>$hint</p></br>";*/
            }
            echo "<hr/>";
        }
        
    }
}
//echo $cpOverview;

?>
</div>