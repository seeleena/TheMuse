<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$allStudentIDs = array();
$allStudentIDs = $vars['allStudentsIDs'];
$assignmentID = $vars['assignID'];
$currentStudentID = $vars['currentStudentID'];
echo "Select Student: <select id='student'>";
echo "  <option value='0'>Select Student</>";
foreach ($allStudentIDs as $studentID) {
    $student = get_user($studentID);
    $selected = ($studentID == $currentStudentID) ? (" selected") : ("");
    echo "<option value='$studentID'$selected>$student->name ($studentID)</>";
}
echo "</select><br />";
if ($currentStudentID !== NULL) {
    echo $currentStudentID."\n";

    $usageClicks = array();
    $usageClicks = getCompletedCP($currentStudentID);

    foreach($usageClicks as $usageClick) {
        $entity = $usageClick->entity;
        $action = $usageClick->action;
        $fullURL= $usageClick->fullURL;
        $helpMe = $usageClick->helpMe;
        $activityID = $usageClick->activityID;
        $lastIID = $usageClick->lastIID;
        $assignID = $usageClick->assignID;
        $core = $usageClick->core;
        if($core == "Core") {
            switch($entity) {
                case "myCreativeProcess": 
                    switch ($action) {
                        case "home" :
                            echo 'Student has entered the My Creative Process. This is the page where course and assignment are selected.';
                            break;
                        case "owner" :
                            if($helpMe) echo 'Help Me button selected. ';
                            else echo "The list of activities (from the CP) are displayed on this page.";
                            break;
                        case "feedbackDashboard":
                            echo "The student has viewed the feedback dashboard.";
                            break;
                        case "survey":
                            echo "The student has clicked on the survey page.";
                            break;
                        case "improvementActivities":
                            echo "The student has clicked on the improvement activities suggested page.";
                            break;
                        case "activity" :
                            $activityDetails = array();
                            $activityDetails = getActivityDetailsV2($activityID);
                            echo "<p>Student has selected an activity: Stage: ". $activityDetails['stage'].". ";
                            echo $activityDetails['shortDesc'] . " - " . $activityDetails['description'] . "</p>";
                            $activityInstructions = array();
                            $activityInstructions = $activityDetails['instructions']; //instructions array
                            $instructionsObject = new stdClass();
                            foreach ($activityInstructions as $instructionsObject) {
                                $instructionID = $instructionsObject->id;
                                $lines = array();
                                $lines = $instructionsObject->lines; //lines array
                                $tools = $instructionsObject->tools;
                                echo "<div class='heading2'>Instruction:$instructionID</div>";
                                $lineObject = new stdClass();
                                foreach ($lines as $lineObject) { 
                                    $lineID = $lineObject->id;
                                    $iDesc = $lineObject->desc;
                                    echo "$lineID: $iDesc</hr>";
                                }
                            }
                            break;
                        default :
                            break;
                    }
                    break;
                case "myTools" : 
                    $groupID = getGroupID($assignmentID, $currentStudentID);
                    switch ($action) {
                        case "owner":
                            echo "Student looked at the list of tools.";
                            break;
                        // write code to get the metrics for each tool, in each case below.
                        // write code to get the usercpengagement: get the number of iterations per tool, per stage, in each case.
                        ?><?php
                        case "collaborativeInput" :
                            echo "<div class='heading2'>Collaborative Input Tool</div>";
                            $ciMetrics = getCollaborativeInputMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>Chat Entries</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $ciMetrics->chatEntries?></td>
                                        <td><?php echo $ciMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                            $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 1);
                            $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 1);
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
                            $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 1);
                            $stageNum = $cpEngagement->stageNum;
                            $iteration = $cpEngagement->iteration;
                            echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                            break;
                        ?><?php
                        case "conceptFan": 
                            echo "<div class='heading2'>Concept Fan Tool</div>";
                            $cfMetrics = getSpecificConceptFanMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>Purpose Ideas</th>
                                    <th>Nodes Created</th>
                                    <th>Leaf Nodes Created</th>
                                    <th>Chat Entries</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $cfMetrics->purposeIdeasCount?></td>
                                        <td><?php echo $cfMetrics->nodesCreatedCount?></td>
                                        <td><?php echo $cfMetrics->leafNodesCreatedCount?></td>
                                        <td><?php echo $cfMetrics->chatEntries?></td>
                                        <td><?php echo $cfMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php                            
                            echo "<div id='conceptFanTree'></div>";
                            //get data from db into script.
                            $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 3);
                            $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 3);
                            $decodedData = json_decode($data, TRUE); //purpose should  be printed. 
                            //error_log("the decoded data:   ". print_r($decodedData));
                            //error_log($data); data is retrieved. There is no tree data from workshop1
                            echo "<link rel='stylesheet' href='http://localhost/elgg_js/jstree/dist/themes/default/style.min.css' />";
                            echo "<script type='text/javascript'>";
                            echo "var conceptFanData = $data;";
                            echo "loadConceptFanTree(conceptFanData);";//added by D.
                            echo "</script>";
                            
                            $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 3);
                            $stageNum = $cpEngagement->stageNum;
                            $iteration = $cpEngagement->iteration;
                            echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                            break;
                        ?><?php
                        case "listAndApply": 
                            echo "<div class='heading2'>List and Apply Tool</div>";
                            $laaMetrics = getSpecificListAndApplyMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>List Answer Count</th>
                                    <th>POs Edited Count</th>
                                    <th>Chat Entries</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $laaMetrics->listAnswerCount?></td>
                                        <td><?php echo $laaMetrics->POsEditedCount?></td>
                                        <td><?php echo $laaMetrics->chatEntries?></td>
                                        <td><?php echo $laaMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php                                 
                            $allData = array();
                            $pos = array();
                            $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 5);
                            $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 5);
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
                            
                            $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 5);
                            $stageNum = $cpEngagement->stageNum;
                            $iteration = $cpEngagement->iteration;
                            echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                            
                            break;
                        ?><?php
                        case "choice": 
                            echo "<div class='heading2'>Choice Tool</div>";
                            $choiceMetrics = getSpecificChoiceMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>Clear Weaker Count</th>
                                    <th>POs Reset Count</th>
                                    <th>Movements Count</th>
                                    <th>Chat Entries Count</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $choiceMetrics->clearWeakerCount?></td>
                                        <td><?php echo $choiceMetrics->resetPOsCount?></td>
                                        <td><?php echo $choiceMetrics->movementsCount?></td>
                                        <td><?php echo $choiceMetrics->chatEntriesCount?></td>
                                        <td><?php echo $choiceMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php   
                            $allData = array();
                            $strong = array();
                            $weak = array();
                            $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 6);
                            $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 6);
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
                            
                            $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 6);
                            $stageNum = $cpEngagement->stageNum;
                            $iteration = $cpEngagement->iteration;
                            echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                            
                            break;
                        ?><?php
                        case "inAndOut": //In and Out
                             echo "<div class='heading2'>In and Out Tool</div>";
                             $inAndOutMetrics = getSpecificInAndOutMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>Reset POs Clicks Count</th>
                                    <th>Clear Out Clicks Count</th>
                                    <th>Movements Count</th>
                                    <th>Added Characteristics Count</th>
                                    <th>Chat Entries Count</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $inAndOutMetrics->resetPOsClicksCount?></td>
                                        <td><?php echo $inAndOutMetrics->clearOutClicksCount?></td>
                                        <td><?php echo $inAndOutMetrics->movementsCount?></td>
                                        <td><?php echo $inAndOutMetrics->addedCharacteristicsCount?></td>
                                        <td><?php echo $inAndOutMetrics->chatEntriesCount?></td>
                                        <td><?php echo $inAndOutMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php  
                             $allData = array();
                             $first = array();
                             $second = array();
                             $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 7);
                             $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 7);
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
                             
                             $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 7);
                             $stageNum = $cpEngagement->stageNum;
                             $iteration = $cpEngagement->iteration;
                             echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                            
                             break;
                        ?><?php
                        case "report":
                             echo "<div class='heading2'>Tool: $action</div>";
                            $reportMetrics = getSpecificReportMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>Word Count</th>
                                    <th>Chat Entries Count</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $reportMetrics->wordCount?></td>
                                        <td><?php echo $reportMetrics->chatEntriesCount?></td>
                                        <td><?php echo $reportMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php   
                             $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 8);
                             $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 8);
                             $reportURL = $data;
                             $firePadID = "firePad_" . $currentStudentID . "_" . $groupID . "_" . $assignID . "_" . $activityID . "_" . $lastIID . "_" . getRandomString(5);
                             ?>
                                <div id="<?php echo $firePadID?>"></div>
                                <script>
                                    var <?php echo $firePadID?> = "<?php echo $firePadID?>";
                                    $(document).ready(function() {
                                        var firepadRef = new Firebase('<?php echo $reportURL ?>');
                                        var codeMirror = CodeMirror(document.getElementById(<?php echo $firePadID?>), { lineWrapping: true, readOnly: true });
                                        firePadID = Firepad.fromCodeMirror(firepadRef, codeMirror,
                                            { richTextShortcuts: true, richTextToolbar: true, defaultText: 'Create your report here.' });                                              
                                    });
                                </script>
                             <?php
                             $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 8);
                             $stageNum = $cpEngagement->stageNum;
                             $iteration = $cpEngagement->iteration;
                             echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                             break;
                        ?><?php
                        case "roundRobin": 
                             echo "<div class='heading2'>$toolName</div>";
                            $roundRobinMetrics = getSpecificRoundRobinMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>Views Entered Count</th>
                                    <th>Chat Entries Count</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $roundRobinMetrics->viewsEnteredCount?></td>
                                        <td><?php echo $roundRobinMetrics->chatEntriesCount?></td>
                                        <td><?php echo $roundRobinMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php  
                             $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 9);
                             $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 9);
                             $decodedData = json_decode($data, TRUE);
                             echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>View</th></tr>";
                             foreach ($decodedData as $obj) {
                                 echo "<tr><td>".$obj['user']."</td>";
                                 echo "<td>".$obj['view']."</td></tr>";
                             }
                             echo "</table>";
                             
                             $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 9);
                             $stageNum = $cpEngagement->stageNum;
                             $iteration = $cpEngagement->iteration;
                             echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                            
                             break;
                        case "list":
                            echo "<div class='heading2'>$toolName</div>";
                            $listMetrics = getSpecificListMetrics($activityID, $assignID, $currentStudentID, $lastIID);
                            ?>
                            <h4>Metrics:</h4>
                            <table class="elgg-table">
                                <thead>
                                    <th>List Items Added Count</th>
                                    <th>Chat Entries Count</th>
                                    <th>Time on Page (HH:MM:SS)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $listMetrics->listItemsAddedCount?></td>
                                        <td><?php echo $listMetrics->chatEntriesCount?></td>
                                        <td><?php echo $listMetrics->timeOnPage?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php  
                             $data = getGroupSolutionCreativeProcessByTool($groupID, $assignID, $activityID, $lastIID, 10);
                             $chatData = getGroupSolutionCreativeProcessChatData($groupID, $assignID, $activityID, $lastIID, 10);
                             $decodedData = json_decode($data, TRUE);
                             //print_r($decodedData);
                             
                             echo "<h4>User Response: </h4>";
                             echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>Listed Item</th></tr>";
                             foreach ($decodedData as $arr) {
                                 $userName = $arr['user'];
                                 $listItem = $arr['listItem'];
                                 echo "<tr><td>$userName</td>";
                                 echo "<td>$listItem</td></tr>";
                             }
                             echo "</table><br/>";
                             
                             $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 10);
                             $stageNum = $cpEngagement->stageNum;
                             $iteration = $cpEngagement->iteration;
                             echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                             break;
                        case "RandomWordGenerator":
                            echo "<div class='heading2'>$toolName</div>";
                            
                            //nobody used this tool.
                             $cpEngagement = getUserCPEngagement($assignmentID, $currentStudentID, 12);
                             $stageNum = $cpEngagement->stageNum;
                             $iteration = $cpEngagement->iteration;
                             echo "<p>The User CP Engagement for Stage Number: $stageNum is Iteration: $iteration.</p>";
                            
                             break;
                        default:
                             break;
                        }
                        echo "<h4>The chat data for the $action:</h4>";
                         $decodedChatData = json_decode($chatData, TRUE);
                         echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>Message</th></tr>";
                         foreach ($decodedChatData as $obj) {
                             echo "<tr><td>".$obj['user']."</td>";
                             echo "<td>".$obj['message']."</td></tr>";
                         }
                         echo "</table><br/>";

                    break;
                case "assignment":
                    //nothing important here. 
                    break;
                case "studentLanding":
                    echo "The student is on the studentLanding home page.";
                    break;
                case "instructorLanding":
                    echo "The instructorLanding";
                    break;
                case "student":
                    //action is landing..
                    //same as entity= studentLanding
                    break;
                case "course":
                    //nothing important here. Done by the instructor.
                    break;
                default :
                    break;
            }

        }
        elseif ($core == "root") {

            switch ($entity) {
                case "activity":
                    echo "<p>The user has clicked on an activity. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "groups":
                    echo "<p>The user has clicked on groups. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "members":
                    echo "<p>The user has clicked on members. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "bookmarks":
                    echo "<p>The user has clicked on bookmarks. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "blog":
                    echo "<p>The user has clicked on blog. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "file":
                    echo "<p>The user has clicked on file. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "pages":
                    echo "<p>The user has clicked on pages. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "thewire":
                    echo "<p>The user has clicked on the wire. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "friends":
                    echo "<p>The user has clicked on friends. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "profile":
                    echo "<p>The user has clicked on profile. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "export":
                    echo "<p>The user has clicked on export. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "avatar":
                    echo "<p>The user has clicked on avatar. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "discussion":
                    echo "<p>The user has clicked on discussion. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "search":
                    echo "<p>The user has clicked on search. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                case "messages":
                    echo "<p>The user has clicked on messages. ";
                    echo "The recorded action is: $action. ";
                    echo "The fullURL is: <a href='".$fullURL."'>$fullURL</a></p>";
                    break;
                default:
                    break;
            }

        }
    }
}

/*function getData($currentStudentID, $activityID, $toolID) {
    $groupID = getGroupID($currentStudentID, $activityID);
    $data = getGroupSolutionCreativeProcessByTool($groupID, $assignmentID, $activityID, $instructionID, $toolID);
    return $data;
}

*/
?>
<style>
    
    .firepad {
      width: 700px !important;
      height: 450px !important;
    }

    /* Note: CodeMirror applies its own styles which can be customized in the same way.
       To apply a background to the entire editor, we need to also apply it to CodeMirror. */
    .CodeMirror {
      background-color: lightgray !important;
    }  
</style>
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
<!-- Firebase -->
<script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>

<!-- CodeMirror -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.css" />

<!-- Firepad -->
<link rel="stylesheet" href="https://cdn.firebase.com/libs/firepad/1.1.1/firepad.css" />
<script src="https://cdn.firebase.com/libs/firepad/1.1.1/firepad.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#student").change(function() {
            if ($("#student").val() > 0) {
                window.location.search = "?currentStudentID=" + $("#student").val();
            }
        });
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
