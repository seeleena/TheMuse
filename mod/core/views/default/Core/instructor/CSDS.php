<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Solution Assessment - Creativity</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Creativity Assessment of Solution</h2>
    </div>
    <blockquote>
        <p>Rate the group's solution on how creative it is using each of the criteria below. These
            are the criteria that you selected for assessment of creativity for your assignment.
            Think on each criteria and the degree of creativity that the criteria is fulfilled 
            by the solution. You can use an upper mark of 10 for each criteria. Enter a mark for 
        each criteria. Click on 'Calculate Sum' to generate the total creativity mark for this solution.</p>
    </blockquote>
<?php
$assignID = $_GET['assignmentID'];
$allCriteria = array();
$allCriteria = getAllCriteria($assignID); //change to send assignID
echo "<table class='elgg-table'>";
foreach ($allCriteria as $headingID => $head) {
    $critArray = array();
    $headName = $head->name;
    $headDesc = $head->desc;
    $headWeight = $head->weight;
    $critArray = $head->critArray;
    echo "<tr><td colspan='2' class='mytext'>$headName - $headDesc [Weight: $headWeight]
         <input type='hidden' class='headweight' value='$headWeight' data-heading='$headingID'/></td></tr>";
    echo "<tr class='mytext'><th>Criteria</th><th>Mark</th></tr>";
    foreach ($critArray as $criteriaID => $crit) {
        $critName = $crit->name;
        $critDesc = $crit->desc;
        $critWeight = $crit->weight;
        echo "<tr><td>$critName - $critDesc [Weight: $critWeight]</td>";
        echo "<td><input class='critweight' type='hidden' value='$critWeight' data-heading='$headingID'/>
             <input class='mark' type='text' data-heading='$headingID'/></td></tr>";
    }
    echo "<tr class='blank_row'><td colspan='2'></td></tr>";
}
echo "</table>";
echo "<br /><div align='center'><input type='button' id='btnCalculate' value='Calculate Sum' class='blu-btn'/></div>";
?>
</div>

<script type="text/javascript">
    $("#btnCalculate").click(function() {
        
        alert("The final creativity mark for the solution is: "+getAllHeadingMarks()+".\n\nPlease close this page and enter the score in the 'Creativity Score for Solution' box on the previous page.");
    });
    
    function getAllHeadingMarks() {
        var finalHeadingMark = 0, headingID, totalCriteriaForHeading, headingWeight;
        $("input.headweight").each(function() {
            headingID = $(this).data("heading");
            headingWeight = $(this).val();
            totalCriteriaForHeading = getTotalCrit(getAllMarksForHeading(headingID), getAllWeightsForHeading(headingID));
            finalHeadingMark += (totalCriteriaForHeading * headingWeight/100);
         });
         return finalHeadingMark;
    }
    
    function getAllMarksForHeading(headingID) {
        return $("input.mark[data-heading='" + headingID + "']");
    }
    
    function getAllWeightsForHeading(headingID) {
        return $("input.critweight[data-heading='" + headingID + "']");
    }
        
    function getTotalCrit(allMarks, allCriteriaWeightingForHeading) {
        var total = 0;
        for (var i = 0; i < allMarks.length; i++) {
             var mark = parseInt(allMarks[i].value, 10) || 0; //base 10, also if empty string use 0.
             var weight = parseInt(allCriteriaWeightingForHeading[i].value, 10) || 0;
             total += (mark * weight/100);
        }
        return total;
    }   
</script>