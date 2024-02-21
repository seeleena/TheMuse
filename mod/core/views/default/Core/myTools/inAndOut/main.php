<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>In and Out Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">In and Out</h2>
    </div>
    <blockquote>
        <p>
            This tool requires you to first outline the characteristics or requirements that your solution must have.
            Then using these characteristics/requirements, you must decide which possible solutions (POs)
            do not meet these requirements. You must eventually choose one of your POs as the 
            final solution which you will implement. 
        </p><p>
            You are shown two boxes.
            All the POs you have previously listed and improved upon are displayed in the In box.
        </p><p>
            You are expected to
            select the POs which do not match the set of required characteristics and drag those into the Out box.
            Think about each PO in turn before deciding whether to eliminate it.
            Click "Clear Out" to eliminate all POs from the Out box. You can repeat this process one by one or in batches of POs
            until only one remains in the In box.
       </p><p>
            You can select the "Reset" button to start over from the beginning.
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

$allPossibilities = getPOs($groupID, $assignmentID);
?>

    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <!-- TimeMe -->
    <script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
    <script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
    <script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>   
    <style>
        #poContainer {
            width: 100%;
        }
        #strongerPOs, #weakerPOs {
            border: 1px solid #444444;
            width: 100%;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
            height: 300px;
            overflow: auto;
        }
        #strongerPOs li.possibility, #weakerPOs li.possibility {
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
    #chatContainer div.border {
            border: 1px solid black;
            /*min-height: 50px;*/
            height: 150px;
            overflow: auto;
        }
    #listContainer {
        width: 60%;
        float: left;
    }
    #listContainer div.border{
        border: 1px solid black;
        /*min-height: 50px;*/
        height: 500px;
        overflow: auto;
    }
    #listItems {
        height: 300px;
        border: 1px solid black;
        overflow: auto;
    }
    #chatContainer div.border {
        border: 1px solid black;
        /*min-height: 50px;*/
        height: 100px;
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
    #listInputContainer {
        width: 100%;
        float: left;
    }
    #listInputContainer div.border, #chatContainer div.border {
        border: 1px solid black;
        /*min-height: 50px;*/
        height: 300px;
        overflow: auto;
    }
    input[type="submit"] {
        width: auto;
    }
    #originalPOs {
        display: none;
    }
    
</style>
<ul id="originalPOs" class="">
    <?php foreach ($allPossibilities as $possibility) { ?>
        <li class="originalPO" data-PO_ID="<?php echo $possibility->id?>"><?php echo $possibility->text?></li>
    <?php } ?>
</ul>
<fieldset class="listFields" id="listFields">
    <legend>Enter the characteristics that your solution must have:</legend>
    <textarea id="listItem" class="myTextArea"></textarea>
    <input class="elgg-button" type="button" value="Add" id="btnAddListItem" />
</fieldset><br />
<div id='listContainer' class='box'>
    <div id="listInputContainer">
        <h3>Characteristics/Requirements:</h3>
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
<br />
<hr class="myHr"/>
<br />
<table id="poContainer">
    <tr>
        <td>
            <h3>In</h3>
            <div>Drag possibilities that you will keep here:</div>
        </td>
        <td>
            <h3>Out</h3>
            <div>Drag possibilities that you will throw out here:</div>
        </td>
    </tr>
    <tr>
        <td>
            <ul id="strongerPOs" class="connectedSortable">
                <?php foreach ($allPossibilities as $possibility) { ?>
                    <li class="ui-state-default possibility" data-PO_ID="<?php echo $possibility->id?>"><?php echo $possibility->text?></li>
                <?php } ?>
            </ul>
        </td>
        <td>
            <ul id="weakerPOs" class="connectedSortable"></ul>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <br /><input type="button" id="btnGetOnlyStrongPossibilities" value="Clear 'Out'" class="elgg-button elgg-button-submit" />
            <input type="button" id="btnResetPossibilities" value="Reset Possibilities" class="elgg-button elgg-button-submit" />
        </td>
    </tr>
</table>
<br />
<hr class="myHr"/>
<div id="formFinishContainer" class="box">
    <?php
    $form_body .= elgg_view('input/hidden', array('id' => 'groupID', 'name' => 'groupID', 'value' => $groupID));
    $form_body .= elgg_view('input/hidden', array('id' => 'stageNum', 'name' => 'stageNum', 'value' => $stageNum));
    $form_body .= elgg_view('input/hidden', array('id' => 'activityID', 'name' => 'activityID', 'value' => $activityID));
    $form_body .= elgg_view('input/hidden', array('id' => 'instructionID', 'name' => 'instructionID', 'value' => $instructionID));
    $form_body .= elgg_view('input/hidden', array('id' => 'assignmentID', 'name' => 'assignmentID', 'value' => $assignmentID));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatData', 'name' => 'chatData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'allListItemsData', 'name' => 'allListItemsData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'allPossibilitiesData', 'name' => 'allPossibilitiesData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'addedCharacteristicsCount', 'name' => 'addedCharacteristicsCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'movementsCount', 'name' => 'movementsCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'clearOutClicksCount', 'name' => 'clearOutClicksCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'resetPOsClicksCount', 'name' => 'resetPOsClicksCount', 'value' => 0));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));    
    $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));
    $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnFinishAndSave'));
    echo elgg_view('input/form', array(
                                    'id' => 'formInAndOut',
                                    'body' => $form_body,
                                    'action' => 'action/myTools/inAndOut/save',
                                    'enctype' => 'multipart/form-data',
    ));
    ?>
</div>
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

    $(document).ready(function() {
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            var allPossibilities = getAllInitialPossibilities();
            socket.emit("inAndOut_start", { room: roomKey, user: currentUser, allPossibilities: allPossibilities });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "inAndOut_started") {
                if (!started) {
                    updateListItems(data.listItems);
                    updateChat(data.chatData); 
                    updateAllPossibilities(data.serverPossibilities);
                    started = true;
                }
            }
            else if (data.messageType === "inAndOut_Req_added") {
                updateListItems(data.listItems);
            }
            else if (data.messageType === "chat_message") {
                writeMessage($("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
            else if (data.messageType === "inAndOut_changed") {
                    if (data.user != currentUser) {
                        updateMovedPossibility(data.movedItemPOID, data.previousItemPOID, data.receiverID, data.senderID);
                    }
                    storePossibilities(data.serverPossibilities);
            }
            else if (data.messageType === "inAndOut_filtered") {
                    if (data.user != currentUser) {
                        updateAllPossibilities(data.serverPossibilities);
                        elgg.system_message('Out Possibilities cleared by ' + data.user);
                    }
                    storePossibilities(data.serverPossibilities);
            }
            else if (data.messageType === "inAndOut_possibilities_reset") {
                    if (data.user != currentUser) {
                        updateAllPossibilities(data.originalPossibilities);
                        storePossibilities(data.originalPossibilities);                        
                        elgg.system_message(data.message);
                    }
                    else {
                        elgg.system_message('Possibilities have been reset.');
                    }
            }
            else if (data.messageType == "inAndOut_form_finished") {
                    if (!submittedByCurrentUser) {
                        window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
                    }
            }
//            else if (data.messageType === "list_form_finished") {
//                if (!submittedByCurrentUser) {
//                    window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
//                }
//            }
            else if (data.messageType === "error") {
                alert('An error has occurred: ' + data.message);
            }
        });
        
        function updateListItems(serverListItems) {
            if (serverListItems == undefined) { return; }
            listItems = serverListItems;
            var listItem;
            var listItemsDiv = $("#listItems");
            listItemsDiv.empty();
            for (var i = 0; i < serverListItems.length; i++) {
                listItem = serverListItems[i];
                $("<p>" + listItem.user + ": " + listItem.listItem + "</p>").appendTo(listItemsDiv);
            }
        }
        
        $("#btnAddListItem").click(function() {
            updateCount($("#addedCharacteristicsCount"));
            var listItemInput = $("#listItem");
            var newListItem = listItemInput.val();
            listItemInput.val("");
            socket.emit("inAndOut_add_Req", { room: roomKey, user: currentUser, listItem: newListItem });
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
        
        //should be called by form submit fn        
        function storeListItems() {
            $("#allListItemsData").val(JSON.stringify(listItems));
        }     
        
        ////choice part begins here
        //http://api.jqueryui.com/sortable/#event-receive
            $( "#strongerPOs, #weakerPOs" ).sortable({
                connectWith: ".connectedSortable",
                receive: function(event, ui) {
                    updateCount($("#movementsCount"));
                    var movedItem = $(ui.item[0]);
                    var previousItem = movedItem.prev();
                    var movedItemPOID = movedItem.data("po_id");
                    var previousItemPOID = 0;
                    if (previousItem.is("li")) {
                        previousItemPOID = previousItem.data("po_id");
                    }
                    var receiverID = $(this).attr("id");
                    var senderID = ui.sender.attr("id");
                    socket.emit("inAndOut_change", { 
                        room: roomKey, 
                        user: currentUser, 
                        previousItemPOID: previousItemPOID,
                        movedItemPOID: movedItemPOID,
                        receiverID: receiverID,
                        senderID: senderID
                    });
                }
            }).disableSelection();
            
            function getOriginalPossibilities() {
                var allPossibilities = {};
                allPossibilities.strong = getAllPossibilitiesFromContainer("originalPOs");
                allPossibilities.weak = [];
                return allPossibilities;
            }
            
            function getAllInitialPossibilities() {
                var allPossibilities = {};
                allPossibilities.strong = getAllPossibilitiesFromContainer("strongerPOs");
                allPossibilities.weak = getAllPossibilitiesFromContainer("weakerPOs");
                return allPossibilities;
            }

            function getAllPossibilitiesFromContainer(containerName) {
                var possibilities = [];
                $("#" + containerName).find("li").each(function() { 
                    possibilities.push(getPossibilityFromListItem($(this)));
                });
                return possibilities;
            }

            function getPossibilityFromListItem(listItem) {
                var possibility = {};
                possibility.id = listItem.data("po_id");
                possibility.text = listItem.html();
                return possibility;
            }
            
            function updateAllPossibilities(allPossibilities) {
                $("#strongerPOs li").remove();
                $("#weakerPOs li").remove();
                var possibility;
                for (i = 0; i < allPossibilities.strong.length; i++) {
                    possibility = allPossibilities.strong[i];
                    $("<li class='ui-state-default possibility'>")
                        .attr("data-po_id", possibility.id)
                        .text(possibility.text)
                        .appendTo($("#strongerPOs"));
                }
                for (i = 0; i < allPossibilities.weak.length; i++) {
                    possibility = allPossibilities.weak[i];
                    $("<li class='ui-state-default possibility'>")
                        .attr("data-po_id", possibility.id)
                        .text(possibility.text)
                        .appendTo($("#weakerPOs"));
                }
            }
            
            function updateMovedPossibility(movedItemPOID, previousItemPOID, remoteReceiverID, remoteSenderID) {
                var localReceiver = $("#" + remoteReceiverID);
                var localSender = $("#" + remoteSenderID);
                var localItemToMove = (localSender.find("li[data-po_id='" + movedItemPOID + "']")).remove();
                if (previousItemPOID == 0) {
                    localItemToMove.prependTo(localReceiver);
                }
                else {
                    var previousItem = localReceiver.find("li[data-po_id='" + previousItemPOID + "']");
                    localItemToMove.insertAfter(previousItem);
                }
            }
            
            function storePossibilities(serverPossibilities) {
                $("#allPossibilitiesData").val(JSON.stringify(serverPossibilities));
            }
            
            $("#btnGetOnlyStrongPossibilities").click(function() {
                updateCount($("#clearOutClicksCount"));
                var allPossibilities = {};
                allPossibilities.strong = getAllPossibilitiesFromContainer("strongerPOs");
                allPossibilities.weak = [];
                $("#weakerPOs").empty();
                elgg.system_message('Weaker Possibilities cleared.');
                socket.emit("inAndOut_filter", { room: roomKey, user: currentUser, allPossibilities: allPossibilities });
            });
            
            $("#btnResetPossibilities").click(function() {
                updateCount($("#resetPOsClicksCount"));
                var originalPossibilities = getOriginalPossibilities();
                updateAllPossibilities(originalPossibilities);         
                storePossibilities(originalPossibilities);
                socket.emit("inAndOut_reset_possibilities", { room: roomKey, user: currentUser, originalPossibilities: originalPossibilities });
            });
            
            function storeInAndOutData() {
                
            }
            
            $("#formInAndOut").submit(function() {
                submittedByCurrentUser = true;
                storeChatData(currentUser, chatData);
                storeListItems();
                storeTimingData();
                socket.emit("inAndOut_form_finish", { room: roomKey, user: currentUser });
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
