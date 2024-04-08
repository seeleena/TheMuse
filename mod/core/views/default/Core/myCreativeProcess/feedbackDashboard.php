<?php

$creativityFactors = $vars['creativityFactors'];


?>
<style>
    .tile {
        border: #4690D6 1px solid;
        width: 180px;
        height: 180px;
        background-color: #EBF5FF;
        margin: 5px;
        padding: 20px;
        float: left;
    }
    .tile:hover {
        border: white 1px solid;
    }
    .tile a {
        color: #0054A7;
    }
    .tile-title {
        font-size: xx-large;
        font-weight: bold;
        color: #0054A7;
    }
    .tile-subtitle {
        font-size: medium;
        font-weight: bold;
        color: #0054A7;
        margin-top: 10px;
    }
    .tile-text {
        margin-top: 120px;
    }
    .dashboard {
        margin-top: 20px;
    }
    .elgg-head {
        margin-bottom: 20px;
    }
    blockquote {
        margin-bottom: 20px;
    }
    .elgg-main {
        margin-bottom: 20px;
    }

    
</style>
<h1>Feedback</h1>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Feedback Dashboard</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Student Feedback Dashboard</h2>
    </div>
    <blockquote>
        <p>This page gives you feedback on your progress based on seven Creativity Factors. You can also compare your score with the class average (shown below your score). Scores are updated as you progress through the various activities.</p>
        <p>Furthermore, there are practice activities and hints available to you should your score fall below 40%. Click on the relevant box for these helpful activities.</p>
    </blockquote>
    <div class="dashboard">
        <?php
        $improvementURL = getServerURL() . "/Core/myCreativeProcess/improvementActivities/";
        foreach ($creativityFactors as $factor) {
        ?>
        <div class="tile">
            <a href='<?php echo $improvementURL . $factor->id?>'>
                <div class="tile-title" title="Your score on <?php echo $factor->name?>"><?php echo $factor->rating?>%</div>
                <div class="tile-subtitle" title="Class Average for <?php echo $factor->name?>"><?php echo $factor->classAverage?>%</div>
                <div class="tile-text"><?php echo $factor->name?></div>
            </a>
        </div>        
        <?php
        }
        ?>
        
<?php
/*
        <div class="tile">
            <div class="tile-title" title="Your score on <?php echo $factor->name?>"><a href='<?php echo $improvementURL . $factor->id?>'><?php echo $factor->rating?>%</a></div>
            <div class="tile-subtitle" title="Class Average for <?php echo $factor->name?>"><?php echo $factor->classAverage?>%</div>
            <div class="tile-text"><?php echo $factor->name?></div>
        </div>       
 */
 
?>
    </div>
</div>