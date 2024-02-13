<?php

//////////// Helper Function //////////////
function debug_bind_param(){
    $numargs = func_num_args();
    $numVars = $numargs - 2;
    $arg2 = func_get_arg(1);
    $flagsAr = str_split($arg2);
    $showAr = array();
    for($i=0;$i<$numargs;$i++){
        switch($flagsAr[$i]){
        case 's' :  $showAr[] = "'".func_get_arg($i+2)."'";
        break;
        case 'i' :  $showAr[] = func_get_arg($i+2);
        break;  
        case 'd' :  $showAr[] = func_get_arg($i+2);
        break;  
        case 'b' :  $showAr[] = "'".func_get_arg($i+2)."'";
        break;  
        }
    }
    $query = func_get_arg(0);
    $querysAr = str_split($query);
    $lengthQuery = count($querysAr);
    $j = 0;
    $display = "";
    for($i=0;$i<$lengthQuery;$i++){
        if($querysAr[$i] === '?'){
            $display .= $showAr[$j];
            $j++;   
        }else{
            $display .= $querysAr[$i];
        }
    }
    if($j != $numVars){
        $display = "Mismatch on Variables to Placeholders (?)"; 
    }
    return $display;
}

include elgg_get_plugins_path()."Core/lib/fileUpload.php"; 
//include elgg_get_plugins_path()."Core/lib/dbConnection.php"; 
$mysqli = get_CoreDB_link("mysqli");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$courseCode = get_input('courseCode');
$courseRun = get_input('courseRun');
//$syllabusPath = $_FILES['syllabus']['name'];
//$classListPath = $_FILES['classList']['name'];
$userguid = elgg_get_logged_in_user_guid();

$syllabusFileGuid = uploadFile('syllabus');
$classListFileGuid = uploadFile('classList');

$res = $mysqli->query("UPDATE courserun SET IsArchived='1' WHERE Code='$courseCode'");
$isArchived = 0;
$insert_statement = $mysqli->prepare("INSERT INTO courserun(Instructor_ID, Code, CourseRun, IsArchived, SyllabusPath, ClassListPath) VALUES (?, ?, ?, ?, ?, ?)");
$insert_statement->bind_param('issiii', $userguid, $courseCode, $courseRun, $isArchived, $syllabusFileGuid, $classListFileGuid);
$insert_statement->execute() or die($mysqli->error);
$insert_statement->close();

?>
