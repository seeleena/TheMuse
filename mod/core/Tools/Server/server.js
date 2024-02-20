var http = require("http");
var url = require("url");
var util = require("util");
var museUtility = require("./museUtility");
var collaborativeInputUtility = require("./collaborativeInput");
var conceptFanUtility = require("./conceptFan");
var choiceTool = require("./choice");
var listUtility = require("./list.js");
var laaUtility = require("./listAndApply.js");
var inAndOutUtility = require("./inAndOutReq.js");
var roundRobinUtility = require("./roundRobin.js");
var io;
var port;

function start(route) {
	function onRequest(request, response) {
		var pathname = url.parse(request.url).pathname;
		route(pathname, request, response);
	}
        port = (process.env.PORT || 8888);
        console.log("Creating server with log level 0 on port:" + port);
        console.log("TheMuseV2 started.");
	io = require("socket.io").listen(http.createServer(onRequest).listen(port));
        io.configure(function() {
            io.set("transports", ["xhr-polling", "websocket"]); 
            io.set("polling duration", 10); 
            io.set('log level', 0);
        });
        
        console.log("About to setup uncaught exception handler...");
        process.on('uncaughtException', function (exception) {
            console.log("Exception: " + exception); 
        });
       
	io.sockets.on("connection", function(socket) {
            console.log('Authenticating user...');
            if (isUserLoggedIn(socket.handshake)) {
                /* START ROUND ROBIN (RR) */
                socket.on("rr_join_room", function(data) {
                    socket.join(data.room);
                    roundRobinUtility.init(util, museUtility);
                    roundRobinUtility.getUserViewStatuses(data.room, 
                        function(error, userStatuses) {
                            getChatData(data.room, function(chatError, chatData) {
                                var userStatus = roundRobinUtility.getUserViewStatus(userStatuses, data.user);
                                if (userStatus == null || userStatus.length == 0 || userStatus.view == "" || userStatus.status == "Not Started") {
                                    roundRobinUtility.recordUserViewStatus(data.room, data.user, "In Progress", "", function(error, savedUsersStatuses) {
                                        io.sockets.in(data.room).emit("acknowledgement", { 
                                            messageType: "roundRobin_started", 
                                            user: data.user, 
                                            statuses: savedUsersStatuses, 
                                            chatData: chatData 
                                        });
                                    });
                                }
                                else {
                                    io.sockets.in(data.room).emit("acknowledgement", { 
                                        messageType: "roundRobin_started", 
                                        user: data.user, 
                                        statuses: userStatuses, 
                                        chatData: chatData 
                                    });                                
                                }                                
                            });
                        }
                    );
                });
                //this is specifically for round robin, it should be 
                //changed to use plain chat_message (the event handler right below this)
                socket.on("rr_chat_message", function(data) {
                    setChatData(data.room, data.chatData, function(error, savedChatData) {
                        io.sockets.in(data.room).emit("acknowledgement", { messageType: "chat", initiatingUser:data.user, serverMessage: data.clientMessage, chatData: savedChatData });
                    });
                });
                socket.on("chat_message", function(data) {
                    museUtility.debugVar("chat_message received", data);
                    setChatData(data.room, data.chatData, function(error, savedChatData) {
                        museUtility.debugVar("callback for set chat_message error", error);
                        museUtility.debugVar("callback for set chat_message saved", savedChatData);
                        io.sockets.in(data.room).emit("acknowledgement", { messageType: "chat_message", initiatingUser:data.user, serverMessage: data.clientMessage, chatData: savedChatData });
                    });
                });
                socket.on("rr_userView_message", function(data) {
                    roundRobinUtility.init(util, museUtility);
                    roundRobinUtility.recordUserViewStatus(data.room, data.user, "Completed", data.view, function(error, userStatuses) {
                        io.sockets.in(data.room).emit("acknowledgement", { messageType: "userView", serverMessage: data.userView, statuses: userStatuses, initiatingUser: data.user });
                    });
                });
                socket.on("rr_store_chats", function(data) {

                });
                socket.on("rr_form_finished", function(data) {
                    io.sockets.in(data.room).emit("acknowledgement", { messageType: "rr_form_finished", message: data.user + " has saved."});
//                    storage.removeItem(getUserStatusesStorageKey(data.room));                        
                });
                /* END ROUND ROBIN (RR) */
                
                /* START REPORT (REPORT) */
                socket.on("report_start", function(data) {
                    socket.join(data.room);
                    getChatData(data.room, function(chatError, chatData) {
                        io.sockets.in(data.room).emit("acknowledgement", { 
                            messageType: "report_started", 
                            user: data.user,
                            chatData: chatData
                        });   
                    });
                });                
                /* END REPORT (REPORT) */
                
                /* START RANDOMWORDGENERATOR (RWG) */
                socket.on("rwg_start", function(data) {
                    socket.join(data.room);
                    getChatData(data.room, function(chatError, chatData) {
                        io.sockets.in(data.room).emit("acknowledgement", { 
                            messageType: "rwg_started", 
                            user: data.user,
                            chatData: chatData
                        });   
                    });
                });                
                /* END REPORT (REPORT) */                

                /* START COLLABORATIVE INPUT (CI) */
                socket.on("ci_start", function(data) {
                    socket.join(data.room);
                    getChatData(data.room, function(chatError, chatData) {
                        collaborativeInputUtility.init(util, museUtility);
                        collaborativeInputUtility.getAllResponses(data.room, function (error, allResponses) {
                            if (error) {
                                museUtility.debugVar(error, "Error retrieving Collaborative Input/AllResponses");
                            }
                            else {
                                io.sockets.in(data.room).emit("acknowledgement", { 
                                    messageType: "ci_started", 
                                    user: data.user,
                                    chatData: chatData,
                                    allResponses: allResponses
                                });   
                            }
                        });                        
                    });
                });

                socket.on("ci_message", function(data) {
                    collaborativeInputUtility.init(util, museUtility);
                    collaborativeInputUtility.recordAllResponses(data.room, data.user, data.userID, data.answer, data.citID, 
                        function (error, allResponses) {
                            if (error) {
                                museUtility.debugVar(error, "Error recording Collaborative Input/AllResponses");
                            }
                            else {
                                io.sockets.in(data.room).emit("acknowledgement", { 
                                    messageType: "ci_message", 
                                    myProp: "ryan",
                                    allResponses: allResponses
                                });                            
                            }  
                        });
                });
                /* END COLLABORATIVE INPUT (CI) */

                /* START CHOICE (CHOICE) */
                socket.on("choice_start", function(data) {
                    socket.join(data.room);
                    choiceTool.init(util, museUtility);
                    //BUG 45: serverPossibilities is screwed up somewhere before the line below. 
                    //serverPossibilities shows the extra array thing in .weak below this comment.
                    choiceTool.recordPossibilities(data.room, data.user, data.allPossibilities, 
                        function(error, serverPossibilities) {
                            if (error) {
                                museUtility.debugVar(error, "Error recording Choice/AllPossibilities");
                            }
                            else {
                                getChatData(data.room, function(chatError, chatData) {
                                    io.sockets.in(data.room).emit("acknowledgement", { 
                                        messageType: "choice_started", 
                                        user: data.user,
                                        chatData: chatData,
                                        serverPossibilities: serverPossibilities
                                    });                                                                    
                                });
                            }
                        }
                    );
                });            

                socket.on("choice_change", function(data) {
                    socket.join(data.room);
                    choiceTool.init(util, museUtility);
                    var serverPossibilities = choiceTool.updatePossibilities(data.room, data.user, data.previousItemPOID, data.movedItemPOID, data.receiverID, data.senderID);
                    io.sockets.in(data.room).emit("acknowledgement", { 
                        messageType: "choice_changed", 
                        user: data.user,
                        previousItemPOID: data.previousItemPOID,
                        movedItemPOID: data.movedItemPOID,
                        receiverID: data.receiverID,
                        senderID: data.senderID,
                        serverPossibilities: serverPossibilities
                    });
                });     

                socket.on("choice_filter", function(data) {
                    socket.join(data.room);
                    choiceTool.init(util, museUtility);
//                    var serverPossibilities = choiceTool.overwritePossibilities(data.room, data.allPossibilities);
                    choiceTool.overwritePossibilities(data.room, data.allPossibilities, function(error, storedPossibilities) {
                        if (error) museUtility.debugVar(error, "Error retrieving overwriting possibilities/choice_filter");
                        io.sockets.in(data.room).emit("acknowledgement", { 
                            messageType: "choice_filtered", 
                            user: data.user,
                            serverPossibilities: storedPossibilities
                        });                        
                    });
                }); 
                
                socket.on("choice_reset_possibilities", function(data) {
                    choiceTool.init(util, museUtility);
                    choiceTool.resetPossibilities(data.room, data.originalPossibilities);
                    io.sockets.in(data.room).emit("acknowledgement", { 
                        messageType: "choice_possibilities_reset", 
                        message: "Possibilities reset by " + data.user,
                        user: data.user,
                        originalPossibilities: data.originalPossibilities
                    });
                });                 

                socket.on("choice_form_finish", function(data) {
                    io.sockets.in(data.room).emit("acknowledgement", { messageType: "choice_form_finished", message: data.user + " has saved."});
                });            

                /* END CHOICE (CHOICE) */

                /* START CONCEPT FAN (CF) */
                socket.on("cf_start", function(data) {
                    socket.join(data.room);
                    getChatData(data.room, function(chatError, chatData) {
                        conceptFanUtility.init(util, museUtility, data.room);
                        conceptFanUtility.getAllPurposes(data.room, function (error, allPurposes) {
                            conceptFanUtility.getCurrentConceptFanTree(data.room, function (error, conceptFan) {
                                io.sockets.in(data.room).emit("acknowledgement", {
                                    messageType: "cf_started",
                                    user: data.user,
                                    chatData: chatData,
                                    purposes: allPurposes.purposes,
                                    conceptFan: conceptFan
                                });                            
                            });
                        });                        
                    });
                });

                socket.on("cf_add_purpose", function(data) {
                    conceptFanUtility.init(util, museUtility, data.room);
                    conceptFanUtility.addPurpose(data.room, data.user, data.purpose, function (error, allPurposes) {
                        conceptFanUtility.getCurrentConceptFanTree(data.room, function (error, conceptFan) {
                            io.sockets.in(data.room).emit("acknowledgement", {
                                messageType: "cf_purpose_added",
                                purposes: allPurposes.purposes,
                                updatedTreeData: conceptFan
                            });
                        });
                    });
                });

                socket.on("cf_add_concept", function(data) {
                   conceptFanUtility.init(util, museUtility, data.room);
                   conceptFanUtility.addConcept(data.room, data.user, data.concept, function (error, allConcepts) {
                        io.sockets.in(data.room).emit("acknowledgement", { 
                             messageType: "cf_concept_added", 
                             concepts: allConcepts
                         });
                   });
                });

                socket.on("cf_add_solution", function(data) {
                   conceptFanUtility.init(util, museUtility, data.room);
                   var concepts = conceptFanUtility.addSolutionToConcept(data.room, data.user, data.conceptIndex, data.solution);
                   io.sockets.in(data.room).emit("acknowledgement", { 
                        messageType: "cf_solution_added", 
                        concepts: concepts
                    });
                });

                socket.on("cf_update_concept_tree", function(data) {
                    conceptFanUtility.init(util, museUtility, data.room);
                    conceptFanUtility.updateConceptTree(data.room, data.user, data.updatedTreeData);
                    io.sockets.in(data.room).emit("acknowledgement", { 
                        messageType: "cf_concept_tree_updated", 
                        updatedTreeData: data.updatedTreeData,
                        updatedBy: data.user
                    });
                });

                socket.on("cf_form_finish", function(data) {
                    io.sockets.in(data.room).emit("acknowledgement", { messageType: "cf_form_finished", message: data.user + " has saved."});
                });

                /* END CONCEPT FAN (CF) */            

                /* START LIST (LIST) */
                socket.on("list_start", function(data) {
                    socket.join(data.room);
                    getChatData(data.room, function(chatError, chatData) {
                        listUtility.init(util, museUtility);
                        listUtility.getAllListItems(data.room, function(error, allListItems) {
                            if (error) {
                                museUtility.debugVar(error, "Error retrieving List/allListItems");
                            }
                            else {
                                io.sockets.in(data.room).emit("acknowledgement", { 
                                    messageType: "list_started", 
                                    user: data.user,
                                    chatData: chatData,
                                    listItems: allListItems.listItems
                                });                            
                            }
                        });                        
                    });
                });

                socket.on("list_add_listItem", function(data) {
                    listUtility.init(util, museUtility);
                    listUtility.addListItem(data.room, data.user, data.listItem, function(error, allListItems) {
                        if (error) {
                            museUtility.debugVar(error, "Error adding List/addListItem");
                        } 
                        else {
                            io.sockets.in(data.room).emit("acknowledgement", { 
                                messageType: "list_listItem_added", 
                                listItems: allListItems.listItems
                            });                           
                        }
                    });
                });

                socket.on("list_form_finish", function(data) {
                    io.sockets.in(data.room).emit("acknowledgement", { messageType: "list_form_finished", message: data.user + " has saved."});
                });            
                /* END LIST (LIST) */ 

                /* START LIST AND APPLY (LAA) */
                socket.on("laa_start", function(data) {
                    socket.join(data.room);
                    laaUtility.init(util, museUtility);
                    laaUtility.setAllInitialPossibilities(data.room, data.initialPossibilities, 
                        function(error, possibilities) {
                            getChatData(data.room, function(chatError, chatData) {
                                io.sockets.in(data.room).emit("acknowledgement", { 
                                    messageType: "laa_started", 
                                    user: data.user,
                                    chatData: chatData,
                                    possibilities: possibilities
                                });                                                            
                            });
                        }
                    );
                });
                
                socket.on("laa_resave_possibilities", function(data){
                    laaUtility.init(util, museUtility);
                    laaUtility.setAllInitialPossibilities(data.room, data.possibilities, 
                        function(error, possibilities) {
                            getChatData(data.room, function(chatError, chatData) {
                                io.sockets.in(data.room).emit("acknowledgement", { 
                                    messageType: "laa_possibilities_resaved", 
                                    user: data.user,
                                    chatData: chatData,
                                    possibilities: possibilities
                                });                                                            
                            });
                        }
                    );                    
                });

                socket.on("laa_add_listItem", function(data) {
                    laaUtility.init(util, museUtility);
                    laaUtility.addListItem(data.room, data.listItem, 
                        function(error, listItems) {
                            io.sockets.in(data.room).emit("acknowledgement", { 
                                messageType: "laa_listItem_added", 
                                listItems: listItems
                            });                        
                        }
                    );
                });
                
                socket.on("laa_change_possibility", function(data) {
                    laaUtility.init(util, museUtility);
                    laaUtility.changePossibility(data.room, data.changedPossibility, 
                        function(error, savedPossibilities) {
                            io.sockets.in(data.room).emit("acknowledgement", { 
                                messageType: "laa_possibility_changed", 
                                changedPossibility: data.changedPossibility
                            });                                                
                        }
                    );
                });
                
                socket.on("laa_form_finish", function(data) {
                    laaUtility.removeAllPossibilities(data.room, function(error) {
                        if (error) {
                            console.log("LAA: An error occured while removing the possibilities." + error);
                        }
                        io.sockets.in(data.room).emit("acknowledgement", { 
                            messageType: "laa_form_finished", 
                            message: data.user + " has saved.",
                            possibilities: data.possibilities
                        });                        
                    });
                });
                /* END LIST AND APPLY (LAA) */
                
                /* START IN AND OUT (inAndOut) */
                socket.on("inAndOut_start", function(data) {
                    socket.join(data.room);
                    getChatData(data.room, function(chatError, chatData) {
                        inAndOutUtility.init(util, museUtility);
                        inAndOutUtility.getAllListItems(data.room, function(error, listItems) {
                            inAndOutUtility.recordPossibilities(data.room, data.user, data.allPossibilities, function(error, serverPossibilities) {
                                io.sockets.in(data.room).emit("acknowledgement", { 
                                    messageType: "inAndOut_started", 
                                    user: data.user,
                                    chatData: chatData,
                                    listItems: listItems,
                                    serverPossibilities: serverPossibilities
                                });                                
                            });
                        });                        
                    });
                });

                socket.on("inAndOut_add_Req", function(data) {
                    inAndOutUtility.init(util, museUtility);
                    inAndOutUtility.addListItem(data.room, data.user, data.listItem, function(error, listItems) {
                        io.sockets.in(data.room).emit("acknowledgement", { 
                            messageType: "inAndOut_Req_added", 
                            listItems: listItems
                        });                        
                    });
                });
                
                socket.on("inAndOut_change", function(data) {
                    inAndOutUtility.init(util, museUtility);
                    socket.join(data.room);
                    inAndOutUtility.updatePossibilities(data.room, data.user, data.previousItemPOID, data.movedItemPOID, data.receiverID, data.senderID, 
                        function(error, serverPossibilities) {
                            io.sockets.in(data.room).emit("acknowledgement", { 
                                messageType: "inAndOut_changed", 
                                user: data.user,
                                previousItemPOID: data.previousItemPOID,
                                movedItemPOID: data.movedItemPOID,
                                receiverID: data.receiverID,
                                senderID: data.senderID,
                                serverPossibilities: serverPossibilities
                            });
                        }
                    );
                }); 
                
                socket.on("inAndOut_filter", function(data) {
                    inAndOutUtility.init(util, museUtility);
                    socket.join(data.room);
                    inAndOutUtility.overwritePossibilities(data.room, data.allPossibilities, function(error, serverPossibilities) {
                        io.sockets.in(data.room).emit("acknowledgement", { 
                            messageType: "inAndOut_filtered", 
                            user: data.user,
                            serverPossibilities: serverPossibilities
                        });                        
                    });
                }); 
                
                socket.on("inAndOut_reset_possibilities", function(data) {
                    inAndOutUtility.init(util, museUtility);
                    inAndOutUtility.resetPossibilities(data.room, data.originalPossibilities, function(error, savedPossibilities) {
                        io.sockets.in(data.room).emit("acknowledgement", { 
                            messageType: "inAndOut_possibilities_reset", 
                            message: "Possibilities reset by " + data.user,
                            user: data.user,
                            originalPossibilities: data.originalPossibilities
                        });                        
                    });
                });
                
                
                socket.on("inAndOut_form_finish", function(data) {
                    io.sockets.in(data.room).emit("acknowledgement", { messageType: "inAndOut_form_finished", message: data.user + " has saved."});
                });            
                /* END IN AND OUT (inAndOut) */
            }
            else {
                socket.emit("acknowledgement", { 
                    messageType: "error", 
                    message: "You are not logged in - try logging in to The Muse again."
                });                
            }
	});
	console.log("Server started.");
}

function isUserLoggedIn(request) {
    if (request.headers.host.toUpperCase().indexOf("LOCALHOST") > -1) {
        console.log('Running locally, not bothering with cookies.');
        return true;
    }
    else {
        console.log('Running on production. Let us check this...');
        if (request.headers.cookie && request.headers.cookie.length > 0) {
            var cookies = request.headers.cookie.split(';');
            for (i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].split('=');
                var cookieKey = cookie[0];
                var indexOf = cookieKey.indexOf("elggmuseuser");
                if (indexOf >= 0) {
                    var cookieValue = cookie[1];
                    var valueLength = cookieValue.length;
                    if (valueLength > 0) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    console.log('Examined: [' + cookie[0] + '] and found that it is not the right one.');
                }
            }
            console.log('Cookies are null.');
            return false;
        }
        console.log('Request.headers.cookie is null.');
        return false;
    }
}

function getChatsStorageKey(room) {
    return room + "_chats";
}

function setChatData(room, chatData, callback) {
    var chatDataDTO = {};
    chatDataDTO._id = getChatsStorageKey(room);
    chatDataDTO.chatData = chatData;
    var db = museUtility.getDB();
    db.save(chatDataDTO, function(error, savedChatDataDTO) {
        if (error) {
            museUtility.debugVar("Error saving Chat/chatData", error);
        }
        if (savedChatDataDTO === undefined || savedChatDataDTO === null) callback(error, savedChatDataDTO);
        else callback(error, savedChatDataDTO.chatData);
    });    
}

function getChatData(room, callback) {
    var chatDataStorageKey = getChatsStorageKey(room);
    var db = museUtility.getDB();
    db.findOne({_id: chatDataStorageKey}, 
        function(error, storedChatDataDTO) {
            if (storedChatDataDTO === undefined || storedChatDataDTO === null) callback(error, storedChatDataDTO);
            else callback(error, storedChatDataDTO.chatData);
        }
    );          
}

function debugVar(name, value) {
    console.log("\n" + name + ":" + util.inspect(value, { showHidden: true, depth: null }) + "\n");   
}

exports.start = start;

//console.log("about to broadcast from message: " + util.inspect(userStatuses, { showHidden: true, depth: null }));
