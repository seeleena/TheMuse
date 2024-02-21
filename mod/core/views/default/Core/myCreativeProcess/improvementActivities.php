<?php
$improvementActivities = $vars['activities'];
$assignmentID = $vars['assignmentID'];
$factorRating = $vars['factorRating'];
$goodJob = "";
if ($factorRating->rating > 40) {
    $goodJob = " Your score is very good, but if you want to improve it or practise further, you can still do some of the suggested activities.";
}
$communicationMessage = $vars['communicationMessage'];

//$emptyMessage = (IsNullOrEmptyString($communicationMessage) ? "There are no suggested activities at this time. Please select")
?>
<style>
    #noImprovementActivities {
        padding: 20px;
    }
    h1 {
        line-height: 1;
    }
</style>
<h1>Activities for improving your score on <?php echo $factorRating->name;?></h1>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Creativity Factors Improvement Activities</li></ul>
    <blockquote>
        <p>Suggested activities for improvement.<?php  echo $goodJob;?></p>
    </blockquote>
    <div>
        <div class='bubble'> 
        <div class='rectangle'><div class='couponcode'><h2>Suggested Activities</h2><span class='coupontooltip'>Suggested activities, prioritized</span></div>
        </div>
        <div class='triangle-l'></div>
        <div class='triangle-r'></div><br/><br/>
            <?php 
            if (empty($improvementActivities)) {
                echo "<div id='noImprovementActivities'>" . $communicationMessage . "</div>";
            }
            $activityURL = getServerURL() . "/Core/myCreativeProcess/activity/";
            foreach ($improvementActivities as $activity) { ?>
            <div class='btn-container' style="height: 50px; line-height: 50px; text-align: center;">
                <span style="display: inline-block; vertical-align: middle; line-height: normal;">
                    <?php echo "<a href='" . $activityURL . "$activity->id?assignID=$assignmentID&stageNum=$stageNum' class='blu-btn'>$activity->shortDescription</a>";?>
                </span>
            </div>
            <?php } ?>
        </div>        
    </div>
</div>