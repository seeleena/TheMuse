.<style>
    .instruction, .instructionContents {
        display: none;
    }
    .instruction.active, .instructionContents.active {
        display: block;
    }
    #btnSaveSectionWeightings, #btnSaveAssessmentWeightings {
        display: none;
    }
    #btnSaveSectionWeightings.active, #btnSaveAssessmentWeightings.active {
        display: block;
    }
    .weightingError {
        background-color: red;
    }
</style>

<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Solution Assessment - Creativity</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Creativity Assessment of Solution</h2>
    </div>
    <blockquote>
        <p>Follow the instructions below to select the criteria for assessing 
            students' solutions to your assignment.</p>
    </blockquote>

    <div id="instruction1" class="instruction active">
        <blockquote>
        <p>Select the Criteria for assessment of the assignment Solution.</p>
        </blockquote>
    </div>
    <div id="instruction2" class="instruction">
        <blockquote>
        <p>For each of the Section headings, give a weighting that represents the importance of the 
            criteria to the overall creativity assessment of the solution.</p>
        </blockquote>
    </div>
    <div id="instruction3" class="instruction">
        <blockquote>
        <p>For each criterion within a Section heading, give a weighting that represents the importance of 
            that criterion within the Section heading to the overall creativity assessment of the solution.</p>
        </blockquote>
    </div>
    

<?php
    // <editor-fold defaultstate="collapsed" desc="icky PHP Code for setting up headings and criteria">

$assignmentID = $vars['assignmentID'];
$allHeadings = array();
$allCriteria = array();

$heading = new stdClass();
$heading->ID = "H1";
$heading->title = "Relevance & Effectiveness";
$heading->desc = "Knowledge of existing facts and principles.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H2";
$heading->title = "Problematization";
$heading->desc = "Solution draws attention to problems in what already exists.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H3";
$heading->title = "Propulsion";
$heading->desc = "Solution propels the field including, the known is seen in a new way, transferred to a new setting, extended in a new direction or new approach.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H4";
$heading->title = "Elegance";
$heading->desc = "Solution is tasteful and aesthetic in its simplicity.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H5";
$heading->title = "Genesis";
$heading->desc = "Ideas in the solution go beyond the immediate situation.";
$heading->weight = "";
$allHeadings[] = $heading;

$header1Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c1";
$criteria->desc = "PERFORMANCE (the solution does what it is supposed to do)";
$criteria->Hid = "H1";
$criteria->weight = "";
$criteria->score = "";
$header1Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c2";
$criteria->desc = "APPROPRIATENESS (the solution fits within task constraints)";
$criteria->Hid = "H1";
$criteria->weight = "";
$criteria->score = "";
$header1Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c3";
$criteria->desc = "CORRECTNESS (the solution accurately reflects conventional knowledge and/or techniques)";
$criteria->Hid = "H1";
$criteria->weight = "";
$criteria->score = "";
$header1Criteria[] = $criteria;
$allCriteria["H1"] = $header1Criteria;

$header2Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c4";
$criteria->desc = "PRESCRIPTION (the solution shows how existing solutions could be improved)";
$criteria->Hid = "H2";
$criteria->weight = "";
$criteria->score = "";
$header2Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c5";
$criteria->desc = "PROGNOSIS (the solution helps the beholder to anticipate likely effects of changes)";
$criteria->Hid = "H2";
$criteria->weight = "";
$criteria->score = "";
$header2Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c6";
$criteria->desc = "DIAGNOSIS (the solution draws attention to shortcomings in other existing solutions)";
$criteria->Hid = "H2";
$criteria->weight = "";
$criteria->score = "";
$header2Criteria[] = $criteria;
$allCriteria["H2"] = $header2Criteria;

$header3Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c7";
$criteria->desc = "REDEFINITION (the solution helps the beholder see new and different ways of using the solution)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c8";
$criteria->desc = "REINITIATION (the solution indicates a radically new approach)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c9";
$criteria->desc = "GENERATION (the solution offers a fundamentally new perspective on possible solutions)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c10";
$criteria->desc = "REDIRECTION (the solution shows how to extend the known in a new direction)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c11";
$criteria->desc = "COMBINATION (the solution makes use of new mixture(s) of existing elements)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;
$allCriteria["H3"] = $header3Criteria;

$header4Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c12";
$criteria->desc = "PLEASINGNESS (the beholder finds the solution neat, well done)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c13";
$criteria->desc = "COMPLETENESS (the solution is well worked out and rounded)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c14";
$criteria->desc = "SUSTAINABILITY (the solution is environmentally friendly)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c15";
$criteria->desc = "GRACEFULNESS (the solution well-proportioned, nicely formed)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c16";
$criteria->desc = "CONVINCINGNESS (the beholder sees the solution as skillfully executed, well-finished)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c17";
$criteria->desc = "HARMONIOUSNESS (the elements of the solution fit together in a consistent way)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c18";
$criteria->desc = "SAFETY (the solution is safe to use)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;
$allCriteria["H4"] = $header4Criteria;

$header5Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c19";
$criteria->desc = "VISION (the solution suggests new norms for judging other solutions-existing or new)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c20";
$criteria->desc = "TRANSFERABILITY (the solution offers ideas for solving apparently unrelated problems)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c21";
$criteria->desc = "SEMINALITY (the solution draws attention to previously unnoticed problems)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c22";
$criteria->desc = "PATHFINDING (the solution opens up a new conceptualization of the issues)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c23";
$criteria->desc = "GERMINALITY (the solution suggests new ways of looking at existing problems)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c24";
$criteria->desc = "FOUNDATIONALITY (the solution suggests a novel basis for further work)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;
$allCriteria["H5"] = $header5Criteria;

// </editor-fold>
echo "
<div id='instructionContents1' class='instructionContents active'>
    <table class='elgg-table'>
        <tr>
            <th width='80%' class='tableHeaderText'>Criteria</th>
            <th width='20%' class='tableHeaderText'>Creative Solution</th>
        </tr>";
foreach ($allCriteria as $key => $value) {
    switch ($key) {
        case "H1":
            $heading = $allHeadings[0];
            $headingTitle = $heading->title;
            $headingDesc = $heading->desc;
            echo "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 1:$headingTitle - $headingDesc</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            printCheckboxes($value);
            break;
        case "H2":
            $heading = $allHeadings[1];
            $headingTitle = $heading->title;
            $headingDesc = $heading->desc;
            echo "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 2:$headingTitle - $headingDesc</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            printCheckboxes($value);
            break;
        case "H3":
            $heading = $allHeadings[2];
            $headingTitle = $heading->title;
            $headingDesc = $heading->desc;
            echo "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 3:$headingTitle - $headingDesc</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            printCheckboxes($value);
            break;
        case "H4":
            $heading = $allHeadings[3];
            $headingTitle = $heading->title;
            $headingDesc = $heading->desc;
            echo "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 4:$headingTitle - $headingDesc</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            printCheckboxes($value);
            break;
        case "H5":
            $heading = $allHeadings[4];
            $headingTitle = $heading->title;
            $headingDesc = $heading->desc;
            echo "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 5:$headingTitle - $headingDesc</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            printCheckboxes($value);
            break;
        default:
            break;
    }
}
echo "
        <tr>
            <td colspan='3'><input type='button' id='instruction1Submit' value='Next Stage' /></td>
        </tr>
    </table>
</div>";

function printCheckboxes($value) {
    foreach($value as $crit) {
        $criteriaID = $crit->ID;
        $criteriaDesc = $crit->desc;
        echo "<tr data-headerID='$crit->Hid'>
            <td class='assessmentCriteria' class='criteriaDescription'>$criteriaDesc</td>
            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
        </tr>
        ";
    }
}
?>
    <?php
        echo elgg_view_form('instructor/setCSDScriteria', array('enctype' => 'multipart/form-data'));
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var assignmentID = <?php echo $assignmentID; ?>;
        $("#assignID").val(assignmentID);
        $("#instruction1Submit").click(function() {
            $("#instructionContents1").removeClass('active');
            $("#instruction1").removeClass('active');
            buildSectionWeightingTable("creativeSolution");
            $("#creativeSolutionWeightingDiv").addClass('active');
            $("#btnSaveSectionWeightings").addClass("active");
            $("#instruction2").addClass('active');
            $("input.headingAssessment").change(setInputMaxTo100);
        });
        
        $("#btnSaveSectionWeightings").click(function() {
            $("#instruction2").removeClass('active');
            $("#instruction3").addClass('active');
            $("input.headingAssessment").prop('readonly', true);
            buildCriteriaWeightingTable("creativeSolution");
            $("#btnSaveSectionWeightings").removeClass('active');
            $("#btnSaveAssessmentWeightings").addClass('active');
        });
        
        function buildCriteriaWeightingTable(weightingTable) {
            var checkedCriteria = getCheckedCriteria(weightingTable);
            var currentHeaderID, currentCriteria;
            for (var i = 0; i < checkedCriteria.length; i++) {
                currentCriteria = $(checkedCriteria[i]);
                currentHeaderID = currentCriteria.data('headerid');
                insertCriteriaIntoSection(currentCriteria, currentHeaderID, weightingTable);
            }
            $(".numbersOnly").keypress(setNumbersOnly);            
            $("input.criteriaAssessment").change(setInputMaxTo100);  
        }
        
        function setInputMaxTo100() {
            var currentInputBox = $(this);
            var allInputsForSection = getAllInputsForSection(currentInputBox);
            allInputsForSection.removeClass("weightingError");
            var totalForSection = getTotalForSection(allInputsForSection);
            if (totalForSection != 100) {
                currentInputBox.addClass("weightingError");
            }
        }
        
        function getAllInputsForSection(currentInputBox) {
            var headingID = currentInputBox.data("headingid");
            var inputType = getInputType(currentInputBox);
            if (inputType == "criteriaAssessment") {
                return $("input." + inputType + "[data-headingid='" + headingID + "']");
            }
            else {
                var criteriaType = currentInputBox.data("criteriatype");
                return $("input.headingAssessment[data-criteriatype='" + criteriaType + "']");
            }
        }
        
        function getInputType(inputBox) {
            if (inputBox.hasClass("criteriaAssessment")) {
                return "criteriaAssessment";
            }
            else { 
                return "headingAssessment";
            }
        }
        
        function insertCriteriaIntoSection(currentCriteria, currentHeaderID, weightingTable) {
            var currentHeaderSection = $("tr.headingAssessment[data-headingid='" + currentHeaderID + "'][data-criteriatype='" + weightingTable + "']:first");
            var criteriaTitle = currentCriteria.parent().prevAll("td.assessmentCriteria:first").text();
            var criteriaID = currentCriteria.attr("id");
            currentHeaderSection.after("<tr class='headingAssessment' data-headingID='" + currentHeaderID + "' data-criteriaType='" 
                    + weightingTable + "'><td>" + criteriaTitle + 
                    "</td><td><input name='" + criteriaID + "' id='" + criteriaID + "' type='text' class='criteriaAssessment numbersOnly' data-criteriaType='" 
                    + weightingTable + "' data-headingID='" + currentHeaderID + "'/></td></tr>");
        }
       
        function getTotalForSection(sectionHeadings) {
            var total = 0;
            for (var i = 0; i < sectionHeadings.length; i++) {
                total += parseInt(sectionHeadings[i].value, 10) || 0; //base 10, also if empty string use 0.
            }
            return total;
        }
       
        function buildSectionWeightingTable(weightingTable) {
            var checkedCriteria = getCheckedCriteria(weightingTable);
            var currentHeaderID, currentCriteria;
            var selectedHeaders = [];
            for (var i = 0; i < checkedCriteria.length; i++) {
                currentCriteria = $(checkedCriteria[i]);
                currentHeaderID = currentCriteria.data('headerid');
                if ($.inArray(currentHeaderID, selectedHeaders) === -1) {
                    selectedHeaders.push(currentHeaderID);
                }
            }
            var weightingTableRowInsertionArea = $("#" + weightingTable + "WeightingTable > tbody:first");
            var headingTitle, row;
            for (var i = 0; i < selectedHeaders.length; i++) {    
                headingTitle = getHeadingTitle(selectedHeaders[i]);
                row = $("<tr class='headingAssessment' data-headingID='" + selectedHeaders[i] + 
                        "' data-criteriaType='" + weightingTable + "'><td>" + headingTitle + 
                        "</td><td><input name='" + selectedHeaders[i] + "' type='text' class='headingAssessment numbersOnly' data-criteriaType='" 
                        + weightingTable + "' data-headingID='" + selectedHeaders[i] 
                        + "' id='" + selectedHeaders[i] + "'/></td></tr>");//added id
                weightingTableRowInsertionArea.append(row);
            }
            $(".numbersOnly").keypress(setNumbersOnly);
            //set val to 100 if only 1 item.
            if (selectedHeaders.length == 1) {
                row.find("input:first").val("100").prop('readonly', true);
            }
        }
        
        function setNumbersOnly() {
            var regexReplaceResult = this.value.replace(/[^0-9]/g, '');
            if (this.value != regexReplaceResult) {
                this.value = regexReplaceResult;
            }            
        }

        function getHeadingTitle(headingID) {
             return $("td[data-headingid='" + headingID + "']").data('headingtitle');
        }
       
        function getCheckedCriteria(weightingTable) {
            return $("input[type='checkbox']").filter("[data-criteriaType='" + weightingTable + "']:checked");
        }
    });
</script>