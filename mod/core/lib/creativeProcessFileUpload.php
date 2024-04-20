<?php

/**
 * Upload a file to the Elgg file system.
 *
 * @param string $title The title of the file.
 * @param mixed $data The data to be written to the file.
 * @return int The GUID of the uploaded file.
 */
function uploadFile(string $title, $data): int {
    // Create a new ElggFile object
    $file = new ElggFile();

    // Set the subtype of the file
    $file->subtype = "file";

    // Set the title of the file
    $file->title = $title;

    // Define the prefix for the filename
    $prefix = "file/";

    // Set the filename, converting the title to lowercase
    $filestorename = elgg_strtolower($title);
    $file->setFilename($prefix . $filestorename);

    // Set the original filename
    $file->originalfilename = $title;

    // Define the MIME type of the file
    $mime_type = "application/json";

    // Set the MIME type and simple type of the file
    $file->setMimeType($mime_type);
    $file->simpletype = file_get_simple_type($mime_type);

    // Log the data to be written to the file
    error_log(json_encode($data));

    // Open the file in append mode, write the data to the file, and close the file
    $file->open("append");
    $file->write(json_encode($data));
    $file->close();

    // Save the file and get its GUID
    $file->save();
    $fileGuid = $file->guid;

    // Return the GUID of the uploaded file
    return $fileGuid;
}
?>