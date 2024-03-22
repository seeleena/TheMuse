<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>My Group</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Group Creation for Assignments</h2>
    </div>
    <Style>
        .background {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .bullet {
            list-style-type: disc;
            padding-left: 20px;
        }
        .bullet li {
            margin-bottom: 10px;
        }
    </Style>
    <blockquote>
        <ul class="bullet">
            <li>
                Firstly, you are responsible for forming your own groups for completing 
                assignments. Use the "Members" menu (under "More") to contact
                other students to discuss who you would like to form a group with.
            </li>
            <li>
                Secondly, you can use the section below to create a new group, 
                from which you can then invite other students to join.
            </li>
            <li>
                One member for each group should create a group. The other members 
                are added through invitations ONLY.
            </li>
            <li>
                See 'Home' for how to add members to a group.
            </li>
            <li>
                All groups should be closed to members only so that your work on the 
                assignment is private to those in your group.
            </li>
            <li>
                In the next assignment you must choose new group members, with a maximum of 
                1 member being the same as before.
            </li>
        </ul>
    </blockquote>
    <div class="elgg-head clearfix">
        <h4 class="elgg-heading-main">Create a New Group</h4>
    </div>
    <div class="background">
<?php
$codes = array();
$codes = $vars['courseCodes'];
array_unshift($codes, "Choose Course");
$form_body .= elgg_view('input/dropdown', array(
                'id' => 'courseCode',
                'name' => 'courseCode',
                'value' => 'courseCode', 
                'options' => $codes
                ));

$assignments = array();
$assignments = $vars['assignments'];
array_unshift($assignments, "Select an Assignment");
$form_body .= elgg_view('input/dropdown', array(
                'id' => 'assignments',
                'name' => 'assignments',
                'value' => 'assignments', 
                'options' => $assignments,
                ));

$form_body .= "<br /><br /><label for='name'>Enter Group Name:</label>";
$form_body .= elgg_view('input/text', array('id' => 'name', 'name' => 'name'));
$form_body .= elgg_view('input/hidden', array('name' => 'description', 'value' => 'Group formed for completing this assignment.'));
$form_body .= elgg_view('input/hidden', array('name' => 'membership', 'value' => 'private'));
$form_body .= elgg_view('input/submit', array('name' => 'submit', 'value' => 'Create Group'));
echo elgg_view('input/form', array(
                                'id' => 'museGroupCreateForm',
                                'body' => $form_body,
                                'action' => 'action/groups/edit',
                                'enctype' => 'multipart/form-data',
));
?>
        </div>

<!-- <div class="elgg-head clearfix">
    <h4 class="elgg-heading-main">List of Students Available for Forming Groups</h4>
</div> -->

<?php



// $userEntities = array();
// $userEntities = $vars['userEntities'];
// foreach ($userEntities as $userEntity) {
//     if(!empty($userEntity)) {
        
//         echo $userEntity;
//     }
// }

?>
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
    
    $("#museGroupCreateForm").submit(function() {
        var courseCode = $("#courseCode").val();  
        var assignment = $("#assignments option:selected").text();
        $("#name").val(getGroupName(courseCode, assignment, $("#name").val()));
    });
    
    function getGroupName(courseCode, assignment, name) {
        return courseCode + " - " + assignment + " - " + name; 
    }
</script>
</div>