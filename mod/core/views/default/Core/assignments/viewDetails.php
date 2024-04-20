<div id="innerAssignmentDetails">
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Details</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Assignment Details</h2>
    </div>
<?php
    $details = $vars['details'];
    $course = $vars['course'];
?>
<style>
    .elgg-main {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
    }
    .background {
        background-color: #f2f2f2;
        padding: 10px;
        margin: 10px;
    }
    .list {
        list-style-type: none; 
    }
    .elgg-head {
        padding: 5px; 
        margin: 5px; 
    }
</style>

<!-- Display the assignment number -->
<div class="elgg-head clearfix">
    <h3 class="elgg-heading-main">Assignment Number</h3>
</div>
<div class="list background">
    <?php
        // Echo the assignment number
        echo $details->number;
    ?>
</div>

<!-- Display the course code -->
<?php
    // Echo the course code
    echo $course->code;
?>

<!-- Display the course ID -->
<div class="elgg-head clearfix">
    <h3 class="elgg-heading-main">Course ID</h3>
</div>
<div class="list background">
    <?php
        // Echo the course ID
        echo $details->courseRunID;
    ?>
</div>

<!-- Display the description -->
<div class="elgg-head clearfix">
    <h3 class="elgg-heading-main">Description</h3>
</div>
<div class="list background">
    <?php
        // Echo the description
        echo $details->description;
    ?>
</div>

<!-- Display the instructions -->
<div class="elgg-head clearfix">
    <h3 class="elgg-heading-main">Instructions</h3>
</div>
<div class="list background">
    <?php
        // Echo the instructions
        echo $details->instructions;
    ?>
</div>

<!-- Display the weight -->
<div class="elgg-head clearfix">
    <h3 class="elgg-heading-main">Weight</h3>
</div>
<div class="list background">
    <?php
        // Echo the weight
        echo $details->weight;
    ?>
</div>