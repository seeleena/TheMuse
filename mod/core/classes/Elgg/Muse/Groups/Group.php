<?php

//No scuess with adding group info to database yet.  Need to figure out how to get the group info from the elgg object

namespace Elgg\Muse\Groups;
include elgg_get_plugins_path()."Core/lib/dbConnection.php";
include elgg_get_plugins_path()."Core/lib/utilities.php";

/**
 * Handle group related events
 *
 * @since 4.0
 * @internal
 */
class Group {

	/**
	 * Groups created so create an access list for it
	 *
	 * @param \Elgg\Event $event 'create', 'group'
	 *
	 */
	public function store_group_init(\Elgg\Event $event) {
        // Get the group object from the event
        $object = $event->getObject();

        // Get the group name, course code, and assignment ID from the input
        $groupName = get_input('name');
        $course = get_input("courseCode");
        $assignmentID = get_input("assignments");

        // Get the group GUID and user GUID
        $groupGuid = $object->guid;
        $userGUID = elgg_get_logged_in_user_guid();

        // Get the course run ID by the course code
        $courseRunID = getCourseRunByCode($course);

        // Log the group GUID, user GUID, assignment ID, and course run ID
        error_log("in store group in db...".$groupGuid.", ".$userGUID.", ".$assignmentID.", ".$courseRunID);
        
        // Get the mysqli link for the CoreDB
        $mysqli = get_CoreDB_link("mysqli");

        // Prepare the insert statement
        $insert_statement = $mysqli->prepare("INSERT INTO grouplist(GroupELGG_ID, StudentELGG_ID, AssignmentID) VALUES (?, ?, ?)");

        // Bind the group GUID, user GUID, and assignment ID to the insert statement
        $insert_statement->bind_param('iii', $groupGuid, $userGUID, $assignmentID);

        // Execute the insert statement
        $insert_statement->execute();

        // Close the insert statement
        $insert_statement->close();

        // Return
        return;	
    }
	
	
	public function join_group_init(\Elgg\Event $event) {
		// Get the event object
		$params = $event->getObject();
	
		// Extract the group from the event object and get the group ID
		$theGroup = elgg_extract('group', $params);
		$groupID = $theGroup->getGUID();
	
		// Get the owner of the group and the owner's ID
		$owner = $theGroup->getOwnerEntity();
		$ownerID = $owner->getGUID();
	
		// Get the logged in user's ID
		$studentID = elgg_get_logged_in_user_guid();
	
		// Get the assignment ID
		$assignmentID = getAssignmentID($groupID, $ownerID);
	
		// Get the mysqli link for the CoreDB
		$mysqli = get_CoreDB_link("mysqli");
	
		// Prepare the insert statement
		$insert_statement = $mysqli->prepare("INSERT INTO grouplist(GroupELGG_ID, StudentELGG_ID, AssignmentID) VALUES (?, ?, ?)");
	
		// Bind the group ID, student ID, and assignment ID to the insert statement
		$insert_statement->bind_param('iii', $groupID, $studentID, $assignmentID);
	
		// Execute the insert statement
		$insert_statement->execute();
	
		// Close the insert statement
		$insert_statement->close();
	
		// Return
		return;
	}
	
	/**
	 * Perform actions when a user leaves a group
	 *
	 * @param \Elgg\Event $event 'leave', 'group'
	 *
	 */
	public function leave_group_init(\Elgg\Event $event) {
		// Get the event object
		$object = $event->getObject();
	
		// Extract the group from the event object and get the group ID
		$theGroup = elgg_extract('group', $object);
		$groupID = $theGroup->getGUID();
	
		// Get the logged in user's ID
		$studentID = elgg_get_logged_in_user_guid();
	
		// Get the mysqli link for the CoreDB
		$mysqli = get_CoreDB_link("mysqli");
	
		// Prepare the delete statement
		$insert_statement = $mysqli->prepare("DELETE FROM grouplist WHERE GroupELGG_ID = ? AND StudentELGG_ID = ?");
	
		// Bind the group ID and student ID to the delete statement
		$insert_statement->bind_param('ii', $groupID, $studentID);
	
		// Execute the delete statement
		$insert_statement->execute();
	
		// Close the delete statement
		$insert_statement->close();
	
		// Return
		return;
	}
}