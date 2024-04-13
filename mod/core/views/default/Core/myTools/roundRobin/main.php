<?php
$toolID       = $vars['toolID'];
$assignmentID = $vars['assignmentID'];
$stageNum     = $_GET['stageNum'];
$activityID   = $vars['activityID'];
$instructionID = $vars['instructionID'];
$groupID      = $vars['groupID'];
$groupMembers = $vars['groupMembers'];
$nodeServer   = $vars['nodeServer'];
$currentUser  = elgg_get_logged_in_user_entity();
$studentELGGID = $currentUser->guid;
$sessionKey   = $vars['sessionKey'];
$reset        = $_GET['reset'];
?>
<script type="text/javascript" src="<?php echo $nodeServer; ?>/socket.io/socket.io.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>	
<!-- TimeMe -->
<script type="text/javascript" src="<?php echo getElggJSURL()?>timeme/timeme.min.js"></script>
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/timing.js"></script>    
<script type="text/javascript" src="<?php echo getElggJSURL()?>common/toolMetrics.js"></script>   
<?php
$_SESSION['groupID'] = $groupID;
$_SESSION['instructionID'] = $instructionID;
$_SESSION['assignmentID'] = $assignmentID;
$_SESSION['activityID'] = $activityID;

    $data = getGroupSolutionCreativeProcessByTool($groupID, $assignmentID, $activityID, $instructionID, 9);
    if (isset($data) && $reset < 1) {
       ?>
       <div class="elgg-main elgg-body">
            <ul class="elgg-menu elgg-breadcrumbs"><li>Round Robin Discussion Tool</li></ul>
            <div class="elgg-head clearfix">
                <h2 class="elgg-heading-main">Round Robin Discussion is Complete</h2>
            </div>
            <blockquote>
                <p>
                    All group member views/opinions have been entered. See below for the details.
                </p>
            </blockquote>
       <?php
        $decodedData = json_decode($data, TRUE);
        echo "<table class='elgg-table'><tr><th width='20%'>Student</th><th>View</th></tr>";
        foreach ($decodedData as $obj) {
            echo "<tr><td>".$obj['user']."</td>";
            echo "<td>".$obj['view']."</td></tr>";
        }
        echo "</table>";
       ?>
            <br />
            <input type="button" id="btnReset" name="btnReset" value="Reset"/>
            <script>
                jQuery(document).ready(function() {
                    jQuery("#btnReset").click(function() {
                        var confirmed = confirm("This will clear all Opinions/Views. Press OK to continue.");
                        if (confirmed === true) {
                            window.location.search += "&reset=1";
                        }
                    });
                });
            </script>
       </div>
       <?php
    }
    
    else {
?>
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Round Robin Discussion Tool</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Round Robin Discussion</h2>
    </div>
    <blockquote>
        <p>
            You are given one entry to enter your viewpoint in the box on the left. 
            Use the chat box on the right to help you determine what this one statement will be for your current task.
            <b>After all group members have entered their views</b>, click the 'Finish and Save' button 
            so that your input will be stored for assessment purposes. Do not click the 'Finish and Save' button
            if there is still another group member to enter a view. 
        </p>
    </blockquote>

<style>
    .box {
        float: left;
        margin-top: 20px;
    }
    .box .elgg-input-text {

    }
    #memberStatus {
        width: 100%;
    }
    #memberStatus th {
        font-weight: bold;
    }
    #memberStatus td {
        padding: 5px;
        border: 1px solid #cccccc;
        text-align: left;
    }
    #memberStatus td.member {
        width: 25%;
    }
    #memberStatus td.status {
        width: 75%;
    }
    #userViewStatusContainer {
        width: 60%;
    }
    #userViewStatusContainer div.border, #chatContainer div.border {
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
        width: 35%;
    }
    #formFinishContainer {
        width: 300px;
    }
    .border {
        border: 1px solid black;
        padding: 5px;
    }
    
</style>
<h1>
    <?php elgg_echo("title"); ?>
</h1>
<div id="userViewStatusContainer" class="box">
    <h4>Enter Your Opinion/View Below</h4>
    <div class="border">
        <table id="memberStatus" border="1" class="elgg-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($groupMembers as $member) {
                    echo "<tr>";
                    echo "  <td class='member' data-member='" . $member->name . "'>" . $member->name . "</td>";
                    echo "  <td class='status'>Not Started</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div><br/>
    <label for="userView">
        Your View:
    </label>
    <?php
        echo elgg_view('input/text', array('id' => 'userView', 'name' => 'userView'));
    ?>    
</div>
<div id="chatContainer" class="box">
    <h4>Group Chat for Round Robin</h4>
    <div class="border">
        <ul id="chat">
        </ul>
    </div><br/>
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
    $form_body .= elgg_view('input/hidden', array('id' => 'viewsData', 'name' => 'viewsData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'chatData', 'name' => 'chatData'));
    $form_body .= elgg_view('input/hidden', array('id' => 'timeOnPage', 'name' => 'timeOnPage', 'value' => 0));  
    $form_body .= elgg_view('input/hidden', array('id' => 'chatEntriesCount', 'name' => 'chatEntriesCount', 'value' => 0));    
    $form_body .= elgg_view('input/hidden', array('id' => 'viewsEnteredCount', 'name' => 'viewsEnteredCount', 'value' => 0));    
    $form_body .= elgg_view('input/submit', array('value'=>'Finish and Save', 'id' => 'btnFinish'));
    echo elgg_view('input/form', array(
                                    'id' => 'formFinish',
                                    'body' => $form_body,
                                    'action' => 'action/myTools/roundRobin/save',
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
    var userViewsData;
    var started = false;
    var submittedByCurrentUser = false;
    jQuery(document).ready(function() {
        var socket = io.connect('<?php echo $nodeServer; ?>');
        socket.on("connect", function() {
            socket.emit("rr_join_room", { room: roomKey, user: currentUser });
        });
        
        socket.on("acknowledgement", function(data) {
            if (data.messageType === "chat") {
                writeMessage(jQuery("#chat"), data.initiatingUser, data.serverMessage);
                storeChatData(data.initiatingUser, data.chatData);
            }
            else if (data.messageType === "userView") {
                updateAllUserStatuses(data.statuses);
                updateUserView(data.initiatingUser, data.serverMessage);
                storeUserViewsdata(data.statuses);
            }
            else if (data.messageType === "roundRobin_started") {
                updateAllUserStatuses(data.statuses);
                storeUserViewsdata(data.statuses);
                if (!started) {
                    updateChat(data.chatData);                    
                    started = true;
                }
            }
            else if (data.messageType === "rr_form_finished") {
                //alert('form finished back from node');
                if (!submittedByCurrentUser) {
                    window.location.href = location.origin + location.pathname.substring(0, location.pathname.indexOf('/', 1)) + "/Core/myCreativeProcess/activity/" + <?php echo $activityID ?> + "?assignID=" + <?php echo $assignmentID ?> + "&message=" + data.message;
                }
            }
        });
        
        jQuery("#userView").keyup(function(e) {
            if (e.keyCode === ENTER_KEY_CODE) {
                jQuery("#viewsEnteredCount").val(1);
                var userViewMessageBox = jQuery(this);
                var userView = userViewMessageBox.val();
                jQuery(this).val("");
                jQuery(this).prop("disabled", true);
                setUserViewStatus(currentUser, "Completed");
                socket.emit("rr_userView_message", { room: roomKey, user: currentUser, view: userView });
            }
        });
        
        jQuery("#chatMessage").keyup(function(e) {
            if (e.keyCode === ENTER_KEY_CODE) {
                updateCount(jQuery("#chatEntriesCount"));
                var chatMessageBox = jQuery(this);
                var message = chatMessageBox.val();
                jQuery(this).val("");
                storeChatMessage(currentUser, message);
                socket.emit("rr_chat_message", { room: roomKey, user: currentUser, clientMessage: message, chatData: chatData });
            }
        });        
        
        jQuery("#formFinish").submit(function() {
            submittedByCurrentUser = true;
            storeChatData(currentUser, chatData);
            storeTimingData();
            socket.emit("rr_form_finished", { room: roomKey, user: currentUser });
            return true;
        });
        
        jQuery(window).unload(function() {
            console.log('unloading...');
            var timeSpentOnPage = Math.round(TimeMe.getTimeOnCurrentPageInSeconds());
            console.log('time on page: ' + timeSpentOnPage);
            elgg.get('/Core/myTools/storeTimeOnPage/?toolID=<?php echo $toolID ?>&studentID=<?php echo $studentELGGID ?>&groupID=<?php echo $groupID ?>&assignmentID=<?php echo $assignmentID ?>&activityID=<?php echo $activityID ?>&instructionID=<?php echo $instructionID ?>&timeOnPage=' + timeSpentOnPage, {
                success: function(result, success, xhr) {
                    console.log('get success ' + success);
                } 
            });  
            return "Sure?";
        });
    });
    
    function updateUserView(user, view) {
        setUserViewStatus(user, view);
    }
    
    function updateAllUserStatuses(userStatuses) {
        var userStatus;
        for (var i = 0; i < userStatuses.length; i++) {
            userStatus = userStatuses[i];
            if (userStatus.status == "In Progress") {
                setUserViewStatus(userStatus.user, "In Progress");
            }
            else if (userStatus.status == "Completed") {
                setUserViewStatus(userStatus.user, userStatus.view);
            }
            else {
                setUserViewStatus(userStatus.user, "Not Started");
            }
        }
    }
    
    function setUserViewStatus(user, status) {
        jQuery("#memberStatus tr td.member[data-member='" + user + "']").next().html(status);
    }

    function writeMessage(container, user, message) {
        container.append(jQuery("<li>" + user + ": " + message + "</li>"));
        container[0].scrollTop = container[0].scrollHeight;
    }
    
    function updateChat(serverChatData) {
        if (serverChatData == undefined) {
            serverChatData = [];
        }
        chatData = serverChatData;
        var chatContainer = jQuery("#chat");
        for (var i = 0; i < chatData.length; i++) {
            writeMessage(chatContainer, chatData[i].user, chatData[i].message);
        }
    }
    
    function storeChatMessage(user, message) {
        var chatMessage = {
            user: user,
            message: message
        };
        chatData.push(chatMessage);
    }
    
    function storeChatData(user, serverChatData) {
        var chatDataField = jQuery("#chatData");
        chatData = serverChatData;
        chatDataField.val(JSON.stringify(chatData));
    }
    
    function storeUserViewsdata(userViews) {
        userViewsData = userViews;
        jQuery("#viewsData").val(JSON.stringify(userViewsData));
    }
    
</script>
</div>
<?php
     }
?>
