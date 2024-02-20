<style>
    #cpDeBono {
        <!--
        background-color: red;
        -->
    }
    .cpStage {
        font-variant: small-caps;
        font-size: 14pt;
        padding-bottom: 10px;
        padding-top: 10px;
    }
    #activities {
        font-size: 10pt;
    }
    .cpActivity {
        font-style: italic;
        padding-left: 15px;
    }
    .cpActivity.selected {
        font-weight: bold;
        font-size: 12pt;
        color: #fff;
        background-color: #7f9db9;
        padding-bottom: 5px;
        padding-top: 5px;
    }
    #instructions {
        font-size: 10pt;
    }
    
    .cpInstruction {
        color: #fff;
        padding-left: 25px;
    }
    .cpInstruction.selected {
        font-size: 12pt;
        color: #fff;
        background-color: #7f9db9;
        text-decoration: underline;
    }
</style>
<ul id="cpDeBono" class="creativeProcess">
<?php
$creativeProcess = $_SESSION["CreativeProcess"];
$currentActivity = $_SESSION['CurrentActivity'];
$instructions = $currentActivity['instructions'];
$currentActivityID = $currentActivity['activityID'];
$currentInstructionID = $_SESSION['CurrentInstructionID'];
$assignID = getCurrentAssignmentID();
$stages = $creativeProcess->stages;
$stageNum = get_input("stageNum");
$activityID = get_input("activityID");
$owner = $_SESSION['owner'];
$activities = array();
$disabled = empty($assignID);
logUsage($owner, $currentActivityID, $currentInstructionID, $assignID);
?>
<?php if (!$disabled) { ?>
    <h2 class="elgg-heading-main<?php echo ($disabled ? " disabled" : "")?>"><a href='<?php echo getServerURL() . "Core/myCreativeProcess/owner/" . $owner . "?assignID=" . $assignID . "&activityID=" . $activityID . "&stageNum=" . $stageNum?>'>Activity Home</a></h2>    
<?php } else { ?>
    <h2 class="elgg-heading-main" style="color:gray" title="Your course and assignment must be chosen before starting an Activity.">Activity Home</h2>    
<?php } ?>
    <br />
    <h2 class="elgg-heading-main"><a target="_blank" href="<?php echo getServerURL(); ?>Core/myCreativeProcess/feedbackDashboard">Feedback Dashboard</a></h2>
    <br />
<?php
$currentInstructionURL = getServerURL() . "Core/myCreativeProcess/activity/$currentActivityID?assignID=$assignID&stageNum=$stageNum";
foreach($stages as $stage) {
    $name = $stage->name;
    $desc = $stage->desc;
    echo "<li id='stage$stage->num' class='cpStage'>Stage $stage->num</li>";
    $activities = $stage->activities;
    echo "<ul id='activities'>";
    foreach ($activities as $activity) {
        if ($activity->num == $currentActivityID) {
            echo "<li id='activity$activity->num' class='cpActivity selected'>";
            echo "$activity->shortDesc";
            $instructionIndex = 0;
            echo "<ul id='instructions'>";
            foreach ($instructions as $instruction) {
                $instructionIndex++;
                if ($currentInstructionID == $instruction->id) {
                    echo "<li id=instruction$instruction->id class='cpInstruction selected'><a style='color:white !important' href='$currentInstructionURL'>Instruction: $instructionIndex</a></li>";
                }
                else {
                    echo "<li id=instruction$instruction->id class='cpInstruction'>Instruction: $instructionIndex</li>";
                }
//                $instructionSelectedClass = ($currentInstructionID == $instruction->id) ? (' selected') : ('');
//                echo "<li id=instruction$instruction->id class='cpInstruction$instructionSelectedClass'><a href='$currentInstructionURL'>Instruction: $instructionIndex</a></li>";
            }
            echo "</ul>";
            echo "</li>";        
        }
        else { 
            echo "<li id='activity$activity->num' class='cpActivity'>$activity->shortDesc</li>";        
        }
    }
    
    echo "</ul><br />";
}
?>
</ul>
