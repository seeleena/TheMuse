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
        .myAlignLeft {
            text-align: left;
        }
        .mytext {
            text-align: left;
        }
        .imgStyle {
            float: left;
            margin-right: 10px;
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
$params = array(
    'assignID' => $assignID,
    'activityID' => $activityID,
    'stageNum' => $stageNum,
    'helpme' => 'true'
);
$queryString = http_build_query($params);
$url = getServerURL() . "Core/myCreativeProcess/owner/" . $assignID . "?" . $queryString;
?>
<a href='<?php echo $url ?>' class='blu-btn'>Help Me</a>

</div>
<?php
//update
$instructions = array();
$instructions = $activity['instructions'];
$instruction = new StdClass();
$tools = array();
$lines = array();
$i =0; 
$siteURL = elgg_get_site_url().'_graphics/themuse/pensive.jpg';
//add user-added instructions and tools here. 
//this for below will be empty? since the activity would not exist.
//so use and isset on the array.
foreach ($instructions as $instruction) {
    $i++;
    echo "<div class='bubble'>
        <div class='rectangle'><div class='couponcode'><h2><div class='myAlignLeft'>Instruction $i: <img src='$siteURL' width='30px' height='30px' class='imgStyle'/></div></h2></div>
        </div>
        <div class='triangle-l'></div>
        <div class='triangle-r'></div><br/><br/>";
    $instructionID = $instruction->id;
    $lines = $instruction->lines;
    $tools = $instruction->tools;
    $line = new StdClass();
    echo "<div><ul class='bullet mytext'>";
    foreach ($lines as $line) {
        $lineID = $line->id;
        $lineDesc = $line->desc;
        //error_log("IN ACTIIVTY lineid ".$lineID . "iDesc " . $iDesc);
        echo "<li >$lineDesc</li>";
    }
    echo "</ul></div>";
    $tool = new StdClass();
    foreach ($tools as $tool) {
        $toolName = $tool->name;
        $toolDesc = $tool->desc;
        $toolURL = $tool->url;
        echo "<div class='btn-container'>";
        echo "<a href='$toolURL$assignID/?activityID=$activityID&instructionID=$instructionID&stageNum=$stageNum' class='blu-btn'>$toolName</a>";
        echo "</div>";
        //echo " </br> $toolDesc </br>  </br>";
        //
        //Calculate the CIT completion rate. (Don't know what the other tools will show as yet)
        //go into the groupsolutioncreativeprocess table: if toolID is 1, it is a CIT
        //The hardcoded CIT values are in collaborativeinputtoolinstructions table
        //Given the JSON structure below, there can be more than 1 user's answer per CIT_ID,
        //so for the completion rate, we need to count whether an answer exists (Not empty string) for
        //each CIT_ID, eg act:1, instr:1, 3 has CIT_IDs 1, 2 & 3.
        //The completion values are per instruction. I also want to display 
        //the rate per instruction and per activity.
        //The hardcoded CIT completion values are:
        //      act:1, instr:1, 3   
        //      act:2, instr:3, 1
        //      act:2, instr:4, 1
        //      act:2, instr:5, 1
        //      act:3, instr:6, 3
        //      act:4, instr:7, 4
        //      act:6, instr:9, 2
        //      act:7, instr:10, 2
        //      act:8, instr:11, 2
        //      act:9, instr:12, 6
        //      act:10, instr:13, 9
        //      act:18, instr:54, 3
        //      act:18, instr:55, 2
        //As separate from completion rate, I need the number of answers posted per CIT_ID per user, 
        //which means number of answers per question by student.
        //The JSON structure for CIT from the DB is :
        /*** SAMPLE DATA STRUCTURE FOR ALLRESPONSES ***/
/*
{
	"groupResponses": [
		{
			"userResponses": [{
				"user": "student1",
				"answer": "student1 purpose"
			},
			{
				"user": "student2",
				"answer": "student2 purpose"
			}],
			"citID": 1
		},
		{
			"userResponses": [{
				"user": "student2",
				"answer": "student2 broad"
			},
			{
				"user": "student1",
				"answer": "student1 broad"
			}],
			"citID": 2
		},
		{
			"userResponses": [{
				"user": "student2",
				"answer": "student2 components"
			},
			{
				"user": "student1",
				"answer": "student1 componenets"
			}],
			"citID": 3
		}
	]
}
*/
        
    }
    echo "</div><br/><br/>";
}
/*
$instructions = array();
$instructions = $activity['instructions'];
for($i = 1, $size = count($instructions); $i <= $size; $i++) { 
    $instructionDetails = array();
    $instructionDetails = $instructions[$i-1];
    echo "<div class='elgg-head clearfix'>'<h3 class='elgg-heading-main'>Instruction $i:</h3></div>";
    echo "<div class='background'><p>";
    echo $instructionDetails[1];
    echo "</p></div><br/>";
    echo "<div class='elgg-head clearfix'>'<h3 class='elgg-heading-main'>List of Tools</h3></div>";
    $tools = array();
    $tools = $instructionDetails[2];
    echo "<ul class='numberedList'>";
    for($j = 1, $jsize = count($tools); $j <= $jsize; $j++) { 
        $tool = array();
        $tool = $tools[$j-1]; //double check this for other CPs
        echo "<li>";
        echo "<a href='$tool[2]$assignID/?activityID=$activityID&instructionID=$instructionDetails[0]'>$tool[0]</a> - $tool[1]";
        echo "<p></p>";
        echo "</li>";
    }
    echo "</ul>";
    echo "</br><div class='elgg-head clearfix'>'<h3 class='elgg-heading-main'>Hints</h3></div>";
    echo "<p>";
    echo $instructionDetails[3];
    echo "</p></br>";
}*/

?>
</div>