<?php
// signup_ajax.php
ini_set("session.cookie_httponly", True); // The following line sets the HttpOnly flag for session cookies - make sure to call it before you call session_start()

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
//Prevent Reflected XSS attacks
$username = htmlentities($json_obj['username']);
$password = htmlentities($json_obj['password']);

//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)

$mysqli = new mysqli('localhost','hlan','lanhou199681','icalendar');
if($mysqli->connect_errno){
    printf("Conncetion Failed:%s\n",$mysqli->connect_error);
    exit;
}


$stmt = $mysqli->prepare("insert into users (username, password) values (?,?);");
if(!stmt){
printf("Query Prep Failed: %s\n",$mysqli->error);
exit;}

$password_hash = password_hash($password, PASSWORD_BCRYPT);
$stmt->bind_param('ss',$username,$password_hash);


if($stmt->execute()){
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 

    echo json_encode(array(
        "success" => true,
        "token" => $_SESSION['token']

    ));
    exit;
}else{
    echo json_encode(array(
        "success" => false,
        "message" => "Incorrect Username or Password"
    ));
    exit;
}


$stmt->close();


?>
