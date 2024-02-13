var mongojs = require("mongojs");
var util;
var museUtility;

function init(serverUtil, serverMuseUtility) {
    util = serverUtil;
    museUtility = serverMuseUtility;
}

function recordAllResponses(room, user, userID, answer, citID, callback) {
    //see sample data structure in comments at bottom
    getAllResponses(room, function(error, allResponses) {
        if (!error) {
            //initialize data structure
            if (allResponses == undefined) allResponses = {};
            if (allResponses.groupResponses == undefined || allResponses.groupResponses.length == 0) {
                allResponses.groupResponses = [];
            }    
            var groupResponse;

            //first, take a copy of and remove the relevant groupResponse
            for (var i = 0; i < allResponses.groupResponses.length; i++) {
                if (allResponses.groupResponses[i].citID === citID) {
                    groupResponse = allResponses.groupResponses[i]; //take copy
                    allResponses.groupResponses.splice(i, 1); //delete original
                    break;
                }
            }

            //initialize userResponses array if not set
            if (groupResponse == undefined || groupResponse.length == 0) {
                groupResponse = {};
                groupResponse.userResponses = [];
                groupResponse.citID = citID;
            }

            //add new user response to the array
            var userResponse = { user: user, userID: userID, answer: answer };
            groupResponse.userResponses.push(userResponse);

            //re-add modified groupResponse
            allResponses.groupResponses.push(groupResponse);

            setAllResponses(room, allResponses);
        }
        callback(error, allResponses); 
    });
}

function getAllResponses(room, callback) {
    var allResponsesStorageKey = getAllResponsesStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({_id: allResponsesStorageKey}, 
        function(error, allResponses) { 
            callback(error, allResponses); 
        }
    );
}

function getAllResponsesStorageKey(room) {
    return "ci_allResponses_" + room;
}

function setAllResponses(room, allResponses) {
    ///TODO: If there is an error, it's discarded here. Perhaps there should
    ///be a callback to let the caller know something went on. Perhaps.
    allResponses._id = getAllResponsesStorageKey(room);
    var db = museUtility.getDB();
    db.save(allResponses, function(error, savedResponses) {
        if (error) {
            museUtility.debugVar("Error saving Collaborative Input/allResponses", error);
        }
    });
}

exports.init = init;
exports.getAllResponses = getAllResponses;
exports.recordAllResponses = recordAllResponses;

/*** SAMPLE DATA STRUCTURE FOR ALLRESPONSES ***/
/*
{
	"groupResponses": [
		{
			"userResponses": [{
				"user": "student1",
				"answer": "student1 purpose"
			},
			{
				"user": "student2",
				"answer": "student2 purpose"
			}],
			"citID": 1
		},
		{
			"userResponses": [{
				"user": "student2",
				"answer": "student2 broad"
			},
			{
				"user": "student1",
				"answer": "student1 broad"
			}],
			"citID": 2
		},
		{
			"userResponses": [{
				"user": "student2",
				"answer": "student2 components"
			},
			{
				"user": "student1",
				"answer": "student1 componenets"
			}],
			"citID": 3
		}
	]
}
*/