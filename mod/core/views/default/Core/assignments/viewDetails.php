<div id="innerAssignmentDetails">
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Details</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Assignment Details</h2>
    </div>
<?php
    $details = $vars['details'];
?>

<div class="elgg-head clearfix">
        <h3 class="elgg-heading-main">Assignment Number</h3>
</div>
    <div class="list background">
<?php
    echo $details->number;
?></div>
<div class="elgg-head clearfix">
        <h3 class="elgg-heading-main">Description</h3>
</div>
    <div class="list background">
<?php
    echo $details->description;
?>
</div>
<div class="elgg-head clearfix">
        <h3 class="elgg-heading-main">Instructions</h3>
</div>
    <div class="list background">
<?php
    echo $details->instructions;
?>
    </div>
<div class="elgg-head clearfix">
        <h3 class="elgg-heading-main">Weight</h3>
</div>
<div class="list background">
<?php
    echo $details->weight;
?>
</div>
</div>
</div>