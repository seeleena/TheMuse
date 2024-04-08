<?php

function uploadFile($title, $data) {
    $file = new ElggFile();
    $file->subtype = "file";
    
    $file->title = $title;
    $prefix = "file/";
    $filestorename = elgg_strtolower($title);
    $file->setFilename($prefix . $filestorename);
    $file->originalfilename = $title;
    $mime_type = "application/json";
    
    $file->setMimeType($mime_type);
    $file->simpletype = file_get_simple_type($mime_type);
    //we would need to pass in the data of the file, ie, json_encode($assessmentData)
    //$file->write(json_encode($assessmentData)); //->write should be public and available to FilePluginFile since it extends ElggFile
    error_log(json_encode($data));
    
    // Open the file to guarantee the directory exists
    //$file->open("write");
    $file->open("append");
    $file->write(json_encode($data));
    $file->close();

    $file->save();
    $fileGuid = $file->guid;
    
    return $fileGuid;
    
}
?>
