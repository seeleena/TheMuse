<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>My Group</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Group Creation for Assignments</h2>
    </div>
    <Style>
        .elgg-main {
            background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
        }

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
        .elgg-heading-main{
           font-size: 18px;
           margin-top: 20px;
           margin-bottom: 10px;
        }
        .user-profile {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </Style>
    <div>
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
    <div>
    <div class="elgg-head-clearfix">
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

    $form_body .= elgg_view('input/dropdown', array(
                    'id' => 'assignments',
                    'name' => 'assignments',
                    'value' => 'assignments', 
                    'options' => array(0 => "No Course selected")
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


<div class="elgg-head-clearfix">
    <h4 class="elgg-heading-main">List of Students Available for Forming Groups</h4>
</div>
<div>
    <?php
    // Initialize an array to store user entities
    $userEntities = array();
    // Get the user entities from the passed variables
    $userEntities = $vars['userEntities'];
    // Loop through each user entity
    foreach ($userEntities as $userEntity) {
        // If the user entity is not empty
        if(!empty($userEntity)) {
            // Display the user entity in a div with a class of 'user-profile'
            echo "<div class='user-profile'>";
            echo "<h2>{$userEntity}</h2>";
            echo "</div>";
        }
    }
    ?>
</div>
<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous">
</script>
<script type="text/javascript">
    // Get the assignments dropdown element
    var assignmentsDropDown = jQuery("#assignments");

    // Define a function to get the group name
    function getGroupName(courseCode, assignment, name) {
        return courseCode + " - " + assignment + " - " + name; 
    }

    // Define a function to load assignments based on the course code
    function loadAssignments(courseCode) {
        // Empty the assignments dropdown and display a loading message
        assignmentsDropDown.empty().append(jQuery("<option />").val(0).text("Loading assignments...")).prop("disabled", true);
        // Make an AJAX request to get the assignments
        jQuery.ajax({
            url: '/Muse/Core/assignment/get/' + courseCode,
            type: 'GET',
            dataType: 'json',
            success: function(assignments) {
                // On success, empty the assignments dropdown and add an option for each assignment
                assignmentsDropDown.empty().append(jQuery("<option />").val(0).text("Select an Assignment"));
                jQuery.each(assignments, function(index, assignment) {
                    assignmentsDropDown.append(jQuery("<option />").val(assignment.ID).text(assignment.number));
                });
                // Enable the assignments dropdown
                assignmentsDropDown.prop("disabled", false);
            }
        });
    }
    
    // When the course code changes, load the assignments for the selected course
    jQuery("#courseCode").change(function() {
        var courseCode = jQuery(this).val();
        loadAssignments(courseCode);
    });

    // When the form is submitted, set the name field to the group name
    jQuery("#museGroupCreateForm").submit(function(e) {
        var courseCode = jQuery("#courseCode").val();  
        var assignment = jQuery("#assignments option:selected").text();
        jQuery("#name").val(getGroupName(courseCode, assignment, jQuery("#name").val()));
    });
</script>
</div>