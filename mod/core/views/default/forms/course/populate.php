<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Populate Course</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add Students to your Course</h2>
    </div>
    <style>
        .elgg-main {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        .studentList {
            margin: 10px;
        }
        

    </style>
    <?php
        // Include utilities
        include elgg_get_plugins_path() . "Core/lib/utilities.php"; 

        // Initialize an array to store course codes
        $codes = array();
        // Get the course codes for running courses
        $codes = getRunCourseCodes();

        // Initialize an array to store student names and IDs
        $students = array();
        // Get the student names and IDs
        $students = getStudentNameAndID();
    ?>

    <h3>Running Courses</h3><br/>

    <?php
        // Display a dropdown for selecting a course code
        echo elgg_view('input/dropdown', array(
            'name' => 'courseCode',
            'value' => 'courseCode',
            'options' => $codes,
        ));

        echo "<br/><br/><h3 class='list'>List of Students in The Muse</h3><div class='studentList'>";

        // Display a list of checkboxes for selecting students
        echo elgg_view("input/checkboxes", array(
            'name' => 'studentList',
            'value' => 'studentList',
            'options' => $students
        ));

        echo "</div><br/>";

        // Display a submit button
        echo elgg_view('input/submit', array('value' => 'Populate Course'));
    ?>
</div>
