var mongojs = require("mongojs");
var util;
var museUtility;

function init(serverUtil, serverMuseUtility) {
    util = serverUtil;
    museUtility = serverMuseUtility;
}

function addListItem(room, listItem, callback) {
    getAllListItems(room, function(error, allListItems) {
        if (!error) {
            if (allListItems == undefined) { allListItems = []; }
            allListItems.push(listItem);
            setAllListItems(room, allListItems, function(error, savedListItems) {
                callback(error, savedListItems);
            });
        }
        else {  callback(error, allListItems); }
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
    return "laa_allListItems_" + room;
}

function setAllListItems(room, listItems, callback) {
    //arrays have to be wrapped in an object
    var db = museUtility.getDB();
    var listItemsDTO = {};
    listItemsDTO._id = getAllListItemsStorageKey(room);
    listItemsDTO.listItems = listItems;
    db.save(listItemsDTO, function(error, savedListItemsDTO) {
        if (error) {
            museUtility.debugVar("Error saving List and Apply/listItems", error);
        }
        if (savedListItemsDTO === undefined || savedListItemsDTO === null) callback(error, savedListItemsDTO);
        else callback(error, savedListItemsDTO.listItems);
    });
}

function getAllPossibilitiesStorageKey(room) {
    return "laa_allPOs_" + room;
}

function changePossibility(room, changedPossibility, callback) {
    getAllPossibilities(room, function(getError, allPossibilities) {
        if (!getError) {
            var possibilityToChange = getPossibilityByID(allPossibilities, changedPossibility.id);
            possibilityToChange.text = changedPossibility.text;
            setAllPossibilities(room, allPossibilities, function(setError, savedPossibilities) {
                callback(setError, savedPossibilities);
            });        
        }
        else {
            callback(getError, allPossibilities);
        }
    });
}

function getPossibilityByID(allPossibilities, id) {
    var foundPossibility = allPossibilities.filter(function(po) {
       return po.id == id; 
    });
    return foundPossibility[0];
}

function getAllPossibilities(room, callback) {
    console.log('Calling getAllPossibilities().');
    var allPOsStorageKey = getAllPossibilitiesStorageKey(room);
    museUtility.debugVar("allPOsStorageKey", allPOsStorageKey);
    var db = museUtility.getDB();
    console.log('Going to findOne for ' + allPOsStorageKey);
    db.findOne({_id: allPOsStorageKey}, 
        function(error, allPossibilitiesDTO) {
            if (allPossibilitiesDTO === undefined || allPossibilitiesDTO === null) callback(error, allPossibilitiesDTO);
            else callback(error, allPossibilitiesDTO.possibilities); 
        }
    );      
}

function setAllPossibilities(room, possibilities, callback) {
    console.log("Calling setAllPossibilities().");
    var db = museUtility.getDB();
    var possibilitiesDTO = {};
    possibilitiesDTO._id = getAllPossibilitiesStorageKey(room);
    possibilitiesDTO.possibilities = possibilities;
    db.save(possibilitiesDTO, function(error, savedPossibilitiesDTO) {
        if (error) {
            museUtility.debugVar("Error saving List and Apply/listItems", error);
        }
        if (savedPossibilitiesDTO === undefined || savedPossibilitiesDTO === null) callback(error, savedPossibilitiesDTO);
        else callback(error, savedPossibilitiesDTO.possibilities);
    });    
}

function setAllInitialPossibilities(room, initialPossibilities, callback) {
    console.log('Calling setAllInitialPossibilities().');
    getAllPossibilities(room, function(getError, existingPossibilities) {
        console.log('In callback for getAllPossibilities().');
        museUtility.debugVar("getError", getError);
        museUtility.debugVar("existingPossibilities", existingPossibilities);
        //if (existingPossibilities) museUtility.debugVar("existingPossibilities.length", existingPossibilities.length);
        if (existingPossibilities == undefined || existingPossibilities == null || existingPossibilities.length == 0) {
            console.log("Possibilities not defined or empty. Setting...");
            setAllPossibilities(room, initialPossibilities, function(setError, savedPossibilities) {
                callback(setError, savedPossibilities);
            });                    
        }
        else { 
            callback(getError, existingPossibilities);
        }        
    });
}

function removeAllPossibilities(room, callback) {
//    console.log('Calling removeAllPossibilities()');
//    var db = museUtility.getDB();
//    var ObjectId = mongojs.ObjectId;
//    var allPOsStorageKey = getAllPossibilitiesStorageKey(room);
//    db.remove({_id: allPOsStorageKey}, function(error) {
//        museUtility.debugVar("error", error);
//        callback(error);
//    });
    callback(null);
}

exports.init = init;
exports.addListItem = addListItem;
exports.getAllListItems = getAllListItems;
exports.setAllInitialPossibilities = setAllInitialPossibilities;
exports.removeAllPossibilities = removeAllPossibilities;
exports.changePossibility = changePossibility;