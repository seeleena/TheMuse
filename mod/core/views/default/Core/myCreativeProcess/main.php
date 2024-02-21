<?php
$userid = $vars['owner'];
$suggestions = $vars['suggestions'];

//$cpDetails = array();
$cp = new StdClass();
$cp = $vars['cp'];

$cpName = $cp->name;
$cpOverview = $cp->overview;
$stages = array();
$stages = $cp->stages;
$key = new stdClass();



$assignID = $_GET['assignID'];
$_SESSION['currentAssignID'] = $assignID;

$cpID = getCP($assignID);

setUpAssessmentFile($userid, $assignID);

$siteURL = elgg_get_site_url().'_graphics/themuse/info.png';
?>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>The Creative Process Steps</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main"><?php echo $cpName ?></h2>
    </div>
    <blockquote>
        You are encouraged to use the group you have created for your assignment to share your thoughts,
        problems and insights about your assignment or your course. You can do this via Blogs, Bookmarks,
        Discussions, Files, or Pages. You can choose to make your post private to your group or visible by
        all in your class. Click on 'Groups' and select your group from the list shown. Your group screen
        will allow you to add a blog, page, file, etc. You may also post as an individual, from the main page 
        on The Muse.
    </blockquote>
    <blockquote>
        <?php echo $cpOverview ?>
    </blockquote>

<?php if (isset($suggestions)) { ?>
    <div class='bubble'> 
    <div class='rectangle'><div class='couponcode'><h2>Suggested Activities <img src='<?php echo $siteURL?>' width='20px' height='20px' class='imgStyle'/></h2><span class='coupontooltip'>Suggested activities, prioritized</span></div>
    </div>
    <div class='triangle-l'></div>
    <div class='triangle-r'></div><br/><br/>
        <?php 
        if (empty($suggestions)) {
            echo "<div id='nosuggestions'>There are no suggestions available at this time.</div>";
        }
        foreach ($suggestions as $suggestion) { ?>
        <div class='btn-container' style="height: 50px; line-height: 50px; text-align: center;">
            <span style="display: inline-block; vertical-align: middle; line-height: normal;">
                <?php echo "<a href='" . getServerURL() . "Core/myCreativeProcess/activity/$suggestion->aid?assignID=$assignID&stageNum=$stageNum' class='blu-btn'>$suggestion->shortDescription</a>";?>
            </span>
        </div>
        <?php } ?>
    </div>
<?php } ?>
<?php 

$creativeProcess = new stdClass();
$creativeProcess->stages = $stages;
$_SESSION["CreativeProcess"] = $creativeProcess;
foreach($stages as $key) {
    $name = $key->name;
    $desc = $key->desc;
    $stageNum = $key->num;
        echo "<div class='bubble'> 
        <div class='rectangle'><div class='couponcode'><h2>Stage $stageNum: $name <img src='$siteURL' width='20px' height='20px' class='imgStyle'/></h2><span class='coupontooltip'>$desc</span></div>
        </div>
        <div class='triangle-l'></div>
        <div class='triangle-r'></div><br/><br/>";
    
    $activities = array();
    $activities = $key->activities;
    $activity = new stdClass();
    foreach($activities as $activity) {
        $activityDesc = $activity->desc;
        $activityShortDesc = $activity->shortDesc;
        $aID = $activity->num;
        $activity = new stdClass();
        
        echo "<div class='btn-container'>";
        echo "<a href='" . getServerURL() . "Core/myCreativeProcess/activity/$aID?assignID=$assignID&stageNum=$stageNum' class='blu-btn'>$activityShortDesc</a>";
        echo "</div>";
    }
    $key = new stdClass();
    
    //add button for user here: "create my own activity:
    echo "<div class='btn-container'>";
    echo "<a href='" . getServerURL() . "Core/myCreativeProcess/newUserActivity/?aID=$aID&assignID=$assignID&userID=$userid&cpID=$cpID&stageNum=$stageNum' class='green-button'>Create My Own Activity</a>";
    //echo "<input type='button' class='grn-btn addUserActivity' value='Create My Own Activity'/>";
    echo "</div>";
    //add user-added activities here
    $studentCreatedActivities = array();
    $studentCreatedActivities = getStudentCreatedActivities($stageNum, $cpID);
    if(!empty($studentCreatedActivities)) {
        echo "<hr/><div class='activityHeader'>Student Created Activities</div>";
    }
    $studentCreatedActivity = new stdClass();
    foreach($studentCreatedActivities as $studentCreatedActivity) {
        $stuAID = $studentCreatedActivity->aid;
        $desc = $studentCreatedActivity->desc;
        $shortDesc = $studentCreatedActivity->shortDesc;
        $studentCreatedActivity = new stdClass();
        
        echo "<div class='btn-container'>";
        echo "<a href='" . getServerURL() . "Core/myCreativeProcess/studentCreatedActivity/$stuAID?assignID=$assignID' class='blu-btn'>$shortDesc</a>";
        echo "</div>";
    }
    
    echo "</div><br/><br/>";
}
    echo "<div class='bubble'>
        <div class='rectangle'><h2>Final Stage: Upload your solution.</h2></div>
        <div class='triangle-l'></div>
        <div class='triangle-r'></div><br/><br/>";
    echo "<div class='btn-container'>";
    echo "<p>Put together all documents and files that must be submitted as part of your assignment 
        and create a .zip file containing them.</p>";
    echo "<a href='" . getServerURL() . "Core/myCreativeProcess/uploadSolution/$userid?assignID=$assignID' class='blu-btn'>Upload zipped solution</a>";
    echo "</div>";
    echo "</div><br/><br/>";
?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".couponcode h2 img.imgStyle").hover(function() {
            var icon = $(this);
            var tooltip = icon.parent().next();
            tooltip.show();
        }, 
        function() {
            var icon = $(this);
            var tooltip = icon.parent().next();
            tooltip.hide();
        });
    });
</script>
