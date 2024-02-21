var mongojs = require("mongojs");
var util;
var museUtility;

function init(serverUtil, serverMuseUtility) {
    util = serverUtil;
    museUtility = serverMuseUtility;
}

function getUserViewStatuses(room, callback) {
    var userStatusesStorageKey = getUserStatusesStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({_id: userStatusesStorageKey}, 
        function(error, allUserViewStatusesDTO) { 
            if (allUserViewStatusesDTO === undefined || allUserViewStatusesDTO === null) callback(error, allUserViewStatusesDTO);
            else callback(error, allUserViewStatusesDTO.userStatuses);             
        }
    );
}

function getUserStatusesStorageKey(room) {
    return room + "_userStatuses";
}

function getUserViewStatus(userStatuses, user) {
    if (userStatuses == undefined) {
        return null;
    }
    else {
        var userStatus = userStatuses.filter(function(status) {
           return status.user == user; 
        });
        return userStatus;
    }
}

function recordUserViewStatus(room, user, status, view, callback) {
    getUserViewStatuses(room, function(error, userStatuses) {
        if (userStatuses == undefined) userStatuses = new Array();
        //remove from array first
        for (var i = 0; i < userStatuses.length; i++) {
            if (userStatuses[i].user === user) {
                userStatuses.splice(i, 1);
                break;
            }
        }
        var userStatus = { user: user, status: status, view: view };
        userStatuses.push(userStatus);
        setUserViewStatuses(room, userStatuses, function(error, savedUserViewStatuses) {
            callback(error, savedUserViewStatuses);
        });
    });
}

function setUserViewStatuses(room, userStatuses, callback) {
    var userStatusesStorageKey = getUserStatusesStorageKey(room);
    var db = museUtility.getDB();
    var userStatusesDTO = {};
    userStatusesDTO._id = userStatusesStorageKey;
    userStatusesDTO.userStatuses = userStatuses;
    db.save(userStatusesDTO, function(error, savedUserViewStatusesDTO) {
        if (error) {
            museUtility.debugVar("Error saving Round Robin/user statuses", error);
        }
        if (savedUserViewStatusesDTO === undefined || savedUserViewStatusesDTO === null) callback(error, savedUserViewStatusesDTO);
        else callback(error, savedUserViewStatusesDTO.userStatuses);        
    });    
}

exports.init = init;
exports.getUserViewStatuses = getUserViewStatuses;
exports.getUserViewStatus = getUserViewStatus;
exports.recordUserViewStatus = recordUserViewStatus;