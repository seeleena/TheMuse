<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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

    function writeMessage(container, user, message) {
        container.append($("<li>" + user + ": " + message + "</li>"));
        container[0].scrollTop = container[0].scrollHeight;
    }