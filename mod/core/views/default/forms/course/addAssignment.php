<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Add Assignment</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add a Task/Assignment</h2>
    </div>
    <style> 
        .elgg-main {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        .myFields small {
            margin: 10px;
        }
        .myFields input[type="text"] {
            width: 100%;
        }
        .myFields input[type="submit"] {
            margin-top: 10px;
        }
        .myFields select {
            width: 100%;
        }
        .myFields label {
            font-weight: bold;
        }
        .myFields h4 {
            font-weight: bold;
        }
        .myFields a {
            text-decoration: none;
            color: #000;
        }
        .myFields a:hover {
            text-decoration: underline;
        }
        .myFields input[type="radio"] {
            margin-right: 5px;
        }
        .myFields input[type="radio"]:checked {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:hover {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:active {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:focus {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:visited {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:link {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:not(:checked) {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:not(:hover) {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:not(:active) {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:not(:focus) {
            background-color: #f9f9f9;
        }
        .myFields input[type="radio"]:not(:visited) {
            background-color: #f9f9f9;
        }
    </style>
    <?php
        include elgg_get_plugins_path()."Core/lib/utilities.php";

        $codes = array();
        $codes = getRunCourseCodes();

        $domainOptions = array("Chemistry", "Computer Science");
        array_unshift($domainOptions, "Choose Domain");

        $cps = array();
        $cps = getCPs();
    ?>
    <div class="myFields small">
        <label>
            Course Code
        </label>
        <br/>
        <?php
            echo elgg_view('input/dropdown', array(
                            'name' => 'courseCode',
                            'value' => 'courseCode',
                            'options' => $codes,
                            ));
        ?>
        <br/><br/>

        <label>
            Assignment Number
        </label>
        <?php
            echo elgg_view('input/text', array('name' => 'number'));
        ?>
        <br/><br/>

        <label>
            Description
        </label>
        <?php
            echo elgg_view('input/text', array('name' => 'description'));
        ?>
        <br/><br/>

        <label>
            Instructions
        </label>
        <?php
            echo elgg_view('input/text', array('name' => 'instructions'));
        ?>
        <br/><br/>

        <label>
            Assignment Weighting
        </label>
        <?php
            echo elgg_view('input/text', array('name' => 'weight'));
        ?>
        <br/><br/>

        <label>
            Domain
        </label><br/>
        <?php
        echo elgg_view('input/dropdown', array(
                        'name' => 'domain',
                        'id' => 'domain',
                        'value' => 'domain',
                        'options' => $domainOptions,
                        ));
        ?>
        <br/><br/>

        <label>
            Question Type
        </label>
        <br/>
        <?php
        echo elgg_view('input/dropdown', array(
                        'name' => 'questionType',
                        'id' => 'questionType',
                        'value' => 'questionType',
                        'options' => array(0 => "No Domain selected")
                        ));
        ?>
        <br/><br/>
        
        <label>
            Creative Pedagogy to be followed
        </label>
        <br/>
            <h4>(Click on the pedagogy for more details.)</h4>
        </br>
        <?php
            foreach($cps as $key => $name) {
                echo "<input type='radio' name='creativePedagogy' id='creativePedagogy' value='$key'><a href='/Muse/Core/grading/creativePedagogy/15?cpID=$key' target='_blank'>$name</a></br>";
            }
        ?>
        <br/>
        <?php
            echo elgg_view('input/submit', array('value'=>'Save Assignment'));
        ?>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            // Attach a change event handler to the #domain element
            jQuery("#domain").change(function() { 
                // Get the selected domain
                var domain = jQuery(this).val();
                // Get the #questionType dropdown
                var questionTypeDropDown = jQuery("#questionType");
                // Empty the dropdown
                questionTypeDropDown.empty();
                // Add a temporary option to the dropdown
                questionTypeDropDown.append(jQuery("<option />").val(0).text("Loading question types..."));
                // Disable the dropdown
                questionTypeDropDown.prop("disabled", true);
                // Make an AJAX request to get the question types for the selected domain
                jQuery.ajax({
                    url: '/Muse/Core/assignment/getQuestionType/' + domain,
                    type: 'GET',
                    success: function(questionTypes) {
                        // Empty the dropdown
                        questionTypeDropDown.empty();
                        // Add a default option to the dropdown
                        questionTypeDropDown.append(jQuery("<option />").val(0).text("Select a Question Type"));
                        // Loop through each question type
                        jQuery.each(questionTypes, function(index) {
                            var questionType = questionTypes[index];
                            var number = Object.keys(questionType)[0];
                            var questionTypeTitle = questionType[number];
                            // Add an option for the question type to the dropdown
                            questionTypeDropDown.append(jQuery("<option />").val(number).text(questionTypeTitle));
                        });
                        // Enable the dropdown
                        questionTypeDropDown.prop("disabled", false);
                    }
                });
            });
        </script>
    </div>
</div>   