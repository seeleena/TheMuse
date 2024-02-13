<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Activity Details</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Activity Description</h2>
    </div>
<?php

$instructions = $vars['instructions'];
$tools = $vars['tools'];

echo "<blockquote><p>";
echo $vars['description'];
echo "</p></blockquote>";

$assignID = $_GET['assignID'];
$studentCreatedAID = $vars['studentCreatedAID'];
$i =0;
$siteURL = elgg_get_site_url().'_graphics/themuse/pensive.jpg';
foreach ($instructions as $instruction) {
    $i++;
    echo "<div class='bubble'>
        <div class='rectangle'><div class='couponcode'><h2><div class='myAlignLeft'>Instruction $i: <img src='$siteURL' width='30px' height='30px' class='imgStyle'/></div></h2></div>
        </div>
        <div class='triangle-l'></div>
        <div class='triangle-r'></div><br/><br/>";
    echo "<div><ul class='bullet mytext'>";
    echo "$instruction";
    echo "</ul></div>";
    $tool = new StdClass();
    foreach ($tools as $tool) {
        $toolName = $tool->name;
        $toolURL = $tool->url;
        echo "<div class='btn-container'>";
        if(strpos($toolURL, "Core")) {
            echo "<a href='$toolURL$assignID/?activityID=$studentCreatedAID&instructionID=0' class='blu-btn'>$toolName</a>";
        }
        else {
            echo "<a href=$toolURL class='blu-btn'>$toolName</a>";
        }
        echo "</div>";
        //echo " </br> $toolDesc </br>  </br>";
    }
    echo "</div><br/><br/>";
}
?>
</div>