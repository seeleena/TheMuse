<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Add Assignment</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add a Task/Assignment</h2>
    </div>
<style> 
    .myFields {
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
    jQuery("#domain").change(function() { 
        var domain = jQuery(this).val();
        var questionTypeDropDown = jQuery("#questionType");
        questionTypeDropDown.empty();
        questionTypeDropDown.append(jQuery("<option />").val(0).text("Loading question types..."));
        questionTypeDropDown.prop("disabled", true);
        jQuery.ajax({
            url: '/Muse/Core/assignment/getQuestionType/' + domain,
            type: 'GET',
            success: function(questionTypes) {
                questionTypeDropDown.empty();
                questionTypeDropDown.append(jQuery("<option />").val(0).text("Select a Question Type"));
                jQuery.each(questionTypes, function(index) {
                    var questionType = questionTypes[index];
                    var number = Object.keys(questionType)[0];
                    var questionTypeTitle = questionType[number];
                    questionTypeDropDown.append(jQuery("<option />").val(number).text(questionTypeTitle));
                });
                questionTypeDropDown.prop("disabled", false);
            }
        });
    });
</script>
</div>
</div>   