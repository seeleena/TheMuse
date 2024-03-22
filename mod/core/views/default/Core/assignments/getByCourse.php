<div class="assignments-listing">
    <style>
        .assignment {
            background-color: #f2f2f2;
            padding: 10px;
            margin: 10px;
        }
    </style>
    <?php
        $course = $vars['course'];
        $assignments = array();
        $assignments = $vars['assignments'];
    ?>
    <h2>Assignments for : <?php echo $course->code; ?></h2>
    <ul>
        <?php 
        
        if (empty($vars['assignments'])) {
            echo "There is no assignment for this course code";
        }
        else{
            foreach ($vars['assignments'] as $assignment) {
                echo '<div class="assignment">';
                echo '<h3>Course Code: ' . $vars['courseCode'] . '</h3>';
                echo '<p>Title: ' . $assignment['title'] . '</p>';
                echo '<p>Description: ' . $assignment['description'] . '</p>';
                echo '</div>';
        }
    }?>
    </ul>
</div>