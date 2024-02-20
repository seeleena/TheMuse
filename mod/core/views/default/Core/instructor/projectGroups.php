<script type="text/javascript">
    $("#submitMarks").click(function() {
        console.log('testing');
        alert('hey');
        var marksEntryDiv = $(this).parent();
        var assignmentScore = marksEntryDiv.find(".assignmentScore:first").val();
        var creativeAssignmentScore = marksEntryDiv.find(".creativeAssignmentScore:first").val();
        //var finalScore = marksEntryDiv.find(".finalScore:first").val();
        var groupID = marksEntryDiv.find(".elggGroupID:first").val();
        var assignmentID = $("#assignments").val();
        var scoreElements = marksEntryDiv.find(".creativeProcessScore");
        var scores = [];
        scoreElements.each(function() {
            scores.push({
                studentID: $(this).attr("data-studentid"),
                score: $(this).val()
            });
        });
        elgg.action('assessment/saveGrades', {
            data: {
                    assignmentScore: assignmentScore,
                    creativeAssignmentScore: creativeAssignmentScore,
                    //finalScore: finalScore,
                    elggGroupID: groupID,
                    assignmentID: assignmentID,
                    scores: scores
            },
            success: function(json) {
                    alert('the server returned: ' + json.output);
            }
        });
    });
    
    $(".linkToCreativeProcess").click(function() {
        var groupID = $(this).attr('data-groupID');
        var assignmentID = $("#assignments").val();
        var creativeProcessURL = "groupCreativeProcess/" + groupID + "/" + assignmentID;
        var newTab = window.open(creativeProcessURL, '_blank');
        newTab.focus();
    });
</script>

<div id="allGroups">
    

<?php
$allGroups = array();
$allGroups = $vars['allGroups'];
$assessmentTechniqueSolution = $vars['assessmentTechniqueSolution'];
$assessmentTechniqueProcess = $vars['assessmentTechniqueProcess'];
$assignmentID = $vars['assignmentID'];

for($i = 0; $i < count($allGroups); $i++) {
    $group = new StdClass;
    $group = $allGroups[$i];
    $groupID = $group->id;
    $groupEntity = get_entity ($groupID);
    $groupName = $groupEntity->name;
    echo "<br /><br /><div class='elgg-head clearfix'><h3 class='elgg-heading-main'>Group: ".$groupName."</h3></div>";
    echo "<table class='elgg-table'>";
    echo "<tr><td><label>Members</label></td><td>";
    $groupMembers = array();
    $groupMemberData = array();
    $student = getStudent($group->member);
    echo "$student->id";// - $student->name";
    $m = 0;
    $groupMembers[$m] = $group->member;
    $groupMemberData[$m] = "$student->id";// - $student->name";
    $j = $i + 1;
    $nextGroup = $allGroups[$j];
    while($group->id == $nextGroup->id) {
        echo "<br/>";
        $student = getStudent($nextGroup->member);
        echo "$student->id";// - $student->name";
        $i++;
        $m++;
        $groupMembers[$m] = $nextGroup->member;
        $groupMemberData[$m] = "$student->id";// - $student->name";
        $j = $i + 1;
        $nextGroup = $allGroups[$j];
    }
    echo "</td>";
    echo "</tr><tr><td><label>Assignment Submission</label></td>";
    if($assessmentTechniqueSolution == "CAT") {
        echo "<td><a target='_blank' href='CAT/$assignmentID'>CAT Instructions for Solution</a><br/>";
    }
    else {
        echo "<td><a target='_blank' href='CSDS/?assignmentID=$assignmentID&groupID=$groupName'>CSDS Creativity Scoring for Solution</a><br/>";
    }
    $fileGuid = getFileGuidForGroupSolution($groupID, $assignmentID);
    echo "<a href='" . getServerURL() . "action/file/download?file_guid=$fileGuid'> Download this group's Solution</td></tr>";
    echo "<tr><td><label>Creative Process</label></td><td><a class='linkToCreativeProcess' data-groupID='" . $groupID . "' href='#'>View this group's Process</a><br/>";//an href for groupCreativeProcess.php sending groupID and assignID
    if($assessmentTechniqueProcess == "CreativityCriteria") {
        echo "<a target='_blank' href='CRITERIA/$assignmentID'>Creativity Criteria for Process</a><br/>";
    }
    else {
        echo "<a target='_blank' href='CAT/$assignmentID'>CAT Instructions for Solution</a><br/>";
    }
    echo "</td></tr>";
?>
    <tr>
        <td>
            <label>Enter Marks</label>
        </td>
        <td>
            <div class="marksEntry">
                <label>Assignment Score</label>
                <input type="text" class="assignmentScore" />
                <label>Creativity Score for Solution</label>
                <input type="text" class="creativeAssignmentScore" />
                <label>Creativity Score for Process</label>
                <br />
                <?php
                for($k = 0; $k < count($groupMembers); $k++) {
                    
                    echo "<label >$groupMemberData[$k]:</label>";
                    echo "<input type='text' class='creativeProcessScore' data-studentID='" . $groupMembers[$k] . "' />";
                }
                echo "<input type='hidden' class='elggGroupID' value='$groupID' />";
                ?>
                
                <input type="button" class="blu-btn" value="submitMarks" id="submitMarks"/>
            </div>
        </td>
    </tr>
    </table>
<?php
}
?>

</div>