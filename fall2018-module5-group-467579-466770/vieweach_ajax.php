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

    $username = $_SESSION['username'];
    // $username = "workindead"; 
    // search from icalendar in events where user and edit which means it belongs to him or he is one of the group member
    $stmt = $mysqli->prepare("select owner,tag,editevent.event_id,title,date,time from events left outer join editevent on events.event_id = editevent.event_id  where editevent.event_id = ? group by editevent.event_id;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s',$id);

    // $stmt->execute();
    if($stmt->execute()){
        $status = true;
    }
    else{
        $status = false;
    }   
    /* Get the result */
    $result = $stmt->get_result();
    // $stmt->bind_result($title,$date,$time);

    /* Get the number of rows */
   $num_of_rows = $result->num_rows;
   $result_array = array();
   
    /* If there are results from database push to result array */

    if ($num_of_rows > 0) {
        while($row = $result->fetch_assoc()) {

            array_push($result_array, $row);

            if($row['owner']==$username){
                $isowner = true;
            }else{
                $isowner=false;
            }
        }

    }
    // get coworkers
    $stmt = $mysqli->prepare("select editor from editevent where event_id = ?;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $id);

    // $stmt->execute();
    if($stmt->execute()){

        $status = true;

    }
    else{

        $status = false;
    }   
    /* Get the result */
    $result = $stmt->get_result();
    $num_of_rows = $result->num_rows;
    $coworkers_array = array();
    
     /* If there are results from database push to result array */
 
     if ($num_of_rows > 0) {
         while($row = $result->fetch_assoc()) {

             array_push($coworkers_array, $row);
    
         }
 
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
    /* free results */
    // $stmt->free_result();
   
    /* send a JSON encded array to client */
    echo json_encode(
        array(
            "events"=> $result_array,
            "coworkers"=> $coworkers_array,
             "max_event_id"=>  $max_event_id,
             "success" => $status,
             "isowner" =>  $isowner,
             "username"=>$username,
             "owner"=>$result_array[0].owner,
             "token" => $_SESSION['token']

        ));

    /* close statement */
    $stmt->close();

?>