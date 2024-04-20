<script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>  
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Collaborative Input Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Collaborative Input Tool</h2>
    </div>

    <blockquote>
        <p>
            You will be asked several questions, displayed one at a time under "Question Prompt".
            Each question may contain a "Specific Hint" to help you to better answer the question.
            Answer each question by typing in the input box below the question and then clicking
            on the "Post Answer" button. Your input will be displayed in the "Group Answers" box.
            
            Clicking the "Post Answer" button moves to the next question. You can choose to move 
            on to the next question, or wait until all your group members 
            finish before proceeding to the next question. 
        </p>
        <p>
            Use the chat box below for discussion of your group answers.
            When all questions have been answered, you can save your work using the "Finish and Save" button.
        </p>
    </blockquote>

<?php

$toolID        = $vars['toolID'];
$instructions  = $vars['instructions'];
$assignmentID  = $vars['assignID'];
$instructionID = $vars['instructionID'];
$activityID    = $vars['activityID'];
$stageNum      = $_GET['stageNum'];
$groupID       = $vars['groupID'];
$groupMembers  = $vars['groupMembers'];
//$nodeServer    = $vars['nodeServer'];
$nodeServer    = 'http://localhost:8888';
$currentUser   = elgg_get_logged_in_user_entity();
$studentELGGID = $currentUser->guid;
$sessionKey    = $vars['sessionKey'];

$_SESSION['groupID'] = $groupID;
$_SESSION['instructionID'] = $instructionID;
$_SESSION['assignmentID'] = $assignmentID;
$_SESSION['activityID'] = $activityID;
?>

<style>
    .elgg-main {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
    }
    #groupInputContainer {
        width: 60%;
        float: left;
    }
    #groupInputContainer div.border, #chatContainer div.border {
        border: 1px solid black;
        /*min-height: 50px;*/
        height: 300px;
        overflow: auto;
    }
    #chat {
        overflow: auto;
        height: 300px;
    }
    #chatContainer {
        float: right;
        width: 38%;
    }
    #formFinishContainer {
        width: 300px;
        float: left;
    }
    span.instruction {
        display: none;
    }
    span.instruction.current {
        display: block;
    }
    .myTextArea {
        width: 100%;
        height: 100px;
    }
    .background {
        background-color: #f0f0f0;
        padding: 5px;
        border: 1px solid #ccc;
        margin-bottom: 5px;
    }
    .box {
        margin-bottom: 10px;
    }
    .myHr {
        clear: both;
    }
</style>
<label> Question Prompt: </label><div id="questionPrompt" class="background"></div>
<label> Specific Hint: </label><div id="specificHint" class="background"></div>
<label> Your Answer: </label><textarea id="studentAnswer" class="myTextArea"></textarea>
<input class="elgg-button" type="button" value="Post Answer" id="btnPostAnswer" /><br /><br />
<?php
echo "<div id='allInstructions'>";
if (empty($instructions)) {
    echo "No instructions found.";
} else {
    foreach ($instructions as $instruction) {
        echo "  <span class='instruction' data-citID='" . $instruction->citID . "'>";
        echo "    <span class='questionPrompt'>" . $instruction->questionPrompt . "</span>";
        echo "    <span class='specificHint'>" . $instruction->specificHint . "</span>";
        echo "    <span class='groupAnswerHeading'>" . $instruction->groupAnswerHeading . "</span>";
        echo "  </span>";
    }
}
echo "</div>";
?>
<div id="groupInputContainer" class="box">
    <h4>Group Answers:</h4>
    <div class="border">
        <div class="groupResponses" data-citID="0">
            <div class="groupAnswerHeading"></div>
            <div class="response"></div>
        </div>
    </div>
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
<hr class="myHr"/>
<div id="formFinishContainer" class="box">
    <?php
    $form_body .= elgg_view('input/hidden', array('id' => 'groupID', 'name' => 'groupID', 'value' => $groupID));
    $form_body .= elgg_view('input/hidden', array('id' => 'stageNum', 'name' => 'stageNum', 'value' => $stageNum));
    $form_body .= elgg_view('input/hidden', array('id' => 'activityID', 'name' => 'activityID', 'value' => $activityID));
    $form_body .= elgg_view('input/hidden', array('id' => 'instructionID', 'name' => 'instructionID', 'value' => $instructionID));
    $form_body .= elgg_view('input/hidden', array('id' => 'assignmentID', 'name' => 'assignmentID', 'value' => $assignmentID));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatData', 'name' => 'chatData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'allResponsesData', 'name' => 'allResponsesData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));    
    $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnSubmit'));
    echo elgg_view('input/form', array(
                                    'id' => 'formQuestions',
                                    'body' => $form_body,
                                    'action' => 'action/myTools/collaborativeInput/save',
                                    'enctype' => 'multipart/form-data',
    ));
    ?>
</div>

<script type="text/javascript" src="<?php echo $nodeServer; ?>/socket.io/socket.io.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>	
<script type="text/javascript">
    var ENTER_KEY_CODE = 13;
    var currentUser = "<?php echo $currentUser->name; ?>";
    var currentUserID = "<?php echo $studentELGGID; ?>";
    var roomKey = "<?php echo $sessionKey . "_" . $instructionID; ?>";
    var chatData = [];
    var allResponses = [];
    var started = false;
    var timeMeCounter = 0;
    
    jQuery(document).ready(function() {
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            socket.emit("ci_start", { room: roomKey, user: currentUser });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "ci_started") {
                if (!started) {
                    updateChat(data.chatData); 
                    updateResponses(data.allResponses);
                    storeGroupResponses(data.allResponses);
                    started = true;
                }
            }
            else if (data.messageType === "ci_message") {
                updateResponses(data.allResponses);
                storeGroupResponses(data.allResponses);
            }
            else if (data.messageType === "chat_message") {
                writeMessage(jQuery("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
        });
        
        jQuery("#chatMessage").keyup(function(e) {
            if (e.keyCode === ENTER_KEY_CODE) {
                updateCount(jQuery("#chatEntriesCount"));
                var chatMessageBox = jQuery(this);
                var message = chatMessageBox.val();
                chatMessageBox.val("");
                storeChatMessage(currentUser, message);
                socket.emit("chat_message", { room: roomKey, user: currentUser, clientMessage: message, chatData: chatData });
            }
        });
        
        TimeMe.callWhenUserLeaves(function() {
            var timeSpentOnPage = Math.round(TimeMe.getTimeOnCurrentPageInSeconds());
            if (!isNaN(timeSpentOnPage) && timeSpentOnPage > 0) {
                var url = '/Muse/Core/myTools/storeTimeOnPage/?toolID=<?php echo $toolID ?>&studentID=<?php echo $studentELGGID ?>&groupID=<?php echo $groupID ?>&assignmentID=<?php echo $assignmentID ?>&activityID=<?php echo $activityID ?>&instructionID=<?php echo $instructionID ?>&timeOnPage=' + timeSpentOnPage;
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => console.log(data))
                .catch((error) => {
                    console.error('Error:', error);
                });
                console.log('User left. Time on page: ' + timeSpentOnPage + ' seconds. Counter: ' + timeMeCounter);
                TimeMe.resetAllRecordedPageTimes();
            }
            else {
                console.log("Refusing to store " + timeSpentOnPage);
            }
        }, TIMEME_MAX_IDLE_INVOCATIONS);        
        
        var firstInstruction = jQuery("span.instruction:first");
        firstInstruction.addClass("current");
        populateInstructionFields(firstInstruction);

        jQuery("#btnPostAnswer").prop("disabled", true);

        jQuery("#studentAnswer").on("input", function() {
            if (jQuery(this).val().length > 0) {
                jQuery("#btnPostAnswer").prop("disabled", false);
            } else {
                jQuery("#btnPostAnswer").prop("disabled", true);
            }
        });

        jQuery("#btnPostAnswer").click(function() {
            studentAnswer_submitted();
        });
        
        jQuery("#formQuestions").submit(function() {
            storeChatData(currentUser, chatData);
        });
        
        function studentAnswer_submitted() {
            var answer = jQuery("#studentAnswer").val();
            var citID = jQuery("#allInstructions .instruction.current").data("citid");
            socket.emit("ci_message", { 
                room: roomKey, 
                user: currentUser, 
                userID: currentUserID,
                answer: answer, 
                allResponses: allResponses,
                citID: citID
            });    
            var nextInstruction = getNextInstruction();
            if (nextInstruction.length == 0) {
                <?php elgg_error_response("You have to completed all questions."); ?>
                jQuery("#btnPostAnswer").attr("disabled", "disabled");
                jQuery("#studentAnswer").prop("disabled", true);
            }
            else {
                nextInstruction.addClass("current");
                populateInstructionFields(nextInstruction);
                jQuery("#btnPostAnswer").prop("disabled", true);
            }
            jQuery("#studentAnswer").val('');
        }
        
        function hasFurtherInstructions() {
            var nextInstruction = getNextInstruction();
            return nextInstruction.length == 0;
        }
        
        function getNextInstruction() {
            var currentInstruction = jQuery("span.instruction.current");
            currentInstruction.removeClass("current");
            var nextInstruction = currentInstruction.next();
            return nextInstruction;
        }
        
        function addStudentAnswer(answer) {
            
        }
        
        function updateResponses(serverResponses) {
            if (serverResponses == undefined) {
                serverResponses = {};
            }
            allResponses = serverResponses;
            if (allResponses.groupResponses === undefined) { return; }
            else {
                var groupResponse;
                for (var i = 0; i < allResponses.groupResponses.length; i++) {
                    groupResponse = allResponses.groupResponses[i];
                    writeResponse(groupResponse);
                }     
            }
        }
        
        function writeResponse(groupResponse) {
            var allResponsesContainer = jQuery("#groupInputContainer");
            var groupResponseContainer = allResponsesContainer.find("div[data-citID=" + groupResponse.citID + "]");
            groupResponseContainer.find(".response").remove();
            if (groupResponseContainer == undefined || groupResponseContainer.length == 0) {
                //create new groupResponse div
                var newGroupResponseContainer = jQuery("<div class='groupResponses'></div>");
                newGroupResponseContainer.attr("data-citID", groupResponse.citID);
                var newGroupAnswerHeadingContainer = jQuery("<div class='groupAnswerHeading'></div>");
                var newGroupAnswerHeadingText = jQuery("#allInstructions .instruction[data-citID=" + groupResponse.citID + "] .groupAnswerHeading").text();
                newGroupAnswerHeadingContainer.text(newGroupAnswerHeadingText);
                newGroupResponseContainer.append(newGroupAnswerHeadingContainer);
                allResponsesContainer.find("div.border").append(newGroupResponseContainer);
                groupResponseContainer = allResponsesContainer.find("div[data-citID=" + groupResponse.citID + "]");
            }
            for (var i = 0; i < groupResponse.userResponses.length; i++) {
                var newResponseContainer = jQuery("<div class='response'></div>");
                newResponseContainer.text(groupResponse.userResponses[i].user + ": " + groupResponse.userResponses[i].answer);
                groupResponseContainer.append(newResponseContainer);
            }
        }
    
        function populateInstructionFields(instruction) {
            jQuery("#questionPrompt").text(instruction.find(".questionPrompt:first").text());
            jQuery("#specificHint").text(instruction.find(".specificHint:first").text());
            jQuery("#groupAnswerHeading").text(instruction.find(".groupAnswerHeading:first").text());            
        }
        
        function storeGroupResponses(allResponses) {
            jQuery("#allResponsesData").val(JSON.stringify(allResponses));
        }
        
       
    });

    <?php include elgg_get_plugins_path()."Core/views/default/Core/myTools/js/chat.php"; ?>
</script>
</div>
