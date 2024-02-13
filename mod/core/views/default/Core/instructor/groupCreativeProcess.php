<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Group Creative Process</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Assessment of Creative Process</h2>
    </div>
    <blockquote>
        <p>This page presents all data on the Creative Process for a group. It follows the Creativity
        Pedagogy and has data on each tool within each activity. This data can give an idea of how students
        interacted with each other, with the tool and what responses they entered for each activity.</p>
        <p>Students may have uploaded files, communicated via The Wire, created Pages, Blogs and Bookmarks. </p>
    </blockquote>
    
<?php
$groupID = $vars['groupID'];
$assignmentID = $vars['assignmentID'];

$groupCreativeProcess = array();
$groupCreativeProcess = getGroupSolutionCreativeProcess($groupID, $assignmentID);//test this function
//print_r($groupCreativeProcess);


$cp = new StdClass();
$cp = getCPDetails($assignmentID);
$cpName = $cp->name;
//$cpOverview = $cp->overview;
$stages = array();
$stages = $cp->stages;
$key = new stdClass();
$aInstructions = array();
$aInstructions = getActivityInstructions();
//print_r($aInstructions);
echo "<div class='heading1'>The Creative Process used: $cpName - <a href='/elgg/Core/grading/creativePedagogy/$assignmentID' target='_blank'>View Details.</a></div><hr/>";

foreach($stages as $key) {
    $name = $key->name;
    $desc = $key->desc;
    $stageNum = $key->num;
    echo "<div class='heading1'>Stage $stageNum: $name</div>";
    $activities = array();
    $activities = $key->activities;
    $activity = new stdClass();
    foreach($activities as $activity) {
        $activityDesc = $activity->desc;
        $activityShortDesc = $activity->shortDesc;
        $aID = $activity->num;
        $activity = new stdClass();
        echo "<div class='heading2'>Activity: $activityShortDesc</div>";
        $instructions = array();
        $instructions = $aInstructions[$aID];
        //error_log("The aID is: $aID");
        foreach ($instructions as $iID) {
            $cpInstruction = $groupCreativeProcess[$iID];
            echo "<div class='background'><div class='heading2'>Instruction:</div>";
            $instruction = getInstruction($iID);
            echo "$instruction";
            //error_log("The TOP iID is: $iID");
            if(!isset($cpInstruction)){
                echo "<br /><br /><h4>No User Response</h4>";
            }
            else {
                $creativeProcessByInstruction = new stdClass();
                foreach ($cpInstruction as $creativeProcessByInstruction) {
                    //print_r($creativeProcessByInstruction);
                    $data = $creativeProcessByInstruction->data;
                    $chatData = $creativeProcessByInstruction->chatdata;
                    $toolID = $creativeProcessByInstruction->toolID;
                    $instructionID = $creativeProcessByInstruction->instructionID;
                    $toolName = getToolName($toolID);
                    //error_log("the instructionid is: ".$instructionID);
                    //error_log("the toolid is: ".$toolID);
                    
                    switch ($toolID) {
                        case "1": //Collaborative Input
                            echo "<div class='heading2'>Collaborative Input Tool</div>";
                            $decodedData = json_decode($data, TRUE);
                            foreach ($decodedData as $groupResponses) {
                                if(is_array($groupResponses)) {
                                    foreach ($groupResponses as $obj) {
                                        $userResponsesArr = $obj['userResponses'];
                                        $citID = $obj['citID'];
                                        $citInstruction = getCitInstruction($citID);
                                        echo "<h4>Tool output: </h4>";
                                        echo "$citInstruction";
                                        echo "<br /><h4>User Response: </h4>";
                                        echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>Answer</th></tr>";
                                        foreach ($userResponsesArr as $response) {
                                            echo "<tr><td>".$response['user']."</td>";
                                            echo "<td>".$response['answer']."</td></tr>";
                                        }
                                        echo "</table><br/>";
                                    }
                                }
                            }
                            break;
                        case "3": //Concept Fan
                            echo "<div class='heading2'>Concept Fan Tool</div>";
                            echo "<div id='conceptFanTree'></div>";
                            //get data from db into script.
                            echo "<link rel='stylesheet' href='http://localhost/elgg_js/jstree/dist/themes/default/style.min.css' />";
                            echo "<script type='text/javascript'>";
                            echo "var conceptFanData = $data;";
                            echo "</script>";

                            break;
                        case "5": //List and Apply
                            echo "<div class='heading2'>List and Apply Tool</div>";
                            $allData = array();
                            $pos = array();
                            $allData = json_decode($data, TRUE);
                            $pos = $allData['allPOs'];
                            $listItems = $allData['allListItems'];
                            echo "<h4>Tool output: </h4>";
                            
                            echo "<br /><h4>User Response: </h4>";
                            echo "<table class='elgg-table'><tr><th>Listed Items</th></tr>";
                            foreach($listItems as $li) {
                                echo "<tr><td>".$li."</td></tr>";
                            }
                            echo "</table><br/>";
                            echo "<h4>User Response: List of Possibilities and adjustments:</h4>";
                            $po = array();
                            echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>View</th></tr>";
                            foreach($pos as $po) {
                                echo "<tr><td>".$po['id']."</td>";
                                echo "<td>".$po['text']."</td></tr>";
                            }
                            echo "</table><br/>";

                            break;
                        case "6": //Choice
                            echo "<div class='heading2'>Choice Tool</div>";
                            $allData = array();
                            $strong = array();
                            $weak = array();
                            $allData = json_decode($data, TRUE);
                            $strong = $allData['strong'];
                            $weak = $allData['weak'];
                            echo "<h4>Tool output: </h4>";
                            echo "$citInstruction";
                            echo "<br /><h4>User Response: </h4>";
                            echo "<br /><h4>POs selected as 'Strong': </h4>";
                            echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>View</th></tr>";
                            foreach($strong as $str) {
                                echo "<tr><td>".$str['id']."</td>";
                                echo "<td>".$str['text']."</td></tr>";
                            }
                            echo "</table><br/>";
                            echo "<br /><h4>POs selected as 'Weak': </h4>";
                            echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>View</th></tr>";
                            foreach($weak as $wk) {
                                echo "<tr><td>".$wk['id']."</td>";
                                echo "<td>".$wk['text']."</td></tr>";
                            }
                            echo "</table><br/>";
                            echo "Choice Tool";
                            break;
                        case "7": //In and Out
                            echo "<div class='heading2'>In and Out Tool</div>";
                            $allData = array();
                            $first = array();
                            $second = array();
                            $allData = json_decode($data, TRUE);
                            $first = $allData['listItemsData'];
                            $second = $allData['possibilitiesData'];
                            echo "<table class='elgg-table'><tr><th width='20%'>User</th><th>Listed Item</th></tr>";
                            foreach($first as $fst) {
                                echo "<tr><td>".$fst['user']."</td>";
                                echo "<td>".$fst['listItem']."</td></tr>";
                            }
                            echo "</table><br/>";
                            $strong = array();
                            $weak = array();
                            $strong = $second['strong'];
                            $weak = $second['weak'];
                            echo "<br /><h4>POs selected as 'Strong': </h4>";
                            echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>PO chosen as 'Strong'</th></tr>";
                            foreach($strong as $str) {
                                echo "<tr><td>".$str['id']."</td>";
                                echo "<td>".$str['text']."</td></tr>";
                            }
                            echo "</table><br/>";
                            echo "<br /><h4>POs selected as 'Weak': </h4>";
                            echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>PO chosen as 'Weak'</th></tr>";
                            foreach($weak as $wk) {
                                echo "<tr><td>".$wk['id']."</td>";
                                echo "<td>".$wk['text']."</td></tr>";
                            }
                            echo "</table><br/>";
                            break;
                        case "8": //Report
                            echo "<div class='heading2'>$toolName</div>";
                            $data = "http://".$data;
                            echo "<a href='$data' >Select to View Report</a> <br />";
                            break;
                        case "9": //Round Robin
                            echo "<div class='heading2'>$toolName</div>";
                            $decodedData = json_decode($data, TRUE);
                            echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>View</th></tr>";
                            foreach ($decodedData as $obj) {
                                echo "<tr><td>".$obj['user']."</td>";
                                echo "<td>".$obj['view']."</td></tr>";
                            }
                            echo "</table>";
                            break;
                        case "10": //List tool
                            $decodedData = json_decode($data, TRUE);
                            //print_r($decodedData);
                            echo "<div class='heading2'>$toolName</div>";
                            echo "<h4>User Response: </h4>";
                            echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>Listed Item</th></tr>";
                            foreach ($decodedData as $arr) {
                                $userName = $arr['user'];
                                $listItem = $arr['listItem'];
                                echo "<tr><td>$userName</td>";
                                echo "<td>$listItem</td></tr>";
                            }
                            echo "</table><br/>";
                            break;
                        default://report?
                            break;
                    }
                    echo "<h4>The chat data for the $toolName:</h4>";
                    $decodedChatData = json_decode($chatData, TRUE);
                    echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>Message</th></tr>";
                    foreach ($decodedChatData as $obj) {
                        echo "<tr><td>".$obj['user']."</td>";
                        echo "<td>".$obj['message']."</td></tr>";
                    }
                    echo "</table><br/>";
               }
            }
            echo "<h4>Social Network Artefacts Created in this Instruction:</h4>";
            echo "<table class='elgg-table'><tr><th width='30%'>Artefact</th><th>Click to View</th><th width='30%'>Author</th></tr>";
            $artefact = new stdClass();
            $artefacts = array();
            $artefacts = getSocialArtefacts($iID, $groupID, $assignmentID);
            foreach ($artefacts as $artefact) {
                echo "<tr><td>$artefact->type</td>";
                echo "<td><a target='_blank' href='$artefact->url'>View the artefact.</a><br/></td>";
                $student = getStudent($artefact->user);
                echo "<td>$student->name</td></tr>";
            }
            echo "</table><br/>";
            echo "</div>";
          
        }
        //print_r($instructions);
    }
    $key = new stdClass();
    echo "<br /><hr/>";
}


?>
</div>
<script type='text/javascript'>
//    var jq19 = jQuery.noConflict(true);
    $ = jQuery.noConflict(true);
//    var y;
//    var tempjq;
//    var oldjq;
//    oldjq = $;
//    $ = jq19;
</script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.9.0.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>	
<script type="text/javascript" src="http://localhost/elgg_js/jstree/dist/jstree.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        if($( "#conceptFanTree" ).length) {
            updateConceptFanTree(conceptFanData.conceptFanTreeData);
            $( "#conceptFanTree" ).show();
        }
    });
    
    function updateConceptFanTree(newData) {
//        oldjq = $;
//        $ = jq19;
        $("#conceptFanTree").jstree('destroy');
        loadConceptFanTree(newData);
//        $ = oldjq;
    }
        
    function loadConceptFanTree(conceptFanData) {
            $("#conceptFanTree")
                .on('rename_node.jstree', function(event, data) {
                    
                    var dataToShare = $("#conceptFanTree").jstree(true).get_json('#', { 'flat': false });
                 })
                .on('activate_node.jstree', function(event, data) {
                    currentNode = data.node;
                    
                })
                .jstree(
                { 
                    'core' : 
                    {
                        'data' : conceptFanData,
                        'check_callback' : true
                    },
                    'plugins' : 
                    [
                        "contextmenu"
                    ]
                }
            );            
        }
</script>
