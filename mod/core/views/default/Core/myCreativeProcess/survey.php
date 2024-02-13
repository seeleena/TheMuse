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
    .assessmentCriteria {
        text-indent: 0%;
        padding: 8px;
    }
    .criteriaHeading {
        font-weight: bold;
        padding: 8px;
    }
    .ratingContainer {
        padding: 8px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo getElggJSURL()?>common/rating.css" />
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/rating.js"></script>

<h1>SURVEY</h1>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Self-ratings</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Student Self-Assessment</h2>
    </div>
    <blockquote>
        <p>Please read each question and select from the ratings which best applies to you. A rating
            of 1 carries the lowest value and a rating of 5 the highest. Please answer all questions.</p>
    </blockquote>
<?php
    // <editor-fold defaultstate="collapsed" desc="icky PHP Code for setting up headings and criteria">

$assignmentID = $vars['assignmentID'];
$allHeadings  = $vars['allHeadings'];
$allCriteria  = $vars['allCriteria'];
$allCMCCriteria  = $vars['cmcCriteria'];
$currentUser   = elgg_get_logged_in_user_entity();
$studentID = $currentUser->guid;

$form_body .= 
"<div id='instructionContents1' class='instructionContents active'>
    <table class='elgg-table'>
        <tr>
            <th width='70%' class='tableHeaderText'>Question</th>
            <th width='30%' class='tableHeaderText'>Rating Response</th>
        </tr>";
foreach ($allCriteria as $key => $value) {
    switch ($key) {
        case "H1":
            $heading = $allHeadings[0];
            $headingTitle = $heading->title;
            $form_body .=  "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 1: $headingTitle </td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            $form_body .= printCSDSRows($value);
            break;
        case "H2":
            $heading = $allHeadings[1];
            $headingTitle = $heading->title;
            $form_body .= "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 2: $headingTitle</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            $form_body .= printCSDSRows($value);
            break;
        case "H3":
            $heading = $allHeadings[2];
            $headingTitle = $heading->title;
            $form_body .= "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 3: $headingTitle</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            $form_body .= printCSDSRows($value);
            break;
        case "H4":
            $heading = $allHeadings[3];
            $headingTitle = $heading->title;
            $form_body .= "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 4: $headingTitle</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            $form_body .= printCSDSRows($value);
            break;
        case "H5":
            $heading = $allHeadings[4];
            $headingTitle = $heading->title;
            $form_body .= "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 5: $headingTitle</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            $form_body .= printCSDSRows($value);
            break;
        case "H6":
            $heading = $allHeadings[5];
            $headingTitle = $heading->title;
            $form_body .= "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 6: $headingTitle</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            $form_body .= printCSDSRows($value);
            break;
        case "H7":
            $heading = $allHeadings[6];
            $headingTitle = $heading->title;
            $form_body .= "<tr>
                <td class='criteriaHeading' data-headingID='$key' data-headingTitle='$heading->title'>SECTION 7: $headingTitle</td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
            $form_body .= printCSDSRows($value);
            break;
        default:
            break;
    }
}

//CMC
$form_body .= 
            "<tr>
                <td class='criteriaHeading' data-headingID='' data-headingTitle=''>SECTION 8: Creative Meta-Cognition (CMC) </td>
                <td class='criteriaHeading checkBoxMiddle'></td>
            </tr>
            ";
foreach ($allCMCCriteria as $criterion) {
    $form_body .= printCMCRow($criterion);
}


$form_body .= "
        <tr>
            <td colspan='2'>
                <input type='submit' id='btnFinishAndSave' value='Finish and Save' class='elgg-button elgg-button-submit' />
            </td>
        </tr>";
$form_body .= "</table></div>";
$form_body .= elgg_view('input/hidden', array('id' => 'studentID', 'name' => 'studentID', 'value' => $studentID));
echo elgg_view('input/form', array(
                                'id' => 'formList',
                                'body' => $form_body,
                                'action' => 'action/myCreativeProcess/saveStudentSurvey',
                                'enctype' => 'multipart/form-data',
));

function printCSDSRows($value) {
    $checkBoxes = "";
    foreach($value as $crit) {
        $criteriaID = $crit->ID;
        $criteriaDesc = $crit->desc;
        $ratingsControl = getRatingsControl("csds", $crit->mapping);
        $checkBoxes .=  
        "<tr data-headerID='$crit->Hid'>
            <td class='assessmentCriteria' class='criteriaDescription'>$criteriaDesc
                <br /><br /><p>$crit->question</p> 
            </td>
            <td class='rating'>
                $ratingsControl
            </td>
        </tr>
        ";
    }
    return $checkBoxes;
}

function printCMCRow($cmcCriterion) {
    $cmcRow = "";
    $ratingsControl = getRatingsControl("cmc", $cmcCriterion->CriteriaID);
    $cmcRow .=  
    "<tr data-headerID='0'>
        <td class='assessmentCriteria' class='criteriaDescription'>
            $cmcCriterion->Criteria - $cmcCriterion->Description
        </td>
        <td class='rating'>
            $ratingsControl
        </td>
    </tr>
    ";
    return $cmcRow;
}

function getRatingsControl($type, $id) {
    //old: <input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'>
    $id = "$type-" . $id . "-rating";
    $ratingsControl = "";
    $ratingsControl .= "<div id='container-$id' class='ratingContainer'>";
    for ($i = 1; $i <= 5; $i++) {
        $ratingsControl .= "<input type='radio' name='$id' class='rating' value='$i' />";
    }
    $ratingsControl .=  "</div>";    
    return $ratingsControl;
}

?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".ratingContainer").rating();
    });
 /*   $(document).ready(function() {
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
    });*/
</script>

<?php
//////////////////////////***************************/////////////////
////This section can be a second page of the survey. Or it can be a section separate in the same table.
////There are 10 questions and there are no criteria IDs or headings.
//echo "<tr>
//                <td class='criteriaHeading' data-headingID='' data-headingTitle=''>SECTION 8: Creative Meta-Cognition (CMC) </td>
//                <td class='criteriaHeading checkBoxMiddle'></td>
//            </tr>
//            ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Self-efficacy/Confidence - Please rate your confidence level on being creative.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Understanding costs and benefits of creativity - Please rate your understanding of weighing the costs and benefits of being creative.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Understanding the time and place for creativity - 
//Please rate your understanding of being creative, only at the relevant time and place. </p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Having clarity of task constraints and expectations - 
//Please rate your general tendency to clarify task constraints and expectations.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Ability to play and explore - Please rate your ability to play and explore an idea that you have had.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Collaborative ability & social expertise / Expressiveness - 
//Please rate your ability to communicate and express yourself in a social context.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Active engagement - Please rate your ability to actively engage in assignments/projects, i.e., your ability to interact with the materials to gain a deeper understanding of the concepts.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Internal motivation - Please rate your level of internal motivation to be creative in your assignments/projects.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>External motivation - Please rate your level of external motivation to be creative in your assignments/projects.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Ability to give critical feedback - Please rate your ability to constructively and critically evaluate your peers’ creative work.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//echo "<tr>
//            <td class='assessmentCriteria' class='criteriaDescription'>
//                <p>Ability to receive critical feedback -Please rate your ability to productively receive evaluation from your peers on your creative work.</p> 
//            </td>
//            <td class='checkBoxMiddle'><input type='checkbox' data-headerID='$crit->Hid' data-criteriaType='creativeSolution' id='$criteriaID'></td>
//        </tr>
//        ";
//////////////////////////*************************///////////////////
//echo "
//        <tr>
//            <td colspan='2'><input type='submit' class='elgg-button elgg-button-submit' id='surveySubmit' value='Finish and Save' /></td>
//        </tr>
//    </table>
//</div>";
?>