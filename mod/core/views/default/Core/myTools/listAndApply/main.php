<!-- TimeMe -->
<script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>  
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>List and Apply Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">List and Apply</h2>
    </div>
    <blockquote>
        <p>
Use the input box below to answer the question listed in the instruction that led you to this tool.
Click on the "List Answer" button to list your answer in the box below. You may input as many answers as you like.
        </p><p>
After you have finished, you must apply the list you created to further develop 
each possible solution (PO).
Select the PO from the list to modify it. (You can type in the selected PO box). When you have finished, click "Finish and Save".
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

$allPossibilities = array();
$allPossibilities = getPOs($groupID, $assignmentID);

$message  = $_GET['message'];
//system_message($message); 

?>
<style>
    .elgg-main {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            
    }
    #POsContainer {
        width: 60%;
        float: left;
    }
    #POsContainer div.border, #chatContainer div.border {
        border: 1px solid black;
        /*min-height: 50px;*/
        height: 300px;
        overflow: auto;
    }
    #listAnswersContainer {
        overflow: auto;
        height: 150px;
    }
    #chat {
        overflow: auto;
        height: 300px;
    }
    #chatContainer {
        float: right;
        width: 35%;
    }
    #formFinishContainer {
        width: 300px;
        float: left;
    }
    #possibilities {
        margin: 10px;
    }
    li.possibility {
        color: white;
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        -moz-border-radius: 1em;
        -webkit-border-radius: 1em;
        border-radius: 1em;
        border: 2px solid #006AB6;
        background: #4690D6;        
    }
    li.editable {
        background: gray;
    }
    .myBox {
        width: 100%;
        height: 100%;
        overflow: auto;
    }
    .box {
        padding: 10px;
        margin: 10px;
    }
    .border {
        border: 1px solid black;
        padding: 10px;
    }
</style>
<div id="listContainer" class="box">
    <div class="border">
        <label> Your Answer: </label>
        <input type="text" id="listItem" />
        <br /><br /><input type="button" value="List Answer" id="btnListItem" class="elgg-button"/>
        <br /><br /><label> List to be applied to POs: </label>
        <div id="listAnswersContainer" class="myBox">
            <div class="border">
                
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="initialPossibilities" value="<?php echo htmlspecialchars(json_encode($allPossibilities), ENT_QUOTES); ?>" />
<div id="POsContainer" class="box">
    <br /><h4>Possible Solutions (POs):</h4>
    <div class="border">
        <div class="PO">
            <ul id="possibilities" class="">
                    <?php /* foreach ($allPossibilities as $possibility) { ?>
                        <li class="ui-state-default possibility" data-PO_ID="<?php echo $possibility->id?>" contenteditable="true"><?php echo $possibility->text?></li>
                    <?php } */?>
            </ul>
        </div>
    </div>
</div>
<div id="chatContainer" class="box">
    <br /><h4>Type a message below to start chatting.</h4>
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
<br /><br /><br />

<div id="formFinishContainer" class="box">
    <?php
    $form_body .= elgg_view('input/hidden', array('id' => 'groupID', 'name' => 'groupID', 'value' => $groupID));
    $form_body .= elgg_view('input/hidden', array('id' => 'stageNum', 'name' => 'stageNum', 'value' => $stageNum));
    $form_body .= elgg_view('input/hidden', array('id' => 'activityID', 'name' => 'activityID', 'value' => $activityID));
    $form_body .= elgg_view('input/hidden', array('id' => 'instructionID', 'name' => 'instructionID', 'value' => $instructionID));
    $form_body .= elgg_view('input/hidden', array('id' => 'assignmentID', 'name' => 'assignmentID', 'value' => $assignmentID));    
    $form_body .= elgg_view('input/hidden', array('id' => 'chatData', 'name' => 'chatData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'allPOsData', 'name' => 'allPOsData'));    
    $form_body .= elgg_view('input/hidden', array('id' => 'allListItemsData', 'name' => 'allListItemsData')); 
    $form_body .= elgg_view('input/hidden', array('id' => 'listAnswerCount', 'name' => 'listAnswerCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'POsEditedCount', 'name' => 'POsEditedCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));
    $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnSubmit'));
    echo "<br />";
    echo elgg_view('input/form', array(
                                    'id' => 'formListAndApply',
                                    'body' => $form_body,
                                    'action' => 'action/myTools/listAndApply/save',
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
    var roomKey = "<?php echo $sessionKey; ?>";
    var chatData = [];
    var started = false;
    var listItems = [];
    var allChangedPOs = [];
    var submittedByCurrentUser = false;    
    var timeMeCounter = 0;
    
    jQuery(document).ready(function() {
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            var initialPossibilities = JSON.parse(jQuery("#initialPossibilities").val());
            socket.emit("laa_start", { room: roomKey, user: currentUser, initialPossibilities: initialPossibilities });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "laa_started") {
                if (!started) {
                    updateListItems(data.listItems);
                    updatePossibilities(data.possibilities);
                    updateChat(data.chatData); 
                    started = true;
                }
            }
            else if (data.messageType === "laa_listItem_added") {
                updateListItems(data.listItems);
                //jQuery("#btnFinishAndSave").show();
            }
            else if (data.messageType === "laa_possibility_changed") {
                updatePossibility(data.changedPossibility);
                savePOs(data.changedPossibility);
            }
            else if (data.messageType === "chat_message") {
                writeMessage(jQuery("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
            else if (data.messageType === "laa_form_finished") {
                if (!submittedByCurrentUser) {
                    //socket.emit("laa_resave_possibilities", { room: roomKey, user: currentUser, possibilities: data.possibilities });
                    //window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
                    elgg.system_message(data.message);
                    //window.location.href = window.location.href + "&message=" + data.message;
                }
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
        
        function updateListItems(serverListItems) {
            if (serverListItems == undefined) { return; }
            listItems = serverListItems;
            var listItem;
            var listItemsDiv = jQuery("#listAnswersContainer");
            listItemsDiv.empty();
            for (var i = 0; i < serverListItems.length; i++) {
                listItem = serverListItems[i];
                jQuery("<p>" + listItem + "</p>").appendTo(listItemsDiv);
            }
        }
        
        function updatePossibility(changedPossibility) {
            var possibilitiesContainer = jQuery("#possibilities");
            var poElement = possibilitiesContainer.find("li[data-PO_ID='" + changedPossibility.id + "']:first");
            poElement.text(changedPossibility.text);
        }
        
        function updatePossibilities(possibilities) {
            if (possibilities === undefined) { return; }
            var possibility;
            var possibilitiesContainer = jQuery("#possibilities");
            possibilitiesContainer.empty();
            for (var i = 0; i < possibilities.length; i++) {
                possibility = possibilities[i];
                jQuery("<li class='ui-state-default possibility' data-PO_ID='" + possibility.id + "' contenteditable='true'>" + possibility.text + "</li>").appendTo(possibilitiesContainer);
            }
        }
        
        jQuery("#btnListItem").click(function() {
            updateCount(jQuery("#listAnswerCount"));
            var listItemInput = jQuery("#listItem");
            var newListItem = listItemInput.val();
            listItemInput.val("");
            socket.emit("laa_add_listItem", { room: roomKey, user: currentUser, listItem: newListItem });
        });
        
        jQuery(document).on("mouseenter", ".possibility", (function() {
            jQuery(this).addClass("editable");
        }));
        
        jQuery(document).on("mouseleave", ".possibility", (function() {
            jQuery(this).removeClass("editable");
        }));
        
        jQuery(document).on("keydown", "li[contenteditable]", (function(e) {
            if (e.keyCode === 13) {
              // insert 2 br tags (if only one br tag is inserted the cursor won't go to the next line)
              document.execCommand('insertHTML', false, '<br /><br />');
              // prevent the default behaviour of return key pressed
              return false;
            }            
        }));
        
        jQuery('body').on('focus', '[contenteditable]', function() {
            var $this = jQuery(this);
            $this.data('before', $this.html());
            return $this;
        }).on('blur', '[contenteditable]', function() {
            var $this = jQuery(this);
            if ($this.data('before') !== $this.html()) {
                $this.data('before', $this.html());
                $this.trigger('change');
            }
            return $this;
        });        
        
        jQuery(document).on("change", "li[contenteditable]", (function() {
            updateCount(jQuery("#POsEditedCount"));
            var possibility = jQuery(this);
            var changedPossibility = {
                id: possibility.data("po_id"),
                text: possibility.html()
            };
            console.log('CHANGE: ' + changedPossibility.text);
            socket.emit("laa_change_possibility", { room: roomKey, user: currentUser, changedPossibility: changedPossibility });
        }));
        
        function savePOs(changedPossibility) {
//            console.log("in savePOs " + allChangedPOs);
            allChangedPOs[allChangedPOs.length] = changedPossibility;
//            console.log("after " + allChangedPOs);
        }
        
        jQuery("#formListAndApply").submit(function() {
            submittedByCurrentUser = true;
            storeChatData(currentUser, chatData);
            storePOs();
            storeListItems();
            storeTimingData();
            socket.emit("laa_form_finish", { room: roomKey, user: currentUser, possibilities: allChangedPOs });
            return true;            
        });
        
        function storePOs() {
            jQuery("#allPOsData").val(JSON.stringify(allChangedPOs));
        }    
        
        function storeListItems() {
            jQuery("#allListItemsData").val(JSON.stringify(listItems));
        }
    });
    <?php include elgg_get_plugins_path()."Core/views/default/Core/myTools/js/chat.php"; ?>
</script>
</div>
