<?php
    ini_set("session.cookie_httponly", True); // The following line sets the HttpOnly flag for session cookies - make sure to call it before you call session_start()
    session_start();

    header("Content-Type: application/json"); 
    // connect to database
    $mysqli = new mysqli('localhost','hlan','lanhou199681','icalendar');
    if($mysqli->connect_errno){
        printf("Conncetion Failed:%s\n",$mysqli->connect_error);
        exit;
    }
    //Because you are posting the data via fetch(), php has to retrieve it elsewhere.
    $json_str = file_get_contents('php://input');
    //This will store the data into an associative array
    $json_obj = json_decode($json_str, true);
    //Variables can be accessed as such:
    //Prevent Reflected XSS attacks
    $event_id = htmlentities($json_obj['id']);

    $username = $_SESSION['username'];
    
    // when delete, first delete editevent then events
    $stmt = $mysqli->prepare("delete from editevent where event_id = '$event_id'");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    if($stmt->execute()){
        $status = true;
    }
    else{
        $status = false;
    }   

    $stmt = $mysqli->prepare("delete from events where event_id = '$event_id'");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    if($stmt->execute()){
        $status = true;
    }
    else{
        $status = false;
    }   


    // get max event
    $stmt = $mysqli->prepare("select max(event_id) as max_event_id from events");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    /* Get the result */
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        //Prevent Persistent XSS attacks
        $max_event_id =htmlentities($row['max_event_id']);
    }
    if($status){
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
    }
    /* send a JSON encded array to client */
    echo json_encode(
        array(
            "max_event_id"=>  $max_event_id,
            "success" => $status,
            "token" => $_SESSION['token']

        ));

    /* close statement */
    $stmt->close();


?>