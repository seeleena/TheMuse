<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Upload Solution</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Upload Assignment Solution</h2>
    </div>
    <blockquote>
        Create a .zip file containing all documents and files required for assessment of your assignment solution.
        Select the .zip file to upload and click 'Submit' to submit your solution. A message will be shown briefly,
        on the top right of your screen on successful upload.
    </blockquote>
<?php
echo elgg_view_form('uploadAssignmentSolution', array('enctype' => 'multipart/form-data'));
?>
</div> 


