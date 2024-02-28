<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Add Course Run</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add the Current Running of a Course</h2>
    </div>
    
<?php
include elgg_get_plugins_path()."Core/lib/utilities.php"; 

$codes = array();
$codes = getCourseCodes();
?>
<label>
    Course Code
</label>
<br/>
<?php
echo elgg_view('input/dropdown', array(
                'name' => 'courseCode',
                'value' => 'x`  x',
                'options' => $codes,
                ));
?>
<br /><br/>
<label>
    Current Run of Course - [Semester/Year]
</label>
<?php
    echo elgg_view('input/text', array('name' => 'courseRun'));
?>
<br/><br/>
<label>
    Syllabus
</label>
<?php
    echo elgg_view('input/file', array('name' => 'syllabus'));
?>
<br /><br/>
<label>
    Class List
</label>
<?php
    echo elgg_view('input/file', array('name' => 'classList'));
?>
<br /><br/>
<?php
echo elgg_view('input/submit', array('value'=>'Save Course Run'));
?>