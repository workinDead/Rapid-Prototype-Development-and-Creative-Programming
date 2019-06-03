<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login on Fox</title>
    <link type="text/css" rel="stylesheet" href="personalpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>
<header>
    <nav>
        <ul>
            <li>
                <a href="mainpage.php">
                    <span class="material-icons nav-icons">home</span>
                    <span class="text">
                            Home
                    </span>
                </a>
            </li>
            <?php

                session_start();
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

                if($_SESSION['login_status']==1){
                $username = $_SESSION['username'];
            ?>
             <li>
                <a href = "notification.php">
                        <span class="material-icons nav-icons">
                        notifications
                        </span>
                    <span class="text">
                            Notification
                        </span>
                    </a>
            </li>
            <li style="float:right;">
                <a href="logout.php">
                    <span class="text">
                        Log out
                    </span>
                </a>
            </li>
            <li style="float:right;">
                <a href = "personalpage.php">
                    <span class="text">
                        <?php echo $username;?>
                    </span>
                </a>
            </li>

            <?php
                }
                else{
                ?>
            <li style="float:right;">
                <div>
                <a href="signup.html">Sign up </a>
                </div>
            </li>
            <li style="float:right;">
                <div>
                <a href="login.html"  class="active">Log in</a>
                </div>
            </li>
            <?php
                }
            ?>
        </ul>
    </nav>
</header>
    <div class="container">
        <div class="wrapper">
<?php
$mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
if($mysqli->connect_errno){
    printf("Conncetion Failed:%s\n",$mysqli->connect_error);
    exit;
}

$username = $_GET['username'];
$password = $_GET['password'];

$stmt = $mysqli->prepare("select count(*), username, password, img_url from users where username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $username);

$stmt->execute();
$stmt->bind_result($cnt, $username_init, $password_hash, $img_url);

while($stmt->fetch()){
    if ($cnt == 1 && password_verify($password, $password_hash)){
        //echo $img_url;
        //echo $username_init;

        $_SESSION['username']= $username_init;
        $_SESSION['login_status']= 1;


        //$finfo = new finfo(FILEINFO_MIME_TYPE);
        //$mime = $finfo->file($img_url);
        // Finally, set the Content-Type header to the MIME type of the file, and display the file.
        //header("Content-Type: ".$mime);

        $imageData = base64_encode(file_get_contents($img_url));

        // Format the image SRC:  data:{mime};base64,{data};
        $src = 'data: '.mime_content_type($img_url).';base64,'.$imageData;

        // Echo out a sample image
        //echo '<img src="'.$src.'">';
        //echo $src;
        $_SESSION['profile_img']=$src;
        header("Location: personalpage.php");

            }

    if(empty($username_init)){
    ?>
    <div class="story-box" style="text-align:center;">
    <span class="material-icons nav-icons" style="font-size:60px;color:red;">close</span>
    <h2>Please login again!</h2>
    </div>
    <?php

    }
    }
    $stmt->close();

    ?>
            </div>
        </div>
</body>
</html>