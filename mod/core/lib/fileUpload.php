<?php

/**
 * Get the simple type of a file based on its MIME type.
 *
 * @param string $mime_type The MIME type of the file.
 * @return string The simple type of the file.
 */
function get_simple_type(string $mime_type): string {
    // Determine the simple type based on the MIME type
    switch ($mime_type) {
        case 'image/jpeg':
        case 'image/png':
        case 'image/gif':
            return 'image';
        case 'text/plain':
            return 'document';
        // Add more cases as needed...
        default:
            return 'unknown';
    }
}

/**
 * Upload a file to the Elgg file system.
 *
 * @param string $title The title of the file.
 * @return mixed The response from the upload process.
 */
function uploadFile(string $title) {
    // Check if the upload failed
    if (!empty($_FILES[$title]['name']) && $_FILES[$title]['error'] != 0) {
        return elgg_error_response(elgg_echo('file:cannotload'));
    }

    // Check if there was no file uploaded
    if (empty($_FILES[$title]['name'])) {
        return elgg_error_response(elgg_echo('file:uploadfailed'));
    }

    // Create a new ElggFile object
    $file = new ElggFile();
    $file->subtype = "file";

    // If no title was provided, use the filename as the title
    if (empty($title)) {
        $title = htmlspecialchars($_FILES[$title]['name'], ENT_QUOTES, 'UTF-8');
    }
    $file->title = $title;

    // If a file was uploaded, process it
    if (isset($_FILES[$title]['name']) && !empty($_FILES[$title]['name'])) {
        $prefix = "file/";
        $filestorename = elgg_strtolower($_FILES[$title]['name']);
        $file->setFilename($prefix . $filestorename);
        $file->originalfilename = $_FILES[$title]['name'];
        $mime_type = $file->getMimeType($_FILES[$title]['tmp_name'], $_FILES[$title]['type']);

        // hack for Microsoft zipped formats
        $info = pathinfo($_FILES[$title]['name']);
        $office_formats = array('docx', 'xlsx', 'pptx');
        if ($mime_type == "application/zip" && in_array($info['extension'], $office_formats)) {
                switch ($info['extension']) {
                    case 'docx':
                            $mime_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                            break;
                    case 'xlsx':
                            $mime_type = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                            break;
                    case 'pptx':
                            $mime_type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
                            break;
                }
        }

        // check for bad ppt detection
        if ($mime_type == "application/vnd.ms-office" && $info['extension'] == "ppt") {
                $mime_type = "application/vnd.ms-powerpoint";
        }

        $file->setMimeType($mime_type);
        $file->simpletype = get_simple_type($mime_type);

        // Open the file to guarantee the directory exists
        $file->open("write");
        $file->close();
        move_uploaded_file($_FILES[$title]['tmp_name'], $file->getFilenameOnFilestore());

        $file->save();
        $fileGuid = $file->guid;

        //If the file is an image, we need to create thumbnails
        if ($file->simpletype == "image") {
                // Get the size of the uploaded image
                $filesize = getimagesize($_FILES[$title]['tmp_name']);

                // If the image size could not be determined, log an error
                if ($filesize === FALSE) {
                error_log("Unable to get image size data from " . $_FILES[$title]['tmp_name']);
                } else {
                        // Otherwise, create thumbnails of the image
                        $thumbnail = get_resized_image_from_existing_file($_FILES[$title]['tmp_name'], 60, 60, true);
                        $smallthumb = get_resized_image_from_existing_file($_FILES[$title]['tmp_name'], 153, 153, true);
                        $largethumb = get_resized_image_from_existing_file($_FILES[$title]['tmp_name'], 600, 600, false);

                        // If the thumbnails were created successfully, save them
                        if ($thumbnail) {
                                $file->thumbnail = $prefix . "thumb" . $filestorename;
                                $file->smallthumb = $prefix . "smallthumb" . $filestorename;
                                $file->largethumb = $prefix . "largethumb" . $filestorename;

                                // Open the file in write mode, write the thumbnail data to the file, and close the file
                                $thumb = new ElggFile();
                                $thumb->setFilename($file->thumbnail);
                                $thumb->open("write");
                                $thumb->write($thumbnail);
                                $thumb->close();

                                // Repeat the process for the small and large thumbnails
                                $thumb->setFilename($file->smallthumb);
                                $thumb->open("write");
                                $thumb->write($smallthumb);
                                $thumb->close();

                                $thumb->setFilename($file->largethumb);
                                $thumb->open("write");
                                $thumb->write($largethumb);
                                $thumb->close();
                        }
                }
        }

        // Save the file
        if (!$file->save()) {
                return elgg_error_response(elgg_echo('file:uploadfailed'));
        }

        // Return a success response
        return elgg_ok_response('', elgg_echo('file:saved'));
    }  
} 
?>
