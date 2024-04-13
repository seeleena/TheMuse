<!-- TimeMe -->
<script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>   

<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Random Word Generator Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Random Word Generator</h2>
    </div>
    <blockquote>
        <p>This tool generates random words. Click it to copy to clipboard.</p>
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
        padding-top: 10px;
        padding-right: 10px;
    }
    #formFinishContainer {
        width: 300px;
        float: left;
        padding-top: 10px;
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
    #rwgContainer {
        font-size: 50px;
        font-weight: bolder;
        text-align: center;
        color: #4690D6;
        padding: 20px;
    }
    #rwgContainer:hover {
        cursor: pointer;
    }



</style>
<div id="rwgContainer" title="Click to copy to clipboard"><?php echo $vars['randomWord']?></div>
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
    $form_body .= elgg_view('input/hidden', array('id' => 'wordsGeneratedCount', 'name' => 'wordsGeneratedCount', 'value' => 1));
    $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));
    $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnFinishAndSave'));
    echo elgg_view('input/form', array(
                                    'id' => 'rwgForm',
                                    'body' => $form_body,
                                    'action' => 'action/myTools/randomWordGenerator/save',
                                    'enctype' => 'multipart/form-data',
    ));
    ?>
</div>  
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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

    function copyToClipboard(elem) {
              // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        var succeed;
        try {
              succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }

    jQuery(document).ready(function() {
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            socket.emit("rwg_start", { room: roomKey, user: currentUser });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "rwg_started") {
                if (!started) {
                    updateChat(data.chatData); 
                    started = true;
                }
            }
            else if (data.messageType === "chat_message") {
                writeMessage(jQuery("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
            else if (data.messageType === "rwg_form_finished") {
                if (!submittedByCurrentUser) {
                    window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
                }
            }
            else if (data.messageType === "error") {
                alert('An error has occurred: ' + data.message);
            }
        });
       
        jQuery("#chatMessage").keyup(function(e) {
            if (e.keyCode === ENTER_KEY_CODE) {
                var chatMessageBox = jQuery(this);
                var message = chatMessageBox.val();
                chatMessageBox.val("");
                storeChatMessage(currentUser, message);
                socket.emit("chat_message", { room: roomKey, user: currentUser, clientMessage: message, chatData: chatData });
            }
        });
        
        function storeRandomWordGeneratorData() {
            //var wordCount = firepad.getText().trim().split(/\s+/).length;
            //jQuery("#wordCount").val(wordCount);
        }
        
        jQuery("#rwgContainer").click(function() {
            copyToClipboard(this);
            elgg.system_message("'" + jQuery(this).text() + "' copied to clipboard.");
        });
        
        jQuery("#rwgForm").submit(function() {
            submittedByCurrentUser = true;
            storeChatData(currentUser, chatData);
            storeRandomWordGeneratorData();
            storeTimingData();
            socket.emit("rwg_form_finish", { room: roomKey, user: currentUser });
            return true;            
        });
        
        jQuery(window).unload(function() {
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
