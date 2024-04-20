<?php

// Define a helper function for debugging bind_param calls
function debug_bind_param(){
    // Get the number of arguments passed to the function
    $numargs = func_num_args();
    // Calculate the number of variables by subtracting 2 from the total number of arguments
    $numVars = $numargs - 2;
    // Get the second argument, which is the string of types
    $arg2 = func_get_arg(1);
    // Split the string of types into an array of characters
    $flagsAr = str_split($arg2);
    // Initialize an array to hold the values to be shown
    $showAr = array();
    // Loop through each argument
    for($i=0;$i<$numargs;$i++){
        // Switch on the type of the argument
        switch($flagsAr[$i]){
        case 's' :  // If it's a string, add it to the array with quotes around it
            $showAr[] = "'".func_get_arg($i+2)."'";
            break;
        case 'i' :  // If it's an integer, add it to the array as is
            $showAr[] = func_get_arg($i+2);
            break;  
        case 'd' :  // If it's a double, add it to the array as is
            $showAr[] = func_get_arg($i+2);
            break;  
        case 'b' :  // If it's a blob, add it to the array with quotes around it
            $showAr[] = "'".func_get_arg($i+2)."'";
            break;  
        }
    }
    // Get the first argument, which is the query
    $query = func_get_arg(0);
    // Split the query into an array of characters
    $querysAr = str_split($query);
    // Get the length of the query
    $lengthQuery = count($querysAr);
    // Initialize a counter for the variables
    $j = 0;
    // Initialize a string to hold the display
    $display = "";
    // Loop through each character in the query
    for($i=0;$i<$lengthQuery;$i++){
        // If the character is a placeholder
        if($querysAr[$i] === '?'){
            // Replace it with the corresponding variable and increment the counter
            $display .= $showAr[$j];
            $j++;   
        }else{
            // If it's not a placeholder, add it to the display as is
            $display .= $querysAr[$i];
        }
    }
    // If the number of variables doesn't match the number of placeholders, set the display to an error message
    if($j != $numVars){
        $display = "Mismatch on Variables to Placeholders (?)"; 
    }
    // Return the display
    return $display;
}

// Include the file upload and database connection libraries
include elgg_get_plugins_path()."Core/lib/fileUpload.php"; 
include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 

// Get a connection to the database
$mysqli = get_CoreDB_link("mysqli");

// If there was an error connecting to the database, return an error response
if ($mysqli->connect_errno) {
    return elgg_error_response(elgg_echo("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error));
}

// Get the course code and run from the input
$courseCode = get_input('courseCode');
$courseRun = get_input('courseRun');

// Get the logged in user's GUID
$userguid = elgg_get_logged_in_user_guid();

// Upload the syllabus and class list files and get their GUIDs
$syllabusFileGuid = uploadFile('syllabus');
$classListFileGuid = uploadFile('classList');

// If any of the fields are empty, return an error response
if (empty($courseCode) || empty($courseRun) || empty($syllabusFileGuid) || empty($classListFileGuid)) {
    return elgg_error_response(elgg_echo("All fields are required."));
}

// Archive the current course run
$res = $mysqli->query("UPDATE courserun SET IsArchived='1' WHERE Code='$courseCode'");

// Initialize the IsArchived flag as 0
$isArchived = 0;

// Prepare an insert statement to add the new course run to the database
$insert_statement = $mysqli->prepare("INSERT INTO courserun(Instructor_ID, Code, CourseRun, IsArchived, SyllabusPath, ClassListPath) VALUES (?, ?, ?, ?, ?, ?)");

// Bind the user GUID, course code, course run, IsArchived flag, and file GUIDs to the insert statement and execute it
$insert_statement->bind_param('issiii', $userguid, $courseCode, $courseRun, $isArchived, $syllabusFileGuid, $classListFileGuid);
$insert_statement->execute() or die($mysqli->error);

// Close the insert statement
$insert_statement->close();

// Return a success response
return elgg_ok_response('', elgg_echo($courseCode . ' has been added as running'), null);

?>

