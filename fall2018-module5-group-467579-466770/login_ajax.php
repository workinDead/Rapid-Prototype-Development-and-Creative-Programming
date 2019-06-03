<?php
ini_set("session.cookie_httponly", True); // The following line sets the HttpOnly flag for session cookies - make sure to call it before you call session_start()

session_start();

// login_ajax.php

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

$stmt = $mysqli->prepare("select password from users where username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $username);

$stmt->execute();

$stmt->bind_result($password_hash);

$result = $stmt->get_result();

$num_of_rows = $result->num_rows;

/* If there are results from database push to result array */

if ($num_of_rows > 0) {
    while($row = $result->fetch_assoc()) {

		$password_hash = $row['password'];
		// validate password
		if(password_verify($password, $password_hash))
		{

			$_SESSION['username'] = $username;
			$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
			$login_status = true;

		}else{
			$login_status = false;
		}

    }

}

// get shared fullcalendar 
$stmt = $mysqli->prepare("select sender from sharefc where receiver = ?;");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $username);

if($stmt->execute()){
	$status = true;
}
else{
	$status = false;
}   


/* Get the result */
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
$result_array = array();


if ($num_of_rows > 0) {
    while($row = $result->fetch_assoc()) {

		array_push($result_array, $row);


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

/* send a JSON encded array to client */

echo json_encode(array(
	"login_status" => $login_status,
	"success" => $status,
	"username" => $username,
	"max_event_id" => $max_event_id,
	"sender" => $result_array,
	"token" =>$_SESSION['token']
));



$stmt->close();


?>
