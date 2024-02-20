<style>
    a.disabledLink {
        color: gray;
    }
</style>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Assignment Grading</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Assessment</h2>
    </div>
    <blockquote>
        <p>Select the course, then the assignment for assessment. You must then select an Assessment 
        Technique for the Assignment Solution and for Creative Process. If you select the 
        Creative Solution Diagnosis Scale for the Assignment Solution assessment, you must click on
        the link next to the selection to set the Criteria for assessment. After clicking on the button
        to load all assignments, you may click on the link below to "View All Assignments/Tasks".</p>
    </blockquote>
<?php

$codes = array();
$codes = $vars['courseCodes'];
array_unshift($codes, "Select your Course");
?>
    <div class="background">
    <label class='dropdownLabel'>
        Select a Course:
    </label>
<?php
echo elgg_view('input/dropdown', array(
                'id' => 'courseCode',
                'name' => 'courseCode',
                'value' => 'courseCode', 
                'options' => $codes
                ));
?>
    <br/>
    <label class='dropdownLabel'>
        Select an Assignment/Task:
    </label>
<?php
echo elgg_view('input/dropdown', array(
                'id' => 'assignments',
                'name' => 'assignments',
                'value' => 'assignments', 
                'options' => array(0 => "No Course selected")
                ));
?>
    
    <br/><br/>
    <label class='dropdownLabel'>
        Select an Assessment Technique for Assignment/Task Creative Solution <a target='_blank' href='productAssessment/'>(Click for Technique Details)</a>:
    </label>
    <div id="radioAssessmentTechniqueSolution">
    <input type="radio" name="assessmentTechniqueSolution" id="CAT" value="CAT" />Consensual Assessment Technique (CAT)<br/>
    <input type="radio" name="assessmentTechniqueSolution" id="CDGS" value="CDGS" />Creative Solution Diagnosis Scale (CSDS)
     - <a id='csdsCriteriaLink' target='_blank' class="disabledLink">Set CSDS Criteria for this course.</a><br/>
    </div><br/>
    
    <br/><br/>
    <label class='dropdownLabel'>
        Select an Assessment Technique for Assignment/Task Creative Process<a target='_blank' href='productAssessment/'>(Click for Technique Details)</a>:
    </label>
    <div id="radioAssessmentTechniqueProcess">
    <input type="radio" name="assessmentTechniqueProcess" id="CAT" value="CAT" />Consensual Assessment Technique (CAT)<br/>
    <input type="radio" name="assessmentTechniqueProcess" id="CreativityCriteria" value="CreativityCriteria" />Creativity Criteria
     <br/>
    </div><br/>
    
    <input type="button" id="btnLoadGroups" class='elgg-button-action dropdownBtn' value="Load Assignments/Tasks" disabled="disabled"/>
    </div>
    
    <a href="#" id="viewAssignmentDetails">View Assignment Details</a><br />
    <div id="assignmentDetails">
        
    </div>
    <a href="#" id="viewAllGroups">View All Assignments/Tasks</a>
    <div id="projectGroups">
        
    </div>
<script type="text/javascript">
    $("#courseCode").change(function() { 
        $("#assignmentDetails").empty();
        $("#projectGroups").empty();
        var courseCode = $(this).val();
        var assignmentsDropDown = $("#assignments");
        assignmentsDropDown.empty();
        assignmentsDropDown.append($("<option />").val(0).text("Loading assignments..."));
        assignmentsDropDown.prop("disabled", true);
        elgg.get('/Core/assignment/get/' + courseCode, {
            success: function(assignments, success, xhr) {
                var assignmentsDropDown = $("#assignments");
                assignmentsDropDown.empty();
                assignmentsDropDown.append($("<option />").val(0).text("Select an Assignment"));
                $.each(assignments, function(index) {
                    var assignment = $(this)[0];
                    assignmentsDropDown.append($("<option />").val(assignment.ID).text(assignment.number));
                });
                assignmentsDropDown.prop("disabled", false);
            } 
        });
    });
    
    $("#assignments").change(function() {
        var assignmentID = $(this).val();
        var setCriteriaLink = $("#csdsCriteriaLink");
        if (assignmentID === "No Course selected" || assignmentID === "0") {
            disableSetCSDSLink(setCriteriaLink);
        }
        else {
            enableSetCSDSLink(setCriteriaLink, assignmentID);
        }
    });
    
    function enableSetCSDSLink(setCriteriaLink, assignmentID) {
        setCriteriaLink.attr("href", "setCSDScriteria/" + assignmentID); 
        setCriteriaLink.removeClass("disabledLink");
    }
    
    function disableSetCSDSLink(setCriteriaLink) {
        setCriteriaLink.removeAttr("href");
        setCriteriaLink.addClass("disabledLink");
    }
    
    //enable the button only when the radio button is selected
    $("input[name='assessmentTechniqueSolution']").click(function() { 
        //this should check to see as well if the course and assignment are selected
        $("#btnLoadGroups").removeAttr("disabled");
    });
    $("input[name='assessmentTechniqueProcess']").click(function() { 
        //this should check to see as well if the course and assignment are selected
        $("#btnLoadGroups").removeAttr("disabled");
    });
    $("#btnLoadGroups").click(function() {
        $("#assignmentDetails").empty();
        $("#projectGroups").empty();
        elgg.system_message('Loading Assignment Details...');
        var assignID = $("#assignments").val();
        var assessmentTechniqueSolution = $('input[name="assessmentTechniqueSolution"]:checked').val();
        var assessmentTechniqueProcess = $('input[name="assessmentTechniqueProcess"]:checked').val();
        setAssignmentDetails(assignID);
        setProjectGroups(assignID, assessmentTechniqueSolution, assessmentTechniqueProcess);    
        
    });
    $("#viewAssignmentDetails").click(function() {
        $("#innerAssignmentDetails").toggle();
    });
    $("#viewAllGroups").click(function() {
        $("#allGroups").toggle();
    });
    
    var userid = "<?php echo $user; ?>";
     
    function setAssignmentDetails(assignmentID) {
        elgg.get('/Core/assignment/viewDetailsBasic/' + assignmentID, {
            success: function(assignmentDetailsMarkup, success, xhr) {
                $("#assignmentDetails").html(assignmentDetailsMarkup);
            } 
        });
    }
    
    function setProjectGroups(assignmentID, assessmentTechniqueSolution, assessmentTechniqueProcess) {
        //make ajax call here and set div just like setAssignmentDetails()
        elgg.get('/Core/grading/getProjectGroups/' + assignmentID + '/' + assessmentTechniqueSolution + '/' + assessmentTechniqueProcess, {
            success: function(projectGroupsMarkup, success, xhr) {
                $("#projectGroups").html(projectGroupsMarkup);
            } 
        });
    }
</script>
</div>