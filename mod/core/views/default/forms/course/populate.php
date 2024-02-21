<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Populate Course</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add Students to your Course</h2>
    </div>
<?php
include elgg_get_plugins_path()."Core/lib/utilities.php"; 
$codes = array();
$codes = getCourseCodes();

$students = array();
$students = getStudentNameAndID();
?>
<label>
    Course Code
</label><br/>
<?php
echo elgg_view('input/dropdown', array(
                'name' => 'courseCode',
                'value' => 'courseCode',
                'options' => $codes,
                ));
echo "<br/><br/><label>List of Students in The Muse</label><br/><br/>";
echo elgg_view("input/checkboxes",
  array('name'=>'studentList',
        'value'=>'studentList',
        'options'=>$students));
echo "<br/>";
echo elgg_view('input/submit', array('value'=>'Populate Course'));
?>
