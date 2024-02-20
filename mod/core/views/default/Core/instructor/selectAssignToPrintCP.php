<style>
    a.disabledLink {
        color: gray;
    }
</style>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Assignment Grading</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Assessment of CPs</h2>
    </div>
    <blockquote>
        <p>Select the course, then the assignment.</p>
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
<div class="aHrefLabel">
    <a href="#" id="continue" >Continue</a>
</div> 
    
<script type="text/javascript">
    $("#courseCode").change(function() { 
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
    
    $("#continue").click(function() {
        var assignID = $("#assignments").val();
        if (parseInt(assignID) > 0) {
            window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/grading/printCPs/"+assignID;
        }
        else {
            elgg.system_message("Please select your assignment to continue.");
        }
    });
</script>
</div>