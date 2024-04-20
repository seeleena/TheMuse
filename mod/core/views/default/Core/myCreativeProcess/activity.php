<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Activity Details</li></ul>
    
<?php
 
$assignID = $_GET['assignID'];
$stageNum = $_GET['stageNum'];
$activity = $vars['activity'];
$activityID = $activity['activityID'];
$userID = elgg_get_logged_in_user_guid();
?>
  
    <style>
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
            padding: 10px 10px;
            background: #34b4db;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin: 10px 0;
        }
      
        .imgStyle {
            float: left;
            margin-right: 10px;
        }
        .desc {
            margin: 10px 0;
            padding-left: 10px;
        }
    </style>

    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main"> <?php echo  $activity['shortDesc'] ?> Activity </h2>
    </div>

<blockquote><p>
    <?php echo $activity['description'] ?>
</p></blockquote>
<!--//Help Button link -->
<div class='btn-container'>
<?php
    // Define parameters for the query string
    $params = array(
        'assignID' => $assignID,
        'activityID' => $activityID,
        'stageNum' => $stageNum,
        'helpme' => 'true'
    );
    // Build the query string
    $queryString = http_build_query($params);
    // Define the URL
    $url = getServerURL() . "Core/myCreativeProcess/owner/" . $assignID . "?" . $queryString;
?>
<!-- Create a link with the URL -->
<a href='<?php echo $url ?>' class='blu-btn'>Help Me</a>

</div>
<?php
    // Initialize an array to store instructions
    $instructions = array();
    // Get the instructions from the activity
    $instructions = $activity['instructions'];
    // Initialize variables
    $instruction = new StdClass();
    $tools = array();
    $lines = array();
    $i = 0; 
    // Define the site URL
    $siteURL = getServerURL().'_graphics/themuse/pensive.jpg';
    // Loop through each instruction
    foreach ($instructions as $instruction) {
        $i++;
        echo "<div class='bubble'>
            <div class='rectangle'><div class='couponcode'><h2><div class='myAlignLeft'>Instruction $i: </div></h2></div>
            </div>
            <div class='triangle-l'></div>
            <div class='triangle-r'></div><br/>";
        $instructionID = $instruction->id;
        $lines = $instruction->lines;
        $tools = $instruction->tools;
        $line = new StdClass();
        echo "<div><ul class='bullet mytext'>";
        // Loop through each line
        foreach ($lines as $line) {
            $lineID = $line->id;
            $lineDesc = $line->desc;
            echo "<h4 class='desc'>$lineDesc</h4>";
        }
        echo "</ul></div>";
        $tool = new StdClass();
        // Loop through each tool
        foreach ($tools as $tool) {
            $toolName = $tool->name;
            $toolDesc = $tool->desc;
            $toolURL = $tool->url;
            echo "<div class='btn-container'>";
            echo "<a href='$toolURL?assignID=$assignID&activityID=$activityID&instructionID=$instructionID&stageNum=$stageNum' class='blu-btn'>$toolName</a>";
            echo "</div>";      
        }
        echo "</div><br/><br/>";
    }
?>
</div>