<?php
$userid = $vars['owner'];
$user = elgg_get_logged_in_user_guid();
$suggestions = $vars['suggestions'];

//$cpDetails = array();
$cp = new StdClass();
$cp = $vars['cp'];
$cpID = $vars['cpID'];
$cpName = $cp->name;
$cpOverview = $cp->overview;
$stages = array();
$stages = $cp->stages;
$stageNum = $vars['stageNum'];
$key = new stdClass();




$assignID = $_GET['assignID'];
$_SESSION['currentAssignID'] = $assignID;

$cpID = getCP($assignID);

setUpAssessmentFile($user, $assignID);

$siteURL = elgg_get_site_url().'_graphics/themuse/info.png';
?>

<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>The Creative Process Steps</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main"><?php echo $cpName ?></h2>
    </div>
    <style>
        .back-to-top {
            position: fixed;
            bottom: 10px;
            right: 20px;
            display: none;
        }
        .bubble {
            position: relative;
            width: 100%;
            padding: 5px;
            background: #f9f9f9;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 10px;
        }
        .rectangle {
            position: relative;
            background: #f9f9f9;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 15px;
            padding: 10px;
            margin: 10px 0;
        }
        .triangle-l {
            position: absolute;
            top: 10px;
            left: -20px;
            width: 0;
            height: 0;
            border-top: 10px solid transparent;
            border-right: 20px solid #34b4db;
            border-bottom: 10px solid transparent;
        }
        .couponcode-sugg {
            position: relative;
            background: #f9f9f9;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 15px;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }
        .activityHeader {
            font-weight: bold;
            font-size: 1.2em;
            margin: 10px 0;
        }
        .a-items {
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
            padding: 10px 0px;
            margin-left: 15px;
        }
        .c-item {
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
            padding: 10px 0px;
            margin-left: 10px;
        }
    </style>
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
    <div class='bubble' style = "margin-bottom: 50px;"> 
    <a href='<?php echo getServerURL() . "Core/myCreativeProcess/improvementActivities/$cpID?assignID=$assignID&stageNum=$stageNum" ?>' >
    <div class='couponcode-sugg'>
        <h2>Suggested Activities <img src='<?php echo $siteURL?>' width='20px' height='20px' class='imgStyle'/></h2>
    </div></a>

    <div class='triangle-l'></div>
    <div class='triangle-r'></div>
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
        <div class='triangle-r'></div>";
    
    $activities = array();
    $activities = $key->activities;
    $activity = new stdClass();
    foreach($activities as $activity) {
        $activityDesc = $activity->desc;
        $activityShortDesc = $activity->shortDesc;
        $aID = $activity->num;
        $activity = new stdClass();
        
        echo "<div class='btn-container'>";
        echo "<a class='a-items' href='" . getServerURL() . "Core/myCreativeProcess/activity/$aID?assignID=$assignID&stageNum=$stageNum' class='blu-btn'>$activityShortDesc</a>";
        echo "</div>";
    }
    $key = new stdClass();
    
    //add button for user here: "create my own activity:
    echo "<div class='btn-container'>";
    echo "<a class='c-item' href='" . getServerURL() . "Core/myCreativeProcess/newUserActivity/$aID?aID=$aID&assignID=$assignID&userID=$user&cpID=$cpID&stageNum=$stageNum' class='green-button'>Create My Own Activity</a>";
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
        echo "<a class='a-items' href='" . getServerURL() . "Core/myCreativeProcess/studentCreatedActivity/$stuAID?assignID=$assignID' class='blu-btn'>$shortDesc</a>";
        echo "</div>";
    }
    
    echo "</div><br/><br/>";
}
    echo "<div class='bubble'>
        <div class='rectangle'><h2>Final Stage: Upload your solution.</h2></div>
        <div class='triangle-l'></div>
        <div class='triangle-r'></div>";
    echo "<div class='btn-container'>";
    echo "<p>Put together all documents and files that must be submitted as part of your assignment 
        and create a .zip file containing them.</p><br/>";
    echo "<a href='" . getServerURL() . "Core/myCreativeProcess/uploadSolution/$assignID?assignID=$assignID' class='blu-btn'>Upload zipped solution</a><br/>";
    echo "<br/></div>";
    echo "</div><br/>";
?>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(".couponcode h2 img.imgStyle").hover(function() {
            var icon = jQuery(this);
            var tooltip = icon.parent().next();
            tooltip.show();
        }, 
        function() {
            var icon = jQuery(this);
            var tooltip = icon.parent().next();
            tooltip.hide();
        });
    });
</script>
