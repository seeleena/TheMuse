<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Choice Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Choice</h2>
    </div>
    <blockquote>
        <p>
            This tool helps you to choose one of your possible solutions (POs) as the 
            final solution which you will implement. 
        </p><p>
            You are shown two boxes.
            All the POs you have previously listed are displayed in the Stronger box.
        </p><p>
            You are expected to
            select the weaker POs iteratively by looking at all POs displayed in the Stronger box.
            Think about each and drag the weaker solutions to the Weaker box.  
            Click "Clear Weaker" to eliminate your weaker solutions and 
            start again, thinking about each of the POs from the Stronger box and 
            dragging the weaker solutions to the Weaker box.
       </p><p>
            Select "Finish and Save" to close the tool and save your work.
        </p>
    </blockquote>
<?php
$assignmentID  = $vars['assignmentID'];
$activityID    = $vars['activityID'];
$stageNum      = $_GET['stageNum'];
$instructionID = $vars['instructionID'];
$groupID       = $vars['groupID'];
$groupMembers  = $vars['groupMembers'];
$toolID        = $vars['toolID'];
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
        .elgg-main {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            
    }
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
        #originalPOs {
            display: none;
        }
        #chatContainer div.border {
            border: 1px solid black;
            height: 150px;
            overflow: auto;
        }
        
    </style>
    <ul id="originalPOs" class="">
        <?php foreach ($allPossibilities as $possibility) { ?>
            <li class="originalPO" data-PO_ID="<?php echo $possibility->id?>"><?php echo $possibility->text?></li>
        <?php } ?>
    </ul>
    <table id="poContainer">
        <tr>
            <td>
                <h3>Stronger</h3>
                <div>Drag stronger possibilities here</div>
            </td>
            <td>
                <h3>Weaker</h3>
                <div>Drag weaker possibilities here</div>
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
                <br /><input type="button" id="btnGetOnlyStrongPossibilities" value="Clear Weaker" class="elgg-button elgg-button-submit" />
                <input type="button" id="btnResetPossibilities" value="Reset Possibilities" class="elgg-button elgg-button-submit" />
            </td>
        </tr>
    </table>
    <br />
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
        $form_body .= elgg_view('input/hidden', array('id' => 'allPossibilitiesData', 'name' => 'allPossibilitiesData'));
        $form_body .= elgg_view('input/hidden', array('id' => 'clearWeakerCount', 'name' => 'clearWeakerCount', 'value' => 0));
        $form_body .= elgg_view('input/hidden', array('id' => 'resetPOsCount', 'name' => 'resetPOsCount', 'value' => 0));
        $form_body .= elgg_view('input/hidden', array('id' => 'movementsCount', 'name' => 'movementsCount', 'value' => 0));
        $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));    
        $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));        
        $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnFinishAndSave'));
        echo elgg_view('input/form', array(
                                        'id' => 'formChoice',
                                        'body' => $form_body,
                                        'action' => 'action/myTools/choice/save',
                                        'enctype' => 'multipart/form-data',
        ));
        ?>
    </div>  
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>  
    <script type="text/javascript" src="<?php echo $nodeServer; ?>/socket.io/socket.io.js"></script>    
    <script type="text/javascript">
        var ENTER_KEY_CODE = 13;
        var currentUser = "<?php echo $currentUser->name; ?>";
        var roomKey = "<?php echo $sessionKey; ?>";
        var chatData = [];
        var allResponses = [];
        var started = false;
        var submittedByCurrentUser = false;        
        jQuery(document).ready(function() {
            var socket = io.connect('<?php echo $nodeServer; ?>');
            socket.on("connect", function() {
                var allPossibilities = getAllInitialPossibilities();
                socket.emit("choice_start", { room: roomKey, user: currentUser, allPossibilities: allPossibilities });
            });

            socket.on("acknowledgement", function(data) {
                if (data.messageType === "choice_started") {
                    if (!started) {
                        updateChat(data.chatData); 
                        updateAllPossibilities(data.serverPossibilities);
                        started = true;
                    }
                }
                else if (data.messageType === "chat_message") {
                    writeMessage(jQuery("#chat"), data.initiatingUser, data.serverMessage);
                    storeChatData(data.initiatingUser, data.chatData);
                }
                else if (data.messageType === "choice_changed") {
                    if (data.user != currentUser) {
                        updateMovedPossibility(data.movedItemPOID, data.previousItemPOID, data.receiverID, data.senderID);
                    }
                    storePossibilities(data.serverPossibilities);
                }
                else if (data.messageType === "choice_filtered") {
                    if (data.user != currentUser) {
                        updateAllPossibilities(data.serverPossibilities);
                        elgg.system_message('Weaker Possibilities cleared by ' + data.user);
                    }
                    storePossibilities(data.serverPossibilities);
                }
                else if (data.messageType === "choice_possibilities_reset") {
                    if (data.user != currentUser) {
                        updateAllPossibilities(data.originalPossibilities);
                        storePossibilities(data.originalPossibilities);                        
                        elgg.system_message(data.message);
                    }
                    else {
                        elgg.system_message('Possibilities have been reset.');
                    }
                }
                else if (data.messageType == "choice_form_finished") {
                    if (!submittedByCurrentUser) {
                        window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
                    }
                }
            });            
            
            jQuery( "#chatMessage").keyup(function(e) {
                if (e.keyCode === ENTER_KEY_CODE) {
                    updateCount(jQuery("#chatEntriesCount"));
                    var chatMessageBox = jQuery(this);
                    var message = chatMessageBox.val();
                    chatMessageBox.val("");
                    storeChatMessage(currentUser, message);
                    socket.emit("chat_message", { room: roomKey, user: currentUser, clientMessage: message, chatData: chatData });
                }
            });            
            
            //http://api.jqueryui.com/sortable/#event-receive
            jQuery( "#strongerPOs, #weakerPOs" ).sortable({
                connectWith: ".connectedSortable",
                receive: function(event, ui) {
                    updateCount(jQuery("#movementsCount"));
                    var movedItem = jQuery(ui.item[0]);
                    var previousItem = movedItem.prev();
                    var movedItemPOID = movedItem.data("po_id");
                    var previousItemPOID = 0;
                    if (previousItem.is("li")) {
                        previousItemPOID = previousItem.data("po_id");
                    }
                    var receiverID = jQuery(this).attr("id");
                    var senderID = ui.sender.attr("id");
                    socket.emit("choice_change", { 
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
                jQuery("#" + containerName).find("li").each(function() { 
                    possibilities.push(getPossibilityFromListItem(jQuery(this)));
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
                jQuery("#strongerPOs li").remove();
                jQuery("#weakerPOs li").remove();
                var possibility;
                for (i = 0; i < allPossibilities.strong.length; i++) {
                    possibility = allPossibilities.strong[i];
                    jQuery("<li class='ui-state-default possibility'>")
                        .attr("data-po_id", possibility.id)
                        .text(possibility.text)
                        .appendTo(jQuery("#strongerPOs"));
                }
                for (i = 0; i < allPossibilities.weak.length; i++) {
                    possibility = allPossibilities.weak[i];
                    jQuery("<li class='ui-state-default possibility'>")
                        .attr("data-po_id", possibility.id)
                        .text(possibility.text)
                        .appendTo(jQuery("#weakerPOs"));
                }
            }

            function updateMovedPossibility(movedItemPOID, previousItemPOID, remoteReceiverID, remoteSenderID) {
                var localReceiver = jQuery("#" + remoteReceiverID);
                var localSender = jQuery("#" + remoteSenderID);
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
                jQuery("#allPossibilitiesData").val(JSON.stringify(serverPossibilities));
            }
            
            jQuery("#btnGetOnlyStrongPossibilities").click(function() {
                updateCount(jQuery("#clearWeakerCount"));
                var allPossibilities = {};
                allPossibilities.strong = getAllPossibilitiesFromContainer("strongerPOs");
                allPossibilities.weak = [];
                jQuery("#weakerPOs").empty();
                elgg.system_message('Weaker Possibilities cleared.');
                socket.emit("choice_filter", { room: roomKey, user: currentUser, allPossibilities: allPossibilities });
            });
            
            jQuery("#btnResetPossibilities").click(function() {
                updateCount(jQuery("#resetPOsCount"));
                var originalPossibilities = getOriginalPossibilities();
                updateAllPossibilities(originalPossibilities);         
                storePossibilities(originalPossibilities);
                socket.emit("choice_reset_possibilities", { room: roomKey, user: currentUser, originalPossibilities: originalPossibilities });
            });
            
            jQuery("#formChoice").submit(function() {
                submittedByCurrentUser = true;
                storeChatData(currentUser, chatData);
                storeTimingData();
                socket.emit("choice_form_finish", { room: roomKey, user: currentUser });
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
