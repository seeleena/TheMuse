<?php
$codes = array();
$codes = $vars['courseCodes'];
$assignments = array();
$assignments = $vars['assignments'];
array_unshift($codes, "Select your Course");
$user = elgg_get_logged_in_user_guid();
$userEntity = elgg_get_logged_in_user_entity();
$message  = $_GET['message'];
//system_message($message); 
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
    

</style>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>My Creative Process</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">My Creative Process</h2>
    </div>
    <blockquote >
        <p>
            Welcome, <?php echo $userEntity->username; ?>. 
            Please select your course first, followed by the assignment number in that course, 
            then click on 'Continue' to proceed.
        </p>
    </blockquote>
    <div class="background">
        <table id="myForm">
            <tr>
                <td>
                    <label>
                        Course:
                    </label>                    
                </td>
                <td>
                    <?php
                    echo elgg_view('input/dropdown', array(
                                    'id' => 'courseCode',
                                    'name' => 'courseCode',
                                    'value' => 'courseCode', 
                                    'options' => $codes
                                    ));
                    ?>                    
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Assignment:
                    </label>                    
                </td>
                <td>
                    <?php
                    echo elgg_view('input/dropdown', array(
                                    'id' => 'assignments',
                                    'name' => 'assignments',
                                    'value' => 'assignments', 
                                    'options' => $assignments,
                                    ));
                    ?>              
                    <div class="aHrefLabel">
                        <a href="#" id="continue" >Continue</a>
                    </div>                    
                </td>
            </tr>
        </table>
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
   var userid = "<?php echo $user; ?>";
    $("#continue").click(function() {
        var assignID = $("#assignments").val();
        if (parseInt(assignID) > 0) {
            window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/owner/"/* +userid+ */"?assignID="+assignID;
        }
        else {
            elgg.system_message("Please select your assignment to continue.");
        }
    });
    
</script>
</div>
    </div>