<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Upload on Fox</title>
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
                    <a href="login.html">Log in</a>
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
    <div class="story-box" style="text-align:center">
<h2 style="text-align:center">Choose a file to upload</h2>
<form  enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <p>
        <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
        <input name="uploadedfile" type="file" id="uploadfile_input" />
    </p>
    <p>
        <input type="submit" name="submit" value="Upload File" />
    </p>
</form>

<div style="text-align:center">
    <span class = "uploadfb">
    <?php
     $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
            if($mysqli->connect_errno){
            printf("Conncetion Failed:%s\n",$mysqli->connect_error);
            exit;
            }

    if (isset($_POST['submit'])==1){
    $filename = basename($_FILES['uploadedfile']['name']);
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);

    // Get the username and make sure it is valid
    if( !preg_match('/^[\w_\-]+$/', $username) ){
    	echo "Invalid username";
    	exit;
    }
    //upload file
    //filtering input

    $user_folder = sprintf("/srv/uploads/fox");
    if (!file_exists($user_folder)) {
        mkdir($user_folder, 0777, true);
    }
    $full_path = sprintf("/srv/uploads/fox/%s.%s",$username,$filetype);
    //echo $full_path;

    if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
        //echo "<p style=\"color:green\">"
        echo "Congradulations!";
        echo $username;
        echo $full_path;
        //echo "<\p>";
               $stmt = $mysqli->prepare("update users set img_url = ? where username = ?;");
               if(!$stmt){
                   printf("Query Prep Failed: %s\n", $mysqli->error);
               	exit;
               }

               $stmt->bind_param('ss', $full_path, $username);

               $stmt->execute();

                //$finfo = new finfo(FILEINFO_MIME_TYPE);
                //$mime = $finfo->file($img_url);
                // Finally, set the Content-Type header to the MIME type of the file, and display the file.
                //header("Content-Type: ".$mime);

                $imageData = base64_encode(file_get_contents($full_path));

                // Format the image SRC:  data:{mime};base64,{data};
                $src = 'data: '.mime_content_type($full_path).';base64,'.$imageData;

                // Echo out a sample image
                //echo '<img src="'.$src.'">';
                //echo $src;
                $_SESSION['profile_img']=$src;

               $stmt->close();

        exit;
    }
    else{
        echo "Oops!";
    	exit;
    }
    }
    ?>
    </span>
</div>
    </div>
</div>
</div>
</body>
</html>
