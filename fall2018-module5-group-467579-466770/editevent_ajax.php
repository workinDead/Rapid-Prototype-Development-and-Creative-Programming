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
    $id = htmlentities($json_obj['id']);

    $event = htmlentities($json_obj['event']);

    $date = htmlentities($json_obj['datepicker']);
    $date = date ("Y-m-d", strtotime($date)); // convert jquery datepicker to mysql datetime

    $time = htmlentities($json_obj['timepicker']);
    $time = str_replace(":","",$time); // mysql time dataformat int
    
    $tag = htmlentities($json_obj['tag']);

    $isowner = $json_obj['isowner'];

    $username = $_SESSION['username'];
    // $username = "workindead"; // mysql owner name cannot be default 
    // array_push($coworkers, $username); // don't forget yourself

    // when add event owner is always authorized with editor and viewer priority
    $stmt = $mysqli->prepare("update events set title = ?,date = ?,time=?,tag=? where event_id = ?;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('sssss',$event,$date,$time,$tag,$id);
    $stmt->execute();
    
    if($isowner){
        $coworkers = $json_obj['coworkers'];
       
        // update coworkers delete and add then
        $stmt = $mysqli->prepare("delete from editevent where event_id =?;");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s',$id);
            
        if($stmt->execute()){
            $status = true;
        }
        else{
            $status = false;
        }  
        array_push($coworkers,$username);
        foreach($coworkers as $coworker){
            $stmt = $mysqli->prepare("insert into editevent (editor,event_id) values (?,?);");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            
            $stmt->bind_param('ss',$coworker,$id);
            
            if($stmt->execute()){
                $status = true;
            }
            else{
                $status = false;
            }  
        }
    }
    
  


    // get max event
    $stmt = $mysqli->prepare("select max(event_id) as max_event_id from events");
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
    
    /* Get the result */
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        //Prevent Persistent XSS attacks
        $max_event_id =htmlentities($row['max_event_id']);

    }
    if($status){
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
    }
    /* free results */
    // $stmt->free_result();

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