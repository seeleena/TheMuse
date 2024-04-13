<!-- TimeMe -->
<script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>  
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>List Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">List</h2>
    </div>
    <blockquote>
        <p>
            This tool helps you to list things - information, ideas, possible solutions, group thoughts, etc.
        </p><p>
            You can use the chat box to discuss things before or after you list them.
        </p><p>
            Select "Finish and Save" to close the tool and save your work.
        </p>
    </blockquote>
<?php
$toolID        = $vars['toolID'];
$assignmentID  = $vars['assignmentID'];
$stageNum      = $_GET['stageNum'];
$activityID    = $vars['activityID'];
$instructionID = $vars['instructionID'];
$groupID       = $vars['groupID'];
$groupMembers  = $vars['groupMembers'];
$nodeServer    = $vars['nodeServer'];
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
    #listContainer {
        width: 60%;
        float: left;
    }
    #listContainer div.border{
        border: 1px solid black;
        height: 500px;
        overflow: auto;
    }
    #listItems {
        height: 300px;
        border: 1px solid black;
        overflow: auto;
        padding: 10px;
    }
    #formFinishContainer {
        width: 300px;
        float: left;
        padding-top: 20px;
    }
    #leftBoxContainer {
        float: left;
        width: 45%;
    }
    #listInputContainer {
        width: 100%;
        float: left;
    }
    #listInputContainer div.border, #chatContainer div.border {
        border: 1px solid black;
        overflow: auto;
    }
    #chatContainer div.border {
        border: 1px solid black;
        overflow: auto;
    }
    #chat {
        overflow: auto;
        height: 253px;
        padding: 10px;
    }
    #chatContainer {
        float: right;
        width: 38%;
    }
    #rightBoxContainer {
        float: right;
        width: 45%;
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
<fieldset class="listFields" id="listFields">
    <legend>Enter your list item here:</legend>
    <textarea id="listItem" class="myTextArea"></textarea>
    <input class="elgg-button" type="button" value="Add List Item" id="btnAddListItem" />
</fieldset><br />
<div id='listContainer' class='box'>
    <div id="listInputContainer">
        <h3>All Listed Items</h3>
        <div id="listItems" class="box"></div>
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
<div id="formFinishContainer" class="box">
    <?php
    $form_body .= elgg_view('input/hidden', array('id' => 'groupID', 'name' => 'groupID', 'value' => $groupID));
    $form_body .= elgg_view('input/hidden', array('id' => 'stageNum', 'name' => 'stageNum', 'value' => $stageNum));
    $form_body .= elgg_view('input/hidden', array('id' => 'activityID', 'name' => 'activityID', 'value' => $activityID));
    $form_body .= elgg_view('input/hidden', array('id' => 'instructionID', 'name' => 'instructionID', 'value' => $instructionID));
    $form_body .= elgg_view('input/hidden', array('id' => 'assignmentID', 'name' => 'assignmentID', 'value' => $assignmentID));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatData', 'name' => 'chatData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'allListItemsData', 'name' => 'allListItemsData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'listItemsAddedCount', 'name' => 'listItemsAddedCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));    
    $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnFinishAndSave'));
    echo elgg_view('input/form', array(
                                    'id' => 'formList',
                                    'body' => $form_body,
                                    'action' => 'action/myTools/list/save',
                                    'enctype' => 'multipart/form-data',
    ));
    ?>
</div>  
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo $nodeServer; ?>/socket.io/socket.io.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.9.0.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>	
<script type="text/javascript">
    var ENTER_KEY_CODE = 13;
    var currentUser = "<?php echo $currentUser->name; ?>";
    var roomKey = "<?php echo $sessionKey; ?>";
    var chatData = [];
    var started = false;
    var submittedByCurrentUser = false;
    var listItems = [];

    jQuery(document).ready(function() {
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            socket.emit("list_start", { room: roomKey, user: currentUser });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "list_started") {
                if (!started) {
                    updateListItems(data.listItems);
                    updateChat(data.chatData); 
                    started = true;
                }
            }
            else if (data.messageType === "list_listItem_added") {
                updateListItems(data.listItems);
            }
            else if (data.messageType === "chat_message") {
                writeMessage(jQuery("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
            else if (data.messageType === "list_form_finished") {
                if (!submittedByCurrentUser) {
                    elgg.system_message(data.message);
                }
            }
            else if (data.messageType === "error") {
                alert('An error has occurred: ' + data.message);
            }
        });
        
        TimeMe.callWhenUserLeaves(function() {
            var timeSpentOnPage = Math.round(TimeMe.getTimeOnCurrentPageInSeconds());
            if (!isNaN(timeSpentOnPage) && timeSpentOnPage > 0) {
                elgg.get('/Core/myTools/storeTimeOnPage/?toolID=<?php echo $toolID ?>&studentID=<?php echo $studentELGGID ?>&groupID=<?php echo $groupID ?>&assignmentID=<?php echo $assignmentID ?>&activityID=<?php echo $activityID ?>&instructionID=<?php echo $instructionID ?>&timeOnPage=' + timeSpentOnPage, {
                    success: function(result, success, xhr) {} 
                });  
                console.log('User left. Time on page: ' + timeSpentOnPage + ' seconds.');
                TimeMe.resetAllRecordedPageTimes();
            }
            else {
                console.log("Refusing to store " + timeSpentOnPage);
            }
        }, TIMEME_MAX_IDLE_INVOCATIONS);          
        
        function updateListItems(serverListItems) {
            if (serverListItems == undefined) { return; }
            listItems = serverListItems;
            var listItem;
            var listItemsDiv = jQuery("#listItems");
            listItemsDiv.empty();
            for (var i = 0; i < serverListItems.length; i++) {
                listItem = serverListItems[i];
                jQuery("<p>" + listItem.user + ": " + listItem.listItem + "</p>").appendTo(listItemsDiv);
            }
        }
        
        jQuery("#btnAddListItem").click(function() {
            var listItemInput = jQuery("#listItem");
            var newListItem = listItemInput.val();
            listItemInput.val("");
            socket.emit("list_add_listItem", { room: roomKey, user: currentUser, listItem: newListItem });
            updateCount(jQuery("#listItemsAddedCount"));
        });        
        
        jQuery("#chatMessage").keyup(function(e) {
            if (e.keyCode === ENTER_KEY_CODE) {
                var chatMessageBox = jQuery(this);
                var message = chatMessageBox.val();
                chatMessageBox.val("");
                storeChatMessage(currentUser, message);
                socket.emit("chat_message", { room: roomKey, user: currentUser, clientMessage: message, chatData: chatData });
                updateCount(jQuery("#chatEntriesCount"));
            }
        });
        
        jQuery("#formList").submit(function() {
            submittedByCurrentUser = true;
            storeChatData(currentUser, chatData);
            storeListItems();
            socket.emit("list_form_finish", { room: roomKey, user: currentUser });
            return true;            
        });
        
        function storeListItems() {
            jQuery("#allListItemsData").val(JSON.stringify(listItems));
        }        
    });
    
    <?php include elgg_get_plugins_path()."Core/views/default/Core/myTools/js/chat.php"; ?>
</script>
</div>
