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
            if (allListItems == undefined) { allListItems = []; }
            allListItems.push(listItemObject);
            setAllListItems(room, allListItems, function(error, savedListItems) {
                callback(error, savedListItems.listItems);
            });
        }
        else { 
            callback(error, allListItems);
        }
    });
}

function getAllListItems(room, callback) {
    var allListItemsStorageKey = getAllListItemsStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({_id: allListItemsStorageKey}, 
        function(error, allListItemsDTO) {
            if (allListItemsDTO === undefined || allListItemsDTO === null) callback(error, allListItemsDTO);
            else callback(error, allListItemsDTO.listItems); 
        }
    );    
}

function getAllListItemsStorageKey(room) {
    return "inAndOut_allReq" + room;
}

function setAllListItems(room, listItems, callback) {
    //arrays have to be wrapped in an object
    var db = museUtility.getDB();
    var listItemsDTO = {};
    listItemsDTO._id = getAllListItemsStorageKey(room);
    listItemsDTO.listItems = listItems;
    db.save(listItemsDTO, function(error, savedListItems) {
        if (error) {
            museUtility.debugVar("Error saving In and Out/listItems", error);
        }
        callback(error, savedListItems);
    });
}

function recordPossibilities(room, user, allPossibilities, callback) {
    getAllServerPossibilities(room, function(error, serverPossibilities) {
        if (serverPossibilities == undefined) { //if it is defined, then we don't need to do anything
            setAllServerPossibilities(room, allPossibilities, function(error, savedPossibilities) {
                if (!error) {
                    serverPossibilities = savedPossibilities;
                }
                callback(error, serverPossibilities);
            });
        }
        callback(error, serverPossibilities);
    });
}

function getAllServerPossibilities(room, callback) {
    var allPossibilitiesStorageKey = getAllPossibilitiesStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({_id: allPossibilitiesStorageKey}, 
        function(error, allPossibilities) { 
            callback(error, allPossibilities); 
        }
    );    
}

function setAllServerPossibilities(room, allPossibilities, callback) {
    allPossibilities._id = getAllPossibilitiesStorageKey(room);
    var db = museUtility.getDB();
    db.save(allPossibilities, function(error, savedPossibilities) {
        if (error) {
            museUtility.debugVar("Error saving In and Out/allPossibilities", error);
        }
        callback(error, savedPossibilities);
    });
}

function updatePossibilities(room, user, previousItemPOID, movedItemPOID, receiverID, senderID, callback) {
    getAllServerPossibilities(room, function(error, serverPossibilities) {
        var movedItemOriginalIndex;
        if (senderID == "strongerPOs") {
            //get item from source array (remove it!)
            movedItemOriginalIndex = getArrayIndexForKey(serverPossibilities.strong, "id", movedItemPOID);
            var movedItem = serverPossibilities.strong.splice(movedItemOriginalIndex, 1);
            //then splice it into the destination array
            var destinationPreviousItemIndex = getArrayIndexForKey(serverPossibilities.weak, "id", previousItemPOID);
            serverPossibilities.weak.splice(destinationPreviousItemIndex + 1, 0, movedItem[0]);
        }
        else if (senderID == "weakerPOs") {
            movedItemOriginalIndex = getArrayIndexForKey(serverPossibilities.weak, "id", movedItemPOID);
            var movedItem = serverPossibilities.weak.splice(movedItemOriginalIndex, 1);
            var destinationPreviousItemIndex = getArrayIndexForKey(serverPossibilities.strong, "id", previousItemPOID);
            serverPossibilities.strong.splice(destinationPreviousItemIndex + 1, 0, movedItem[0]);
        }
        recordPossibilities(room, user, serverPossibilities, function(error, savedPossibilities) {
            if (error) {
                museUtility.debugVar("Error updating In and Out/possibilities", error);
            }
            callback(error, savedPossibilities);
        });
    });
}

function getAllPossibilitiesStorageKey(room) {
    return "inAndOut_allPossibilities_" + room;
}

function getArrayIndexForKey(arr, key, val){
    for(var i = 0; i < arr.length; i++){
        if(arr[i][key] == val)
            return i;
    }
    return -1;
}

function overwritePossibilities(room, allPossibilities, callback) {
    getAllServerPossibilities(room, function(getError, serverPossibilities) {
        if (!getError) { 
            setAllServerPossibilities(room, allPossibilities, function(setError, savedPossibilities) {
                serverPossibilities = savedPossibilities;
                callback(setError, serverPossibilities);
            });
        }
        else callback(getError, serverPossibilities);
    });
}

function resetPossibilities(room, originalPossibilities, callback) {
    overwritePossibilities(room, originalPossibilities, callback);
}

exports.init = init;
exports.addListItem = addListItem;
exports.getAllListItems = getAllListItems;
exports.recordPossibilities = recordPossibilities;
exports.updatePossibilities = updatePossibilities;
exports.overwritePossibilities = overwritePossibilities;
exports.resetPossibilities = resetPossibilities;