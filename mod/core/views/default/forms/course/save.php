<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Add Course</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Add a Course</h2>
    </div>
    <style>
        .elgg-form-course-save {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
    </style>
<label>
    Course Code
</label>
<?php
    echo elgg_view('input/text', array('name' => 'code'));
?>
    <br/><br/>
<label>
    Course Title
</label>
<?php
    echo elgg_view('input/text', array('name' => 'title'));
?>
    <br/><br/>
<label>
    Number of Credits
</label>
<?php
    echo elgg_view('input/text', array('name' => 'credits'));
?>
<br/><br/>
<?php
echo elgg_view('input/submit', array('value'=>'Save Course'));
?>