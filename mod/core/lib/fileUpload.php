<?php

function get_simple_type($mime_type) {
    
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

function uploadFile($title) {
    //elgg_make_sticky_form('file');

    // check if upload failed
    if (!empty($_FILES[$title]['name']) && $_FILES[$title]['error'] != 0) {
        return elgg_error_response(elgg_echo('file:cannotload'));
    }
    
    // must have a file if a new file upload
    if (empty($_FILES[$title]['name'])) {
        return elgg_error_response(elgg_echo('file:uploadfailed'));
    }

    $file = new ElggFile();
    $file->subtype = "file";

    // if no title on new upload, grab filename
    if (empty($title)) {
            $title = htmlspecialchars($_FILES[$title]['name'], ENT_QUOTES, 'UTF-8');
    }
    $file->title = $title;
    
    // we have a file upload, so process it
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

            // if image, we need to create thumbnails (this should be moved into a function)
            if ($guid && $file->simpletype == "image") {
                    $file->icontime = time();

                    $thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
                    if ($thumbnail) {
                            $thumb = new ElggFile();
                            $thumb->setMimeType($_FILES[$title]['type']);

                            $thumb->setFilename($prefix."thumb".$filestorename);
                            $thumb->open("write");
                            $thumb->write($thumbnail);
                            $thumb->close();

                            $file->thumbnail = $prefix."thumb".$filestorename;
                            unset($thumbnail);
                    }

                    $thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
                    if ($thumbsmall) {
                            $thumb->setFilename($prefix."smallthumb".$filestorename);
                            $thumb->open("write");
                            $thumb->write($thumbsmall);
                            $thumb->close();
                            $file->smallthumb = $prefix."smallthumb".$filestorename;
                            unset($thumbsmall);
                    }

                    $thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
                    if ($thumblarge) {
                            $thumb->setFilename($prefix."largethumb".$filestorename);
                            $thumb->open("write");
                            $thumb->write($thumblarge);
                            $thumb->close();
                            $file->largethumb = $prefix."largethumb".$filestorename;
                            unset($thumblarge);
                    }
            }
    } else {
            // not saving a file but still need to save the entity to push attributes to database
            $file->save();
    }

    // file saved so clear sticky form
    //elgg_clear_sticky_form('file');
    return $fileGuid;
}   
?>
