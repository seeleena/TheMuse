<!-- TimeMe -->
<script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>  
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Concept Fan Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Concept Fan</h2>
    </div>
    <blockquote>
        <p>
            This tool will guide you in creating possible solutions (POs) for your assignment. 
            In later tools, you will develop these POs and then eventually choose the best PO to implement as your solution.
        </p><p>
            First, enter the purpose of your thinking in the box below. Click "Add Purpose" to continue.
            Scroll down to see the Concept Fan tree.
        </p>
    </blockquote>
<?php
$assignmentID  = $vars['assignmentID'];
$activityID    = $vars['activityID'];
$stageNum      = $_GET['stageNum'];
$instructionID = $vars['instructionID'];
$groupID       = $vars['groupID'];
$groupMembers  = $vars['groupMembers'];
$nodeServer    = $vars['nodeServer'];
$currentUser   = elgg_get_logged_in_user_entity();
$studentELGGID = $currentUser->guid;
$toolID        = $vars['toolID'];
$sessionKey    = $vars['sessionKey'];

$_SESSION['groupID'] = $groupID;
$_SESSION['instructionID'] = $instructionID;
$_SESSION['assignmentID'] = $assignmentID;
$_SESSION['activityID'] = $activityID;

$conceptFanQuestions = array();
$conceptFanQuestions[0] = "What is the purpose of your thinking with respect to your assignment?";
$conceptFanQuestions[1] = "Give at least one broad concept that would help you achieve the purpose you listed.";
$conceptFanQuestions[2] = "Give at least one practical way or possible solution for implementing the broad concept that is selected.";

?>
<style>
    #conceptFanTree {
        float: left;
    }
    #conceptFanContainer {
        width: 100%;
        float: left;
        padding-top: 50px;
    }
    #conceptFanContainer div.border{
        border: 1px solid black;
        min-height: 50px;
        height: 500px;
        overflow: auto;
    }
    #chatContainer div.border {
        border: 1px solid black;
        min-height: 50px;
        overflow: auto;
    }
    #chat {
        height: 273px;
        overflow: auto;
    }
    #chatContainer {
        height: 200px;
        width: 38%;
        float: right;
    }
    #purposeContainer {
        overflow: auto;
    }
    #purposeBox {
        border: 1px solid black;
        height: 100px;
        overflow: auto;
    }
    #purpose {

    }
    #purposes {
        border: 1px solid black;
        padding: 10px;
        height: 300px;
        overflow: auto;
    }
    #addedPurposesContainer {
        width: 60%;
        float: left;
    }
    #formFinishContainer {
        width: 100%;
        float: left;
    }
    #leftBoxContainer {
        float: left;
        width: 45%;
    }
    
    #rightBoxContainer {
        float: right;
        width: 45%;
    }
    input[type="submit"] {
        width: auto;
    }
    .explanation, h3, hr {
        float: left;
    }
    .conceptFanFields {
        display: none;
    }
    .conceptFanFields legend {
        font-weight: bold;
    }
    #purposeFields {
        display: block;
    }
    #solutionFieldsTitle {
        display: none;
    }
    #btnFinishAndSave {}
    .jstree-default a { 
        white-space:normal !important; 
        height: auto; 
    }
    .jstree-anchor {
        height: auto !important;
    }
    .jstree-default li > ins { 
        vertical-align:top; 
    }
    .jstree-leaf {
        height: auto;
    }
    .jstree-leaf a{
        height: auto !important;
    }
    
</style>
<link rel="stylesheet" href="<?php echo getElggJSURL()?>jstree/dist/themes/default/style.min.css" />

<div id="purposeContainer" >
    <fieldset class="conceptFanFields" id="purposeFields">
        <h4>What is the purpose of your thinking with respect to your assignment?</h4>
        <textarea id="purpose" class="myTextArea"></textarea>
        <input class="elgg-button" type="button" value="Add Purpose" id="btnAddPurpose" />
    </fieldset>
</div>
<div id="addedPurposesContainer">
    <h4>Group Members Ideas on Purpose</h4>
    <div id="purposes" class="purposeBox"></div>
</div>
<div id="chatContainer" class="box">
    <h4>Type a message below to start chatting.</h4>
    <div class="border">
        <ul id="chat">
        </ul>
    </div>
    <label for="chatMessage">
        Message:
    </label>
    <?php
        echo elgg_view('input/text', array('id' => 'chatMessage', 'name' => 'chatMessage'));
    ?>
</div>


<div id="conceptFanContainer">
           
    <h3>The Concept Fan Tree</h3><br />
    <div class="background explanation">
        <p>
            The Concept Fan is a technique that helps you to generate several alternative possibilities 
            that could become a solution to your assignment. <b>The tree below is editable</b>, and represents your Concept Fan. 
            Firstly, you must think about what broad concepts can lead you to the purpose
            you defined above. Broad Concepts are solution ideas that could achieve your purpose. When you have several
            broad concepts or ideas, then you take each idea and think about how you can implement it. To add an implementation to a broad concept,
            right click on it and click 'Create'.
            Repeat this process by using your implementation ideas as broad concepts for which
            you must find implementation ideas.
        </p>
       
        <p>
            Do not modify the first node. You can right click on any node to change the text you entered, to delete the entire node, or to move it to 
            another position in the tree. When you are finished, click on the "Finish and Save" button. 
            Your possible solutions will be saved for the next stage of your creative process.
        </p>
    </div>
    <br />
    <div id="conceptFanTree"></div>
    <div id="secondTree"></div>
    <br />
    
    <div id="formFinishContainer" class="box">
        <?php
        $form_body .= elgg_view('input/hidden', array('id' => 'groupID', 'name' => 'groupID', 'value' => $groupID));
        $form_body .= elgg_view('input/hidden', array('id' => 'stageNum', 'name' => 'stageNum', 'value' => $stageNum));
        $form_body .= elgg_view('input/hidden', array('id' => 'activityID', 'name' => 'activityID', 'value' => $activityID));
        $form_body .= elgg_view('input/hidden', array('id' => 'instructionID', 'name' => 'instructionID', 'value' => $instructionID));
        $form_body .= elgg_view('input/hidden', array('id' => 'assignmentID', 'name' => 'assignmentID', 'value' => $assignmentID));
        $form_body .= elgg_view('input/hidden', array('id' => 'chatData', 'name' => 'chatData'));
        $form_body .= elgg_view('input/hidden', array('id' => 'allPurposesData', 'name' => 'allPurposesData'));
        $form_body .= elgg_view('input/hidden', array('id' => 'conceptFanTreeData', 'name' => 'conceptFanTreeData'));
        $form_body .= elgg_view('input/hidden', array('id' => 'purposeIdeasCount', 'name' => 'purposeIdeasCount', 'value' => 0));
        $form_body .= elgg_view('input/hidden', array('id' => 'nodesCreatedCount', 'name' => 'nodesCreatedCount', 'value' => 0));
        $form_body .= elgg_view('input/hidden', array('id' => 'leafNodesCreatedCount', 'name' => 'leafNodesCreatedCount', 'value' => 0));
        $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));
        $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));        
        $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnFinishAndSave'));
        echo "<br />";
        echo elgg_view('input/form', array(
                                        'id' => 'formConceptFan',
                                        'body' => $form_body,
                                        'action' => 'action/myTools/conceptFan/save',
                                        'enctype' => 'multipart/form-data',
        ));
        ?>
        <br /><hr/><br />
    </div>    
</div>

<script type="text/javascript" src="<?php echo $nodeServer; ?>/socket.io/socket.io.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.9.0.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>	
<script type="text/javascript" src="<?php echo getElggJSURL()?>jstree/dist/jstree.js"></script>
<script type="text/javascript">
    var ENTER_KEY_CODE = 13;
    var timeMeCounter = 0;
    var currentUser = "<?php echo $currentUser->name; ?>";
    var roomKey = "<?php echo $sessionKey; ?>";
    var chatData = [];
    var allResponses = [];
    var started = false;
    var submittedByCurrentUser = false;
    var questions = new Array();
    questions[0] = "What is the purpose of your thinking with respect to your assignment?";
    questions[1] = "Give at least one broad concept that would help you achieve the purpose you listed.";
    questions[2] = "Give at least one practical way or possible solution for implementing the broad concept that is selected.";
    var currentQuestionIndex = 0;
    var purposes = [];
    var currentNode;
    var leafNodes = [];
    var newNode = {};
    var defaultTree = 
    {
        'text' : '[START NODE] Enter your ideas below',
        'state' : {
                'opened' : true,
                'selected' : true,
                'level' : 0
        },
        'children' : [
            { 
                'text' : 'Enter a Broad Concept or Idea that can help you achieve your purpose.',
                'state' : {
                    'opened' : true,
                    'level' : 1
                },                
                'children' : [
                    {
                        'text' : 'Enter a possible implementation of the above broad concept or idea.',
                        'state' : {
                            'level' : 2
                        }
                    }
                ]
            }
         ]        
    }
    
    $(document).ready(function() {
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            socket.emit("cf_start", { room: roomKey, user: currentUser });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "cf_started") {
                if (!started) {
                    updateChat(data.chatData); 
                    showPurposeFields();
                    updateConceptFanTree(data.conceptFan);
                    started = true;
                }
            }
            else if (data.messageType === "cf_purpose_added") {
                updatePurposes(data.purposes);
                updateConceptFanTree(data.updatedTreeData);
            }
            else if (data.messageType === "cf_concept_added") {
                updateConcepts(data.concepts);
            }
            else if (data.messageType === "cf_solution_added") {
                alert('solution has been added; create a method to handle this. Concepts: ' + data.concepts);
            }
            else if (data.messageType === "cf_message") {
                updateResponses(data.allResponses);
                storeGroupResponses(data.allResponses);
            }
            else if (data.messageType === "chat_message") {
                writeMessage($("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
            else if (data.messageType == "cf_concept_tree_updated") {
                if (data.updatedBy != currentUser) {
                    //Need to actually update the tree here with data.updatedTreeData
                    //Pay attention to currentNode - you need to update the currentNode
                    //after you set the jstree's data = data.updatedTreeData
                    updateConceptFanTree(data.updatedTreeData);
                }
                else {
                    console.log("No need to update.");
                }
            }
            else if (data.messageType == "cf_form_finished") {
//                if (!submittedByCurrentUser) {
//                    window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
//                }
            }
        });
        
        function updateConceptFanTree(newData) {
            $("#conceptFanTree").jstree('destroy');
            loadConceptFanTree(newData);
        }
        
        $("#chatMessage").keyup(function(e) {
            if (e.keyCode === ENTER_KEY_CODE) {
                updateCount($("#chatEntriesCount"));
                var chatMessageBox = $(this);
                var message = chatMessageBox.val();
                chatMessageBox.val("");
                storeChatMessage(currentUser, message);
                socket.emit("chat_message", { room: roomKey, user: currentUser, clientMessage: message, chatData: chatData });
            }
        });
        
        TimeMe.callWhenUserLeaves(function() {
            var timeSpentOnPage = Math.round(TimeMe.getTimeOnCurrentPageInSeconds());
            if (!isNaN(timeSpentOnPage) && timeSpentOnPage > 0) {
                elgg.get('/Core/myTools/storeTimeOnPage/?toolID=<?php echo $toolID ?>&studentID=<?php echo $studentELGGID ?>&groupID=<?php echo $groupID ?>&assignmentID=<?php echo $assignmentID ?>&activityID=<?php echo $activityID ?>&instructionID=<?php echo $instructionID ?>&timeOnPage=' + timeSpentOnPage, {
                    success: function(result, success, xhr) {} 
                });  
                console.log('User left. Time on page: ' + timeSpentOnPage + ' seconds. Counter: ' + timeMeCounter);
                TimeMe.resetAllRecordedPageTimes();
            }
            else {
                console.log("Refusing to store " + timeSpentOnPage);
            }
        }, TIMEME_MAX_IDLE_INVOCATIONS);           
        
        function showPurposeFields() {
            $(".conceptFanFields").hide();
            $("#purposeFields").show();
        }
        
        function showConceptFields() {
            $(".conceptFanFields").hide();
            $("#conceptFields").show();
        }
        
        function showPossibilitiesFields() {
            $(".conceptFanFields").hide();
            $("#purposeFields").hide();
        }
        
        function getSolutions() {
            $(".concept").each(function() {
               $("<textarea class='solution' cols='50' rows='3'></textarea>").appendTo($(this));
               $("<input type='button' value='Add Solution' id='btnAddSolution' class='btnAddSolution' />").appendTo($(this));
            });
            
            $(".btnAddSolution").click(function() {
                var parentContainer = $(this).parent();
                var conceptIndex = parentContainer.attr("data-conceptIndex");
                var solution = parentContainer.find(".solution:first").val();
                socket.emit("cf_add_solution", { room: roomKey, user: currentUser, conceptIndex: conceptIndex, solution: solution });
                alert("c/s: " + conceptIndex + "/" + solution);
            });
            
            $("#concept").hide();
            $("#btnAddConcept").hide();
            $("#btnGetSolutions").hide();
            $("#conceptFieldsTitle").hide();
            $("#solutionFieldsTitle").show();
        }
        
        $("#btnAddPurpose").click(function() {
            updateCount($("#purposeIdeasCount"));
            var newPurpose = $("#purpose").val();
            socket.emit("cf_add_purpose", { room: roomKey, user: currentUser, purpose: newPurpose });
        });

        $("#btnAddConcept").click(function() {
            var newConcept = $("#concept").val();
            socket.emit("cf_add_concept", { room: roomKey, user: currentUser, concept: newConcept });
            $("#concept").val("");
        });
        
        $("#btnGetSolutions").click(function() {
            getSolutions();
        });
        
        $("#btnFinishAndSave").click(function() {
            var $form = $("#formConceptFan");
            $form.appendTo("body").submit();
        });
  
        $("#formConceptFan").submit(function(e) {
           submittedByCurrentUser = true;
           storeChatData(currentUser, chatData);
           storePurposes();
           storeConceptFanTree();
           storeLeafNodes();
           socket.emit("cf_form_finish", { room: roomKey, user: currentUser });
           return true;
        });
        
        function storePurposes() {
            $("#allPurposesData").val(JSON.stringify(purposes));
        }
        
        function storeConceptFanTree() {
            var conceptFanTreeData = $("#conceptFanTree").jstree(true).get_json('#', { 'flat': false });
            $("#conceptFanTreeData").val(JSON.stringify(conceptFanTreeData));
        }
        
        function storeLeafNodes() {
            var treeNode;
            //compare leafNodes with actual nodes to find out and set whether or not the node is still a leaf.
            var index = leafNodes.length - 1;
            while (index >= 0) {
                treeNode = $("#conceptFanTree").jstree(true).get_node(leafNodes[index].nodeID);
                if (treeNode.children.length !== 0) {
                    leafNodes.splice(index, 1);
                }
                index -= 1;
            }
            $("#leafNodesCreatedCount").val(leafNodes.length);            
        }
        
        function loadConceptFanTree(conceptFanData) {
            $("#conceptFanTree")
                .on('rename_node.jstree', function(event, data) {
                    //A node has been updated. Send the new data to node.js for distribution to all clients
                    console.log('a new node was created (rename_node.jstree) with the following data:\n' + data.old + "\n" + data.text);
                    //maybe I can just pass the new node around, since it has the parent info...?
                    //That might not work, since more than one person could be working on the same node.
                    //We probably therefore have to store the id of the node that's currently being worked on
                    //and update the whole tree, then add back the current node as a child under its original parent.
                    //What now: figure out how to store the node that's currently being worked on. What event
                    //should we use to capture this? -- activate_node
                    var dataToShare = $("#conceptFanTree").jstree(true).get_json('#', { 'flat': false });
                    socket.emit("cf_update_concept_tree", { room: roomKey, user: currentUser, updatedTreeData: dataToShare });
                })
                .on('create_node.jstree', function(event, data) {
                    updateCount($("#nodesCreatedCount"));
                    newNode = {};
                    newNode.nodeID = data.node.id;
                    newNode.isLeafNode = true;
                    newNode.user = <?php echo $studentELGGID ?>;
                    leafNodes.push(newNode);                    
                })
                .on('activate_node.jstree', function(event, data) {
                    currentNode = data.node;
                    console.log('a new node was created (activate_node.jstree) with the following data:\n' + data.node.id);
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
    
        function updateConcepts(serverConcepts) {
            alert('Number of serverConcepts: ' + serverConcepts.length);
            if (serverConcepts == undefined) { return; }
            var concept;
            for (var i = 0; i < serverConcepts.length; i++) {
                concept = serverConcepts[i];
                //if the concept isn't already present on the page, add it.
                if ($("#concepts:first").find("div.concept[data-conceptIndex='" + i + "']").length == 0) {
                    $("<div class='concept' data-conceptIndex='" + i + "'><p>" + concept + "</p></div>").appendTo($("#concepts"));
                }
            }
        }
        
        function updatePurposes(serverPurposes) {
            if (serverPurposes == undefined) { return; }
            purposes = serverPurposes;
            var purpose;
            var purposesDiv = $("#purposes");
            purposesDiv.empty();
            for (var i = 0; i < serverPurposes.length; i++) {
                purpose = serverPurposes[i];
                $("<p>" + purpose + "</p>").appendTo(purposesDiv);
            }
        }
        
        ///OLD
        
        $("#btnAdd").click(function() {
            studentAnswer_submitted();
        });
        
        function showQuestionAndResponses() {
            $("#questionPrompt").text(questions[currentQuestionIndex]);
            currentQuestionIndex++;
        }
        
        function studentAnswer_submitted() {
            var answer = $("#studentAnswer").val();
            socket.emit("cf_message", { 
                room: roomKey, 
                user: currentUser, 
                answer: answer, 
                allResponses: allResponses
            });    
            showQuestionAndResponses();
            $("#studentAnswer").val('');
        }
        
        function hasFurtherInstructions() {
            var nextInstruction = getNextInstruction();
            return nextInstruction.length == 0;
        }
        
        function getNextInstruction() {
            var currentInstruction = $("span.instruction.current");
            currentInstruction.removeClass("current");
            var nextInstruction = currentInstruction.next();
            return nextInstruction;
        }
        
        function addStudentAnswer(answer) {
            
        }
        
        function updateResponses(serverResponses) {
//            if (serverResponses == undefined) {
//                serverResponses = {};
//            }
//            allResponses = serverResponses;
//            if (allResponses.groupResponses === undefined) { return; }
//            else {
//                var groupResponse;
//                for (var i = 0; i < allResponses.groupResponses.length; i++) {
//                    groupResponse = allResponses.groupResponses[i];
//                    writeResponse(groupResponse);
//                }     
//            }
        }
        
        function writeResponse(groupResponse) {
            var allResponsesContainer = $("#groupInputContainer");
            var groupResponseContainer = allResponsesContainer.find("div[data-citID=" + groupResponse.citID + "]");
            groupResponseContainer.find(".response").remove();
            if (groupResponseContainer == undefined || groupResponseContainer.length == 0) {
                //create new groupResponse div
                var newGroupResponseContainer = $("<div class='groupResponses'></div>");
                newGroupResponseContainer.attr("data-citID", groupResponse.citID);
                var newGroupAnswerHeadingContainer = $("<div class='groupAnswerHeading'></div>");
                var newGroupAnswerHeadingText = $("#allInstructions .instruction[data-citID=" + groupResponse.citID + "] .groupAnswerHeading").text();
                newGroupAnswerHeadingContainer.text(newGroupAnswerHeadingText);
                newGroupResponseContainer.append(newGroupAnswerHeadingContainer);
                allResponsesContainer.find("div.border").append(newGroupResponseContainer);
                groupResponseContainer = allResponsesContainer.find("div[data-citID=" + groupResponse.citID + "]");
            }
            for (var i = 0; i < groupResponse.userResponses.length; i++) {
                var newResponseContainer = $("<div class='response'></div>");
                newResponseContainer.text(groupResponse.userResponses[i].user + ": " + groupResponse.userResponses[i].answer);
                groupResponseContainer.append(newResponseContainer);
            }
        }
     
        function storeGroupResponses(allResponses) {
            $("#allResponsesData").val(JSON.stringify(allResponses));
        }
    });
    <?php include elgg_get_plugins_path()."Core/views/default/Core/myTools/js/chat.php"; ?>
</script>
</div>
