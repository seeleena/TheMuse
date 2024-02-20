var mongojs = require("mongojs");
var util;
var museUtility;

var defaultTree = 
{
    'text' : 'Instruction: Enter Broad Concepts below',
    'state' : {
            'opened' : true,
            'selected' : true,
            'level' : 0
    },
    'children' : [
        { 
            'text' : 'Enter a Broad Concept here',
            'state' : {
                'opened' : true,
                'level' : 1
            },                
            'children' : [
                {
                    'text' : 'Enter a Solution for the above Broad Concept here',
                    'state' : {
                        'level' : 2
                    }
                }
            ]
        }
     ]        
}

function init(serverUtil, serverMuseUtility, room) {
    util = serverUtil;
    museUtility = serverMuseUtility;
    getCurrentConceptFanTree(room, function(error, currentConceptFanTree) {
        if (currentConceptFanTree == undefined) {
            setCurrentConceptFanTree(room, defaultTree);
        }
    });
}

function addPurpose(room, user, purpose, callback) {
    getAllPurposes(room, function (error, allPurposes) {
        
        allPurposes.purposes.push(purpose);
        setAllPurposes(room, allPurposes, function (error, savedPurposes) {
            callback(error, savedPurposes);
        });
    });
}

function getAllPurposes(room, callback) {
    var allPurposesStorageKey = getAllPurposesStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({ _id: allPurposesStorageKey },
    function (error, allPurposes) {
        if (allPurposes == undefined) { allPurposes = getNewPurposes(); }
        callback(error, allPurposes);
    });
}

function getAllPurposesStorageKey(room) {
    return "cf_allPurposes_" + room;
}

function setAllPurposes(room, purposes, callback) {
    purposes._id = getAllPurposesStorageKey(room);
    var db = museUtility.getDB();
    db.save(purposes, function (error, savedPurposes) {
        if (error) {
            museUtility.debugVar("Error saving Concept Fan/purposes", error);
        }
        callback(error, savedPurposes);
    });
}

function addConcept(room, user, concept, callback) {
    getAllConcepts(room, function(error, allConcepts) {
        if (!error) {
            if (allConcepts == undefined || allConcepts.length == 0) { allConcepts = []; }
            allConcepts.push(concept);
            setAllConcepts(room, allConcepts, function(error, newAllConcepts) {
                allConcepts = newAllConcepts;
            });
       } 
       callback(error, allConcepts);
    });
}

function getAllConcepts(room, callback) {
    var allConceptsStorageKey = getAllConceptsStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({_id: allConceptsStorageKey},
        function(error, allConcepts) {
            callback(error, allConcepts);
        }
    );
}

function getAllConceptsStorageKey(room) {
    return "cf_allConcepts_" + room;
}

function setAllConcepts(room, concepts, callback) {
    concepts._id = getAllConceptsStorageKey(room);
    var db = museUtility.getDB();
    db.save(concepts, function (error, savedConcepts) {
        if (error) {
            museUtility.debugVar("Error saving Concept Fan/concepts", error);
        }
        callback(error, savedConcepts);
    });
}

function addSolutionToConcept(room, user, conceptIndex, solution) {
    var allConcepts = getAllConcepts(room);
    allConcepts[conceptIndex].solution = solution;
    setAllConcepts(room, allConcepts);
    return allConcepts;
}

function updateConceptTree(room, user, updatedConceptTree) {
    //we need to persist the tree here and store it in current tree
//    console.log("About to update all concept trees with the following data:\n" + 
//        util.inspect(updatedConceptTree, { showHidden: true, depth: null }));
    setCurrentConceptFanTree(room, updatedConceptTree);
}

function getConceptFanStorageKey(room) {
    return "cf_concept_fan_tree_" + room;
}

function getCurrentConceptFanTree(room, callback) {
    var conceptFanStorageKey = getConceptFanStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({ _id: conceptFanStorageKey },
        function (error, conceptFanDTO) {
            var conceptFan = defaultTree;
            if (conceptFanDTO) { conceptFan = JSON.parse(conceptFanDTO.conceptFan); }
            callback(error, conceptFan);
        }
    );
}

function setCurrentConceptFanTree(room, conceptFanTree) {
    var cfDTO = {};
    cfDTO._id = getConceptFanStorageKey(room);
    var db = museUtility.getDB();
    var cfString = JSON.stringify(conceptFanTree);
    cfDTO.conceptFan = cfString;
    db.save(cfDTO, function(error, savedConceptFanTreeDTO) {
        if (error) {
            museUtility.debugVar("Error saving Concept Fan/conceptFanTree", error);
        } 
    });
}

function getNewPurposes() {
    var allPurposes;
    allPurposes = {};
    allPurposes.purposes = [];
    return allPurposes;
}

exports.init = init;
exports.addPurpose = addPurpose;
exports.getAllPurposes = getAllPurposes;
exports.addConcept = addConcept;
exports.addSolutionToConcept = addSolutionToConcept;
exports.updateConceptTree = updateConceptTree;
exports.getCurrentConceptFanTree = getCurrentConceptFanTree;