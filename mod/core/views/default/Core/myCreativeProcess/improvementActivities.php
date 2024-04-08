<?php
$improvementActivities = $vars['activities'];
$assignmentID = $vars['assignmentID'];
$factorRating = $vars['factorRating'];
$stageNum = $_GET['stageNum']; 
$assignID = $_GET['assignID'];
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
    .bubble {
        position: relative;
        width: 100%;
        padding: 15px;
        background: #f9f9f9;
        border: 1px solid #c9c9c9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .rectangle {
        position: relative;
        width: 100%;
        padding: 15px;
        background: #f9f9f9;
        border: 1px solid #c9c9c9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .blu-btn {
        display: inline-block;
        padding: 10px 20px;
        background: #34b4db;
        color: #fff;
        text-decoration: none;
        border-radius: 3px;
        margin: 10px 0;
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
                    <?php echo "<a href='" . $activityURL . "$activity->id?assignID=$assignID&stageNum=$stageNum' class='blu-btn'>$activity->shortDescription</a>";?>
                </span>
            </div>
            <?php } ?>
        </div>        
    </div>
</div>