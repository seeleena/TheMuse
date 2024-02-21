<?php
$toolList = getToolListing();

if (isset($_SESSION['currentAssignID'])) {
  $currentAssignID = $_SESSION['currentAssignID'];
}
?>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>All Tools</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">List of Tools</h2>
    </div>
<table class="elgg-table">
    <tr>
        <th width="30%">Name</th>
        <th>Description</th>
    </tr>
    <?php foreach($toolList as $tool) { ?>
    <tr>
        <td>
            <!--a href="<?php  //echo $tool->url.$currentAssignID; ?>"> <?php  //echo $tool->name; ?> </a-->
            <?php  echo $tool->name; ?>
        </td>
        <td>
            <?php  echo $tool->description; ?>
        </td>
    </tr>
     <?php } ?>
</table>
    </div>