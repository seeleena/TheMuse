<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Add Assignment</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add a Task/Assignment</h2>
    </div>

<?php
include elgg_get_plugins_path()."Core/lib/utilities.php"; 
$codes = array();
$codes = getCourseCodes();


$domainOptions = array();
$domainOptions = getDomain();

$questionTypes = array();
$questionTypes = getQuestionTypes();



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
                'options' => $questionTypes
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
    echo "<input type='radio' name='creativePedagogy' id='creativePedagogy' value='$key'><a href='/elgg/Core/grading/creativePedagogy?cpID=$key' target='_blank'>$name</a></br>";
}
?>
<br/>
<?php
echo elgg_view('input/submit', array('value'=>'Save Assignment'));
?>
<script type="text/javascript">
    $("#domain").change(function() { 
        var domain = $(this).val();
        var questionTypeDropDown = $("#questionType");
        questionTypeDropDown.empty();
        questionTypeDropDown.append($("<option />").val(0).text("Loading question types..."));
        questionTypeDropDown.prop("disabled", true);
        elgg.get('/Core/assignment/getQuestionTypes/' + domain, {
            success: function(questionTypes, success, xhr) {
                var questionTypeDropDown = $("#questionType");
                questionTypeDropDown.empty();
                questionTypeDropDown.append($("<option />").val(0).text("Select a Question Type"));
                $.each(questionTypes, function(index) {
                    var questionType = questionTypes[index];
                    var number = Object.keys(questionType)[0];
                    var questionTypeTitle = questionType[number];
                    questionTypeDropDown.append($("<option />").val(number).text(questionTypeTitle));
                });
                questionTypeDropDown.prop("disabled", false);
            } 
        });
    });
</script>
</div>
</div>   