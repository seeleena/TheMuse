var mongojs = require("mongojs");
var util;
var museUtility;

function init(serverUtil, serverMuseUtility) {
    util = serverUtil;
    museUtility = serverMuseUtility;
}

function addListItem(room, user, listItem, callback) {
    getAllListItems(room, function(error, allListItems) {
        if (!error) {
            var listItemObject = {};
            listItemObject.user = user;
            listItemObject.listItem = listItem;
            allListItems.listItems.push(listItemObject);
            setAllListItems(room, allListItems, function(error, savedListItems) {
                callback(error, savedListItems);
            });
        }
        else {
            museUtility.debugVar("Error adding List/listItem", error);
        }
    });
}

function getAllListItems(room, callback) {
    var allListItemsStorageKey = getAllListItemsStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({_id: allListItemsStorageKey}, 
        function (error, allListItems) {
            if (allListItems == undefined) { allListItems = getNewListItems(); }
            callback(error, allListItems);
        }
    );
}

function getAllListItemsStorageKey(room) {
    return "list_allListItems_" + room;
}

function setAllListItems(room, listItems, callback) {
    listItems._id = getAllListItemsStorageKey(room);
    var db = museUtility.getDB();
    db.save(listItems, function(error, savedListItems) {
       if (error) {
           museUtility.debugVar("Error saving List/listItems", error);
       }
       callback(error, savedListItems);
    });
}

function getNewListItems() {
    var allListItems;
    allListItems = {};
    allListItems.listItems = [];
    return allListItems;
}

exports.init = init;
exports.addListItem = addListItem;
exports.getAllListItems = getAllListItems;