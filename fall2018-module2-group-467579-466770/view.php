<?php
        session_start();
        // Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
        // include(basename($_REQUEST['file']));
        $filename = $_REQUEST['file'];
        //echo $filename;
        // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
        // To perform the check, we will use a regular expression.
        if(!preg_match('/^[\w_\.\-]+$/', $filename) ){
        	echo "Invalid filename";
        	exit;
        }
        $username = $_REQUEST['username'];
        $full_path = sprintf("/srv/uploads/%s/%s", $username, $filename);

        if(preg_match('/(.*)+\.(txt|pdf|png|jpg)$/i',$filename)){

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($full_path);
                // Finally, set the Content-Type header to the MIME type of the file, and display the file.
                header("Content-Type: ".$mime);
                readfile($full_path);
        }
        else{

                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$filename.'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($full_path));
                readfile($full_path);
        }


?>


