/*hey, .js  000*/
function updateChat(serverChatData) {
    if (serverChatData == undefined) {
        serverChatData = [];
    }
    chatData = serverChatData;
    var chatContainer = $("#chat");
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
    var chatDataField = $("#chatData");
    chatData = serverChatData;
    chatDataField.val(JSON.stringify(chatData));
}