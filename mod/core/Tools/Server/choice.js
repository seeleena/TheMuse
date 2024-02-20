var mongojs = require("mongojs");
var util;
var museUtility;
//testing

function init(serverUtil, serverMuseUtility) {
    util = serverUtil;
    museUtility = serverMuseUtility;
}

function recordPossibilities(room, user, allPossibilities, callback) {
    getAllServerPossibilities(room, function(error, serverPossibilities) {
        if (!error) {
            if (serverPossibilities == undefined) { //if it is defined, then we don't need to do anything
                setAllServerPossibilities(room, allPossibilities);
                serverPossibilities = allPossibilities;
            }            
        }
    });
}

function overwritePossibilities(room, allPossibilities, callback) {
    getAllServerPossibilities(room, function(error, serverPossibilities) {
        if (!error) {
            setAllServerPossibilities(room, allPossibilities);
        }
        if (typeof(callback) === typeof(Function)) callback(error, allPossibilities);
    });
}

function resetPossibilities(room, originalPossibilities) {
    overwritePossibilities(room, originalPossibilities);
}

function updatePossibilities(room, user, previousItemPOID, movedItemPOID, receiverID, senderID) {
    getAllServerPossibilities(room, function(error, serverPossibilities) {
        var movedItemOriginalIndex;
        //PROPER ORDER NOT BEING STORED, FOR SOME REASON
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
        recordPossibilities(room, user, serverPossibilities);
        return serverPossibilities;        
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

function setAllServerPossibilities(room, allPossibilities) {
    allPossibilities._id = getAllPossibilitiesStorageKey(room);
    var db = museUtility.getDB();
    db.save(allPossibilities, function(error, savedResponses) {
        if (error) {
            museUtility.debugVar("Error saving Choice/allPossibilities", error);
        }
    });    
}

function getAllPossibilitiesStorageKey(room) {
    return "choice_allPossibilities_" + room;
}

function getArrayIndexForKey(arr, key, val){
    for(var i = 0; i < arr.length; i++){
        if(arr[i][key] == val)
            return i;
    }
    return -1;
}

exports.init = init;
exports.overwritePossibilities = overwritePossibilities;
exports.recordPossibilities = recordPossibilities;
exports.updatePossibilities = updatePossibilities;
exports.resetPossibilities = resetPossibilities;