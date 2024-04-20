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
    <style> 
        .elgg-main{
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
        }
        .elgg-table th {
            padding: 5px;
            text-align: left;
        }
        .elgg-table td {
            padding: 5px;
        }
        .header {
            font-weight: bold;
            color: blue;
        }
        .items {
            
        }
    </style>
<table class="elgg-table">
    <tr>
        <th class='header' >Name</th>
        <th class='header' >Description</th>
    </tr>
    <?php foreach($toolList as $tool) { ?>
    <tr>
        <td class='items'>
            <!--a href="<?php  //echo $tool->url.$currentAssignID; ?>"> <?php  //echo $tool->name; ?> </a-->
            <?php  echo $tool->name; ?>
        </td>
        <td class='items'>
            <?php  echo $tool->description; ?>
        </td>
    </tr>
    <?php } ?>
</table>
</div>