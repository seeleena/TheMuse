<?php
$codes = array();
$codes = $vars['courseCodes'];
$assignments = array();
$assignments = $vars['assignments'];
$user = elgg_get_logged_in_user_guid();
$userEntity = elgg_get_logged_in_user_entity();
$message  = $_GET['message'];
//system_message($message); 

if (empty ($codes)) {
    elgg_error_response("You are not enrolled in any courses. Please contact your instructor.");
    $url = elgg_get_site_url() . "Core/student/landing";
    die('<meta http-equiv="refresh" content="0; url=' . $url . '" />');
}
?>

<style>
    #myForm td {
        padding: 5px 5px 5px 5px;
    }
    #courseCode, #assignments {
        width: 200px;
    }
    .aHrefLabel {
        margin-top: 10px;
        
    }
    .background {
        background-color: #f9f9f9;
        padding: 10px;
        border-radius: 5px;
    }
    .form-group{
        margin-bottom: 10px;
    }
    .elgg-main {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
    }
    

</style>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs">
        <li>My Creative Process</li>
    </ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">My Creative Process</h2>
    </div>
    <blockquote>
        <p>Welcome, <?php echo htmlspecialchars($userEntity->username); ?>. 
            Please select your course first, followed by the assignment number in that course, 
            then click on 'Continue' to proceed.</p>
    </blockquote>
    <div class="background">
        <form id="assignmentForm">
            <div class="form-group">
                <label for="courseCode">Course:</label>
                <?php echo elgg_view('input/dropdown', array(
                    'id' => 'courseCode',
                    'name' => 'courseCode',
                    'value' => 'courseCode', 
                    'options' => $codes
                )); ?>
            </div>
            <div class="form-group">
                <label for="assignments">Assignment:</label>
                <?php echo elgg_view('input/dropdown', array(
                    'id' => 'assignments',
                    'name' => 'assignments',
                    'value' => 'assignments', 
                    'options' => array(0 => "No Course selected")
                )); ?>
                <div class="aHrefLabel" >
                   <button> <a href="#" id="continue" >Continue</a> </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#courseCode").change(function() {
            var courseCode = jQuery(this).val();
            var assignmentsDropDown = jQuery("#assignments");
            assignmentsDropDown.empty().append(jQuery("<option />").val(0).text("Loading assignments...")).prop("disabled", true);
            jQuery.ajax({
                url: '/Muse/Core/assignment/get/' + courseCode,
                type: 'GET',
                dataType: 'json',
                success: function(assignments) {
                    assignmentsDropDown.empty().append(jQuery("<option />").val(0).text("Select an Assignment"));
                    jQuery.each(assignments, function(index, assignment) {
                        assignmentsDropDown.append(jQuery("<option />").val(assignment.ID).text(assignment.number));
                    });
                    assignmentsDropDown.prop("disabled", false);
                }
            });
        });

        jQuery("#continue").click(function() {
            var assignID = jQuery("#assignments").val();
            var userid = "<?php echo htmlspecialchars($user); ?>";
            if (parseInt(assignID) > 0) {
                window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/owner/" + assignID + "?assignID=" + assignID;
            } else {
                elgg.system_message("Please select your assignment to continue.");
            }
        });
    });
</script>