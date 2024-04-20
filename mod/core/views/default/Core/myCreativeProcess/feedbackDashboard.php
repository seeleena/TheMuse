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
    // Define the URL for improvement activities
    $improvementURL = getServerURL() . "/Core/myCreativeProcess/improvementActivities/";

    // Loop through each creativity factor
    foreach ($creativityFactors as $factor) {
        // Start a new tile
        echo "<div class='tile'>";
        // Create a link to the improvement activity for this factor
        echo "<a href='{$improvementURL}{$factor->id}'>";
        // Display the user's score for this factor
        echo "<div class='tile-title' title='Your score on {$factor->name}'>{$factor->rating}%</div>";
        // Display the class average for this factor
        echo "<div class='tile-subtitle' title='Class Average for {$factor->name}'>{$factor->classAverage}%</div>";
        // Display the name of this factor
        echo "<div class='tile-text'>{$factor->name}</div>";
        // End the link and the tile
        echo "</a></div>";
    }
?>
</div>
</div>

