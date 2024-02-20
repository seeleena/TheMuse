<!-- Firebase -->
<script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>

<!-- CodeMirror -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.css" />

<!-- Firepad -->
<link rel="stylesheet" href="https://cdn.firebase.com/libs/firepad/1.1.1/firepad.css" />
<script src="https://cdn.firebase.com/libs/firepad/1.1.1/firepad.min.js"></script>

<!-- TimeMe -->
<script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>   

<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Report Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Report</h2>
    </div>
    <blockquote>
        <p>This tool provides a collaborative writing area, in which you can write your report as a group.
        Each person in your group can immediately see what the others are writing. Formatting tools
        are also provided.</p>
        <p>
         Select "Finish and Save" to close the tool and save your work.
        </p>
   </blockquote>
<?php
$toolID       = $vars['toolID'];
$assignmentID = $vars['assignmentID'];
$stageNum = $_GET['stageNum'];
$activityID   = $vars['activityID'];
$instructionID= $vars['instructionID'];
$groupID      = $vars['groupID'];
$groupMembers = $vars['groupMembers'];
$nodeServer   = $vars['nodeServer'];
$currentUser  = elgg_get_logged_in_user_entity();
$studentELGGID = $currentUser->guid;
$sessionKey   = $vars['sessionKey'];
$reportURL    = $vars['reportURL'];

$_SESSION['groupID'] = $groupID;
$_SESSION['instructionID'] = $instructionID;
$_SESSION['assignmentID'] = $assignmentID;
$_SESSION['activityID'] = $activityID;
?>
<style>
    
    .firepad {
      width: 700px;
      height: 450px;
    }

    /* Note: CodeMirror applies its own styles which can be customized in the same way.
       To apply a background to the entire editor, we need to also apply it to CodeMirror. */
    .CodeMirror {
      background-color: lightgray;
    }    
    
    #chatContainer div.border {
        border: 1px solid black;
        /*min-height: 50px;*/
        height: 150px;
        overflow: auto;
    }
    #chat {
        overflow: auto;
    }
    #chatContainer {
        float: left;
        width: 700px;
    }
    #formFinishContainer {
        width: 300px;
        float: left;
    }
   
    #chatContainer div.border {
        border: 1px solid black;
        /*min-height: 50px;*/
        height: 300px;
        overflow: auto;
    }
    
    input[type="submit"] {
        width: auto;
    }
    #purposeFields {
        display: block;
    }
    #solutionFieldsTitle {
        display: none;
    }
   
</style>

<div id="firepad"></div>
<div id="chatContainer" class="box">
    <br/><h4>Type a message below to start chatting.</h4>
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
    $form_body .= elgg_view('input/hidden', array('id' => 'url', 'name' => 'url', 'value' => $reportURL));
    $form_body .= elgg_view('input/hidden', array('id' => 'wordCount', 'name' => 'wordCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));    
    $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));
    $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnFinishAndSave'));
    echo elgg_view('input/form', array(
                                    'id' => 'reportForm',
                                    'body' => $form_body,
                                    'action' => 'action/myTools/report/save',
                                    'enctype' => 'multipart/form-data',
    ));
    ?>
</div>  
<script type="text/javascript" src="<?php echo $nodeServer; ?>/socket.io/socket.io.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>	
<script type="text/javascript">
    var ENTER_KEY_CODE = 13;
    var currentUser = "<?php echo $currentUser->name; ?>";
    var roomKey = "<?php echo $sessionKey . "_" . $instructionID; ?>";
    var chatData = [];
    var started = false;
    var submittedByCurrentUser = false;
    var listItems = [];
    var firepad = null;

    $(document).ready(function() {
        
        var firepadRef = new Firebase('<?php echo $reportURL ?>');
        var codeMirror = CodeMirror(document.getElementById('firepad'), { lineWrapping: true });
        firepad = Firepad.fromCodeMirror(firepadRef, codeMirror,
            { richTextShortcuts: true, richTextToolbar: true, defaultText: 'Create your report here.' });        
        
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            socket.emit("report_start", { room: roomKey, user: currentUser });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "report_started") {
                if (!started) {
                    updateChat(data.chatData); 
                    started = true;
                }
            }
            else if (data.messageType === "chat_message") {
                writeMessage($("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
            else if (data.messageType === "report_form_finished") {
                if (!submittedByCurrentUser) {
                    window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
                }
            }
            else if (data.messageType === "error") {
                alert('An error has occurred: ' + data.message);
            }
        });
       
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
        
        function storeReportData() {
            var wordCount = firepad.getText().trim().split(/\s+/).length;
            $("#wordCount").val(wordCount);
        }
        
        $("#reportForm").submit(function() {
            submittedByCurrentUser = true;
            storeChatData(currentUser, chatData);
            storeReportData();
            storeTimingData();
            socket.emit("report_form_finish", { room: roomKey, user: currentUser });
            return true;            
        });
        
        $(window).unload(function() {
            var timeSpentOnPage = Math.round(TimeMe.getTimeOnCurrentPageInSeconds());
            elgg.get('/Core/myTools/storeTimeOnPage/?toolID=<?php echo $toolID ?>&studentID=<?php echo $studentELGGID ?>&groupID=<?php echo $groupID ?>&assignmentID=<?php echo $assignmentID ?>&activityID=<?php echo $activityID ?>&instructionID=<?php echo $instructionID ?>&timeOnPage=' + timeSpentOnPage, {
                success: function(result, success, xhr) {

                } 
            });  
        });
    });
    
    <?php include elgg_get_plugins_path()."Core/views/default/Core/myTools/js/chat.php"; ?>
</script>
</div>
