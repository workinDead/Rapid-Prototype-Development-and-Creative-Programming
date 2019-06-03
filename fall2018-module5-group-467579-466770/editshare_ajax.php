<?php
// editsharefc_ajax.php
ini_set("session.cookie_httponly", True); // The following line sets the HttpOnly flag for session cookies - make sure to call it before you call session_start()
session_start();
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$friends = $json_obj['friend'] ;
$username = $_SESSION['username'];
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)

$mysqli = new mysqli('localhost','hlan','lanhou199681','icalendar');
if($mysqli->connect_errno){
    printf("Conncetion Failed:%s\n",$mysqli->connect_error);
    exit;
}
// update friends delete and add then
$stmt = $mysqli->prepare("delete from sharefc where sender =?;");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s',$username);

$stmt->execute();
// if($stmt->execute()){
//     $status = true;
// }
// else{
//     $status = false;
// }
if(count($friends)>0){
    foreach($friends as $friend){
        $stmt = $mysqli->prepare("insert into sharefc (sender, receiver) values (?,?);");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        
        $stmt->bind_param('ss',$username,$friend);
        
        if($stmt->execute()){
            $status = true;
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 

        }
        else{
            $status = false;
        }  
    }
}

echo json_encode(array(
    "success" => $status,
    "message" => "Incorrect Friend Name",
    "friend_msg" => $friends,
    "token" => $_SESSION['token']

));
exit;



$stmt->close();


?>
