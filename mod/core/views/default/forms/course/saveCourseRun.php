<div class="elgg-main elgg-body">
    <!-- Breadcrumbs navigation -->
    <ul class="elgg-menu elgg-breadcrumbs">
        <li>Add Course Run</li>
    </ul>
    <!-- Page header -->
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add the Current Running of a Course</h2>
    </div>
    <!-- Page styling -->
    <style>
        .elgg-main {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
    </style>
    <?php
        // Include utilities from the Core plugin
        include elgg_get_plugins_path() . "Core/lib/utilities.php"; 

        // Initialize and populate the course codes array
        $codes = array();
        $codes = getCourseCodes();
    ?>

    <!-- Course code selection -->
    <label>Course Code</label>
    <br/>
    <?php
        echo elgg_view('input/dropdown', array(
            'name' => 'courseCode',
            'value' => 'courseCode',
            'options' => $codes,
        ));
    ?>
    <br/><br/>

    <!-- Current run of the course input -->
    <label>Current Run of Course - [Semester/Year]</label>
    <?php
        echo elgg_view('input/text', array('name' => 'courseRun'));
    ?>
    <br/><br/>

    <!-- Syllabus file upload -->
    <label>Syllabus</label>
    <?php
        echo elgg_view('input/file', array('name' => 'syllabus'));
    ?>
    <br/><br/>

    <!-- Class list file upload -->
    <label>Class List</label>
    <?php
        echo elgg_view('input/file', array('name' => 'classList'));
    ?>
</div>