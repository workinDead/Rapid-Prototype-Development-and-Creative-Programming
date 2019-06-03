<?php

// logout_ajax.php
ini_set("session.cookie_httponly", True); // The following line sets the HttpOnly flag for session cookies - make sure to call it before you call session_start()

session_start();

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
session_unset();

if (session_destroy()){
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 

    echo json_encode(array(
        "success" => true,
        "token" => $_SESSION['token'] 
    ));
    exit;
}else{
    echo json_encode(array(
        "success" => false
    ));
    exit;
}



?>